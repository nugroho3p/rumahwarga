@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
    <link href="{{asset('style/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">


    <title>
        Rumah Warga | Kecamatan
    </title>
</head>
@section('isi')
    <section class="content-header">

        <h1>Daftar Kecamatan
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Dashboard</a></li>
                    <li><a href="#">Lokasi</a></li>
                    <li class="active">Kecamatan</li>
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
                    <h1 class="box-title">Daftar Kecamatan</h1>
                    <div class="btn-group pull-right">
                        <a href="{{url('lokasi/kota')}}" >
                            <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Daftar Kota">
                                <i class="fa fa-arrow-circle-left margin-r-5"></i>Kota
                            </button>
                        </a>
                        <a data-toggle="modal" data-target="#myModalAdd">
                            <button type="button" class="btn btn-success flat" data-toggle="tooltip" title="Tambahkan Kecamatan">
                                <i class="fa fa-plus margin-r-5"></i>Tambah
                            </button>
                        </a>
                        <a href="{{url('lokasi/kelurahan')}}" >
                            <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Daftar Kelurahan">
                                <i class="fa fa-arrow-circle-right margin-r-5"></i>Kelurahan
                            </button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="display" id="example" cellspacing="0" width="100%" style="overflow-y: scroll; max-height: 500px">
                        <thead >
                        <tr>
                            <th>Nama Kecamatan</th>
                            <th>Nama Kota</th>
                            <th>Nama Provinsi</th>
                            <th>Nama Negara</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->nama_kec}}</td>
                                <td>{{$row->nama_kota}}</td>
                                <td>{{$row->nama_prov}}</td>
                                <td>{{$row->nama_negara}}</td>
                                <td>

                                    <a data-toggle="modal" data-target="#myModalUpdate{{$row->id_kec}}">
                                        <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Ubah Peta">
                                            <i class="fa fa-edit margin-r-5"></i> Ubah
                                        </button>
                                    </a>
                                    <div class="modal fade" id="myModalUpdate{{$row->id_kec}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Ubah Data Kecamatan</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-kec")}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="id_prov" value="{{ $row->id_kec}}">

                                                        <div class="form-group required">
                                                            <label class="col-md-4 control-label">Nama kota</label>
                                                            <div class="col-md-6">
                                                                <select name="id_negara" class="form-control" required="true" oninput="validateNamaNegara2(this)">
                                                                    <option selected disabled value="{{$row->id_kota}}">{{$row->nama_kota}}</option>
                                                                    @foreach($getDataKot as $neg)
                                                                        <option value="{{$neg->id_kota}}">{{$neg->nama_kota}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2"><span id="validateMsgNamaNegara2"></span></div>
                                                        </div>

                                                        <div class="form-group required">
                                                            <label class="col-md-4 control-label">Nama Kecamatan</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="nama_prov" required="true" oninput="validateNamaProv(this)" value="{{$row->nama_kec}}">
                                                            </div>
                                                            <div class="col-md-2"><span id="validateMsgNamaProv"></span></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6 col-md-offset-4 ">
                                                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check-circle margin-r-5"></i>Simpan</button>
                                                                <button type="buttin" data-dismiss="modal" class="btn btn-default btn-flat"><i class="fa fa-times-circle margin-r-5"></i>Batal</button>
                                                            </div>
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
    </section>
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Negara</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-kec")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required">
                            <label class = "col-md-4 control-label">Nama Kota</label>
                            <div class="col-md-6">
                                <select name="id_kota" class="form-control" required="true" oninput="validateNamaKota2(this)">
                                    <option></option>
                                    @foreach($getDataKot as $row)
                                        <option value="{{$row->id_kota}}">{{$row->nama_kota}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2"><span id="validateMsgNamaKota2"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Kecamatan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_kec" required="true" oninput="validateNamaKec(this)">
                            </div>
                            <div class="col-md-2"><span id="validateMsgNamaKec"></span></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 ">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check-circle margin-r-5"></i>Simpan</button>
                                <button type="button" data-dismiss="modal" class="btn btn-default btn-flat"><i class="fa fa-times-circle margin-r-5"></i>Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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