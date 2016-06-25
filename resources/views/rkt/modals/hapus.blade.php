<!-- Hapus Modal -->
<div class="modal fade" id="hapusmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="ion-android-delete"></i> Hapus Data </h4>
      </div>
      <form method="post">
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

<!-- Hapus node -->
<script>
$('#hapusmodal').on('show.bs.modal', function (e) {
    // reset
    $('#hapusmodal form')[0].reset();
    $('#hapusmodal form').parsley().reset(); 

    var modal  = $(this);
    var row    = $(e.relatedTarget).data('row');
    var base   = $('base').attr('href');
    var action = base + "/" + row.level + "/hapus/";

    modal.find('.modal-body input[name="id"]').val(row.id);  

    $('#hapusmodal form').parsley().on('form:submit', function() {
        var formData = {'_method'  : 'DELETE'},  id = row.id;

        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            url         : action + id, // the url where we want to POST
            data        : formData, // our data object
            encode      : true,
            beforeSend  : function () {
                $('#hapusmodal').find('.overlay').show();
            }
        }).done(function (result) {
            
            flashMessage(result);    
            
            $('#tree').treegrid('reload', { next: row.mak });
                         
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

// Reset everything on hide
$('.modal').on('hide.bs.modal', function (e) {
    $('#box-action button').hide();
    $('#tree').treegrid('unselectAll');
    $(this).find('.overlay').hide();
});
</script>