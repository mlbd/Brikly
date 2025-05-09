<?php

namespace Brikly\Widgets\InfoBox;

use Brikly\Core\Widget\Base;
use Elementor\Controls_Manager;

class Widget extends Base {
    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'brikly_info_box';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Info Box', 'brikly');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-info-box';
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['info', 'box', 'icon', 'image'];
    }
}