<?php

namespace Breakdance\A11y\Core;

use Breakdance\A11y\Core\Optimization;

class Plugin
{
  protected $optimization;

  public function __construct()
  {
    $this->init();
    $this->optimization = new Optimization();
  }

  public function init()
  {
    register_activation_hook('__FILE__', [$this, 'activate']);
    register_deactivation_hook('__FILE__', [$this, 'deactivate']);

    add_action('plugins_loaded', [$this, 'load_text_domain']);
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

  public function enqueue_scripts()
  {
    if(!is_admin())	{
      wp_enqueue_script('jquery');
      wp_enqueue_script('choices-js', plugins_url('/assets/js/choices.min.js', __FILE__), [], false, true);
      wp_enqueue_script('bda11y-script', plugins_url( '/assets/js/bd-a11y.js', __FILE__ ), ['jquery'], true);

      wp_enqueue_style('choices-css', plugins_url('/assets/css/choices.min.css', __FILE__));
      wp_enqueue_style('bda11y-style', plugins_url('/assets/css/bd-a11y.css',__FILE__));
    }
  }

}