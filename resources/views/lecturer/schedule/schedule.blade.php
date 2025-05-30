
@extends('layouts.ketua_program')

@section('main')

<style>
    .cke_chrome{
        border:1px solid #eee;
        box-shadow: 0 0 0 #eee;
    }

    .event-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .delete-btn-container {
        margin-left: auto;
    }

    /* This will increase the height of the slots in the FullCalendar */
    .fc-timegrid-slot {
        height: 60px !important; /* or whatever height you prefer */
    }

    /* This CSS rule makes sure that the height of the events match the slot height */
    .fc-timegrid-event {
        min-height: 1px !important; /* Adjust if you want a different minimum height */
    }

    /* Adjust the line height and vertical alignment of the slot labels */
    .fc-timegrid-slot-label .fc-timegrid-slot-label-cushion {
        /* This height should be the same as the slot height to ensure proper alignment. */
        /* If the slot height is 60px, then set this to 60px as well. */
        height: 60px !important;
        
        /* Line height should be less than the container height to push text up towards the top */
        line-height: 30px !important; /* Adjust this value as needed to align text */
        
        /* Since the text is inside a flex container, you might need to adjust alignment using flex properties */
        display: flex;
        align-items: start; /* This aligns the child elements (text) to the start (top) of the flex container */
    }



    
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
    <!-- Content Header (Page header) -->	  
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Timetable</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Timetable</li>
                        </ol>
                    </nav>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="box">
                    <div class="box-body">
                        <h4 class="box-title fw-500">Lecturer Timetable</h4>	
                        {{-- <hr> --}}
                        {{-- <div class="mb-4">
                            <div class="box bg-success">
                                <div class="box-body d-flex p-0">
                                    <div class="flex-grow-1 p-30 flex-grow-1 bg-img bg-none-md" style="background-position: right bottom; background-size: auto 100%; background-image: url(images/svg-icon/color-svg/custom-30.svg)">
                                        <div class="row">
                                            <div class="col-12 col-xl-12">
                                                <h1 class="mb-0 fw-600">{{ $data['lectureInfo']->name }}</h1>
                                                <p class="my-10 fs-16"><strong>Session : {{ $data['lectureInfo']->session }}</strong> </p>
                                                <p class="my-10 fs-16"><strong>Description : {{ $data['lectureInfo']->description }}</strong> </p>
                                                <div class="col-12 mt-45 d-md-flex align-items-center">
                                                    <div class="col-mx-4 me-30 mb-30 mb-md-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-danger b-1 border-white rounded-circle">
                                                                <i class="fa fa-users"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">Room Capacity</h5>
                                                                <p class="mb-0 text-white-70">{{ $data['lectureInfo']->capacity }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-mx-4 me-30 mb-30 mb-md-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-primary b-1 border-white rounded-circle">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">Total Hours Per Day</h5>
                                                                <p class="mb-0 text-white-70">{{ $data['lectureInfo']->total_hour }} Hours</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-mx-4 me-30 mb-30 mb-md-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-warning b-1 border-white rounded-circle">
                                                                <i class="fa fa-clock-o"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">Time Start/End</h5>
                                                                <p class="mb-0 text-white-70">{{ (new DateTime($data['lectureInfo']->start))->format('h:i A') }} - {{ (new DateTime($data['lectureInfo']->end))->format('h:i A') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-mx-4 me-30 mb-30 mb-md-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-info b-1 border-white rounded-circle">
                                                                <i class="fa fa-address-book"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">Total Bookings</h5>
                                                                <p class="mb-0 text-white-70">{{ ($data['totalBooking']) ? $data['totalBooking']->total_booking : '0' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-mx-4 me-30 mb-30 mb-md-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-15 text-center fs-24 w-50 h-50 l-h-50 bg-light b-1 border-white rounded-circle">
                                                                <i class="fa fa-video-camera"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">Total Projector</h5>
                                                                <p class="mb-0 text-white-70">{{ $data['lectureInfo']->projector }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="box-footer">
                            {{-- <div id='event-creator'>
                                <div class="row mt-3">
                                    <div class="col-md-4 mr-3">
                                        <div class="form-group">
                                          <label>Start Time</label>
                                          <input type="datetime-local" name="start" id="event-start" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 mr-3">
                                        <div class="form-group">
                                          <label class="form-label" for="lect">Lecturer</label>
                                          <select class="form-select" id="lect" name="lect">
                                            <option value="-" selected>-</option>
                                            @foreach($data['lecturer'] as $lct)
                                            <option value="{{ $lct->ic }}">{{ $lct->name }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mr-3">
                                        <div class="form-group">
                                          <label class="form-label" for="subject">Subject</label>
                                          <select class="form-select" id="subject" name="subject">
                                            <option value="-" selected>-</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mr-3">
                                        <div class="form-group">
                                          <label class="form-label" for="group">Group</label>
                                          <select class="form-select" id="group" name="group">
                                            <option value="-" selected>-</option>
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <input type="submit" id="add-event" class="form-controlwaves-effect waves-light btn btn-primary btn-sm pull-right" value="Add Event">
                                </div>
                            </div> --}}
                            <div id='calendar' style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->

    {{-- <div id="edit-event-modal" class="modal">
        <div class="modal-content">
          <label for="edit-event-title">Title:</label>
          <input type="text" id="edit-event-title" />
          <button id="save-edit-event">Save</button>
          <button id="close-edit-event-modal">Close</button>
        </div>
    </div> --}}

    {{-- <div id="edit-event-modal" class="modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" id="getModal">
                <div class="modal-header">
                    <div class="">
                        <button class="close waves-effect waves-light btn btn-danger btn-sm pull-right" id="close-edit-event-modal" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                <div class="row col-md-12">
                    <div>
                        <div class="form-group">
                            <label for="edit-event-title">Title</label>
                            <input type="text" id="edit-event-title" class="form-control">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="edit-start">Start</label>
                            <input type="datetime-local" class="form-control" id="edit-start" name="start">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="edit-end">End</label>
                            <input type="datetime-local" class="form-control" id="edit-end" name="end">
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group pull-right">
                        <div class="row">
                            <div class="col">
                                <button id="delete-edit-event" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                            <div class="col">
                                <button id="save-edit-event" class="form-controlwaves-effect waves-light btn btn-primary btn-sm">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    
    </div> --}}
</div>
<!-- /.content-wrapper -->

<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.css' />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.css' />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.css' />
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.5/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.js'></script>

<script>
        function getRandomColor() {
            const colors = ['blue', 'green', 'purple', 'orange', 'pink', 'cyan', 'magenta', '#34ebc9', '#eb34df']; // Example colors
            return colors[Math.floor(Math.random() * colors.length)];
        }

        // Define the hiddenDays variable based on the condition
        var hiddenDays;
        hiddenDays = []; // Show all days
       
        document.addEventListener('DOMContentLoaded', function () {
            var options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                hiddenDays: hiddenDays, // Hide Sunday (0) and Saturday (6)
                slotMinTime: '07:00:00', // Set the minimum visible time to 8 AM
                slotMaxTime: '20:00:00', // Set the maximum visible time to 5 PM (17:00)
                slotDuration: '00:30:00', // Sets the duration of each time slot, e.g., '00:30:00' for 30 minutes
                slotLabelInterval: '00:30:00', // Sets the interval at which time labels are displayed, e.g., '00:30:00' for every 30 minutes
                height: 'auto', // You can set this to 'auto' or a specific pixel value like '800px'
                aspectRatio: 1.35, // Set the width-to-height ratio for the calendar container
                allDaySlot: false, // Disable the all-day slot
                // events: '/AR/schedule/fetch/{{ request()->id }}', // Fetch events from the server

                events: function(fetchInfo, successCallback, failureCallback) {
                    // Fixed "REHAT" events
                    var rehatEvents = [];
                    var date = new Date(fetchInfo.start);
                    while (date < fetchInfo.end) {
                        rehatEvents.push({
                            title: 'REHAT',
                            start: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 13, 0, 0),
                            end: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 14, 0, 0),
                            allDay: false,
                            color: 'red'
                        });
                        date.setDate(date.getDate() + 1);
                    }

                    // Fetch dynamic events from the server
                    fetch('/lecturer/class/schedule/fetch')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Fetched events:', data); // Log fetched events
                            // Assuming 'data' is an array of event objects
                            const coloredEvents = data.map(event => ({
                                ...event,
                                color: getRandomColor() // Assign a random color to each event
                            }));
                            successCallback(rehatEvents.concat(coloredEvents));
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                editable: false,
                selectable: false,
                eventResizableFromStart: false, // Allow resizing event from the start
                durationEditable: false, // Enable duration editing by dragging the event's sides
                titleFormat: { // Customize the title format
                    title: 'Lecturer Timetable',
                    text: 'Lecturer Timetable'
                },
                dayHeaderFormat: { // Customize the day header format
                    weekday: 'long'
                },
                eventContent: function(arg) {
                    
                    // Create an HTML element for the event title
                    var titleElement = document.createElement('div');
                    titleElement.classList.add('event-title');
                    titleElement.style.fontWeight = 'bold';  // Set text to be bold
                    titleElement.textContent = arg.event.title;

                    // Create an HTML element for the event time
                    var timeElement = document.createElement('div');
                    timeElement.classList.add('event-time');
                    timeElement.textContent = arg.timeText; // Default time text, e.g., "9:00 - 12:00"

                    // Container for both elements
                    var arrayOfDomNodes = [timeElement, titleElement];
                    
                    // You can conditionally add elements or modify them based on the event's properties
                    if (arg.event.extendedProps.description) {
                        var descriptionElement = document.createElement('div');
                        descriptionElement.textContent = arg.event.extendedProps.description;
                        arrayOfDomNodes.push(descriptionElement);
                    }

                    return { domNodes: arrayOfDomNodes };
                },

                eventClick: function (info) {
                    const eventElement = info.el;
                    if (eventElement.getAttribute('data-clicked') === 'true') {
                        openEditEventModal(info.event, calendar);
                    } else {
                        eventElement.setAttribute('data-clicked', 'true');
                        setTimeout(() => {
                        eventElement.removeAttribute('data-clicked');
                        }, 300);
                    }
                },

                // Add eventResize callback for updating event duration
                eventResize: async function (info) {
                    var event = info.event;

                    // Update event data
                    var eventData = {
                        start: convertToPhpMyAdminDatetime(event.start),
                        end: event.end ? convertToPhpMyAdminDatetime(event.end) : null
                    };

                    // Send data to the backend
                    const response = await fetch(`/AR/schedule/update/${event.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(eventData)
                    });

                    if (response.ok) {
                        const data = await response.json();
                        if(data.error)
                        {
                            info.revert();
                            alert(data.error);
                        }else{
                            alert('Event updated successfully');
                        }
                    } else {
                        alert('Failed to update event');
                        info.revert();
                    }
                },
            });

            calendar.render();

            // Add event button click listener
            document.getElementById('add-event').addEventListener('click', async function () {
                // var eventTitle = document.getElementById('event-title').value.trim();
                var lecturer = document.getElementById('lect').value;
                var groupId = document.getElementById('subject').value;
                var groupName = document.getElementById('group').value;
                var eventStart = convertToPhpMyAdminDatetime(new Date(document.getElementById('event-start').value));

                const slotMinTime = '07:00:00';
                const slotMaxTime = '20:00:00';

                const startHour = parseInt(eventStart.slice(11, 13));

                if (startHour < parseInt(slotMinTime.slice(0, 2)) || startHour > parseInt(slotMaxTime.slice(0, 2))) {
                    alert('Error: Event start time is outside the allowed time range.');
                    return;
                }

                if (lecturer) {
                    var currentDate = convertToPhpMyAdminDatetime(calendar.getDate());

                    if(document.getElementById('event-start').value)
                    {
                        var futureDate = convertToPhpMyAdminDatetime(new Date(new Date(document.getElementById('event-start').value).getTime() + 60 * 60000));
                    }else{
                        var futureDate = convertToPhpMyAdminDatetime(new Date(calendar.getDate().getTime() + 60 * 60000));
                    }

                    var eventData = {
                        // title: eventTitle,
                        lecturer: lecturer,
                        groupId: groupId,
                        groupName: groupName,
                        start: (document.getElementById('event-start').value) ? eventStart : currentDate,
                        end: futureDate,
                        allDay: true
                    };

                    if(eventData.start != eventData.end)
                    {

                        // Send data to the backend
                        const response = await fetch('/AR/schedule/create/{{ request()->id }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(eventData)
                        });

                        if (response.ok) {
                            const data = await response.json();
                            if(data.error)
                            {
                                alert(data.error);
                            }else{
                                calendar.addEvent(data.event);
                                // document.getElementById('event-title').value = ''; // Clear the input field
                                document.getElementById('lect').value = ''; // Clear the input field
                                document.getElementById('subject').value = ''; // Clear the input field
                                document.getElementById('group').value = ''; // Clear the input field
                                document.getElementById('event-start').value = ''; // Clear the input field
                                document.getElementById('event-end').value = ''; // Clear the input field
                                alert('Event added successfully.'); // Inform the user that the event was added    
                            }
                        } else {
                            alert('Failed to add event.'); // Inform the user that adding the event failed
                        }

                    }else{

                        alert('Please make sure start and end is not the same.');
                        
                    }

                } else {
                    alert('Please enter an event title.');
                }
            });

            // Event drop callback for updating event time
            calendar.setOption('eventDrop', async function (info) {
                var event = info.event;

                // Update event data
                var eventData = {
                    start: convertToPhpMyAdminDatetime(event.start),
                    end: event.end ? convertToPhpMyAdminDatetime(event.end) : null
                };

                // Send data to the backend
                const response = await fetch(`/AR/schedule/update/${event.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(eventData)
                });

                if (response.ok) {
                    const data = await response.json();
                    if(data.error)
                    {
                        info.revert();
                        alert(data.error);
                    }else{
                        alert('Event updated successfully');
                    }
                } else {
                    alert('Failed to update event');
                    info.revert();
                }
            });

            async function handleEventDelete(event, calendar) {
                const response = await fetch('/AR/schedule/delete/' + event.id, {
                    method: 'DELETE',
                    headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                if (response.ok) {
                    event.remove(); // Use remove() on the event object
                } else {
                    alert('Error: Could not delete the event.');
                }
            }

            function openEditEventModal(event, calendar) {
                document.getElementById('edit-event-title').value = event.title;
                document.getElementById('edit-start').value = convertToPhpMyAdminDatetime(event.start);
                document.getElementById('edit-end').value = convertToPhpMyAdminDatetime(event.end);

                const saveButton = document.getElementById('save-edit-event');
                saveButton.onclick = function () {
                    handleEventUpdate(event, calendar);
                };

                const deleteButton = document.getElementById('delete-edit-event');
                deleteButton.onclick = function () {
                    handleEventDelete(event, calendar);
                    closeModal();
                };

                const closeButton = document.getElementById('close-edit-event-modal');
                closeButton.onclick = function () {
                    closeModal();
                };

                document.getElementById('edit-event-modal').style.display = 'block';
            }

            function closeModal() {
                document.getElementById('edit-event-modal').style.display = 'none';
            }

            async function handleEventUpdate(event, calendar) {
                const newTitle = document.getElementById('edit-event-title').value;
                const newStart = document.getElementById('edit-start').value;
                const newEnd = document.getElementById('edit-end').value;

                const slotMinTime = '07:00:00';
                const slotMaxTime = '20:00:00';

                const startHour = parseInt(newStart.slice(11, 13));
                const endHour = parseInt(newEnd.slice(11, 13));

                if (startHour < parseInt(slotMinTime.slice(0, 2)) || endHour > parseInt(slotMaxTime.slice(0, 2))) {
                    alert('Error: Event start or end time is outside the allowed time range.');
                    return;
                }

                const response = await fetch('/AR/schedule/update2/' + event.id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        title: newTitle,
                        start: newStart,
                        end: newEnd
                    }),
                });

                if (response.ok) {
                    const data = await response.json();
                    if(data.error)
                    {
                        alert(data.error);
                    }else{
                        event.setProp('title', newTitle);
                        event.setDates(newStart, newEnd);
                        calendar.render();
                        closeModal();
                        alert('Event updated successfully');
                    }
                } else {
                    alert('Failed to update event');
                    info.revert();
                }
            }


            function convertToPhpMyAdminDatetime(dateString) {
                // Parse the date string into a JavaScript Date object
                const dateObj = new Date(dateString);

                // Format the Date object into the PHPMyAdmin datetime format (YYYY-MM-DD HH:mm:ss)
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                const hours = String(dateObj.getHours()).padStart(2, '0');
                const minutes = String(dateObj.getMinutes()).padStart(2, '0');
                const seconds = String(dateObj.getSeconds()).padStart(2, '0');

                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

        });
    </script>

@stop