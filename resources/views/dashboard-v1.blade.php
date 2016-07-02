@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('css')
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/flat/blue.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/morris/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datepicker/datepicker3.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

  @parent
  <style type="text/css">
      table thead td {
          font-weight: bold;
      }
  </style>
@endsection

@section('content-header')
<h1> Dashboard <small>Control panel</small> </h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Dashboard</li>
</ol>
@endsection

@section('content')

@include('widget')

<!-- Main row -->
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Rekapitulasi Data RKT</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <td>#</td>
              <td class="text-center">Unit Kerja</td>
              <td>Kode</td>
              <td>Kegiatan</td>
              <td class="text-center">Personil</td>
              {{-- <td class="text-center">Intensitas<br/>(Menit)</td> --}}
              <td class="text-center" style="width: 165px;">Beban Kegiatan Per Pegawai (Maks. 100%)</td>
              <td>Anggaran</td>
              <td class="text-center">DatDuk</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($kegiatans as $index => $kegiatan)
<?php
    $unit_kerja = $kegiatan->getUnitKerja();

    $hari_pr   = "341";
    $pegawai   = $unit_kerja->pegawai;
    try {
        $perkiraan = $kegiatan->durasi_sum / $hari_pr / $pegawai;
    } catch (Exception $e) {
        $perkiraan = 0;
    }
?>
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $kegiatan->eselondua }}</td>
                  <td>{{ $kegiatan->code }}</td>
                  <td>{{ $kegiatan->name }}</td>
                  <td class="text-right">{{ $pegawai }}</td>
                  {{-- <td class="text-right">{{ $kegiatan->durasi }}</td> --}}
                  <td class="text-right">{{ round($perkiraan/344*100) }} %</td>
                  <td class="text-right">{{ $kegiatan->pagu }}</td>
<?php
if ($kegiatan->total_sk > 0) {
    $perc = sizeof($kegiatan->datduks) / $kegiatan->total_sk * 100;
} else {
    $perc = 0;
}

switch (true) {
    case $perc > 90:
        $bg = 'bg-green';
        break;
    case $perc > 60:
        $bg = 'bg-yellow';
        break;
    default:
        $bg = 'bg-red';
        break;
}
?>
                  <td class="text-center"><span class="badge {{ $bg }}">
                    {{ sizeof($kegiatan->datduks->groupBy('parent')) }}/{{ $kegiatan->total_sk }}
                  </span></td>
                </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-center"><strong>Total</strong></td>
              <td class="text-right text-bold"><strong>{{ 
                number_format($kegiatans->sum(function ($kegiatan) {
                  return str_replace('.', '', $kegiatan['pagu']);
                }), "0", ",", ".") }}</strong>
              </td>
            </tr>
          </tfoot>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>
@endsection

@section('javascript')

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('adminlte/plugins/morris/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('adminlte/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('adminlte/plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>
@endsection