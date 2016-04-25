@extends('layouts.adminlte')

@section('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
  <h1> @yield('unitkerja')
    <small>dashboard</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Unit Kerja</a></li>
    <li class="active">@yield('unitkerja')</li>
  </ol>
@endsection 

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Daftar Unit Kerja Eselon I</h3>
        <div class="pull-right box-tools  no-print">
            <button class="btn btn-success btn-social" title="Tambah Data Pemerintah Daerah">
              <i class="fa fa-plus"> </i> Tambah Data Eselon I
            </button>
          </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table id="unitkerja" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th style="width: 18px">No.</th>
              <th>Unit Kerja</th>
              <th>Alias</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection