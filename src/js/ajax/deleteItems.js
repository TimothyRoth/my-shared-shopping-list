'use strict';

const {renderShoppingList} = require("../view/renderShoppingList");
const {renderInfoMessage} = require("../view/renderInfoMessage");

const initDeleteItems = () => {

    const deleteButton = jQuery('.delete-group img');
    deleteButton.on('click', function (e) {
        e.preventDefault();
        deleteItems(getCheckedItems());
    });
}

const getCheckedItems = () => {
    const items = [];
    jQuery('.shopping-list-item.checked').each(function () {
        items.push(jQuery(this).attr('data-src'));
    });
    return items;
}
const deleteItems = items => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_delete_items',
            items: items,
        }, beforeSend: function () {
            // Show loader or loading state if needed
        }, success: function (data) {
            renderInfoMessage(data.message);
            if (data.status === 'success') {
                renderShoppingList();
            }
        }, complete: function () {
            // Hide loader or loading state if needed
        }
    });
}

module.exports = {
    initDeleteItems
}

