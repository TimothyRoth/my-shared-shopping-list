'use strict';

const initLoadRecipes = () => {
    const openButton = jQuery('.open-recipes');
    const closeButton = jQuery('.close-recipes');
    const recipePage = jQuery('.recipes');

    openButton.on('click', () => {
        recipePage.addClass('show');
    });

    closeButton.on('click', () => {
        recipePage.removeClass('show');
    });
}

module.exports = {
    initLoadRecipes
}