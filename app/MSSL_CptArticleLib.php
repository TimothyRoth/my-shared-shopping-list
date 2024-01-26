<?php

namespace app;

use Wp_Query;

class MSSL_CptArticleLib
{
    public string $Cpt_ArticleLib;

    public function __construct()
    {
        $this->Cpt_ArticleLib = 'mssl_article_lib';
    }

    public function init(): void
    {
        add_action('init', [$this, 'register_cpt_article_lib']);
    }

    public function register_cpt_article_lib(): void
    {

        $labels = [
            'name' => _x('Artikel', 'post type general name', 'shared_shopping_list'),
            'singular_name' => _x('Artikel', 'post type singular name', 'shared_shopping_list'),
            'add_new' => _x('Hinzufügen', 'Artikel hinzufügen', 'shared_shopping_list'),
            'add_new_item' => __('Neuen Artikel hinzufügen', 'shared_shopping_list'),
            'edit_item' => __('Artikel bearbeiten', 'shared_shopping_list'),
            'new_item' => __('Neuer Artikel', 'shared_shopping_list'),
            'menu_name' => __('Artikelliste', 'shared_shopping_list'),
            'view_item' => __('Artikel anzeigen', 'shared_shopping_list'),
            'search_items' => __('Nach Artikeln suchen', 'shared_shopping_list'),
            'not_found' => __('Keine Artikel gefunden', 'shared_shopping_list'),
            'not_found_in_trash' => __('Keine Artikel im Papierkorb', 'shared_shopping_list'),
            'parent_item_colon' => ''
        ];

        $args = [
            'label' => __('Artikelliste', 'shared_shopping_list'),
            'description' => __('Teile deine Artikelliste', 'shared_shopping_list'),
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-list-view',
            'menu_position' => 3,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'publicly_queryable' => false,
            'has_archive' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            '_builtin' => false,
            'query_var' => true,
            'supports' => ['title'],
        ];

        register_post_type($this->Cpt_ArticleLib, $args);

    }

    public function get_post_by_title($title): WP_Query
    {
        $normalized_title = strtolower($title);

        $args = [
            'post_type' => $this->Cpt_ArticleLib,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'title' => $normalized_title
        ];

        return new WP_Query($args);
    }

    public function insert_post($title): int
    {
        return wp_insert_post([
            'post_title' => $title,
            'post_type' => $this->Cpt_ArticleLib,
            'post_status' => 'publish'
        ]);
    }

    public function synchronize_article_database($title): void
    {
        if ((!$this->get_post_by_title($title)->found_posts) > 0) {
            $this->insert_post($title);
        }
    }

    public function find_article_in_shopping_list(string $title): bool
    {
        $shopping_list = new MSSL_CptShoppingList();
        return $shopping_list->get_post_by_title($title)->found_posts > 0;
    }

    public function get_articles_by_name($search): array
    {
        $response = [];

        $args = [
            'post_type' => $this->Cpt_ArticleLib,
            's' => $search,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        foreach ($query->posts as $article) {

            if ($this->find_article_in_shopping_list($article->post_title)) {
                continue;
            }

            $response[] = [
                'id' => $article->ID,
                'title' => $article->post_title
            ];
        }

        return $response;

    }

}
