@php

use Carbon\Carbon;

@endphp

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Tawaran Kemasukan ke Program Akademik Kolej UNITI</title>
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        @page {
        size: A4; /* reduced height for A5 size in landscape orientation */
        }
        * {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
            font-size: 10px;
            
        }
        body {
                background-image: url('{{ asset("assets/images/letter_head/letter_head2.jpg") }}');
                background-size: cover; /* Cover the entire page */
                background-position: center; /* Center the background image */
                background-repeat: no-repeat; /* Do not repeat the image */
                margin-bottom: 10cm;
                margin-left: 1cm;
                margin-right: 1cm;
            }
        h2,h3,p {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
            font-size: 10px;
        }
        .form-group {
            page-break-inside: avoid;
        }
        </style>
    </head>
    <body>
        @php

            // Get the date two weeks before
            $twoWeeksBefore = Carbon::parse($data['student']->date_offer)->subWeeks(2);

            // Convert the date format
            $formattedDate = $twoWeeksBefore->format('d/m/Y');

        @endphp
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p>Ruj. Kami: KJ/KUKB/{{ date('Y') }}/{{ $data['student']->ic }}</p>
        <p class="mt-2">{{ $formattedDate }}</p>
        <p class="mt-2">{{ strtoupper($data['student']->name) }}</p>
        @if($data['address']->address1 != null)<p>{{ strtoupper($data['address']->address1) }}</p>@endif
        @if($data['address']->address2 != null)<p>{{ strtoupper($data['address']->address2) }}</p>@endif
        @if($data['address']->address3 != null)<p>{{ strtoupper($data['address']->address3) }}</p>@endif
        <p>{{ $data['address']->postcode }}</p>
        <p>{{ strtoupper($data['address']->city) }}, {{ strtoupper($data['address']->state) }}</p>
        <p>{{ strtoupper($data['address']->country) }}</p>
        <p>Saudara/Saudari,</p>
        <p class="mt-1"><b>TAWARAN KEMASUKAN KE PROGRAM AKADEMIK KOLEJ UNITI KOTA BHARU SESI {{ $data['student']->intake }}</b></p>
        <p class="mt-1"><b>TAHNIAH</b> dan <b>SUKACITA</b> di maklumkan, saudara/saudari di tawarkan untuk mengikuti pengajian program {{ $data['student']->progname }} di KOLEJ UNITI KOTA BHARU.</p>
        {{-- <div class="col-12 mb-1 mt-1">  
            <div style="border: 0px solid white; padding: 5px;">
            <p>Program &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $data['student']->progname }} (SEPENUH MASA)</b></p>
            <p>Tempoh Pengajian &nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>3 Tahun</b></p>   
            </div> 
        </div> --}}
        <p class="mt-1"><b> Untuk pengetahuan saudara/saudari, program yang diikuti adalah program akademik yang dikendalikan oleh KOLEJ UNITI
            KOTA BHARU, Kampus Kijang, Lot 1911, Jalan Pantai Cahaya Bulan, 15350, Kota Bharu, Kelantan. Setelah memenuhi
            semua keperluan, saudara/saudari akan DIANUGERAHKAN DIPLOMA OLEH KOLEJ UNITI KOTA BHARU.</b></p>
        <p class="mt-1"><b>Berikut merupakan perincian berkenaan dengan maklumat pendaftaran :</b></p>
        <div class="col-5 mb-1 mt-1">
            <div style="border: 1px solid black; padding: 10px;">
            <p>Nama IPT : Kolej UNITI Kota Bharu</p>
            <p>Mod Pengajian : Sepenuh Masa</p>
            <p>Peringkat Pengajian : Diploma</p>
            <p>Program : {{ $data['student']->progname }}</p>
            <p>Tempoh Program : 3 Tahun</p>
            <p>Tarikh Pendaftaran : {{ Carbon::createFromFormat('Y-m-d', $data['student']->date_offer)->format('d/m/Y') }}</p>
            <p>Masa : 9.00 Pagi - 3.00 Petang</p>
            <p>Tarikh  Mula Pengajian : {{ ($data['student']->date_study) ? Carbon::createFromFormat('Y-m-d', $data['student']->date_study)->format('d/m/Y') : '' }}</p>
            </div>
        </div>
        <p class="mt-3">Tawaran ini adalah sah untuk tujuan di atas sahaja.</p>
        <ol class="mt-2">
            <li>Memenuhi syarat kemasukan ke program yang dipohon dan maklumat-maklumat yang diberikan adalah benar. Sekiranya terdapat pemalsuan maklumat dalam borang permohonan dan dokumen yang berkaitan, pihak Kolej UNITI Kota Bharu berhak menarik balik tawaran ini atau saudara/i diberhentikan daripada pengajian pada bila-bila masa.</li>
            <li>Menjelaskan yuran seperti yang dilampirkan.</li>
        </ol>
        <p>Jika saudara/i menerima tawaran ini, sila :</p>
        <ol class="mt-2" type="a">
            <li>Kembalikan Borang Jawapan Penerimaan tawaran kemasukan ke KOLEJ UNITI KOTA BHARU kepada Penolong Pendaftar Kemasukan
                dan Rekod Pelajar.</li>
            <li>Sila pastikan saudara/saudari mempunyai aplikasi myPTPTN untuk proses permohonan pinjaman PTPTN.</li>
            <li>Hadir untuk mendaftarkan diri mengikuti maklumat di atas.</li>
        </ol>
        <p>Semasa mendaftar saudara/i dikehendaki membawa dokumen asal dan salinan yang <b>DISAHKAN</b> seperti berikut :</p>
        <div class="row">
            <div class="d-flex p-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <ul>
                            <li>Surat Tawaran (2 salinan)</li>
                            <li>Salinan Kad Pengenalan pemohon dan penjaga/ibubapa (2 salinan)</li>
                            <li>2 keping gambar ukuran pasport</li>
                            <li>Slip gaji penjaga/ibubapa terkini</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <ul>
                            <li>Salinan Sijil Kelahiran pemohon dan penjaga/ibubapa (2 salinan)</li>
                            <li>Salinan Slip peperiksaan yang berkenaan (2 salinan)</li>
                            <li>Borang J (ibubapa)</li>
                            <li>Laporan kesihatan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <p class="mt-1 mb-1">Sekian, terima kasih.</p>
        <p>Yang benar,</p>
        <img src="{{ asset('storage/signature/signature1.png') }}" alt="Image" width="7%" height="7%">

        <p><b>SERI BANUN BINTI BAHTIAR</b><br>
        KETUA EKSEKUTIF<br>
        <b> KOLEJ UNITI KOTA BHARU</b></p>
        <p class="mt-2">* Pihak Kolej UNITI Kota Bharu berhak menarik balik tawaran ini di atas apa-apa jua alasan dari semasa ke semasa</p>
        <p>* Dokumen ini dicetak oleh komputer dan tidak perlu tandatangan.</p>
    </body>
</html>

<script type="text/javascript">

$(document).ready(function () {
    window.print();
});

</script>