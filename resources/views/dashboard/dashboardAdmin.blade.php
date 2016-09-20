@extends('layouts.header')
<head>
    <title>Rumah Warga | Dashboard</title>
    <link rel="stylesheet" href="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}" type="text/css" media="screen"/>
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <!--<script src="{asset('style/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>-->
    <!--<script src="{asset('style/plugins/jvectormap/peta.js')}}"></script>-->
</head>

@section('isi')


    <section class="content-header">
        <h1>
            Dashboard
            <small>
                <ol class="breadcrumb">
                    <li class="active">Dashboard</li>
                </ol>
            </small>
        </h1>
    </section>


    <!-- Main content -->
    <section class="content">

        @if(Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <em> {!! session('flash_message') !!}</em>
            </div>
        @endif
        @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <em> {!! session('error_message') !!}</em>
            </div>
        @endif

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue flat">
                    <div class="inner">
                        <h3>{{count($petaAdmin)}}</h3>
                        <p>Peta</p>
                    </div>
                    <div class="icon" >
                        <i class="fa fa-group" style="margin-top: 15px"></i>
                    </div>
                    <a href="{{url('peta')}}" class="small-box-footer">
                        Lihat Daftar Peta <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->

        <div class="row">
            <div class="col-md-3" id='loadingDiv' style="display: none">
                <img class="center-block" src='{{asset('dist/img/loading.gif')}}' style="margin-top: 30px"/>
                <br>
                <div class="text-center">
                    <label>Mohon Tunggu..</label>
                </div>
            </div>
            <div class="col-md-3" id="user-con" style="display: none;" >
                <div class="box box-widget widget-user" id="target" >
                </div>
                <div class="text-right" style="padding-right: 10px">
                    <a href = '{{url("peta")}}' ><i class="fa fa-gear" ></i > Atur Peta </a >
                </div >

            </div>
        </div>
    </section>

@endsection
