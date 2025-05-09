<?php

namespace Brikly\Widgets\Heading;

class View {
    /**
     * Render widget output on the frontend.
     *
     * @param array $settings Widget settings.
     * @return void
     */
    public function render($settings) {
        // Allow template path to be filtered
        $template_path = apply_filters(
            'brikly/widget/heading/template_path',
            BRIKLY_PATH . 'templates/widgets/heading.php'
        );

        // Extract settings for easier access in template
        $title = $settings['title'] ?? '';
        $heading_type = $settings['heading_type'] ?? 'h2';

        // Allow data to be filtered before render
        $data = apply_filters('brikly/widget/heading/template_data', [
            'title' => $title,
            'heading_type' => $heading_type,
            'settings' => $settings,
        ]);

        // Check if custom template exists
        if (file_exists($template_path)) {
            extract($data);
            include $template_path;
            return;
        }

        // Fallback rendering if no template exists
        printf(
            '<%1$s class="brikly-heading">%2$s</%1$s>',
            esc_attr($heading_type),
            esc_html($title)
        );
    }
}