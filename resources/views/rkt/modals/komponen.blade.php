<!-- Komponen Modal -->
<div class="modal fade" id="komponenmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Tambah Komponen</h4>
      </div>
      <div class="modal-body overlay-wrapper">
        <!-- Modal body -->
        <form id="create-komponen" method="post" action="{{ route('komponen.create') }}"
          data-edit="{{ route('komponen.update', "/") }}/"  
        >
          <div class="form-group">
            <label>SubOutput</label>
            <input class="form-control" type="text" name="parent-kw" required disabled />
            <input type="hidden" name="parent" >               
          </div>
          <div class="form-group">
            <label>Kode Komponen</label>
            <input class="form-control" name="code" placeholder="Kode Komponen" data-edit type="text" required maxlength="3">
          </div>
          <div class="form-group">
            <label>Nama Komponen</label>
            <input class="form-control" name="name" placeholder="Name Komponen" type="text" required />
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
        <button form="create-komponen" type="submit" class="btn btn-primary">Simpan</button>
        <button class="btn btn-danger" data-dismiss="modal">Batal</button>
        <!-- Modal footer -->
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>

<!-- SubOutput related -->
<script>
$('#komponenmodal').on('show.bs.modal', function (e) {
    // reset
    $('#komponenmodal form')[0].reset();
    $('#komponenmodal form').parsley().reset();

    var data   = $(e.relatedTarget).data(), d = new Date;
    var action = $('#komponenmodal form').attr('action');
    var parent = data.parent;
    var editee;

    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote', 
        $('#tree').data('url') + "?id=" + parent.mak + ".{value}&_t=" +d.getTime()
    );
    $(this).find('.modal-body input[name="parent-kw"]').val(parent.code + " - " + parent.name); 
    $(this).find('.modal-body input[name="parent"]').val(parent.id); 

    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-validator', 'reverse'); 
    $(this).find('.modal-body input[name="code"]').attr('data-parsley-remote-message', 'Kode sudah ada'); 

    if (data.method == "PUT" ) {
        $(this).find('.modal-body .modal-title').val("Edit Data"); 
        $(this).find('.modal-body [name="code"]').data('edit', data.node.code); 
        $(this).find('.modal-body [name="code"]').val(data.node.code).inputmask('9[99]');
        $(this).find('.modal-body [name="name"]').val(data.node.name); 
        $(this).find('.modal-body [name="_method"]').val("PUT"); 

        action =  $('#create-komponen').data('edit') + data.node.id;
        editee = data.node;
    } else {
        $(this).find('.modal-body [name="code"]').val('').inputmask('9[99]');
        $(this).find('.modal-body .modal-title').val("Tambah Data");
        $(this).find('.modal-body input[name="_method"]').val("POST"); 
        editee = data.parent;
    }
    $('#tree').treegrid('beginEdit', editee.mak);

    $('#komponenmodal [name="code"]').parsley()
        .on('field:validate', function(field) {
            var lmn  = this.$element;
            var pre  = this.$element.data('edit');
            var sel  = $('#create-komponen [name="parent"]');
            
            if (pre == this.value) {
                this.removeConstraint('remote');
            } else {
                this.addConstraint({
                    'remote' : $('#tree').data('url') + "?id=" + parent.mak + ".{value}&_t=" +d.getTime() 
                });
            }
        });

    $('#komponenmodal form').parsley().on('form:submit', function() {
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            data        : $('#komponenmodal form').serialize(), // our data object
            url         : action, // the url where we want to POST
            encode      : true,
            beforeSend  : function () {
                $('#komponenmodal').find('.overlay').show();
            }
        }).done(function (result) {
            
            flashMessage(result);

            $('#tree').treegrid('endEdit', editee.mak);
            $('#tree').treegrid('reload', { next: parent.mak });

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