@extends('unit-kerja')

@section('css')
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
  @parent
@endsection

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
  <form id="create-unitkerja" method="post" action="{{ route('api.eselon_dua.create') }}"
    data-edit="{{ route('api.eselon_dua.update', "/") }}/"  
  >
    <div class="form-group">
      <label>Nama Unit Kerja Eselon II</label>
      <input class="form-control" name="name" placeholder="Nama Unit Kerja Eselon II" type="text" required/>
    </div>
    <div class="form-group">
      <label>Alias</label>
      <input class="form-control" name="codename" placeholder="Kode" type="text" 
        required maxlength="3"
        data-remote="{{ route('view.eselon_dua') }}/{value}" 
        data-parsley-remote-reverse="true" 
        data-parsley-remote-message="Alias sudah ada" 
      />
    </div>
    <div class="form-group">
      <label>Eselon I</label>
      <select name="parent" style="width: 100%;height: 24px;" required
        data-parsley-required-message="Pilih Eselon I"
      >
        <option></option>
        @foreach ($eselon_satu as $unit)
            <option value="{{ $unit->codename }}"> 
              {{ $unit->codename }} - {{ $unit->name }}
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

@section('custom-js')
  <script src="{{ url('vendor/select2/js/select2.min.js') }}"></script>
  @parent
@endsection

@section('ukjs')
  <script>
    $('[name=parent]').select2({ 
        placeholder: "Pilih Unit Eselon Satu",
        minimumResultsForSearch: Infinity
    });

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
                data: 'parent',
                name: 'parent'
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

@endsection