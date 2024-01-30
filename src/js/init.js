'use strict';

/*
* Import Modules
* */

const {checkPluginPage} = require("./functions/checkPluginPage");
const {renderShoppingList} = require("./view/renderShoppingList");
const {initAddItem} = require("./ajax/addItem");
const {initDeleteItem} = require("./ajax/deleteItem");
const {initDeleteItems} = require("./ajax/deleteItems");
const {initDeleteArticle} = require("./ajax/deleteArticle");
const {initUpdateStatus} = require("./ajax/updateStatus");
const {initUpdateDescription} = require("./ajax/updateDescription");
const {initShowMetaData} = require("./functions/showMetaData");
const {initUpdateTitle} = require("./ajax/updateTitle");
const {initLoadArticleSuggestions} = require("./ajax/loadArticleSuggestions");
const {initReloadApplication} = require("./ajax/reloadApplication");
const {initOpenSidebar} = require("./functions/openSidebar");
const {initLoadRecipes} = require("./ajax/loadRecipes");


/*
* Execute Functions
* */

jQuery(document).ready(function () {

    if (!checkPluginPage()) return 0;
    initAddItem();
    renderShoppingList();
    initDeleteItem();
    initDeleteItems();
    initUpdateDescription();
    initUpdateStatus();
    initShowMetaData();
    initUpdateTitle();
    initLoadArticleSuggestions();
    initDeleteArticle();
    initReloadApplication();
    initOpenSidebar();
    initLoadRecipes();
})
