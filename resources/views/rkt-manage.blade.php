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
  <link rel="stylesheet" type="text/css" href="{{ asset('easyui/themes/default/easyui.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('easyui/themes/icon.css') }}">
  <!-- dxhtml -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dhtmlxSuite/codebase/fonts/font_roboto/roboto.css')}}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('dhtmlxSuite/codebase/dhtmlx.css') }}"/>

  <!-- Jqwidgets -->
  <link rel="stylesheet" href="{{ asset('jqwidgets/styles/jqx.base.css') }}" type="text/css" />
  
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

      .jqx-grid { 
          border-radius : 0;
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
                data-toggle="modal" data-target="#formoutput" aria-hidden="true" data-method='POST'>
                <i class="fa fa-plus"> </i> Rekam Output 
              </button>
              <button class="btn btn-primary btn-social" title="Edit Output" style="display: none;" 
                data-toggle="modal" data-target="#formoutput" aria-hidden="true" data-method='PUT'>
                <i class="fa fa-edit"> </i> Edit Output 
              </button>
              <button class="btn btn-danger btn-social" title="Hapus" style="display: none;" 
                data-toggle="modal" data-target="#hapus" aria-hidden="true">
                <i class="fa fa-trash"> </i> Hapus 
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
          <div id="dtbl" style="height: 300px;"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="formoutput">
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
              <input class="form-control" name="kegiatan-kw" type="text" disabled>
              <input class="form-control" name="kegiatan" type="hidden">
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
  <div class="modal fade" id="hapus">
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
  <script src="{{ asset('dhtmlxSuite/codebase/dhtmlx.js') }}"></script>

  <!-- Jqwidgets -->
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxdata.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxlistbox.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxdropdownlist.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxdatatable.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets/jqxtreegrid.js') }}"></script>
  
  <!-- Form validation -->
  <script>
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

      var source = {
          datatype: "json",
          datafields: [
              { name: 'code', type: "string" },
              { name: 'name' }
          ],
          url: "{{ route('rkt.dx') }}"
      };

      var dataAdapter = new $.jqx.dataAdapter(source);
      
      $('#dtbl').jqxTreeGrid(
      {
          source: dataAdapter,
          columns: [
              { text: 'Kode', dataField: 'code', width: 100 },
              { text: 'Uraian', dataField: 'name', width: 500 },
              { text: 'Product', dataField: 'Product', width: 180 },
              { text: 'Unit Price', dataField: 'Price', width: 90, align: 'right', cellsAlign: 'right', cellsFormat: 'c2' },
              { text: 'Quantity', dataField: 'Quantity', width: 80, align: 'right', cellsAlign: 'right' }
          ]
      });
      
      $("#dtbl").on('rowSelect', function (event) {
          // event arguments
          var args = event.args;
          // row data
          var rowData = args.row;
          // row key
          var rowKey = args.key;
          
          // dataAdapter.dataBind();   
      });



  });

 
  </script>

  <!-- Flash messages -->
  <script>
  function flashMessage(data, error = false) {
      var error, message;

      if (typeof data.raw != "undefined" ) { console.log(data.raw); }

      if (error) {
          $('#flash-message .alert').addClass('alert-danger');
          $('#flash-message .alert .alert-messages').html(
              "Error " + data.error + ": " + data.message
          );
      } else {
          $('#flash-message .alert').addClass('alert-success');
          $('#flash-message .alert .alert-messages').html(data.message);
      }

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

  $('#tree').treegrid({
      url       : "{{ route('rkt.getdata') }}",
      idField   : 'mak',
      treeField : 'name',
      method    : 'GET',
      lines     : true,
      columns   :[[
          {
              title : 'Kode',
              field : 'code',
              width : 60,
              align : 'center'
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
      onClickRow: function (row)
      {
          $('#box-action button').hide();

          switch(row.level) {
              case 'kegiatan':
                  $('#box-action [data-target="#formoutput"][data-method="POST"]').data('kegiatan', row);
                  $('#box-action [data-target="#formoutput"][data-method="POST"]').show();
                  break;
              case 'output':
                  var parent = $(this).treegrid('getParent', row.mak);
                  $('#box-action [data-target="#formoutput"][data-method="PUT"]').data('kegiatan', parent);
                  $('#box-action [data-target="#formoutput"][data-method="PUT"]').data('output', row);
                  $('#box-action [data-target="#formoutput"][data-method="PUT"]').show();
                  break
          }

          if (row.level !== 'program' && row.level !== 'kegiatan') {
              $('#box-action [data-target="#hapus"]').data('row', row);
              $('#box-action [data-target="#hapus"]').show();
          }

          console.log(row);

      },
      onUnselect: function (row) 
      {
          $('#box-action button').hide();
      },
      onBeforeLoad: function (row, param) {
          
      },
      onLoadSuccess: function (row, data) {
          for (var i = 0; i < data.length; i++) {
              if (data[i].continue) {
                  $(this).treegrid('reload', {
                      id   : data[i].mak,
                      next : data[i].next
                  });
              }
          }
      }
  });

  </script>

  <script>
    $('[name=eselondua]').select2({ placeholder: "Pilih Unit Eselon Dua", });

  </script>

  <!-- Modal related -->
  <script>
  $('#formoutput').on('show.bs.modal', function (e) {
      // reset
      $('#formoutput form')[0].reset();
      $('#formoutput form').parsley().reset();

      var data     = $(e.relatedTarget).data();
      var action   = $('#formoutput form').attr('action');
      var kegiatan = data.kegiatan;

      $(this).find('.modal-body input[name="kegiatan"]').val(kegiatan.code);
      $(this).find('.modal-body input[name="kegiatan-kw"]').val(kegiatan.code + " - " + kegiatan.name);
      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote', 
          $('#tree').data('url') + "?id=" + kegiatan.mak + ".{value}"
      );
      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-validator', 'reverse'); 
      $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-message', 'Kode sudah ada'); 

      if (data.method == "PUT" ) {
          $(this).find('.modal-body .modal-title').val("Edit Data"); 
          $(this).find('.modal-body input[name="code"]').data('edit', data.output.code); 
          $(this).find('.modal-body input[name="code"]').val(data.output.code); 
          $(this).find('.modal-body input[name="name"]').val(data.output.name); 
          $(this).find('.modal-body input[name="_method"]').val("PUT"); 

          action =  $('#create-output').data('edit') + data.output.id;
      } else {
          $(this).find('.modal-body .modal-title').val("Tambah Data"); 
          $(this).find('.modal-body input[name="_method"]').val("POST"); 

      }

      $('#formoutput [name="code"]').parsley()
          .on('field:validate', function(field) {
              var lmn = this.$element;
              var pre = this.$element.data('edit');
              
              if (pre == this.value) {
                  this.removeConstraint('remote');
              } else {
                  this.addConstraint({
                      'remote' : lmn.data('parsleyRemote') 
                  });
              }
          });

      $('#formoutput form').parsley().on('form:submit', function() {
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              data        : $('#formoutput form').serialize(), // our data object
              url         : action, // the url where we want to POST
              encode      : true,
              beforeSend  : function () {
                  $('#formoutput').find('.overlay').show();
              }
          }).done(function (result) {
              $('#formoutput').modal('hide');
              
              flashMessage(result);

              var root = $('#tree').treegrid('getRoot', kegiatan.mak);
              var next = kegiatan.mak.replace(root.mak, '');
             
              $('#tree').treegrid('reload', {id: root.mak, next: next});

          }).fail(function(result) {
              $('#formoutput').modal('hide');
              
              var data = {};
              
              if (typeof result.responseJSON != "undefined" ) {
                  data = result.responseJSON;
              } else {
                  data.error   = result.status;
                  data.message = result.statusText;
              }
              
              flashMessage(data, true);
          });

          return false;
      });

  });

  $('#hapus').on('show.bs.modal', function (e) {
      // reset
      $('#hapus form')[0].reset();
      $('#hapus form').parsley().reset(); 

      var modal = $(this), action;
      var row   = $(e.relatedTarget).data('row');

      switch(row.level) {
          case 'output':
              action = "{{ route('output.delete', '') }}";
              break;

      }

      modal.find('.modal-body input[name="id"]').val(row.id);  

      $('#hapus form').parsley().on('form:submit', function() {
          var formData = {
              '_method'  : 'DELETE'
          },  id = row.id;

          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              url         : action + "/" + id, // the url where we want to POST
              data        : formData, // our data object
              encode      : true,
              beforeSend  : function () {
                  $('#hapus').find('.overlay').show();
              }
          }).done(function (result) {
              $('#hapus').modal('hide');
              
              flashMessage(result);    

              var root = $('#tree').treegrid('getRoot', row.mak);
              var next = row.mak.replace(root.mak, '');
              
              $('#tree').treegrid('reload', {id: root.mak, next: next});
                           
          }).fail(function(result) {
              $('#hapus').modal('hide');
              
              var data = {};
              
              if (typeof result.responseJSON != "undefined" ) {
                  data = result.responseJSON;
              } else {
                  data.error   = result.status;
                  data.message = result.statusText;
              }
              
              flashMessage(data, true);
          });

          return false;
      });  
  });

  // Reset everything on hide
  $('#formoutput').on('hide.bs.modal', function (e) {
      $('#box-action button').hide();
      $('#tree').treegrid('unselectAll');
      $(this).find('.overlay').hide();
  });

  // Reset everything on hide
  $('#hapus').on('hide.bs.modal', function (e) {
      $('#box-action button').hide();
      $('#tree').treegrid('unselectAll');
      $(this).find('.overlay').hide();
  });
  
  // $('#formprogram').on('show.bs.modal', function (e) {
      
  //     var data   = $(e.relatedTarget).data(), 
  //         action = $('#create-program').attr('action'),
  //         modal  = $(this), base = $('base').attr('href');
  //         remote = modal.find('.modal-body input[name="code"]').data('remote');

  //     modal.find('.modal-title').html("<i class='fa fa-plus-circle'></i> Tambah Data");
  //     modal.find('.modal-body input[name="code"]').attr('data-parsley-remote', remote);

  //     modal.find('.modal-body input[name="_method"]').val('POST');

  //     if (data.method == "put") {
  //         var program = table.row( $(e.relatedTarget).parents('tr') ).data();
  //         modal.find('.modal-title').html(
  //             "<i class='fa fa-edit'></i> Edit Data"
  //         );
          
  //         action =  $('#create-program').data('edit') + program.id;

  //         $('#formprogram [name="code"]').val(program.code);
  //         $('#formprogram [name="code"]').data('edit', program.code);
  //         $('#formprogram [name="name"]').val(program.name);
  //         $('#formprogram [name="_method"]').val('PUT');
          
  //     } else {
  //         $('#formprogram [name="code"]').removeData('edit');
  //     }
      
  //     $('#formprogram [name="code"]').parsley()
  //         .on('field:validate', function(field) {
  //             var lmn = this.$element;
  //             var rem = lmn.data('remote');
              
  //             if (lmn.data('edit') == this.value) {
  //                 this.removeConstraint('remote');
  //             } else {
  //                 this.addConstraint({
  //                     'remote' : lmn.data('parsleyRemote') 
  //                 });
  //             }

  //         });

  //     $('#create-program').parsley().on('form:submit', function() {
  //         $.ajax({
  //             type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
  //             dataType    : 'JSON', // what type of data do we expect back from the server
  //             data        : $('#create-program').serialize(), // our data object
  //             url         : action, // the url where we want to POST
  //             encode      : true,
  //             beforeSend  : function () {
  //                 $('#formprogram').find('.overlay').show();
  //             }
  //         }).done(function (result) {
  //             $('#formprogram').modal('hide');
              
  //             table.ajax.reload(null, false);

  //             flashMessage(result);

  //         }).fail(function(result) {
  //             $('#formprogram').modal('hide');
              
  //             table.ajax.reload(null, false);
              
  //             var data = {};
              
  //             if (typeof result.error == "function" ) {
  //                 data.error   = result.status;
  //                 data.message = result.statusText;
  //             } else {
  //                 data = result;
  //             }
              
  //             flashMessage(data, true);
  //         });

  //         return false;
  //     });

  // });

  

  // // reset form on modal hide
  // $('#formprogram').on('hide.bs.modal', function (e) {
  //     $('#create-program').parsley().reset(); 
  //     $('#create-program')[0].reset();
  //     $(this).find('.overlay').hide();
  // });

  // // reset form on modal hide
  // $('#hapusprogram').on('hide.bs.modal', function (e) {
  //     $('#hapusprogram form').parsley().reset(); // reset form on modal hide
  //     $(this).find('.overlay').hide();
  // });
  </script>
@endsection