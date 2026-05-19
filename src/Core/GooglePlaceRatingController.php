<?php

namespace Breakdance\A11y\Core;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class GooglePlaceRatingController
{
    public function register_routes(): void
    {
        register_rest_route('bda11y/v1', '/place-rating', [
            'methods'             => 'GET',
            'callback'            => [$this, 'get_place_rating'],
            'permission_callback' => '__return_true',
            'args'                => [
                'place_id' => [
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                    'validate_callback' => static function ($param) {
                        return is_string($param) && strlen(trim($param)) > 0;
                    },
                ],
            ],
        ]);
    }

    public function get_place_rating(WP_REST_Request $request): WP_REST_Response|WP_Error
    {
        $api_key = get_option('bda11y_google_api_key', '');

        if (empty($api_key)) {
            return new WP_Error('missing_api_key', 'Google Places API key not configured.', ['status' => 500]);
        }

        $place_id = (string) $request->get_param('place_id');
        $ttl      = (int) get_option('bda11y_google_cache_ttl', 43200);

        $client = new GooglePlacesClient($api_key, $ttl);
        $data   = $client->get_place_rating($place_id);

        if (empty($data['ok'])) {
            return new WP_Error(
                'place_rating_unavailable',
                'Place rating could not be retrieved.',
                ['status' => 502, 'details' => $data['error'] ?? 'unknown']
            );
        }

        return new WP_REST_Response([
            'place_id'               => $data['place_id'],
            'name'                   => $data['name'],
            'rating'                 => $data['rating'],
            'user_rating_count'      => $data['user_rating_count'],
            'google_maps_uri'        => $data['google_maps_uri'],
            'stars_percent'          => $data['stars_percent'],
            'rating_integer'         => $data['rating_integer'],
            'rating_percent_integer' => $data['rating_percent_integer'],
        ], 200);
    }
}
