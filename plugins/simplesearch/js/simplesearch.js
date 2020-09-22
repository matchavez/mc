((function(){
    if (!Element.prototype.matches) {
        Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
    }
    var findAncestor = function(el, selector) {
        while ((el = el.parentElement) && !((el.matches || el.matchesSelector).call(el, selector))) {}
        return el;
    };

    var fields = document.querySelectorAll('input[name="searchfield"][data-search-input]');
    Array.prototype.forEach.call(fields, function(field) {
        var form = findAncestor(field, 'form[data-simplesearch-form]'),
            min = field.getAttribute('data-min') || false,
            location = field.getAttribute('data-search-input'),
            separator = field.getAttribute('data-search-separator');

        if (min) {
            var invalid = field.getAttribute('data-search-invalid');
            field.addEventListener('keydown', function() {
                field.setCustomValidity(field.value.length >= min ? '' : invalid);
            });
        }

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if (field.checkValidity()) {
                window.location.href = location + separator + field.value;
            }
        });
    });
})());
