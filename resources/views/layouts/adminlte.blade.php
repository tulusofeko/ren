<!DOCTYPE html>
<html>
  <head> @include('includes.head') </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header"> @include('includes.header') </header>
      
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar"> @include('includes.sidebar') </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header"> @yield('content-header') </section>

        <!-- Main content -->
        <section class="content"> @yield('content') </section>

      </div><!-- /.content-wrapper -->

      @include('includes.footer')
    
      @section('core-javascript')
          @include('includes.javascript')
      
          @yield('javascript')
      @show
    </div><!-- ./wrapper -->
  </body>
</html>
