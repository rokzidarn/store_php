$(document).ready(function () {
    $('#browse').hide();
    $('#click').click(function (evt) {
        evt.preventDefault();
        $('#browse').slideToggle(300);
        $('#ri_box').toggle();
        $('#li_box').toggle();
    });
});