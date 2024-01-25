'use strict';

/*
* Import Modules
* */

const {renderShoppingList} = require("./view/renderShoppingList");
const {initAddItem} = require("./ajax/addItem");
const {initDeleteItem} = require("./ajax/deleteItem");
const {initUpdateStatus} = require("./ajax/updateStatus");
const {initUpdateDescription} = require("./ajax/updateDescription");
const {initShowMetaData} = require("./functions/showMetaData");
const {initUpdateTitle} = require("./ajax/updateTitle");
const {initLoadArticleSuggestions} = require("./ajax/loadArticleSuggestions");

jQuery(document).ready(function () {
    initAddItem();
    renderShoppingList();
    initDeleteItem();
    initUpdateDescription();
    initUpdateStatus();
    initShowMetaData();
    initUpdateTitle();
    initLoadArticleSuggestions();
})
