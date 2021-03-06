@extends('layouts.adminlte')

@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  @parent
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
              <button class="btn btn-success btn-social" title="Tambah Data @yield('unitkerja')"
                data-toggle="modal" 
                data-target="#formunitkerja" 
                data-method="post" 
              >
                <i class="fa fa-plus"> </i> Tambah Data @yield('unitkerja')
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
          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <button type="button" class="close" aria-hidden="true" data-dismiss="alert">×</button>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
            </div>
          @endif
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
          <div class="overlay" style="display: none;"> <i class="fa fa-refresh fa-spin"></i> </div>
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
  @include('includes.parsley')
  
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/select2.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  
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

  @yield('custom-javascript')

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

      $('#unitkerja').DataTable().ajax.reload(null, false);

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
  
  <!-- Modal related -->
  <script>
  $('#formunitkerja').on('show.bs.modal', function (e) {
      $('#create-unitkerja').parsley().reset();
      $('#create-unitkerja')[0].reset();

      var method = $(e.relatedTarget).data('method'); 
      var modal  = $(this), d = new Date(); 
      var remote = $(this).find('.modal-body input[name="codename"]').data('remote');
      var action = $('#create-unitkerja').attr('action');

      modal.find('.modal-body input[name="_method"]').val('POST');
      modal.find('.modal-body input[name="codename"]')
          .attr('data-parsley-remote', remote + "?" + d.getTime());

      if (method == "put") {
          var unit = table.row( $(e.relatedTarget).parents('tr') ).data();

          console.log(unit);
          
          modal.find('.modal-title').html("<i class='fa fa-edit'></i> Edit Data");
          
          action =  $('#create-unitkerja').data('edit') + unit.id;

          @yield('additionalform')

          $('#formunitkerja [name="codename"]').val(unit.codename);
          $('#formunitkerja [name="codename"]').data('edit', unit.codename);
          $('#formunitkerja [name="name"]').val(unit.name);
          $('#formunitkerja [name="parent"]').val(unit.parent).trigger("change");
          $('#formunitkerja [name="_method"]').val('PUT');
          
      } else {
          $('#formunitkerja [name="codename"]').removeData('edit');
          
          modal.find('.modal-title').html(
            "<i class='ion-person-add'></i> Tambah Data"
          );
      }
      
      $('#formunitkerja [name="codename"]').parsley()
          .on('field:validate', function(field) {
              var lmn = this.$element;
              
              if (lmn.data('edit') == this.value) {
                  this.removeConstraint('remote');
              } else {
                  this.addConstraint({'remote' : lmn.data('parsleyRemote')});
              }
          });

      $('#create-unitkerja').parsley().on('form:submit', function() {
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              url         : action, // the url where we want to POST
              data        : $('#create-unitkerja').serialize(),
              encode      : true,
              beforeSend  : function () {
                  $('#formunitkerja').find('.overlay').show();
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

  $('#hapusunitkerja').on('show.bs.modal', function (e) {
      var modal = $(this);
      var data  = table.row( $(e.relatedTarget).parents('tr') ).data();
          modal.find('.modal-title').html("Hapus " + data.name);
          modal.find('.modal-body input[name="id"]').val(data.id);  

      $('#hapusunitkerja form').parsley().on('form:submit', function() {
          var formData = {
              '_method'  : 'DELETE',
              '_token'   : $('#hapusunitkerja form input[name=_token]').val()
          },  id = $('#hapusunitkerja form input[name=id]').val();

          $.ajax({
              type       : 'POST',   // define the type of HTTP verb we want to use (POST for our form)
              dataType   : 'JSON',   // what type of data do we expect back from the server
              data       : formData, // our data object
              url        : $('#hapusunitkerja form').attr('action') + "/" + id, // the url where we want to POST
              encode     : true,
              beforeSend : function () {
                  $('#hapusunitkerja').find('.overlay').show();
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

  // Reset everything on hide
  $('#formunitkerja').on('hide.bs.modal', function (e) {
      try {
          $('#create-unitkerja')[0].reset();
          $('#create-unitkerja').parsley().reset(); 
          $("[name='parent']").select2("val", "");
      } catch (err) {
          // console.log(err);
      } finally {
          $(this).find('.overlay').hide();
      }

  });
  
  // Reset everything on hide
  $('#hapusunitkerja').on('hide.bs.modal', function (e) {
      try {
          $('#hapusunitkerja form').parsley().reset(); // reset form on modal hide
      } catch (err) {
          // console.log(err);
      } finally {
          $(this).find('.overlay').hide();
      }

  });
  </script>
@endsection