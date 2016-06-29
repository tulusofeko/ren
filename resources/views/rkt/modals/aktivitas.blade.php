<!-- Komponen Modal -->
<div class="modal fade" id="aktivitasmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Tambah Aktivitas</h4>
      </div>
      <div class="modal-body overlay-wrapper">
        <!-- Modal body -->
        <form id="create-aktivitas" method="post" action="{{ route('aktivitas.create') }}"
          data-edit="{{ route('aktivitas.update', "/") }}/"  
        >
          <div class="form-group">
            <label>Sub Komponen</label>
            <input class="form-control" type="text" name="parent-kw" required disabled />
            <input type="hidden" name="parent" >               
          </div>
          <div class="form-group">
            <label>Nama Aktivitas</label>
            <input class="form-control" name="name" placeholder="Nama Aktivitas" type="text" required />
          </div>
          <div class="row">
            <div class="form-group col-md-4">
              <label>Personil Pelaksana</label>
              <input class="form-control xren" name="personil" placeholder="Personil" type="text" required />
            </div>
            <div class="form-group col-md-4">
              <label>Durasi (Hari)</label>
              <input class="form-control xren" name="durasi" placeholder="Durasi (Hari)" type="text" required />
            </div>
            <div class="form-group col-md-4">
              <label>Jumlah Waktu (Menit)</label>
              <input class="form-control" name="durasi_sum" disabled type="text" required />
            </div>
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
        <button form="create-aktivitas" type="submit" class="btn btn-primary">Simpan</button>
        <button class="btn btn-danger" data-dismiss="modal">Batal</button>
        <!-- Modal footer -->
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>

<!-- SubOutput related -->
<script>

$('#aktivitasmodal form .xren').change(function () {
    var personil = $('#aktivitasmodal [name="personil"]').val();
    var durasi   = $('#aktivitasmodal [name="durasi"]').val();
    var hasil    = parseInt(personil)*parseInt(durasi)*344;

    if (isNaN(hasil)) {
        hasil = 0;
    }

    $('#aktivitasmodal [name="durasi_sum"]').val(hasil);
});

$('#aktivitasmodal').on('show.bs.modal', function (e) {
    // reset
    $('#aktivitasmodal form')[0].reset();
    $('#aktivitasmodal form').parsley().reset();

    var data   = $(e.relatedTarget).data(), d = new Date;
    var action = $('#aktivitasmodal form').attr('action');
    var parent = data.parent;
    var editee;

    $(this).find('.modal-body input[name="parent-kw"]').val(parent.code + " - " + parent.name); 
    $(this).find('.modal-body input[name="parent"]').val(parent.id); 

    if (data.method == "PUT" ) {
        var hasil = parseInt(data.node.personil) * parseInt(data.node.durasi) * 344;

        $(this).find('.modal-body .modal-title').val("Edit Data"); 
        $(this).find('.modal-body [name="personil"]').val(data.node.personil).inputmask('numeric');
        $(this).find('.modal-body [name="durasi"]').val(data.node.durasi).inputmask('numeric');
        $(this).find('.modal-body [name="durasi_sum"]').val(hasil);
        $(this).find('.modal-body [name="name"]').val(data.node.name); 
        $(this).find('.modal-body [name="_method"]').val("PUT"); 

        action =  $('#create-aktivitas').data('edit') + data.node.id;
        editee = data.node;
    } else {
        $(this).find('.modal-body [name="personil"]').val('').inputmask('numeric');
        $(this).find('.modal-body [name="durasi"]').val('').inputmask('numeric');
        $(this).find('.modal-body .modal-title').val("Tambah Data");
        $(this).find('.modal-body input[name="_method"]').val("POST"); 
        editee = data.parent;
    }
    $('#tree').treegrid('beginEdit', editee.mak);

    $('#aktivitasmodal form').parsley().on('form:submit', function() {
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            data        : $('#aktivitasmodal form').serialize(), // our data object
            url         : action, // the url where we want to POST
            encode      : true,
            beforeSend  : function () {
                $('#aktivitasmodal').find('.overlay').show();
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