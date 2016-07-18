@extends('layouts.adminlte')

@section('title', 'Kelola Data Pengguna')

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
  <h1> User <small>dashboard</small> </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">User</a></li>
    <li class="active">Manage</li>
  </ol>
@endsection 

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Pengguna</h3>
          <div class="pull-right box-tools  no-print">
            <!-- Header Button -->
            <button class="btn btn-success btn-social" data-toggle="modal" data-target="#formuser" data-method="post" title="Tambah Data Pengguna">
                <i class="fa fa-plus"> </i> Tambah Data Pengguna
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
          <table id="users" class="table table-bordered table-hover table-striped" 
            data-url="{{ route('user.datatables') }}"
          >
            <thead>
              <tr>
                <th style="width: 18px;padding-right: 8px" class="text-center">No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Registrasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody> </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="formuser">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          <form id="create-user" method="post" action="{{ route('user.create') }}"
            data-edit="{{ route('user.update', "/") }}/"  
          >
            <div class="form-group">
              <label>Nama Pengguna</label>
              <input class="form-control" name="name" placeholder="Name Pengguna" type="text" required
              />
            </div>
            <div class="form-group">
              <label>Email Pengguna</label>
              <div class="input-group">
                <input class="form-control" name="email" placeholder="Email Pengguna" type="text" required 
                maxlength="255" 
                data-remote="{{ route('user.get', '') }}/{value}" 
                data-parsley-remote-validator="reverse" 
                data-parsley-remote-message="email sudah ada"
                />
                <span class="input-group-addon">@lemsaneg.go.id</span>
              </div>
            </div>
            <div class="form-group">
              <label>Default Password</label>
              <input class="form-control" name="password" placeholder="Password" type="password" />
            </div>
            <div class="form-group">
              <label>Default Password Confirm</label>
              <input class="form-control" name="password_confirmation" placeholder="Password Confirm" type="password" required data-parsley-equalto='[name="password"]' data-parsley-equalto-message='password tidak sama'/>
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
          <button form="create-user" type="submit" class="btn btn-primary">Simpan</button>
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
        <form method="post" action="{{ route('user.delete', '/')}}">
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
  <!-- iCheck 1.0.1 -->
  <script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/select2.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  
  <!-- Form validation -->
  <script>
  $(document).ready(function () {
      $('#create-user').parsley({
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

      $('#users').DataTable().ajax.reload(null, false);

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
    var table = $('#users').DataTable({
        "jQueryUI"   : true,
        "paging"     : true,
        "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
        "autoWidth"  : false,
        "stateSave"  : false,
        "order"      : [[ 1, 'asc' ]],
        "serverSide" : true,
        "ajax": {
            "url": $('#users').data('url'),
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data  : 'created_at',
                name  : 'created_at',
                class : 'text-center'
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
                btn_edit += "data-target='#formuser' data-method='put'>"
                btn_edit += "<i class='fa fa-edit'></i></buton> ";
            
                btn_del  = "<buton class='btn btn-danger' data-toggle='modal'";
                btn_del += "data-target='#hapus'>"
                btn_del += "<i class='fa fa-trash'></i></buton>";
            
            $('td', row).eq(-1).html( btn_edit + btn_del );
        }
    });
  </script>

  <!-- Modal related -->
  <script>
  $('#formuser').on('show.bs.modal', function (e) {
      $('#create-user').parsley().reset(); 
      $('#create-user')[0].reset();

      var data   = $(e.relatedTarget).data(), d = new Date();
          action = $('#create-user').attr('action'),
          modal  = $(this), base = $('base').attr('href');
      var remote = $(this).find('.modal-body input[name="email"]').data('remote');

      modal.find('.modal-title').html("<i class='fa fa-plus-circle'></i> Tambah Data");
      modal.find('.modal-body input[name="email"]')
          .attr('data-parsley-remote', remote + "?" + d.getTime());
      modal.find('.modal-body [name="_method"]').val('POST');

      if (data.method == "put") {
          var user = table.row( $(e.relatedTarget).parents('tr') ).data();
          action   =  $('#create-user').data('edit') + user.id;
          modal.find('.modal-title').html("<i class='fa fa-edit'></i> Edit Data");
          modal.find('.modal-body [name="name"]').val(user.name);
          modal.find('.modal-body [name="email"]').val(user.email.replace('@lemsaneg.go.id', ''));
          modal.find('.modal-body [name="email"]').data('edit', user.email.replace('@lemsaneg.go.id', ''));
          modal.find('.modal-body [name="_method"]').val('PUT');
          modal.find('.modal-body [name="password"]').removeAttr('required');
          modal.find('.modal-body [name="password_confirmation"]').removeAttr('required');
      } else {
          modal.find('.modal-body [name="password"]').attr('required', '');
          modal.find('.modal-body [name="password_confirmation"]').attr('required', '');
      }

      $('#formuser [name="email"]').parsley()
          .on('field:validate', function(field) {
              var lmn = this.$element;
              
              if (lmn.data('edit') == this.value) {
                  this.removeConstraint('remote');
              } else {
                  this.addConstraint({'remote' : lmn.data('parsleyRemote')});
              }
          });
     
      $('#create-user').parsley().on('form:submit', function() {
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              data        : modal.find('form').serialize(), // our data object
              url         : action, // the url where we want to POST
              encode      : true,
              beforeSend  : function () {
                  modal.find('.overlay').show();
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

  $('#hapus').on('show.bs.modal', function (e) {
      var modal = $(this);
      var data  = table.row( $(e.relatedTarget).parents('tr') ).data();
          modal.find('.modal-title').html("Hapus " + data.name);
          modal.find('.modal-body input[name="id"]').val(data.id);  

      $('#hapus form').parsley().on('form:submit', function() {
          var formData = {
              '_method'  : 'DELETE',
              '_token'   : $('#hapus form input[name=_token]').val()
          },  id = $('#hapus form input[name=id]').val();

          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              url         : modal.find('form').attr('action') + "/" + id, // the url where we want to POST
              data        : formData, // our data object
              encode      : true,
              beforeSend  : function () {
                  modal.find('.overlay').show();
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
  $('#formuser').on('hide.bs.modal', function (e) {
      $('#formuser form').parsley().reset(); 
      $('#formuser form')[0].reset();
      $(this).find('.overlay').hide();
  });

  // reset form on modal hide
  $('#hapus').on('hide.bs.modal', function (e) {
      $('#hapus form').parsley().reset(); // reset form on modal hide
      $(this).find('.overlay').hide();
  });
  </script>
@endsection