@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
    <link href="{{asset('style/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">


    <title>
        Rumah Warga | Kelurahan
    </title>
</head>
@section('isi')
    <section class="content-header">

        <h1>Daftar Kelurahan
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Dashboard</a></li>
                    <li><a href="#">Lokasi</a></li>
                    <li class="active">Kelurahan</li>
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
                    <h1 class="box-title">Daftar Kelurahan</h1>
                    <div class="btn-group pull-right">
                        <a href="{{url('lokasi/kecamatan')}}" >
                            <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Daftar Kecamatan">
                                <i class="fa fa-arrow-circle-left margin-r-5"></i>Kecamatan
                            </button>
                        </a>
                        <a data-toggle="modal" data-target="#myModalAdd">
                            <button type="button" class="btn btn-success flat" data-toggle="tooltip" title="Tambahkan Kelurahan">
                                <i class="fa fa-plus margin-r-5"></i>Tambah
                            </button>
                        </a>
                        <a href="{{url('lokasi/klaster')}}" >
                            <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Daftar Klaster">
                                <i class="fa fa-arrow-circle-right margin-r-5"></i>Klaster
                            </button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="display" id="example" cellspacing="0" width="100%" style="overflow-y: scroll; max-height: 500px">
                        <thead >
                        <tr>
                            <th>Nama Kelurahan</th>
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
                                <td>{{$row->nama_kel}}</td>
                                <td>{{$row->nama_kec}}</td>
                                <td>{{$row->nama_kota}}</td>
                                <td>{{$row->nama_prov}}</td>
                                <td>{{$row->nama_negara}}</td>
                                <td>

                                    <a data-toggle="modal" data-target="#myModalUpdate{{$row->id_kel}}">
                                        <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Ubah Peta">
                                            <i class="fa fa-edit margin-r-5"></i> Ubah
                                        </button>
                                    </a>
                                    <div class="modal fade" id="myModalUpdate{{$row->id_kel}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Ubah Data Kelurahan</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-kel")}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="id_prov" value="{{ $row->id_kel}}">

                                                        <div class="form-group required">
                                                            <label class="col-md-4 control-label">Nama Kecamatan</label>
                                                            <div class="col-md-6">
                                                                <select name="id_negara" class="form-control" required="true" oninput="validateNamaNegara2(this)">
                                                                    <option selected disabled value="{{$row->id_kel}}">{{$row->nama_kel}}</option>
                                                                    @foreach($getDataKec as $neg)
                                                                        <option value="{{$neg->id_kel}}">{{$neg->nama_kel}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2"><span id="validateMsgNamaNegara2"></span></div>
                                                        </div>

                                                        <div class="form-group required">
                                                            <label class="col-md-4 control-label">Nama Kelurahan</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="nama_prov" required="true" oninput="validateNamaProv(this)" value="{{$row->nama_kel}}">
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
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-kel")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required">
                            <label class = "col-md-4 control-label">Nama Kecamatan</label>
                            <div class="col-md-6">
                                <select name="id_kec" class="form-control" required="true" oninput="validateNamaKec2(this)">
                                    <option></option>
                                    @foreach($getDataKec as $row)
                                        <option value="{{$row->id_kec}}">{{$row->nama_kec}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2"><span id="validateMsgNamaKec2"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Kelurahan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_kel" required="true" oninput="validateNamaKel(this)">
                            </div>
                            <div class="col-md-2"><span id="validateMsgNamaKel"></span></div>
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