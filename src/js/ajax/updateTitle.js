'use strict';

const {inputLimiter} = require("../lib/inputLimiter");
const {renderInfoMessage} = require("../view/renderInfoMessage");
const initUpdateTitle = () => {

    jQuery('body').on('keyup', '.update-title', inputLimiter(function (e) {
        e.preventDefault();
        const titleField = jQuery(this);

        let meta = {
            id: titleField.attr('data-src'),
            title: titleField.val(),
        }
        updateTitle(meta);
    }, 300));
}

const updateTitle = meta => {

    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_update_title',
            item: meta.id,
            title: meta.title,
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
    initUpdateTitle
}

