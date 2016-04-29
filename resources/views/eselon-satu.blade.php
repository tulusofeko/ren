@extends('layouts.adminlte')

@section('title', 'Data Unit Kerja Eselon I')

@section('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content-header')
  <h1> Eselon I <small>dashboard</small> </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Unit Kerja</a></li>
    <li class="active">Eselon I</li>
  </ol>
@endsection 

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Unit Kerja Eselon I</h3>
          <div class="pull-right box-tools  no-print">
              <button class="btn btn-success btn-social" data-toggle="modal" data-target="#formunitkerja" data-method="post" title="Tambah Data Eselon I">
                <i class="fa fa-plus"> </i> Tambah Data Eselon I
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
          <table id="unitkerja" class="table table-bordered table-hover table-striped" data-url="{{ route('api.eselon_satu.datatables') }}">
            <thead>
              <tr>
                <th style="width: 18px;padding-right: 8px" class="text-center">No.</th>
                <th>Unit Kerja</th>
                <th>Alias</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
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
          <form id="create-eselon-satu" action="{{ route('api.eselon_satu.create') }}" method="post">
            <div class="form-group">
              <label>Nama Unit Kerja Eselon I</label>
              <input class="form-control" name="name" placeholder="Nama Unit Kerja Eselon I" type="text" required/>
            </div>
            <div class="form-group">
              <label>Alias</label>
              <input class="form-control" name="codename" placeholder="Alias" type="text" required data-remote="{{ route('view.eselon_satu') }}/{value}" data-parsley-remote-reverse="true" data-parsley-remote-message="Alias sudah ada" maxlength="2" />
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
          <button form="create-eselon-satu" type="submit" class="btn btn-primary">Simpan</button>
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
  <!-- Datatable related -->
  <script>
    var table = $('#unitkerja').DataTable({
        "jQueryUI"   : true,
        "paging"     : true,
        "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
        "autoWidth"  : false,
        "stateSave"  : false,
        "order"      : [[ 2, 'asc' ]],
        "serverSide" : true,
        "ajax": {
            "url": $('#unitkerja').data('url'),
            "type": "POST",
            "data":
            {
                '_token': '{{ csrf_token() }}'
            }
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
                data: 'codename',
                name: 'codename'
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

            var btn_edit, base = $('base').attr('href');
                btn_edit  = "<buton class='btn btn-primary' data-toggle='modal'";
                btn_edit += "data-target='#formunitkerja' data-method='put'>"
                btn_edit += "<i class='fa fa-edit'></i></buton> ";
                btn_edit += "<buton class='btn btn-danger' data-toggle='modal'";
                btn_edit += "data-target='#hapusunitkerja'>"
                btn_edit += "<i class='fa fa-trash'></i></buton>";
            $('td', row).eq(-1).html( btn_edit );
        }
    });
  </script>
  <!-- Form validation -->
  <script>
  $(document).ready(function() {
      $('#create-eselon-satu').parsley({
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

  <!-- Modal related -->
  <script>

  $('#formunitkerja').on('show.bs.modal', function (e) {
      $('#create-eselon-satu')[0].reset();

      var data   = $(e.relatedTarget).data(), 
          action = $('#create-eselon-satu').attr('action'),
          modal  = $(this), base = $('base').attr('href');
          remote = modal.find('.modal-body input[name="codename"]').data('remote');

      modal.find('.modal-title').html("<i class='ion-person-add'></i> Tambah Data");
      modal.find('.modal-body input[name="codename"]').attr('data-parsley-remote', remote);
      modal.find('.modal-body input[name="_method"]').val('POST');

      if (data.method == "put") {
          var eselon_satu  = table.row( $(e.relatedTarget).parents('tr') ).data();
              

          modal.find('.modal-title').html(
              "<i class='fa fa-edit'></i> Edit Data"
          );
          
          action =  base+ "/unit/eselon-satu/update/" + eselon_satu.codename;

          $('#formunitkerja input[name="codename"]').val(eselon_satu.codename);
          $('#formunitkerja input[name="codename"]').removeAttr('data-parsley-remote');
          $('#formunitkerja input[name="name"]').val(eselon_satu.name);
          $('#formunitkerja input[name="_method"]').val('PUT');
          
          
      }
      
      $('#create-eselon-satu').parsley().on('form:submit', function() {
          var formData = {
            'name'     : $('#create-eselon-satu input[name=name]').val(),
            'codename' : $('#create-eselon-satu input[name=codename]').val(),
            '_method'  : $('#create-eselon-satu input[name=_method]').val(),
            '_token'   : $('#create-eselon-satu input[name=_token]').val()
          };
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              url         : action, // the url where we want to POST
              data        : formData, // our data object
              dataType    : 'json', // what type of data do we expect back from the server
              encode      : true,
              beforeSend  : function () {
                $('#formunitkerja').find('.overlay').show();
              }
          }).done(function (result) {

                if (result.error == 0) {
                    $('#formunitkerja').modal('hide');
                    
                    table.ajax.reload(null, false);

                    $('#flash-message .alert').addClass('alert-success');
                    $('#flash-message .alert .alert-messages').html("Data berhasil disimpan");

                    $('#flash-message').slideDown(function() {
                        setTimeout(function() {
                            $('#flash-message').slideUp("slow", function() {
                                $('#flash-message .alert').removeClass('alert-success');
                                $('#flash-message .alert .alert-messages').html('');
                            });
                        }, 2000);
                    });
                }

                // here we will handle errors and validation messages
          }).fail(function(result) {
              $('#formunitkerja').modal('hide');
              $('#flash-message .alert').addClass('alert-danger');
              $('#flash-message .alert .alert-messages').html("Gagal menyimpan data");

              $('#flash-message').slideDown(function() {
                  setTimeout(function() {
                      $('#flash-message').slideUp("slow", function() {
                          $('#flash-message .alert').removeClass('alert-dager');
                          $('#flash-message .alert .alert-messages').html('');
                      });
                  }, 2000);
              });
          });

          return false;
      });

  });

  $('#formunitkerja').on('hide.bs.modal', function (e) {
      $('#create-eselon-satu').parsley().reset(); // reset form on modal hide
      $(this).find('.overlay').hide();
  });

  $('#hapusunitkerja').on('hide.bs.modal', function (e) {
      $('#hapus-eselon-satu').parsley().reset(); // reset form on modal hide
      $(this).find('.overlay').hide();
  });

  $('#hapusunitkerja').on('show.bs.modal', function (e) {
      var modal = $(this);
      var data  = table.row( $(e.relatedTarget).parents('tr') ).data();
          modal.find('.modal-title').append(data.name);
          modal.find('.modal-body input[name="id"]').val(data.id);  

      $('#hapus-eselon-satu').parsley().on('form:submit', function() {
          var formData = {
            '_method'  : 'DELETE',
            '_token'   : $('#hapus-eselon-satu input[name=_token]').val()
          }, id = $('#hapus-eselon-satu input[name=id]').val();

          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              url         : $('#hapus-eselon-satu').attr('action') + "/" + id, // the url where we want to POST
              data        : formData, // our data object
              dataType    : 'json', // what type of data do we expect back from the server
              encode      : true,
              beforeSend  : function () {
                $('#hapusunitkerja').find('.overlay').show();
              }
          }).done(function (result) {
                if (result.error == 0) {
                    $('#hapusunitkerja').modal('hide');
                    
                    table.ajax.reload(null, false);

                    $('#flash-message .alert').addClass('alert-success');
                    $('#flash-message .alert .alert-messages').html("Data berhasil dihapus");

                    $('#flash-message').slideDown(function() {
                        setTimeout(function() {
                            $('#flash-message').slideUp("slow", function() {
                                $('#flash-message .alert').removeClass('alert-success');
                                $('#flash-message .alert .alert-messages').html('');
                            });
                        }, 2000);
                    });
                }

                // here we will handle errors and validation messages
          }).fail(function(result) {
              $('#hapusunitkerja').modal('hide');
              $('#flash-message .alert').addClass('alert-danger');
              $('#flash-message .alert .alert-messages').html("Penghapusan data gagal");

              $('#flash-message').slideDown(function() {
                  setTimeout(function() {
                      $('#flash-message').slideUp("slow", function() {
                          $('#flash-message .alert').removeClass('alert-dager');
                          $('#flash-message .alert .alert-messages').html('');
                      });
                  }, 2000);
              });
          });

          return false;
      });  
  });

  </script>
  
@endsection