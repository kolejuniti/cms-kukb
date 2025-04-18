<div class="col-12">
  <div class="box">
    <div class="card-header">
    <h3 class="card-title d-flex">Incentive List</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <div id="complex_header_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-sm-12">
                <table id="table_projectprogress_course" class="table table-striped projects display dataTable no-footer " style="width: 100%;">
                    <thead class="thead-themed">
                    <tr>
                        <th style="width: 1%">
                        No.
                        </th>
                        <th style="width: 5%">
                        Session From
                        </th>
                        <th style="width: 5%">
                        Session To
                        </th>
                        <th style="width: 5%">
                        Amount
                        </th>
                        <th style="width: 5%">
                        Program
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data['incentive'] as $keys => $dt)
                        <tr>
                            <td>
                            {{ $keys+1 }}
                            </td>
                            <td >
                            {{ $dt->from }}
                            </td>
                            <td >
                            {{ $dt->to }}
                            </td>
                            <td >
                            {{ $dt->amount }}
                            </td>
                            <td >
                              <a class="btn btn-info btn-sm pr-2" href="#" onclick="getProgram('{{ $dt->id }}')">
                                  <i class="ti-pencil-alt">
                                  </i>
                                  PROGRAM
                              </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="tfoot-themed">
                        <tr>
                            
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>
  </div>
</div>

