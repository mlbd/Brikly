<?php

namespace Brikly\Widgets\Heading;

use Brikly\Core\Widget\Base;
use Elementor\Controls_Manager;

class Widget extends Base {
    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'brikly_heading';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Brikly Heading', 'brikly');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-heading';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return parent::get_categories();
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['heading', 'title', 'text'];
    }
}