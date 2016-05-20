var $root = jQuery('html, body');
jQuery('a').click(function() {
    var href = jQuery.attr(this,'href');
    $root.animate({
        scrollTop: jQuery(href).offset().top
    }, 750, function () {
        window.location.hash = href;
    });
    return false;
});