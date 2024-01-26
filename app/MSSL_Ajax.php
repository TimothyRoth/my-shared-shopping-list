<?php

namespace app;

use app\enums\MSSL_CheckStatus as CheckStatus;
use app\MSSL_CptShoppingList as CptShoppingList;
use JsonException;
use WP_Query;

class MSSL_Ajax
{

    public function init(): void
    {
        add_action('wp_ajax_MSSL_add_item', [$this, 'MSSL_add_item']);
        add_action('wp_ajax_nopriv_MSSL_add_item', [$this, 'MSSL_add_item']);

        add_action('wp_ajax_MSSL_delete_item', [$this, 'MSSL_delete_item']);
        add_action('wp_ajax_nopriv_MSSL_delete_item', [$this, 'MSSL_delete_item']);

        add_action('wp_ajax_MSSL_delete_items', [$this, 'MSSL_delete_items']);
        add_action('wp_ajax_nopriv_MSSL_delete_items', [$this, 'MSSL_delete_items']);

        add_action('wp_ajax_MSSL_render_shopping_list', [$this, 'MSSL_render_shopping_list']);
        add_action('wp_ajax_nopriv_MSSL_render_shopping_list', [$this, 'MSSL_render_shopping_list']);

        add_action('wp_ajax_MSSL_update_description', [$this, 'MSSL_update_description']);
        add_action('wp_ajax_nopriv_MSSL_update_description', [$this, 'MSSL_update_description']);

        add_action('wp_ajax_MSSL_update_title', [$this, 'MSSL_update_title']);
        add_action('wp_ajax_nopriv_MSSL_update_title', [$this, 'MSSL_update_title']);

        add_action('wp_ajax_MSSL_update_item_status', [$this, 'MSSL_update_item_status']);
        add_action('wp_ajax_nopriv_MSSL_update_item_status', [$this, 'MSSL_update_item_status']);

        add_action('wp_ajax_MSSL_show_article_suggestions', [$this, 'MSSL_show_article_suggestions']);
        add_action('wp_ajax_nopriv_MSSL_show_article_suggestions', [$this, 'MSSL_show_article_suggestions']);
    }


    /**
     * @throws JsonException
     */
    public function MSSL_update_item_status(): void
    {
        $post_type = new CptShoppingList();
        $itemID = $_POST['item'];
        $current_status = get_post_meta($itemID, $post_type->Cpt_ListItemStatus, true);
        $title = get_the_title($itemID);

        $toggle_status = match ($current_status) {
            'unchecked' => CheckStatus::CHECKED->toString(),
            'checked' => CheckStatus::UNCHECKED->toString(),
        };

        $status_name = match ($toggle_status) {
            'unchecked' => '"ausstehend"',
            'checked' => '"erledigt"',
        };

        update_post_meta($itemID, $post_type->Cpt_ListItemStatus, $toggle_status);

        $response = [
            'status' => 'success',
            'message' => "Du hast {$title} als {$status_name} markiert."
        ];

        $this->return_json($response);
    }

    /**
     * @throws JsonException
     */
    public function MSSL_show_article_suggestions(): void
    {
        $article_lib = new MSSL_CptArticleLib();
        $search_string = $_POST['search'];
        $this->return_json($article_lib->get_articles_by_name($search_string));
    }

    /**
     * @throws JsonException
     */
    public function MSSL_update_description(): void
    {

        $itemID = $_POST['item'];
        $description = $_POST['description'];
        $title = get_the_title($itemID);

        $update_success = wp_update_post([
            'ID' => $itemID,
            'post_content' => $description
        ]);

        if ($update_success) {
            $response = [
                'status' => 'success',
                'message' => "{$title} wurde erfolgreich aktualisiert."
            ];
            $this->return_json($response);
        }

        $response = [
            'status' => 'error',
            'message' => "{$title} konnte nicht aktualisiert werden."
        ];
        $this->return_json($response);
    }

