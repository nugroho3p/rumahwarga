@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
    <link href="{{asset('style/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">


    <title>
        Rumah Warga | Produk
    </title>
</head>
@section('isi')
    <section class="content-header">


        <h1>Daftar Produk Anda
            <small>
                <ol class="breadcrumb">
                    <li><a href="#"> Beranda</a></li>
                    <li><a href="{{url('katalog')}}">Katalog Belanja</a></li>
                    <li class="active">Daftar Produk</li>
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
                    <h1 class="box-title">Daftar Produk Anda</h1>
                    <a href="{{url('produk/tambah')}}" >
                        <button type="button" class="btn btn-success flat pull-right" data-toggle="tooltip" title="Tambahkan Produk">
                            <i class="fa fa-plus margin-r-5"></i>Tambah
                        </button>
                    </a>
                </div><!-- /.box-header -->
                @if(count($produk) > 0)
                    <div class="box-body">
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Barang</th>
                                <th>Ukuran</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($produk as $row)
                                <tr>
                                    <td><img class="img-responsive" src="{{ asset('dist/img/produk/'.$row->gambar) }}" width="50" height="50"/></td>
                                    <td>{{$row->nama_barang}}</td>
                                    <td>{{$row->ukuran}}</td>
                                    <td>Rp. {{$row->harga}}</td>
                                    <td>{{$row->stok}}</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#myModalDelete{{$row->id_detail_barang}}">
                                            <button type="button" class="btn btn-danger flat pull-right" data-toggle="tooltip" title="Hapus Produk">
                                                <i class="fa fa-trash margin-r-5"></i> Hapus
                                            </button>
                                        </a>
                                        <a data-toggle="modal" data-target="#myModalUpdate{{$row->id_detail_barang}}">
                                            <button type="submit" class="btn btn-primary flat pull-right" data-toggle="tooltip" title="Ubah Produk">
                                                <i class="fa fa-edit  margin-r-5"></i> Ubah
                                            </button>
                                        </a>

                                    </td>
                                </tr>

                                <!-- Modal Konfirmasi -->
                                <div class="modal fade" id="myModalUpdate{{$row->id_detail_barang}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelKonfirmasi">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Update Data {{$row->nama_barang}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" role="form" method="post" action="{{url("produk/update")}}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="id" value="{{$row->id_detail_barang}}">
                                                    <div class="modal-body">
                                                        <label class="control-label ">Harga        : </label>
                                                        <input id="harga" name="harga" type="number" class="form-control" min="1" value="{{$row->harga}}"><br>
                                                        <label class="control-label ">Stok   : </label>
                                                        <input id="stok" name="stok" class="form-control" type="number"  min="1" value="{{$row->stok}}">
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

                                <!-- Modal DELETE -->
                                <div class="modal fade" id="myModalDelete{{$row->id_detail_barang}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" role="form" method="post" action="{{url("produk/hapus",$row->id_detail_barang)}}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="modal-body">
                                                        <label>Anda Yakin Ingin Menghapus {{$row->nama_barang}}?</label>
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
                            <h4>Anda tidak mempunyai produk.</h4>
                            <a href="{{url('produk/tambah')}}">
                                <button class="btn btn-lg center-block btn-primary flat" >Tambah Produk</button>
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