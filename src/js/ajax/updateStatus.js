'use strict';

const {inputLimiter} = require("../lib/inputLimiter");
const {renderShoppingList} = require("../view/renderShoppingList");
const {renderInfoMessage} = require("../view/renderInfoMessage");
const initUpdateStatus = () => {

    jQuery('body').on('click', '.check-item',function (e) {
        e.preventDefault();
        const item = jQuery(this).parent().attr('data-src');
        updateStatus(item);
    });
}

const updateStatus = item => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_update_item_status',
            item: item,
        }, beforeSend: function () {
            // Show loader or loading state if needed
        }, success: function (data) {
            renderInfoMessage(data.message);
            renderShoppingList();
        }, complete: function () {
            // Hide loader or loading state if needed
        }
    });
}

module.exports = {
    initUpdateStatus
}

