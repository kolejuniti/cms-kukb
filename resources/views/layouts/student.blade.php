<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">
    <title>EduHub - @yield('title')</title>
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('assets/src/css/vendors_css.css') }}">
	<!-- Style-->  
	<link rel="stylesheet" href="{{ asset('assets/src/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/src/css/skin_color.css') }}">
	{{-- <link rel="stylesheet" media="screen, print" href="{{ asset('assets/src/css/datagrid/datatables/datatables.bundle.css') }}"> --}}
	{{-- <link rel="stylesheet" href="{{ asset('assets/assets/vendor_components/datatable/datatables.css') }}"> --}}
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/css-skeletons@1.0.3/css/css-skeletons.min.css"/> --}}
	<link rel="stylesheet" href="https://unpkg.com/css-skeletons@1.0.3/css/css-skeletons.min.css" />

	<!-- For Collaps -->


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
  </head>

<style>
	
	.unity {
		max-width:170%;
		margin-left:-9px;
		margin-right:-5px;
	}
	.eduhub {
		margin-left:15px;
	}
	.treeview menu-open {
		display: none;
	}
	.light-skin .sidebar-menu > li > .treeview-menu{
		padding-left:6%;
	}

	#treeview-menu-visible {
		margin-left:14px;
	}

	.main-sidebar .sidebar-menu .active{
		color:#019ff8 !important;
		/* color:blue !important; */
	}

	/* custom progres bar */
	.custom-progress {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height:0.3em !important;
		z-index: 9999;
		background-color: #F2F2F2;
	}
	.custom-progress-bar { 
		background-color: #819FF7; 
		background-color:blue;
		width:0%; 
		height:0.3em;
		border-radius: 3px; 
	}
	.custom-percent { 
		position:absolute; 
		display:inline-block; 
		top:3px; 
		left:48%; 
	}

	/* bootstrap select */
	.bootstrap-select .hidden{
		display: none;
	}
	.bootstrap-select div.dropdown-menu.open {
        overflow: hidden;
    }
    .bootstrap-select ul.dropdown-menu.inner{
        max-height: 20em !important;
        overflow-y: auto;
    }

	/* cke editor */
	.ck-editor__editable_inline {
		min-height: 20em;
	}

	.count-circle {
		background-color: red;
		color: white;
		border-radius: 50%;
		padding: 2px 5px;
		font-size: 12px;
		margin-left: 5px;
	}

	.hidden {
		display: none;
	}


</style>



<div class='custom-progress'>
	<div class='custom-progress-bar' id='custom-progress-bar1'></div>
	<div class='custom-percent' id='custom-percent1'></div>
	<input type="hidden" id="custom_progress_width" value="0">
</div>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed sidebar-collapse">
	
