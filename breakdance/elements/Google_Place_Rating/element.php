<?php

namespace BreakdanceA11yElement;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "BreakdanceA11yElement\\GooglePlaceRating",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class GooglePlaceRating extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'StarIcon';
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
        return 'Google Place Rating';
    }

    static function className()
    {
        return 'bda11y-google-rating';
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
        return ['content' => ['components' => ['place_id' => '', 'show_rating_number' => true, 'show_review_count' => false, 'link_mode' => 'google_maps', 'icon_type' => 'fontawesome', 'show_label' => false, 'label_text' => 'Google Bewertung', 'unmarked_style' => null]], 'design' => ['stars' => ['unmarked_color' => null], 'google_logo' => ['logo_size' => null, 'logo_gap' => null, 'custom_logo' => null]]];
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
        "logo",
        "Logo",
        [c(
        "size",
        "Size",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'rangeOptions' => ['min' => 12, 'max' => 128, 'step' => 1], 'unitOptions' => ['types' => ['px', 'em', 'rem'], 'defaultType' => 'px']],
        true,
        false,
        [],
        
      ), c(
        "gap",
        "Gap to Stars",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'rangeOptions' => ['min' => 0, 'max' => 64, 'step' => 1], 'unitOptions' => ['types' => ['px', 'em', 'rem'], 'defaultType' => 'px']],
        true,
        false,
        [],
        
      ), c(
        "custom_logo",
        "Custom Logo",
        [c(
        "color",
        "Color",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "logo",
        "Logo",
        [],
        ['type' => 'icon', 'layout' => 'vertical'],
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
        "stars",
        "Stars",
        [c(
        "size",
        "Size",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'rangeOptions' => ['min' => 12, 'max' => 256, 'step' => 1], 'unitOptions' => ['types' => ['px', 'em', 'rem'], 'defaultType' => 'px']],
        true,
        false,
        [],
        
      ), c(
        "gap",
        "Gap",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'rangeOptions' => ['min' => 0, 'max' => 50, 'step' => 1], 'unitOptions' => ['types' => ['px', 'em', 'rem'], 'defaultType' => 'px']],
        true,
        false,
        [],
        
      ), c(
        "stars_color",
        "Stars Color",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "unmarked_color",
        "Unmarked Color",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      ), c(
        "typography",
        "Typography",
        [getPresetSection(
      "EssentialElements\\typography_with_effects",
      "Rating",
      "rating",
       ['type' => 'popout']
     ), getPresetSection(
      "EssentialElements\\typography_with_effects",
      "Count",
      "count",
       ['type' => 'popout']
     )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      ), c(
        "spacing",
        "Spacing",
        [getPresetSection(
      "EssentialElements\\spacing_margin_y",
      "Wrapper",
      "wrapper",
       ['type' => 'popout']
     ), c(
        "label_spacing",
        "Label Spacing",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'unitOptions' => ['types' => ['px', 'em', 'rem', 'custom'], 'defaultType' => 'px'], 'rangeOptions' => ['min' => 0, 'max' => 100, 'step' => 1]],
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
        "components",
        "Components",
        [c(
        "place_id",
        "Place ID",
        [],
        ['type' => 'text', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "show_rating",
        "Show Rating",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "show_count",
        "Show Count",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "link_mode",
        "Link",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['value' => 'none', 'text' => 'Kein Link'], ['value' => 'google_maps', 'text' => 'Google Maps']]],
        false,
        false,
        [],
        
      ), c(
        "icon_type",
        "Icon Type",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['text' => 'Font Awesome', 'label' => 'Label', 'value' => 'fontawesome'], ['text' => 'Icon Moon', 'value' => 'iconmoon'], ['text' => 'Custom', 'value' => 'custom']]],
        false,
        false,
        [],
        
      ), c(
        "custom_icon",
        "Custom Icon",
        [],
        ['type' => 'icon', 'layout' => 'vertical', 'condition' => ['path' => 'content.components.icon_type', 'operand' => 'equals', 'value' => 'custom']],
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
        return ['0' =>  ['title' => 'Google Place Rating','inlineScripts' => ['(() => {
  const endpoint = \'/wp-json/bda11y/v1/place-rating\';

  // Deduplicates fetch calls for identical place IDs on the same page.
  const cache = new Map();

  const fetchRating = (placeId) => {
    if (!cache.has(placeId)) {
      console.log(\'[bda11y] Fetching rating for place_id:\', placeId);
      cache.set(
        placeId,
        fetch(endpoint + \'?place_id=\' + encodeURIComponent(placeId), { credentials: \'same-origin\' })
          .then((res) => {
            if (!res.ok) throw new Error(\'HTTP \' + res.status);
            return res.json();
          })
      );
    } else {
      console.log(\'[bda11y] Using cached promise for place_id:\', placeId);
    }
    return cache.get(placeId);
  };

  const formatRating = (v) =>
    new Intl.NumberFormat(\'de-DE\', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(v);

  const formatCount = (v) =>
    new Intl.NumberFormat(\'de-DE\').format(v);

  /**
   * Animates the filled star layer by changing clip-path.
   * Two nested rAF calls ensure the browser has painted the starting state
   * (inset 100% from CSS) before the target value is applied, so the
   * CSS transition always fires — even when the element is already visible.
   */
  const revealStars = (el, fillPercent) => {
    const filledLayer = el.querySelector(\'.bda11y-google-rating__stars-filled\');
    if (!filledLayer) {
      console.warn(\'[bda11y] No filled layer found\');
      return;
    }
    const rightInset = (100 - fillPercent).toFixed(4);
    console.log(\'[bda11y] Animating: fill\', fillPercent + \'%\', \'| right-inset\', rightInset + \'%\');

    // Double rAF: first frame paints the initial clip value from CSS,
    // second frame applies the target value and the transition plays.
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        filledLayer.style.clipPath = `inset(0 ${rightInset}% 0 0)`;
      });
    });
  };

  const hydrate = async (el, observer) => {
    const placeId = el.dataset.placeId;
    if (!placeId) {
      console.warn(\'[bda11y] Element found but data-place-id is empty:\', el);
      return;
    }

    const showNumber = el.dataset.showNumber === \'1\';
    const showCount  = el.dataset.showCount === \'1\';
    const linkMode   = el.tagName === \'A\' ? \'google_maps\' : \'none\';

    console.log(\'[bda11y] Hydrating, place_id:\', placeId);

    try {
      const data = await fetchRating(placeId);
      console.log(\'[bda11y] API response for\', placeId, \':\', data);

      const valueEl = el.querySelector(\'.bda11y-google-rating__value\');
      const countEl = el.querySelector(\'.bda11y-google-rating__count\');

      if (showNumber && valueEl) {
        valueEl.textContent = formatRating(data.rating);
      }

      if (showCount && countEl) {
        countEl.textContent = `(${formatCount(data.user_rating_count)})`;
      }


      // The <a> tag is already rendered by Twig when link_mode === google_maps.
      // Just set the href from the API response.
      const target = el;
      if (linkMode === \'google_maps\' && data.google_maps_uri && el.tagName === \'A\') {
        el.href = data.google_maps_uri;
        console.log(\'[bda11y] Link href set to:\', data.google_maps_uri);
      }

      const store = target.closest(\'.bda11y-google-rating\') || target;
      store.dataset.gprFillPercent = data.stars_percent;
      store.dataset.gprRating = data.rating;
      store.dataset.gprCount = data.user_rating_count;
      store.dataset.gprReady = \'1\';
      target.dataset.gprFillPercent = data.stars_percent;
      target.dataset.gprReady = \'1\';

      if (target.dataset.gprVisible === \'1\') {
        // Observer already fired while fetch was in flight — animate immediately.
        revealStars(target, data.stars_percent);
      } else {
        // Element not yet visible — (re-)register the observer on the final element
        // so it fires when the user scrolls to it.
        observer.observe(target);
        console.log(\'[bda11y] Observing final element for scroll trigger, place_id:\', placeId);
      }

      console.log(\'[bda11y] Hydration complete for place_id:\', placeId);
    } catch (err) {
      console.error(\'[bda11y] Hydration failed for place_id:\', placeId, err);
      el.dataset.gprError = \'1\';
    }
  };

  const boot = () => {
    const elements = document.querySelectorAll(\'.bda11y-google-rating__inner[data-place-id]\');
    console.log(\'[bda11y] Boot: found\', elements.length, \'Google Place Rating element(s)\');

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        observer.unobserve(el);
        el.dataset.gprVisible = \'1\';
        console.log(\'[bda11y] Element visible, place_id:\', el.dataset.placeId, \'| ready:\', el.dataset.gprReady);

        // hydrate() already ran and left gprReady + gprFillPercent on the element.
        if (el.dataset.gprReady === \'1\') {
          revealStars(el, parseFloat(el.dataset.gprFillPercent));
        }
        // If gprReady is not set: observer was re-registered by hydrate() on the
        // original el before replaceWith — this should not happen in normal flow.
      });
    }, { threshold: 0.1 });

    elements.forEach((el) => {
      // Initial observe on the original element — only to detect early visibility.
      // After fetch resolves, hydrate() re-registers on the final (possibly replaced) element.
      observer.observe(el);
      hydrate(el, observer);
    });
  };

  if (document.readyState === \'loading\') {
    document.addEventListener(\'DOMContentLoaded\', boot);
  } else {
    boot();
  }
})();'],],];
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
'onPropertyChange' => [['script' => '
(function() {
  const inner = document.querySelector(\'%%SELECTOR%% .bda11y-google-rating__inner\');
  if (!inner) return;
  const store = inner.closest(\'.bda11y-google-rating\') || inner;
  if (store.dataset.gprReady !== \'1\') return;

  const showRating = {{ content.components.show_rating ? \'true\' : \'false\' }};
  const showCount  = {{ content.components.show_count  ? \'true\' : \'false\' }};

  const valueEl = inner.querySelector(\'.bda11y-google-rating__value\');
  const countEl = inner.querySelector(\'.bda11y-google-rating__count\');

  const formatRating = function(v) {
    return new Intl.NumberFormat(\'de-DE\', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(v);
  };
  const formatCount = function(v) {
    return new Intl.NumberFormat(\'de-DE\').format(v);
  };

  if (showRating && valueEl && store.dataset.gprRating) {
    valueEl.textContent = formatRating(parseFloat(store.dataset.gprRating));
  }
  if (showCount && countEl && store.dataset.gprCount) {
    countEl.textContent = \'(\' + formatCount(parseInt(store.dataset.gprCount, 10)) + \')\';
  }

  const filledLayer = inner.querySelector(\'.bda11y-google-rating__stars-filled\');
  if (filledLayer && store.dataset.gprFillPercent) {
    const rightInset = (100 - parseFloat(store.dataset.gprFillPercent)).toFixed(4);
    filledLayer.style.clipPath = \'inset(0 \' + rightInset + \'% 0 0)\';
  }
})();
',
        ]],];
    }

    static function nestingRule()
    {
        return ['type' => 'final'];
    }

    static function spacingBars()
    {
        return [['location' => 'outside-top', 'cssProperty' => 'margin-top', 'affectedPropertyPath' => 'design.spacing.wrapper.margin_top.%%BREAKPOINT%%'], ['location' => 'outside-bottom', 'cssProperty' => 'margin-bottom', 'affectedPropertyPath' => 'design.spacing.wrapper.margin_bottom.%%BREAKPOINT%%']];
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
        return 750;
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
        return ['design.stars.size'];
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return false;
    }
}
