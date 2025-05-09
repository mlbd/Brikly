<?php

namespace Brikly\Widgets\TeamMember;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

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
                    'image' => [
                        'label' => esc_html__('Member Image', 'brikly'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => '',
                        ],
                    ],
                    'name' => [
                        'label' => esc_html__('Name', 'brikly'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('John Doe', 'brikly'),
                        'placeholder' => esc_html__('Enter member name', 'brikly'),
                        'label_block' => true,
                    ],
                    'title' => [
                        'label' => esc_html__('Position', 'brikly'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('CEO', 'brikly'),
                        'placeholder' => esc_html__('Enter member position', 'brikly'),
                        'label_block' => true,
                    ],
                    'bio' => [
                        'label' => esc_html__('Bio', 'brikly'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => esc_html__('Enter member bio here', 'brikly'),
                        'placeholder' => esc_html__('Enter member bio', 'brikly'),
                        'rows' => 5,
                    ],
                    'social_links_heading' => [
                        'label' => esc_html__('Social Links', 'brikly'),
                        'type' => Controls_Manager::HEADING,
                        'separator' => 'before',
                    ],
                    'facebook' => [
                        'label' => esc_html__('Facebook', 'brikly'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => esc_html__('https://facebook.com/', 'brikly'),
                        'label_block' => true,
                    ],
                    'twitter' => [
                        'label' => esc_html__('Twitter', 'brikly'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => esc_html__('https://twitter.com/', 'brikly'),
                        'label_block' => true,
                    ],
                    'linkedin' => [
                        'label' => esc_html__('LinkedIn', 'brikly'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => esc_html__('https://linkedin.com/', 'brikly'),
                        'label_block' => true,
                    ],
                    'instagram' => [
                        'label' => esc_html__('Instagram', 'brikly'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => esc_html__('https://instagram.com/', 'brikly'),
                        'label_block' => true,
                    ],
                ],
            ],
            'style_section' => [
                'label' => esc_html__('Style', 'brikly'),
                'tab' => Controls_Manager::TAB_STYLE,
                'controls' => [
                    'image_size' => [
                        'label' => esc_html__('Image Size', 'brikly'),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => ['px', '%'],
                        'range' => [
                            'px' => [
                                'min' => 50,
                                'max' => 500,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .brikly-team-member-image img' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ],
                    'name_color' => [
                        'label' => esc_html__('Name Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-team-member-name' => 'color: {{VALUE}};',
                        ],
                    ],
                    'title_color' => [
                        'label' => esc_html__('Position Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-team-member-title' => 'color: {{VALUE}};',
                        ],
                    ],
                    'bio_color' => [
                        'label' => esc_html__('Bio Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-team-member-bio' => 'color: {{VALUE}};',
                        ],
                    ],
                    'social_icons_color' => [
                        'label' => esc_html__('Social Icons Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-team-member-social a' => 'color: {{VALUE}};',
                        ],
                    ],
                    'overlay_color' => [
                        'label' => esc_html__('Overlay Color', 'brikly'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .brikly-team-member-overlay' => 'background-color: {{VALUE}};',
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