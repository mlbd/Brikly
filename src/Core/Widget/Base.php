<?php

namespace Brikly\Core\Widget;

use Elementor\Widget_Base;

abstract class Base extends Widget_Base {
    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['brikly'];
    }

    /**
     * Widget Model instance.
     *
     * @var object|null
     */
    protected $model = null;

    /**
     * Widget View instance.
     *
     * @var object|null
     */
    protected $view = null;

    /**
     * Initialize widget with MVC components.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    
        $original_class = get_class($this);
    
        $model_class = str_replace('\\Widget\\', '\\Model\\', $original_class);
        $view_class  = str_replace('\\Widget\\', '\\View\\', $original_class);
    
        // Avoid recursion: don't instantiate if the class name didn't actually change
        if ($model_class !== $original_class && class_exists($model_class)) {
            $this->model = new $model_class();
        }
    
        if ($view_class !== $original_class && class_exists($view_class)) {
            $this->view = new $view_class();
        }
    }
    

    /**
     * Get widget controls.
     *
     * @return array
     */
    protected function get_widget_controls() {
        $controls = [];
        
        if ($this->model && method_exists($this->model, 'get_controls')) {
            $controls = $this->model->get_controls();
        }
        
        // Allow controls to be filtered
        return apply_filters('brikly/widget/' . $this->get_name() . '/controls', $controls);
    }

    /**
     * Register widget controls.
     *
     * @return void
     */
    protected function register_controls() {
        $controls = $this->get_widget_controls();
        
        foreach ($controls as $section_id => $section) {
            $this->start_controls_section($section_id, [
                'label' => $section['label'] ?? '',
                'tab' => $section['tab'] ?? \Elementor\Controls_Manager::TAB_CONTENT,
            ]);

            foreach ($section['controls'] ?? [] as $control_id => $control) {
                $this->add_control($control_id, $control);
            }

            $this->end_controls_section();
        }
    }

    /**
     * Render widget output.
     *
     * @return void
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Allow settings to be filtered
        $settings = apply_filters('brikly/widget/' . $this->get_name() . '/settings', $settings);
        
        if ($this->view && method_exists($this->view, 'render')) {
            $this->view->render($settings);
        }
    }
}