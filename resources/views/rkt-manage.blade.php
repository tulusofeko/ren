@extends('layouts.adminlte')

@section('title', 'Kelola Data Usulan RKT')

@section('css')
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ url('adminlte/plugins/iCheck/all.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- JEasyUI -->
  <link rel="stylesheet" type="text/css" href="{{ url('easyui/themes/default/easyui.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('easyui/themes/icon.css') }}">
  @parent
  <style type="text/css">
      .datagrid-wrap.panel-body {
          padding: 0;
      }

      .datagrid-cell {
          padding: 8px;
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
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="flash-message" style="display: none">
            <div class="alert">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <p class="alert-messages"></p>
            </div>
          </div>
          <table id="usulan" class="table table-bordered table-hover table-striped" 
            data-url="{{ route('api.rkt.getdata') }}"
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
  <div class="modal fade" id="formoutput">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Tambah Output</h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          <form id="create-output" method="post" action="{{ route('api.output.create') }}"
            data-edit="{{ route('api.output.update', "/") }}/"  
          >
            <div class="form-group">
              <label>Kegiatan</label>
              <input class="form-control" name="kegiatan" type="text" disabled>
            </div>
            <div class="form-group">
              <label>Kode Output</label>
              <input class="form-control" name="code" placeholder="Kode Output" type="text" required maxlength="2">
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
  <div class="modal fade" id="hapusprogram">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="ion-android-delete"></i> Hapus Data </h4>
        </div>
        <form method="post" action="{{ route('api.program.delete', '')}}">
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


@section('custom-js')
  @include('includes.parsley')
  <!-- EasyUI -->
  <script src="{{ url('easyui/jquery.easyui.min.js') }}"></script>
  <!-- iCheck 1.0.1 -->
  <script src="{{ url('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ url('vendor/select2/js/select2.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  
  <!-- Form validation -->
  <script>
  // $(document).ready(function() {
  //     $('#create-program').parsley({
  //         errorClass    : 'has-error',
  //         errorsWrapper : '<ul class="parsley-errors-list list-unstyled"></ul>',
  //         errorTemplate : '<li class="small text-danger"></li>',
  //         classHandler: function (ParsleyField) {
  //             var element = ParsleyField.$element;
  //             return element.parents('.form-group');
  //         },
  //         errorsContainer: function (ParsleyField) {
  //             var element = ParsleyField.$element;
  //             return element.parents('.form-group');
  //         },
  //     });
  // });
  </script>

  <!-- Flash messages -->
  <script>
  function flashMessage(data, error = false) {
      var error, message;

      if (typeof data.raw != "undefined" ) {
          console.log(data.raw);
      }

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
  function button_switcher(row)
  {
      var button = '';

      console.log(row);

      switch(row.level) {
          case 'kegiatan':
              button += '<button class="btn btn-success btn-social" data-toggle="modal" '; 
              button += 'title="Tambah Data Program"';
              button += 'data-target="#formoutput">';
              button += '<i class="fa fa-plus"> </i> Rekam Output </button>';
      }

      $('#box-action').empty();

      $('#box-action').html(button);

  }

  $('#usulan').treegrid({
      url       : $('#usulan').data('url'),
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
      onClickRow: button_switcher
  });
  </script>

  <script>
    // $('[name=eselondua]').select2({ placeholder: "Pilih Unit Eselon Dua", });

    // var table = $('#programs').DataTable({
    //     "jQueryUI"   : true,
    //     "paging"     : true,
    //     "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
    //     "autoWidth"  : false,
    //     "stateSave"  : false,
    //     "order"      : [[ 1, 'asc' ]],
    //     "serverSide" : true,
    //     "ajax": {
    //         "url": $('#programs').data('url'),
    //         "type": "POST",
    //         "data":
    //         {
    //             '_token': '{{ csrf_token() }}'
    //         }
    //     },
    //     "columns": [
    //         {
    //             className: 'text-center',
    //             data: null,
    //             defaultContent: '',
    //             name: 'nomor',
    //             searchable: false,
    //             sortable: false
    //         },
    //         {
    //             className: 'text-center',
    //             data: 'code',
    //             name: 'code'
    //         },
    //         {
    //             data: 'name',
    //             name: 'name'
    //         },
    //         {
    //             className: 'text-center',
    //             data: null,
    //             defaultContent: '',
    //             name: 'aksi',
    //             searchable: false,
    //             sortable: false
    //         },
    //     ],
    //     "createdRow": function ( row, data, index ) {
            
    //         $('td', row).eq(0).html(table.page.info().start + index + 1);

    //         var btn_edit, btn_del;

    //             btn_edit  = "<button class='btn btn-primary' data-toggle='modal'";
    //             btn_edit += "data-target='#formprogram' data-method='put'>"
    //             btn_edit += "<i class='fa fa-edit'></i></button> ";
            
    //             btn_del  = "<button class='btn btn-danger' data-toggle='modal'";
    //             btn_del += "data-target='#hapusprogram'>"
    //             btn_del += "<i class='fa fa-trash'></i></button>";
            
    //         $('td', row).eq(-1).html( btn_edit + btn_del );
    //     }
    // });
  </script>

  <!-- Modal related -->
  <script>
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

  // $('#hapusprogram').on('show.bs.modal', function (e) {
  //     var modal = $(this);
  //     var data  = table.row( $(e.relatedTarget).parents('tr') ).data();
  //         modal.find('.modal-title').html("Hapus " + data.name);
  //         modal.find('.modal-body input[name="id"]').val(data.id);  

  //     $('#hapusprogram form').parsley().on('form:submit', function() {
  //         var formData = {
  //             '_method'  : 'DELETE',
  //             '_token'   : $('#hapusprogram form input[name=_token]').val()
  //         },  id = $('#hapusprogram form input[name=id]').val();

  //         $.ajax({
  //             type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
  //             url         : $('#hapusprogram form').attr('action') + "/" + id, // the url where we want to POST
  //             data        : formData, // our data object
  //             dataType    : 'json', // what type of data do we expect back from the server
  //             encode      : true,
  //             beforeSend  : function () {
  //                 $('#hapusprogram').find('.overlay').show();
  //             }
  //         }).done(function (result) {
  //             $('#hapusprogram').modal('hide');
              
  //             table.ajax.reload(null, false);

  //             flashMessage(result);    
                           
  //         }).fail(function(result) {
  //             $('#hapusprogram').modal('hide');
              
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