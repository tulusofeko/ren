@extends('layouts.adminlte')

@section('title', 'Kelola Data Program')

@section('css')
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/all.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  @parent
@endsection

@section('content-header')
  <h1> Program <small>dashboard</small> </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Program</a></li>
    <li class="active">Manage</li>
  </ol>
@endsection 

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Program</h3>
          <div class="pull-right box-tools  no-print">
            <!-- Header Button -->
            <button class="btn btn-success btn-social" data-toggle="modal" data-target="#formprogram" data-method="post" title="Tambah Data Program">
                <i class="fa fa-plus"> </i> Tambah Data Program
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
          <table id="programs" class="table table-bordered table-hover table-striped" 
            data-url="{{ route('program.datatables') }}"
          >
            <thead>
              <tr>
                <th style="width: 18px;padding-right: 8px" class="text-center">No.</th>
                <th>Kode</th>
                <th>Nama Program</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody> </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="formprogram">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          <form id="create-program" method="post" action="{{ route('program.create') }}"
            data-edit="{{ route('program.update', "/") }}/"  
          >
            <div class="form-group">
              <label>Kode Program</label>
              <input class="form-control" name="code" placeholder="Kode Program" type="text" required maxlength="2"
                data-remote="{{ route('program.show') }}/{value}" 
                data-parsley-remote-reverse="true" 
                data-parsley-remote-message="Kode Program sudah ada" 
              />
            </div>

            <div class="form-group">
              <label>Nama Program</label>
              <input class="form-control" name="name" placeholder="Name Program" type="text" required
              />
            </div>
            <div class="form-group">
              <input type="hidden" name="_method" value="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
          </form>

          <div class="overlay" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
        <div class="modal-footer clearfix">
          <button form="create-program" type="submit" class="btn btn-primary">Simpan</button>
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
        <form method="post" action="{{ route('program.delete', '/')}}">
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
  <!-- Form validation -->
  <script>
  $(document).ready(function () {
      $('#create-unitkerja').parsley({
          errorsWrapper : '<ul class="parsley-errors-list list-unstyled"></ul>',
          errorTemplate : '<li class="small text-danger"></li>',
          errorClass    : 'has-error',
          classHandler  : function (ParsleyField) {
              var element = ParsleyField.$element;
              return element.parents('.form-group');
          },
          errorsContainer: function (ParsleyField) {
              var element = ParsleyField.$element;
              return element.parents('.form-group');
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
      console.log(data);

      if (error === true) {
          $('#flash-message .alert').addClass('alert-danger');
          $('#flash-message .alert .alert-messages').html(data.message);
      } else {

          $('#flash-message .alert').addClass('alert-success');
          $('#flash-message .alert .alert-messages').html(data.message);
      }

      $('.modal').modal('hide');

      $('#programs').DataTable().ajax.reload(null, false);

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

  <script>
    $('[name=eselondua]').select2({ placeholder: "Pilih Unit Eselon Dua", });

    var table = $('#programs').DataTable({
        "jQueryUI"   : true,
        "paging"     : true,
        "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
        "autoWidth"  : false,
        "stateSave"  : false,
        "order"      : [[ 1, 'asc' ]],
        "serverSide" : true,
        "ajax": {
            "url": $('#programs').data('url'),
            "type": "POST"
        },
        "columns": [
            {
                className: 'text-center',
                data: null,
                defaultContent: '',
                name: 'nomor',
                searchable: false,
                sortable: false
            },
            {
                className: 'text-center',
                data: 'code',
                name: 'code'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                className: 'text-center',
                data: null,
                defaultContent: '',
                name: 'aksi',
                searchable: false,
                sortable: false
            },
        ],
        "createdRow": function ( row, data, index ) {
            
            $('td', row).eq(0).html(table.page.info().start + index + 1);

            var btn_edit, btn_del;

                btn_edit  = "<buton class='btn btn-primary' data-toggle='modal'";
                btn_edit += "data-target='#formprogram' data-method='put'>"
                btn_edit += "<i class='fa fa-edit'></i></buton> ";
            
                btn_del  = "<buton class='btn btn-danger' data-toggle='modal'";
                btn_del += "data-target='#hapusprogram'>"
                btn_del += "<i class='fa fa-trash'></i></buton>";
            
            $('td', row).eq(-1).html( btn_edit + btn_del );
        }
    });
  </script>

  <!-- Modal related -->
  <script>
  $('#formprogram').on('show.bs.modal', function (e) {
      $('#create-program').parsley().reset(); 
      $('#create-program')[0].reset();

      var data   = $(e.relatedTarget).data(), d = new Date();
          action = $('#create-program').attr('action'),
          modal  = $(this), base = $('base').attr('href');
          remote = modal.find('.modal-body input[name="code"]').data('remote');

      modal.find('.modal-title').html("<i class='fa fa-plus-circle'></i> Tambah Data");
      modal.find('.modal-body input[name="code"]').attr(
        'data-parsley-remote', remote + "?" + d.getTime()
      );

      modal.find('.modal-body input[name="_method"]').val('POST');

      if (data.method == "put") {
          var program = table.row( $(e.relatedTarget).parents('tr') ).data();
          modal.find('.modal-title').html(
              "<i class='fa fa-edit'></i> Edit Data"
          );
          
          action =  $('#create-program').data('edit') + program.id;

          $('#formprogram [name="code"]').val(program.code).inputmask('9[9]');
          $('#formprogram [name="code"]').data('edit', program.code);
          $('#formprogram [name="name"]').val(program.name);
          $('#formprogram [name="_method"]').val('PUT');
          
      } else {
          $('#formprogram [name="code"]').val("").inputmask('9[9]');
          $('#formprogram [name="code"]').removeData('edit');
      }
      
      $('#formprogram [name="code"]').parsley()
          .on('field:validate', function(field) {
              var lmn = this.$element;
              var rem = lmn.data('remote');

              if (lmn.data('edit') == this.value) {
                  this.removeConstraint('remote');
              } else {
                  this.addConstraint({
                      'remote' : lmn.data('parsleyRemote') 
                  });
              }

          });

      $('#create-program').parsley().on('form:submit', function() {
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              data        : $('#create-program').serialize(), // our data object
              url         : action, // the url where we want to POST
              encode      : true,
              beforeSend  : function () {
                  $('#formprogram').find('.overlay').show();
              }
          }).done(flashMessage).fail(function(result) {
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

  $('#hapusprogram').on('show.bs.modal', function (e) {
      var modal = $(this);
      var data  = table.row( $(e.relatedTarget).parents('tr') ).data();
          modal.find('.modal-title').html("Hapus " + data.name);
          modal.find('.modal-body input[name="id"]').val(data.id);  

      $('#hapusprogram form').parsley().on('form:submit', function() {
          var formData = {
              '_method'  : 'DELETE',
              '_token'   : $('#hapusprogram form input[name=_token]').val()
          },  id = $('#hapusprogram form input[name=id]').val();

          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              url         : $('#hapusprogram form').attr('action') + "/" + id, // the url where we want to POST
              data        : formData, // our data object
              dataType    : 'json', // what type of data do we expect back from the server
              encode      : true,
              beforeSend  : function () {
                  $('#hapusprogram').find('.overlay').show();
              }
          }).done(flashMessage).fail(function(result) {
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

  // reset form on modal hide
  $('#formprogram').on('hide.bs.modal', function (e) {
      $('#create-program').parsley().reset(); 
      $('#create-program')[0].reset();
      $(this).find('.overlay').hide();
  });

  // reset form on modal hide
  $('#hapusprogram').on('hide.bs.modal', function (e) {
      $('#hapusprogram form').parsley().reset(); // reset form on modal hide
      $(this).find('.overlay').hide();
  });
  </script>
@endsection