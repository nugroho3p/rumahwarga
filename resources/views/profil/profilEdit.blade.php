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
            Profil
            <small>Edit Profil</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"> Home</a></li>
            <li class="active">Edit Profile</li>
        </ol>
    </section>

    <section class="content">
        <div class="col-xs-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="container-fluid">
                        <form class="form-horizontal" role="form" method="POST" action="{{url("profil/submit")}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control" name="id" value="{{ $getData->id }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">NIK</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="NIK" maxlength="16" value="{{ $getData->NIK }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ $getData->name }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="email" value="{{ $getData->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Alamat</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="alamat">{{ $getData->alamat }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">No Telp</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="no_telp" maxlength="12" value="{{ $getData->no_telp }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Tempat Lahir</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="tempat_lahir" value="{{ $getData->tempat_lahir }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Tanggal Lahir</label>
                                <div class="col-md-6">
                                    <input type="text" id="datepicker" class="form-control" name="tanggal_lahir" value="{{ $getData->tanggal_lahir }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Pekerjaan</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pekerjaan" value="{{ $getData->pekerjaan }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">facebook</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="facebook" value="{{ $getData->facebook }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Twitter</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="twitter" value="{{ $getData->twitter }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Foto</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="foto" value="{{ $getData->foto }}">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                <button type="reset" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('style/plugins/select2/select2.full.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
    </script>

@endsection