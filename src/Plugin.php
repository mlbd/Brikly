<?php

namespace Brikly;

use Brikly\Includes\Api;
use Brikly\Includes\Loader;
use Brikly\Admin\Options as OptionsManager;
use Brikly\Core\Widget\Manager as WidgetManager;
use Brikly\Core\Category\Manager as CategoryManager;

class Plugin {
    /**
     * Plugin instance.
     *
     * @var Plugin|null
     */
    private static $instance = null;

    /**
     * Widget Manager instance.
     *
     * @var WidgetManager|null
     */
    private $widget_manager = null;

    /**
     * Category Manager instance.
     *
     * @var CategoryManager|null
     */
    private $category_manager = null;

    /**
     * Get plugin instance.
     *
     * @return Plugin
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Plugin constructor.
     */
    private function __construct() {
        // Only initialize if Elementor is loaded and active
        if (defined('ELEMENTOR_PATH') && did_action('elementor/loaded')) {
            $this->init_components();
            $this->init_hooks();
            Api::instance()->init();
            Loader::instance()->init();
            OptionsManager::instance()->register();
        }
    }

    /**
     * Initialize plugin components.
     *
     * @return void
     */
    private function init_components() {
        // Initialize Widget Manager
        $this->widget_manager = new WidgetManager();

        // Initialize Category Manager
        $this->category_manager = new CategoryManager();
    }

    /**
     * Initialize plugin hooks.
     *
     * @return void
     */
    private function init_hooks() {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this->category_manager, 'register_categories']);
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_scripts']);
        add_action('elementor/preview/enqueue_scripts', [$this, 'register_scripts']);
    }

    public function register_scripts() {
        // Register Lottie Player
        wp_register_script(
            'lottie-player',
            'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js',
            [],
            '5.12.2',
            true
        );

        // Register Goal Tracker Widget Script
        wp_register_script(
            'brikly-goal-tracker',
            BRIKLY_URL . 'assets/frontend/widgets/goaltracker/goaltracker.js',
            ['jquery', 'lottie-player'],
            BRIKLY_VERSION,
            true
        );
    }

    public function register_widgets($widgets_manager) {
        $widget_manager = new WidgetManager();
        // Initialize Widget Manager
        $widget_manager->register_widgets($widgets_manager);
    }
}