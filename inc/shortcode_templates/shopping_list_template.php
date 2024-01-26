<?php

use  app\MSSL_CptShoppingList as CptShoppingList;

$post_type = new CptShoppingList();

$post_type_args = [
    'post_type' => $post_type->Cpt_ShoppingList,
    'posts_per_page' => 5,
]; ?>

<div class="mssl-wrapper">

    <div class="app-menu">
        <div class="refresh-application"><img src="<?= MSSL_PLUGIN_URI ?>/assets/images/icons/update-arrows.svg"></div>
    </div>

    <div class="delete-group"><img src="<?= MSSL_PLUGIN_URI ?>/assets/images/icons/delete-item.svg"></div>
    
    <div class="add-item-row">
        <input type="text" id="add-item" name="add-item" placeholder="Artikel hinzufügen">
        <div id="add-item-button">+</div>
        <div class="article-suggestion-wrapper"><ul class="article-suggestions"></ul></div>
    </div>

    <div class="content">
        <div class="message-container"></div>
        <div class="shopping-list"></div>
    </div>
</div>

