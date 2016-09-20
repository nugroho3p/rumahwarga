@extends('layouts.header')
<head>
    <title>Rumah Warga | Beranda</title>
    <link rel="stylesheet" href="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}" type="text/css" media="screen"/>
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <!--<script src="{asset('style/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>-->
    <!--<script src="{asset('style/plugins/jvectormap/peta.js')}}"></script>-->
</head>

@section('isi')


    <section class="content-header">
        <h1>
            Beranda
            <small>
                <ol class="breadcrumb">
                    <li class="active">Beranda</li>
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

    <div class="col-md-8" xmlns="http://www.w3.org/1999/html">
        <div class="box box-success flat">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{$peta->nama_klaster}}
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
                                                    }else{
                                                        label.html('Belum Ada Pemiliknya');
                                                    }
                                                }
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
        <div class="row">
            <div class="col-md-4" id='userProfil'>
                <div class="box box-widget widget-user" >
                    <div class="widget-user-header bg-green-active flat" >
                        <h3 class="widget-user-username">{{Auth::user()->name}}<span class="label label-default pull-right" style="font-size:9pt;">{{$role->nama_role}}</span></h3>
                        <h6 class="widget-user-desc">{{Auth::user()->email}}</h6>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src={{ asset("dist/img/profil/". Auth::user()->foto)}}>
                    </div>
                    <div class="box-footer">
                        <br><br>
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5>Klaster</h5>
                                    <small class="description-header visible-lg"> {{$peta->nama_klaster}} </small>
                                    <small class="description-header visible-md" data-toggle="tooltip" title="{{$peta->nama_klaster}}">
                                        {{substr($peta->nama_klaster,0,5).'...'}}
                                    </small>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5>Blok</h5>
                                    <small class="description-header">A</small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5>Nomor</h5>
                                    <small class="description-header">25</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group" aria-label="...">
                            <a href=' {{ url('profil/user/' .Auth::user()->id)}} '>
                            <button class="btn btn-flat btn-default"><i class="fa fa-user  margin-r-5"></i> Lihat Profil</button>
                            </a>
                        </div>
                        <div class="btn-group" role="group" aria-label="...">
                            <a href="{{url('profil/edit/'.Auth::user()->id)}}">
                                <button class="btn btn-flat btn-default"><i class="fa fa-edit  margin-r-5"></i> Edit Profil</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4" id='loadingDiv' style="display: none">
                <img class="center-block" src='{{asset('dist/img/loading.gif')}}' style="margin-top: 30px"/>
                <br>
                <div class="text-center">
                    <label>Mohon Tunggu..</label>
                </div>
            </div>
            <div class="col-md-4" id="user-con" style="display: none;" >
                <div class="box box-widget widget-user" id="target" >
                </div>
                @if (Auth::user()->status == "Penanggung Jawab Lokasi")
                <div class="text-right" style="padding-right: 10px">
                    <a href = '{{url("peta")}}' ><i class="fa fa-gear" ></i > Setting Peta </a >
                </div >
                @endif
            </div>
        </div>
    </section>

@endsection
