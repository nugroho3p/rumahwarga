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

        <!-- Profile Image -->
        <div class="col-md-5">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user flat">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-green-active flat">
                    <h3 class="widget-user-username">{{$profil->name}}</h3>
                    <h6 class="widget-user-desc">{{$profil->email}}</h6>

                </div>
                <div class="widget-user-image">
                    <img class="img-circle" width="128" height="128" src="{{asset ('dist/img/profil/'.$profil->foto) }}"/>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h6 class="description-header">Klaster</h6>
                                <h4>{{$join -> nama_klaster}}</h4>
                            </div><!-- /.description-block -->
                        </div><!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h6 class="description-header">Blok</h6>
                                <h4>AD2</h4>
                            </div><!-- /.description-block -->
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h6 class="description-header">Nomor</h6>
                                <h4>25</h4>
                            </div><!-- /.description-block -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- About Me Box -->
                    <hr>
                    <strong><i class="fa fa-phone margin-r-5"></i>  Telepon</strong>
                    <p class="text-muted" style="margin-left: 20px">
                        {{$profil->no_telp}}
                    </p>
                    <hr>
                    <strong><i class="fa fa-briefcase margin-r-5"></i>  Pekerjaan</strong>
                    <p class="text-muted" style="margin-left: 20px">
                        {{$profil->pekerjaan}}
                    </p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                    <p class="text-muted" style="margin-left: 20px">
                        {{$profil->alamat}}</p>
                </div>
            </div><!-- /.col -->
        </div><!-- /.col -->
        <div class="col-md-7">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Data Keluarga</a></li>
                    <li><a href="#timeline" data-toggle="tab">Daftar Tagihan</a></li>
                    <li><a href="#settings" data-toggle="tab">Event</a></li>
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
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <table class="table table-bordered table-striped" id="tabel">
                            <thead class="">
                            <tr>
                                <th>No</th>
                                <th>Nomor Tagihan</th>
                                <th>Jenis Tagihan</th>
                                <th>Jumlah Tagihan</th>
                                <th>Periode</th>
                            </tr>
                            </thead>
                        </table>
                    </div><!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        Your EVENT
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->

    </section><!-- /.content -->
@endsection