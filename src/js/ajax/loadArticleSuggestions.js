'use strict';

const {inputLimiter} = require("../lib/inputLimiter");
const {renderArticleSuggestions} = require("../view/renderArticleSuggestions");
const {addItem} = require("../ajax/addItem");
const initLoadArticleSuggestions = () => {

    const searchBar = jQuery('input[name="add-item"]');
    const articleSuggestionWrapper = jQuery('.article-suggestion-wrapper');

    searchBar.on('keyup', inputLimiter(function (e) {
        e.preventDefault();
        const search = jQuery(this).val();
        articleSuggestions(search);
    }, 300));

    jQuery('body').on('click', function (e) {
        e.preventDefault();

        console.log(e.target)
        if (e.target === searchBar[0]) {
            const search = jQuery(this).val();
            articleSuggestionWrapper.addClass('show');
            articleSuggestions(search);
            return 0;
        }

        articleSuggestionWrapper.removeClass('show');
    });

    jQuery('body').on('click', '.single-article-suggestion', function (e) {
        e.preventDefault();
        const item = jQuery(this).html();
        addItem(item);
    });
}

const articleSuggestions = search => {
    jQuery.ajax({
        url: ajax.url, method: 'POST', dataType: 'json', data: {
            action: 'MSSL_show_article_suggestions',
            search: search,
        }, beforeSend: function () {
            // Show loader or loading state if needed
        }, success: function (data) {
            renderArticleSuggestions(data);
        }, complete: function () {
            // Hide loader or loading state if needed
        }
    });
}

module.exports = {
    initLoadArticleSuggestions
}

