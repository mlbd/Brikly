<?php

namespace Brikly\Widgets\Heading;

use Elementor\Controls_Manager;

class Model {
    /**
     * Get widget controls.
     *
     * @return array
     */
    public function get_controls() {
        return [
            'content_section' => [
                'label' => esc_html__('Content', 'brikly'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'controls' => [
                    'title' => [
                        'label' => esc_html__('Title', 'brikly'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Add Your Heading', 'brikly'),
                        'placeholder' => esc_html__('Enter your title', 'brikly'),
                        'label_block' => true,
                    ],
                    'heading_type' => [
                        'label' => esc_html__('HTML Tag', 'brikly'),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ],
                        'default' => 'h2',
                    ],
                ],
            ],
            'style_section' => [
                'label' => esc_html__('Style', 'brikly'),
                'tab' => Controls_Manager::TAB_STYLE,
                'controls' => [
                    'title_color' => [
                        'label' => esc_html__('Text Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-heading' => 'color: {{VALUE}};',
                        ],
                    ],
                    'typography' => [
                        'label' => esc_html__('Typography', 'brikly'),
                        'type' => Controls_Manager::TYPOGRAPHY,
                        'selector' => '{{WRAPPER}} .brikly-heading',
                    ],
                ],
            ],
        ];
    }
}