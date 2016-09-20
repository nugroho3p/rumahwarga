@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
</head>

@section('isi')

    <section class="content-header">
        <h1>
            Pengaturan Peta
            <small><ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Dashboard</a></li>
                    <li><a href="#"> Pengaturan</a></li>
                    <li class="active">Peta </li>
                </ol></small>
        </h1>

    </section>

    <section class="content">
        @if(Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <em> {!! session('flash_message') !!}</em>
            </div>
        @endif
        @if(Session::has('error_message'))
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <em> {!! session('error_message') !!}</em>
            </div>
        @endif
        <div class="col-xs-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Peta Lokasi</h3>
                    <a href="{{url('konversi')}}">
                        <button type="button" class="btn btn-success btn-flat pull-right" data-toggle="tooltip" title="Tambah Peta">
                            <i class="fa fa-plus margin-r-5 "></i><span> Tambah Peta</span>
                        </button>
                    </a>
                </div><!-- /.box-header -->
                <div class="container-fluid">
                    <!-- Button trigger modal -->

                    <div class="box-body">
                        <table class="display" id="example" cellspacing="0" width="100%" style="overflow-y: scroll; max-height: 500px">
                            <thead >
                            <tr>
                                <th>Klaster</th>
                                <th>Kode</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($peta as $row)
                                <tr>
                                    <td>{{$row->nama_peta}}</td>
                                    <td>{{substr($row->kode,0,70).'...'}}</td>
                                    <td>

                                        <a href="{{url('peta/data-peta/'.$row->id_peta)}}">
                                            <button type="button" class="btn btn-default flat" data-toggle="tooltip" title="Lihat Peta">
                                                <i class="fa fa-eye margin-r-5"></i> Lihat
                                            </button>
                                        </a>
                                        <a href="{{url('peta/ubah-peta/'.$row->id_peta)}}">
                                            <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Ubah Peta">
                                                <i class="fa fa-edit margin-r-5"></i> Ubah
                                            </button>
                                        </a>
                                        <a data-toggle="modal" data-target="#myModalDelete{{$row->id_peta}}">
                                            <button type="button" class="btn btn-danger flat" data-toggle="tooltip" title="Hapus Peta">
                                                <i class="fa fa-trash margin-r-5"></i> Hapus
                                            </button>
                                        </a>
                                        <div class="modal fade" id="myModalDelete{{$row->id_peta}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" role="form" method="post" action="{{url("peta/delete-peta",$row->id_peta)}}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <div class="modal-body">
                                                                <label>
                                                                    Anda Yakin Ingin Menghapus Peta {{$row->nama_peta}}?
                                                                    <br>
                                                                    <br>
                                                                    Perhatian!! Semua Data di dalam Peta akan ikut terhapus.
                                                                </label>
                                                            </div>
                                                            <div class="modal-footer">
                                                            <span class="pull-right">
                                                                <button type="submit" class="btn btn-danger btn-flat">Iya</button>
                                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tidak</button>
                                                            </span>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
         </div>
    </div>
            </div>
    </section>

    <!-- Modal ADD -->
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Kode SVG</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("petaAdmin/submit")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">File SVG</label>
                            <div class="col-md-6">
                                 <input class=" form-control" type="file" placeholder="pilih file svg ..." name="deskripsi"></textarea>
                            </div>
                        </div>

                        <h4 class="modal-title" id="myModalLabel">Pengaturan Peta</h4>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Lokasi</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="jenis_tagihan">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>


    <script>
    $(function(){
        $("#example").dataTable({

            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        })
    });
    </script>

@endsection