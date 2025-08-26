<?php

namespace BreakdanceCustomElements;

use function Breakdance\Util\getDirectoryPathRelativeToPluginFolder;
use function Breakdance\ElementStudio\registerSaveLocation;
use function Breakdance\Elements\registerCategory;

add_action('breakdance_loaded', function () {
    registerSaveLocation(
        getDirectoryPathRelativeToPluginFolder(__DIR__) . '/elements',
        'BreakdanceA11yElements',
        'element',
        'Breakdance A11y Elements',
        false
    );

    registerSaveLocation(
        getDirectoryPathRelativeToPluginFolder(__DIR__) . '/macros',
        'BreakdanceA11yElements',
        'macro',
        'Breakdance A11y Macros',
        false,
    );

    registerSaveLocation(
        getDirectoryPathRelativeToPluginFolder(__DIR__) . '/presets',
        'BreakdanceA11yElements',
        'preset',
        'Breakdance A11y Presets',
        false,
    );
    
    registerCategory('breakdance-a11y', 'Breakdance A11y');
},
    // register elements before loading them
    9
);