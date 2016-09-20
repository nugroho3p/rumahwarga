@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
    <link href="{{asset('style/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">


    <title>
        Rumah Warga | Pesanan
    </title>
</head>
@section('isi')
    <section class="content-header">


        <h1>Pesanan Anda
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li><a href="#"> Belanja</a></li>
                    <li class="active">Pesanan Anda</li>
                </ol>
            </small>
        </h1>
    </section>

    <section class="content">

        <div class="col-md-12">
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
        </div>

        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h1 class="box-title">Daftar Pesanan Anda</h1>

                    <a href="{{url('pesanan/riwayat')}}" class="pull-right">
                        <button class="btn btn-primary flat" data-toggle="tooltip" title="Riwayat Pesanan">
                            <i class="fa fa-list margin-r-5"></i>Riwayat
                        </button>
                    </a>
                </div><!-- /.box-header -->
                @if(count($pesanan) > 0)
                <div class="box-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Tanggal Pesan</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                            <th>Penjual</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pesanan as $row)
                            <tr>
                                <td>{{$row->created_at}}</td>
                                <td>{{$row->nama_barang}}</td>
                                <td>Rp. {{$row->harga}}</td>
                                <td>{{$row->kuantitas}}</td>
                                <td>Rp. {{$row->sub_total}}</td>
                                <td>
                                    <a href="{{url('profil/user/' . $row->id_penjual)}}" data-toggle="tooltip" title="Lihat profil">{{$row->name}}</a>
                                </td>
                                <td>{{$row->status}}</td>
                                <td>
                                    @if($row->status != "Transaksi dibatalkan")

                                        @if($row->status != 'Sedang diproses')

                                            @if($row->status == "Belum dikonfirmasi")
                                                <a data-toggle="modal" data-target="#myModalBatal{{$row->id_detail_transaksi}}">
                                                    <button type="button" class="btn btn-warning btn-block flat"data-toggle="tooltip" title="Batalkan Pesanan">
                                                        <i class="fa fa-times-circle margin-r-5"></i> Batal
                                                    </button>
                                                </a>
                                            @endif

                                        @else
                                            <a data-toggle="modal" data-target="#myModalKonfirmasi{{$row->id_detail_transaksi}}">
                                                <button type="submit" class="btn btn-success btn-block flat" data-toggle="tooltip" title="Konfirmasi Pesanan telah sampai" id="konfirmasi">
                                                    <i class="fa fa-check-circle  margin-r-5"></i> Konfirmasi
                                                </button>
                                            </a>
                                        @endif

                                    @else

                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Konfirmasi -->
                            <div class="modal fade" id="myModalKonfirmasi{{$row->id_detail_transaksi}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelKonfirmasi">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" method="post" action="{{url("pesanan/konfirmasi")}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="id" value="{{$row->id_detail_transaksi}}">
                                                <input type="hidden" name="qty" id="qty{{$row->id_detail_transaksi}}" value="{{$row->kuantitas}}">
                                                <input type="hidden" name="stok" id="stok{{$row->id_detail_transaksi}}" value="{{$row->stok}}">
                                                <div class="modal-body">
                                                    <label>Konfirmasi Pesanan?</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <span class="pull-right">
                                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check margin-r-5"></i> Ya </button>
                                                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times margin-r-5"></i> Tidak</button>
                                                    </span>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Batal -->
                            <div class="modal fade" id="myModalBatal{{$row->id_detail_transaksi}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelBatal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" method="post" action="{{url("pesanan/batal")}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="{{$row->id_detail_transaksi}}">
                                                    <input type="hidden" name="qty" value="{{$row->kuantitas}}">
                                                    <input type="hidden" name="id_det_barang" value="{{$row->id_detail_barang}}">
                                                    <label>Anda Yakin Ingin Membatalkan Pesanan?</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <span class="pull-right">
                                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check margin-r-5"></i> Ya </button>
                                                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times margin-r-5"></i>Tidak</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal DELETE -->
                            <div class="modal fade" id="myModalDelete{{$row->id_detail_transaksi}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" method="post" action="{{url("pesanan/hapus")}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="{{$row->id_detail_transaksi}}">
                                                    <label>Anda Yakin Ingin Menghapus Pesanan?</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <span class="pull-right">
                                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check margin-r-5"></i> Ya </button>
                                                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times margin-r-5"></i>Tidak</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="box-body">
                        <div class="col-md-12 text-center" style="padding-bottom: 30px;">
                            <h4>Anda belum memesan apapun.</h4>
                            <a href="{{url('katalog')}}">
                                <button class="btn btn-lg center-block btn-primary flat" >Mulai Belanja</button>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('style/bootstrap/js/bootstrap-toggle.min.js')}}"></script>

    <script>
        $(function(){
            $("#example").dataTable({
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                    "sEmptyTable": "Tidak ada data di database"
                }
            })
        });

        $(function() {
            $('#toggle-two').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
        })

    </script>
@endsection