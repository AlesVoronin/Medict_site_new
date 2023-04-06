$(document).ready(function() {
    $('.accordeon .accordeon-head').on('click', my_func);
});
function my_func(){
    $('#accordeon .accordeon-hidden').not($(this).next());
    $(this).next().toggleClass("accordeon-active");
}
