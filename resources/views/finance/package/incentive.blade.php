@extends('../layouts.finance')

@section('main')
<!-- Content Header (Page header) -->
<div class="content-wrapper" style="min-height: 695.8px;">
  <div class="container-full">
    <!-- Content Header (Page header) -->	  
    <div class="content-header">
      <div class="d-flex align-items-center">
        <div class="me-auto">
          <h4 class="page-title">Incentive</h4>
          <div class="d-inline-block align-items-center">
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                <li class="breadcrumb-item" aria-current="page">Package</li>
                <li class="breadcrumb-item active" aria-current="page">Incentive</li>
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
                <h3 class="card-title">Create Incentive</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6" id="program-card">
                    <div class="form-group">
                      <label class="form-label" for="from">FROM</label>
                      <select class="form-select" id="from" name="from">
                        <option value="" selected disabled>-</option>
                        @foreach ($data['session'] as $ses)
                          <option value="{{ $ses->SessionID }}">{{ $ses->SessionName }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>       
                  <div class="col-md-6" id="intake-card">
                    <div class="form-group">
                      <label class="form-label" for="to">TO</label>
                      <select class="form-select" id="to" name="to">
                        <option value="" selected>-</option>
                        @foreach ($data['session'] as $ses)
                          <option value="{{ $ses->SessionID }}">{{ $ses->SessionName }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6" id="claim-card">
                    <div class="form-group">
                      <label class="form-label" for="amount">Amount (RM)</label>
                      <input type="number" id="amount" name="amount" class="form-control">
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
                <hr>
                <div id="add-student-div">
                </div>
              </div>
              <!-- /.card-body -->
              <div id="uploadModal" class="modal fade" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- modal content-->
                  <div class="modal-content" id="getModal">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                      <div id="program_list">

                      </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">

  var getInput = [];

  $(document).ready(function(){

    getIncentive();

  });

  function getIncentive()
  {
    return $.ajax({
            headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
            url      : "{{ url('finance/package/incentive/getIncentive') }}",
            method   : 'GET',
            error:function(err){
                alert("Error");
                console.log(err);
            },
            success  : function(data){
                $('#add-student-div').html(data);
                $('#table_projectprogress_course').DataTable({
                    paging: false
                });


            }
        });
  }

  function submit()
  {

    var formData = new FormData();

    getInput = {
      from : $('#from').val(),
      to : $('#to').val(),
      amount : $('#amount').val()
    };
    
    formData.append('formData', JSON.stringify(getInput));

    $.ajax({
        headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
        url: "{{ url('finance/package/incentive/storeIncentive') }}",
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
                    alert("Success! Incentive has been added/created!")
                    getIncentive();
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

function getProgram(id)
{

  return $.ajax({
      headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
      url      : "{{ url('/finance/package/incentive/getProgram') }}",
      method   : 'POST',
      data 	 : {id: id},
      error:function(err){
          alert("Error");
          console.log(err);
      },
      success  : function(data){
          $('#program_list').html(data);
          $('#uploadModal').modal('show');
      }
  });

}

function Register(prg,id)
{

  return $.ajax({
      headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
      url      : "{{ url('/finance/package/incentive/registerPRG') }}",
      method   : 'POST',
      data 	 : {prg: prg,id: id},
      error:function(err){
          alert("Error");
          console.log(err);
      },
      success  : function(data){
          getProgram(data)
      }
  });

}

function unRegister(prg,id)
{

  return $.ajax({
      headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
      url      : "{{ url('/finance/package/incentive/unregisterPRG') }}",
      method   : 'POST',
      data 	 : {prg: prg,id: id},
      error:function(err){
          alert("Error");
          console.log(err);
      },
      success  : function(data){
          getProgram(data)
      }
  });

}

function updateStartAt(id) {
  var start_at = $('#start_at').val();
  
  $.ajax({
      headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
      url: "{{ url('/finance/package/incentive/updateStartAt') }}",
      method: 'POST',
      data: {
          id: id,
          start_at: start_at
      },
      error: function(err) {
          alert("Error");
          console.log(err);
      },
      success: function(data) {
          if(data.message === "Success") {
              alert("Start At semester has been updated successfully!");
          } else {
              alert(data.message || "Error updating Start At semester");
          }
      }
  });
}

</script>
@endsection
