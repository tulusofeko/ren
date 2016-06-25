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
              <button class="btn btn-primary btn-social" title="Edit Output" style="display: none;" 
                data-toggle="modal" data-target="#outputmodal" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit Output 
              </button>
              <button class="btn btn-primary btn-social" title="Edit SubOutput" style="display: none;" 
                data-toggle="modal" data-target="#suboutputmodal" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit SubOutput 
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

  <!-- Output Modal -->
  <div class="modal fade" id="outputmodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Tambah Output</h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          <form id="create-output" method="post" action="{{ route('output.create') }}"
            data-edit="{{ route('output.update', "/") }}/"  
          >
            <div class="form-group">
              <label>Kegiatan</label>
              <select id="kegiatan-selector" name="parent">
                @foreach ($kegiatans as $program => $kegiatans)
                    <optgroup label="{{ $program }}">
                      @foreach ($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->code }}" 
                          data-mak="051.01.{{ $kegiatan->parent }}.{{ $kegiatan->code }}"> 
                          {{ $kegiatan->code }} - {{ $kegiatan->name }}
                        </option>
                      @endforeach
                    </optgroup>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Output</label>
              <input class="form-control" name="code" placeholder="Kode Output" data-edit type="text" required maxlength="2">
            </div>
            <div class="form-group">
              <label>Nama Output</label>
              <input class="form-control" name="name" placeholder="Name Output" type="text" required />
            </div>
            <div class="form-group">
              <input type="hidden" name="_method" value="POST">
            </div>
          </form>
          <div class="overlay" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
        <div class="modal-footer clearfix">
          <button form="create-output" type="submit" class="btn btn-primary">Simpan</button>
          <button class="btn btn-danger" data-dismiss="modal">Batal</button>
          <!-- Modal footer -->
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>
  
  <!-- SubOutput Modal -->
  <div class="modal fade" id="suboutputmodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Tambah Output</h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          <form id="create-suboutput" method="post" action="{{ route('suboutput.create') }}"
            data-edit="{{ route('suboutput.update', "/") }}/"  
          >
            <div class="form-group">
              <label>Output</label>
              <input class="form-control" type="text" name="parent-kw" required disabled />
              <input type="hidden" name="parent" >               
            </div>
            <div class="form-group">
              <label>Kode SubOutput</label>
              <input class="form-control" name="code" placeholder="Kode SubOutput" data-edit type="text" required maxlength="2">
            </div>
            <div class="form-group">
              <label>Nama SubOutput</label>
              <input class="form-control" name="name" placeholder="Name SubOutput" type="text" required />
            </div>
            <div class="form-group">
              <input type="hidden" name="_method" value="POST">
            </div>
          </form>

          <div class="overlay" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
        <div class="modal-footer clearfix">
          <button form="create-suboutput" type="submit" class="btn btn-primary">Simpan</button>
          <button class="btn btn-danger" data-dismiss="modal">Batal</button>
          <!-- Modal footer -->
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

  <!-- Hapus Modal -->
  <div class="modal fade" id="hapusmodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="ion-android-delete"></i> Hapus Data </h4>
        </div>
        <form method="post">
          <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
            <p>Data yang dihapus tidak dapat dikembalikan lagi.</p>
            <div class="form-group">
              <input type="hidden" name="id">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token"  value="{{ csrf_token() }}">
            </div>
            <div class="overlay" style="display: none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          <div class="modal-footer clearfix">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <button class="btn btn-primary" data-dismiss="modal">Batal</button>
            <!-- Modal footer -->
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div>
  </div>
@endsection


