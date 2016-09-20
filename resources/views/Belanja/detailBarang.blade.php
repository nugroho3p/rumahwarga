@extends('layouts.header')
<head>
    <title>Rumah Warga | Belanja</title>
</head>
@section('isi')

    <section class="content-header">
        <h1>
            Detail Barang
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li><a href="#"> Belanja</a></li>
                    <li><a href="{{url('katalog')}}">Katalog Belanja</a></li>
                    <li class="active">Detail Barang</li>
                </ol>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$detail_barang->nama_barang}}</h3>

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
                        <div class="col-md-11" style="margin-top: 10px">
                            <div class="col-md-4">
                                <img class="img-responsive" src="{{asset('dist/img/produk/'.$detail_barang->gambar)}}">
                            </div>
                            <div class="col-md-8">
                                <label class=>Ukuran : </label>
                                <select name="jenisukur" id="jenisukur" class="form-control" required="" onchange="getPenjual()">
                                    <option selected disabled>Pilih Ukuran</option>
                                    @foreach($ukuran as $row)
                                        <option value="{{$row->ukuran}}">{{$row->ukuran}}</option>
                                    @endforeach
                                </select>
                                <hr>
                                <h5 id="x">*Pilih Ukuran Terlebih Dahulu</h5>
                                <table class="table text-center" id="tabel">

                                   <!-- <thead>
                                    <tr>
                                        <th>Penjual</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Kuantitas</th>
                                        <th>Pesan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <!--<form role="form" method="POST" action="{{ url('katalog/add-cart')}}">
                                            <td>{{ $row->name }}</td>
                                            <td>Rp. {{ $row->harga }}</td>
                                            <td>{{ $row->stok }}</td>

                                            <td>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input name="id_detail_barang" type="hidden"  value="{{$row->id_detail_barang}}">
                                                <input name="id_transaksi" type="hidden">
                                                <input name="penjual" type="hidden" value="{{$row->name}}">
                                                <input name="penjualID" type="hidden" value="{{$row->id}}">
                                                <input name="nama_barang" type="hidden" value="$row->nama_barang.'">
                                                <input id="stok'.$row->id_detail_barang.'" name="stok" type="hidden" value="'.$row->stok.'">
                                                <input id="harga'.$row->id_detail_barang.'" name="harga" type="hidden" value="'.$row->harga.'">

                                                <input id="jumlah'.$row->id_detail_barang.'" name="jumlah" type="number" class="form-control" min="0" max="'.$row->stok.'"><br>

                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-success btn-flat" data-toggle="tooltip" title="Masukan kekeranjang" data-placement="right">
                                                    <i class="fa fa-shopping-cart"></i></button>
                                            </td>
                                        </form>
                                    </tr>
                                    </tbody>-->
                                </table>

                            </div>
                        </div>
                    </div> <!-- box body -->
                    <div class="box-footer">
                        <a href="{{url('katalog')}}">
                            <button class="btn btn-primary flat">
                                <i class="fa fa-arrow-circle-left margin-r-5"></i> Katalog Belanja
                            </button>
                        </a>
                        <a href="#" class="pull-right">
                            <button class="btn btn-danger flat">
                                <i class="fa fa-phone margin-r-5"></i> Laporkan Produk
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();

        });

        function getPenjual(){
            $('#tabel').load('{{ url('katalog/penjual') }}' + '/' + '{{$detail_barang->id_barang}}' + '/' + $('#jenisukur').val());
            $('#x').hide();
            /*var url = '/rumahwarga/public/katalog/penjual' + '/' + '{{$detail_barang->id_barang}}' + '/' + $('#jenisukur').val();
            $.ajax({
                url: url,
                type: "get",
                success: function (data) {
                    if (data.success == true) {
                        console.log(data);
                    }else{
                        console.log(data)
                    }
                }
            });*/
        };
    </script>

@endsection