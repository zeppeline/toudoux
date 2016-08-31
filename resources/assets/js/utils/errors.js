var $ = require('jQuery');

var errors = {
    // create validation error message
    'validation': function(element, message = 'This field is required') {
        var $el = $(document.createElement('p'));
        $el.html(message);
        element.after($el);
        // todo: add classes & check if exist
    }
};

module.exports = errors;
