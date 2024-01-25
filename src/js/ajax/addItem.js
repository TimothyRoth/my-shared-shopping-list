'use strict';

const {renderShoppingList} = require("../view/renderShoppingList");
const {renderInfoMessage} = require("../view/renderInfoMessage");
const {inputLimiter} = require("../lib/inputLimiter");

const initAddItem = () => {
    const addItemButton = jQuery('#add-item-button');
    addItemButton.on('click', function (e) {
        e.preventDefault();
        const inputField = jQuery('input[name="add-item"]')
        addItem(inputField.val());
    });
}

const addItem = title => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_add_item',
            title: title,
        }, beforeSend: function () {
            // Show loader or loading state if needed
        }, success: function (data) {
            const inputField = jQuery('input[name="add-item"]');
            inputField.val('');
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
    initAddItem,
    addItem
}

