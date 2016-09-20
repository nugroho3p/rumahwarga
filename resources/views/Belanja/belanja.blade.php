@extends('layouts.header')

<head>
    <title>Rumah Warga | Belanja</title>
</head>

@section('isi')

    <section class="content-header">
        <h1>
            Katalog Belanja
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li><a href="#"> Belanja</a></li>
                    <li class="active">Katalog Belanja</li>
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
                    <h3 class="box-title"><a href="{{url('katalog')}}"> Katalog Produk </a></h3>

                    <div class="btn-group pull-right">
                        <a href="{{url('katalog/keranjang-belanja')}}" >
                            <button class="btn btn-warning flat" data-toggle="tooltip" title="Keranjang Belanja Anda">( {{(Cart::count(false))}} Produk )
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                        </a>
                        @if(Auth::user()->id_role == 10)
                            <a href="{{url('produk')}}" >
                                <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Lihat Daftar Produk">
                                    <i class="fa fa-list margin-r-5"></i> Daftar
                                </button>
                            </a>
                            <a href="{{url('produk/tambah')}}" >
                                <button type="button" class="btn btn-success flat" data-toggle="tooltip" title="Tambahkan Produk">
                                    <i class="fa fa-plus margin-r-5"></i>Tambah
                                </button>
                            </a>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="container-fluid">
                    <div class="box-body">
                        <div class="col-md-12">
                            <form action="{{url('katalog')}}" method="get" class="sidebar-form pull-left" style="margin-top: 0; ">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari Barang..." >
                                    <span class="input-group-btn">
                                        <button type="submit" id="search-btn" class="btn btn-flat">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12" style="margin-top: 20px">
                        @foreach($barang as $row)
                            <div class="col-md-3">
                                <a href="{{url('katalog/detail-barang/'.$row->id_barang)}}" >
                                    <div class="box box-primary flat" id="produk">
                                        <img class="img-responsive" src="{{asset('dist/img/produk/'.$row->gambar)}}" alt="..." >

                                    <div class="box-footer text-center flat" id="produklabel">
                                        <small class="visible-lg visible-sm">{{$row->nama_barang}}</small>
                                        <small class="visible-md"  data-toggle="tooltip" title="{{$row->nama_barang}}">{{substr($row->nama_barang,0,13).'...'}}</small>
                                    </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        </div><!-- ./col -->
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="text-center"> {!! $barang->links() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection