'use strict';

const checkPluginPage = () => {
    const onPluginPage = jQuery('.MSSL').length > 0;
    return onPluginPage;
}

module.exports = {
    checkPluginPage
}