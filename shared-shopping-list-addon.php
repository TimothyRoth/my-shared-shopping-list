<?php

/**
 * Plugin Name: shared shopping list for WordPress
 * Plugin URI: www.timothy-roth.de
 * Description: Share your shopping list with your friends and family
 * Version: 1.0.0
 * Author: Timothy Roth
 * Author URI: www.timothy-roth.de
 * License: GPL2
 * Text Domain: shared_shopping_list
 * Domain Path: /languages
 */

define('MSSL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MSSL_PLUGIN_URI', plugin_dir_url(__FILE__));
define('MSSL_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('MSSL_PLUGIN_FILE_PATH', __FILE__);

load_plugin_textdomain('shared_shopping_list', FALSE, basename(__DIR__) . '/languages/');

spl_autoload_register(static function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    $class_file = MSSL_PLUGIN_PATH . $class_name . '.php';
    if (file_exists($class_file)) {
        include $class_file;
    }
});

// Initialize instances of app
$instances = [
    'app\MSSL_Installation',
    'app\MSSL_CptShoppingList',
    'app\MSSL_CptArticleLib',
    'app\MSSL_Ajax',
    'app\MSSL_Shortcodes',
];

foreach ($instances as $instance_name) {
    ${$instance_name} = new $instance_name();
    ${$instance_name}->init();
}


