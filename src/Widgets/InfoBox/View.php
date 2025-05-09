<?php

namespace Brikly\Widgets\InfoBox;

class View {
    /**
     * Render widget output on the frontend.
     *
     * @param array $settings Widget settings.
     * @return void
     */
    public function render($settings) {
        // Extract settings
        $media_type = $settings['media_type'] ?? 'icon';
        $title = $settings['title'] ?? '';
        $description = $settings['description'] ?? '';
        $link = $settings['link'] ?? [];
        $hover_animation = $settings['hover_animation'] ?? '';

        // Prepare link attributes
        $link_attributes = '';
        if (!empty($link['url'])) {
            $link_attributes .= ' href="' . esc_url($link['url']) . '"';
            if (!empty($link['is_external'])) {
                $link_attributes .= ' target="_blank"';
            }
            if (!empty($link['nofollow'])) {
                $link_attributes .= ' rel="nofollow"';
            }
        }

        // Prepare animation class
        $animation_class = !empty($hover_animation) ? ' elementor-animation-' . esc_attr($hover_animation) : '';

        // Start wrapper
        echo '<div class="brikly-info-box' . $animation_class . '">';

        // Render link opening tag if URL is set
        if (!empty($link['url'])) {
            echo '<a class="brikly-info-box-link"' . $link_attributes . '>';
        }

        // Render media (icon or image)
        echo '<div class="brikly-info-box-media">';
        if ($media_type === 'icon' && !empty($settings['icon']['value'])) {
            echo '<div class="brikly-info-box-icon">';
            \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);
            echo '</div>';
        } elseif ($media_type === 'image' && !empty($settings['image']['url'])) {
            echo '<div class="brikly-info-box-image">';
            echo '<img src="' . esc_url($settings['image']['url']) . '" alt="' . esc_attr($title) . '">';
            echo '</div>';
        }
        echo '</div>';

        // Render content
        echo '<div class="brikly-info-box-content">';
        if (!empty($title)) {
            echo '<h3 class="brikly-info-box-title">' . esc_html($title) . '</h3>';
        }
        if (!empty($description)) {
            echo '<div class="brikly-info-box-description">' . wp_kses_post($description) . '</div>';
        }
        echo '</div>';

        // Close link tag if URL was set
        if (!empty($link['url'])) {
            echo '</a>';
        }

        // Close wrapper
        echo '</div>';
    }
}