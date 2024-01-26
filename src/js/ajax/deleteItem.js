'use strict';

const {renderShoppingList} = require("../view/renderShoppingList");
const {renderInfoMessage} = require("../view/renderInfoMessage");

const initDeleteItem = () => {

    jQuery('body').on('click', '.delete-item', function (e) {
        e.preventDefault();
        const item = jQuery(this).attr('data-src');
        deleteItem(item);
    });
}

const deleteItem = id => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_delete_item',
            item: id,
        }, beforeSend: function () {
            // Show loader or loading state if needed
        }, success: function (data) {

            renderInfoMessage(data.message);
            if(data.status === 'success') {
                renderShoppingList();
            }
        }, complete: function () {
            // Hide loader or loading state if needed
        }
    });
}

module.exports = {
    initDeleteItem
}

