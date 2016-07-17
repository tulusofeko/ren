@extends('layouts.auth')

@section('title',  'Login')

@section('css')
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/square/red.css') }}">

  @parent
@endsection

@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html">PE<b>REN</b>CANAAN</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="{{ route('user.login') }}" method="post">
        <div class="form-group has-feedback">
          <div class="input-group">
            <input type="text" class="form-control" name="email" placeholder="Email">
            <span class="input-group-addon">@lemsaneg.go.id</span>
          </div>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-4 pull-right">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div><!-- /.col -->
        </div>
        {{ csrf_field() }}
      </form>
    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->
@endsection

@section('javascript')
  <!-- iCheck 1.0.1 -->
  <script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
      });
    });
  </script>
@endsection
