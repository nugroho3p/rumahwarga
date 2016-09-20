@extends('layouts.header')

<head>
    <title>Rumah Warga | Belanja</title>
</head>

@section('isi')

    <section class="content-header">
        <h1>
            Keranjang Barang
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li><a href="#"> Belanja</a></li>
                    <li><a href="{{url('katalog')}}">Katalog Belanja</a></li>
                    <li class="active">Keranjang Barang</li>
                </ol>
            </small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">Keranjang Belanja</h3>
                    <a href="{{url('katalog/keranjang-belanja')}}" >
                        <button class="btn btn-warning flat pull-right">( {{(Cart::count(false))}} Produk )
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                    </a>

                </div><!-- /.box-header -->
                <div class="container-fluid">
                    @if(Cart::count() > 0)
                    <div class="box-body">
                        <div class="col-md-12 text-center">
                            <span class="col-md-3 ">
                                <h4>Nama Barang</h4>
                            </span>
                            <span class="col-md-3 ">
                                <h4>Harga</h4>
                            </span>
                            <span class="col-md-3 ">
                                <h4>Kuantitas</h4>
                            </span>
                            <span class="col-md-3 ">
                                <h4 >Subtotal</h4>
                            </span>
                            <hr>
                        </div>
                            @foreach($keranjang as $row)
                            <div class="col-md-12 text-center" style="background-color: #d3d3d3; margin-top: 5px">
                                <span class="col-md-3 ">
                                    <a href="{{url("katalog/remove-item/".$row->id.'/'.$row->qty)}}">
                                        <button type="button" class="btn btn-xs btn-danger flat pull-left"  data-toggle="tooltip" title="Hapus Produk" data-placement="left" style="margin-top: 18px">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </a>
                                    <h5>
                                        {{$row->name}}
                                        <br><br>
                                        <small>Penjual : {{$row->options->seller}}</small>
                                    </h5>
                                </span>
                                <span class="col-md-3 ">
                                    <h5>Rp. {{$row->price}}</h5>
                                </span>
                                <span class="col-md-3 ">
                                    <h5>{{$row->qty}}</h5>
                                </span>
                                <span class="col-md-3 ">
                                    <h5>Rp. {{$row->subtotal}}</h5>
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <div class="box-footer">

                            <div class="col-md-9 text-right ">
                                <h4>
                                    <b>Total :</b>
                                </h4>
                            </div>
                            <div class="col-md-3 text-center pull-right">
                                <h4>
                                   <b>Rp. {{Cart::total()}}</b>
                                </h4>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px">
                                <a href="{{url('katalog/pesan')}}">
                                    <button class="btn-lg center-block btn-success flat">
                                        <i class="fa fa-check-square margin-r-5"></i>
                                        BELI</button>
                                </a>
                            </div>
                            <a href="{{url('katalog')}}">
                                <button class="btn btn-primary flat">
                                    <i class="fa fa-arrow-circle-left margin-r-5"></i> Katalog Belanja
                                </button>
                            </a>

                        </div>
                        @else
                    <div class="box-body">
                        <div class="col-md-12 text-center" style="padding-bottom: 30px;">
                            <h4>Keranjang Belanja Anda Kosong.</h4>
                            <a href="{{url('katalog')}}">
                                <button class="btn btn-lg center-block btn-primary flat" >Mulai Belanja</button>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection