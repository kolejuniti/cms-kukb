@php
    $layoutMap = [
        'AR' => 'layouts.pendaftar_akademik',
        'LCT' => 'layouts.ketua_program',
        'PL' => 'layouts.ketua_program',
        'AO' => 'layouts.ketua_program',
        'OTR' => 'layouts.other_user',
        'ADM' => 'layouts.admin',
        'HEA' => 'layouts.hea'
    ];
    
    $layout = 'layouts.student';
    
    if (isset(Auth::user()->usrtype) && array_key_exists(Auth::user()->usrtype, $layoutMap)) {
        $layout = $layoutMap[Auth::user()->usrtype];
    }
@endphp

@extends($layout)

@section('main')

<!-- Include the custom CSS -->
<style>
    :root {
    --primary: #4361ee;
    --secondary: #3f37c9;
    --success: #4cc9f0;
    --info: #4895ef;
    --warning: #f72585;
    --danger: #e63946;
    --light: #f8f9fa;
    --dark: #212529;
    --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    --transition-speed: 0.3s;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fa;
}

.content-wrapper {
    background-color: #f5f7fa;
}

.card, .box {
    border-radius: 12px;
    box-shadow: var(--card-shadow);
    border: none;
    transition: transform var(--transition-speed), box-shadow var(--transition-speed);
    overflow: hidden;
}

.card:hover, .box:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.2);
}

.profile-card {
    background: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
    color: white;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: url('images/svg-icon/color-svg/custom-30.svg');
    background-position: right bottom;
    background-size: auto 100%;
    opacity: 0.2;
}

.profile-content {
    position: relative;
    z-index: 1;
    padding: 30px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    transition: all var(--transition-speed);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-5px);
}

.stat-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 1.2rem;
    margin-right: 15px;
}

.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all var(--transition-speed);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
}

.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
}

.btn-primary:hover {
    background-color: var(--secondary);
    border-color: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
}

.btn-warning {
    background-color: var(--warning);
    border-color: var(--warning);
}

.btn-warning:hover {
    background-color: #d1214c;
    border-color: #d1214c;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(247, 37, 133, 0.4);
}

.btn-info {
    background-color: var(--info);
    border-color: var(--info);
}

.btn-info:hover {
    background-color: #3572b8;
    border-color: #3572b8;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(72, 149, 239, 0.4);
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
}

.action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.form-control, .form-select {
    border-radius: 8px;
    padding: 12px 15px;
    border: 1px solid #e0e0e0;
    background-color: #f8f9fa;
    transition: all var(--transition-speed);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    background-color: #fff;
}

label {
    font-weight: 500;
    margin-bottom: 8px;
}

.form-group {
    margin-bottom: 20px;
}

.card-title, .box-title {
    font-weight: 700;
    color: #212529;
    position: relative;
    padding-bottom: 10px;
}

.card-title::after, .box-title::after {
    content: '';
    position: absolute;
    width: 50px;
    height: 3px;
    background: linear-gradient(to right, var(--primary), var(--info));
    bottom: 0;
    left: 0;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}

.fc-timegrid-slot {
    height: 60px !important;
}

.fc-theme-standard td, .fc-theme-standard th {
    border-color: #e0e0e0;
}

.fc .fc-button-primary {
    background-color: var(--primary);
    border-color: var(--primary);
}

.fc .fc-button-primary:hover {
    background-color: var(--secondary);
    border-color: var(--secondary);
}

.fc .fc-col-header-cell-cushion {
    padding: 10px;
}

.fc-event {
    background-color: var(--primary);
    border-color: var(--primary);
    border-radius: 6px;
    transition: all var(--transition-speed);
}

.fc-event:hover {
    transform: scale(1.02);
}

.fc-h-event .fc-event-title-container {
    padding: 5px;
}

/* Remove the old positioning styles that were causing the issue */
.fc-event .program-info {
    text-align: center;
    font-size: smaller;
    font-weight: bold;
    padding: 2px 4px;
    margin-top: 4px;
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
}

.fc-event .lecturer-info {
    text-align: center;
    font-size: smaller;
    font-weight: bold;
    padding: 2px 4px;
    margin-top: 2px;
    background-color: rgba(255, 255, 255, 0.25);
    border-radius: 3px;
}

/* Improve calendar event styling */
.fc-event {
    overflow: visible !important;
    display: flex;
    flex-direction: column;
}

.fc-event-title-container {
    flex: 1;
}

.fc-event-title {
    font-weight: bold;
    margin-bottom: 4px;
}

.event-program, .event-lecturer {
    margin-top: 3px;
    font-size: 0.75rem;
}

/* Add a bit more height to event cells to accommodate the content */
.fc-timegrid-slot {
    height: 65px !important;
}

/* Make sure event content is properly aligned */
.fc-event-main {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.table th, .table td {
    border: none;
    padding: 12px 15px;
    vertical-align: middle;
}

.table thead th {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: all var(--transition-speed);
}

.table tbody tr:hover {
    background-color: rgba(67, 97, 238, 0.05);
}

.table tbody tr:nth-child(odd) {
    background-color: #f8f9fa;
}

.modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: var(--card-shadow);
}

.modal-header {
    background-color: var(--primary);
    color: white;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    padding: 15px 20px;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #e0e0e0;
}

/* Tooltip styling */
.custom-tooltip {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.8rem;
    z-index: 1000;
    pointer-events: none;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: var(--danger);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.last-published {
    display: inline-block;
    margin-left: 10px;
}

.calendar-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.8);
    padding: 15px;
    border-radius: 8px;
    z-index: 10;
    box-shadow: var(--card-shadow);
}

.toast-notification {
    animation: slide-in 0.3s ease-out forwards;
}

