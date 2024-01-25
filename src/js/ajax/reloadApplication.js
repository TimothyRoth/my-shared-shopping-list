'use strict';

const {renderShoppingList} = require("../view/renderShoppingList");
const {renderInfoMessage} = require("../view/renderInfoMessage");

const initReloadApplication = () => {

    const reloadApplicationButton = jQuery('.refresh-application');
    reloadApplicationButton.on('click', function (e) {
        e.preventDefault();
        renderShoppingList();
        renderInfoMessage('Die Liste wurde aktualisiert und ist jetzt auf dem neuesten Stand.');
    });
};

module.exports = {
    initReloadApplication
}