<div class="wrapper">
	<div id="loader"></div>
	
  <header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">	
		<!-- Logo -->
		<a href="{{ url('student') }}" class="logo">
		  <!-- logo-->
		  <div class="logo-mini w-30">
			  <span class="light-logo"><img src="{{ asset('assets/images/logo/Kolej-UNITI.png')}}" alt="logo" class="unity"></span>
			  <span class="dark-logo"><img src="{{ asset('assets/images/logo-letter-white.png') }}" alt="logo"></span>
		  </div>
		  <div class="logo-lg">
			  <span class="light-logo"><img src="{{ asset('assets/images/logo_ucms2.png') }}" alt="logo" class="eduhub"></span>
			  <span class="dark-logo"><img src="{{ asset('assets/images/logo_ucms2.png') }}" alt="logo" class="eduhub"></span>
		  </div>
		</a>	
	</div>      
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
	  <div class="app-menu">
		<ul class="header-megamenu nav">
			<li class="btn-group nav-item">
				<a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light ms-0" 
				data-toggle-status="true" data-toggle="push-menu" role="button">
					<i data-feather="menu"></i>
			    </a>
			</li>
			<li class="btn-group d-lg-inline-flex d-none">
				<div class="app-menu">
					<div class="search-bx mx-5">
						<form>
							<div class="input-group">
							  <input type="search" class="form-control" placeholder="Search">
							  <div class="input-group-append">
								<button class="btn" type="submit" id="button-addon3"><i class="icon-Search"><span class="path1"></span><span class="path2"></span></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</li>
		</ul> 
	  </div>
		
      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
			<li class="btn-group d-md-inline-flex d-none">
              <a href="javascript:void(0)" title="skin Change" class="waves-effect skin-toggle waves-light">
			  	<label class="switch">
					<input type="checkbox" data-mainsidebarskin="toggle" id="toggle_left_sidebar_skin">
					<span class="switch-on"><i data-feather="moon"></i></span>
					<span class="switch-off"><i data-feather="sun"></i></span>
				</label>
			  </a>				
            </li>
			<!--<li class="dropdown notifications-menu btn-group">
				<a href="#" class="waves-effect waves-light btn-primary-light svg-bt-icon bg-transparent" data-bs-toggle="dropdown" title="Notifications">
					<i data-feather="bell"></i>
					<div class="pulse-wave"></div>
			    </a>
				<ul class="dropdown-menu animated bounceIn">
				  <li class="header">
					<div class="p-20">
						<div class="flexbox">
							<div>
								<h4 class="mb-0 mt-0">Notifications</h4>
							</div>
							<div>
								<a href="#" class="text-danger">Clear All</a>
							</div>
						</div>
					</div>
				  </li>
				  <li>
					inner menu: contains the actual data
					<ul class="menu sm-scrol">
					  <li>
						<a href="#">
						  <i class="fa fa-users text-info"></i> Curabitur id eros quis nunc suscipit blandit.
						</a>
					  </li>
					  <li>
						<a href="#">
						  <i class="fa fa-warning text-warning"></i> Duis malesuada justo eu sapien elementum, in semper diam posuere.
						</a>
					  </li>
					  <li>
						<a href="#">
						  <i class="fa fa-users text-danger"></i> Donec at nisi sit amet tortor commodo porttitor pretium a erat.
						</a>
					  </li>
					</ul>
				  </li>
				  <li class="footer">
					  <a href="#">View all</a>
				  </li>
				</ul>
			</li>-->
			
			
			<!-- User Account-->
			<li class="dropdown user user-menu">
				<a href="#" class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent p-0 no-shadow" title="User" data-bs-toggle="modal" data-bs-target="#quick_user_toggle">
					<div class="d-flex pt-1 align-items-center">
						<div class="text-end me-10">
							<p class="pt-5 fs-14 mb-0 fw-700"></p>
							<small class="fs-10 mb-0 text-uppercase text-mute"></small>
						</div>
						<img src="{{ Storage::disk('linode')->url('storage/student_image/' . Session::get('User')->ic . '.jpg') }}" class="avatar rounded-circle bg-primary-light h-40 w-40" alt="" />
					</div>
				</a>
			</li>		  
			
        </ul>
      </div>
    </nav>
  </header>
  
  <aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative"> 
	  	<div class="multinav">
		  <div class="multinav-scroll" style="height: 97%;">	
			  <!-- sidebar menu-->
			  <ul class="sidebar-menu" data-widget="tree">	  
        		<li>
					<a href="{{ route('student') }}" class="{{ (route('student') == Request::url()) ? 'active' : ''}}"><i data-feather="bookmark"></i><span>Course</span></a>
				</li> 
				<li>
					<a href="{{ Storage::disk('linode')->url('classschedule/index.htm') }}" target="_blank"><i data-feather="layout"></i><span>Old Timetable</span></a>
				</li>
				<li>
					<a href="AR/schedule/scheduleTable/{{ Auth::guard('student')->user()->ic }}?type=std" target="_blank"><i data-feather="layout"></i><span>Timetable</span></a>
				</li>
				<li class="treeview">
					<a href="#"><i data-feather="users"></i><span>Student Affair</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu treeview-menu-visible" id="treeview-menu-visible">
						<li><a href="{{ route('student.affair.statement') }}" class="{{ (route('student.affair.statement') == Request::url()) ? 'active' : ''}}">Statement</a></li>
						@php
						$range = DB::table('tblresult_period')->first();
						$now = now();

						$block_status = Auth::guard('student')->user()->block_status;
						@endphp

						@if(!$range || ($now >= $range->Start && $now <= $range->End))
						<li><a href="{{ route('student.affair.result') }}" class="{{ (route('student.affair.result') == Request::url()) ? 'active' : ''}}">Result</a></li>
						@endif
						<!-- Link with JavaScript onclick handler -->
						<li>
							<a id="examSlipLink" href="#" target="_blank">Slip Exam</a>
						</li>
					</ul>
				</li> 
				<li class="treeview">
					<a href="#"><i data-feather="message-square"></i><span>Messages</span><span id="total-messages-count" class="count-circle hidden">0</span> <!-- Total count -->
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu treeview-menu-visible" id="treeview-menu-visible">
						<li><a href="#" onclick="getMessage('FN')">UKP <span id="ukp-count" class="count-circle">0</span></a></li>
						<li><a href="#" onclick="getMessage('RGS')">KRP <span id="krp-count" class="count-circle">0</span></a></li>
						<li><a href="#">HEP</a></li>
					</ul>
				</li> 
				<script>
					let previousUkpCount = 0;
					let previousKrpCount = 0;
					let totalCount = 0;

					function updateMessageCount(type, elementId) {
						fetch(`/all/massage/student/countMessage?type=${type}`) // Replace with your API endpoint
							.then(response => response.json())
							.then(data => {
								const count = data.count;
								const element = document.getElementById(elementId);

								if (count === 0) {
									element.classList.add('hidden');
								} else {
									element.classList.remove('hidden');
									element.innerText = count;
								}

								// Check for changes in count and update total accordingly
								if (type === 'FN') {
									if (previousUkpCount !== count) {
										totalCount = totalCount - previousUkpCount + count;
										previousUkpCount = count;
									}
								} else if (type === 'RGS') {
									if (previousKrpCount !== count) {
										totalCount = totalCount - previousKrpCount + count;
										previousKrpCount = count;
									}
								}

								// Update total count display
								const totalElement = document.getElementById('total-messages-count');
								if (totalCount === 0) {
									totalElement.classList.add('hidden');
								} else {
									totalElement.classList.remove('hidden');
									totalElement.innerText = totalCount;
								}
							})
							.catch(error => console.error('Error:', error));
					}

					// Update counts every second
					setInterval(() => {
						updateMessageCount('FN', 'ukp-count');
						updateMessageCount('RGS', 'krp-count');
					}, 1000);


				</script>
				{{-- <li>
					<a href="/yuran-pengajian" class=""><i data-feather="shopping-bag"></i><span>Payment</span></a>
				</li> --}}
				<li>
					<a href="{{ asset('storage/finals_schedule/Jadual Pengawasan Peperiksaan Akhir UNITI Kemasukan Julai 20242025-I.pdf') }}" target="_blank"><i data-feather="layout"></i><span>Finals Timetable</span></a>
				</li> 
			  </ul>
			  <div class="sidebar-widgets">
				  <div class="mx-25 mb-30 pb-20 side-bx bg-primary-light rounded20">
					<div class="text-center">
						<img src="{{ asset('assets/images/svg-icon/color-svg/custom-24.svg') }}" class="sideimg p-5" alt="">
						<h4 class="title-bx text-primary">Best Education Platform</h4>
					</div>
				  </div>
			  </div>
		  </div>
		</div>
    </section>
  </aside>

  <!-- Modal Structure Outside the Sidebar -->
