<?php

namespace app;
class MSSL_Shortcodes
{

    public function init(): void
    {
        add_shortcode('mssl_shopping_list', [$this, 'shared_shopping_list_shortcode']);
    }

    public function shared_shopping_list_shortcode(): false|string
    {
        ob_start();
        require_once MSSL_PLUGIN_PATH . '/inc/shortcode_templates/shopping_list_template.php';
        return ob_get_clean();
    }

}