@section('javascript')
  @parent
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
              width : 120,
              align : 'left'
          },
          {
              title : 'Uraian Suboutput/Komponen/Subkomponen/Akun/Detil',
              field : 'name',
              width : 580,
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

          switch(row.level) {
              case 'kegiatan':
                  $('#box-action [data-target="#outputmodal"][data-method="POST"]').data('kegiatan', row);
                  $('#box-action [data-target="#outputmodal"][data-method="POST"]').show();
                  break;
              case 'output':
                  var parent = $(this).treegrid('getParent', row.mak);
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').data('kegiatan', parent);
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').data('output', row);
                  $('#box-action [data-target="#outputmodal"][data-method="PUT"]').show();
                  $('#box-action [data-target="#suboutputmodal"][data-method="POST"]').data('output', row);
                  $('#box-action [data-target="#suboutputmodal"][data-method="POST"]').show();
                  break
              case 'suboutput':
                  var parent = $(this).treegrid('getParent', row.mak);
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').data('output', parent);
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').data('suboutput', row);
                  $('#box-action [data-target="#suboutputmodal"][data-method="PUT"]').show();
                  break
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

  <!-- Output related -->
  <script>
  $('#outputmodal').on('show.bs.modal', function (e) {
      // reset
      $('#outputmodal form')[0].reset();
      $('#outputmodal form').parsley().reset();

      var data     = $(e.relatedTarget).data(), d = new Date;
      var action   = $('#outputmodal form').attr('action');
      var kegiatan = data.kegiatan;
      var editee;

      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote', 
          $('#tree').data('url') + "?id=" + kegiatan.mak + ".{value}&_t=" +d.getTime()
      );

      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-validator', 'reverse'); 
      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-message', 'Kode sudah ada'); 

      $('#kegiatan-selector').val(kegiatan.code).trigger('change');

      if (data.method == "PUT" ) {
          $(this).find('.modal-body .modal-title').val("Edit Data"); 
          $(this).find('.modal-body input[name="code"]').data('edit', data.output.code); 
          $(this).find('.modal-body input[name="code"]').val(data.output.code); 
          $(this).find('.modal-body input[name="name"]').val(data.output.name); 
          $(this).find('.modal-body input[name="_method"]').val("PUT"); 

          action =  $('#create-output').data('edit') + data.output.id;
          editee = data.output;
      } else {
          $(this).find('.modal-body .modal-title').val("Tambah Data"); 
          $(this).find('.modal-body input[name="_method"]').val("POST"); 
          editee = data.kegiatan;
      }

      $('#tree').treegrid('beginEdit', editee.mak);

      $('#outputmodal [name="code"]').parsley()
          .on('field:validate', function(field) {
              var lmn  = this.$element;
              var pre  = this.$element.data('edit');
              var sel  = $('#kegiatan-selector');
              var mak  = sel.find('[value="'+ sel.val() +'"]').data('mak');
              
              if (pre == this.value && sel.val() == kegiatan.code) {
                  this.removeConstraint('remote');
              } else {
                  this.addConstraint({
                      'remote' : $('#tree').data('url') + "?id=" + mak + ".{value}&_t=" +d.getTime() 
                  });
              }
          });

      $('#outputmodal form').parsley().on('form:submit', function() {
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              data        : $('#outputmodal form').serialize(), // our data object
              url         : action, // the url where we want to POST
              encode      : true,
              beforeSend  : function () {
                  $('#outputmodal').find('.overlay').show();
              }
          }).done(function (result) {
              
              flashMessage(result);

              $('#tree').treegrid('endEdit', editee.mak);
              $('#tree').treegrid('reload', { next: kegiatan.mak });

          }).fail(function(result) {
              
              flashMessage({ 
                  message : "Internal server error. See develpoer tools for error detail",
                  data    : result
              }, true);
          });

          return false;
      });
  });
  </script>

  <!-- SubOutput related -->
  <script>
  $('#suboutputmodal').on('show.bs.modal', function (e) {
      // reset
      $('#suboutputmodal form')[0].reset();
      $('#suboutputmodal form').parsley().reset();

      var data   = $(e.relatedTarget).data(), d = new Date;
      var action = $('#suboutputmodal form').attr('action');
      var output = data.output;
      var editee;

      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote', 
          $('#tree').data('url') + "?id=" + output.mak + ".{value}&_t=" +d.getTime()
      );
      $(this).find('.modal-body input[name="parent-kw"]').val(output.code + " - " + output.name); 
      $(this).find('.modal-body input[name="parent"]').val(output.id); 

      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-validator', 'reverse'); 
      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-message', 'Kode sudah ada'); 

      if (data.method == "PUT" ) {
          $(this).find('.modal-body .modal-title').val("Edit Data"); 
          $(this).find('.modal-body input[name="code"]').data('edit', data.suboutput.code); 
          $(this).find('.modal-body input[name="code"]').val(data.suboutput.code); 
          $(this).find('.modal-body input[name="name"]').val(data.suboutput.name); 
          $(this).find('.modal-body input[name="_method"]').val("PUT"); 

          action =  $('#create-suboutput').data('edit') + data.suboutput.id;
          editee = data.suboutput;
      } else {
          $(this).find('.modal-body .modal-title').val("Tambah Data");
          $(this).find('.modal-body input[name="_method"]').val("POST"); 
          editee = data.output;
      }
      $('#tree').treegrid('beginEdit', editee.mak);

      $('#suboutputmodal [name="code"]').parsley()
          .on('field:validate', function(field) {
              var lmn  = this.$element;
              var pre  = this.$element.data('edit');
              var sel  = $('#create-suboutput [name="parent"]');
              
              if (pre == this.value) {
                  this.removeConstraint('remote');
              } else {
                  this.addConstraint({
                      'remote' : $('#tree').data('url') + "?id=" + output.mak + ".{value}&_t=" +d.getTime() 
                  });
              }
          });

      $('#suboutputmodal form').parsley().on('form:submit', function() {
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              data        : $('#suboutputmodal form').serialize(), // our data object
              url         : action, // the url where we want to POST
              encode      : true,
              beforeSend  : function () {
                  $('#suboutputmodal').find('.overlay').show();
              }
          }).done(function (result) {
              
              flashMessage(result);

              $('#tree').treegrid('endEdit', editee.mak);
              $('#tree').treegrid('reload', { next: output.mak });

          }).fail(function(result) {
              
              flashMessage({ 
                  message : "Internal server error. See develpoer tools for error detail",
                  data    : result
              }, true);
          });
          return false;
      });
  });

  </script>

  <!-- Hapus node -->
  <script>
  $('#hapusmodal').on('show.bs.modal', function (e) {
      // reset
      $('#hapusmodal form')[0].reset();
      $('#hapusmodal form').parsley().reset(); 

      var modal  = $(this);
      var row    = $(e.relatedTarget).data('row');
      var base   = $('base').attr('href');
      var action = base + "/" + row.level + "/hapus/";

      modal.find('.modal-body input[name="id"]').val(row.id);  

      $('#hapusmodal form').parsley().on('form:submit', function() {
          var formData = {
              '_method'  : 'DELETE'
          },  id = row.id;

          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              url         : action + id, // the url where we want to POST
              data        : formData, // our data object
              encode      : true,
              beforeSend  : function () {
                  $('#hapusmodal').find('.overlay').show();
              }
          }).done(function (result) {
              
              flashMessage(result);    
              
              $('#tree').treegrid('reload', { next: row.mak });
                           
          }).fail(function(result) {
              
              var errormessages = null;
              
              if (result.status == 422) {
                  var errormessages = result.responseJSON;
              }
              
              flashMessage({ 
                message : "Internal server error. See develpoer tools for error detail",
                data    : errormessages
              }, true);
          });

          return false;
      });  
  });

  // Reset everything on hide
  $('.modal').on('hide.bs.modal', function (e) {
      $('#box-action button').hide();
      $('#tree').treegrid('unselectAll');
      $(this).find('.overlay').hide();
  });
  </script>
@endsection