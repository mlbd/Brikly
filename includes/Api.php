<?php
namespace Brikly\Includes;

class Api {
    /**
     * Options instance.
     *
     * @var Api|null
     */
    private static $instance = null;

    /**
     * Get Api instance.
     *
     * @return Api
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Class initialization.
     */
    public function init() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('brikly/v1', '/widgets', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_widgets'],
            'permission_callback' => '__return_true', // Adjust for security
        ]);
        register_rest_route('brikly/v1', '/widgets', [
            'methods' => 'POST',
            'callback' => [$this, 'update_widgets'],
            'permission_callback' => function() {
                return current_user_can('manage_options');
            },
            'args' => [
                'widgets' => [
                    'required' => true,
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'icon' => ['type' => 'string'],
                            'enabled' => ['type' => 'boolean']
                        ]
                    ]
                ]
            ]
        ]);
    }
    
    public function get_widgets() {
        $widgets = get_option('brikly_widgets_list');
        if (!$widgets) {
            return new \WP_REST_Response([], 200); // Return empty array if no option saved
        }
        return new \WP_REST_Response($widgets, 200);
    }

    public function update_widgets($request) {
        $widgets = $request->get_param('widgets');
        $updated = update_option('brikly_widgets_list', $widgets);

        if ($updated) {
            return new \WP_REST_Response(['success' => true], 200);
        }

        return new \WP_REST_Response(['success' => false], 500);
    }
}