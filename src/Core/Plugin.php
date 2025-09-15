<?php

namespace Breakdance\A11y\Core;

use Breakdance\A11y\Core\Optimization;
use function BreakdanceCustomElements\registerElements;

class Plugin
{
  protected $optimization;

  public function __construct()
  {
    $this->optimization = new Optimization();
    $this->init();
    $this->registerElements();
  }

  public function init()
  {
    register_activation_hook('__FILE__', [$this, 'activate']);
    register_deactivation_hook('__FILE__', [$this, 'deactivate']);

    add_action('init', [$this, 'load_text_domain']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
  }


  public function activate()
  {
    // Activation
  }

  public function deactivate()
  {
    // Deactivation
  }

  static public function uninstall()
  {
    // Uninstallation
  }

  public function load_text_domain()
  {
    load_plugin_textdomain('bda11y', false, BDA11Y_PATH .'/lang/');
  }

  public function get_plugin_name()
  {
    return esc_html__(BDA11Y_PLUGIN, 'bda11y');
  }

  public function enqueue_scripts()
  {
    if(!is_admin())	{
      wp_enqueue_script('jquery');
      wp_enqueue_script('choices-js', plugins_url('/src/Core/assets/js/choices.min.js', BDA11Y_PATH), [], false, true);
      wp_enqueue_script('bda11y-script', plugins_url('/src/Core/assets/js/bd-a11y.js', BDA11Y_PATH), ['jquery'], true);

      wp_enqueue_style('choices-css', plugins_url('/src/Core/assets/css/choices.min.css', BDA11Y_PATH));
      wp_enqueue_style('bda11y-style', plugins_url('/src/Core/assets/css/bd-a11y.css', BDA11Y_PATH));
    }
  }

  private function registerElements()
  {
    registerElements();
  }

}