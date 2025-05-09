<?php

namespace Brikly;

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
        $this->init_components();
        $this->init_hooks();
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
        add_action('elementor/widgets/register', [$this->widget_manager, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this->category_manager, 'register_categories']);
    }

    /**
     * Get Widget Manager instance.
     *
     * @return WidgetManager
     */
    public function widget_manager() {
        return $this->widget_manager;
    }
}