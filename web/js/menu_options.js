jQuery(document).ready(function() {
    var $wrapper = $('.menu-options-wrapper');
    $wrapper.on('click', '.option-remove', function(e) {
        e.preventDefault();
        $(this).closest('.menu-options-item')
            .fadeOut()
            .remove();
    });
    $wrapper.on('click', '.menu-options-add', function(e) {
        e.preventDefault();
        var prototype = $wrapper.data('prototype');
        var index = $wrapper.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        $wrapper.data('index', index + 1);
        $(this).before(newForm);
    });
});
