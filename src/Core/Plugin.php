<?php

namespace Breakdance\A11y\Core;

use Breakdance\A11y\Core\Optimization;
use Breakdance\A11y\Core\AdminSettings;
use Breakdance\A11y\Core\GooglePlaceRatingController;
use function BreakdanceCustomElements\registerElements;

class Plugin
{
  protected $optimization;

  public function __construct()
  {
    $this->optimization = new Optimization();
    $this->init();
    $this->registerElements();
    $this->register_dependencies();
  }

  public function init()
  {
    register_activation_hook('__FILE__', [$this, 'activate']);
    register_deactivation_hook('__FILE__', [$this, 'deactivate']);

    add_action('init', [$this, 'load_text_domain']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

    add_action('init', [$this, 'add_excerpt_to_pages']);

    new AdminSettings();

    add_action('rest_api_init', function () {
      $controller = new GooglePlaceRatingController();
      $controller->register_routes();
    });

    add_filter('rank_math/frontend/breadcrumb/items', [$this, 'register_job_breadcrumb'], 10, 2);
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
    load_plugin_textdomain('bda11y', false, BDA11Y_PATH . '/lang/');
  }

  public function get_plugin_name()
  {
    return esc_html__(BDA11Y_PLUGIN, 'bda11y');
  }

  public function enqueue_scripts()
  {
    if (!is_admin()) {
      wp_enqueue_script('jquery');
      wp_enqueue_script('choices-js', plugins_url('/src/Core/assets/js/choices.min.js', BDA11Y_PATH), [], false, true);
      wp_enqueue_script('bda11y-script', plugins_url('/src/Core/assets/js/bd-a11y.js', BDA11Y_PATH), ['jquery'], true);

      wp_enqueue_style('choices-css', plugins_url('/src/Core/assets/css/choices.min.css', BDA11Y_PATH));
      wp_enqueue_style('bda11y-style', plugins_url('/src/Core/assets/css/bd-a11y.css', BDA11Y_PATH));
    }
  }

  public function register_dependencies()
  {
    add_filter('breakdance_reusable_dependencies_urls', function ($urls) {
      $urls['bda11yGooglePlaceRatingJs'] = plugins_url('breakdance/elements/Google_Place_Rating/assets/js/google-place-rating.js', BDA11Y_PATH);

      $base = plugins_url('breakdance/elements/Leaflet_Maps/assets', BDA11Y_PATH);

      $urls['bda11yLeafletJs'] = $base . '/js/leaflet.js';
      $urls['bda11yLeafletCss'] = $base . '/css/leaflet.css';
      $urls['bda11yLeafletProviders'] = $base . '/js/leaflet-providers.js';
      $urls['bda11yLeafletFullscreenJs'] = $base . '/js/leaflet.fullscreen.js';
      $urls['bda11yLeafletFullscreenCss'] = $base . '/css/leaflet.fullscreen.css';
      $urls['bda11yLeafletClusterJs'] = $base . '/js/leaflet.markercluster.js';
      $urls['bda11yLeafletClusterCss'] = $base . '/css/MarkerCluster.css';
      $urls['bda11yLeafletClusterDefaultCss'] = $base . '/css/MarkerCluster.Default.css';
      $urls['bda11yLeafletInit'] = $base . '/js/leaflet-map-init.js';

      return $urls;
    });
  }

  private function registerElements()
  {
    registerElements();
  }

  public function register_job_breadcrumb($crumbs, $class)
  {

    if (!is_singular('job')) {
      return $crumbs;
    }

    // ID der Karriere-Seite anpassen!
    $career_page_id = 29;
    $career_page = get_post($career_page_id);

    if (empty($career_page) || is_wp_error($career_page)) {
      return $crumbs;
    }

    $home_crumb = $crumbs[0];

    // Neues Breadcrumb-Array: Home -> Karriere -> Rest
    $new_crumbs = [];
    $new_crumbs[] = $home_crumb;
    $new_crumbs[] = [
      0 => get_the_title($career_page),
      1 => get_permalink($career_page),
      'hide_in_schema' => false,
    ];

    for ($i = 1; $i < count($crumbs); $i++) {
      $new_crumbs[] = $crumbs[$i];
    }

    return $new_crumbs;
  }

  public function add_excerpt_to_pages()
  {
    add_post_type_support('page', 'excerpt');
  }


}
