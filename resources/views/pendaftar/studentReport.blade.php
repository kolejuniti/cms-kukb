@extends((Auth::user()->usrtype == "RGS") ? 'layouts.pendaftar' : (Auth::user()->usrtype == "FN" ? 'layouts.finance' : (Auth::user()->usrtype == "AR" ? 'layouts.pendaftar_akademik' : (Auth::user()->usrtype == "ADM" ? 'layouts.admin' : ''))))

@section('main')
<!-- Content Header (Page header) -->
<div class="content-wrapper" style="min-height: 695.8px;">
  <div class="container-full">
  <!-- Content Header (Page header) -->	  
  <div class="content-header">
    <div class="d-flex align-items-center">
      <div class="me-auto">
        <h4 class="page-title">Student Report</h4>
        <div class="d-inline-block align-items-center">
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
              <li class="breadcrumb-item" aria-current="page">Dashboard</li>
              <li class="breadcrumb-item active" aria-current="page">Student Report</li>
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
                <h3 class="card-title">Student Report</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                {{-- <div class="row">
                  <div class="col-md-3">
                      <div class="form-group">
                      <label class="form-label" for="name">Date</label>
                      <input type="date" class="form-control" id="date" name="date">
                      </div>
                  </div>
                </div> --}}
                <div class="card-body" style="width: 100%; overflow-x: auto;">
                    <table id="table_dismissed" class="w-100 table display margin-top-10 w-p100 table-layout: fixed;" style="width: 100%;">
                      <thead style="background-color: darkcyan">
                        <tr>
                          <th style="text-align: center; border: 1px solid black;" colspan="2"> </th>
                          <th style="text-align: center; border: 1px solid black;" colspan="2">Holding</th>
                          <th style="text-align: center; border: 1px solid black;" colspan="2">40</th>
                          <th style="text-align: center; border: 1px solid black;" colspan="2">40</th>
                          <th style="text-align: center; border: 1px solid black;" colspan="2">10</th>
                          <th style="text-align: center; border: 1px solid black;" colspan="2">6</th>
                          <th style="text-align: center; border: 1px solid black;" colspan="2">2</th>
                          <th style="text-align: center; border: 1px solid black;" colspan="2">0</th>
                          <th style="text-align: center; border: 1px solid black;" colspan="12"> </th>
                        </tr>
                        <tr>
                          <th style="text-align: center; width: 1%; border: 1px solid black;" rowspan="2">
                          Faculty
                          </th>
                          <th style="text-align: center; width: 20%; border: 1px solid black;" rowspan="2">
                          Program
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="4">
                          Sem 1
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 2
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 3
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 4
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 5
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 6
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 7
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 8
                          </th>
                          <th style="text-align: center; width: 5%; border: 1px solid black;" colspan="2">
                          Sem 9
                          </th>
                          <th style="width: 10%; text-align: center; border: 1px solid black;" rowspan="2">
                          Industry Training
                          </th>
                          <th style="width: 10%; text-align: center; border: 1px solid black;" rowspan="2">
                          Active
                          </th>
                          <th style="width: 10%; text-align: center; border: 1px solid black;" rowspan="2">
                          Active on Leave
                          </th>
                          <th style="width: 10%; text-align: center; border: 1px solid black;" rowspan="2">
                          Postpone
                          </th>
                          <th style="width: 10%; text-align: center; border: 1px solid black;" rowspan="2">
                          Dismissed
                          </th>
                          <th style="width: 10%; text-align: center; border: 1px solid black;" rowspan="2">
                          Suspended
                          </th>
                        </tr>
                        <tr>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                          <th style="border: 1px solid black;">L</th>
                          <th style="border: 1px solid black;">P</th>
                      </tr>
                      </thead>
                      <tbody id="table">
                        @php
                        $totalSum_m1 = 0;
                        $totalSum_f1 = 0;
                        $totalSum_ms1 = 0;
                        $totalSum_fs1 = 0;
                        $totalSum_ms2 = 0;
                        $totalSum_fs2 = 0;
                        $totalSum_ms3 = 0;
                        $totalSum_fs3 = 0;
                        $totalSum_ms4 = 0;
                        $totalSum_fs4 = 0;
                        $totalSum_ms5 = 0;
                        $totalSum_fs5 = 0;
                        $totalSum_ms6 = 0;
                        $totalSum_fs6 = 0;
                        $totalSum_ms7 = 0;
                        $totalSum_fs7 = 0;
                        $totalSum_ms8 = 0;
                        $totalSum_fs8 = 0;
                        $totalSum_ms9 = 0;
                        $totalSum_fs9 = 0;
                        @endphp
                        @foreach ($data['program'] as $key=>$prg)
                        <tr>
                          <td style="text-align: center; border: 1px solid black;">
                          {{ $prg->facultycode }} <br>
                          {{ $data['sum'][$key] }} (ACTIVE)<br>
                          {{ $data['sum2'][$key] }} (TOTAL ALL)
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                          {{ $prg->progcode }}
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['holding_m1'][$key] as $ms1)
                            {{ $ms1 }}
                            @endforeach
                            @php
                                $sum_m1 = array_sum((array) $data['holding_m1'][$key]);
                                $totalSum_m1 += $sum_m1;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['holding_f1'][$key] as $ms1)
                            {{ $ms1 }}
                            @endforeach
                            @php
                                $sum_f1 = array_sum((array) $data['holding_f1'][$key]);
                                $totalSum_f1 += $sum_f1;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms1'][$key] as $ms1)
                            {{ $ms1 }}
                            @endforeach
                            @php
                                $sum_ms1 = array_sum((array) $data['ms1'][$key]);
                                $totalSum_ms1 += $sum_ms1;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs1'][$key] as $fs1)
                            {{ $fs1 }}
                            @endforeach
                            @php
                                $sum_fs1 = array_sum((array) $data['fs1'][$key]);
                                $totalSum_fs1 += $sum_fs1;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms2'][$key] as $ms2)
                            {{ $ms2 }}
                            @endforeach
                            @php
                                $sum_ms2 = array_sum((array) $data['ms2'][$key]);
                                $totalSum_ms2 += $sum_ms2;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs2'][$key] as $fs2)
                            {{ $fs2 }}
                            @endforeach
                            @php
                                $sum_fs2 = array_sum((array) $data['fs2'][$key]);
                                $totalSum_fs2 += $sum_fs2;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms3'][$key] as $ms3)
                            {{ $ms3 }}
                            @endforeach
                            @php
                                $sum_ms3 = array_sum((array) $data['ms3'][$key]);
                                $totalSum_ms3 += $sum_ms3;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs3'][$key] as $fs3)
                            {{ $fs3 }}
                            @endforeach
                            @php
                                $sum_fs3 = array_sum((array) $data['fs3'][$key]);
                                $totalSum_fs3 += $sum_fs3;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms4'][$key] as $ms4)
                            {{ $ms4 }}
                            @endforeach
                            @php
                                $sum_ms4 = array_sum((array) $data['ms4'][$key]);
                                $totalSum_ms4 += $sum_ms4;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs4'][$key] as $fs4)
                            {{ $fs4 }}
                            @endforeach
                            @php
                                $sum_fs4 = array_sum((array) $data['fs4'][$key]);
                                $totalSum_fs4 += $sum_fs4;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms5'][$key] as $ms5)
                            {{ $ms5 }}
                            @endforeach
                            @php
                                $sum_ms5 = array_sum((array) $data['ms5'][$key]);
                                $totalSum_ms5 += $sum_ms5;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs5'][$key] as $fs5)
                            {{ $fs5 }}
                            @endforeach
                            @php
                                $sum_fs5 = array_sum((array) $data['fs5'][$key]);
                                $totalSum_fs5 += $sum_fs5;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms6'][$key] as $ms6)
                            {{ $ms6 }}
                            @endforeach
                            @php
                                $sum_ms6 = array_sum((array) $data['ms6'][$key]);
                                $totalSum_ms6 += $sum_ms6;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs6'][$key] as $fs6)
                            {{ $fs6 }}
                            @endforeach
                            @php
                                $sum_fs6 = array_sum((array) $data['fs6'][$key]);
                                $totalSum_fs6 += $sum_fs6;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms7'][$key] as $ms7)
                            {{ $ms7 }}
                            @endforeach
                            @php
                                $sum_ms7 = array_sum((array) $data['ms7'][$key]);
                                $totalSum_ms7 += $sum_ms7;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs7'][$key] as $fs7)
                            {{ $fs7 }}
                            @endforeach
                            @php
                                $sum_fs7 = array_sum((array) $data['fs7'][$key]);
                                $totalSum_fs7 += $sum_fs7;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms8'][$key] as $ms8)
                            {{ $ms8 }}
                            @endforeach
                            @php
                                $sum_ms8 = array_sum((array) $data['ms8'][$key]);
                                $totalSum_ms8 += $sum_ms8;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs8'][$key] as $fs8)
                            {{ $fs8 }}
                            @endforeach
                            @php
                                $sum_fs8 = array_sum((array) $data['fs8'][$key]);
                                $totalSum_fs8 += $sum_fs8;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['ms9'][$key] as $ms9)
                            {{ $ms9 }}
                            @endforeach
                            @php
                                $sum_ms9 = array_sum((array) $data['ms9'][$key]);
                                $totalSum_ms9 += $sum_ms9;
                            @endphp
                          </td>
                          <td style="border: 1px solid black;">
                            @foreach ((array) $data['fs9'][$key] as $fs9)
                            {{ $fs9 }}
                            @endforeach
                            @php
                                $sum_fs9 = array_sum((array) $data['fs9'][$key]);
                                $totalSum_fs9 += $sum_fs9;
                            @endphp
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @foreach ((array) $data['industry'][$key] as $industry)
                            {{ $industry }}
                            @endforeach
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @foreach ((array) $data['active'][$key] as $active)
                            {{ $active }}
                            @endforeach
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @foreach ((array) $data['active_leave'][$key] as $aol)
                            {{ $aol }}
                            @endforeach
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @foreach ((array) $data['postpone'][$key] as $postpone)
                            {{ $postpone }}
                            @endforeach
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @foreach ((array) $data['dismissed'][$key] as $dismissed)
                            {{ $dismissed }}
                            @endforeach
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @foreach ((array) $data['suspended'][$key] as $suspended)
                            {{ $suspended }}
                            @endforeach
                          </td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                      <tfoot style="background-color: darkcyan">
                        <tr>
                          <td style="border: 1px solid black;">
                            
                          </td>
                          <td style="border: 1px solid black;">
                            TOTAL STUDENT
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_m1 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_f1 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms1 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs1 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms2 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs2 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms3 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs3 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms4 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs4 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms5 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs5 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms6 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs6 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms7 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs7 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms8 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs8 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_ms9 }}
                          </td>
                          <td style="border: 1px solid black;">
                            {{ $totalSum_fs9 }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @php
                              $industry = count(DB::table('students')->where([
                                    ['students.status', 2],
                                    ['students.student_status', 4],
                                    ['students.campus_id', 1]
                                    ])->get());
                            @endphp
                            {{ $industry }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @php
                              $active = count(DB::table('students')->where([
                                    ['students.status', 2],
                                    ['students.campus_id', 1],
                                    ['students.student_status', 2]
                                    ])->get());
                            @endphp
                            {{ $active }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @php
                              $aol = count(DB::table('students')->where([
                                    ['students.status', 2],
                                    ['students.campus_id', 0]
                                    ])
                                    ->whereIn('students.student_status', [2,4])
                                    ->get());
                            @endphp
                            {{ $aol }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @php
                              $postpone = count(DB::table('students')->where([
                                    ['students.status', 6]
                                    ])->get());
                            @endphp
                            {{ $postpone }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @php
                              $dismissed = count(DB::table('students')->where([
                                    ['students.status', 4]
                                    //['students.campus_id', 1]
                                    ])->get());
                            @endphp
                            {{ $dismissed }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;">
                            @php
                              $suspended = count(DB::table('students')->where([
                                    ['students.status', 15]
                                    ])->get());
                            @endphp
                            {{ $suspended }}
                          </td>
                        </tr>
                        <tr>
                          <td style="border: 1px solid black;">
                            
                          </td>
                          <td style="border: 1px solid black;">

                          </td>
                          @php
                            $semester = DB::table('semester')->get();
                          @endphp
                          @foreach ($semester as $sem)
                            @php
                              if($sem->id != 1)
                              {

                                $total = count(DB::table('students')
                                          ->where([
                                            ['semester', $sem->id],
                                            ['status', 2],
                                            ['student_status', 2],
                                            ['campus_id', 1]
                                          ])->get());

                              }else{

                                $holding = count(DB::table('students')
                                          ->where([
                                            ['semester', $sem->id],
                                            ['status', 2],
                                            ['student_status', 1],
                                            ['campus_id', 1]
                                          ])->get());

                                $total2 = count(DB::table('students')
                                          ->where([
                                            ['semester', $sem->id],
                                            ['status', 2],
                                            ['student_status', 2],
                                            ['campus_id', 1]
                                          ])->get());

                              }
                            @endphp

                            @if($sem->id != 1)
                              <td colspan="{{ ($sem->id == 1) ? '4' : '2' }}" style="text-align: center; border: 1px solid black;">
                                {{ $total }}
                              </td>
                            @else
                              <td colspan="2" style="text-align: center; border: 1px solid black;">
                                {{ $holding }}
                              </td>
                              <td colspan="2" style="text-align: center; border: 1px solid black;">
                                {{ $total2 }}
                              </td>
                            @endif
                          @endforeach
                          <td style="text-align: center; border: 1px solid black;">
                            @php
                              $industry = count(DB::table('students')->where([
                                    ['students.status', 2],
                                    ['students.student_status', 4],
                                    ['students.campus_id', 1]
                                    ])->get());
                            @endphp
                            {{ $industry }}
                          </td>
                          @php

                          $total_all = $active + $aol + $postpone + $holding;

                          @endphp
                          <td style="text-align: center; border: 1px solid black;" colspan="3">
                            {{ $total_all }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;" colspan="2">
                          </td>
                        </tr>
                        <tr>
                          <td style="border: 1px solid black;">
                            
                          </td>
                          <td style="border: 1px solid black;">
                            
                          </td>
                          @php
                            $total = count(DB::table('students')
                            ->where([
                              ['semester', 1],
                              ['status', 2],
                              ['campus_id', 1]
                              ])
                              ->whereIn('student_status', [1,2])
                              ->get())
                          @endphp
                          <td colspan="4" style="text-align: center; border: 1px solid black;">
                            {{ $total }}
                          </td>
                          <td colspan="16" style="border: 1px solid black;">

                          </td>
                          @php

                          $total_all = $industry + $active + $aol + $postpone + $holding;

                          @endphp
                          <td style="text-align: center; border: 1px solid black;" colspan="4">
                            {{ $total_all }}
                          </td>
                          <td style="text-align: center; border: 1px solid black;" colspan="2">
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row">
          <div class="card mb-3" id="stud_info">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="form-group">
                            <table id="secondTable" class="w-100 table display margin-top-10 w-p100 table-layout: fixed;" style="background-color: darkcyan">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; border: 1px solid black;">
                                            Pecahan Pelajar Semester 1
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; border: 1px solid black;">
                                            INTAKE
                                        </th>
                                        <th style="text-align: center; border: 1px solid black;">
                                            HOLDING
                                        </th>
                                        <th style="text-align: center; border: 1px solid black;">
                                            KULIAH
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                  $totalKuliah = 0;
                                  $totalHolding = 0;
                                  @endphp
                                  @foreach($data['sessions'] as $key => $ses)
                                    <tr>
                                        <td style="text-align: center; border: 1px solid black;">
                                            {{ $ses->SessionName }}
                                        </td>
                                        <td style="text-align: center; border: 1px solid black;">
                                            {{ $data['holding'][$key] }}
                                        </td>
                                        <td style="text-align: center; border: 1px solid black;">
                                            {{ $data['kuliah'][$key] }}
                                      </td>
                                    </tr>
                                    @php
                                    $totalKuliah += $data['kuliah'][$key];

                                    $totalHolding += $data['holding'][$key];
                                    @endphp
                                  @endforeach
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td style="text-align: center; border: 1px solid black;">JUMLAH</td>
                                    <td style="text-align: center; border: 1px solid black;">
                                      {{ $totalHolding }}
                                    </td>
                                    <td style="text-align: center; border: 1px solid black;">
                                      {{ $totalKuliah }}
                                    </td>
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
    </section>
    <!-- /.content -->
  </div>
</div>

<script>
  $(document).ready( function () {
      $('#table_dismissed').DataTable({
        dom: 'lBfrtip', // if you remove this line you will see the show entries dropdown
        paging: false,

        buttons: [
              {
                extend: 'print',
                text: 'Print',
                orientation: 'landscape', // Set the orientation to landscape
                customize: function(win) {
                  var today = new Date();
                  var dd = String(today.getDate()).padStart(2, '0');
                  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                  var yyyy = today.getFullYear();

                  today = dd + '/' + mm + '/' + yyyy;

                  var body = $(win.document.body);

                  // Clone the main table and ensure the footer is shown
                  var mainTable = $('#table_dismissed').clone();
                  mainTable.find('tfoot').show();

                  // Also clone the additional table you want to include
                  var additionalTable = $('#secondTable').clone();
                  additionalTable.find('tfoot').show();

                  // Clear the body first
                  body.html('');

                  // Append the cloned tables
                  body.append(`<h1>LAPORAN BILANGAN PELAJAR SETAKAT ${today}</h1>`); // Optional: Add a title or any additional content
                  body.append(mainTable); // Append the main table
                  body.append('<h2>Pecahan Pelajar Semester 1</h2>'); // Optional: Add subtitles or descriptions
                  body.append(additionalTable); // Append the additional table

                  // Additional customizations can be done here, like adjusting styles for print
                  body.find('table').addClass('print-table').css({
                      'border-collapse': 'collapse',
                      'width': '100%'
                  });
                  body.find('th, td').css({
                      'border': '1px solid black',
                      'padding': '8px'
                  });
                  body.find('.print-table').css({
                      'margin-bottom': '20px'
                  });

                  
                }
            },
            {
              
              text: 'Excel',
              action: function () {
                // get the HTML table to export
                const table = document.getElementById("table_dismissed");
                
                // create a new Workbook object
                const wb = XLSX.utils.book_new();
                
                // add a new worksheet to the Workbook object
                const ws = XLSX.utils.table_to_sheet(table);
                XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                
                // trigger the download of the Excel file
                XLSX.writeFile(wb, "exported-data.xlsx");
              }
            }
        ],

      });

      let db = document.getElementById("table_dismissed");
      let dbRows = db.rows;
      let lastValue = "";
      let lastCounter = 1;
      let lastRow = 0;
      for (let i = 0; i < dbRows.length; i++) {
        let thisValue = dbRows[i].cells[0].innerHTML;
        if (thisValue == lastValue) {
          lastCounter++;
          dbRows[lastRow].cells[0].rowSpan = lastCounter;
          dbRows[i].cells[0].style.display = "none";
        } else {
          dbRows[i].cells[0].style.display = "table-cell";
          lastValue = thisValue;
          lastCounter = 1;
          lastRow = i;
        }
      }

      // Remove the cells that are hidden
      $("#table_dismissed td:first-child:hidden").remove();
        } );
</script>

<script type="text/javascript">

/*$(document).on('change', '#date', function(){

    var date = $(this).val();

    getReport(date);

});

function getReport(date)
{

  $('#table_dismissed').DataTable().destroy();

    return $.ajax({
            headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
            url      : "{{ url('pendaftar/student/report/getStudentReport') }}",
            method   : 'POST',
            data 	 : {date: date},
            beforeSend:function(xhr){
              $("#table_dismissed").LoadingOverlay("show", {
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
              $("#table_dismissed").LoadingOverlay("hide");
            },
            error:function(err){
                alert("Error");
                console.log(err);
            },
            success  : function(data){
                $('#table_dismissed').removeAttr('hidden');
                $('#table_dismissed').html(data);
                
                $('#table_dismissed').DataTable();
                //window.location.reload();
            }
        });
  
}*/



 window.onload = mergeCells;
 

</script>
@endsection
