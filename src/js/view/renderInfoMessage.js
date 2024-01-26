let timeoutID = null;

const renderInfoMessage = message => {

    const infoMessageContainer = jQuery('.message-container');
    infoMessageContainer.addClass('show-message');
    infoMessageContainer.html(message);

    if(timeoutID) {
        clearTimeout(timeoutID);
    }

    timeoutID = setTimeout(function () {
        infoMessageContainer.removeClass('show-message');
    }, 1500);

}

module.exports = {
    renderInfoMessage
}

