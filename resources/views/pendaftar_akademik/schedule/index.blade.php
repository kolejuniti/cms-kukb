@extends('layouts.pendaftar_akademik')

@section('main')
<!-- Content Header (Page header) -->
<div class="content-wrapper" style="min-height: 695.8px;">
  <div class="container-full">
    <!-- Content Header (Page header) -->	  
    <div class="content-header">
      <div class="d-flex align-items-center">
        <div class="me-auto">
          <h4 class="page-title">Student List</h4>
          <div class="d-inline-block align-items-center">
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                <li class="breadcrumb-item active" aria-current="page">Student List</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Search Student</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        {{-- <div class="card-body">
          <div class="row mt-3 ">
            <div class="col-md-6 mr-3" id="room-card">
              <div class="form-group">
                <label class="form-label" for="room">Room</label>
                <select class="form-select" id="room" name="room">
                  <option value="-" selected>-</option>
                  @foreach ($data['room'] as $rm)
                  <option value="{{ $rm->id }}">{{ $rm->name }}</option> 
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6 mr-3" id="session-card">
              <div class="form-group">
                <label class="form-label" for="session">Session</label>
                <select class="form-select" id="session" name="session">
                  <option value="-" selected>-</option>
                  @foreach ($data['session'] as $ses)
                  <option value="{{ $ses->SessionID }}">{{ $ses->SessionName}}</option> 
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mt-3">
              <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary pull-right mb-3" onclick="submit()">Submit</button>
              </div>
            </div>
          </div>
        </div> --}}
        @if(request()->type == 'lct')
        <div class="card-body">
            <table id="complex_header" class="table table-striped projects display dataTable">
                <thead>
                    <tr>
                        <th>
                            No.
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Ic
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody id="table">
                @if(isset($data['lecturer']) && count($data['lecturer']) > 0)
                    @foreach ($data['lecturer'] as $key => $lct)
                        <tr>
                            <td>
                                {{ $key+1 }}
                            </td>
                            <td>
                                {{ $lct->name }}
                            </td>
                            <td>
                                {{ $lct->ic }}
                            </td>
                            <td class="project-actions text-right" >
                                <a class="btn btn-info btn-sm" href="/AR/schedule/scheduleTable/{{ $lct->ic }}?type={{ request()->type }}">
                                    <i class="ti-info-alt"></i>
                                    Table
                                </a>
                                {{-- <a class="btn btn-danger btn-sm" href="#" onclick="deleteMaterial('{{ $lct->ic }}')">
                                    <i class="ti-trash"></i>
                                    Delete
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No lecturers available.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        @elseif(request()->type == 'std')
        <div class="card-body">
          <table id="complex_header" class="table table-striped projects display dataTable">
              <thead>
                  <tr>
                      <th>
                          No.
                      </th>
                      <th>
                          Name
                      </th>
                      <th>
                          Ic
                      </th>
                      <th>
                          Program
                      </th>
                      <th>
                      </th>
                  </tr>
              </thead>
              <tbody id="table">
              @if(isset($data['student']) && count($data['student']) > 0)
                  @foreach ($data['student'] as $key => $std)
                      <tr>
                          <td>
                              {{ $key+1 }}
                          </td>
                          <td>
                              {{ $std->name }}
                          </td>
                          <td>
                              {{ $std->ic }}
                          </td>
                          <td>
                            {{ $std->progcode }} - {{ $std->progname }}
                          </td>
                          <td class="project-actions text-right" >
                              <a class="btn btn-info btn-sm" href="/AR/schedule/scheduleTable/{{ $std->ic }}?type={{ request()->type }}">
                                  <i class="ti-info-alt"></i>
                                  Table
                              </a>
                              {{-- <a class="btn btn-danger btn-sm" href="#" onclick="deleteMaterial('{{ $lct->ic }}')">
                                  <i class="ti-trash"></i>
                                  Delete
                              </a> --}}
                          </td>
                      </tr>
                  @endforeach
              @else
                  <tr>
                      <td colspan="4">No lecturers available.</td>
                  </tr>
              @endif
              </tbody>
          </table>
        </div>
        @elseif(request()->type == 'lcr')
        <div class="card-body">
          <table id="complex_header" class="table table-striped projects display dataTable">
              <thead>
                  <tr>
                    <th style="width: 1%">
                        No.
                    </th>
                    <th>
                        Room Name
                    </th>
                    <th>
                        Start Time
                    </th>
                    <th>
                        End Time
                    </th>
                    <th>
                        Capacity
                    </th>
                    <th>
                        Total Hour Per Day
                    </th>
                    <th>
                        Projector
                    </th>
                    <th>
                        Weekend
                    </th>
                    <th>
                        Description
                    </th>
                      <th>
                      </th>
                  </tr>
              </thead>
              <tbody id="table">
              @if(isset($data['room']) && count($data['room']) > 0)
                  @foreach ($data['room'] as $key => $rm)
                      <tr>
                          <td style="width: 1%">
                            {{ $key+1 }}
                          </td>
                          <td>
                            {{ $rm->name }}
                          </td>
                          <td>
                            {{ (new DateTime($rm->start))->format('h:i A') }}
                          </td>
                          <td>
                            {{ (new DateTime($rm->end))->format('h:i A') }}
                          </td>
                          <td>
                            {{ $rm->capacity }}
                          </td>
                          <td>
                            {{ $rm->total_hour }}
                          </td>
                          <td>
                            {{ $rm->projector }}
                          </td>
                          <td>
                            @if($rm->weekend == 0 )
                            No
                            @else
                            Yes
                            @endif
                          </td>
                          <td>
                            {!! $rm->description !!}
                          </td>
                          <td class="project-actions text-right" >
                              <a class="btn btn-info btn-sm" href="/AR/schedule/scheduleTable/{{ $rm->id }}?type={{ request()->type }}">
                                  <i class="ti-info-alt"></i>
                                  Table
                              </a>
                              {{-- <a class="btn btn-danger btn-sm" href="#" onclick="deleteMaterial('{{ $lct->ic }}')">
                                  <i class="ti-trash"></i>
                                  Delete
                              </a> --}}
                          </td>
                      </tr>
                  @endforeach
              @else
                  <tr>
                      <td colspan="4">No lecturers available.</td>
                  </tr>
              @endif
              </tbody>
          </table>
        </div>
        @endif
        <!-- /.card-body -->
        <div id="uploadModal" class="modal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
              <!-- modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <div class="">
                        <button class="close waves-effect waves-light btn btn-danger btn-sm pull-right" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                </div>
                <div class="modal-body" id="getModal">
                  
                </div>
              </div>
          </div>
        </div>
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
</div>

{{-- @if(session('newStud'))
    <script>
      alert('Success! Student has been registered!')
      window.open('/pendaftar/surat_tawaran?ic={{ session("newStud") }}')
    </script>
@endif --}}

<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script src="{{ asset('assets/src/js/pages/data-table.js') }}"></script>

<script type="text/javascript">

  function deleteMaterial(id){     
      Swal.fire({
    title: "Are you sure?",
    text: "This will be permanent",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!"
  }).then(function(res){
    
    if (res.isConfirmed){
              $.ajax({
                  headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
                  url      : "{{ url('/pendaftar/delete') }}",
                  method   : 'DELETE',
                  data 	 : {id:id},
                  error:function(err){
                      alert("Error");
                      console.log(err);
                  },
                  success  : function(data){
                      window.location.reload();
                      alert("success");
                  }
              });
          }
      });
  }

</script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

  <script type="text/javascript">
    var selected_session = "";

    $(document).on('change', '#session', function(e){
    selected_session = $(e.target).val();

      getStudent(selected_session);

    });

  function getStudent(session)
  {

    $('#complex_header').DataTable().destroy();

    return $.ajax({
            headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
            url      : "{{ url('AR/schedule/getLectureRoom') }}",
            method   : 'POST',
            data 	 : {session: session},
            beforeSend:function(xhr){
              $("#complex_header").LoadingOverlay("show", {
                image: `<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="30px" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                  <rect x="0" y="10" width="4" height="10" fill="#333" opacity="0.2">
                  <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0s" dur="0.6s" repeatCount="indefinite"></animate>
                  <animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0s" dur="0.6s" repeatCount="indefinite"></animate>
                  <animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0s" dur="0.6s" repeatCount="indefinite"></animate>
                  </rect>
                  <rect x="8" y="10" width="4" height="10" fill="#333" opacity="0.2">
                  <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.15s" dur="0.6s" repeatCount="indefinite"></animate>
                  <animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite"></animate>
                  <animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite"></animate>
                  </rect>
                  <rect x="16" y="10" width="4" height="10" fill="#333" opacity="0.2">
                  <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>
                  <animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>
                  <animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>
                  </rect>
                </svg>`,
                background:"rgba(255,255,255, 0.3)",
                imageResizeFactor : 1,    
                imageAnimation : "2000ms pulse" , 
                imageColor: "#019ff8",
                text : "Please wait...",
                textResizeFactor: 0.15,
                textColor: "#019ff8",
                textColor: "#019ff8"
              });
              $("#complex_header").LoadingOverlay("hide");
            },
            error:function(err){
                alert("Error");
                console.log(err);
            },
            success  : function(data){
                $('#complex_header').removeAttr('hidden');
                $('#complex_header').html(data);
                
                $('#complex_header').DataTable({
                  dom: 'lBfrtip', // if you remove this line you will see the show entries dropdown
                  
                  buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                  ],
                });
                //window.location.reload();
            }
        });
  }

  function submit()
  {

    var formData = new FormData();

    getInput = {
      room : $('#room').val(),
      session : $('#session').val()
    };
    
    formData.append('formData', JSON.stringify(getInput));

    $.ajax({
        headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
        url: "{{ url('AR/schedule/createLectureRoom') }}",
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
                    alert("Success! Class has been added/created!")
                    getStudent($('#session').val());
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

  </script>
@endsection
