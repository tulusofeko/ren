@extends('unit-kerja')

@section('title', 'Data Unit Kerja Eselon I')

@section('unitkerja', 'Eselon I')

@section('tabel-unitkerja')
  <table id="unitkerja" class="table table-bordered table-hover table-striped" 
    data-url="{{ route('eselon_satu.datatables') }}"
  >
    <thead>
      <tr>
        <th style="width: 18px;padding-right: 8px" class="text-center">No.</th>
        <th>Unit Kerja</th>
        <th>Kode</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody> </tbody>
  </table>
@endsection

@section('form-unitkerja')
  <form id="create-unitkerja" action="{{ route('eselon_satu.create') }}"
    data-edit="{{ route('eselon_satu.update', "/") }}/" method="post"
  >
    <div class="form-group">
      <label>Nama Unit Kerja Eselon I</label>
      <input class="form-control" name="name" placeholder="Nama Unit Kerja Eselon I" type="text" required />
    </div>
    <div class="form-group">
      <label>Kode</label>
      <input class="form-control" name="codename" placeholder="Kode" type="text" required maxlength="2"
        data-remote="{{ route('eselon_satu.show') }}/{value}" 
        data-parsley-remote-validator="reverse" 
        data-parsley-remote-message="Kode sudah ada"
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
    $('#hapusunitkerja form').attr('action', '{{ route("eselon_satu.delete", "") }}');

    var table = $('#unitkerja').DataTable({
        "jQueryUI"   : true,
        "paging"     : true,
        "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
        "autoWidth"  : false,
        "order"      : [[ 2, 'asc' ]],
        "serverSide" : true,
        "ajax": {
            "url"  : $('#unitkerja').data('url'),
            "type" : "POST"
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
                className : 'text-center',
                data      : 'codename',
                name      : 'codename'
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
                btn_edit += "data-target='#formunitkerja' data-method='put'>"
                btn_edit += "<i class='fa fa-edit'></i></buton> ";
             
                btn_del   = "<buton class='btn btn-danger' data-toggle='modal'";
                btn_del  += "data-target='#hapusunitkerja'>"
                btn_del  += "<i class='fa fa-trash'></i></buton>";
            
            $('td', row).eq(-1).html( btn_edit + btn_del );
        }
    });
  </script>
 
@endsection