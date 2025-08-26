<?php
/*
Plugin Name:  Breakdance A11y
Plugin URI:   https://github.com/mirkoschubert/breakdance-a11y
Description:  Accessibility Features and Elements for the Soflyy Breakdance Builder 
Version:      0.4.0
Author:       Mirko Schubert
Author URI:   https://mirkoschubert.de/
License:      GPL 3.0
License URI:  https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
Text Domain:  bda11y
Domain Path:  /lang
*/

if (!defined( 'ABSPATH' )) exit();

define('BDA11Y_VERSION', '0.4.0');
define('BDA11Y_PLUGIN', esc_html__('Breakdance A11y', 'bda11y'));
define('BDA11Y_DIR', dirname(plugin_basename(__FILE__)));
define('BDA11Y_PATH', plugin_basename(__FILE__));
define('BDA11Y_ABSPATH', plugin_dir_path(__FILE__));

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use Breakdance\A11y\Core\Plugin;

include 'breakdance/bd-register-elements.php';

$plugin = new Plugin();
$plugin->init();

register_uninstall_hook(__FILE__, ['Breakdance\A11y\Core\Plugin', 'uninstall']);
