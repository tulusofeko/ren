@extends('unit-kerja')

@section('title', 'Data Unit Kerja Eselon III')

@section('unitkerja', 'Eselon III')

@section('tabel-unitkerja')
  <table id="unitkerja" class="table table-bordered table-hover table-striped" 
    data-url="{{ route('eselon_tiga.datatables') }}"
  >
    <thead>
      <tr>
        <th style="width: 18px;padding-right: 8px" class="text-center">No.</th>
        <th>Unit Kerja</th>
        <th>Kode</th>
        <th style="width: 80;">Eselon II</th>
        <th style="width: 80;">Eselon I</th>
        <th>Pegawai</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody> </tbody>
  </table>
@endsection


@section('form-unitkerja')
  <form id="create-unitkerja" method="post" action="{{ route('eselon_tiga.create') }}"
    data-edit="{{ route('eselon_tiga.update', "/") }}/"  
  >
    <div class="form-group">
      <label>Nama Unit Kerja Eselon III</label>
      <input class="form-control" name="name" placeholder="Nama Unit Kerja Eselon III" type="text" required/>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label>Kode</label>
        <input class="form-control" name="codename" placeholder="Kode" type="text" required maxlength="4"
          data-remote="{{ route('eselon_tiga.show') }}/{value}" 
          data-parsley-remote-reverse="true" 
          data-parsley-remote-message="Kode sudah ada" 
        />
      </div>
      <div class="form-group col-md-6">
        <label>Pegawai Aktif</label>
        <input name="pegawai" class="form-control" required placeholder="Pegawai Aktif"
          data-parsley-type="integer"
        >
      </div>
    </div>
    <div class="form-group">
      <label>Eselon II</label>
      <select name="parent" style="width: 100%;height: 24px;" required
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
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>
  </form>
@endsection

@section('custom-javascript')
  <script>
    $('#create-unitkerja [name=parent]').select2({placeholder: "Pilih Unit Eselon Dua"});

    $('#hapusunitkerja form').attr('action', '{{ route("eselon_tiga.delete", "") }}');

    var table = $('#unitkerja').DataTable({
        "jQueryUI"   : true,
        "paging"     : true,
        "lengthMenu" : [ 5, 10, 25, 50, 75, 100, "All" ],
        "autoWidth"  : false,
        "stateSave"  : false,
        "order"      : [[ 4, 'asc' ], [ 3, 'asc' ], [ 2, 'asc' ]],
        "serverSide" : true,
        "ajax": {
            "url": $('#unitkerja').data('url'),
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
                className: 'text-center',
                data: 'codename',
                name: 'codename'
            },
            {
                className: 'text-center',
                data: 'parent',
                name: 'parent'
            },
            {
                className: 'text-center',
                data: 'eselonsatu',
                name: 'eselonsatu'
            },
            {
                className: 'text-center',
                data: 'pegawai',
                name: 'pegawai'
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
                btn_edit += "data-target='#formunitkerja' data-method='put'>";
                btn_edit += "<i class='fa fa-edit'></i></buton> ";
            
                btn_del   = "<buton class='btn btn-danger' data-toggle='modal'";
                btn_del  += "data-target='#hapusunitkerja'>";
                btn_del  += "<i class='fa fa-trash'></i></buton>";
            
            $('td', row).eq(-1).html( btn_edit + btn_del );
        }
    });
  </script> 
@endsection

@section('additionalform')
  $('#formunitkerja [name="pegawai"]').val(unit.pegawai);
@endsection