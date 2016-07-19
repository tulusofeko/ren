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

  <!-- Context Menu -->
  <link rel="stylesheet" href="{{ asset('plugins/contextMenu/dist/jquery.contextMenu.min.css') }}">
  <!-- File selector -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
  
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

      #datduks {
          margin-bottom: 10px;
      }
      #datduks .btn-group {
          margin-right: 5px;
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
              <button class="btn btn-success btn-social" title="Tambah SubKomponen" style="display: none;" 
                data-toggle="modal" data-target="#subkomponenmodal" aria-hidden="true" data-method='POST'>
                <i class="fa fa-plus"> </i> Rekam SubKomponen 
              </button>
              <button class="btn btn-success btn-social" title="Tambah Aktivitas" style="display: none;" 
                data-toggle="modal" data-target="#aktivitasmodal" aria-hidden="true" data-method='POST'>
                <i class="fa fa-plus"> </i> Rekam Aktivitas 
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
              <button class="btn btn-primary btn-social" title="Edit Sub Komponen" style="display: none;" 
                data-toggle="modal" data-target="#subkomponenmodal" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit SubKomponen 
              </button>
              <button class="btn btn-primary btn-social" title="Edit Aktivitas" style="display: none;" 
                data-toggle="modal" data-target="#aktivitasmodal" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit Aktivitas 
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
            data-url="{{ route('rkt.getdata') }}" style="min-height: 300px;" 
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
  @include('rkt.context-menu')
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
  <!-- Input Mask -->
  <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
  <!-- EasyUI -->
  <script src="{{ asset('easyui/jquery.easyui.min.js') }}"></script>
  <!-- Context Menu -->
  <script src="{{ asset('plugins/contextMenu/dist/jquery.contextMenu.min.js') }}"></script>
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

  $.contextMenu({
      selector : '.datagrid-cell',
      callback: function(key, opt) {
          var datacet = {
              kegiatan : {
                  child  : 'output',
              },
              output   : {
                  child  : 'suboutput',
                  target : '#outputmodal'
              },
              suboutput   : {
                  child  : 'komponen',
                  target : '#suboutputmodal'
              },
              komponen : {
                  child  : 'subkomponen',
                  target : '#komponenmodal'
              },
              subkomponen : {
                  child  : 'aktivitas',
                  target : '#subkomponenmodal'
              },
              aktivitas : {
                  child  : '#',
                  target : '#aktivitasmodal'
              }
          }

          var level  = opt.$trigger.data('level');
          var child  = datacet[level].child;
          var target = "";

          switch(key) {
              case "add":
                  target = datacet[child].target;
                  break;
              case "add-sibling":
                  target = $(datacet[level].target).data('method', 'POST');
                  target = datacet[level].target;
                  break;
              case "edit":
                  target = datacet[level].target;
                  break;
              case "delete":
                  target = '#hapusmodal';
                  break;
          }

          $(target).modal('show');
      },
      build: function($trigger, e) {
          e.preventDefault();

          return $trigger.data('menu-items');
      }
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
              width : 470,
          },
          {
              title : 'Jumlah Personil',
              field : 'personil',
              align : 'right',
              width : 100
          },
          {
              title : 'Durasi (Hari)',
              field : 'durasi',
              align : 'right',
              width : 100
          },
          {
              title : 'Waktu (Menit)',
              field : 'durasi_sum',
              align : 'right',
              width : 100
          },
          {
              title : 'Anggaran',
              field : 'pagu',
              width : 100,
              align : 'right',
              formatter: function(value,row,index) {
                  return value;
              }
          }
      ]],
      onContextMenu: function (e,row){
          if (row.level == 'program') {
              $(".datagrid-cell").contextMenu(false);
          } else {
              $(".datagrid-cell").contextMenu(true);
          }

          var parent = $(this).treegrid('getParent', row.mak), child;
          
          switch(row.level) {
              case 'kegiatan':
                  $('#outputmodal').data('kegiatan', row);
                  $('#outputmodal').data('method', 'POST');
                  $('#box-action [data-target="#outputmodal"][data-method="POST"]').show();
                  child = 'output';
                  break;
              case 'output':
                  $('#outputmodal').data('kegiatan', parent);
                  $('#outputmodal').data('output', row);
                  $('#outputmodal').data('method', 'PUT');
                  $('#suboutputmodal').data('output', row);
                  $('#suboutputmodal').data('method', 'POST');
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#suboutputmodal"][data-method="POST"]').show();
                  child = 'suboutput';
                  break;
              case 'suboutput':
                  $('#suboutputmodal').data('output', parent);
                  $('#suboutputmodal').data('suboutput', row);
                  $('#suboutputmodal').data('method', 'PUT');
                  $('#komponenmodal').data('parent', row);
                  $('#komponenmodal').data('method', 'POST');
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#komponenmodal"][data-method="POST"]').show();
                  child = 'komponen';
                  break;
              case 'komponen' :
                  $('#komponenmodal').data('parent', parent);
                  $('#komponenmodal').data('node', row);
                  $('#komponenmodal').data('method', 'PUT');
                  $('#subkomponenmodal').data('parent', row);
                  $('#subkomponenmodal').data('method', 'POST');
                  $('#box-action [data-target="#komponenmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#subkomponenmodal"][data-method="POST"]').show();
                  child = 'subkomponen';
                  break;
              case 'subkomponen' :
                  $('#subkomponenmodal').data('parent', parent);
                  $('#subkomponenmodal').data('node', row);
                  $('#subkomponenmodal').data('method', 'PUT');
                  $('#aktivitasmodal').data('parent', row);
                  $('#aktivitasmodal').data('method', 'POST');
                  $('#box-action [data-target="#subkomponenmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#aktivitasmodal"][data-method="POST"]').show();
                  child = 'aktivitas';
                  break;
              case 'aktivitas' :
                  $('#aktivitasmodal').data('parent', parent);
                  $('#aktivitasmodal').data('method', 'PUT');
                  $('#aktivitasmodal').data('node', row);
                  $('#box-action [data-target="#aktivitasmodal"][data-method="PUT"]').show();
                  child = false;
                  break;
          }

          if (row.level !== 'program' && row.level !== 'kegiatan') {
              $('#hapusmodal').data('row', row);
              $('#box-action [data-target="#hapusmodal"]').show();
          }
          
          var data = { items: {
                  "add": {
                      name    : "Add " + child, 
                      icon    : "add",
                      visible : child ? true : false
                  },
                  separator2: { "type": "cm_separator" },
                  "add-sibling": {
                      name    : "Add " + row.level, 
                      icon    : "add",
                      visible : true
                  },
                  "edit": {
                      name    : "Edit " + row.level, 
                      icon    : "edit",
                      visible : true
                  },
                  "delete": {
                      name    : "Hapus " + row.level, 
                      icon    : "delete",
                      visible : true
                  }
              }
          };

          if (row.level == 'kegiatan') { 
              data.items.edit.visible   = false;
              data.items.delete.visible = false;
          }

          $(e.target).data('level', row.level);
          $(e.target).data('menu-items', data);
      },
      onSelect: function (row)
      {
          $('#box-action button').hide();

          var parent = $(this).treegrid('getParent', row.mak);

          switch(row.level) {
              case 'kegiatan':
                  $('#outputmodal').data('kegiatan', row);
                  $('#outputmodal').data('method', 'POST');
                  $('#box-action [data-target="#outputmodal"][data-method="POST"]').show();
                  break;
              case 'output':
                  $('#outputmodal').data('kegiatan', parent);
                  $('#outputmodal').data('output', row);
                  $('#outputmodal').data('method', 'PUT');
                  $('#suboutputmodal').data('output', row);
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#suboutputmodal"][data-method="POST"]').show();
                  break;
              case 'suboutput':
                  $('#suboutputmodal').data('output', parent);
                  $('#suboutputmodal').data('suboutput', row);
                  $('#suboutputmodal').data('method', 'PUT');
                  $('#komponenmodal').data('parent', row);
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#komponenmodal"][data-method="POST"]').show();
                  break;
              case 'komponen' :
                  $('#box-action [data-target="#komponenmodal"][data-method="PUT"]').data('parent', parent);
                  $('#box-action [data-target="#komponenmodal"][data-method="PUT"]').data('node', row);
                  $('#box-action [data-target="#komponenmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#subkomponenmodal"][data-method="POST"]').data('parent', row);
                  $('#box-action [data-target="#subkomponenmodal"][data-method="POST"]').show();
                  break;
              case 'subkomponen' :
                  $('#box-action [data-target="#subkomponenmodal"][data-method="PUT"]').data('parent', parent);
                  $('#box-action [data-target="#subkomponenmodal"][data-method="PUT"]').data('node', row);
                  $('#box-action [data-target="#subkomponenmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#aktivitasmodal"][data-method="POST"]').data('parent', row);
                  $('#box-action [data-target="#aktivitasmodal"][data-method="POST"]').show();
                  break;
              case 'aktivitas' :
                  $('#box-action [data-target="#aktivitasmodal"][data-method="PUT"]').data('parent', parent);
                  $('#box-action [data-target="#aktivitasmodal"][data-method="PUT"]').data('node', row);
                  $('#box-action [data-target="#aktivitasmodal"][data-method="PUT"]').show();
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
          if (nexttoload.length === 0) { 
              $(this).treegrid('expand', '051.01.01');
              $(this).treegrid('expand', '051.01.06');
          }

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

  @include('rkt.modals.subkomponen')

  @include('rkt.modals.aktivitas')

  @include('rkt.modals.hapusdatduk')
  
  @include('rkt.modals.hapus')

@endsection