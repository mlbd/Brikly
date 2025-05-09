<?php

namespace Brikly\Admin;

class Options{

    /**
     * Options instance.
     *
     * @var Options|null
     */
    private static $instance = null;

    /**
     * Get Options instance.
     *
     * @return Options
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register() {
        add_action('admin_menu', [$this, 'addAdminPage']);
    }

    public function addAdminPage() {
        add_menu_page(
            'Brikly Admin',
            'Brikly',
            'manage_options',
            'brikly-admin',
            [$this, 'renderAdminPage'],
            'dashicons-admin-generic',
            6
        );
    }

    public function renderAdminPage() {
        echo '<div id="brikly-admin-root"></div>';
        wp_enqueue_script('brikly-admin-script', BRIKLY_URL . '/build/index.js', ['wp-i18n', 'wp-element'], '1.0', true);
    }
}