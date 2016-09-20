@extends('layouts.header')
<head>
    <title>Rumah Warga | Peta</title>
    <link rel="stylesheet" href="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}" type="text/css" media="screen"/>
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <!--<script src="{asset('style/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>-->
    <!--<script src="{asset('style/plugins/jvectormap/peta.js')}}"></script>-->
</head>

@section('isi')

    <section class="content-header">
        <h1>
            Pengaturan Peta
            <small><ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Dashboard</a></li>
                    <li><a href="#"> Pengaturan</a></li>
                    <li><a href="{{url('peta')}}"> Peta</a></li>
                    <li class="active">Data Peta </li>
                </ol></small>
        </h1>

    </section>


    <!-- Main content -->
    <section class="content">

        <div class="col-md-7" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{$klaster->nama_klaster}}
                    </h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding" style="overflow-x: scroll">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="pad">
                                <!-- Map will be created here -->
                                <div id="map" style="width: 136.5%;"></div>
                                <script>

                                    {!! $peta->kode !!}

                                    name = '{{$peta->nama_peta}}';

                                    $('#map').vectorMap({
                                        map: name,
                                        backgroundColor: 'lightgrey',
                                        hoverOpacity: 0.7,
                                        selectedColor: '#666666',
                                        enableZoom: true,
                                        showTooltip: false,
                                        scaleColors: ['#C8EEFF', '#006491'],
                                        normalizeFunction: 'polynomial'
                                    });
                                </script>

                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="row">
            <div class="col-md-5" >
                <div class="box box-success flat" >
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Kode Peta
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="height: 105%; overflow-y: scroll">
                        {{$peta->kode}}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
