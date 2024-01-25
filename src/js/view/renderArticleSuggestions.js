const renderArticleSuggestions = (data) => {

    const articleSuggestionsContainer = jQuery('.mssl-wrapper .article-suggestions');
    articleSuggestionsContainer.html('');

    if (data.length > 0) {
        for (let i = 0; i < data.length; i++) {
            articleSuggestionsContainer.append(`
                <li data-src="${data[i].id}" class="single-article-suggestion">${data[i].title}</li>
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

