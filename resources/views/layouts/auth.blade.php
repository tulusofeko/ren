<!DOCTYPE html>
<html>
  <head> @include('includes.head') </head>
  <body class="hold-transition skin-blue login-page">
      @yield('content')

      @section('core-javascript')
          @include('includes.javascript')
      
          @yield('javascript')
      @show
    </div><!-- ./wrapper -->
  </body>
</html>
