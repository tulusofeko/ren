@extends('layouts.adminlte')

@section('title', 'Kelola Data Kegiatan')

@section('css')
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ url('adminlte/plugins/iCheck/square/red.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  @parent
  <style type="text/css">
    .radio-label {
        font-weight  : normal;
        display      : inline-block;
        height       : 22px;
        line-height  : 22px;
        padding-left : 15px;
    }

  </style>
@endsection

@section('content-header')
  <h1> Kegiatan <small>dashboard</small> </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Kegiatan</a></li>
    <li class="active">Manage</li>
  </ol>
@endsection 

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Kegiatan</h3>
          <div class="pull-right box-tools  no-print">
            <!-- Header Button -->
            <button class="btn btn-success btn-social" title="Tambah Data Kegiatan"
              data-toggle="modal" 
              data-target="#formkegiatan" 
              data-method="post" 
            >
                <i class="fa fa-plus"> </i> Tambah Data Kegiatan
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
          <table id="kegiatans" class="table table-bordered table-hover table-striped" 
            data-url="{{ route('api.kegiatan.datatables') }}"
          >
            <thead>
              <tr>
                <th style="width: 18px;padding-right: 8px" class="text-center">No.</th>
                <th>Program</th>
                <th>Kode</th>
                <th>Nama Kegiatan</th>
                <th style="width: 70px;">Unit Kerja</th>
                <th style="width: 100px;">Aksi</th>
              </tr>
            </thead>
            <tbody> </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="formkegiatan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body overlay-wrapper">
          <!-- Modal body -->
          <form id="create-kegiatan" method="post" action="{{ route('api.kegiatan.create') }}"
            data-edit="{{ route('api.kegiatan.update', "/") }}/"  
          >
            <div class="form-group">
              <label>Kode Kegiatan</label>
              <input class="form-control" name="code" placeholder="Kode Kegiatan" type="text" required maxlength="4"
                data-remote="{{ route('view.kegiatan') }}/{value}" 
                data-parsley-remote-reverse="true" 
                data-parsley-remote-message="Kode sudah ada" 
              />
            </div>

            <div class="form-group">
              <label>Nama Kegiatan</label>
              <input class="form-control" name="name" placeholder="Name Kegiatan" type="text" 
                required
              />
            </div>
            
            <div class="form-group">
              <label>Eselon II</label>
              <select name="eselondua" style="width: 100%;height: 24px;" required
                data-parsley-required-message="Pilih Eselon II"
              >
                <option></option>
                @foreach ($eselon_dua as $eselon_satu => $units)
                    <optgroup label="{{ $eselon_satu}}">
                        @foreach ($units as $unit)
                            <option value="{{ $unit->codename }}"> 
                                {{ $unit->codename }} - {{ $unit->name }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
              </select>
            </div>
            <div class="form-group">
            @foreach ($programs as $program)
              <div style="margin-bottom: 10px;">
                <label>
                  <input name="program" value="{{ $program->code }}" type="radio" required 
                    data-parsley-required-message="Pilih Program"
                  >
                  <span class="radio-label">{{ $program->name }}</span>
                </label>
              </div>
            @endforeach
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
          <button form="create-kegiatan" type="submit" class="btn btn-primary">Simpan</button>
          <button class="btn btn-danger" data-dismiss="modal">Batal</button>
          <!-- Modal footer -->
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>
  <div class="modal fade" id="hapuskegiatan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="ion-android-delete"></i> Hapus Data </h4>
        </div>
        <form method="post" action="{{ route('api.kegiatan.delete', '')}}">
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
  <!-- iCheck 1.0.1 -->
  <script src="{{ url('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ url('vendor/select2/js/select2.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ url('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  
  <!-- Form validation -->
  <script>
  $(document).ready(function() {
      $('#create-kegiatan').parsley({
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
  $(function(){
      $("#flash-message .close").on("click", function(){
          $("#flash-message").hide();
      });
  });
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

  <script>
    $('[name=eselondua]').select2({ 
        placeholder: "Pilih Unit Eselon Dua",
    });

    var table = $('#kegiatans').DataTable({
        "jQueryUI"   : true,
        "paging"     : true,
        "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
        "autoWidth"  : false,
        "stateSave"  : false,
        "order"      : [[ 1, 'asc' ], [ 2, 'asc' ]],
        "serverSide" : true,
        "ajax": {
            "url": $('#kegiatans').data('url'),
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
                className: 'text-center',
                data: 'program',
                name: 'program'
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
                data: 'eselondua',
                name: 'eselondua'
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

            var btn_edit, btn_del, base = $('base').attr('href');
                
                btn_edit  = "<buton class='btn btn-primary' data-toggle='modal'";
                btn_edit += "data-target='#formkegiatan' data-method='put'>"
                btn_edit += "<i class='fa fa-edit'></i></buton> ";
                
                btn_del   = "<buton class='btn btn-danger' data-toggle='modal'";
                btn_del  += "data-target='#hapuskegiatan'>"
                btn_del  += "<i class='fa fa-trash'></i></buton>";
            
            $('td', row).eq(-1).html( btn_edit + btn_del );
        }
    });
  </script>
  <!-- Modal related -->
  <script>
  $('#formkegiatan').on('show.bs.modal', function (e) {
      $('#create-kegiatan')[0].reset();

      $("#create-kegiatan input[type='radio']").iCheck({
          radioClass: 'iradio_square-red'
      });


      var data   = $(e.relatedTarget).data(), 
          action = $('#create-kegiatan').attr('action'),
          modal  = $(this);
          remote = modal.find('.modal-body input[name="code"]').data('remote');

      modal.find('.modal-title').html("<i class='ion-person-add'></i> Tambah Data");
      modal.find('.modal-body input[name="code"]').attr('data-parsley-remote', remote);
      modal.find('.modal-body input[name="_method"]').val('POST');

      if (data.method == "put") {
          var kegiatan = table.row( $(e.relatedTarget).parents('tr') ).data();
          
          modal.find('.modal-title').html(
              "<i class='fa fa-edit'></i> Edit Data"
          );
          
          action =  $('#create-kegiatan').data('edit') + kegiatan.id;

          $('#formkegiatan [name="code"]').val(kegiatan.code);
          $('#formkegiatan [name="code"]').data('edit', kegiatan.code);
          $('#formkegiatan [name="name"]').val(kegiatan.name);
          $('#formkegiatan [value="' + kegiatan.program +'"]').iCheck('check');
          $('#formkegiatan [name="eselondua"]').val(kegiatan.eselondua).trigger("change");
          $('#formkegiatan [name="_method"]').val('PUT');
          
      } else {
          $('#formkegiatan [name="code"]').removeData('edit');
      }
      
      $('#formkegiatan [name="code"]').parsley()
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

      $('#create-kegiatan').parsley().on('form:submit', function() {

          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              url         : action, // the url where we want to POST
              data        : $('#create-kegiatan').serialize(), // our data object
              encode      : true,
              beforeSend  : function () {
                  $('#formkegiatan').find('.overlay').show();
              }
          }).done(function (result) {
              $('#formkegiatan').modal('hide');
              
              table.ajax.reload(null, false);

              flashMessage(result);

          }).fail(function(result) {
              $('#formkegiatan').modal('hide');
              
              table.ajax.reload(null, false);
              
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

  $('#hapuskegiatan').on('show.bs.modal', function (e) {
      var modal = $(this);
      var data  = table.row( $(e.relatedTarget).parents('tr') ).data();
          modal.find('.modal-title').html("Hapus " + data.name);
          modal.find('.modal-body input[name="id"]').val(data.id);  

      $('#hapuskegiatan form').parsley().on('form:submit', function() {
          var formData = {
              '_method'  : 'DELETE',
              '_token'   : $('#hapuskegiatan form input[name=_token]').val()
          },  id = $('#hapuskegiatan form input[name=id]').val();

          $.ajax({
              type        : 'POST',   // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON',   // what type of data do we expect back from the server
              data        : formData, // our data object
              url         : $('#hapuskegiatan form').attr('action') + "/" + id, // the url where we want to POST
              encode      : true,
              beforeSend  : function () {
                  $('#hapuskegiatan').find('.overlay').show();
              }
          }).done(function (result) {
              $('#hapuskegiatan').modal('hide');
              
              table.ajax.reload(null, false);

              flashMessage(result);    
                           
          }).fail(function(result) {
              $('#hapuskegiatan').modal('hide');
              
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

  // reset form on modal hide
  $('#formkegiatan').on('hide.bs.modal', function (e) {
      $('#create-kegiatan')[0].reset();
      $('#create-kegiatan').parsley().reset(); 
      $("[name='eselondua']").select2("val", "");
      $(this).find('.overlay').hide();
  });

  // reset form on modal hide
  $('#hapuskegiatan').on('hide.bs.modal', function (e) {
      $('#hapuskegiatan form').parsley().reset(); 
      $(this).find('.overlay').hide();
  });

  </script>
@endsection