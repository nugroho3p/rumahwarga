@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
    <title>
    Rumah Warga | Pengguna
    </title>
</head>
@section('isi')
    <section class="content-header">
        <h1>Pengguna
            <small>
                <ol class="breadcrumb">
                    <li><a href="#"> Beranda</a></li>
                    <li><a href="#"> Administrasi</a></li>
                    <li class="active">Pengguna</li>
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

            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h1 class="box-title">Daftar Pengguna</h1>
                    <button type="button" class="btn btn-success btn-flat pull-right" data-toggle="modal" data-target="#myModalAdd">
                        <i class="fa fa-plus margin-r-5"></i>
                        <span>
                            @if(Auth::user()->id_role == 1)
                                Tambah PJ Lokasi
                            @else
                                Tambah Kepala Keluarga
                            @endif
                        </span>
                    </button>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            @if(Auth::user()->id_role == 1)<th>Klaster</th>@endif
                            <th>Status</th>

                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($getDataWarga as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                @if(Auth::user()->id_role == 1)<td>{{$row->nama_klaster}}</td>@endif
                                <td>{{$row->status}}</td>
                                <td>
                                    <div class="text-center">
                                        @if(Auth::user()->id_role == 2)
                                        <a data-toggle="modal" data-target="#myModalRole{{$row->id}}">
                                            <button type="submit" class="btn btn-primary flat " data-toggle="tooltip" title="Tambahkan Role" id="konfirmasi">
                                                <i class="fa fa-plus-circle  margin-r-5"></i> Role
                                            </button>
                                        </a>
                                        @endif
                                        <a data-toggle="modal" data-target="#myModalDelete{{$row->id}}">
                                            <button type="button" class="btn btn-danger flat "data-toggle="tooltip" title="Hapus Pengguna">
                                                <i class="fa fa-trash margin-r-5"></i> Hapus
                                            </button>
                                        </a>

                                    </div>

                                </td>
                            </tr>

                            <!-- Modal DELETE -->
                            <div class="modal fade" id="myModalDelete{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" method="get" action="{{url("pengguna/delete",$row->id)}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="modal-body">
                                                    <label>Anda Yakin Ingin Menghapus Data {{$row->name}}?</label>
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

                            <div class="modal fade" id="myModalRole{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" role="form" method="post" action="{{url("pengguna/role",$row->id)}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="modal-body">
                                                    <div class="form-group required error{{ $errors->has('name') ? ' has-error' : '' }}">
                                                        <label class="col-md-4 control-label">Pilih Role</label>
                                                        <div class="col-md-6">
                                                            <select name="id_role" class="form-control" required="true" oninput="validateNamaRole2(this)">
                                                                <option></option>
                                                                @foreach($role as $row)
                                                                    <option value="{{$row->id_role}}">{{$row->nama_role}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="margin-top: 20px">
                                                    <span class="pull-right">
                                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check margin-r-5"></i> Ya </button>
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
            </div>
        </div>
    </section>

    <!-- Modal Add -->
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        @if(Auth::user()->id_role == 1)
                            Tambah PJ Lokasi
                        @else
                            Tambah Kepala Keluarga
                        @endif
                    </h4>
                </div>

                <div class="modal-body">
                    <form id="form-add" class="form-horizontal" role="form" method="POST" action="{{url("pengguna/submit")}}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required error{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nama Lengkap</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required="true" oninput="validateName(this)">
                            </div>
                            <div class="col-md-2"><span id="validateMsgName"></span></div>
                        </div>

                        <div class="form-group required error{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Alamat Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required="true" oninput="validateEmail(this)">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2"><span id="validateMsgEmail"></span></div>
                        </div>

                        @if(Auth::user()->status == "SuperAdmin")
                            <div class="form-group">
                                <label class = "col-md-4 control-label">Klaster</label>
                                <div class="col-md-6">
                                    <select name="klaster" class="form-control" required="true" oninput="validateKlaster(this)">
                                        <option selected disabled value="">Pilih Klaster</option>
                                        @foreach($getKlaster as $data)
                                            <option value="{{$data->id_klaster}}">{{$data->nama_klaster}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2"><span id="validateMsgKlaster"></span></div>
                            </div>
                        @endif

                        <div class="form-group error{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" id="pass" required="true" oninput="validatePassword(this)" >
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2"><span id="validateMsgPassword"></span></div>
                        </div>

                        <div class="form-group error{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Ulangi Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" id="repass" required="true" oninput="validateRepassword(this)" min="6" >
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2"><span id="validateMsgRepassword"></span></div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="simpan" class="btn btn-success btn-flat" id="submit">
                                <i class="fa fa-check-circle margin-r-5"></i> Simpan</button>
                            <button type="reset" class="btn btn-default btn-flat" data-dismiss="modal">
                                <i class="fa fa-check-circle margin-r-5"></i> Batal</button>
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
        $("#example").dataTable({

            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        })
        //------------------------------------------------------------------------------------------------------------
        function validateName(input) {
            var name = document.getElementById('validateMsgName');
            if (input.validity) {
                if (input.validity.valid === true) {
                    name.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    name.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan nama' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

        function validateEmail(input) {
            var email = document.getElementById('validateMsgEmail');
            if (input.validity) {
                if (input.validity.valid === true) {
                    email.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    email.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan E-mail' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

        function validateKlaster(input) {
            var klaster = document.getElementById('validateMsgKlaster');
            if (input.validity) {
                if (input.validity.valid === true) {
                    klaster.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    klaster.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama klaster' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

        function validateRole(input) {
            var id_role = document.getElementById('validateMsgRole');
            if (input.validity) {
                if (input.validity.valid === true) {
                    id_role.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    id_role.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama klaster' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

        function validatePassword(input) {
            var password = document.getElementById('validateMsgPassword');
            if (input.validity) {
                if (input.validity.valid === true) {
                    password.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    password.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan Password' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

            function validateRepassword(input) {
                var repassword = document.getElementById('validateMsgRepassword');
                if (input.validity) {
                    if ((input.validity.valid === true) && ($('#pass').val() === $('#repass').val())) {
                        repassword.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check' data-toggle='tooltip' title='Password anda valid' data-placement='auto-right'></span>";
                        document.getElementById('simpan').disabled = false;
                    } else {
                        repassword.innerHTML = "<span class='invalid'><i class='fa fa-2x fa-close' data-toggle='tooltip' title='Password anda tidak valid' data-placement='auto-right'></span>";
                        document.getElementById('simpan').disabled = true;

                    }
                }
            }

    </script>

    @endsection




