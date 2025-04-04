
<head>
    <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>EduHub - @yield('title')</title>

  {{-- <link rel="stylesheet" media="screen, print" href="{{ asset('assets/src/css/datagrid/datatables/datatables.bundle.css') }}"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('assets/assets/vendor_components/datatable/datatables.css') }}"> --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/css-skeletons@1.0.3/css/css-skeletons.min.css"/> --}}
  <link rel="stylesheet" href="https://unpkg.com/css-skeletons@1.0.3/css/css-skeletons.min.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
   <style>
    @page {
       size: A4 potrait; /* reduced height for A5 size in landscape orientation */
       margin: 1cm;
     }
 
     * {
         margin: 0;
         padding: 0;
         border: 0;
         outline: 0;
         vertical-align: baseline;
         background: transparent;
         font-size: 9px;
         padding: 1px;   
     }
     h1 {
         margin: 0;
         padding: 0;
         border: 0;
         outline: 0;
         vertical-align: baseline;
         background: transparent;
         font-size: 20px;
     }
     h2,h3,p {
         margin: 0;
         padding: 0;
         border: 0;
         outline: 0;
         vertical-align: baseline;
         background: transparent;
         font-size: 9px;
     }

     .table-fit-content {
    width: auto;         /* Fit to content, rather than stretching to full width */
    max-width: 30%;     /* Ensure it doesn't overflow the parent container */
    border-collapse: collapse;
    margin: auto;        /* Center the table if smaller than the parent width */
}


     /* Base table styles */
table {
    width: 100%;            /* Make the table take up the full width */
    border-collapse: collapse; /* Remove gaps between cells */
    font-size: 16px;        /* Set base font size */
    margin-bottom: 20px;   /* Add space below the table */
}

     /* Headers */
th {
    background-color: #f4f4f4;  /* Light gray background */
    font-weight: bold;      /* Bold font for headers */
    text-align: left;       /* Left-align header text */
    padding: 5px;          /* Add padding */
    border: 1px solid #ddd; /* Light gray border */
}

/* Cells */
td {
    padding: 5px;          /* Add padding to cells */
    border: 1px solid #ddd; /* Light gray border */
    vertical-align: top;    /* Align content to top */
}

/* Rows */
tr:nth-child(even) {
    background-color: #f9f9f9; /* Alternate row color for better readability */
}

tr:hover {
    background-color: #e6e6e6; /* Highlight row on hover */
}
     </style>
  </head>
  
  
  
 <body>
    <div class="container">
        <!-- BEGIN INVOICE -->
        <div class="col-12">
        {{-- <h1>Daily Report as of {{ $data['from'] }} until {{ $data['to'] }}</h1> --}}
        <br>
        <br>
        <!--pre registration -->
            <div class="card mb-3" id="stud_info">
                <div class="card-header">
                <b>Sponsor Info</b>
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p>Sponsor &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; {{ $data['info']->sponsor }}</p>
                            </div>
                            <div class="form-group">
                                <p>No. Voucher &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; {{ $data['info']->no_document }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Students -->
            <div class="card mb-3" id="stud_info">
                <div class="card-header">
                <b>Students</b>
                </div>
                <div class="card-body p-0">
                <table class="w-100 table table-bordered display margin-top-10 w-p100">
                    <thead>
                        <tr>
                            <th>
                              #
                            </th>
                            <th>
                                Student name
                            </th>
                            <th>
                                Ic/Passport No.
                            </th>
                            <th>
                                Program
                            </th>
                            <th>
                                Matric No.
                            </th>
                            <th style="text-align: center;">
                                Total Sponsorship
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table">
                        @foreach($data['students'] as $key => $std)
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
                              {{ $std->progcode }}
                            </td>
                            <td>
                              {{ $std->no_matric }}
                            </td>
                            <td style="text-align: center;">
                              {{ $std->amount }}
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
            
            <div class="row justify-content-center">
                <!-- pecahan -->
                <div class="card col-md-2 mb-3" id="stud_info" style="margin-right: 2%">
                    <div class="card-body p-0">
                        <table class="table-fit-content">
                            <tbody id="table">
                                <tr>
                                    <td>
                                        <table class="table-fit-content">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" style="text-align: center">
                                                        Sponsor Total By Program
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 1%">
                                                        No.
                                                    </th>
                                                    <th style="width: 5%">
                                                        PROGRAM
                                                    </th>
                                                    <th style="width: 5%">
                                                        QUOTE
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="table">
                                                @foreach ($data['program'] as $key => $prg)
                                                <tr>
                                                  <td>
                                                    {{ $prg->program_ID }}
                                                  </td>
                                                  <td>
                                                    {{ $prg->progcode }}
                                                  </td>
                                                  <td>
                                                    {{ (!empty($data['totalPayment'])) ? number_format($data['totalPayment'][$key], 2) : 0.00}}
                                                  </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" style="text-align: center">
                                                        TOTAL
                                                    </td>
                                                    <td>
                                                        {{ number_format(array_sum($data['totalPayment']), 2) }}
                                                    </td>
                                                  </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- END INVOICE -->
    </div>
 </body>
 <script type="text/javascript">
 
    $(document).ready(function () {
        window.print();
    });
    
    </script>