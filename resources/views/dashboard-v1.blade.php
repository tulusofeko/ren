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
        <h3 class="box-title">Rekapitulasi Data RKT
          @if (isset($selected))
            <small>{{ $selected->name or '' }}</small>
          @endif
        </h3>
        <div class="pull-right box-tools  no-print">
          <button class="btn btn-success btn-social" title="Cetak Tabel" onclick="window.print()">
            <i class="fa fa-print"> </i> Cetak Data
          </button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <td>#</td>
              <td style="width: 70px;" class="text-center">{{ $parent }}</td>
              <td style="width: 50px;">Kode</td>
              <td class="text-center">Unit Kerja</td>
              <td class="text-center">Personil</td>
              {{-- <td class="text-center">Intensitas<br/>(Menit)</td> --}}
              <td class="text-center" style="width: 145px;">Beban Per Pegawai (Maks. 100%)</td>
              <td>Anggaran</td>
              <td class="text-center">DatDuk</td>
            </tr>
          </thead>
          <tbody>
            @forelse ($units as $index => $unit)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td class="text-center">{{ $unit->parent }}</td>
                  <td class="text-right" >{{ $unit->codename }}</td>
                  <td class="text-left"  >
                    @if (!isset($selected))
                      <a href="{{ url()->current() }}/{{$unit->codename }}">
                        {{ $unit->name }}
                      </a>
                    @else 
                        {{ $unit->name }}
                    @endif
                  </td>
                  <td class="text-right" >{{ $unit->pegawai }}</td>
                  <td class="text-right" >
                  @if ($unit->perkiraan > 98)
                    <i class="fa fa-warning text-danger pull-left" style="padding-top: 4px;"></i>
                  @endif
                  {{ $unit->perkiraan }} %
                  </td>
                  <td class="text-right" >{{ $unit->pagu }}</td>
<?php
if (sizeof($unit->sub_komponens) > 0) {
    $perc = sizeof($unit->datduks) / sizeof($unit->sub_komponens) * 100;
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
                  {{ sizeof($unit->datduks->groupBy('parent')) }}/
                  {{ sizeof($unit->sub_komponens) }}
                </span></td>
              </tr>
            @empty
              <tr>
                <td> # </td>
                <td colspan="7"> No Data </td>
              </tr>
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-center"><strong>Total</strong></td>
              <td colspan="3" class="text-right text-bold"><strong>{{ 
                number_format($units->sum(function ($unit) {
                  return str_replace('.', '', $unit['pagu']);
                }), "0", ",", ".") }}</strong>
              </td>
              <td></td>
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