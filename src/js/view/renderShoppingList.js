const renderShoppingList = () => {
  const shoppingListContainer = jQuery(".shopping-list");

  jQuery.ajax({
    url: ajax.url,
    method: "POST",
    dataType: "json",
    data: {
      action: "MSSL_render_shopping_list",
    },
    beforeSend: function () {
      // Show loader or loading state if needed
    },
    success: function (data) {
      shoppingListContainer.html(shoppingListView(data));
    },
    complete: function () {
      // Hide loader or loading state if needed
    },
  });
};

const shoppingListView = (data) => {
  const pluginDirectory = plugin_settings.plugin_directory;
  let html = "";

  for (let i = 0; i < data.length; i++) {
    const currentStatus = data[i].status;
    const deleteGroupButton = jQuery(".delete-group");

    deleteGroupButton.removeClass("show");
    if (currentStatus === "checked") deleteGroupButton.addClass("show");

    let checkItemImage = `<img src="${pluginDirectory}/assets/images/icons/unchecked-item.svg">`;

    if (currentStatus === "checked")
      checkItemImage = `<img src="${pluginDirectory}/assets/images/icons/checked-item.svg">`;

    html += `
            <div class="shopping-list-item ${currentStatus}" data-src="${data[i].id}">
            <div data-src="${data[i].id}" class="check-item">${checkItemImage}</div>
                <h3 class="show-popup">${data[i].title}<span class="short-description">${data[i].description}</span></h3>
                <div class="item-meta-data">
                   <div class="close-popup"><img src="${pluginDirectory}/assets/images/icons/modal-close.svg"></div>
                    <div class="inner-content">
                        <div class="item-title">
                            <input class="update-title" data-src="${data[i].id}" type="text" value="${data[i].title}">
                        </div>                    
                        <div class="item-description">
                            <textarea placeholder="Notizen..." class="update-description" data-src="${data[i].id}">${data[i].description}</textarea>                
                        </div>
                        <div class="last-time-changed">
                            <p>Zuletzt geändert: ${data[i].last_changed}</p>
                        </div>
                    </div>
                </div>
                <div data-src="${data[i].id}" class="delete-item"><img src="${pluginDirectory}/assets/images/icons/delete-item.svg"></div>
            </div>
        `;
  }
  return html;
};

module.exports = {
  renderShoppingList,
};
