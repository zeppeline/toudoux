var $ = require('jQuery');
var err = require('../utils/errors.js');

var tasks = {
    'config': {
        'newTaskForm': 'newTaskForm',
        'newTaskBody': 'newTask',
        'newTaskDate': 'dueDate',
        'newTaskProject': 'project',
        'newTaskTags': 'newTaskTags'
    },
    'init': function() {
        console.log('tasks');
        this.getElements();
        this.setEvents();
    },
    'getElements': function() {
        // task creation elements
        this.newTaskForm = $('#' + this.config.newTaskForm);
        this.newTaskBody = $('#' + this.config.newTaskBody);
        this.newTaskDate = $('#' + this.config.newTaskDate);
        this.newTaskProject = $('#' + this.config.newTaskProject);
        this.newTaskTags = $('.' + this.config.newTaskTags);
        // task state change elements
    },
    'setEvents': function() {
        // Sets events
        this.newTaskForm.on('submit', this.e_createTask.bind(this));
    },
    // Events functions
    'e_createTask': function(e) {
        e.preventDefault();

        if(this.newTaskBody.val() == '') {
            err.validation(this.newTaskBody, 'The field is required.');
        } else {
            var task = {
                'body': this.newTaskBody.val(),
                'dueDate': this.newTaskDate.val(),
                'project_id': this.newTaskProject.val(),
                'tags': this.findNewTags()
            };

            console.log(task);

            var request = $.ajax('/api/tasks', {
                'method': 'POST',
                'headers': {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                },
                'data': this.newTaskForm.serialize()
            });

            request.done(function(response, textStatus, jqXHR) {
                console.log("youpi");
                console.log(response, textStatus, jqXHR);
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error('snif');
                console.log(textStatus, errorThrown);
            });
        }
    },
    // Other methods
    'findNewTags': function() {
        return this.newTaskTags.parent().find(':checked').map(function() {
            return this.value;
        }).get();
    }
};

module.exports = tasks;
