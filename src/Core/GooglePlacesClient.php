<?php

namespace Breakdance\A11y\Core;

class GooglePlacesClient
{
    private string $api_key;
    private int $ttl;

    public function __construct(string $api_key, int $ttl = 43200)
    {
        $this->api_key = $api_key;
        $this->ttl     = $ttl;
    }

    public function get_place_rating(string $place_id): array
    {
        $place_id = trim($place_id);

        if ($place_id === '') {
            return ['ok' => false, 'error' => 'missing_place_id'];
        }

        $cache_key = 'bda11y_gpr_' . md5($place_id);
        $cached    = get_transient($cache_key);

        if (is_array($cached)) {
            return $cached;
        }

        $url = 'https://places.googleapis.com/v1/places/' . rawurlencode($place_id);

        $response = wp_remote_get($url, [
            'timeout' => 10,
            'headers' => [
                'X-Goog-Api-Key'   => $this->api_key,
                'X-Goog-FieldMask' => 'displayName,rating,userRatingCount,googleMapsUri',
                'Referer'          => home_url('/'),
            ],
        ]);

        if (is_wp_error($response)) {
            return ['ok' => false, 'error' => 'http_error', 'message' => $response->get_error_message()];
        }

        $status = wp_remote_retrieve_response_code($response);
        $body   = json_decode(wp_remote_retrieve_body($response), true);

        if ($status !== 200 || !is_array($body)) {
            $google_message = '';
            if (is_array($body) && isset($body['error']['message'])) {
                $google_message = $body['error']['message'];
            } elseif (is_array($body) && isset($body['error']['status'])) {
                $google_message = $body['error']['status'];
            }
            return ['ok' => false, 'error' => 'invalid_response', 'status' => $status, 'message' => $google_message];
        }

        $rating = isset($body['rating']) ? (float) $body['rating'] : 0.0;

        $data = [
            'ok'                => true,
            'place_id'          => $place_id,
            'name'              => $body['displayName']['text'] ?? '',
            'rating'            => $rating,
            'user_rating_count' => isset($body['userRatingCount']) ? (int) $body['userRatingCount'] : 0,
            'google_maps_uri'   => $body['googleMapsUri'] ?? '',
            'stars_percent'     => round(max(0.0, min(100.0, ($rating / 5.0) * 100.0)), 4),
            'rating_integer'    => (int) floor($rating),
            'rating_percent_integer' => (int) round(($rating - floor($rating)) * 10) * 10,
        ];

        set_transient($cache_key, $data, $this->ttl);

        return $data;
    }
}
