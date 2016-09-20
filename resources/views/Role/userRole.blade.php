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
            Role Menu
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"> Home</a></li>
            <li class="active">Role Menu</li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#users" data-toggle="tab">Users</a></li>
                <li><a href="#role" data-toggle="tab">Role</a></li>
                <li><a href="#usersRole" data-toggle="tab">Users-Role</a></li>
            </ul>


            <!--DAFTAR ROLE-->
            <div class="tab-content">
                <div class="active tab-pane" id="users">
                    <div class="active tab-pane" id="users">
                        <table id="example" class="display nowrap" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Nomor Telp</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Pekerjaan</th>
                                <th>Facebook</th>
                                <th>Twitter</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            @foreach($warga as $row)
                                <tr>
                                    <td><img class="img-responsive" src="{{ asset('dist/img/profil/'.$row->foto) }}" width="50" height="50"/></td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->NIK}}</td>
                                    <td>{{$row->tempat_lahir}}</td>
                                    <td>{{$row->tanggal_lahir}}</td>
                                    <td>{{$row->no_telp}}</td>
                                    <td>{{$row->alamat}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>{{$row->status}}</td>
                                    <td>{{$row->pekerjaan}}</td>
                                    <td>{{$row->facebook}}</td>
                                    <td>{{$row->twitter}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('akun/editAkun/'.$row->id)}}">
                                                <button type="button" class="btn btn-flat" title="Edit"><i class="fa fa-edit"></i></button> </a>
                                        </div>
                                        <div class="btn-group">
                                            <a data-toggle="modal" data-target="#myModalDelete">
                                                <button type="button" class="btn btn-flat" title="Hapus"><i class="fa fa-trash"></i></button></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <!--DAFTAR MENU-->
                <div class="tab-pane" id="role">
                    <div class="active tab-pane" id="role">
                        <button type="button" class="btn btn-primary btn-flat pull-right" data-toggle="modal" data-target="#myModalAddRole" style="margin:5px 10px  ">
                            <span class="fa fa-plus"></span>
                            <span>Tambah Role</span>
                        </button>
                        <table id="example2" class="display" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th>Nama Role</th>
                                <th>status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            @foreach($getDataRole as $row)
                                <tr>
                                    <td>{{$row->nama_role}}</td>
                                    <td>{{$row->status}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('akun/editRole/'.$row->id_role)}}">
                                                <button type="button" class="btn btn-flat"><i class="fa fa-edit"></i></button> </a>
                                        </div>
                                        <div class="btn-group">
                                            <a data-toggle="modal" data-target="#myModalDelete">
                                                <button type="button" class="btn btn-flat"><i class="fa fa-trash"></i></button></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <!--DAFTAR ROLE MENU-->
                <div class="tab-pane" id="usersRole">
                    <div class="active tab-pane" id="usersRole">
                        <button type="button" class="btn btn-primary btn-flat pull-right" data-toggle="modal" data-target="#myModalAddAkunRole" style="margin:5px 10px  ">
                            <span class="fa fa-plus"></span>
                            <span>Buat Role Menu</span>
                        </button>
                        <table id="example3" class="display" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th>Nama</th>
                                <th>Nama Role</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            @foreach($getJoinUsersRole as $row)
                                <tr>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->nama_role}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('akun/editAkunRole/'.$row->id)}}">
                                                <button type="button" class="btn btn-flat"><i class="fa fa-edit"></i></button> </a>
                                        </div>
                                        <div class="btn-group">
                                            <a data-toggle="modal" data-target="#myModalDelete">
                                                <button type="button" class="btn btn-flat"><i class="fa fa-trash"></i></button></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
    </section>

    <!-- Modal ADD ROLE -->
    <div class="modal fade" id="myModalAddRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Role</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("akun/submit-role")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="hidden">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Id Role</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="id_role" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Role</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_role" required="true" oninput="validateNamaRole(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaRole"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <select name="status" class="form-control" required="true" oninput="validateStatus(this)">
                                    <option></option>
                                    <option>Aktif</option>
                                    <option>Tidak Aktif</option>
                                </select>
                            </div>
                                <div class="col-md-2"><span id="validateMsgStatus"></span></div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                            <button type="reset" class="btn btn-default btn-flat">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Users Role -->
    <div class="modal fade" id="myModalAddAkunRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Buat Role Menu</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("akun/submit-hub")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama</label>
                            <div class="col-md-6">
                                <select name="id" class="form-control" required="true" oninput="validateNama(this)">
                                    <option></option>
                                    @foreach($warga as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-2"><span id="validateMsgNama"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Role</label>
                            <div class="col-md-6">
                                <select name="id_role" class="form-control" required="true" oninput="validateNamaRole2(this)">
                                    <option></option>
                                    @foreach($getDataRole as $row)
                                        <option value="{{$row->id_role}}">{{$row->nama_role}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaRole2"></span></div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                            <button type="reset" class="btn btn-default btn-flat">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('style/dist/js/pages/dashboard.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(function(){
            $("#example").dataTable({
                "scrollX": true
            });
            $("#example2").dataTable();
            $('#example3').dataTable();
        });
    </script>

    <style>
        div.dataTables_wrapper {
            width: 1000px;
            margin: auto;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        function validateNamaRole(input) {
            var nama_role = document.getElementById('validateMsgNamaRole');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_role.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_role.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tulsikan nama role' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

        function validateNamaRole2(input) {
            var nama_role = document.getElementById('validateMsgNamaRole2');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_role.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_role.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama role' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

        function validateStatus(input) {
            var status = document.getElementById('validateMsgStatus');
            if (input.validity) {
                if (input.validity.valid === true) {
                    status.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    status.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih status' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNama(input) {
            var name = document.getElementById('validateMsgNama');
            if (input.validity){
                if (input.validity.valid === true){
                    name.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                }else {
                    name.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama warga' data-placement='auto-top'></span>";
                }
            }
        }
    </script>

@endsection