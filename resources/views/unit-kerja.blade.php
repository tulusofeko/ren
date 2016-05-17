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


@section('custom-js')
  @include('includes.parsley')
  <!-- DataTables -->
  <script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  
  <!-- Form validation -->
  <script>
  $(document).ready(function() {
      $('#create-unitkerja').parsley({
          errorClass    : 'has-error',
          errorsWrapper : '<ul class="parsley-errors-list list-unstyled"></ul>',
          errorTemplate : '<li class="small text-danger"></li>',
          classHandler: function (ParsleyField) {
              var element = ParsleyField.$element;
              return element.parents('.form-group');
          },
          errorsContainer: function (ParsleyField) {
              var element = ParsleyField.$element;
              return element.parents('.form-group');
          },
      });
  });
  </script>
  
  @yield('ukjs')

  <script>

  function flashMessage(data) {

      var error, message;

      if (typeof data.error == "function" ) {
          error   = data.status;
          message = data.statusText;
      } else {
          error   = data.error;
          message = data.message;
      }
      
      if (typeof data.raw != "undefined" ) {
          console.log(data.raw);
      }

      $('#flash-message').html(
        "<div class='alert'>" +
          "<button type='button' class='close' data-dismiss='alert' " + 
            "aria-hidden='true'>×</button>" +
          "<p class='alert-messages'></p>"  +
        "</div>"
      );

      if (data.error === 0) {
          $('#flash-message .alert').addClass('alert-success');
          $('#flash-message .alert .alert-messages').html(message);

      } else {
          $('#flash-message .alert').addClass('alert-danger');

          $('#flash-message .alert .alert-messages').html(
              "Error " + error + ": " + message
          );
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

  $('#formunitkerja').on('hide.bs.modal', function (e) {
      $('#create-unitkerja').parsley().reset(); // reset form on modal hide
      $(this).find('.overlay').hide();
  });

  $('#hapusunitkerja').on('hide.bs.modal', function (e) {
      $('#hapusunitkerja form').parsley().reset(); // reset form on modal hide
      $(this).find('.overlay').hide();
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
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              url         : $('#hapusunitkerja form').attr('action') + "/" + id, // the url where we want to POST
              data        : formData, // our data object
              dataType    : 'json', // what type of data do we expect back from the server
              encode      : true,
              beforeSend  : function () {
                  $('#hapusunitkerja').find('.overlay').show();
              }
          }).done(function (result) {
              $('#hapusunitkerja').modal('hide');
              
              table.ajax.reload(null, false);

              flashMessage(result);    
                           
          }).fail(function(result) {
              $('#hapusunitkerja').modal('hide');
              
              flashMessage(result);    
          });

          return false;
      });  
  });
  </script>
@endsection