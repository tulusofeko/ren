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
        <section class="content-header">
          <h1> Dashboard <small>Control panel</small> </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content"> @yield('content') </section>

      </div><!-- /.content-wrapper -->

      @include('includes.ctrl-sidebar')
      @include('includes.footer')
    
    </div><!-- ./wrapper -->

    @include('includes.javascript')

  </body>
</html>
