<!-- SubOutput Modal -->
<div class="modal fade" id="suboutputmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Tambah SubOutput</h4>
      </div>
      <div class="modal-body overlay-wrapper">
        <!-- Modal body -->
        <form id="create-suboutput" method="post" action="{{ route('suboutput.create') }}"
          data-edit="{{ route('suboutput.update', "/") }}/"  
        >
          <div class="form-group">
            <label>Output</label>
            <input class="form-control" type="text" name="parent-kw" required disabled />
            <input type="hidden" name="parent" >               
          </div>
          <div class="form-group">
            <label>Kode SubOutput</label>
            <input class="form-control" name="code" placeholder="Kode SubOutput" data-edit type="text" required maxlength="3">
          </div>
          <div class="form-group">
            <label>Nama SubOutput</label>
            <input class="form-control" name="name" placeholder="Name SubOutput" type="text" required />
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
        <button form="create-suboutput" type="submit" class="btn btn-primary">Simpan</button>
        <button class="btn btn-danger" data-dismiss="modal">Batal</button>
        <!-- Modal footer -->
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>

<!-- SubOutput related -->
<script>
$('#suboutputmodal').on('show.bs.modal', function (e) {
    // reset
    $('#suboutputmodal form')[0].reset();
    $('#suboutputmodal form').parsley().reset();

    var data   = $(e.relatedTarget).data(), d = new Date;
    var action = $('#suboutputmodal form').attr('action');
    var output = data.output;
    var editee;

    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote', 
        $('#tree').data('url') + "?id=" + output.mak + ".{value}&_t=" +d.getTime()
    );
    $(this).find('.modal-body input[name="parent-kw"]').val(output.code + " - " + output.name); 
    $(this).find('.modal-body input[name="parent"]').val(output.id); 

    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-validator', 'reverse'); 
    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-message', 'Kode sudah ada'); 

    if (data.method == "PUT" ) {
        $(this).find('.modal-body .modal-title').val("Edit Data"); 
        $(this).find('.modal-body input[name="code"]').data('edit', data.suboutput.code); 
        $(this).find('.modal-body input[name="code"]').val(data.suboutput.code).inputmask('9[99]');; 
        $(this).find('.modal-body input[name="name"]').val(data.suboutput.name); 
        $(this).find('.modal-body input[name="_method"]').val("PUT"); 

        action =  $('#create-suboutput').data('edit') + data.suboutput.id;
        editee = data.suboutput;
    } else {
        $(this).find('.modal-body input[name="code"]').val('').inputmask('9[99]');; 
        $(this).find('.modal-body .modal-title').val("Tambah Data");
        $(this).find('.modal-body input[name="_method"]').val("POST"); 
        editee = data.output;
    }
    $('#tree').treegrid('beginEdit', editee.mak);

    $('#suboutputmodal [name="code"]').parsley()
        .on('field:validate', function(field) {
            var lmn  = this.$element;
            var pre  = this.$element.data('edit');
            var sel  = $('#create-suboutput [name="parent"]');
            
            if (pre == this.value) {
                this.removeConstraint('remote');
            } else {
                this.addConstraint({
                    'remote' : $('#tree').data('url') + "?id=" + output.mak + ".{value}&_t=" +d.getTime() 
                });
            }
        });

    $('#suboutputmodal form').parsley().on('form:submit', function() {
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            data        : $('#suboutputmodal form').serialize(), // our data object
            url         : action, // the url where we want to POST
            encode      : true,
            beforeSend  : function () {
                $('#suboutputmodal').find('.overlay').show();
            }
        }).done(function (result) {
            
            flashMessage(result);

            $('#tree').treegrid('endEdit', editee.mak);
            $('#tree').treegrid('reload', { next: output.mak });

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