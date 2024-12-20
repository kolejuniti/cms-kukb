@extends('layouts.student.student')

@section('main')
<!-- Content Header (Page header) -->
<div class="content-wrapper" style="min-height: 695.8px;">
  <div class="container-full">
  <!-- Content Header (Page header) -->	  
  <div class="content-header">
    <div class="d-flex align-items-center">
      <div class="me-auto">
        <h4 class="page-title">Student's Warning letter</h4>
        <div class="d-inline-block align-items-center">
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
              <li class="breadcrumb-item" aria-current="page">Extra</li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Student's Warning letter</h3>
              </div>
              <!-- /.card-header -->
              {{-- <div class="card mb-3">
                <div class="card-header">
                  <b>Search Student</b>
                </div>
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
                </div>
              </div> --}}
              <div id="form-student">
                <!-- form start -->
                  <div class="card mb-3" id="stud_info">
                    <div class="card-header">
                    <b>Student Info</b>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>Student Name &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; {{ $data['student']->name }}</p>
                                </div>
                                <div class="form-group">
                                    <p>Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; {{ $data['student']->statusName }}</p>
                                </div>
                                <div class="form-group">
                                    <p>Program &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; {{ $data['student']->program }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p>No. IC / No. Passport &nbsp; &nbsp;: &nbsp;&nbsp; {{ $data['student']->ic }}</p>
                                </div>
                                <div class="form-group">
                                    <p>No. Matric &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; {{ $data['student']->no_matric }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card mb-3">
                  <div class="card-header">
                    <b>Student Result List</b>
                  </div>
                  <div class="card-body">
                      <div class="card-body">
                          <table id="complex_header" class="table table-striped projects display dataTable">
                              <thead>
                                  <tr>
                                      <th style="width: 1%">
                                          No.
                                      </th>
                                      <th style="width: 10%">
                                          Subject
                                      </th>
                                      <th style="width: 5%">
                                          Session
                                      </th>
                                      <th style="width: 5%">
                                          Semester
                                      </th>
                                      <th style="width: 5%">
                                          Warning
                                      </th>
                                      <th style="width: 5%">
                                      </th>
                                  </tr>
                              </thead>
                              <tbody id="table">
                                  @foreach ($data['letter'] as $key=> $ltr)
                                  <tr>
                                      <td>
                                          {{ $key+1 }}
                                      </td>
                                      <td>
                                        {{ $ltr->course_code }} - {{ $ltr->course_name }}
                                      </td>
                                      <td>
                                          {{ $ltr->SessionName }}
                                      </td>
                                      <td>
                                          {{ $ltr->semesterid }}
                                      </td>
                                      <td>
                                          {{ $ltr->warning }}
                                      </td>
                                      <td>
                                          <a class="btn btn-info btn-sm btn-sm mr-2" href="/AR/student/printWarningLetter?id={{ $ltr->id }}" target="_blank">
                                              <i class="ti-pencil-alt">
                                              </i>
                                              Print
                                          </a>
                                      </td>
                                  </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>
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

<script src="{{ asset('assets/assets/vendor_components/ckeditor/ckeditor.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">

$('#search').keyup(function(event){
    if (event.keyCode === 13) { // 13 is the code for the "Enter" key
        var searchTerm = $(this).val();
        getStudent(searchTerm);
    }
});

$('#student').on('change', function(){
    var selectedStudent = $(this).val();
    getStudInfo(selectedStudent);
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

function getStudInfo(student)
{
    return $.ajax({
            headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
            url      : "{{ url('pendaftar/student/result/getStudentResult') }}",
            method   : 'POST',
            data 	 : {student: student},
            error:function(err){
                alert("Error");
                console.log(err);
            },
            success  : function(data){
              var d = new Date();

              var month = d.getMonth()+1;
              var day = d.getDate();

              var output = d.getFullYear() + '/' +
                  (month<10 ? '0' : '') + month + '/' +
                  (day<10 ? '0' : '') + day;


                $('#form-student').html(data);
            
                $('#complex_header').DataTable({
                  dom: 'lBfrtip', // if you remove this line you will see the show entries dropdown
                  
                  buttons: [
                    {
                        extend: 'excelHtml5',
                        messageTop: output,
                        title: 'Excel' + '-' + output,
                        text:'Export to excel'
                        //Columns to export
                        //exportOptions: {
                       //     columns: [0, 1, 2, 3,4,5,6]
                       // }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'PDF' + '-' + output,
                        text: 'Export to PDF'
                        //Columns to export
                        //exportOptions: {
                       //     columns: [0, 1, 2, 3, 4, 5, 6]
                      //  }
                    }
                  ],
                });
                //$('#student').selectpicker('refresh');

                "use strict";
                ClassicEditor
                .create( document.querySelector( '#commenttxt' ),{ height: '25em' } )
                .then(newEditor =>{editor = newEditor;})
                .catch( error => { console.log( error );});
            }
        });
}

function submitForm(ic)
{
    var forminput = [];
    var formData = new FormData();

    forminput = {
        ic: ic,
        intake: $('#intake').val(),
        batch: $('#batch').val(),
        session: $('#session').val(),
        semester: $('#semester').val(),
        status: $('#status').val(),
        kuliah: $('#kuliah').val(),
        comment: editor.getData(),
      };

    if(forminput.status == '' || forminput.comment == '')
    {

      alert('Please fill in Student Status & Comment before submit!')

    }else{

      formData.append('studentData', JSON.stringify(forminput));

      $.ajax({
          headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
          url: '{{ url('/pendaftar/student/status/storeStudent') }}',
          type: 'POST',
          data: formData,
          cache : false,
          processData: false,
          contentType: false,
          error:function(err){
              console.log(err);
          },
          success:function(res){
              try{
                  if(res.message == "Success"){
                      alert("Success! Status & Student info has been updated!")
                      $('#complex_header').html(res.data);
                      
                  }else{
                      $('.error-field').html('');
                      if(res.message == "Field Error"){
                          for (f in res.error) {
                              $('#'+f+'_error').html(res.error[f]);
                          }
                      }
                      else if(res.message == "Group code already existed inside the system"){
                          $('#classcode_error').html(res.message);
                      }
                      else{
                          alert(res.message);
                      }
                      $("html, body").animate({ scrollTop: 0 }, "fast");
                  }
              }catch(err){
                  alert("Ops sorry, there is an error");
              }
          }
      });

    }

}
</script>
@endsection
