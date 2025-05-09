<?php
/**
 * Template for the Heading widget.
 *
 * Variables available:
 * @var string $title The heading text
 * @var string $heading_type The HTML tag (h1-h6)
 * @var array $settings All widget settings
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<<?php echo esc_attr($heading_type); ?> class="brikly-heading">
    <?php echo wp_kses_post($title); ?>
</<?php echo esc_attr($heading_type); ?>>