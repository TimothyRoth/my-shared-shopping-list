'use strict';

const initOpenSidebar = () => {
    const button = jQuery('.trigger-sidebar');
    const sidebar = jQuery('.side-bar');
    const sidebarContent = jQuery('.side-bar-content');

    button.on('click', () => {
        sidebar.toggleClass('active');
        sidebarContent.toggleClass('active');
    });

    jQuery('body').on('click', (e) => {
        if(e.target !== button[0] && !sidebarContent[0].contains(e.target)) {
            sidebar.removeClass('active');
            sidebarContent.removeClass('active');
        }
    });
};

module.exports = {
    initOpenSidebar
}