@keyframes slide-in {
    0% {
        transform: translateY(-20px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.event-dragging {
    opacity: 0.7;
    transform: scale(1.03);
}

@media (max-width: 767px) {
    .action-buttons {
        justify-content: center;
    }
    
    .stat-cards-container {
        flex-direction: column;
    }
}
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<!-- Google Fonts - Poppins -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" />

<!-- FullCalendar CSS -->
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.css' />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.css' />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.css' />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->	  
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Timetable Management</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i> Home</a></li>
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
                    <!-- Profile Card -->
                    <div class="profile-card mb-4">
                        <div class="profile-content">
                            <div class="row">
                                <div class="col-12 col-xl-6">
                                    @if(request()->type == 'std')
                                        <h1 class="mb-2 fw-700">{{ $data['studentInfo']->name }}</h1>
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-id-card me-2"></i>
                                            <p class="mb-0 fs-16"><strong>IC:</strong> {{ $data['studentInfo']->ic }}</p>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-user-graduate me-2"></i>
                                            <p class="mb-0 fs-16"><strong>Matric No:</strong> {{ $data['studentInfo']->no_matric }}</p>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            <p class="mb-0 fs-16"><strong>Session:</strong> {{ $data['studentInfo']->session }}</p>
                                        </div>
                                    @elseif(request()->type == 'lcr')
                                        <h1 class="mb-2 fw-700">{{ $data['roomInfo']->name }}</h1>
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-clock me-2"></i>
                                            <p class="mb-0 fs-16"><strong>Time:</strong> {{ $data['roomInfo']->start }} - {{ $data['roomInfo']->end }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 col-xl-6 mt-4 mt-xl-0">
                                    <!-- Add some info/stats cards here if appropriate -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Calendar Box -->
                    <div class="box mb-4">
                        <div class="box-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="box-title mb-0 fw-700">Timetable</h4>
                                <div class="last-published">
                                    <span class="badge bg-info p-2">
                                        <i class="fas fa-sync me-1"></i>
                                        Last published: {{ date('d M Y', strtotime($data['time'] ?? now())) }}
                                    </span>
                                </div>
                            </div>
                            <hr>
                            
                            <div id='calendar' style="width: 100%;"></div>
                            
                            <div class="action-buttons">
                                @if(request()->type == 'std')
                                    <button 
                                        id="print-schedule-btn" 
                                        class="btn btn-secondary"
                                        onclick="printScheduleTable(
                                            '{{ $data['studentInfo']->name }}',
                                            '{{ $data['studentInfo']->ic }}',
                                            '{{ $data['studentInfo']->no_matric }}',
                                            '{{ $data['studentInfo']->session }}',
                                            'std'
                                        )"
                                    >
                                        <i class="fas fa-print me-2"></i> Print
                                    </button>
                                @elseif(request()->type == 'lcr')
                                    <button 
                                        id="print-schedule-btn" 
                                        class="btn btn-secondary"
                                        onclick="printScheduleTable(
                                            '{{ $data['roomInfo']->name }}',
                                            '{{ $data['roomInfo']->start }}',
                                            '{{ $data['roomInfo']->end }}',
                                            '',
                                            'lcr'
                                        )"
                                    >
                                        <i class="fas fa-print me-2"></i> Print
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

        <!-- Edit Event Modal -->
        <div id="edit-event-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- modal content-->
                <div class="modal-content" id="getModal">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-edit me-2"></i> Edit Timetable
                        </h5>
                        <button type="button" class="btn-close btn-close-white" id="close-edit-event-modal" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="edit-event-title">
                                        <i class="fas fa-heading me-2"></i> Title
                                    </label>
                                    <input type="text" id="edit-event-title" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="edit-start">
                                        <i class="fas fa-hourglass-start me-2"></i> Start
                                    </label>
                                    <input type="datetime-local" class="form-control" id="edit-start" name="start">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="edit-end">
                                        <i class="fas fa-hourglass-end me-2"></i> End
                                    </label>
                                    <input type="datetime-local" class="form-control" id="edit-end" name="end">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between w-100">
                            <button id="delete-edit-event" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i> Delete
                            </button>
                            <button id="save-edit-event" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Edit Event Modal -->
    </div>
</div>
<!-- /.content-wrapper -->

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.5/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.js'></script>

<!-- Custom JavaScript -->
<script>
    /**
 * Timetable Management System JavaScript
 * Enhanced with modern UX, animations, and error handling
 */

document.addEventListener('DOMContentLoaded', function() {
    // Enhanced tooltips for better user guidance
    initializeTooltips();
    
    // Initialize data tables and fetch logged schedules
    initializeDataTables();
    
    // Initialize calendar
    setupCalendar();
});

/**
 * Initialize tooltips for interactive elements
 */
function initializeTooltips() {
    const addTooltip = (element, message) => {
        if (!element) return;
        
        element.addEventListener('mouseenter', (e) => {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.innerText = message;
            tooltip.style.top = `${e.pageY - 30}px`;
            tooltip.style.left = `${e.pageX + 10}px`;
            document.body.appendChild(tooltip);
        });
        
        element.addEventListener('mouseleave', () => {
            const tooltips = document.querySelectorAll('.custom-tooltip');
            tooltips.forEach(tip => tip.remove());
        });
    };
    
    // Add tooltips to buttons
    addTooltip(document.getElementById('publish-schedule'), 'Publish the current timetable');
    addTooltip(document.getElementById('reset-schedule'), 'Reset changes to last published version');
    addTooltip(document.getElementById('log-schedule'), 'Save current timetable state to history');
    addTooltip(document.getElementById('print-schedule-btn'), 'Print current timetable');
}

/**
 * Initialize DataTables for better table handling
 */
function initializeDataTables() {
    if ($.fn.DataTable && document.getElementById('complex_header')) {
        $('#complex_header').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 5,
            "language": {
                "emptyTable": "No history data available",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "search": "Search:",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    }
}

/**
 * Generate random colors from modern palette
 */
function getRandomColor() {
    // Modern color palette
    const colors = [
        '#4361ee', // Primary blue
        '#4cc9f0', // Light blue
        '#3a0ca3', // Deep purple
        '#7209b7', // Purple
        '#f72585', // Pink
        '#4895ef', // Sky blue
        '#560bad', // Dark purple
        '#b5179e', // Magenta
        '#3f37c9'  // Indigo
    ];
    return colors[Math.floor(Math.random() * colors.length)];
}

/**
 * Show notification for user feedback
 */
 function showNotification(message, type = 'info', autoHide = true) {
    // Create toast container if it doesn't exist
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '10px';
        toastContainer.style.left = '50%';
        toastContainer.style.transform = 'translateX(-50%)';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    // Generate a unique ID for this toast
    const toastId = 'toast-' + Date.now();
    
    // Create the toast HTML structure using innerHTML for more reliable rendering
    const toastHTML = `
        <div id="${toastId}" class="toast-notification toast-${type}" style="
            background-color: ${type === 'success' ? '#4cc9f0' : type === 'error' ? '#e63946' : type === 'warning' ? '#f72585' : '#4895ef'};
            color: #fff;
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: flex-start;
            max-width: 400px;
            word-break: break-word;
            position: relative;
        ">
            <i class="fas ${
                type === 'success' ? 'fa-check-circle' : 
                type === 'error' ? 'fa-exclamation-triangle' : 
                type === 'warning' ? 'fa-exclamation-circle' : 'fa-info-circle'
            } me-2" style="margin-top: 2px;"></i>
            <div style="flex: 1;">${message}</div>
            <button onclick="document.getElementById('${toastId}').remove();" style="
                margin-left: 10px;
                background: none;
                border: none;
                color: #fff;
                font-size: 24px;
                font-weight: bold;
                cursor: pointer;
                padding: 0 8px;
                position: relative;
                z-index: 10;
            ">&times;</button>
        </div>
    `;
    
    // Insert the toast into the container
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    // Get the newly created toast element
    const toast = document.getElementById(toastId);
    
    // Add a click handler directly to the close button
    const closeBtn = toast.querySelector('button');
    if (closeBtn) {
        closeBtn.onclick = function() {
            if (toast && toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        };
    }
    
    // Auto hide after 4 seconds
    if (autoHide) {
        setTimeout(() => {
            if (toast && toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 4000);
    }
    
    return toast;
}
// Calendar global variable
var calendar;

/**
 * Set up the FullCalendar
 */
function setupCalendar() {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;
    
    var hiddenDays = [5, 6]; // Hide Friday(5) & Saturday(6)

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        headerToolbar: {
            left: 'today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Today',
            week: 'Week',
            day: 'Day'
        },
        hiddenDays: hiddenDays,
        slotMinTime: '08:15:00',
        slotMaxTime: '17:15:00',
        slotDuration: '00:30:00',
        slotLabelInterval: '00:30:00',
        height: 'auto',
        aspectRatio: 1.35,
        allDaySlot: false,
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        nowIndicator: true,
        navLinks: true,
        dayMaxEvents: true,
        
        // Events fetching (REHAT + dynamic events)
        events: function(fetchInfo, successCallback, failureCallback) {
            // Show loading indicator
            $('#calendar').addClass('loading');
            $('<div class="calendar-loading"><i class="fas fa-circle-notch fa-spin"></i></div>').appendTo('#calendar');
            
            // 1) Generate "REHAT" events
            var rehatEvents = [];
            var date = new Date(fetchInfo.start);
            while (date < fetchInfo.end) {
                var dayOfWeek = date.getDay(); 
                if (dayOfWeek >= 1 && dayOfWeek <= 4) {
                    // Monday-Thursday => 13:30 to 14:00
                    rehatEvents.push({
                        title: 'REHAT',
                        start: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 13, 15, 0),
                        end: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 14, 15, 0),
                        allDay: false,
                        color: '#e63946',
                        textColor: '#ffffff',
                        borderColor: '#e63946'
                    });
                } else if (dayOfWeek === 5) {
                    // Friday => 12:30 to 14:30
                    rehatEvents.push({
                        title: 'REHAT',
                        start: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 12, 30, 0),
                        end: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 14, 30, 0),
                        allDay: false,
                        color: '#e63946',
                        textColor: '#ffffff',
                        borderColor: '#e63946'
                    });
                }
                date.setDate(date.getDate() + 1);
            }

            // 2) Fetch dynamic events
            const urlParams = new URLSearchParams(window.location.search);
            const id = window.location.pathname.split('/').pop();
            const type = urlParams.get('type') || '';

            fetch(`/AR/schedule/fetch/${id}?type=${type}`)
                .then(response => response.json())
                .then(data => {
                    const coloredEvents = data.map(event => ({
                        ...event,
                        color: getRandomColor(),
                        textColor: '#ffffff',
                        borderColor: 'rgba(255,255,255,0.2)'
                    }));
                    
                    // Remove loading overlay
                    $('#calendar').removeClass('loading');
                    $('.calendar-loading').remove();
                    
                    successCallback(rehatEvents.concat(coloredEvents));
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    
                    // Remove loading overlay
                    $('#calendar').removeClass('loading');
                    $('.calendar-loading').remove();
                    
                    // Show error notification
                    showNotification('Error loading calendar events: ' + error.message, 'error');
                    
                    failureCallback(error);
                });
        },

        // Enhanced event styling
        // Enhanced event styling - modified to prevent duplication
        eventDidMount: function(info) {
            // Only add special styling for REHAT events if needed
            if (info.event.title === 'REHAT') {
                // Apply any REHAT-specific styling here
                info.el.style.backgroundColor = '#e63946';
                info.el.style.color = 'white';
            }
            
            // No need to add program/lecturer info here anymore
            // since we're handling it in eventContent
        },

        editable: {{ Auth::check() ? (Auth::user()->usrtype === 'AR' ? 'true' : 'false') : 'false' }},
        selectable: {{ Auth::check() ? (Auth::user()->usrtype === 'AR' ? 'true' : 'false') : 'false' }},
        eventResizableFromStart: {{ Auth::check() ? (Auth::user()->usrtype === 'AR' ? 'true' : 'false') : 'false' }},
        durationEditable: {{ Auth::check() ? (Auth::user()->usrtype === 'AR' ? 'true' : 'false') : 'false' }},
        
        titleFormat: {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        },
        
        dayHeaderFormat: {
            weekday: 'long',
            day: 'numeric'
        },

        // Event content customization
        eventContent: function(arg) {
            // Create the main container
            var container = document.createElement('div');
            container.style.height = '100%';
            container.style.display = 'flex';
            container.style.flexDirection = 'column';
            container.style.padding = '2px';
            
            // Time element at the top
            var timeElement = document.createElement('div');
            timeElement.classList.add('event-time');
            timeElement.style.fontSize = '0.7rem';
            timeElement.style.opacity = '0.9';
            timeElement.style.fontWeight = 'bold';
            timeElement.textContent = arg.timeText;
            
            // Title element below time
            var titleElement = document.createElement('div');
            titleElement.classList.add('event-title');
            titleElement.style.fontWeight = 'bold';
            titleElement.style.fontSize = '0.85rem';
            titleElement.style.padding = '2px 0';
            titleElement.style.margin = '2px 0';
            titleElement.textContent = arg.event.title;
            
            // Add elements to container
            container.appendChild(timeElement);
            container.appendChild(titleElement);
            
            // Description (if available)
            if (arg.event.extendedProps.description) {
                var descriptionElement = document.createElement('div');
                descriptionElement.classList.add('event-description');
                descriptionElement.style.fontSize = '0.7rem';
                descriptionElement.style.opacity = '0.8';
                descriptionElement.style.whiteSpace = 'normal';
                descriptionElement.style.overflow = 'visible';
                descriptionElement.style.marginBottom = '5px';
                descriptionElement.textContent = arg.event.extendedProps.description;
                container.appendChild(descriptionElement);
            }
            
            // Add program info directly in the content instead of appending later
            if (arg.event.title !== 'REHAT' && arg.event.extendedProps) {
                // Program info
                if (arg.event.extendedProps.programInfo) {
                    var programDiv = document.createElement('div');
                    programDiv.classList.add('event-program');
                    programDiv.style.fontSize = '0.7rem';
                    programDiv.style.padding = '2px 4px';
                    programDiv.style.marginTop = 'auto';
                    programDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.1)';
                    programDiv.style.borderRadius = '3px';
                    programDiv.style.fontWeight = 'bold';
                    programDiv.textContent = 'Program: ' + arg.event.extendedProps.programInfo;
                    container.appendChild(programDiv);
                }
                
                // Lecturer info
                if (arg.event.extendedProps.lectInfo) {
                    var lectDiv = document.createElement('div');
                    lectDiv.classList.add('event-lecturer');
                    lectDiv.style.fontSize = '0.7rem';
                    lectDiv.style.padding = '2px 4px';
                    lectDiv.style.marginTop = '2px';
                    lectDiv.style.backgroundColor = 'rgba(255, 255, 255, 0.25)';
                    lectDiv.style.borderRadius = '3px';
                    lectDiv.style.fontWeight = 'bold';
                    lectDiv.textContent = 'Lecturer: ' + arg.event.extendedProps.lectInfo;
                    container.appendChild(lectDiv);
                }
            }
            
            return { domNodes: [container] };
        },

        // Event click handling
        eventClick: function (info) {
            const eventElement = info.el;
            if (eventElement.getAttribute('data-clicked') === 'true') {
                if('{{ request()->type }}' == 'lcr') {
                    if({{ Auth::check() ? 'true' : 'false' }} && '{{ Auth::check() ? Auth::user()->usrtype : "" }}' == 'AR') {
                        openEditEventModal(info.event, calendar);
                    }else{
                        // Show event details in a modal or tooltip
                        showEventDetails(info.event);
                    }
                }else{
                    // Show event details in a modal or tooltip
                    showEventDetails(info.event);
                }
            } else {
                eventElement.setAttribute('data-clicked', 'true');
                setTimeout(() => {
                    eventElement.removeAttribute('data-clicked');
                }, 300);
            }
        },

        // Event resize handling
        eventResize: async function (info) {
            var event = info.event;
            var eventData = {
                start: convertToPhpMyAdminDatetime(event.start),
                end: event.end ? convertToPhpMyAdminDatetime(event.end) : null
            };

            // Show loading indicator
            showNotification('Updating event...', 'info', true);

            try {
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
                    if(data.error) {
                        info.revert();
                        
                        // Check if conflicting students list exists
                        if (data.conflicting_students && data.conflicting_students.length > 0) {
                            // Create list of student ICs
                            const studentList = data.conflicting_students.map(student => student.no_matric).join(', ');
                            showNotification(`${data.error}<br><br>Conflicting students: ${studentList}`, 'error', false);
                        } else {
                            showNotification(data.error, 'error');
                        }
                    } else {
                        showNotification('Event updated successfully', 'success');
                    }
                } else {
                    throw new Error('Failed to update event');
                }
            } catch (error) {
                info.revert();
                showNotification('Failed to update event: ' + error.message, 'error');
            }
        },

        // Event drag start
        eventDragStart: async function(info) {
            // Add visual drag effect
            $(info.el).addClass('event-dragging');
            
            var event = info.event;
            try {
                const response = await fetch(`/AR/schedule/fetch/${event.id}/fetchExistEvent`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.error) {
                        info.revert();
                        showNotification(data.error, 'error');
                    } else {
                        data.forEach(fetchedEvent => {
                            const startTime = new Date();
                            startTime.setHours(...fetchedEvent.startTime.split(':'));

                            const endTime = new Date();
                            endTime.setHours(...fetchedEvent.endTime.split(':'));

                            const currentDay = startTime.getDay();
                            const targetDay = fetchedEvent.daysOfWeek[0]; 
                            const dayDifference = targetDay - currentDay;
                            startTime.setDate(startTime.getDate() + dayDifference);
                            endTime.setDate(endTime.getDate() + dayDifference);

                            var highlightEvent = {
                                id: 'highlight-' + fetchedEvent.id,
                                start: startTime,
                                end: endTime,
                                display: 'background',
                                backgroundColor: 'rgba(244, 67, 54, 0.15)',
                                borderColor: 'rgba(244, 67, 54, 0.3)',
                                allDay: false
                            };
                            info.view.calendar.addEvent(highlightEvent);
                        });
                    }
                } else {
                    throw new Error('Failed to fetch existing events');
                }
            } catch (error) {
                info.revert();
                showNotification('Error: ' + error.message, 'error');
            }
        },

        // Event drag stop
        eventDragStop: function(info) {
            // Remove drag effect
            $(info.el).removeClass('event-dragging');
            
            // Remove highlight events
            info.view.calendar.getEvents().forEach(e => {
                if (e.id.startsWith('highlight-')) {
                    e.remove();
                }
            });
        },

        // Event drop (after dragging)
        eventDrop: async function(info) {
            var event = info.event;
            var eventData = {
                start: convertToPhpMyAdminDatetime(event.start),
                end: event.end ? convertToPhpMyAdminDatetime(event.end) : null
            };

            // Show loading indicator
            showNotification('Updating event...', 'info', true);

            try {
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
                    if(data.error) {
                        info.revert();
                        
                        // Check if conflicting students list exists
                        if (data.conflicting_students && data.conflicting_students.length > 0) {
                            // Create list of student ICs
                            const studentList = data.conflicting_students.map(student => student.no_matric).join(', ');
                            showNotification(`${data.error}<br><br>Conflicting students: ${studentList}`, 'error', false);
                        } else {
                            showNotification(data.error, 'error');
                        }
                    } else {
                        showNotification('Event updated successfully', 'success');
                    }
                } else {
                    throw new Error('Failed to update event');
                }
            } catch (error) {
                info.revert();
                showNotification('Error: ' + error.message, 'error');
            }

            // Remove highlight events
            info.view.calendar.getEvents().forEach(e => {
                if (e.id.startsWith('highlight-')) {
                    e.remove();
                }
            });
        }
    });

    // Render the calendar
    calendar.render();

    // Initialize button handlers
    initializeButtonHandlers();
}

