<?php

namespace Brikly\Widgets\TeamMember;

class View {
    /**
     * Render widget output on the frontend.
     *
     * @param array $settings Widget settings.
     * @return void
     */
    public function render($settings) {
        // Extract settings
        $name = $settings['name'] ?? '';
        $title = $settings['title'] ?? '';
        $bio = $settings['bio'] ?? '';
        $hover_animation = $settings['hover_animation'] ?? '';

        // Prepare animation class
        $animation_class = !empty($hover_animation) ? ' elementor-animation-' . esc_attr($hover_animation) : '';

        // Start wrapper
        echo '<div class="brikly-team-member' . $animation_class . '">';

        // Image with overlay
        if (!empty($settings['image']['url'])) {
            echo '<div class="brikly-team-member-image-wrapper">';
            echo '<div class="brikly-team-member-image">';
            echo '<img src="' . esc_url($settings['image']['url']) . '" alt="' . esc_attr($name) . '">';
            echo '</div>';
            echo '<div class="brikly-team-member-overlay">';
            
            // Social Icons in Overlay
            echo '<div class="brikly-team-member-social">';
            $social_networks = ['facebook', 'twitter', 'linkedin', 'instagram'];
            $social_icons = [
                'facebook' => 'fab fa-facebook-f',
                'twitter' => 'fab fa-twitter',
                'linkedin' => 'fab fa-linkedin-in',
                'instagram' => 'fab fa-instagram',
            ];

            foreach ($social_networks as $network) {
                if (!empty($settings[$network]['url'])) {
                    $target = !empty($settings[$network]['is_external']) ? ' target="_blank"' : '';
                    $nofollow = !empty($settings[$network]['nofollow']) ? ' rel="nofollow"' : '';
                    echo '<a href="' . esc_url($settings[$network]['url']) . '"' . $target . $nofollow . '>';
                    echo '<i class="' . esc_attr($social_icons[$network]) . '"></i>';
                    echo '</a>';
                }
            }
            echo '</div>'; // End social icons

            echo '</div>'; // End overlay
            echo '</div>'; // End image wrapper
        }

        // Content
        echo '<div class="brikly-team-member-content">';
        if (!empty($name)) {
            echo '<h3 class="brikly-team-member-name">' . esc_html($name) . '</h3>';
        }
        if (!empty($title)) {
            echo '<div class="brikly-team-member-title">' . esc_html($title) . '</div>';
        }
        if (!empty($bio)) {
            echo '<div class="brikly-team-member-bio">' . wp_kses_post($bio) . '</div>';
        }
        echo '</div>'; // End content

        echo '</div>'; // End wrapper
    }
}