@extends('layouts.header')
@section('isi')
    <section class="content-header">
        <h1>
            User Profile
            <small>
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">User Profile</li>
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

                <!-- Profile Image -->
                <div class="col-md-5">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user flat">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-green-active flat">
                            <h3 class="widget-user-username">{{Auth::user()->name}}</h3>
                            <h5 class="widget-user-desc">{{Auth::user()->email}}</h5>

                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle" width="128" height="128" src="{{asset ('dist/img/profil/'.Auth::user()->foto) }}"/>
                        </div>
                        <div class="box-footer">
                            <br><br>
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5>Klaster</h5>
                                        <h4 class="description-header">{{$join -> nama_klaster}}</h4>
                                    </div><!-- /.description-block -->
                                </div><!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5>Blok</h5>
                                        <h4 class="description-header">A</h4>
                                    </div><!-- /.description-block -->
                                </div><!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5>Nomor</h5>
                                        <h4 class="description-header">25</h4>
                                    </div><!-- /.description-block -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <!-- About Me Box -->
                            <hr>
                            <strong><i class="fa fa-phone margin-r-5"></i>  Telepon</strong>
                        <p class="text-muted" style="margin-left: 20px">
                            {{Auth::user()->no_telp}}
                        </p>
                        <hr>
                        <strong><i class="fa fa-briefcase margin-r-5"></i>  Pekerjaan</strong>
                        <p class="text-muted" style="margin-left: 20px">
                            {{Auth::user()->pekerjaan}}
                        </p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                        <p class="text-muted" style="margin-left: 20px">
                            {{Auth::user()->alamat}}</p>
                    </div>
                    </div><!-- /.col -->
                </div><!-- /.col -->
            <div class="col-md-7">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Data Keluarga</a></li>
                        @if(Auth::user()->status == "Kepala Keluarga")
                        <li><a href="#timeline" data-toggle="tab">Daftar Tagihan</a></li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <div class="container-fluid">
                                @foreach($getDatawarga as $row)
                                    <div class="col-lg-10" style="margin-top: 10px">
                                    <div class="col-md-4">
                                        <img class="img-circle" width="118px" height="118px" src="{{asset ('dist/img/profil/'.$row->foto) }}" />
                                    </div>
                                    <div class="col-md-8">
                                            <h3>{{$row->name}}</h3>
                                            <h4>{{$row->status}}</h4>
                                    </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if(Auth::user()->status == "Kepala Keluarga")
                        <div class="tab-pane" id="timeline">
                            <table class="table table-bordered table-striped" id="tabel">
                                <thead class="">
                                <tr>
                                    <th>Jenis Tagihan</th>
                                    <th>Periode</th>
                                    <th>Sisa</th>
                                </tr>
                                </thead>
                                @foreach($getTagihan as $row)
                                    <tr>
                                        <td>{{$row->jenis_tagihan}}</td>
                                        <td>{{$row->periode}}</td>
                                        <td>{{$row->jumlah_tagihan}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div><!-- /.tab-pane -->
                        @endif

                        <div class="tab-pane" id="settings">
                           Your EVENT
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
    </section><!-- /.content -->
@endsection