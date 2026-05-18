<?php

namespace BreakdanceA11yElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "BreakdanceA11yElements\\LeafletMaps",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class LeafletMaps extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return [];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Leaflet Maps';
    }

    static function className()
    {
        return 'bda11y-leaflet-map';
    }

    static function category()
    {
        return 'breakdance-a11y';
    }

    static function badge()
    {
        return false;
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function template()
    {
        return file_get_contents(__DIR__ . '/html.twig');
    }

    static function defaultCss()
    {
        return file_get_contents(__DIR__ . '/default.css');
    }

    static function defaultProperties()
    {
        return false;
    }

    static function defaultChildren()
    {
        return false;
    }

    static function cssTemplate()
    {
        $template = file_get_contents(__DIR__ . '/css.twig');
        return $template;
    }

    static function designControls()
    {
        return [c(
        "controls",
        "Controls",
        [c(
        "background_color",
        "Background Color",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "icon_color",
        "Icon Color",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "borders",
        "Borders",
        [c(
        "radius",
        "Radius",
        [],
        ['type' => 'border_radius', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "styling",
        "Styling",
        [],
        ['type' => 'border_complex', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "shadow",
        "Shadow",
        [],
        ['type' => 'shadow', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'layout' => 'inline', 'sectionOptions' => ['type' => 'popout']],
        false,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      ), c(
        "marker",
        "Marker",
        [c(
        "type",
        "Marker Type",
        [],
        ['type' => 'button_bar', 'layout' => 'inline', 'items' => [['text' => 'Icon', 'value' => 'icon'], ['text' => 'Image', 'value' => 'image']], 'buttonBarOptions' => ['size' => 'small', 'layout' => 'default']],
        false,
        false,
        [],
        
      ), c(
        "image",
        "Image",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'condition' => [[['path' => 'design.marker.type', 'operand' => 'equals', 'value' => 'image']]]],
        false,
        false,
        [],
        
      ), c(
        "icon",
        "Icon",
        [],
        ['type' => 'icon', 'layout' => 'vertical', 'condition' => [[['path' => 'design.marker.type', 'operand' => 'equals', 'value' => 'icon']]]],
        false,
        false,
        [],
        
      ), c(
        "color",
        "Color",
        [],
        ['type' => 'color', 'layout' => 'inline', 'condition' => [[['path' => 'design.marker.type', 'operand' => 'equals', 'value' => 'icon']]]],
        false,
        false,
        [],
        
      ), c(
        "size",
        "Size",
        [],
        ['type' => 'unit', 'layout' => 'inline'],
        false,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      ), c(
        "popup",
        "Popup",
        [c(
        "colors",
        "Colors",
        [c(
        "text",
        "Text",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "background",
        "Background",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "link",
        "Link",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "close_button",
        "Close-Button",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'layout' => 'inline', 'sectionOptions' => ['type' => 'popout']],
        false,
        false,
        [],
        
      ), getPresetSection(
      "EssentialElements\\typography_with_effects",
      "Typography",
      "typography",
       ['type' => 'popout']
     ), c(
        "borders",
        "Borders",
        [c(
        "radius",
        "Radius",
        [],
        ['type' => 'border_radius', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "styling",
        "Styling",
        [],
        ['type' => 'border_complex', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "shadow",
        "Shadow",
        [],
        ['type' => 'shadow', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'layout' => 'inline', 'sectionOptions' => ['type' => 'popout']],
        false,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      ), c(
        "size",
        "Size",
        [c(
        "height",
        "Height",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'unitOptions' => ['types' => ['px', 'rem', 'vw', 'vh', 'custom'], 'defaultType' => 'rem']],
        true,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      ), c(
        "spacing",
        "Spacing",
        [c(
        "padding",
        "Padding",
        [],
        ['type' => 'spacing_complex', 'layout' => 'vertical'],
        true,
        false,
        [],
        
      ), c(
        "margin_top",
        "Margin Top",
        [],
        ['type' => 'unit', 'layout' => 'inline'],
        true,
        false,
        [],
        
      ), c(
        "margin_bottom",
        "Margin Bottom",
        [],
        ['type' => 'unit', 'layout' => 'inline'],
        true,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      ), c(
        "borders",
        "Borders",
        [c(
        "radius",
        "Radius",
        [],
        ['type' => 'border_radius', 'layout' => 'inline'],
        true,
        false,
        [],
        
      ), c(
        "styling",
        "Styling",
        [],
        ['type' => 'border_complex', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "shadow",
        "Shadow",
        [],
        ['type' => 'shadow', 'layout' => 'vertical'],
        true,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      )];
    }

    static function contentControls()
    {
        return [c(
        "places",
        "Places",
        [c(
        "locations",
        "Locations",
        [c(
        "name",
        "Name",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "latitude",
        "Latitude",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "longitude",
        "Longitude",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "description",
        "Description",
        [],
        ['type' => 'richtext', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "directions",
        "Directions",
        [],
        ['type' => 'link', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "center_item",
        "Center this item",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => [[['path' => 'content.places.view_mode', 'operand' => 'not equals', 'value' => 'single']]]],
        false,
        false,
        [],
        
      )],
        ['type' => 'repeater', 'layout' => 'vertical', 'repeaterOptions' => ['titleTemplate' => '{name}', 'defaultTitle' => '', 'buttonName' => '']],
        false,
        false,
        [],
        
      ), c(
        "provider",
        "Provider",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'items' => [['value' => 'OpenStreetMap.Mapnik', 'text' => 'OpenStreetMap'], ['text' => 'CartoDB', 'value' => 'CartoDB.Voyager'], ['text' => 'CartoDB Light', 'value' => 'CartoDB.Positron'], ['text' => 'CartoDB Dark', 'value' => 'CartoDB.DarkMatter'], ['text' => 'OpenTopoMap', 'value' => 'OpenTopoMap'], ['text' => 'Esri WorldStreetMap', 'value' => 'Esri.WorldStreetMap'], ['text' => 'Esri WordlTopoMap', 'value' => 'Esri.WorldTopoMap'], ['text' => 'Esri WorldImagery', 'value' => 'Esri.WorldImagery'], ['text' => 'TopPlusOpen Color', 'value' => 'TopPlusOpen.Color'], ['text' => 'TopPlusOpen Grey', 'value' => 'TopPlusOpen.Grey'], ['text' => 'MTB Map', 'value' => 'MtbMap']]],
        false,
        false,
        [],
        
      ), c(
        "view_mode",
        "View Mode",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'items' => [['value' => 'single', 'text' => 'Single'], ['text' => 'Nearby', 'value' => 'nearby'], ['text' => 'Fitbounds', 'value' => 'fitbounds']]],
        false,
        false,
        [],
        
      ), c(
        "clustering",
        "Location Clustering",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => [[['path' => 'content.places.view_mode', 'operand' => 'equals', 'value' => 'fitbounds']]]],
        false,
        false,
        [],
        
      ), c(
        "zoom",
        "Zoom",
        [],
        ['type' => 'number', 'layout' => 'vertical', 'condition' => [[['path' => 'content.places.view_mode', 'operand' => 'not equals', 'value' => 'fitbounds']]]],
        false,
        false,
        [],
        
      ), c(
        "full_screen_toggle",
        "Full Screen Toggle",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )];
    }

    static function settingsControls()
    {
        return [];
    }

    static function dependencies()
    {
        return ['0' =>  ['title' => 'Leaflet','scripts' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_JS%%'],'styles' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_CSS%%'],],'1' =>  ['title' => 'Leaflet Providers','scripts' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_PROVIDERS%%'],],'2' =>  ['title' => 'Leaflet Fullscreen','scripts' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_FULLSCREEN_JS%%'],'styles' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_FULLSCREEN_CSS%%'],],'3' =>  ['title' => 'Leaflet MarkerClusters','scripts' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_CLUSTER_JS%%'],'styles' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_CLUSTER_CSS%%','%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_CLUSTER_DEFAULT_CSS%%'],],'4' =>  ['title' => 'Leaflet Map Init','scripts' => ['%%BREAKDANCE_REUSABLE_BDA11Y_LEAFLET_INIT%%'],],'5' =>  ['title' => 'Leaflet Map Init Call','inlineScripts' => ['
(function() {
  const el = document.querySelector(\'%%SELECTOR%% .leaflet-map\');
  if (!el || !window.BDA11Y || typeof window.BDA11Y.initLeafletMap !== \'function\') return;

  window.BDA11Y.initLeafletMap(el, {
    zoom: parseInt(\'{{ content.places.zoom|default(13) }}\', 10),
    providerKey: \'{{ content.places.provider|default("OpenStreetMap.Mapnik") }}\',
    locations: {{ content.places.locations|default([])|json_encode|raw }},
    viewMode: \'{{ content.places.view_mode|default("fitbounds") }}\',
    useClustering: {{ content.places.clustering ? \'true\' : \'false\' }},
    isFullscreen: {{ content.places.full_screen_toggle ? \'true\' : \'false\' }},
    marker: {
      type: \'{{ design.marker.type|default("icon") }}\',
      image: \'{{ design.marker.image.url|default("") }}\',
      icon: \'{{ design.marker.icon.slug|default("") }}\',
    }
  });
})();
'],],];
    }

    static function settings()
    {
        return false;
    }

    static function addPanelRules()
    {
        return false;
    }

    static public function actions()
    {
        return [

'onPropertyChange' => [['script' => 'const el = document.querySelector(\'%%SELECTOR%% .leaflet-map\');

if (!el || typeof L === \'undefined\') {
  console.warn(\'Leaflet / Map Element nicht verfügbar (on property change)\');
} else {

  // Vorherige Instanz sauber zerstören
  if (el._leaflet_map_instance) {
    el._leaflet_map_instance.off();
    el._leaflet_map_instance.remove();
    el._leaflet_map_instance = null;
  }
  if (el._leaflet_id) {
    delete el._leaflet_id;
  }

  // Neue Settings aus Twig holen
  const settings = {
    zoom: parseInt(\'{{ content.places.zoom|default(13) }}\', 10),
    providerKey: \'{{ content.places.provider|default("OpenStreetMap.Mapnik") }}\',
    locations: {{ content.places.locations|default([])|json_encode|raw }},
    viewMode: \'{{ content.places.view_mode|default("fitbounds") }}\',
    useClustering: {{ content.places.clustering ? \'true\' : \'false\' }},
    isFullscreen: {{ content.places.full_screen_toggle ? \'true\' : \'false\' }},
    marker: {
      type: \'{{ design.marker.type|default("icon") }}\',
      image: \'{{ design.marker.image.url|default("") }}\',
      icon: \'{{ design.marker.icon.slug|default("") }}\',
    }
  };

  // Zentralen Init‑Code aus dem Plugin wiederverwenden
  if (window.BDA11Y && typeof window.BDA11Y.initLeafletMap === \'function\') {
    window.BDA11Y.initLeafletMap(el, settings);
  }
}',
],],

'onMovedElement' => [['script' => 'const el = document.querySelector(\'%%SELECTOR%% .leaflet-map\');

if (!el || typeof L === \'undefined\') {
  console.warn(\'Leaflet / Map Element nicht verfügbar (on property change)\');
} else {

  // Vorherige Instanz sauber zerstören
  if (el._leaflet_map_instance) {
    el._leaflet_map_instance.off();
    el._leaflet_map_instance.remove();
    el._leaflet_map_instance = null;
  }
  if (el._leaflet_id) {
    delete el._leaflet_id;
  }

  // Neue Settings aus Twig holen
  const settings = {
    zoom: parseInt(\'{{ content.places.zoom|default(13) }}\', 10),
    providerKey: \'{{ content.places.provider|default("OpenStreetMap.Mapnik") }}\',
    locations: {{ content.places.locations|default([])|json_encode|raw }},
    viewMode: \'{{ content.places.view_mode|default("fitbounds") }}\',
    useClustering: {{ content.places.clustering ? \'true\' : \'false\' }},
    isFullscreen: {{ content.places.full_screen_toggle ? \'true\' : \'false\' }},
    marker: {
      type: \'{{ design.marker.type|default("icon") }}\',
      image: \'{{ design.marker.image.url|default("") }}\',
      icon: \'{{ design.marker.icon.slug|default("") }}\',
    }
  };

  // Zentralen Init‑Code aus dem Plugin wiederverwenden
  if (window.BDA11Y && typeof window.BDA11Y.initLeafletMap === \'function\') {
    window.BDA11Y.initLeafletMap(el, settings);
  }
}',
],],];
    }

    static function nestingRule()
    {
        return ['type' => 'final'];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return false;
    }

    static function experimental()
    {
        return false;
    }

    static function availableIn()
    {
        return ['breakdance'];
    }


    static function order()
    {
        return 0;
    }

    static function dynamicPropertyPaths()
    {
        return false;
    }

    static function additionalClasses()
    {
        return false;
    }

    static function projectManagement()
    {
        return false;
    }

    static function propertyPathsToWhitelistInFlatProps()
    {
        return false;
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return false;
    }
}
