const renderArticleSuggestions = (data) => {

    const articleSuggestionsContainer = jQuery('.mssl-wrapper .article-suggestions');
    const pluginDirectory = plugin_settings.plugin_directory;
    articleSuggestionsContainer.html('');

    if (data.length > 0) {
        for (let i = 0; i < data.length; i++) {
            articleSuggestionsContainer.append(`
                <li data-src="${data[i].id}" class="single-article-suggestion"><span class="list-item-title">${data[i].title}</span><img src="${pluginDirectory}/assets/images/icons/delete-article.svg"class="delete-article-from-list" data-src="${data[i].id}"></li>
            `);
        }
        return 0;
    }

    articleSuggestionsContainer.append(`
        <li class="no-results">Kein Datenbankeintrag gefunden.</li>
    `);
}

module.exports = {
    renderArticleSuggestions
}

