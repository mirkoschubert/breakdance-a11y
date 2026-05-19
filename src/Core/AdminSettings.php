<?php

namespace Breakdance\A11y\Core;

class AdminSettings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_notices', [$this, 'maybe_show_api_key_notice']);
        add_action('admin_post_bda11y_test_connection', [$this, 'handle_test_connection']);
        add_action('admin_post_bda11y_clear_cache', [$this, 'handle_clear_cache']);
    }

    public function add_settings_page(): void
    {
        add_options_page(
            'Breakdance A11y',
            'Breakdance A11y',
            'manage_options',
            'bda11y-settings',
            [$this, 'render_page']
        );
    }

    public function register_settings(): void
    {
        register_setting('bda11y_settings', 'bda11y_google_api_key', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ]);

        register_setting('bda11y_settings', 'bda11y_google_cache_ttl', [
            'type'              => 'integer',
            'sanitize_callback' => static function ($value) {
                $int = (int) $value;
                return max(3600, min(604800, $int));
            },
            'default'           => 43200,
        ]);

        add_settings_section(
            'bda11y_google_section',
            'Google Places API',
            static function () {
                echo '<p>Zugangsdaten für die Google Places API (New). Der API Key wird benötigt, um Google-Bewertungen abzurufen.</p>';
            },
            'bda11y-settings'
        );

        add_settings_field(
            'bda11y_google_api_key',
            'API Key',
            [$this, 'render_api_key_field'],
            'bda11y-settings',
            'bda11y_google_section'
        );

        add_settings_field(
            'bda11y_google_cache_ttl',
            'Cache-Dauer (Sekunden)',
            [$this, 'render_cache_ttl_field'],
            'bda11y-settings',
            'bda11y_google_section'
        );
    }

    public function render_api_key_field(): void
    {
        $value = get_option('bda11y_google_api_key', '');
        echo '<input type="password" name="bda11y_google_api_key" id="bda11y_google_api_key" value="' . esc_attr($value) . '" class="regular-text" autocomplete="off">';
        echo '<p class="description">Nur "Places API (New)" muss in der Google Cloud Console aktiviert sein.</p>';
    }

    public function render_cache_ttl_field(): void
    {
        $value = (int) get_option('bda11y_google_cache_ttl', 43200);
        echo '<input type="number" name="bda11y_google_cache_ttl" id="bda11y_google_cache_ttl" value="' . esc_attr($value) . '" min="3600" max="604800" step="3600" class="small-text">';
        echo '<p class="description">Wie lange Bewertungen zwischengespeichert werden (3600 = 1 Stunde, 43200 = 12 Stunden, 86400 = 1 Tag).</p>';
    }

    public function handle_test_connection(): void
    {
        if (!current_user_can('manage_options') || !check_admin_referer('bda11y_test_connection')) {
            wp_die('Nicht erlaubt.');
        }

        $place_id = sanitize_text_field($_POST['bda11y_test_place_id'] ?? '');
        $api_key  = get_option('bda11y_google_api_key', '');

        if (empty($api_key)) {
            set_transient('bda11y_test_result', ['ok' => false, 'error' => 'Kein API Key gesetzt.'], 60);
        } elseif (empty($place_id)) {
            set_transient('bda11y_test_result', ['ok' => false, 'error' => 'Keine Place ID eingegeben.'], 60);
        } else {
            $client = new GooglePlacesClient($api_key, 60);
            // Bypass cache for test: delete transient first
            delete_transient('bda11y_gpr_' . md5($place_id));
            $result = $client->get_place_rating($place_id);
            $result['tested_place_id'] = $place_id;
            $result['tested_at']       = current_time('mysql');
            set_transient('bda11y_test_result', $result, 60);
        }

        wp_redirect(admin_url('options-general.php?page=bda11y-settings#bda11y-status'));
        exit;
    }

    public function handle_clear_cache(): void
    {
        if (!current_user_can('manage_options') || !check_admin_referer('bda11y_clear_cache')) {
            wp_die('Nicht erlaubt.');
        }

        global $wpdb;
        $deleted = $wpdb->query(
            "DELETE FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_bda11y_gpr_%'
                OR option_name LIKE '_transient_timeout_bda11y_gpr_%'"
        );

        set_transient('bda11y_cache_cleared', (int) $deleted, 60);

        wp_redirect(admin_url('options-general.php?page=bda11y-settings#bda11y-status'));
        exit;
    }

    private function render_status_section(): void
    {
        $api_key       = get_option('bda11y_google_api_key', '');
        $test_result   = get_transient('bda11y_test_result');
        $cache_cleared = get_transient('bda11y_cache_cleared');

        if ($cache_cleared !== false) {
            delete_transient('bda11y_cache_cleared');
            echo '<div class="notice notice-success inline"><p>Cache geleert: ' . (int) $cache_cleared . ' Eintr&auml;ge gel&ouml;scht.</p></div>';
        }

        echo '<hr><h2 id="bda11y-status">Status &amp; Diagnose</h2>';

        // System status table
        global $wpdb;
        echo '<table class="widefat striped" style="max-width:700px;margin-bottom:16px">';
        echo '<tbody>';

        // API Key status
        $key_status = empty($api_key)
            ? '<span style="color:#d63638">&#10007; Nicht gesetzt</span>'
            : '<span style="color:#00a32a">&#10003; Gesetzt (' . strlen($api_key) . ' Zeichen)</span>';
        echo '<tr><th style="width:220px">API Key</th><td>' . $key_status . '</td></tr>';

        // REST endpoint reachability
        $rest_url = rest_url('bda11y/v1/place-rating');
        echo '<tr><th>REST-Endpoint</th><td>';
        echo '<code>' . esc_html($rest_url) . '?place_id=...</code><br>';
        echo '<a href="' . esc_url($rest_url . '?place_id=ChIJN1t_tDeuEmsRUsoyG83frY4') . '" target="_blank" class="button button-small" style="margin-top:4px">Im Browser testen (Demo-ID)</a>';
        echo '</td></tr>';

        // PHP version & WP HTTP
        echo '<tr><th>PHP-Version</th><td>' . esc_html(PHP_VERSION) . '</td></tr>';

        // WP cron / transient storage
        $using_external_cache = wp_using_ext_object_cache();
        echo '<tr><th>Transient-Speicher</th><td>' . ($using_external_cache ? 'Externer Object Cache (z.B. Redis)' : 'Datenbank (wp_options)') . '</td></tr>';

        // Cache entries count
        $cache_count = (int) $wpdb->get_var(
            "SELECT COUNT(*) FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_bda11y_gpr_%'
               AND option_name NOT LIKE '_transient_timeout_%'"
        );
        echo '<tr><th>Gecachte Places</th><td>' . $cache_count . ' Eintr&auml;ge</td></tr>';

        echo '</tbody></table>';

        // Cache entry details
        $cache_entries = $wpdb->get_results(
            "SELECT
                REPLACE(option_name, '_transient_bda11y_gpr_', '') AS hash,
                option_value
             FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_bda11y_gpr_%'
               AND option_name NOT LIKE '_transient_timeout_%'
             LIMIT 20"
        );

        // Cache details
        if ($cache_entries) {
            echo '<h3>Cache-Einträge</h3>';
            echo '<table class="widefat striped" style="max-width:700px;margin-bottom:16px">';
            echo '<thead><tr><th>Place ID</th><th>Name</th><th>Rating</th><th>Bewertungen</th><th>Timeout</th></tr></thead><tbody>';
            foreach ($cache_entries as $row) {
                $data    = maybe_unserialize($row->option_value);
                $timeout = get_option('_transient_timeout_bda11y_gpr_' . $row->hash);
                $expires = $timeout ? human_time_diff(time(), (int) $timeout) . ' verbleibend' : 'unbekannt';
                $place_id = $data['place_id'] ?? '-';
                $name     = $data['name'] ?? '-';
                $rating   = isset($data['rating']) ? number_format_i18n((float) $data['rating'], 1) : '-';
                $count    = isset($data['user_rating_count']) ? number_format_i18n((int) $data['user_rating_count']) : '-';
                echo '<tr>';
                echo '<td><code>' . esc_html($place_id) . '</code></td>';
                echo '<td>' . esc_html($name) . '</td>';
                echo '<td>' . esc_html($rating) . '</td>';
                echo '<td>' . esc_html($count) . '</td>';
                echo '<td>' . esc_html($expires) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }

        // Connection test result
        if ($test_result !== false) {
            delete_transient('bda11y_test_result');
            echo '<h3>Verbindungstest</h3>';
            if (!empty($test_result['ok'])) {
                echo '<div class="notice notice-success inline"><p>';
                echo '<strong>&#10003; Verbindung erfolgreich</strong> ';
                echo '(Place ID: <code>' . esc_html($test_result['tested_place_id'] ?? '') . '</code>, ';
                echo 'getestet: ' . esc_html($test_result['tested_at'] ?? '') . ')<br>';
                echo 'Name: ' . esc_html($test_result['name'] ?? '') . '<br>';
                echo 'Rating: ' . esc_html(number_format_i18n((float) ($test_result['rating'] ?? 0), 1)) . ' ';
                echo '(' . esc_html(number_format_i18n((int) ($test_result['user_rating_count'] ?? 0))) . ' Bewertungen)';
                echo '</p></div>';
            } else {
                echo '<div class="notice notice-error inline"><p>';
                echo '<strong>&#10007; Verbindung fehlgeschlagen:</strong> ' . esc_html($test_result['error'] ?? 'Unbekannter Fehler');
                if (!empty($test_result['status'])) {
                    echo ' (HTTP ' . (int) $test_result['status'] . ')';
                }
                if (!empty($test_result['message'])) {
                    echo '<br><code>' . esc_html($test_result['message']) . '</code>';
                }
                echo '</p></div>';
            }
        }

        // Connection test form
        echo '<h3>Verbindung testen</h3>';
        echo '<p class="description" style="margin-bottom:8px">Testet die Verbindung direkt von diesem Server zur Google Places API. Ignoriert den Cache einmalig und zeigt die Rohdaten.</p>';
        echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '" style="display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap">';
        wp_nonce_field('bda11y_test_connection');
        echo '<input type="hidden" name="action" value="bda11y_test_connection">';
        echo '<input type="text" name="bda11y_test_place_id" placeholder="Place ID (z.B. ChIJN1t_tDeuEmsRUsoyG83frY4)" class="regular-text" required>';
        echo '<button type="submit" class="button button-primary">API-Verbindung testen</button>';
        echo '</form>';

        // JS diagnostics section
        echo '<h3>JS-Hydration debuggen</h3>';
        echo '<p class="description" style="margin-bottom:8px">';
        echo 'Das Hydration-Script loggt jeden Schritt in die Browser-Konsole (<code>F12 &rarr; Console</code>). ';
        echo 'Erwartete Meldungen beim Seitenaufruf mit einem platzierten Element:<br>';
        echo '<code>[bda11y] Boot: found 1 Google Place Rating element(s)</code><br>';
        echo '<code>[bda11y] Fetching rating for place_id: ...</code><br>';
        echo '<code>[bda11y] Hydration complete for place_id: ...</code>';
        echo '</p>';
        echo '<p class="description">';
        echo 'Erscheint kein <code>[bda11y] Boot</code>-Log, wird das Script nicht geladen. ';
        echo 'Erscheint <code>Boot: found 0 elements</code>, fehlt <code>data-place-id</code> im HTML &ndash; ';
        echo 'pr&uuml;fbar &uuml;ber Rechtsklick auf das Element &rarr; "Element untersuchen": ';
        echo 'Das innere <code>&lt;div class="bda11y-google-rating__inner"&gt;</code> muss ein ';
        echo '<code>data-place-id</code>-Attribut mit der eingetragenen Place ID enthalten.';
        echo '</p>';

        $rest_url = rest_url('bda11y/v1/place-rating');
        echo '<p class="description">';
        echo 'REST-Endpoint direkt im Browser pr&uuml;fen (eingeloggt als Admin): ';
        echo '<a href="' . esc_url($rest_url . '?place_id=ChIJN1t_tDeuEmsRUsoyG83frY4') . '" target="_blank">';
        echo esc_html($rest_url) . '?place_id=ChIJN1t_tDeuEmsRUsoyG83frY4</a>';
        echo '</p>';

        // Clear cache form
        echo '<h3>Cache leeren</h3>';
        echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
        wp_nonce_field('bda11y_clear_cache');
        echo '<input type="hidden" name="action" value="bda11y_clear_cache">';
        echo '<button type="submit" class="button button-secondary" onclick="return confirm(\'Alle gecachten Bewertungen l&ouml;schen?\')">Cache leeren</button>';
        echo '</form>';
        echo '<p class="description">Alle zwischengespeicherten Google-Bewertungen werden gel&ouml;scht. Beim n&auml;chsten Seitenaufruf werden die Daten neu von der API abgerufen.</p>';
    }

    public function render_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('bda11y_settings');
                do_settings_sections('bda11y-settings');
                submit_button('Einstellungen speichern');
                ?>
            </form>
            <?php $this->render_status_section(); ?>
        </div>
        <?php
    }

    public function maybe_show_api_key_notice(): void
    {
        $screen = get_current_screen();

        if (!$screen || $screen->id === 'settings_page_bda11y-settings') {
            return;
        }

        if (!empty(get_option('bda11y_google_api_key', ''))) {
            return;
        }

        echo '<div class="notice notice-warning is-dismissible"><p>'
            . 'Breakdance A11y: Kein Google Places API Key konfiguriert. '
            . '<a href="' . esc_url(admin_url('options-general.php?page=bda11y-settings')) . '">Jetzt einrichten</a>.'
            . '</p></div>';
    }
}
