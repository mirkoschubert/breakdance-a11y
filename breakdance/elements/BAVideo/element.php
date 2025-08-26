<?php

namespace BreakdanceA11yElement;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "BreakdanceA11yElement\\BAVideo",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class BAVideo extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'VideoIcon';
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
        return 'BA Video';
    }

    static function className()
    {
        return 'bde-video';
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
        return ['content' => ['video' => ['video' => ['title' => 'Sample Videos / Dummy Videos For Demo Use', 'provider' => 'youtube', 'url' => 'https://www.youtube.com/watch?v=EngW7tLk6R8', 'embedUrl' => 'https://www.youtube.com/embed/EngW7tLk6R8?feature=oembed', 'thumbnail' => 'https://i.ytimg.com/vi/EngW7tLk6R8/hqdefault.jpg', 'format' => 'video', 'type' => 'oembed', 'videoId' => 'EngW7tLk6R8', 'source' => 'youtube']], 'youtube' => ['loading_method' => 'lightweight']]];
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
        "container",
        "Container",
        [c(
        "width",
        "Width",
        [],
        ['type' => 'unit', 'layout' => 'inline'],
        true,
        false,
        [],
      ), c(
        "overlay",
        "Overlay",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
      ), getPresetSection(
      "EssentialElements\\borders",
      "Borders",
      "borders",
       ['type' => 'popout']
     )],
        ['type' => 'section'],
        false,
        false,
        [],
      ), c(
        "lazy_load",
        "Lazy Load",
        [c(
        "icon_color",
        "Icon Color",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        true,
        [],
      ), c(
        "icon_size",
        "Icon Size",
        [],
        ['type' => 'unit', 'layout' => 'inline'],
        true,
        false,
        [],
      )],
        ['type' => 'section', 'condition' => ['path' => 'content.lazy_load.lazy_load', 'operand' => 'is set', 'value' => '']],
        false,
        false,
        [],
      ), getPresetSection(
      "EssentialElements\\spacing_margin_y",
      "Spacing",
      "spacing",
       ['type' => 'popout']
     )];
    }

    static function contentControls()
    {
        return [c(
        "video",
        "Video",
        [c(
        "video",
        "Video",
        [],
        ['type' => 'video', 'layout' => 'vertical', 'videoOptions' => ['providers' => ['youtube', 'vimeo', 'dailymotion']], 'autofocus' => null],
        false,
        false,
        [],
      ), c(
        "ratio",
        "Ratio",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['text' => '16:9', 'label' => 'Label', 'value' => '56.25%'], ['text' => '16:10', 'label' => 'Label', 'value' => '62.5%'], ['text' => '4:3', 'value' => '75%'], ['text' => '1:1', 'value' => '100%'], ['text' => '21:9', 'value' => '42.85%'], ['text' => '3:2', 'value' => '66.67%'], ['text' => 'Custom', 'value' => 'custom']]],
        false,
        false,
        [],
      ), c(
        "custom_width",
        "Custom width",
        [],
        ['type' => 'number', 'layout' => 'inline', 'condition' => ['path' => 'content.video.ratio', 'operand' => 'equals', 'value' => 'custom']],
        false,
        false,
        [],
      ), c(
        "custom_height",
        "Custom height",
        [],
        ['type' => 'number', 'layout' => 'inline', 'condition' => ['path' => 'content.video.ratio', 'operand' => 'equals', 'value' => 'custom']],
        false,
        false,
        [],
      ), c(
        "title",
        "Title",
        [],
        ['type' => 'text', 'layout' => 'inline'],
        false,
        false,
        [],
      )],
        ['type' => 'section', 'layout' => 'vertical'],
        false,
        false,
        [],
      ), c(
        "video_options",
        "Video Options",
        [c(
        "poster",
        "Poster",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'mediaOptions' => ['acceptedFileTypes' => ['image'], 'multiple' => false]],
        false,
        false,
        [],
      ), c(
        "autoplay",
        "Autoplay",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "controls",
        "Controls",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "loop",
        "Loop",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "muted",
        "Muted",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "download_button",
        "Download Button",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "subtitles",
        "Subtitles",
        [c(
        "label",
        "Label",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'textOptions' => ['format' => 'plain']],
        false,
        false,
        [],
      ), c(
        "language",
        "Language",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'items' => [['value' => 'en', 'text' => 'English'], ['text' => 'German', 'value' => 'de']]],
        false,
        false,
        [],
      ), c(
        "file",
        "File",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'mediaOptions' => ['multiple' => false]],
        false,
        false,
        [],
      ), c(
        "is_default",
        "Default",
        [],
        ['type' => 'toggle', 'layout' => 'vertical'],
        false,
        false,
        [],
      )],
        ['type' => 'repeater', 'layout' => 'vertical', 'repeaterOptions' => ['titleTemplate' => '{label}', 'defaultTitle' => '', 'buttonName' => '']],
        false,
        false,
        [],
      )],
        ['type' => 'section', 'layout' => 'vertical', 'condition' => ['path' => 'content.video.video.source', 'operand' => 'is none of', 'value' => ['youtube', 'vimeo', 'dailymotion']]],
        false,
        false,
        [],
      ), c(
        "youtube",
        "YouTube",
        [c(
        "loading_method",
        "Load Method",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['text' => 'Lightweight', 'value' => 'lightweight'], ['value' => 'lazyload', 'text' => 'Lazy load'], ['text' => 'Full Embed', 'value' => 'embed']]],
        false,
        false,
        [],
      ), c(
        "background_image",
        "Background Image",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'condition' => [[['path' => 'content.youtube.loading_method', 'operand' => 'equals', 'value' => 'lightweight']]]],
        false,
        false,
        [],
      ), c(
        "logo",
        "Logo",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'condition' => [[['path' => 'content.youtube.loading_method', 'operand' => 'equals', 'value' => 'lightweight']]]],
        false,
        false,
        [],
      ), c(
        "title",
        "Title",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'condition' => [[['path' => 'content.youtube.loading_method', 'operand' => 'equals', 'value' => 'lightweight']]]],
        false,
        false,
        [],
      ), c(
        "autoplay",
        "Autoplay",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.youtube.loading_method', 'operand' => 'is none of', 'value' => ['lightweight']]],
        false,
        false,
        [],
      ), c(
        "loop",
        "Loop",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "mute",
        "Mute",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "modest_branding",
        "Modest Branding",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.youtube.hide_player_controls', 'operand' => 'is not set', 'value' => '']],
        false,
        false,
        [],
      ), c(
        "hide_player_controls",
        "Hide Player Controls",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "play_inline",
        "Play Inline",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "privacy_mode",
        "Privacy mode",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.youtube.loading_method', 'operand' => 'not equals', 'value' => 'lightweight']],
        false,
        false,
        [],
      ), c(
        "start_time",
        "Start Time",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'unitOptions' => ['types' => ['s'], 'defaultType' => 's']],
        false,
        false,
        [],
      ), c(
        "end_time",
        "End Time",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'unitOptions' => ['types' => ['s'], 'defaultType' => 's']],
        false,
        false,
        [],
      ), c(
        "suggested_videos",
        "Suggested Videos",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['value' => 'same_channel', 'text' => 'From same channel'], ['text' => 'Recommendations', 'value' => 'recommendations']], 'condition' => ['path' => 'content.youtube.loop', 'operand' => 'is not set', 'value' => '']],
        false,
        false,
        [],
      )],
        ['type' => 'section', 'layout' => 'vertical', 'condition' => ['path' => 'content.video.video.source', 'operand' => 'is none of', 'value' => ['vimeo', 'dailymotion']]],
        false,
        false,
        [],
      ), c(
        "vimeo",
        "Vimeo",
        [c(
        "loading_method",
        "Load Method",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['text' => 'Lightweight', 'value' => 'lightweight'], ['text' => 'Lazy Load', 'value' => 'lazyload'], ['text' => 'Full embed', 'value' => 'embed']]],
        false,
        false,
        [],
      ), c(
        "autoplay",
        "Autoplay",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.youtube.loading_method', 'operand' => 'not equals', 'value' => 'lightweight']],
        false,
        false,
        [],
      ), c(
        "play_inline",
        "Play Inline",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.vimeo.loading_method', 'operand' => 'not equals', 'value' => 'lightweight']],
        false,
        false,
        [],
      ), c(
        "loop",
        "Loop",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.vimeo.loading_method', 'operand' => 'not equals', 'value' => 'lightweight']],
        false,
        false,
        [],
      ), c(
        "mute",
        "Mute",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.vimeo.loading_method', 'operand' => 'not equals', 'value' => 'lightweight']],
        false,
        false,
        [],
      ), c(
        "hide_player_controls",
        "Hide Player Controls",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.vimeo.loading_method', 'operand' => 'not equals', 'value' => 'lightweight']],
        false,
        false,
        [],
      ), c(
        "start_time",
        "Start Time",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'unitOptions' => ['types' => ['s'], 'defaultType' => 's']],
        false,
        false,
        [],
      ), c(
        "background_image",
        "Background Image",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'condition' => [[['path' => 'content.vimeo.loading_method', 'operand' => 'equals', 'value' => 'lightweight']]]],
        false,
        false,
        [],
      )],
        ['type' => 'section', 'layout' => 'vertical', 'condition' => ['path' => 'content.video.video.source', 'operand' => 'is none of', 'value' => ['dailymotion', 'youtube']]],
        false,
        false,
        [],
      ), c(
        "dailymotion",
        "DailyMotion",
        [c(
        "loading_method",
        "Load Method",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['value' => 'lazyload', 'text' => 'Lazy load'], ['text' => 'Full Embed', 'value' => 'embed']]],
        false,
        false,
        [],
      ), c(
        "autoplay",
        "Autoplay",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "controls",
        "Controls",
        [c(
        "hide_all_controls",
        "Hide All Controls",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "color",
        "Color",
        [],
        ['type' => 'color', 'layout' => 'inline', 'condition' => ['path' => 'content.dailymotion.controls.hide_all_controls', 'operand' => 'is not set', 'value' => '']],
        false,
        false,
        [],
      ), c(
        "hide_logo",
        "Hide Logo",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.dailymotion.controls.hide_all_controls', 'operand' => 'is not set', 'value' => '']],
        false,
        false,
        [],
      ), c(
        "hide_video_info",
        "Hide Video Info",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.dailymotion.controls.hide_all_controls', 'operand' => 'is not set', 'value' => '']],
        false,
        false,
        [],
      ), c(
        "disable_sharing",
        "Disable Sharing",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.dailymotion.controls.hide_all_controls', 'operand' => 'is not set', 'value' => '']],
        false,
        false,
        [],
      )],
        ['type' => 'section', 'layout' => 'vertical', 'condition' => ['path' => 'content.dailymotion.hide_player_controls', 'operand' => 'is not set', 'value' => ''], 'sectionOptions' => ['type' => 'popout']],
        false,
        false,
        [],
      ), c(
        "mute",
        "Mute",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "start_time",
        "Start Time",
        [],
        ['type' => 'unit', 'layout' => 'inline', 'unitOptions' => ['types' => ['s'], 'defaultType' => 's']],
        false,
        false,
        [],
      )],
        ['type' => 'section', 'layout' => 'vertical', 'condition' => ['path' => 'content.video.video.source', 'operand' => 'is none of', 'value' => ['vimeo', 'youtube']]],
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
        return ['0' =>  ['frontendCondition' => '{% if content.video.video.provider == \'youtube\' and content.youtube.loading_method == \'lightweight\' %}
return true;
{% endif %}','title' => 'lite-youtube','scripts' => ['%%BREAKDANCE_ELEMENTS_PLUGIN_URL%%dependencies-files/lite-youtube@0.2/lite-yt-embed.js'],'styles' => ['%%BREAKDANCE_ELEMENTS_PLUGIN_URL%%dependencies-files/lite-youtube@0.2/lite-yt-embed.css'],'builderCondition' => '{% if content.video.video.provider == \'youtube\' and content.youtube.loading_method == \'lightweight\'%}
return true;
{% endif %}',],'1' =>  ['frontendCondition' => '{% if content.video.video.provider == \'vimeo\' and content.vimeo.loading_method == \'lightweight\'%}
return true;
{% endif %}','title' => 'lite-vimeo','builderCondition' => '{% if content.video.video.provider == \'vimeo\' and content.vimeo.loading_method == \'lightweight\' %}
return true;
{% endif %}','scripts' => ['%%BREAKDANCE_ELEMENTS_PLUGIN_URL%%dependencies-files/lite-vimeo-embed@0.1/lite-vimeo.js'],'inlineScripts' => ['const backgroundImage = \'{{content.vimeo.background_image.url}}\';
if (backgroundImage != \'\') {
  const container = document.querySelector(\'%%SELECTOR%% .ee-video-container\');
  const poster = container.querySelector(\'.ee-vimeo-poster\');
  if (poster) {
    poster.addEventListener(\'click\', function() {
      const liteVimeo = document.createElement(\'lite-vimeo\');
      liteVimeo.setAttribute(\'videoid\', \'{{ content.video.video.videoId }}\');
      liteVimeo.setAttribute(\'autoload\', \'\');
      liteVimeo.setAttribute(\'autoplay\', \'\');
      {% if content.vimeo.start_time %}
      liteVimeo.setAttribute(\'videoPlay\', \'{{content.vimeo.start_time.style}}\');
      {% endif %}
      liteVimeo.classList.add(\'ee-video\');
      container.appendChild(liteVimeo);
      container.removeChild(poster);
      liteVimeo.click();
    });
  }
}'],],'2' =>  ['title' => 'lozad','scripts' => ['%%BREAKDANCE_ELEMENTS_PLUGIN_URL%%dependencies-files/lozard@1/lozad.min.js'],'inlineScripts' => ['const observer = lozad();
observer.observe();'],'builderCondition' => 'return false;','frontendCondition' => '{% if content.youtube.loading_method != \'embed\' or content.vimeo.loading_method != \'embed\' or content.dailymotion.loading_method != \'embed\' %}
return true;
{% endif %}',],];
    }

    static function settings()
    {
        return ['bypassPointerEvents' => true];
    }

    static function addPanelRules()
    {
        return false;
    }

    static public function actions()
    {
        return false;
    }

    static function nestingRule()
    {
        return ["type" => "final",   ];
    }

    static function spacingBars()
    {
        return [['location' => 'outside-top', 'cssProperty' => 'margin-top', 'affectedPropertyPath' => 'design.spacing.margin_top.%%BREAKPOINT%%'], ['location' => 'outside-bottom', 'cssProperty' => 'margin-bottom', 'affectedPropertyPath' => 'design.spacing.margin_bottom.%%BREAKPOINT%%']];
    }

    static function attributes()
    {
        return false;
    }

    static function experimental()
    {
        return false;
    }

    static function order()
    {
        return 93;
    }

    static function dynamicPropertyPaths()
    {
        return [['accepts' => 'video', 'path' => 'content.video.video'], ['accepts' => 'string', 'path' => 'content.youtube.title'], ['accepts' => 'image_url', 'path' => 'content.youtube.background_image'], ['accepts' => 'image_url', 'path' => 'content.youtube.logo'], ['accepts' => 'image_url', 'path' => 'content.vimeo.background_image']];
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
