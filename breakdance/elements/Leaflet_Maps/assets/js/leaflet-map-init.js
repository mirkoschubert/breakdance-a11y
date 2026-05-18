// window-Namespace vorbereiten
window.BDA11Y = window.BDA11Y || {}

window.BDA11Y.initLeafletMap = function (el, settings) {
  if (!el || typeof L === 'undefined') {
    console.warn('Leaflet oder .leaflet-map nicht verfügbar')
    return
  }
  if (el._leaflet_map_instance) return

  const {
    zoom,
    providerKey,
    locations,
    viewMode,
    useClustering,
    isFullscreen,
    marker: markerSettings = {},
  } = settings

  console.log(markerSettings)

  const markers = []
  let centerLoc = null

  const map = L.map(el, {
    scrollWheelZoom: false,
    zoomControl: false,
  })
  el._leaflet_map_instance = map

  map.on('focus', () => map.scrollWheelZoom.enable())
  map.on('blur', () => map.scrollWheelZoom.disable())

  // Marker Icon
  function createMarkerIcon() {
    const type = (markerSettings.type || 'icon').toLowerCase()

    // Basisgröße, visuelle Größe machst du per CSS
    const sizePx = 32
    const iconSize = [sizePx, sizePx]

    // IMAGE: klassisches Leaflet-Icon
    if (type === 'image' && markerSettings.image) {
      return L.icon({
        iconUrl: markerSettings.image,
        iconSize,
        iconAnchor: [sizePx / 2, sizePx],
        popupAnchor: [0, -sizePx / 2],
      })
    }

    // ICON: SVG aus Template kopieren
    const wrapper = el.parentElement
    if (!wrapper) return null

    const originalIcon = wrapper.querySelector('.marker-icon')
    if (!originalIcon) return null

    const svgHtml = originalIcon.innerHTML.trim()
    if (!svgHtml) return null

    // Leaflet gibt selbst die Klassen leaflet-marker-icon / leaflet-zoom-animated / leaflet-interactive
    // an das <img> bzw. das divIcon-Container-Element, da müssen wir nichts doppelt setzen.
    // Hier sorgen wir nur für ARIA + Tabindex am interaktiven Element.
    const html = `${svgHtml}`

    // Original-Icon aus dem DOM entfernen, damit es nicht sichtbar bleibt
    //originalIcon.remove()

    return L.divIcon({
      html,
      className:
        'leaflet-marker-icon leaflet-zoom-animated leaflet-interactive',
      iconSize,
      iconAnchor: [sizePx / 2, sizePx / 2],
      popupAnchor: [0, -sizePx / 2],
    })
  }

  const markerIcon = createMarkerIcon()

  // --- Fullscreen-Control ---
  const fullscreenEnterIcon = `
    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 24 24"
         width="18" height="18"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
      <path d="M8 3H5a2 2 0 0 0-2 2v3" />
      <path d="M21 8V5a2 2 0 0 0-2-2h-3" />
      <path d="M3 16v3a2 2 0 0 0 2 2h3" />
      <path d="M16 21h3a2 2 0 0 0 2-2v-3" />
    </svg>
  `

  const fullscreenExitIcon = `
    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 24 24"
         width="18" height="18"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
      <path d="M8 3v3a2 2 0 0 1-2 2H3" />
      <path d="M21 8h-3a2 2 0 0 1-2-2V3" />
      <path d="M3 16h3a2 2 0 0 1 2 2v3" />
      <path d="M16 21v-3a2 2 0 0 1 2-2h3" />
    </svg>
  `

  if (isFullscreen && L.Control) {
    const FullscreenControl = L.Control.extend({
      options: { position: 'topright' },

      onAdd(mapInstance) {
        const container = L.DomUtil.create(
          'div',
          'leaflet-bar leaflet-control leaflet-control-fullscreen',
        )

        const link = L.DomUtil.create(
          'a',
          'leaflet-control-fullscreen-button leaflet-bar-part',
          container,
        )
        link.href = '#'
        link.title = 'View Fullscreen'
        link.innerHTML = fullscreenEnterIcon

        const toggleFullscreen = () => {
          const containerEl = mapInstance.getContainer()
          if (!document.fullscreenElement) {
            if (containerEl.requestFullscreen) containerEl.requestFullscreen()
          } else if (document.exitFullscreen) {
            document.exitFullscreen()
          }
        }

        L.DomEvent.on(link, 'click', (e) => {
          L.DomEvent.stopPropagation(e)
          L.DomEvent.preventDefault(e)
          toggleFullscreen()
        })

        document.addEventListener('fullscreenchange', () => {
          const isOn = !!document.fullscreenElement
          link.innerHTML = isOn ? fullscreenExitIcon : fullscreenEnterIcon
          link.title = isOn ? 'Leave Fullscreen' : 'View Fullscreen'
          setTimeout(() => mapInstance.invalidateSize(), 100)
        })

        return container
      },
    })

    map.addControl(new FullscreenControl())
  }

  // --- Custom Zoom-Control ---
  const CustomZoomControl = L.Control.extend({
    options: { position: 'topleft' },

    onAdd(mapInstance) {
      const container = L.DomUtil.create(
        'div',
        'leaflet-control-zoom leaflet-bar leaflet-control',
      )

      const zoomIn = L.DomUtil.create('a', 'leaflet-control-zoom-in', container)
      zoomIn.href = '#'
      zoomIn.title = 'Zoom in'
      zoomIn.setAttribute('role', 'button')
      zoomIn.setAttribute('aria-label', 'Zoom in')
      zoomIn.setAttribute('aria-disabled', 'false')
      zoomIn.innerHTML = `
        <span aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg"
               viewBox="0 0 24 24"
               width="18" height="18"
               fill="none"
               stroke="currentColor"
               stroke-width="2"
               stroke-linecap="round"
               stroke-linejoin="round">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
          </svg>
        </span>
      `
      L.DomEvent.on(zoomIn, 'click', (e) => {
        L.DomEvent.stopPropagation(e)
        L.DomEvent.preventDefault(e)
        mapInstance.zoomIn()
      })

      const zoomOut = L.DomUtil.create(
        'a',
        'leaflet-control-zoom-out',
        container,
      )
      zoomOut.href = '#'
      zoomOut.title = 'Zoom out'
      zoomOut.setAttribute('role', 'button')
      zoomOut.setAttribute('aria-label', 'Zoom out')
      zoomOut.setAttribute('aria-disabled', 'false')
      zoomOut.innerHTML = `
        <span aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg"
               viewBox="0 0 24 24"
               width="18" height="18"
               fill="none"
               stroke="currentColor"
               stroke-width="2"
               stroke-linecap="round"
               stroke-linejoin="round">
            <path d="M5 12h14" />
          </svg>
        </span>
      `
      L.DomEvent.on(zoomOut, 'click', (e) => {
        L.DomEvent.stopPropagation(e)
        L.DomEvent.preventDefault(e)
        mapInstance.zoomOut()
      })

      return container
    },
  })

  map.addControl(new CustomZoomControl())

  // --- Tiles ---
  if (L.tileLayer && L.tileLayer.provider) {
    L.tileLayer.provider(providerKey).addTo(map)
  } else {
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap-Mitwirkende',
    }).addTo(map)
  }

  // --- Marker + Popups ---
  locations.forEach((loc) => {
    const lat = parseFloat(loc.latitude)
    const lng = parseFloat(loc.longitude)
    if (Number.isNaN(lat) || Number.isNaN(lng)) return

    const markerOptions = {}
    if (markerIcon) {
      markerOptions.icon = markerIcon
    }

    const marker = L.marker([lat, lng], markerOptions)

    let popupHtml = ''
    if (loc.name) popupHtml += '<strong>' + loc.name + '</strong><br>'
    if (loc.description) popupHtml += loc.description + '<br>'
    if (loc.directions && loc.directions.url) {
      popupHtml += `<a href="${loc.directions.url}" target="_blank" rel="noopener">Route planen</a>`
    }
    if (popupHtml) marker.bindPopup(popupHtml)

    markers.push(marker)
    if (loc.center_item) centerLoc = { lat, lng }
  })

  if (!markers.length) {
    map.setView([51.4545, 7.0116], zoom)
    return
  }

  let layerGroup
  if (
    viewMode === 'fitbounds' &&
    useClustering &&
    typeof L.markerClusterGroup === 'function'
  ) {
    layerGroup = L.markerClusterGroup()
    markers.forEach((m) => layerGroup.addLayer(m))
    map.addLayer(layerGroup)
  } else {
    layerGroup = L.featureGroup(markers).addTo(map)
  }

  if ((viewMode === 'single' || viewMode === 'nearby') && centerLoc) {
    map.setView([centerLoc.lat, centerLoc.lng], zoom)
  } else {
    const bounds = layerGroup.getBounds()
    map.fitBounds(bounds, {
      paddingTopLeft: [30, 30],
      paddingBottomRight: [30, 30],
    })
  }
}
