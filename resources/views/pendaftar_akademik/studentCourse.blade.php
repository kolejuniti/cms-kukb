@extends((Auth::user()->usrtype == "AR") ? 'layouts.pendaftar_akademik' : (Auth::user()->usrtype == "PL" ? 'layouts.ketua_program' : ''))

@section('main')
<!-- Content Header (Page header) -->
<div class="content-wrapper" style="min-height: 695.8px;">
  <div class="container-full">
    <!-- Content Header (Page header) -->	  
    <div class="content-header">
      <div class="d-flex align-items-center">
        <div class="me-auto">
          <h4 class="page-title">Assign Group</h4>
          <div class="d-inline-block align-items-center">
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                <li class="breadcrumb-item" aria-current="page">Students</li>
                <li class="breadcrumb-item active" aria-current="page">Group</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      @if($errors->any())
      <a class="btn btn-danger btn-sm ml-2 ">
        <i class="ti-na">
        </i>
        {{$errors->first()}}
      </a>
      @endif
    </div>
  

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Student Subjects</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                          <label class="form-label" for="name">Name / No. IC / No. Matric</label>
                          <input type="text" class="form-control" id="search" placeholder="Search..." name="search">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="student">Student</label>
                            <select class="form-select" id="student" name="student">
                              <option value="-" selected disabled>-</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="semester">Semester</label>
                          <select class="form-select" id="semester" name="semester">
                            <option value="" selected>-</option>
                            @for ($i = 1; $i <= 8; $i++)
                              <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="box-body" id="allcourse" hidden>

                </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">

  var selected_program = null;
  var selected_session = null;
  var selected_student = null;
  var student = document.getElementById('student-card');

  $('#search').keyup(function(event){
    if (event.keyCode === 13) { // 13 is the code for the "Enter" key
        var searchTerm = $(this).val();
        getStudent(searchTerm);
      }
  });

  function getStudent(search)
  {

      return $.ajax({
              headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
              url      : "{{ url('pendaftar/student/status/listStudent') }}",
              method   : 'POST',
              data 	 : {search: search},
              error:function(err){
                  alert("Error");
                  console.log(err);
              },
              success  : function(data){
                  $('#student').html(data);
                  $('#student').selectpicker('refresh');

              }
          });
      
  }

  $(document).on('change', '#student', function(e){
    selected_student = $(e.target).val();

    document.getElementById('allcourse').hidden = false;

    getCourse(selected_student);
  });



  function getCourse(student)
  {
    return $.ajax({
            headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
            url      : "{{ url('AR/student/getCourse') }}",
            method   : 'GET',
            data 	 : {student: student},
            error:function(err){
                alert("Error");
                console.log(err);
            },
            success  : function(data){
                //$('#lecturer-selection-div').removeAttr('hidden');
                $('#allcourse').html(data);
                //$('#student').selectpicker('refresh');
            }
        });
  }

  function register(id,ic)
  {

    semester = $('#semester').val();

    return $.ajax({
            headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
            url      : "{{ url('AR/student/register') }}",
            method   : 'POST',
            data 	 : {id: id,ic: ic, semester: semester},
            error:function(err){
                alert("Error");
                console.log(err);
            },
            success  : function(data){
                //$('#lecturer-selection-div').removeAttr('hidden');
                $('#allcourse').html(data);
                //$('#student').selectpicker('refresh');
            }
        });

  }

  function register2(ic)
  {
    id = $('#course2').val();
    semester = $('#semester').val();

    if(id == null)
    {

      alert('Please select a course first from the list');

    }else{

      return $.ajax({
              headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
              url      : "{{ url('AR/student/register') }}",
              method   : 'POST',
              data 	 : {id: id,ic: ic,semester: semester},
              error:function(err){
                  alert("Error");
                  console.log(err);
              },
              success  : function(data){
                  //$('#lecturer-selection-div').removeAttr('hidden');
                  $('#allcourse').html(data);
                  //$('#student').selectpicker('refresh');
              }
          });

    }

  }


  function unregister(id,ic)
  {

    Swal.fire({
    title: "Are you sure?",
    text: "This will be permanent",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!"
  }).then(function(res){
    
    if (res.isConfirmed){

        $.ajax({
            headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
            url      : "{{ url('AR/student/unregister') }}",
            method   : 'DELETE',
            data 	 : {id: id,ic: ic},
            error:function(err){
                alert("Error");
                console.log(err);
            },
            success  : function(data){
                //$('#lecturer-selection-div').removeAttr('hidden');
                $('#allcourse').html(data);
                //$('#student').selectpicker('refresh');
            }
        });

      }
      });
      
  }

</script>
@endsection
