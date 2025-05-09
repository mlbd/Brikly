<?php
/**
 * Plugin Name: Brikly – Brick by Brick, Better Elementor
 * Description: Brikly adds lightweight, modular Elementor widgets and design blocks to help you build stunning websites—brick by brick.
 * Version: 1.0.0
 * Author: Brikly
 * Author URI: https://brikly.com
 * Text Domain: brikly
 * License: GPL-2.0-or-later
 * Requires PHP: 7.4
 * Elementor tested up to: 3.18.0
 * Elementor Pro tested up to: 3.18.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define('BRIKLY_VERSION', '1.0.0');
define('BRIKLY_DB_VERSION', '1.0.0');
define('BRIKLY_PATH', plugin_dir_path( __FILE__ )); //use for include files to other files
define('BRIKLY_ROOT', dirname( __FILE__ ));
define('BRIKLY_FILE_PATH', BRIKLY_ROOT . '/' . basename( __FILE__ ));
define('BRIKLY_FILE', __FILE__);
define('BRIKLY_URL', plugins_url( '/', __FILE__ ));

// Autoload classes
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

// Initialize the plugin
add_action('plugins_loaded', function() {
    // Check if Elementor is installed and activated
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function() {
            $message = sprintf(
                esc_html__('Brikly requires %1$s to be installed and activated. %2$s', 'brikly'),
                '<strong>Elementor</strong>',
                '<a href="' . esc_url(admin_url('plugin-install.php?s=Elementor&tab=search&type=term')) . '">Install Elementor</a>'
            );
            printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
        });
        return;
    }

    // Initialize plugin
    \Brikly\Plugin::instance();
});