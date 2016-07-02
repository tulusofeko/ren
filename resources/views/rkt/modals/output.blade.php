<!-- Output Modal -->
<div class="modal fade" id="outputmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Tambah Output</h4>
      </div>
      <div class="modal-body overlay-wrapper">
        <!-- Modal body -->
        <form id="create-output" method="post" action="{{ route('output.create') }}" data-edit="{{ route('output.update', "/") }}/">
          <div class="form-group">
            <label>Kegiatan</label>
            <select id="kegiatan-selector" name="parent">
              @foreach ($kegiatans as $program => $kegiatans)
                  <optgroup label="{{ $program }}">
                    @foreach ($kegiatans as $kegiatan)
                      <option value="{{ $kegiatan->code }}" 
                        data-mak="051.01.{{ $kegiatan->parent }}.{{ $kegiatan->code }}"> 
                        {{ $kegiatan->code }} - {{ $kegiatan->name }}
                      </option>
                    @endforeach
                  </optgroup>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Kode Output</label>
            <input class="form-control" name="code" placeholder="Kode Output" data-edit type="text" required maxlength="3">
          </div>
          <div class="form-group">
            <label>Nama Output</label>
            <input class="form-control" name="name" placeholder="Name Output" type="text" required />
          </div>
          <div class="form-group">
            <input type="hidden" name="_method" value="POST">
          </div>
        </form>
        <div class="overlay" style="display: none;">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
      <div class="modal-footer clearfix">
        <button form="create-output" type="submit" class="btn btn-primary">Simpan</button>
        <button class="btn btn-danger" data-dismiss="modal">Batal</button>
        <!-- Modal footer -->
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>
<!-- Output related -->
<script>
$('#outputmodal').on('show.bs.modal', function (e) {
    // reset
    $('#outputmodal form')[0].reset();
    $('#outputmodal form').parsley().reset();

    var data     = $(e.relatedTarget).data(), d = new Date;
    var action   = $('#outputmodal form').attr('action');
    var kegiatan = data.kegiatan;
    var editee;

    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote', 
        $('#tree').data('url') + "?id=" + kegiatan.mak + ".{value}&_t=" +d.getTime()
    );

    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-validator', 'reverse'); 
    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-message', 'Kode sudah ada'); 

    $('#kegiatan-selector').val(kegiatan.code).trigger('change');

    if (data.method == "PUT" ) {
        $(this).find('.modal-body .modal-title').val("Edit Data"); 
        $(this).find('.modal-body input[name="code"]').data('edit', data.output.code); 
        $(this).find('.modal-body input[name="code"]').val(data.output.code).inputmask('9[99]');
        $(this).find('.modal-body input[name="name"]').val(data.output.name); 
        $(this).find('.modal-body input[name="_method"]').val("PUT"); 

        action =  $('#create-output').data('edit') + data.output.id;
        editee = data.output;
    } else {
        $(this).find('.modal-body input[name="code"]').val('').inputmask('9[99]');; 
        $(this).find('.modal-body .modal-title').val("Tambah Data"); 
        $(this).find('.modal-body input[name="_method"]').val("POST"); 
        editee = data.kegiatan;
    }

    $('#tree').treegrid('beginEdit', editee.mak);

    $('#outputmodal [name="code"]').parsley()
        .on('field:validate', function(field) {
            var lmn  = this.$element;
            var pre  = this.$element.data('edit');
            var sel  = $('#kegiatan-selector');
            var mak  = sel.find('[value="'+ sel.val() +'"]').data('mak');
            
            if (pre == this.value && sel.val() == kegiatan.code) {
                this.removeConstraint('remote');
            } else {
                this.addConstraint({
                    'remote' : $('#tree').data('url') + "?id=" + mak + ".{value}&_t=" +d.getTime() 
                });
            }
        });

    $('#outputmodal form').parsley().on('form:submit', function() {
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            data        : $('#outputmodal form').serialize(), // our data object
            url         : action, // the url where we want to POST
            encode      : true,
            beforeSend  : function () {
                $('#outputmodal').find('.overlay').show();
            }
        }).done(function (result) {
            
            flashMessage(result);

            $('#tree').treegrid('endEdit', editee.mak);
            $('#tree').treegrid('reload', { next: kegiatan.mak });

        }).fail(function(result) {
            var message;

            if ( typeof result.responseJSON != 'undefined' 
              && typeof result.responseJSON.message != 'undefined'
            ) {
                message = result.responseJSON.message;
            } else {
                message = "Internal server error. See develpoer tools for error detail";
            }

            flashMessage({message : message, data : result}, true);
        });

        return false;
    });
});
</script>