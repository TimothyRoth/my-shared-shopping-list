<?php

class PLUGIN_Installation
{

    public function init(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'load_plugin_scripts']);
    }

    public function load_plugin_scripts(): void
    {
        if (!is_admin()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js', false, '3.6.1', true);
            wp_enqueue_script('jquery');

            wp_enqueue_script('plugin-bundle', MSSL_PLUGIN_URI . '/dist/main.min.js', ['wp-i18n'], '0.1', true);
            wp_enqueue_script('pw-script', 'https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js', ['wp-i18n'], '0.1', true);
            wp_localize_script('plugin-bundle', 'ajax', ['url' => admin_url('admin-ajax.php')]);
            wp_enqueue_style('plugin-main', MSSL_PLUGIN_URI . '/dist/main.min.css', [], '0.1', 'all');
        }
    }
}
