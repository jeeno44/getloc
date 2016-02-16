$(function () {

    $("#quick-search").autocomplete({
        source: "/sites",
        minLength: 1,
        select: function(event, ui) {
            console.log(ui);
            window.location.href = '/site/' + ui.item.key;
        }
    });

});