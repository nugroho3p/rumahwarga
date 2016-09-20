@extends('layouts.header')

<head>
    <title>Rumah Warga | Belanja</title>
    <link rel="stylesheet" href="{{asset('style/plugins/select2/select2.min.css')}}">
</head>

@section('isi')

    <section class="content-header">
        <h1>
            Tambah Produk
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li><a href="#"> Belanja</a></li>
                    <li><a href="{{url('katalog')}}">Katalog Belanja</a></li>
                    <li><a href="{{url('produk')}}">Daftar Produk</a></li>
                    <li class="active">Tambah Produk</li>
                </ol>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
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
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Produk</h3>
                    <a href="{{url('produk')}}" >
                        <button type="button" class="btn btn-primary flat pull-right" data-toggle="tooltip" title="Lihat Daftar Produk">
                            <i class="fa fa-list margin-r-5"></i> Daftar
                        </button>
                    </a>
                </div><!-- /.box-header -->
                <div class="container-fluid">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("produk/tambah")}}" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Produk :</label>
                                <div class="col-md-5">
                                    <select name="produk" class="form-control select2" required="" style="width: 100%;">
                                        <option selected disabled>Pilih Produk</option>
                                        @foreach($produk as $row)
                                            <option value="{{$row->id_barang}}">{{$row->nama_barang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a data-toggle="modal" data-target="#modal" >
                                        <button type="button" class="btn btn-default flat form-control" data-toggle="tooltip" title="Tambah Produk Baru">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ukuran :</label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" required="" name="ukuran" id="ukuran" min="1" onchange="getUkur()">
                                </div>
                                <div class="col-md-3">
                                    <select name="jenisukur" id="jenisukur" class="form-control" required="" onchange="getUkur()">
                                        <option selected disabled>Pilih Ukuran</option>
                                        <option value="mg">Miligram (mg)</option>
                                        <option value="g">Gram (g)</option>
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="ml">Mililiter (ml)</option>
                                        <option value="ltr">Liter (ltr)</option>
                                    </select>
                                </div>
                                <input type="hidden" class="form-control" required="" name="ukur" id="ukur" >
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Harga :</label>
                                <label class="col-xs-1 control-label">Rp.</label>
                                <div class="col-md-5">
                                    <input type="number" class="form-control" required="" name="harga" min="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Stok :</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" required="" name="stok" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <button type="submit" class="btn btn-success flat"><i class="fa fa-check-circle margin-r-5"></i>
                                Simpan
                            </button>
                            <button type="submit" class="btn btn-danger flat"><i class="fa fa-times-circle margin-r-5"></i>
                                Batal
                            </button>
                        </div>
                    </form>


                    <!-- modal -->
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"> Tambah Produk Baru</h4>
                                </div>

                                    <form role="form" method="POST" action="{{url("produk/baru")}}" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-group">
                                                <label class="form-label">Nama Barang        : </label>
                                                <input name="nama_barang" type="text" class="form-control" required="">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Gambar       : </label>
                                                <input name="gambar" type="file" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <span class="pull-right">
                                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check-circle margin-r-5"></i> Simpan</button>
                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times-circle margin-r-5"></i> Batal</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="{{asset('style/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        function getUkur() {
            $('#ukur').val($('#ukuran').val() + $('#jenisukur').val());
        };

        $(".select2").select2();
    </script>

@endsection