@extends('unit-kerja')

@section('title', 'Data Unit Kerja Eselon I')

@section('unitkerja', 'Eselon I')

@section('tabel-unitkerja')
  <table id="unitkerja" class="table table-bordered table-hover table-striped" 
    data-url="{{ route('api.eselon_satu.datatables') }}"
  >
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
@endsection

@section('form-unitkerja')
  <form id="create-unitkerja" action="{{ route('api.eselon_satu.create') }}" 
    method="post"
  >
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
@endsection


@section('custom-js')
  @parent
  
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

  <!-- Modal related -->
  <script>

  $('#formunitkerja').on('show.bs.modal', function (e) {
      $('#create-unitkerja')[0].reset();

      var data   = $(e.relatedTarget).data(), 
          action = $('#create-unitkerja').attr('action'),
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
      
      $('#create-unitkerja').parsley().on('form:submit', function() {
          var formData = {
            'name'     : $('#create-unitkerja input[name=name]').val(),
            'codename' : $('#create-unitkerja input[name=codename]').val(),
            '_method'  : $('#create-unitkerja input[name=_method]').val(),
            '_token'   : $('#create-unitkerja input[name=_token]').val()
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
      $('#create-unitkerja').parsley().reset(); // reset form on modal hide
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