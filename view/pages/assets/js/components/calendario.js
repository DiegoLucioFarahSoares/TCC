document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '2022-11-12',
        locale: 'pt-br',

        eventDidMount: function(info) {
            var tooltip = new Tooltip(info.el, {
                title: info.event.extendedProps.description,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        },

        events: [
            {
                title: 'Evento 1',
                description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                start: '2022-11-01'
            },
            {
                title: 'Evento 2',
                description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                start: '2022-11-15',
                end: '2022-11-25'
            }
        ]
    });

    calendar.render();
});