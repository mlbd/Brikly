<?php

namespace Brikly\Widgets\GoalTracker;

use Brikly\Core\Widget\Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

class Widget extends Base {
    /**
     * Get widget stylesheet.
     *
     * @return array Widget stylesheet.
     * @since 1.0.0
     **/
    public function get_script_depends() {
        return ['lottie-player', 'brikly-goal-tracker'];
    }

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'brikly_goal_tracker';
    }

    public function is_reload_preview_required() {
        return true;
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Interactive Goal Tracker', 'brikly');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-skill-bar';
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['goal', 'tracker', 'progress', 'animation', 'lottie'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'brikly'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'goal_title',
            [
                'label' => esc_html__('Goal Title', 'brikly'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('My Goal', 'brikly'),
            ]
        );

        $this->add_control(
            'current_progress',
            [
                'label' => esc_html__('Current Progress', 'brikly'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 0,
            ]
        );

        $this->add_control(
            'target_amount',
            [
                'label' => esc_html__('Target Amount', 'brikly'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
                'min' => 1,
            ]
        );

        $this->add_control(
            'lottie_url',
            [
                'label' => esc_html__('Lottie JSON URL', 'brikly'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com/lottie.json', 'brikly'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'animation_type',
            [
                'label' => esc_html__('Animation Type', 'brikly'),
                'type' => Controls_Manager::SELECT,
                'default' => 'loop',
                'options' => [
                    'loop' => esc_html__('Loop', 'brikly'),
                    'once' => esc_html__('Play Once', 'brikly'),
                ],
            ]
        );

        $this->add_control(
            'animation_direction',
            [
                'label' => esc_html__('Animation Direction', 'brikly'),
                'type' => Controls_Manager::SELECT,
                'default' => 'forward',
                'options' => [
                    'forward' => esc_html__('Forward', 'brikly'),
                    'reverse' => esc_html__('Reverse', 'brikly'),
                ],
            ]
        );

        $this->add_control(
            'trigger_event',
            [
                'label' => esc_html__('Trigger Animation On', 'brikly'),
                'type' => Controls_Manager::SELECT,
                'default' => 'view',
                'options' => [
                    'view' => esc_html__('When Widget is Viewed', 'brikly'),
                    'hover' => esc_html__('On Hover', 'brikly'),
                    'click' => esc_html__('On Click', 'brikly'),
                ],
            ]
        );

        $this->add_control(
            'event_repeater',
            [
                'label' => esc_html__('Repeat on Trigger', 'brikly'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'brikly'),
                'label_off' => esc_html__('No', 'brikly'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'animation_type' => 'once',
                ],
            ]
        );        

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'brikly'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'progress_bar_color',
            [
                'label' => esc_html__('Progress Bar Color', 'brikly'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4054b2',
                'selectors' => [
                    '{{WRAPPER}} .goal-tracker-progress-bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'progress_bar_height',
            [
                'label' => esc_html__('Progress Bar Height', 'brikly'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .goal-tracker-progress-bar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'brikly'),
                'selector' => '{{WRAPPER}} .goal-tracker-title',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $progress_percentage = ($settings['current_progress'] / $settings['target_amount']) * 100;
        $progress_percentage = min(100, max(0, $progress_percentage));

        ?>
        <div class="goal-tracker-widget">
            <h3 class="goal-tracker-title"><?php echo esc_html($settings['goal_title']); ?></h3>
            <div class="goal-tracker-progress">
                <span class="goal-tracker-amount">
                    <?php echo esc_html($settings['current_progress']); ?> / <?php echo esc_html($settings['target_amount']); ?>
                </span>
                <div class="goal-tracker-progress-bar-container">
                    <div class="goal-tracker-progress-bar" style="width: <?php echo esc_attr($progress_percentage); ?>%"></div>
                </div>
            </div>
            <?php if (!empty($settings['lottie_url']['url'])): ?>
            <div class="goal-tracker-lottie" 
                data-lottie-url="<?php echo esc_url($settings['lottie_url']['url']); ?>"
                data-animation-type="<?php echo esc_attr($settings['animation_type']); ?>"
                data-animation-direction="<?php echo esc_attr($settings['animation_direction']); ?>"
                data-progress="<?php echo esc_attr($progress_percentage); ?>"
                data-trigger-event="<?php echo esc_attr($settings['trigger_event']); ?>"
                data-event-repeater="<?php echo esc_attr($settings['event_repeater']); ?>"
                style="min-height: 200px;">
            </div>
            <?php else: ?>
            <div class="goal-tracker-no-animation">
                <?php echo esc_html__('Please provide a Lottie animation URL in the widget settings.', 'brikly'); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
}