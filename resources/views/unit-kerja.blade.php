@extends('layouts.adminlte')

@section('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
  <h1> @yield('unitkerja') <small>dashboard</small> </h1>
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
          <h3 class="box-title">Daftar Unit @yield('unitkerja')</h3>
          <div class="pull-right box-tools  no-print">
              <button class="btn btn-success btn-social" data-toggle="modal" data-target="#formunitkerja" data-method="post" title="Tambah Data @yield('unitkerja')">
                <i class="fa fa-plus"> </i> Tambah Data @yield('unitkerja')
              </button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="flash-message" style="display: none">
            <div class="alert">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <p class="alert-messages"></p>
              
            </div>
          </div>
          @yield('tabel-unitkerja')
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="formunitkerja">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          @yield('form-unitkerja')

          <div class="overlay" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
        <div class="modal-footer clearfix">
          <button form="create-unitkerja" type="submit" class="btn btn-primary">Simpan</button>
          <button class="btn btn-danger" data-dismiss="modal">Batal</button>
          <!-- Modal footer -->
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>
  <div class="modal fade" id="hapusunitkerja">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="ion-android-delete"></i> Hapus Data </h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          <form id="hapus-eselon-satu" action="{{ route('view.eselon_satu') }}/hapus" method="post">
            <p>Data yang dihapus tidak dapat dikembalikan lagi.</p>
            <div class="form-group">
              <input type="hidden" name="id">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token"  value="{{ csrf_token() }}">
            </div>
          </form>
          <div class="overlay" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
        <div class="modal-footer clearfix">
          <button form="hapus-eselon-satu" type="submit" class="btn btn-danger">Hapus</button>
          <button class="btn btn-primary" data-dismiss="modal">Batal</button>
          <!-- Modal footer -->
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>
@endsection


@section('custom-js')
  @include('includes.parsley')
  <!-- DataTables -->
  <script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
@endsection