    /**
     * @throws JsonException
     */
    public function MSSL_update_title(): void
    {
        $shopping_list = new CptShoppingList();
        $article_lib = new MSSL_CptArticleLib();

        $itemID = $_POST['item'];
        $title = $_POST['title'];
        $previous_title = get_the_title($itemID);

        if ($title === '') {
            $response['message'] = 'Bitte gib einen Namen für deinen Artikel ein.';
            $this->return_json($response);
        }

        $check_for_duplicate_post = $shopping_list->get_post_by_title($title)->found_posts > 0;
        if ($check_for_duplicate_post) {
            $response = [
                'status' => 'error',
                'message' => "Ein Artikel mit dem Namen {$title} existiert bereits."
            ];

            $this->return_json($response);

        }

        $response = [
            'status' => $shopping_list->update_post($itemID, $title),
            'message' => "Du hast Artikel {$previous_title} erfolgreich zu {$title} geändert."
        ];

        $this->return_json($response);
    }

    /**
     * @throws JsonException
     */
    public function MSSL_add_item(): void
    {
        $shopping_list = new CptShoppingList();
        $title = $_POST['title'];

        if ($title === '') {
            $response['message'] = 'Bitte gib einen Namen für deinen Artikel ein.';
            $this->return_json($response);
        }

        $item_is_already_part_of_the_shopping_list = $shopping_list->get_post_by_title($title)->found_posts > 0;
        if ($item_is_already_part_of_the_shopping_list) {
            $response = [
                'status' => 'error',
                'message' => "Ein Artikel mit dem Namen {$title} existiert bereits."
            ];
            $this->return_json($response);
        }

        update_post_meta($shopping_list->insert_post($title), $shopping_list->Cpt_ListItemStatus, CheckStatus::UNCHECKED->toString());
        $response = [
            'status' => 'success',
            'message' => "{$title} wurde erfolgreich zu deiner Einkaufsliste hinzugefügt."
        ];

        $this->return_json($response);
    }

    /**
     * @throws JsonException
     */
    public function MSSL_delete_item(): void
    {
        $itemID = $_POST['item'];
        $title = get_the_title($itemID);
        $delete_success = wp_delete_post($itemID, true);

        if ($delete_success) {
            $response = [
                'status' => 'success',
                'message' => "Du hast {$title} erfolgreich von der Liste entfernt."
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => "{$title} konnte nicht von der Liste entfernt werden."
            ];
        }
        $this->return_json($response);
    }

    /**
     * @throws JsonException
     */
    public function MSSL_delete_items(): void
    {
        $itemID = $_POST['items'];

        foreach ($itemID as $id) {
            wp_delete_post($id, true);
        }

        $response = [
            'status' => 'success',
            'message' => "Du hast die ausgewählten Artikel erfolgreich von der Einkaufsliste entfernt."
        ];

        $this->return_json($response);
    }


    /**
     * @throws JsonException
     */
    public function MSSL_render_shopping_list(): void
    {
        $shopping_list = new CptShoppingList();
        $article_lib = new MSSL_CptArticleLib();

        $items = [];

        $args = [
            'post_type' => $shopping_list->Cpt_ShoppingList,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        foreach ($query->posts as $p) {

            $id = $p->ID;
            $title = $p->post_title;

            $article_lib->synchronize_article_database($title);

            $status = get_post_meta($id, $shopping_list->Cpt_ListItemStatus, true);


            $description = wp_strip_all_tags($p->post_content) ?? '';
            $thumbnail = get_the_post_thumbnail_url($p->ID) == true ? get_the_post_thumbnail_url($p->ID) : '';
            $last_changed = $p->post_modified;

            $items[] = [
                'id' => $id,
                'title' => $title,
                'status' => $status,
                'description' => $description,
                'thumbnail' => $thumbnail,
                'last_changed' => $last_changed,
            ];

        }

        $this->return_json($this->sortItemsByStatus($items));

    }

    /**
     * @throws JsonException
     */
    private function return_json($response): void
    {
        wp_die(json_encode($response, JSON_THROW_ON_ERROR));
    }

    private function sortItemsByStatus($items): array
    {
        $checkedItems = [];
        $uncheckedItems = [];

        foreach ($items as $item) {

            if ($item['status'] === CheckStatus::CHECKED->toString()) {
                $checkedItems[] = $item;
                continue;
            }

            $uncheckedItems[] = $item;

        }

        return array_merge($uncheckedItems, $checkedItems);
    }

}