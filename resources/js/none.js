require('./bootstrap');

$(function () {
    $("a[href$='destroy']").click(function (event) {
        event.preventDefault();

        confirmKey = $('#confirm-key').html();
        confirmValue = this.title.substr(8);
        url = this.href.replace(/\/destroy$/g,'');

        if(confirmKey === undefined) {
            console.error("confirm-key not found, please add a id to item have key value, ex: <th id=\"confirm-key\">something</th>.");
        }

        if(confirmValue === "") {
            console.error("confirm-value not found, please add it to a:title after Destroy, ex: title='Destroy something'");
        }

        destroyConfirm = $('#destroy-confirm');
        destroyConfirm.find('form').attr('action', url);
        destroyConfirm.find('#destroy-confirm-key').html(confirmKey);
        destroyConfirm.find('#destroy-confirm-value').html(confirmValue);
        destroyConfirm.modal('show');
    })
})