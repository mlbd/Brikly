<?php

namespace Brikly\Core\Widget;

class Manager {
    /**
     * Registered widgets.
     *
     * @var array
     */
    private $widgets = [];

    /**
     * Manager constructor.
     */
    public function __construct() {
        $this->init_widgets();
    }

    /**
     * Initialize default widgets.
     *
     * @return void
     */
    private function init_widgets() {
        // Hook for registering widgets
        do_action('brikly/widgets/register', $this);
    }

    /**
     * Register a new widget.
     *
     * @param string $widget_class Widget class name.
     * @return void
     */
    public function register_widget($widget_class) {
        if (class_exists($widget_class)) {
            $this->widgets[] = $widget_class;
        }
    }

    /**
     * Register widgets with Elementor.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     * @return void
     */
    public function register_widgets($widgets_manager) {
        foreach ($this->widgets as $widget) {
            // Allow widget registration to be filtered
            $widget = apply_filters('brikly/widget/register', $widget);
            
            if ($widget) {
                $widgets_manager->register(new $widget());
            }
        }
    }
}