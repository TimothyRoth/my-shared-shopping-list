<?php

namespace app;
class MSSL_Installation
{

    private static string $shortcode_name = 'mssl_shopping_list';
    private static string $class_name = 'MSSL';

    public function init(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'load_plugin_scripts']);
        add_filter('body_class', [$this, 'add_body_class_to_plugin_page']);
    }

    public function load_plugin_scripts(): void
    {

        $plugin_meta_data = [
          'plugin_directory' => MSSL_PLUGIN_URI
        ];

        if (!is_admin()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js', false, '3.6.1', true);
            wp_enqueue_script('jquery');

            wp_enqueue_script('mssl-bundle', MSSL_PLUGIN_URI . '/dist/main.min.js', ['wp-i18n'], '0.1', true);
            wp_enqueue_script('ajax', 'https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js', ['wp-i18n'], '0.1', true);
            wp_localize_script('mssl-bundle', 'ajax', ['url' => admin_url('admin-ajax.php')]);
            wp_localize_script('mssl-bundle', 'plugin_settings', $plugin_meta_data);
            wp_enqueue_style('mssl-main', MSSL_PLUGIN_URI . '/dist/main.min.css', [], '0.1', 'all');
        }
    }

    public function add_body_class_to_plugin_page($classes): array
    {
        global $post;

        if (isset($post) && has_shortcode($post->post_content, self::$shortcode_name)) {
            $classes[] = self::$class_name;
        }

        return $classes;
    }
}

