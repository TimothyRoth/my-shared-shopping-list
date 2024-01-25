'use strict';

const {renderInfoMessage} = require("../view/renderInfoMessage");
const {articleSuggestions} = require("./loadArticleSuggestions");
const initDeleteArticle = () => {
    jQuery('body').on('click', '.delete-article-from-list', function (e) {
        e.preventDefault();
        const id = jQuery(this).attr('data-src');
        jQuery(this).parent().addClass('deleted');
        deleteArticle(id);
    });
};

const deleteArticle = id => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_delete_item',
            item: id,
        }, beforeSend: function () {
            // Show loader or loading state if needed
        }, success: function (data) {
            const searchBar = jQuery('input[name="add-item"]');
            articleSuggestions(searchBar.val());
            renderInfoMessage(data.message);
        }, complete: function () {
            // Hide loader or loading state if needed
        }
    });
};

module.exports = {
    initDeleteArticle
}