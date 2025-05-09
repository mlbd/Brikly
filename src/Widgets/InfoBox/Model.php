<?php

namespace Brikly\Widgets\InfoBox;

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
                    'media_type' => [
                        'label' => esc_html__('Media Type', 'brikly'),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            'icon' => [
                                'title' => esc_html__('Icon', 'brikly'),
                                'icon' => 'eicon-font-awesome',
                            ],
                            'image' => [
                                'title' => esc_html__('Image', 'brikly'),
                                'icon' => 'eicon-image',
                            ],
                        ],
                        'default' => 'icon',
                        'toggle' => false,
                    ],
                    'icon' => [
                        'label' => esc_html__('Icon', 'brikly'),
                        'type' => Controls_Manager::ICONS,
                        'default' => [
                            'value' => 'fas fa-star',
                            'library' => 'solid',
                        ],
                        'condition' => [
                            'media_type' => 'icon',
                        ],
                    ],
                    'image' => [
                        'label' => esc_html__('Image', 'brikly'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => '',
                        ],
                        'condition' => [
                            'media_type' => 'image',
                        ],
                    ],
                    'title' => [
                        'label' => esc_html__('Title', 'brikly'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Info Box Title', 'brikly'),
                        'placeholder' => esc_html__('Enter your title', 'brikly'),
                        'label_block' => true,
                    ],
                    'description' => [
                        'label' => esc_html__('Description', 'brikly'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => esc_html__('Add your description here', 'brikly'),
                        'placeholder' => esc_html__('Enter your description', 'brikly'),
                        'rows' => 5,
                    ],
                    'link' => [
                        'label' => esc_html__('Link', 'brikly'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => esc_html__('https://your-link.com', 'brikly'),
                        'show_external' => true,
                        'default' => [
                            'url' => '',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                ],
            ],
            'style_section' => [
                'label' => esc_html__('Style', 'brikly'),
                'tab' => Controls_Manager::TAB_STYLE,
                'controls' => [
                    'icon_size' => [
                        'label' => esc_html__('Icon Size', 'brikly'),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => ['px'],
                        'range' => [
                            'px' => [
                                'min' => 10,
                                'max' => 300,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .brikly-info-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .brikly-info-box-icon img' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ],
                    'icon_color' => [
                        'label' => esc_html__('Icon Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-info-box-icon i' => 'color: {{VALUE}};',
                        ],
                        'condition' => [
                            'media_type' => 'icon',
                        ],
                    ],
                    'title_color' => [
                        'label' => esc_html__('Title Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-info-box-title' => 'color: {{VALUE}};',
                        ],
                    ],
                    'description_color' => [
                        'label' => esc_html__('Description Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-info-box-description' => 'color: {{VALUE}};',
                        ],
                    ],
                    'box_padding' => [
                        'label' => esc_html__('Padding', 'brikly'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%', 'em'],
                        'selectors' => [
                            '{{WRAPPER}} .brikly-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    'hover_animation' => [
                        'label' => esc_html__('Hover Animation', 'brikly'),
                        'type' => Controls_Manager::HOVER_ANIMATION,
                    ],
                ],
            ],
        ];
    }
}