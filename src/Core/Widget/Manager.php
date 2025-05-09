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
        $widgets_path = __DIR__ . '/../../Widgets/';
        $base_namespace = 'Brikly\\Widgets\\';

        // Scan all directories inside Widgets
        foreach (glob($widgets_path . '*', GLOB_ONLYDIR) as $widget_dir) {
            $widget_name = basename($widget_dir);
            $widget_file = $widget_dir . '/Widget.php';

            if (file_exists($widget_file)) {
                require_once $widget_file;

                $class = $base_namespace . $widget_name . '\\Widget';

                if (class_exists($class)) {
                    $widget_instance = new $class();

                    // Ensure it extends Elementor\Widget_Base
                    if (is_subclass_of($widget_instance, \Elementor\Widget_Base::class)) {
                        $widgets_manager->register($widget_instance);
                    }
                }
            }
        }
    }
}