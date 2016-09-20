@extends('layouts.header')
@section('isi')

    <head>
        <title>Pengaturan Peta</title>
        <link rel="stylesheet" href="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}" type="text/css" media="screen"/>
        <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
        <script src="{{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>

        <!--<script src="{asset('style/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>->
        <script src="{asset('style/plugins/jvectormap/peta.js')}}"></script>-->
    </head>

    <section class="content-header">
        <h1>
            Peta
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li><a href="#">Pengaturan</a></li>
                    <li class="active">Peta</li>
                </ol>
            </small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="col-md-8" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat" >
                <div class="box-header with-border">
                    <h3 class="box-title">Peta <small>{{$peta->nama_klaster}}</small></h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="pad">
                                <!-- Map will be created here -->
                                <div id="map" style="width: 136.5%; height: 500px"></div>
                                <script>
                                    $(document).ready(function(){
                                        $('#jenis').change(function(){
                                            var selected = $("option:selected", this);
                                            if(selected.parent()[0].id == "pribadi"){
                                                $("#formDiv").fadeIn();
                                            } else if(selected.parent()[0].id == "umum"){
                                                $("#formDiv").fadeOut();
                                            }
                                        });
                                    });

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
                                            $('#code').val(code);
                                            $('#kode_svg').val(code);
                                            $('#region').val(region);
                                            $("#submit").fadeIn();
                                            var url = 'peta/info' + '/' + (code);
                                            $.ajax({
                                                url: url,
                                                type: "get",
                                                success: function (data) {
                                                    console.log(data);
                                                    if (data.success == true) {
                                                        $('#nomor_rumah').val(data.nomor_rumah);
                                                        $('#alamat').val(data.alamat);
                                                        $("#jenis").val(data.id_warna);
                                                        $("#pemilik").val(data.pemilik);

                                                        if(data.pemilik == null){
                                                            $("#formDiv").fadeOut();
                                                        }else{
                                                            $("#formDiv").fadeIn();
                                                        }

                                                        $('#modalDelete').fadeIn();
                                                        var link = document.getElementById("delete");
                                                        link.setAttribute('href', "peta/delete/" + $('#kode_svg').val());
                                                    } else {
                                                        $('#nomor_rumah').val('');
                                                        $('#alamat').val('');
                                                        $("#jenis").val($("#jenis option:first").val());
                                                        $("#pemilik").val($("#pemilik option:first").val());

                                                        $("#formDiv").fadeOut();
                                                        $('#modalDelete').fadeOut();
                                                    }
                                                },
                                                error: function (data) {
                                                    if (data.success == false) {
                                                    }
                                                }
                                            });
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
                <div class="col-md-4">
                    @if(Session::has('flash_message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <em>{!! session('flash_message') !!}</em>
                        </div>
                    @endif
                    @if(Session::has('delete_message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <em>{!! session('delete_message') !!}</em>
                        </div>
                    @endif
                    @if(Session::has('error_message'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <em> {!! session('error_message') !!}</em>
                        </div>
                    @endif

                    <div class="box box-success flat">
                        <form class="form" role="form" method="POST" action="{{url("peta/submit")}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_peta" value="{{$peta->id_peta}}">

                            <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kode SVG</label>
                                <input type="text" class="form-control" id="kode_svg" name="kode_svg" placeholder="Kode SVG" required="" readonly>
                            </div>
                            <div class="form-group">
                                <label class = "control-label">Jenis <small>(wajib diisi)</small></label>
                                <select id="jenis" name="jenis" class="form-control" required >
                                    <option selected disabled value="">Pilih Jenis</option>
                                    <optgroup label="Pribadi" id="pribadi">
                                        <option value="1">Rumah</option>
                                        <option value="3">Toko</option>
                                    </optgroup>
                                    <optgroup label="Fasilitas Umum" id="umum">
                                        <option value="2">Kavling</option>
                                        <option value="4">Taman</option>
                                        <option value="5">Lapangan</option>
                                        <option value="6">Jalan</option>
                                        <option value="7">Tempat Ibadah</option>
                                        <option value="8">Pos Satpam</option>
                                    </optgroup>
                                </select>
                            </div>
                                <div id="formDiv" style="display: none;">
                            <div class="form-group" >
                                <label>Pemilik</label>
                                <select id="pemilik" name="pemilik" class="form-control" style="width: 100%;">
                                    <option selected disabled>Pilih kepala keluarga</option>
                                    <optgroup label="Kepala Keluarga">
                                        @foreach($getDataWarga as $data)
                                            @if($getDataWarga == "")
                                                <option disabled>Tidak Ada Warga</option>
                                            @endif
                                            <option @if($data->id == $wargaID ) disabled @endif value="{{$data->id}}">{{$data->name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nomor Rumah</label>
                                <input type="text" class="form-control" id="nomor_rumah" name="nomor_rumah" placeholder="Nomor Rumah">
                            </div>
                            <div class="form-group" >
                                <label for="exampleInputPassword1">Alamat Rumah</label>
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                            </div>
                                </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-flat" data-toggle="tooltip" title="Simpan Data" id="submit" style="display: none;">
                                <i class="fa fa-check-circle margin-r-5"></i> Simpan
                            </button>
                            <a data-toggle="modal" data-target="#myModalDelete" id="modalDelete" style="display: none;">
                                <button type="button" class="btn btn-danger btn-flat"  data-toggle="tooltip" title="Hapus Data">
                                    <i class="fa fa-trash margin-r-5"></i> Hapus
                                </button>
                            </a>
                        </div>
                    </form>
                </div><!-- /.box -->
                </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <label>Anda Yakin Ingin Menghapus Data?</label>
                            </div>
                            <div class="modal-footer">
                                <span class="pull-right">
                                    <a id="delete">
                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check-circle margin-r-5"></i> Ya </button>
                                    </a>
                                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times-circle margin-r-5"></i> Tidak</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection





