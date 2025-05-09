<?php

namespace Brikly\Core\Category;

class Manager {
    /**
     * Register Brikly category with Elementor.
     *
     * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
     * @return void
     */
    public function register_categories($elements_manager) {
        $elements_manager->add_category(
            'brikly',
            [
                'title' => esc_html__('Brikly', 'brikly'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
}