@extends('layouts.header')
@section('isi')

    <link rel="stylesheet" href="{{asset('style/plugins/select2/select2.min.css')}}">
    <script src="{{asset('style/plugins/select2/select2.full.min.js')}}"></script>


    <section class="content-header">
        <h1>
            Dashboard
            <small>Pekerja</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Pekerja</li>
        </ol>

    </section>

    <section class="content">

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

        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success">
                <div class="container-fluid">
                    <div class="box-header with-border">
                        <h1 class="box-title">Daftar Pekerja</h1>
                        <button type="button" class="btn btn-primary btn-flat pull-right" data-toggle="modal" data-target="#myModalAdd" style="margin:5px 10px  ">
                            <span class="fa fa-plus"></span>
                            <span>Tambah Pekerja</span>
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <table id="pekerja" class="display" cellspacing="0" width="100%">
                                <thead class="">
                                <tr>
                                    <td>Foto</td>
                                    <td>Nama</td>
                                    <td>Alamat</td>
                                    <td>Nomor Telfon</td>
                                    <td>Posisi</td>
                                    <td>Aksi</td>
                                </tr>
                                </thead>
                                @foreach($pekerja as $row)
                                    <tr>
                                        <td><img class="img-responsive" src="{{ asset('dist/img/pekerja/'.$row->foto) }}" width="50" height="50"/></td>
                                        <td>{{$row->nama_pekerja}}</td>
                                        <td>{{$row->alamat}}</td>
                                        <td>{{$row->no_telp}}</td>
                                        <td>{{$row->posisi}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a data-toggle="modal" data-target="#myModalEdit{{$row->id_pekerja}}">
                                                    <button type="submit" class="btn btn-warning flat" data-toggle="tooltip" title="Edit Pekerja">
                                                        <i class="fa fa-edit  margin-r-5"></i> Edit
                                                    </button>
                                                </a>
                                                <a data-toggle="modal" data-target="#myModalDelete{{$row->id_pekerja}}">
                                                    <button type="submit" class="btn btn-danger flat" data-toggle="tooltip" title="Hapus Pekerja">
                                                        <i class="fa fa-edit  margin-r-5"></i> Hapus
                                                    </button>
                                                </a>
                                            </div>
                                        </td>

                                        <div class="modal fade" id="myModalDelete{{$row->id_pekerja}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
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
                                                            <a href="{{url('pekerja/delete/'.$row->id_pekerja)}}">
                                                                <button type="submit" class="btn btn-danger btn-flat"> Iya </button>
                                                            </a>
                                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tidak</button>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="myModalEdit{{$row->id_pekerja}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelEdit">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Edit Pekerja</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" role="form" method="POST" action="{{url("pekerja/submit")}}" enctype="multipart/form-data">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="id_pekerja">

                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label">Nama Pekerja</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="nama_pekerja" value="{{$row->nama_pekerja}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label">Alamat</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="alamat" value="{{$row->alamat}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label">Telepon</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" name="no_telp" value="{{$row->no_telp}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label">Posisi</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" readonly name="posisi" value="{{$row->posisi}}">
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="modal-footer">
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
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
                    <h4 class="modal-title" id="myModalLabel">Tambah Pekerja</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("pekerja/submit")}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_pekerja">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Nama Pekerja</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_pekerja">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Alamat</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="alamat">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Telepon</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="no_telp">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Posisi</label>
                            <div class="col-md-6">
                                <select name="posisi" class="form-control">
                                    <option></option>
                                    <option>Kepala Satpam</option>
                                    <option>Satpam</option>
                                    <option>Petugas Kebersihan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Foto</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="foto">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('style/plugins/select2/select2.full.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(function(){
            $("#pekerja").dataTable();
        });
    </script>
@endsection