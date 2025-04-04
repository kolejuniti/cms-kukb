<div>
  <div class="modal-header">
      <div class="">
          <button class="close waves-effect waves-light btn btn-danger btn-sm pull-right" data-dismiss="modal">
              &times;
          </button>
      </div>
  </div>
  <div class="modal-body">
    <div class="card mb-3" id="stud_info">
      <div class="card-body">
        {{-- <div class="row">
          <div class="col-md-6">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width: 25%">Service Date</td>
                  <td style="width: 10%">27/06/2024</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width: 25%">Odometer (KM)</td>
                  <td style="width: 10%">27</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> --}}
  
        <div class="row">
          <div class="col-md-12">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width: 2%">Subject</td>
                  <td style="width: 1%">:</td>
                  <td style="width: 6.7%">{{ $data['event']->course_code }} - {{ $data['event']->course_name }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
  
        <div class="row">
          <div class="col-md-12">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width: 2%">Session</td>
                  <td style="width: 1%">:</td>
                  <td style="width: 6.7%">{{ $data['event']->SessionName }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
  
        <div class="row">
          <div class="col-md-12">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td style="width: 2%">Lecturer</td>
                  <td style="width: 1%">:</td>
                  <td style="width: 6.7%">{{ $data['event']->lecturer }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  </div>
  <div class="modal-footer">
      
  </div>
</div>