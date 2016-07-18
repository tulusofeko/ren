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
              <td>Eselon I</td>
              <td>Kode</td>
              <td class="text-center">Unit Kerja</td>
              <td class="text-center">Personil</td>
              {{-- <td class="text-center">Intensitas<br/>(Menit)</td> --}}
              <td class="text-center" style="width: 165px;">Beban Kegiatan Per Pegawai (Maks. 100%)</td>
              <td>Anggaran</td>
              <td class="text-center">DatDuk</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($eselon_dua as $index => $unit_kerja)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td class="text-center">{{ $unit_kerja->parent }}</td>
                  <td class="text-right" >{{ $unit_kerja->codename }}</td>
                  <td class="text-left"  >{{ $unit_kerja->name }}</td>
                  <td class="text-right" >{{ $unit_kerja->pegawai }}</td>
                  <td class="text-right" >{{ $unit_kerja->perkiraan }} %</td>
                  <td class="text-right" >{{ $unit_kerja->pagu }}</td>
<?php
if (sizeof($unit_kerja->sub_komponens) > 0) {
    $perc = sizeof($unit_kerja->datduks) / sizeof($unit_kerja->sub_komponens) * 100;
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
                    {{ sizeof($unit_kerja->datduks->groupBy('parent')) }}/
                    {{ sizeof($unit_kerja->sub_komponens) }}
                  </span></td>
                </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-center"><strong>Total</strong></td>
              <td class="text-right text-bold"><strong>{{ 
                number_format($eselon_dua->sum(function ($unit) {
                  return str_replace('.', '', $unit['pagu']);
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

@endsection