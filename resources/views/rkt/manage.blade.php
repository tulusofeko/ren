@extends('layouts.adminlte')

@section('title', 'Kelola Data Usulan RKT')

@section('css')
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/all.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- JEasyUI -->
  <link rel="stylesheet" type="text/css" href="{{ asset('easyui/themes/metro-gray/easyui.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('easyui/themes/icon.css') }}">
  
  @parent
  <style type="text/css">
      .datagrid .panel-body {
          border-radius : 0;
          padding       : 0;
      }

      .datagrid .datagrid-cell,
      .jqx-cell {
          padding : 8px;
      }

      .jqx-grid-column-header span {
          padding-left: 4px;
      }

      .jqx-grid, .panel.datagrid {
          border-radius : 0;
      }

      .datagrid-cell {
          white-space: normal !important;
      }
      
      #kegiatan-selector, .select2-container {
          width: 100% !important;
      }
  </style>
@endsection

@section('content-header')
  <h1> Usulan Rencana Kerja Tahunan <small>dashboard</small> </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">RKT</a></li>
    <li class="active">Manage</li>
  </ol>
@endsection 

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Usulan RKT</h3>
          <div class="pull-right box-tools  no-print" id="box-action">
              <!-- Header Button -->
              <button class="btn btn-success btn-social" title="Tambah Output" style="display: none;" 
                data-toggle="modal" data-target="#outputmodal" aria-hidden="true" data-method='POST'>
                <i class="fa fa-plus"> </i> Rekam Output 
              </button>
              <button class="btn btn-success btn-social" title="Tambah SubOutput" style="display: none;" 
                data-toggle="modal" data-target="#suboutputmodal" aria-hidden="true" data-method='POST'>
                <i class="fa fa-plus"> </i> Rekam SubOutput 
              </button>
              <button class="btn btn-success btn-social" title="Tambah Komponen" style="display: none;" 
                data-toggle="modal" data-target="#komponenmodal" aria-hidden="true" data-method='POST'>
                <i class="fa fa-plus"> </i> Rekam Komponen 
              </button>
              <button class="btn btn-primary btn-social" title="Edit Output" style="display: none;" 
                data-toggle="modal" data-target="#outputmodal" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit Output 
              </button>
              <button class="btn btn-primary btn-social" title="Edit SubOutput" style="display: none;" 
                data-toggle="modal" data-target="#suboutputmodal" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit SubOutput 
              </button>
              <button class="btn btn-primary btn-social" title="Edit Komponen" style="display: none;" 
                data-toggle="modal" data-target="#komponenmodal" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit Komponen 
              </button>
              <button class="btn btn-danger btn-social" title="Hapus" style="display: none;" 
                data-toggle="modal" data-target="#hapusmodal" aria-hidden="true">
                <i class="fa fa-trash"> </i> Hapus 
              </button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="flash-message" style="display: none">
            <div class="alert">
              <button type="button" class="close" aria-hidden="true">×</button>
              <p class="alert-messages"></p>
            </div>
          </div>
          <table id="tree" class="table table-bordered table-hover table-striped" 
            data-url="{{ route('rkt.getdata') }}"
          >
            <thead>
              <tr>
                <th>Kode</th>
                <th>Uraian Suboutput/Komponen/Subkomponen/Akun/Detil</th>
                <th>Jumlah Pelaksana</th>
                <th>Durasi Pelaksanaan</th>
                <th>Anggaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody> </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  @include('includes.parsley')
  <!-- iCheck 1.0.1 -->
  <script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/select2.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <!-- EasyUI -->
  <script src="{{ asset('easyui/jquery.easyui.min.js') }}"></script>
  
  <!-- Form validation -->
  <script>
  $('#kegiatan-selector').select2();

  $(document).ready(function() {
      $('.modal form').parsley({
          errorsWrapper : '<ul class="parsley-errors-list list-unstyled"></ul>',
          errorTemplate : '<li class="small text-danger"></li>',
          errorClass    : 'has-error',
          classHandler: function (ParsleyField) {
              return ParsleyField.$element.parents('.form-group');
          },
          errorsContainer: function (ParsleyField) {
              return ParsleyField.$element.parents('.form-group');
          },
      });
  });

  $(function(){
      $("#flash-message .close").on("click", function(){
          $("#flash-message").hide();
      });
  });
  </script>

  <!-- Flash messages -->
  <script>
  var flashMessage = function (data, error = false) {
      if (error === true) {
          $('#flash-message .alert').addClass('alert-danger');
          $('#flash-message .alert .alert-messages').html(data.message);
      } else {

          $('#flash-message .alert').addClass('alert-success');
          $('#flash-message .alert .alert-messages').html(data.message);
      }

      $('.modal').modal('hide');

      $('#flash-message').slideDown(function() {
          setTimeout(function() {
              $('#flash-message').slideUp("slow", function() {
                  $('#flash-message .alert').removeClass('alert-success');
                  $('#flash-message .alert').removeClass('alert-danger');
                  $('#flash-message .alert .alert-messages').html('');
              });
          }, 4000);
      }); 
  }
  </script>

  <!-- TreeGrid -->
  <script>
  var nexttoload = new Array;

  $('#tree').treegrid({
      url       : "{{ route('rkt.getdata') }}",
      idField   : 'mak',
      treeField : 'code',
      method    : 'GET',
      lines     : true,
      columns   :[[
          {
              title : 'Kode',
              field : 'code',
              width : 180,
              align : 'left'
          },
          {
              title : 'Uraian Suboutput/Komponen/Subkomponen/Akun/Detil',
              field : 'name',
              width : 500,
          },
          {
              title : 'Jumlah Pelaksana',
              field : 'pegawai',
              width : 120
          },
          {
              title : 'Durasi Pelaksanaan',
              field : 'waktu',
              width : 120
          }
      ]],
      onSelect: function (row)
      {
          $('#box-action button').hide();

          console.log(row);

          var parent = $(this).treegrid('getParent', row.mak);
          switch(row.level) {
              case 'kegiatan':
                  $('#box-action [data-target="#outputmodal"][data-method="POST"]').data('kegiatan', row);
                  $('#box-action [data-target="#outputmodal"][data-method="POST"]').show();
                  break;
              case 'output':
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').data('kegiatan', parent);
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').data('output', row);
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#suboutputmodal"][data-method="POST"]').data('output', row);
                  $('#box-action [data-target="#suboutputmodal"][data-method="POST"]').show();
                  break;
              case 'suboutput':
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').data('output', parent);
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').data('suboutput', row);
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#komponenmodal"][data-method="POST"]').data('parent', row);
                  $('#box-action [data-target="#komponenmodal"][data-method="POST"]').show();
                  break;
              case 'komponen' :
                  $('#box-action [data-target="#komponenmodal"][data-method="PUT"]').data('parent', parent);
                  $('#box-action [data-target="#komponenmodal"][data-method="PUT"]').data('node', row);
                  $('#box-action [data-target="#komponenmodal"][data-method="PUT"]').show();
                  break;
          }

          if (row.level !== 'program' && row.level !== 'kegiatan') {
              $('#box-action [data-target="#hapusmodal"]').data('row', row);
              $('#box-action [data-target="#hapusmodal"]').show();
          }
      },
      onUnselect: function (row) 
      {
          $('#box-action button').hide();
      },
      onBeforeLoad: function (row, param) {
          if (typeof param.next !== 'undefined') {
              var step = param.next.split(".");
              var next = '';
              
              for (var i = 0; i < step.length; i++) {
                  if (i == 0) {
                      next += step[i];
                      continue;
                  } 
                      
                  next += "." + step[i];
                  
                  if (i == 1) { continue; }

                  nexttoload.push(next);
              }
          }
      },
      onLoadSuccess: function (row, data) {
          if (nexttoload.length === 0) { return; }

          var toload = nexttoload.shift();
          var node   = $(this).treegrid('find', toload);
          
          if (node !== null) {
              console.log("Loading data from row " + toload);
              
              $(this).treegrid('reload', {id   : toload });
              
              $(this).treegrid('select', toload);
          }
      }
  });

  </script>

  @include('rkt.modals.output')

  @include('rkt.modals.suboutput')

  @include('rkt.modals.komponen')

  @include('rkt.modals.hapus')

@endsection