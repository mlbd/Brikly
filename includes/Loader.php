<?php
namespace Brikly\Includes;

class Loader {
    /**
     * Options instance.
     *
     * @var Loader|null
     */
    private static $instance = null;

    /**
     * Get Loader instance.
     *
     * @return Loader
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /*
    * Initialize the plugin.
    *
    * @return void
    */
    public function init() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_brikly-admin') {
            return;
        }

        $asset_file = include(plugin_dir_path(__DIR__) . 'build/index.asset.php');
        
        wp_enqueue_script(
            'brikly-admin',
            plugins_url('build/index.js', __DIR__),
            $asset_file['dependencies'],
            $asset_file['version'],
            true
        );

        wp_localize_script('brikly-admin', 'briklyWidgets', get_option('brikly_widgets_list', [
            ['name' => 'Team Member', 'icon' => 'eicon-person', 'enabled' => true],
            ['name' => 'Heading', 'icon' => 'eicon-heading', 'enabled' => true],
            ['name' => 'Info Box', 'icon' => 'eicon-info-box', 'enabled' => true]
        ]));
    }
}