/**
 * Show event details in a modal or tooltip
 */
   /**
 * Show event details in a modal or tooltip
 */
function showEventDetails(event) {
    // Create custom tooltip or use SweetAlert for a nice modal
    Swal.fire({
        title: event.title,
        html: `
            <div class="event-details">
                <p><strong>Time:</strong> ${event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} - ${event.end ? event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'N/A'}</p>
                ${event.extendedProps.description ? `<p><strong>Description:</strong> ${event.extendedProps.description}</p>` : ''}
                ${event.extendedProps.programInfo ? `<p><strong>Program:</strong> ${event.extendedProps.programInfo}</p>` : ''}
                ${event.extendedProps.lectInfo ? `<p><strong>Lecturer:</strong> ${event.extendedProps.lectInfo}</p>` : ''}
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Close',
        confirmButtonColor: '#4361ee'
    });
}

/**
 * Modal handling for edit events
 */
function openEditEventModal(event, calendarRef) {
    // Set current event values
    document.getElementById('edit-event-title').value = event.title;
    document.getElementById('edit-start').value = convertToPhpMyAdminDatetime(event.start);
    document.getElementById('edit-end').value = convertToPhpMyAdminDatetime(event.end);

    const saveButton = document.getElementById('save-edit-event');
    const deleteButton = document.getElementById('delete-edit-event');
    const closeButton = document.getElementById('close-edit-event-modal');

    // Setup button handlers
    saveButton.onclick = function() {
        handleEventUpdate(event, calendarRef);
    };
    
    deleteButton.onclick = function() {
        handleEventDelete(event);
        closeModal();
    };
    
    closeButton.onclick = function() {
        closeModal();
    };

    // Show modal
    $('#edit-event-modal').modal('show');
}

/**
 * Close the edit event modal
 */
function closeModal() {
    $('#edit-event-modal').modal('hide');
}

/**
 * Handle delete event action
 */
async function handleEventDelete(event) {
    Swal.fire({
        title: "Delete Event?",
        text: "This cannot be undone",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Delete',
        cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
        confirmButtonColor: '#e63946',
        cancelButtonColor: '#6c757d'
    }).then(async (result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Deleting...',
                html: '<i class="fas fa-spinner fa-spin fa-2x"></i>',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            try {
                const response = await fetch('/AR/schedule/delete/' + event.id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                });
                
                if (response.ok) {
                    event.remove();
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'The event has been removed',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    throw new Error('Could not delete the event');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message
                });
            }
        }
    });
}

/**
 * Handle update event action
 */
async function handleEventUpdate(event, calendarRef) {
    const newTitle = document.getElementById('edit-event-title').value;
    const newStart = document.getElementById('edit-start').value;
    const newEnd = document.getElementById('edit-end').value;

    // Validate inputs
    if (!newTitle || !newStart || !newEnd) {
        showNotification('All fields are required', 'warning');
        return;
    }

    const slotMinTime = '08:15:00';
    const slotMaxTime = '17:15:00';
    const startHour = parseInt(newStart.slice(11, 13));
    const endHour = parseInt(newEnd.slice(11, 13));

    if (startHour < parseInt(slotMinTime.slice(0, 2)) || endHour > parseInt(slotMaxTime.slice(0, 2))) {
        showNotification('Event times must be between 08:15 and 17:15', 'error');
        return;
    }

    // Show loading state
    const saveBtn = document.getElementById('save-edit-event');
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
    saveBtn.disabled = true;

    try {
        const response = await fetch('/AR/schedule/update2/' + event.id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                title: newTitle,
                start: newStart,
                end: newEnd
            }),
        });
        
        if (response.ok) {
            const data = await response.json();
            if(data.error) {
                // Check if the response includes conflicting students list
                if (data.conflicting_students && data.conflicting_students.length > 0) {
                    // Create list of student ICs
                    const studentList = data.conflicting_students.map(student => student.no_matric).join(', ');
                    showNotification(`${data.error}<br><br>Conflicting students: ${studentList}`, 'error', false);
                } else {
                    showNotification(data.error, 'error');
                }
            } else {
                // Update the event on the calendar
                event.setProp('title', newTitle);
                event.setDates(newStart, newEnd);
                calendarRef.render();
                closeModal();
                showNotification('Event updated successfully', 'success');
            }
        } else {
            throw new Error('Failed to update event');
        }
    } catch (error) {
        showNotification('Error: ' + error.message, 'error');
    } finally {
        // Reset button state
        saveBtn.innerHTML = '<i class="fas fa-save me-2"></i> Save Changes';
        saveBtn.disabled = false;
    }
}

/**
 * Convert to "YYYY-MM-DD HH:mm:ss" format for API calls
 */
function convertToPhpMyAdminDatetime(dateString) {
    if(!dateString) return ''; // handle empty
    const dateObj = new Date(dateString);
    const year = dateObj.getFullYear();
    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    const day = String(dateObj.getDate()).padStart(2, '0');
    const hours = String(dateObj.getHours()).padStart(2, '0');
    const minutes = String(dateObj.getMinutes()).padStart(2, '0');
    const seconds = String(dateObj.getSeconds()).padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

// Print schedule table function
function printScheduleTable(name, ic, staffNo, email) {
    // Show loading notification
    showNotification('Preparing timetable for printing...', 'info');
    
    const dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday'];

    // Build time slots with safe predefined slots (08:15..17:15)
    let times = [
        '08:15', '08:45', '09:15', '09:45', '10:15', '10:45', '11:15', '11:45',
        '12:15', '12:45', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30',
        '15:00', '15:30', '16:00', '16:30', '17:00'
    ];

    // Get events from FullCalendar
    const events = calendar.getEvents();

    // Build a 2D array scheduleData[dayIndex][timeIndex] = [events]
    // Changed to store arrays of events instead of single events
    let scheduleData = [];
    for (let d = 0; d < dayNames.length; d++) {
        scheduleData[d] = [];
        for (let t = 0; t < times.length; t++) {
            scheduleData[d][t] = []; // Initialize with empty array
        }
    }

    events.forEach(event => {
        let start = event.start;
        let end = event.end || new Date(start.getTime() + 60 * 60 * 1000);

        // Convert day-of-week (Sun=0..Thu=4 => index 0..4)
        let dayIndex = start.getDay(); 
        if (dayIndex > 4) return; // skip Friday(5) and Saturday(6)

        let startTimeStr = toHHMM(start);
        let endTimeStr = toHHMM(end);

        let startIndex = times.indexOf(startTimeStr);
        if (startIndex === -1) return;

        let endIndex = times.indexOf(endTimeStr);
        if (endIndex === -1) endIndex = times.length;

        // Fill each half-hour slot with the event
        for (let i = startIndex; i < endIndex; i++) {
            scheduleData[dayIndex][i].push(event); // Push to array instead of overwriting
        }
    });

    // Create processed tracking arrays
    let processedEvents = new Set();
    let skip = [];
    for (let d = 0; d < dayNames.length; d++) {
        skip[d] = new Array(times.length).fill(false);
    }

    // Add current date for footer
    const currentDate = new Date().toLocaleDateString('en-GB', {
        day: '2-digit', 
        month: 'short', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    // Build HTML with modern styling
    let html = `
    <html>
    <head>
        <title>Timetable - ${name}</title>
        <style>
            /* Control page breaks */
            @page {
                size: A4 landscape;
                margin: 0.5cm;
            }
            
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                margin: 0;
                padding: 0;
                color: #000000;
                font-size: 9px;
                font-weight: 500;
            }
            
            .container {
                max-width: 100%;
                margin: 0 auto;
                padding: 10px;
            }
            
            .header {
                text-align: center;
                margin-bottom: 10px;
                padding-bottom: 5px;
                border-bottom: 1px solid #4361ee;
            }
            
            h1 {
                color: #4361ee;
                margin: 0;
                font-size: 16px;
                font-weight: 600;
            }
            
            .lecturer-info {
                background-color: #f8f9fa;
                border-radius: 4px;
                padding: 5px;
                margin-bottom: 10px;
                border: 1px solid #e0e0e0;
            }
            
            .lecturer-info p {
                margin: 2px 0;
                font-size: 9px;
                font-weight: 600;
                color: #000000;
            }
            
            .lecturer-info strong {
                color: #000000;
                font-weight: 700;
            }
            
            /* Table layout across pages */
            table {
                width: 100%;
                border-collapse: collapse;
                box-shadow: none;
                border-radius: 0;
                font-size: 8px;
                page-break-inside: auto;
            }
            
            /* Keep rows together where possible */
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            /* Add table header repeat for second page */
            thead {
                display: table-header-group;
            }
            
            /* Prevent orphaned footer */
            tfoot {
                display: table-footer-group;
            }
            
            th {
                background-color: #1e40af;
                color: white;
                padding: 3px;
                text-align: center;
                font-weight: 700;
                font-size: 9px;
            }
            
            /* Style for time header in the top row */
            th.time-column {
                background-color: #1e40af;
                color: white;
                font-weight: 700;
            }
            
            td {
                border: 1px solid #000000;
                padding: 2px;
                text-align: center;
                vertical-align: middle;
                background-color: #f8f8f8;
            }
            
            .time-column {
                background-color: #e0e0e0;
                font-weight: 700;
                color: #000000;
                width: 60px;
            }
            
            .event-cell {
                background-color: #d1e4ff;
                border: 1.5px solid #000000;
            }
            
            .event-title {
                font-weight: 700;
                color: #000000;
                margin-bottom: 1px;
                font-size: 8px;
            }
            
            .event-description {
                color: #333333;
                font-size: 7px;
                font-weight: 500;
                line-height: 1.2;
            }
            
            .rehat-cell {
                background-color: #ffcccf;
                border: 1.5px solid #000000;
                color: #c62828;
                font-weight: 700;
            }
            
            .multi-event-container {
                display: flex;
                flex-direction: column;
                gap: 2px;
            }
            
            .event-divider {
                border-top: 1px dashed #ccc;
                margin: 1px 0;
            }
            
            .print-date {
                text-align: right;
                color: #999;
                font-size: 8px;
                margin-top: 5px;
            }
            
            footer {
                text-align: center;
                margin-top: 5px;
                font-size: 8px;
                color: #999;
            }
            
            /* New classes for program and lecturer info */
            .event-description.program-info {
                font-weight: 600;
                background-color: rgba(0, 0, 0, 0.05);
                padding: 1px 2px;
                border-radius: 2px;
                margin-top: 1px;
                font-size: 7px;
            }
            
            .event-description.lecturer-info {
                font-weight: 600;
                background-color: rgba(255, 255, 255, 0.3);
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 1px 2px;
                border-radius: 2px;
                margin-top: 1px;
                font-size: 7px;
            }
            
            /* Table footer for page number */
            .table-footer {
                text-align: center;
                font-size: 7px;
                border: none !important;
                background: transparent !important;
            }
            
            @media print {
                body {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
                
                .container {
                    padding: 0;
                }
                
                /* Ensure text is dark enough for printing */
                * {
                    color: #000000 !important;
                }
                
                th {
                    background-color: #1e40af !important;
                    color: white !important;
                    font-weight: 800 !important;
                    border: 1px solid #000000 !important;
                }
                
                td {
                    background-color: #f8f8f8 !important;
                    border: 1px solid #000000 !important;
                }
                
                .time-column {
                    background-color: #e0e0e0 !important;
                    color: #000000 !important;
                    font-weight: 700 !important;
                }
                
                .event-cell {
                    background-color: #d1e4ff !important;
                    border: 1.5px solid #000000 !important;
                }
                
                .rehat-cell {
                    background-color: #ffcccf !important;
                    color: #c62828 !important;
                    font-weight: 700 !important;
                    border: 1.5px solid #000000 !important;
                }
                
                .event-title {
                    font-weight: 700 !important;
                }
                
                .event-description {
                    font-weight: 600 !important;
                }
                
                .event-description.program-info {
                    background-color: rgba(0, 0, 0, 0.05) !important;
                    font-weight: 700 !important;
                }
                
                .event-description.lecturer-info {
                    background-color: rgba(255, 255, 255, 0.3) !important;
                    border: 1px solid rgba(0, 0, 0, 0.1) !important;
                    font-weight: 700 !important;
                }
                
                .table-footer {
                    background: transparent !important;
                    border: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Lecturer Timetable</h1>
            </div>
            
            <div class="lecturer-info">
                <p><strong>Name:</strong> ${name}</p>
                <p><strong>IC:</strong> ${ic}</p>
                <p><strong>Staff No:</strong> ${staffNo}</p>
                <p><strong>Email:</strong> ${email}</p>
            </div>
            
            <table>
                <!-- Table Header (repeats on each page) -->
                <thead>
                    <tr>
                        <th class="time-column">Time</th>`;

    // Column headers for days
    dayNames.forEach(day => {
        html += `<th>${day}</th>`;
    });

    html += `</tr></thead>
                
                <!-- Table Footer (repeats on each page) -->
                <tfoot>
                    <tr>
                        <td colspan="${dayNames.length + 1}" class="table-footer">
                            ${name} - Timetable - Generated on: ${currentDate}
                        </td>
                    </tr>
                </tfoot>
                
                <tbody>`;

    // For each timeslot row
    for (let t = 0; t < times.length; t++) {
        // Build the time label, e.g. "08:30 - 09:00"
        let timeLabel = times[t];
        if (t < times.length - 1) {
            timeLabel += ' - ' + times[t + 1];
        } else {
            timeLabel += ' - 17:15';
        }

        // Start a row
        html += `<tr>`;

        // Left column: time label
        html += `<td class="time-column">${timeLabel}</td>`;

        // For each day column
        for (let d = 0; d < dayNames.length; d++) {
            // If this slot is marked skip => do nothing
            if (skip[d][t]) {
                continue; 
            }

            let eventList = scheduleData[d][t];
            
            if (eventList.length > 0) {
                // Check if there's a REHAT event in this cell
                let hasRehat = eventList.some(event => event.title === 'REHAT');
                
                // If there's a REHAT event, give it priority
                if (hasRehat) {
                    let rehatEvent = eventList.find(event => event.title === 'REHAT');
                    
                    let start = rehatEvent.start;
                    let end = rehatEvent.end || new Date(start.getTime() + 60 * 60 * 1000);
                    
                    let startTimeStr = toHHMM(start);
                    let endTimeStr = toHHMM(end);
                    
                    let startIndex = times.indexOf(startTimeStr);
                    let endIndex = times.indexOf(endTimeStr);
                    if (endIndex === -1) endIndex = times.length;
                    
                    let rowSpan = endIndex - startIndex;
                    
                    // Mark future slots to skip
                    for (let k = 1; k < rowSpan; k++) {
                        if (t + k < times.length) {
                            skip[d][t + k] = true;
                        }
                    }
                    
                    // Create cell with REHAT
                    html += `<td rowspan="${rowSpan}" class="rehat-cell">
                                <div class="event-title">REHAT</div>
                            </td>`;
                    
                    // Skip processing other events in this cell
                    continue;
                }
                
                // Group non-REHAT events by their full time span
                let eventGroups = {};
                
                eventList.forEach(event => {
                    // Skip if we already processed this event
                    if (processedEvents.has(event.id)) return;
                    
                    let start = event.start;
                    let end = event.end || new Date(start.getTime() + 60 * 60 * 1000);
                    
                    let startTimeStr = toHHMM(start);
                    let endTimeStr = toHHMM(end);
                    
                    let startIndex = times.indexOf(startTimeStr);
                    let endIndex = times.indexOf(endTimeStr);
                    if (endIndex === -1) endIndex = times.length;
                    
                    // Create a unique key for this time span
                    let timeSpanKey = `${startIndex}-${endIndex}`;
                    
                    // Initialize group if not exists
                    if (!eventGroups[timeSpanKey]) {
                        eventGroups[timeSpanKey] = {
                            events: [],
                            rowSpan: endIndex - startIndex
                        };
                    }
                    
                    // Add event to the group
                    eventGroups[timeSpanKey].events.push(event);
                    
                    // Mark event as processed
                    processedEvents.add(event.id);
                });
                
                // Get the keys sorted by start time
                let timeSpanKeys = Object.keys(eventGroups).sort();
                
                // Only process if we have groups and this is the starting row for a group
                if (timeSpanKeys.length > 0) {
                    let firstGroup = eventGroups[timeSpanKeys[0]];
                    let rowSpan = firstGroup.rowSpan;
                    let events = firstGroup.events;
                    
                    // Mark future slots to skip
                    for (let k = 1; k < rowSpan; k++) {
                        if (t + k < times.length) {
                            skip[d][t + k] = true;
                        }
                    }
                    
                    // Create cell with rowspan
                    html += `<td rowspan="${rowSpan}" class="event-cell">`;
                    
                    // Now just display the events without REHAT check (handled earlier)
                    {
                        // Start multi-event container if we have multiple events
                        if (events.length > 1) {
                            html += `<div class="multi-event-container">`;
                        }
                        
                        // Add each event
                        events.forEach((event, index) => {
                            if (index > 0) {
                                html += `<div class="event-divider"></div>`;
                            }
                            
                            // Title
                            html += `<div class="event-title">${event.title || '(No Title)'}</div>`;
                            
                            // Add description if available
                            if (event.extendedProps && event.extendedProps.description) {
                                html += `<div class="event-description">${event.extendedProps.description}</div>`;
                            }
                            
                            // Add program info if available (only once, with special class)
                            if (event.extendedProps && event.extendedProps.programInfo) {
                                html += `<div class="event-description program-info">Program: ${event.extendedProps.programInfo}</div>`;
                            }
                            
                            // Add lecturer info if available (was missing before)
                            if (event.extendedProps && event.extendedProps.lectInfo) {
                                html += `<div class="event-description lecturer-info">Lecturer: ${event.extendedProps.lectInfo}</div>`;
                            }
                        });
                        
                        // Close multi-event container if needed
                        if (events.length > 1) {
                            html += `</div>`;
                        }
                    }
                    
                    html += `</td>`;
                } else {
                    // No unprocessed events => empty cell
                    html += `<td></td>`;
                }
            } else {
                // No events => just a normal empty cell
                html += `<td></td>`;
            }
        }

        // Close row
        html += `</tr>`;
    }
    
    html += `
                </tbody>
            </table>
            
            <footer>
                © Timetable Management System
            </footer>`;
            
    // Remove the script completely - it's not essential
    // Just close the remaining HTML tags
    html += `
        </div>
    </body>
    </html>`;

    // Open print window
    let printWindow = window.open('', '_blank', 'width=1100,height=800');
    printWindow.document.open();
    printWindow.document.write(html);
    printWindow.document.close();
    
    // Wait for content to load before printing
    setTimeout(() => {
        printWindow.focus();
        printWindow.print();
    }, 1000);
}

// Helper to convert Date -> "HH:MM"
function toHHMM(dateObj) {
    let hh = String(dateObj.getHours()).padStart(2, '0');
    let mm = String(dateObj.getMinutes()).padStart(2, '0');
    return hh + ':' + mm;
}
</script>
@stop