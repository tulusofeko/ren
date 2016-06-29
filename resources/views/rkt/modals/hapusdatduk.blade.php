<!-- Hapus Modal -->
<div class="modal fade" id="datdukhapusmodal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="ion-android-delete"></i> Hapus Data </h4>
      </div>
      <form method="post" action="{{ route('datduk.delete', '/') }}/">
        <div class="modal-body overlay-wrapper">
        <!-- Modal body -->
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
$('#datdukhapusmodal').on('show.bs.modal', function (e) {
    // reset
    $('#datdukhapusmodal form')[0].reset();
    $('#datdukhapusmodal form').parsley().reset(); 

    var modal  = $(this);
    var data   = $(e.relatedTarget).data();
    var button = $(e.relatedTarget);
    var action = $('#datdukhapusmodal form').attr('action');

    modal.find('.modal-body input[name="id"]').val(data.datdukId);  

    $('#datdukhapusmodal form').parsley().on('form:submit', function() {
        var formData = {'_method'  : 'DELETE'},  id = data.datdukId;

        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            url         : action + id, // the url where we want to POST
            data        : formData, // our data object
            encode      : true,
            beforeSend  : function () {
                $('#datdukhapusmodal').modal('hide');
                $('#subkomponenmodal').find('.overlay').show();
            }
        }).done(function (result) {
            button.parent().remove();
            $('#subkomponenmodal').find('.overlay').hide();
        });

        return false;
    });  
});

</script>