'use strict';

const {inputLimiter} = require("../lib/inputLimiter");
const {renderShoppingList} = require("../view/renderShoppingList");
const initShowMetaData = () => {

    jQuery('body').on('click', '.show-popup',function (e) {
        e.preventDefault();
        const popup = jQuery(this).next('.item-meta-data');
        popup.addClass('show');
    });

    jQuery('body').on('click', '.close-popup', function (e) {
        e.preventDefault();
        jQuery('.item-meta-data').removeClass('show');
        renderShoppingList();
    });
};

module.exports = {
    initShowMetaData
}