<div id="overlay" style="display: none;">
    <div id="blockAlertModal">
        <div class="warning-icon">
            <!-- Warning SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="orange" viewBox="0 0 24 24">
                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1 17.5h-2v-2h2v2zm0-4.5h-2v-7h2v7z"/>
            </svg>
        </div>
        <h3>Anda mempunyai tunggakan yang perlu dijelaskan, sila semak penyata kewangan anda.</h3>
        <button onclick="closeModal()">OK</button>
    </div>
</div>

<style>
    /* Full-screen overlay background with blur effect */
    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px); /* Blurring effect */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Modal styling */
    #blockAlertModal {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 350px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s ease; /* Optional animation */
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    /* Warning icon styling */
    .warning-icon {
        margin-bottom: 10px;
    }

    /* Button styling */
    #blockAlertModal button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #blockAlertModal button:hover {
        background-color: #0056b3;
    }

    /* Fade-in animation for the modal */
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<script>
    document.getElementById('examSlipLink').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default navigation

        var block_status = {{ $block_status }}; // Fetch the block status from PHP

        if (block_status === 1) {
            // Show the overlay and modal
            document.getElementById('overlay').style.display = 'flex';
        } else {
            // Redirect to the link if block_status is 0
            window.open("/AR/student/getSlipExam?student={{ Auth::guard('student')->user()->ic }}", "_blank");
        }
    });

    function closeModal() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>

	
  <!-- BEGIN Page Content -->
  @yield('main')	
	
	
	
  

  <footer class="main-footer">
    <div class="pull-right d-none d-sm-inline-block">
        <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
		 
		</ul>
    </div>
	  &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://eduhub.intds.com.my">EduHub</a>
  </footer>
  <!-- Side panel -->   
  <!-- quick_user_toggle -->
  <div class="modal modal-right fade" id="quick_user_toggle" tabindex="-1">
	  <div class="modal-dialog">
		<div class="modal-content slim-scroll3">
		  <div class="modal-body p-30 bg-white">
			<div class="d-flex align-items-center justify-content-between pb-30">
				<h4 class="m-0">User Profile
				<small class="text-fade fs-12 ms-5"></small></h4>
				<a href="#" class="btn btn-icon btn-danger-light btn-sm no-shadow" data-bs-dismiss="modal">
					<span class="fa fa-close"></span>
				</a>
			</div>
            <div>
                <div class="d-flex flex-row">
                    <div class=""><img src="{{ Storage::disk('linode')->url('storage/student_image/' . Session::get('User')->ic . '.jpg') }}" alt="user" class="rounded bg-danger-light w-150" width="100"></div>
                    <div class="ps-20">
                        <h5 class="mb-0"></h5>
                        <p class="my-5 text-fade"></p>
                        <a href="mailto:">
							<span class="icon-Mail-notification me-5 text-success"><span class="path1"></span><span class="path2">{{ Session::get('User')->email }}</span></span> 
						</a>
                    </div>
                </div>
			</div>
              <div class="dropdown-divider my-30"></div>
              {{-- <div>
                <div class="d-flex align-items-center mb-30">
                    <div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
                          <span class="icon-Library fs-24"><span class="path1"></span><span class="path2"></span></span>
                    </div>
                    <div class="d-flex flex-column fw-500">
                        <a href="extra_profile.html" class="text-dark hover-primary mb-1 fs-16">My Profile</a>
                        <span class="text-fade">Account settings and more</span>
                    </div>
                </div>
                
              </div> --}}
			  <div>
				  <div class="col-sm-12 d-flex justify-content-center">
				  <a href="/student/setting" type="button" class="waves-effect waves-light btn btn-secondary btn-rounded mb-5" style="margin-right:10px;"><i class="mdi mdi-account-edit"></i> Edit</a>
				  <a href="{{ route('logout') }}" type="button" class="waves-effect waves-light btn btn-secondary btn-rounded mb-5"
				  onclick="event.preventDefault();
				  document.getElementById('logout-form').submit();">
				  <i class="mdi mdi-logout"></i>{{ __('Logout') }}</a>
  
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
					</form>
			  	  </div>
              </div>
              <div class="dropdown-divider my-30"></div>
              
		  </div>
		</div>
	  </div>
  </div>
  <!-- /quick_user_toggle --> 
  
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>	
	
