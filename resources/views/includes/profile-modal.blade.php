<div class="modal fade" id="userprofile">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body overlay-wrapper">
        <!-- Modal body -->
        <form id="edit-user" method="post" action="{{ route('user.updateprofile') }}">
          <div class="form-group">
            <label>Nama Pengguna</label>
            <input class="form-control" name="name" placeholder="Name Pengguna" type="text" required
            value="{{ auth()->user()->name }}" 
            />
          </div>
          <div class="form-group">
            <label>Email Pengguna</label>
            <div class="input-group">
              <input class="form-control" name="email" placeholder="Email Pengguna" type="text" required 
              maxlength="255" 
              data-remote="{{ route('user.get', '') }}/{value}" 
              data-parsley-remote-validator="reverse" 
              data-parsley-remote-message="email sudah ada"
              data-edit="{{ str_replace('@lemsaneg.go.id', '', auth()->user()->email) }}" 
              value="{{ str_replace('@lemsaneg.go.id', '', auth()->user()->email) }}" 
              />
              <span class="input-group-addon">@lemsaneg.go.id</span>
            </div>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input class="form-control" name="old_password" placeholder="Password lama" type="password" />
          </div>
          <div class="form-group">
            <label>Password Baru</label>
            <input class="form-control" name="new_password" placeholder="Password lama" type="password" />
          </div>
          <div class="form-group">
            <label>Password Baru Confirm</label>
            <input class="form-control" name="new_password_confirmation" placeholder="Password Confirm" type="password" data-parsley-equalto='[name="new_password"]' data-parsley-equalto-message='password tidak sama'/>
          </div>
          <div class="form-group">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </div>
        </form>

        <div class="overlay" style="display: none;">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
      <div class="modal-footer clearfix">
        <button form="edit-user" type="submit" class="btn btn-primary">Simpan</button>
        <button class="btn btn-danger" data-dismiss="modal">Batal</button>
        <!-- Modal footer -->
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>
<script>
  $(document).ready(function () {
      $('#edit-user').parsley({
          errorsWrapper : '<ul class="parsley-errors-list list-unstyled"></ul>',
          errorTemplate : '<li class="small text-danger"></li>',
          errorClass    : 'has-error',
          classHandler  : function (ParsleyField) {
              var element = ParsleyField.$element;
              return element.parents('.form-group');
          },
          errorsContainer: function (ParsleyField) {
              var element = ParsleyField.$element;
              return element.parents('.form-group');
          },
      });
  });
</script>
<script>
  $('#userprofile').on('show.bs.modal', function (e) {
      $('#edit-user').parsley().reset(); 
      $('#edit-user')[0].reset();

      var d      = new Date();
          action = $('#edit-user').attr('action'),
          modal  = $(this), base = $('base').attr('href');
      var remote = $(this).find('.modal-body input[name="email"]').data('remote');

      modal.find('.modal-body input[name="email"]').attr('data-parsley-remote', remote + "?" + d.getTime());

      $('#userprofile [name="email"]').parsley()
          .on('field:validate', function(field) {
              var lmn = this.$element;
              
              if (lmn.data('edit') == this.value) {
                  this.removeConstraint('remote');
              } else {
                  this.addConstraint({'remote' : lmn.data('parsleyRemote')});
              }
          });
     
      $('#edit-user').parsley().on('form:submit', function() {
          $.ajax({
              type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
              dataType    : 'JSON', // what type of data do we expect back from the server
              data        : modal.find('form').serialize(), // our data object
              url         : action, // the url where we want to POST
              encode      : true,
              beforeSend  : function () {
                  modal.find('.overlay').show();
              }
          }).done(function (result) {
              console.log(result);
              var name = modal.find('.modal-body input[name="name"]').val();

              $('.user-panel .info p').html(name);

              $('#callout-message .callout').addClass('callout-success');
              $('#callout-message .callout .callout-messages').html(result.message);

              $('.modal').modal('hide');

              $('#callout-message').slideDown(function() {
                  setTimeout(function() {
                      $('#callout-message').slideUp("slow", function() {
                          $('#callout-message .callout').removeClass('callout-success');
                          $('#callout-message .callout').removeClass('callout-danger');
                          $('#callout-message .callout .callout-messages').html('');
                      });
                  }, 4000);
              }); 
              modal.find('.overlay').hide();
          }).fail(function(result) {
              console.log(result);

              var errormessages = null;
              
              if (result.status == 422) {
                  var errormessages = result.responseJSON;
              }
              
                var message = "Internal server error. See develpoer tools for error detail",
                    data = errormessages;

              $('#callout-message .callout').addClass('callout-danger');
              $('#callout-message .callout .callout-messages').html(message);

              $('.modal').modal('hide');

              $('#callout-message').slideDown(function() {
                  setTimeout(function() {
                      $('#callout-message').slideUp("slow", function() {
                          $('#callout-message .callout').removeClass('callout-success');
                          $('#callout-message .callout').removeClass('callout-danger');
                          $('#callout-message .callout .callout-messages').html('');
                      });
                  }, 4000);
              }); 
              modal.find('.overlay').hide();
          });

          return false;
      });

  });
</script>