@extends('layouts.adminlte')

@section('title', 'Kelola Data Program')

@section('css')
  @parent

  <style type="text/css">
    .error-page .headline {
        float: none;
        text-align:center;
    }
    .error-page .error-content {
        margin-left:0;
        text-align:center;
    }
  </style>
@endsection

@section('content-header')
  <h1> ERROR! </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $error['path'] }}</a></li>
  </ol>
@endsection 

@section('content')
  <div class="error-page">
    <h2 class="headline text-red"><i class="fa fa-warning text-red"></i> {{ $error['number'] or "500" }}</h2>
    <div class="error-content">
      <h3> {{ $error['message'] or 'Oops! Something went wrong.'}}</h3>
    </div>
  </div><!-- /.error-page -->
@endsection
