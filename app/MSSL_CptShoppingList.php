<?php

namespace app;

use Wp_Query;

class MSSL_CptShoppingList
{
    public string $Cpt_ShoppingList;

    public string $Cpt_ListItemStatus;

    public function __construct()
    {
        $this->Cpt_ShoppingList = 'plugin_shopping_list';
        $this->Cpt_ListItemStatus = 'status';
    }

    public function init(): void
    {
        add_action('init', [$this, 'register_cpt_shopping_list']);
    }

    public function get_post_by_title($title): WP_Query
    {
        $normalized_title = strtolower($title);

        $args = [
            'post_type' => $this->Cpt_ShoppingList,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'title' => $normalized_title
        ];

        return new WP_Query($args);
    }

    public function register_cpt_shopping_list(): void
    {

        $labels = [
            'name' => _x('Lebensmittel', 'post type general name', 'shared_shopping_list'),
            'singular_name' => _x('Lebensmittel', 'post type singular name', 'shared_shopping_list'),
            'add_new' => _x('Hinzufügen', 'Lebensmittel hinzufügen', 'shared_shopping_list'),
            'add_new_item' => __('Neuen Lebensmittel hinzufügen', 'shared_shopping_list'),
            'edit_item' => __('Lebensmittel bearbeiten', 'shared_shopping_list'),
            'new_item' => __('Neuer Lebensmittel', 'shared_shopping_list'),
            'menu_name' => __('Einkaufsliste', 'shared_shopping_list'),
            'view_item' => __('Lebensmittel anzeigen', 'shared_shopping_list'),
            'search_items' => __('Nach Lebensmitteln suchen', 'shared_shopping_list'),
            'not_found' => __('Keine Lebensmittel gefunden', 'shared_shopping_list'),
            'not_found_in_trash' => __('Keine Lebensmittel im Papierkorb', 'shared_shopping_list'),
            'parent_item_colon' => ''
        ];

        $args = [
            'label' => __('Einkaufsliste', 'shared_shopping_list'),
            'description' => __('Teile deine Einkaufsliste', 'shared_shopping_list'),
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-list-view',
            'menu_position' => 2,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            '_builtin' => false,
            'query_var' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true
        ];

        register_post_type($this->Cpt_ShoppingList, $args);

    }

    public function insert_post($title): int
    {
        return wp_insert_post([
            'post_title' => $title,
            'post_type' => $this->Cpt_ShoppingList,
            'post_status' => 'publish',
        ]);
    }

    public function update_post($post_id, $title): int
    {

        return wp_update_post([
            'ID' => $post_id,
            'post_title' => $title,
        ]);
    }

}
