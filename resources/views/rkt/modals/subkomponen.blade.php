<!-- Komponen Modal -->
<div class="modal fade" id="subkomponenmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Tambah Sub Komponen</h4>
      </div>
      <div class="modal-body overlay-wrapper">
        <!-- Modal body -->
        <form id="create-subkomponen" method="post" action="{{ route('subkomponen.create') }}"
          data-edit="{{ route('subkomponen.update', "/") }}/" enctype="multipart/form-data"  
        >
          <div class="form-group">
            <label>Komponen</label>
            <input class="form-control" type="text" name="parent-kw" required disabled />
            <input type="hidden" name="parent" >               
          </div>
          <div class="row">
            <div class="form-group col-md-4">
              <label>Kode </label>
              <input class="form-control" name="code" placeholder="Kode SubKomponen" data-edit type="text" required maxlength="3">
            </div>
            <div class="form-group col-md-8">
              <label>Nama SubKomponen</label>
              <input class="form-control" name="name" placeholder="Name SubKomponen" type="text" required />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-4">
              <label>Anggaran</label>
              <div class="input-group">
                <span class="input-group-addon">Rp.</span>
                <input class="form-control" name="anggaran" placeholder="Anggaran" type="text" required />
              </div>
            </div>
            <div class="form-group col-md-8">
              <label>Unit Kerja</label>
              <select name="unit_kerja" required data-parsley-required-message="Pilih Unit Kerja" id="es3" style="width: 100%;height: 34px;">
                
              </select>
              <select style="display: none;" id="es3data">
                @foreach ($eselon_tiga as $unit)
                    <option value="{{ $unit->codename }}" data-parent={{ $unit->parent }}> 
                      {{ $unit->name }}
                    </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" name="keterangan" placeholder="Keterangan tambahan"></textarea>
          </div>
          <div class="form-group">
            <label for="datduk">Data Dukung</label>
            <div id="datduks"></div>
            <input id="datduk" type="file" name="datduks[]" multiple data-parsley-max-file-size="20000">
          </div>
          <div class="form-group">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="POST">
          </div>
        </form>

        <div class="overlay" style="display: none;">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
      <div class="progress active" style="display: none;">
        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
          <span class="sr-only">20% Complete</span>
        </div>
      </div>
      <div class="modal-footer clearfix">
        <button form="create-subkomponen" type="submit" class="btn btn-primary">Simpan</button>
        <button class="btn btn-danger" data-dismiss="modal">Batal</button>
        <!-- Modal footer -->
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>
<script src="{{ asset('plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<!-- SubOutput related -->
<script>
window.Parsley.addValidator('maxFileSize', {
    validateString: function(_value, maxSize, parsleyInstance) {
        if (!window.FormData) {
            alert('You are making all developpers in the world cringe. Upgrade your browser!');
            return true;
        }
        var files = parsleyInstance.$element[0].files, size = 0;

        for (var i = 0; i < files.length; i++) {
            size += files[i].size;
        }

        return size <= maxSize * 1024;
    },
    requirementType: 'integer',
    messages: {
        en: 'This file should not be larger than %s Kb',
        fr: "Ce fichier est plus grand que %s Kb.",
        id: 'File tidak boleh lebih dari %s Kb'
    }
});

Inputmask.extendAliases({
    'rupiah': {
        prefix: "",
        groupSeparator: ",",
        alias: "numeric",
        placeholder: "0",
        autoGroup: !0,
        digits: 0,
        digitsOptional: !1,
        clearMaskOnLostFocus: !1
    }
});

var progressHandlerFunction = function (e)
{
    var percent = parseInt(e.loaded) / parseInt(e.total) *100;
    
    $('#subkomponenmodal .progress-bar').width(percent + "%");

    console.log(parseInt(e.loaded) / parseInt(e.total) * 100);
}

