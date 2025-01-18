document.addEventListener('DOMContentLoaded', function () {
    const calendarDiv = document.getElementById('calendar');
    const dateModal = document.getElementById('dateModal');

    var timezoneDataset = calendarDiv.dataset.timezone;
    var firstDayDataset = calendarDiv.dataset.firstDay;

    const calendar = new FullCalendar.Calendar(calendarDiv, {
        firstDay: firstDayDataset,
        timeZone: timezoneDataset,
        initialView: 'dayGridMonth',
        dateClick: function (info) {
            var anchor = info.dayEl.querySelector(".fc-daygrid-day-number");
            anchor.href = baseUrlDataset + 'calendar/' + info.dateStr;
            window.location.href = anchor.href;
        },
        eventClick: function (info) {
            info.jsEvent.preventDefault(); 
            var date = moment(info.event.start).format('YYYY-MM-DD');

            var anchor = info.el;
            anchor.href = baseUrlDataset + 'calendar/' + date + '/' + info.event.id;
            window.location.href = anchor.href;
        },
        customButtons: {
            dateCustomButton: {
                text: 'Date',
                click: function () {
                    flatpickr("#dateInput", {
                        altInput: true,
                        altFormat: "Y-F",
                        dateFormat: "Y-m",
                    });
                }
            }
        },
        headerToolbar: {
            right: 'dateCustomButton today prev,next',
        }
    })
    calendar.render();


    loadCalendar(calendar, baseUrlDataset, calendar.getDate());

    var fcHeaderTollbar = document.querySelector('.fc-header-toolbar');
    fcHeaderTollbar.after(collapseDiv(calendar));

    var custumdDateButton = document.querySelector('.fc-dateCustomButton-button');
    custumdDateButton.setAttribute('data-bs-toggle', 'collapse');
    custumdDateButton.setAttribute('data-bs-target', '#collapseExample');
    custumdDateButton.setAttribute('aria-expanded', 'false');
    custumdDateButton.setAttribute('aria-controls', 'collapseExample');



    document.querySelector('.fc-next-button').addEventListener('click', function () {
        loadCalendar(calendar, baseUrlDataset, calendar.getDate());
    });

    document.querySelector('.fc-prev-button').addEventListener('click', function () {
        loadCalendar(calendar, baseUrlDataset, calendar.getDate());
    });

});




function loadCalendar(calendar, baseUrlDataset, date) {
    calendar.removeAllEvents();
    getAjax(baseUrlDataset + 'calendar?' + 'date=' + moment(date).format('YYYY-M'),
        function (output) {
            var jsonEvents = JSON.parse(output);
            console.log(jsonEvents);
            Object.values(jsonEvents).forEach(value => {
                calendar.addEvent({
                    id: value.cipherId,
                    title: value.title,
                    start: value.start + 'T' + value.startTime + 'Z',
                    end: value.end + 'T' + value.endTime + 'Z',
                    backgroundColor: value.backgroundColor,
                    borderColor: value.backgroundColor,
                    textColor: '#FFFFFF',
                    display: 'block',
                });
            });
        }
    );
}


function collapseDiv(calendar) {
    const div = document.createElement("div");
    div.setAttribute('class', 'collapse');
    div.setAttribute('id', 'collapseExample');
    div.classList.add();

    const row = document.createElement("div");
    row.classList.add('p-2', 'row', 'justify-content-end', 'mb-4');
    div.appendChild(row);

    const col = document.createElement("div");
    col.classList.add('col-lg-4', 'col-md-6', 'col-sm-10', 'col-12', 'd-flex', 'flex-column', 'row-gap-2');
    row.appendChild(col);

    var text = document.createElement("input");
    text.setAttribute("type", "text");
    text.classList.add('form-control');
    text.setAttribute('id', 'dateInput');
    text.setAttribute('placeholder', 'Select Date');
    text.setAttribute('data-input', '');
    text.setAttribute('name', 'date');
    text.setAttribute('value', moment(calendar.getDate()).format('YYYY-M'));
    text.setAttribute('readonly', 'readonly');
    col.appendChild(text);

    var button = document.createElement("button");
    button.appendChild(document.createTextNode("Go To"));
    button.setAttribute("type", "submit");
    button.setAttribute('name', 'goto-date');
    button.setAttribute('id', 'goto-date');
    button.classList.add('btn', 'primary-btn', 'w-100');
    col.appendChild(button);
    button.addEventListener('click', event => {
        loadCalendar(calendar, baseUrlDataset, text.value);
        calendar.gotoDate(text.value);

        document.querySelector('.fc-dateCustomButton-button').click();
    })


    return div;
}




