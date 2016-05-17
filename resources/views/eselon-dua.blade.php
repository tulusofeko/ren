@extends('unit-kerja')

@section('title', 'Data Unit Kerja Eselon II')

@section('unitkerja', 'Eselon II')

@section('tabel-unitkerja')
  <table id="unitkerja" class="table table-bordered table-hover table-striped" 
    data-url="{{ route('api.eselon_dua.datatables') }}"
  >
    <thead>
      <tr>
        <th style="width: 18px;padding-right: 8px" class="text-center">No.</th>
        <th>Unit Kerja</th>
        <th>Alias</th>
        <th>Eselon I</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
@endsection


@section('form-unitkerja')
  <form id="create-unitkerja" action="{{ route('api.eselon_dua.create') }}" 
    method="post"
  >
    <div class="form-group">
      <label>Nama Unit Kerja Eselon II</label>
      <input class="form-control" name="name" placeholder="Nama Unit Kerja Eselon II" type="text" required/>
    </div>
    <div class="form-group">
      <label>Alias</label>
      <input class="form-control" name="codename" placeholder="Alias" type="text" 
        required maxlength="3"
        data-remote="{{ route('view.eselon_dua') }}/{value}" 
        data-parsley-remote-reverse="true" 
        data-parsley-remote-message="Alias sudah ada" 
      />
    </div>
    <div class="form-group">
      <label>Eselon I</label>
      <select name="eselon_satu" style="width: 100%;height: 24px;" required
        data-parsley-required-message="Pilih Eselon I"
      >
        <option value>Pilih Unit Eselon I</option>
        @foreach ($eselon_satu as $unit)
            <option value="{{ $unit->codename }}"> 
              {{ $unit->name }} ({{ $unit->codename }})
            </option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>
  </form>
@endsection

@section('ukjs')
  <script>
    $('#hapusunitkerja form').attr('action', '{{ route("api.eselon_dua.delete", "") }}');

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
                className: 'text-center',
                data: 'codename',
                name: 'codename'
            },
            {
                className: 'text-center',
                data: 'eselonsatu',
                name: 'eselonsatu'
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
          var eselon_dua  = table.row( $(e.relatedTarget).parents('tr') ).data();
              
          modal.find('.modal-title').html(
              "<i class='fa fa-edit'></i> Edit Data"
          );
          
          action =  base+ "/unit/eselon-satu/update/" + eselon_dua.codename;

          $('#formunitkerja [name="codename"]').val(eselon_dua.codename);
          $('#formunitkerja [name="codename"]').removeAttr('data-parsley-remote');
          $('#formunitkerja [name="name"]').val(eselon_dua.name);
          $('#formunitkerja [name="eselon_satu"]').val(eselon_dua.eselonsatu);
          $('#formunitkerja [name="_method"]').val('PUT');
          
          
      }
      
      $('#create-unitkerja').parsley().on('form:submit', function() {
          var formData = {
            'name'        : $('#create-unitkerja [name=name]').val(),
            'codename'    : $('#create-unitkerja [name=codename]').val(),
            'eselon_satu' : $('#create-unitkerja [name=eselon_satu]').val(),
            '_method'     : $('#create-unitkerja [name=_method]').val(),
            '_token'      : $('#create-unitkerja [name=_token]').val()
          };
          console.log(formData);
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

  </script>
  
@endsection