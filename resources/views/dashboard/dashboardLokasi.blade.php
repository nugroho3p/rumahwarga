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

        <div class="col-md-6" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        {{$peta->nama_klaster}}
                    </h2>
                    <a href="{{url('peta')}}" class="pull-right">
                        <button class="btn btn-primary flat" data-toggle="tooltip" title="Pengaturan peta">
                            <i class="fa fa-gear margin-r-5"></i>Pengaturan Peta
                        </button>
                    </a>
                </div><!-- /.box-header -->

                <div class="box-body no-padding" style="overflow: scroll;">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="pad no-padding">
                                <!-- Map will be created here -->
                                <div id="map" style="width: 140%; height: 70%;"></div>
                                <script>

                                    {!! $peta->kode !!}

                                    name = '{{$peta->nama_peta}}';

                                    $('#map').vectorMap({
                                        map: name,
                                        backgroundColor: 'lightgrey',
                                        hoverOpacity: 0.7,
                                        selectedColor: '#666666',
                                        enableZoom: true,
                                        showTooltip: true,
                                        scaleColors: ['#C8EEFF', '#006491'],
                                        normalizeFunction: 'polynomial',
                                        series: {
                                            regions:[{
                                                values: {!! str_replace('"',' ', $colors )  !!}
                                            }],
                                        },
                                        onRegionClick: function (event, code, region) {
                                            $("#userProfil").hide();
                                            $("#user-con").hide();
                                            $('#loadingDiv').show();
                                            $("#target").load('{{ url('dashboard/info') }}' + '/' + (code), function() {
                                                $('#loadingDiv').hide();
                                                $("#user-con").fadeIn(500);
                                            });
                                        },
                                        onRegionLabelShow: function(event, label, code) {
                                            var url = 'peta/info' + '/' + (code);
                                            $.ajax({
                                                url: url,
                                                type: "get",
                                                success: function (data) {
                                                    if (data.success == true) {
                                                        label.html(data.jenis);
                                                    } else {
                                                        label.html('Belum Ada Pemiliknya');
                                                    }
                                                },
                                            });
                                        //map.series.regions[0].setValue(colors);
                                        }
                                    });
                                </script>

                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue flat">
                    <div class="inner">
                        <h3>{{$users}}</h3>
                        <p>Warga</p>
                    </div>
                    <div class="icon" >
                        <i class="fa fa-group" style="margin-top: 15px"></i>
                    </div>
                    <a href="{{url('pengguna')}}" class="small-box-footer">
                        Lihat Daftar Warga <i class="fa fa-arrow-circle-right"></i></a>
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