</div>
<!-- ./wrapper -->
	
<div id="app">
	<example-component></example-component>
</div>
			
<!-- Page Content overlay -->
<!-- Vendor JS -->

<script>
    window.Laravel = {
        sessionUserId: 'STUDENT'
    };
  </script>

<script src="{{ mix('js/app.js') }}"></script>

<script src="{{ asset('assets/src/js/vendors.min.js') }}"></script>



<script src="{{ asset('assets/src/js/pages/chat-popup.js') }}"></script>
<script src="{{ asset('assets/assets/icons/feather-icons/feather.min.js') }}"></script>

<script src="{{ asset('assets/assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js') }}"></script>

{{-- <script src="{{ asset('assets/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script> --}}
<script src="{{ asset('assets/assets/vendor_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>	

<script src="{{ asset('assets/assets/vendor_components/full-calendar/moment.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_components/full-calendar/fullcalendar.min.js') }}"></script>

<script src="{{ asset('assets/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js') }}"></script> 

<script src="{{ asset('assets/assets/vendor_components/nestable/jquery.nestable.js') }}"></script> 


<script src="{{ asset('assets/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<script src="{{ asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/assets/vendor_plugins/iCheck/icheck.min.js') }}"></script>


<!-- edulearn App -->
<script src="{{ asset('assets/src/js/demo.js') }}"></script>
<script src="{{ asset('assets/src/js/template.js') }}"></script>
{{-- <script src="{{ asset('assets/src/js/pages/dashboard.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/src/js/pages/demo.calendar.js') }}"></script> --}}
<script src="{{ asset('assets/src/js/pages/owl-slider.js') }}"></script>

	
	
<script src="{{ asset('assets/src/js/pages/advanced-form-element.js') }}"></script>

<script src="{{ asset('assets/assets/vendor_components/datatable/datatables.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>


<script src="http://spp3.intds.com.my/assets/js/formplugins/select2/select2.bundle.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>


	
<script src="{{ asset('assets/src/js/pages/component-animations-css3.js')}}"></script>
	

{{-- 
<script src="{{ asset('assets/src/js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/src/js/datagrid/datatables/datatables.export.js') }}"></script> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script> 

<script src="{{ asset('assets/assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js')}}"></script>	
<script src="{{ asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
 --}}


@yield('content')



</body>
</html>
  