$('#subkomponenmodal').on('show.bs.modal', function (e) {
    // reset
    $('#subkomponenmodal form')[0].reset();
    $('#subkomponenmodal form').parsley().reset();

    var data   = $(e.relatedTarget).data(), d = new Date;
    var action = $('#subkomponenmodal form').attr('action');
    var parent = data.parent;
    var modal  = $(this);
    var editee;

    modal.find('.progress').hide();

    modal.find('.modal-body [name="code"]').attr('data-parsley-remote', 
        $('#tree').data('url') + "?id=" + parent.mak + ".{value}&_t=" +d.getTime()
    );

    modal.find('#es3').html('');
    modal.find('#es3data [data-parent="' + parent.eselon_dua + '"]').clone().appendTo('#es3');
    modal.find('#es3').append('<option selected value="">Pilih Unit Kerja</option>');

    modal.find('.modal-body [name="code"]').attr('data-parsley-remote-validator', 'reverse'); 
    modal.find('.modal-body [name="code"]').attr('data-parsley-remote-message', 'Kode sudah ada'); 
    modal.find('.modal-body [name="parent-kw"]').val(parent.code + " - " + parent.name); 
    modal.find('.modal-body [name="parent"]').val(parent.id); 

    if (data.method == "PUT" ) {
        modal.find('.modal-body .modal-title').val("Edit Data"); 
        modal.find('.modal-body [name="code"]').data('edit', data.node.code); 
        modal.find('.modal-body [name="code"]').val(data.node.code).inputmask('A[AA]'); 
        modal.find('.modal-body [name="name"]').val(data.node.name); 
        modal.find('.modal-body [name="unit_kerja"]').val(data.node.unit_kerja); 
        modal.find('.modal-body [name="anggaran"]').val(data.node.anggaran).inputmask("rupiah");  //static mask
        modal.find('.modal-body [name="_method"]').val("PUT"); 

        action =  $('#create-subkomponen').data('edit') + data.node.id;
        editee = data.node;

        $.ajax({
            type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            url         : '{{ route('datduk.get', '/') }}/' + data.node.mak, // the url where we want to POST
            beforeSend  : function () {
                modal.find('.overlay').show();

                $('#datduks').html('');
            },
            xhr: function() {
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progressHandlerFunction, false);
                }
                return myXhr;
            },
        }).done(function (result) {
            var wrapper = $('#datduks');
            for (var i = 0; i < result.length; i++) {
                var btn  = "<div class='btn-group'>";
                    btn += "<a class='btn btn-sm btn-flat btn-default' target='_blank'";
                    btn += " href='{{ route('datduk.show', '') }}/" + result[i].id +"'>";
                    btn += result[i].filename;
                    btn += "</a><a class='btn btn-sm btn-flat btn-default' ";
                    btn += "data-datduk-id='"+ result[i].id + "' ";
                    btn += "data-toggle='modal' data-target='#datdukhapusmodal' aria-hidden='true'>"
                    btn += "<i class='fa fa-fw fa-trash'></i></a></div>";
                $(btn).appendTo(wrapper);
            }
            modal.find('.overlay').hide();
        });

    } else {
        modal.find('.modal-body [name="code"]').val('').inputmask('A[AA]'); 
        modal.find('.modal-body [name="anggaran"]').val('').inputmask("rupiah");  //static mask
        modal.find('.modal-body .modal-title').val("Tambah Data");
        modal.find('.modal-body [name="_method"]').val("POST"); 
        editee = data.parent;
    }
    
    $('#tree').treegrid('beginEdit', editee.mak);

    $('#subkomponenmodal [name="code"]').parsley()
        .on('field:validate', function(field) {
            var lmn  = this.$element;
            var pre  = this.$element.data('edit');
            var sel  = $('#create-subkomponen [name="parent"]');
            
            if (pre == this.value) {
                this.removeConstraint('remote');
            } else {
                this.addConstraint({
                    'remote' : $('#tree').data('url') + "?id=" + parent.mak + ".{value}&_t=" +d.getTime() 
                });
            }
        });

    $('#subkomponenmodal form').parsley().on('form:submit', function() {
        var formData = new FormData($('#create-subkomponen')[0]);
        
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            dataType    : 'JSON', // what type of data do we expect back from the server
            data        : formData, // our data object
            url         : action, // the url where we want to POST
            encode      : true,
            processData : false,
            contentType : false,
            beforeSend  : function () {
                modal.find('.overlay').show();
                modal.find('.progress').show();
            },
            xhr: function() {
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progressHandlerFunction, false);
                }
                return myXhr;
            },
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

$('#datduk').fileinput({
    showUpload: false,
    showPreview: false,
    maxFileSize: 20000,
    browseIcon: "<i class='fa fa-folder-open-o'></i>"
});
</script>