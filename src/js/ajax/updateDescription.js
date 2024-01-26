'use strict';

const {inputLimiter} = require("../lib/inputLimiter");
const {renderInfoMessage} = require("../view/renderInfoMessage");
const initUpdateDescription = () => {

    jQuery('body').on('keyup', '.update-description', inputLimiter(function (e) {
        e.preventDefault();
        const descriptionField = jQuery(this);

        let meta = {
            id: descriptionField.attr('data-src'),
            description: descriptionField.val(),
        }
        updateDescription(meta);
    }, 300));
}

const updateDescription = meta => {

    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_update_description',
            item: meta.id,
            description: meta.description,
        }, beforeSend: function () {
            // Show loader or loading state if needed
        }, success: function (data) {
            renderInfoMessage(data.message);
        }, complete: function () {
            // Hide loader or loading state if needed
        }
    });
}

module.exports = {
    initUpdateDescription
}

