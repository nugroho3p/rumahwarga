@extends('layouts.header')
<head>
    <title>
        Rumah Warga | Keluarga
    </title>
</head>
@section('isi')

    <section class="content-header">
        <h1>
            Keluarga
            <small>
                <ol class="breadcrumb">
                    <li><a href="#"> Home</a></li>
                    <li>Informasi</li>
                    <li class="active">Keluarga</li>
                </ol>
            </small>
        </h1>
    </section>



    <section class="content">
        @if(Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <em> {!! session('flash_message') !!}</em>
            </div>
        @endif
        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h1 class="box-title"><small>Keluarga</small>
                        <b>
                            @if(Auth::user()->status == "Kepala Keluarga")
                            {{Auth::user()->name}}
                            @else
                                {{$parent->name}}
                            @endif
                        </b>
                    </h1>
                    @if (Auth::user()->status == "Kepala Keluarga")
                        <button type="button" class="btn btn-success btn-flat pull-right" data-toggle="modal" data-target="#myModalAdd">
                            <i class="fa fa-plus"></i><span> Tambah Anggota Keluarga</span>
                        </button>
                    @endif
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <form action="{{url('keluarga')}}" method="get" class="sidebar-form" >
                            <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari..." >
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                        <i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    @foreach($getDataWarga as $row)
                        <div class="col-md-3 col-sm-4 col-xs-6 with-border">
                            <a href="{{url('profil/user/'.$row->id)}}">
                                <img class="img-responsive" src="{{asset('dist/img/profil/'.$row->foto)}}" />
                                <div class="box-footer">
                                    <label>{{$row->name}}</label><br>
                                    <label class="pull-right"><small> {{$row->status}}</small></label>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Modal ADD -->
        <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tambah Data Keluarga</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{url("keluarga/submit")}}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Nama Lengkap</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required="true" oninput="validateName(this)">
                                </div>
                                <div class="col-md-2"><span id="validateMsgName"></span></div>
                            </div>

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Alamat Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required="true" oninput="validateEmail(this)">
                                </div>
                                <div class="col-md-2"><span id="validateMsgEmail"></span></div>
                            </div>

                            <div class="form-group">
                                <label class = "col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                    <select name="status" class="form-control" required="" id="status" oninput="validateStatus(this)">
                                        <option selected disabled>Pilih Status dalam Keluarga</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-2"><span id="validateMsgStatus"></span></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" id="pass" required="true" oninput="validatePassword(this)" >

                                </div>
                                <div class="col-md-2"><span id="validateMsgPassword"></span></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Ulangi Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation" id="repass" required="true" oninput="validateRepassword(this)" min="6" >
                                </div>
                                <div class="col-md-1"><span id="validateMsgRepassword"></span></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-flat" id="simpan">Simpan</button>
                                <button type="reset" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal EDIT -->
        <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Data Keluarga</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{url("keluarga/submit")}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Lengkap</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">NIK</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="NIK">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class = "col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                    <select name="status" class="form-control">
                                        <option>Kepala Keluarga</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Foto</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="foto">
                                </div>
                            </div>

                            <div class="modal-footer ">
                                <button type="submit" id="simpan" class="btn btn-success btn-flat">Simpan</button>
                                <button type="reset" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        function validateName(input) {
            var name = document.getElementById('validateMsgName');
            if (input.validity) {
                if (input.validity.valid === true) {
                    name.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    name.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Masukan nama anda' data-placement='auto-right'>" +
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
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Email anda tidak valid' data-placement='auto-top'></span>";
                }
            }
        }

        function validateStatus(input) {
            var status = document.getElementById('validateMsgStatus');
            if (input.validity){
                if (input.validity.valid === true){
                    status.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                }else {
                    status.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih salah satu status' data-placement='auto-top'></span>";
                }
            }
        }

        function validatePassword(input){
            var password = document.getElementById('validateMsgPassword');
            if (input.validity) {
                if (input.validity.valid === true) {
                    password.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    password.innerHTML = "<span class='invalid'><i class='fa fa-2x fa-close' data-toggle='tooltip' title='Masukan password anda' data-placement='auto-top'></span>";
                }
            }
        }

        function validateRepassword(input){
            var repassword = document.getElementById('validateMsgRepassword');
            var r = false;
            if (input.validity) {
                if ((input.validity.valid === true) && ($('#pass').val() === $('#repass').val())){
                    repassword.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                    document.getElementById('simpan').disabled = false;
                } else {
                    repassword.innerHTML = "<span class='invalid'><i class='fa fa-2x fa-close' data-toggle='tooltip' title='password tidak sama' data-placement='auto-top'></span>";
                    document.getElementById('simpan').disabled = true;
                }
            }
        }
    </script>
@endsection