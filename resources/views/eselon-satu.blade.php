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
  <form id="create-unitkerja" 
    action="{{ route('api.eselon_satu.create') }}" 
    data-edit="{{ route('api.eselon_satu.update', "/") }}/" 
    method="post"
  >
    <div class="form-group">
      <label>Nama Unit Kerja Eselon I</label>
      <input class="form-control" name="name" placeholder="Nama Unit Kerja Eselon I" type="text" required />
    </div>
    <div class="form-group">
      <label>Alias</label>
      <input class="form-control" name="codename" placeholder="Kode" 
        type="text" required maxlength="2" 
        data-remote="{{ route('view.eselon_satu') }}/{value}" 
        data-parsley-remote-validator="reverse" 
        data-parsley-remote-message="Alias sudah ada"
      />
    </div>
    <div class="form-group">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="_token"  value="{{ csrf_token() }}">
    </div>
  </form>
@endsection

@section('ukjs')
  
  <!-- Datatable related -->
  <script>
    $('#hapusunitkerja form').attr('action', '{{ route("api.eselon_satu.delete", "") }}');

    var table = $('#unitkerja').DataTable({
        "jQueryUI"   : true,
        "paging"     : true,
        "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
        "autoWidth"  : false,
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
          
          action =  $('#create-unitkerja').data('edit') + eselon_satu.id;

          $('#formunitkerja [name="codename"]').val(eselon_satu.codename);
          $('#formunitkerja [name="codename"]').data('edit', eselon_satu.codename);
          $('#formunitkerja [name="name"]').val(eselon_satu.name);
          $('#formunitkerja [name="_method"]').val('PUT');
          
      } else {
          $('#formunitkerja [name="codename"]').removeData('edit');
      }
      
      $('#formunitkerja [name="codename"]').parsley()
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

      $('#create-unitkerja').parsley().on('form:submit', function() {
          var formData = {
            'name'     : $('#create-unitkerja [name=name]').val(),
            'codename' : $('#create-unitkerja [name=codename]').val(),
            '_method'  : $('#create-unitkerja [name=_method]').val(),
            '_token'   : $('#create-unitkerja [name=_token]').val()
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

              $('#formunitkerja').modal('hide');
              
              table.ajax.reload(null, false);

              flashMessage(result);

          }).fail(function(result) {
              $('#formunitkerja').modal('hide');
              
              flashMessage(result);

          });

          return false;
      });

  });

  </script>
  
@endsection