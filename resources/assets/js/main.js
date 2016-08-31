var $ = require('jQuery');

var t = {
    'init': function() {
        if( $('body').hasClass('tasks') ) {
            t.modules.tasks.init();
        }
    },
    'modules': {
        'tasks': require('./modules/tasks.js')
    }
};


$(window).on('load', t.init);
