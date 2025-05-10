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
    }

    public function register_widgets($widgets_manager) {
        $widget_manager = new WidgetManager();
        // Initialize Widget Manager
        $widget_manager->register_widgets($widgets_manager);
    }
}