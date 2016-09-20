@extends('layouts.header')
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
                <li class="active"><a href="#role" data-toggle="tab">Role</a></li>
                <li><a href="#menu" data-toggle="tab">Menu</a></li>
                <li><a href="#roleMenu" data-toggle="tab">Role-Menu</a></li>
            </ul>

            <!--DAFTAR ROLE-->
            <div class="tab-content">
                <div class="active tab-pane" id="role">
                    <div class="active tab-pane" id="role">
                        <button type="button" class="btn btn-primary btn-flat pull-left" data-toggle="modal" data-target="#myModalAddRole" style="margin:5px 10px  ">
                            <span class="fa fa-plus"></span>
                            <span>Tambah Role</span>
                        </button>
                        <table class="table table-bordered table-striped" id="tabel">
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
                                            <a href="{{url('menu/editRole/'.$row->id_role)}}">
                                                <button type="button" class="btn btn-warning flat" data-toggle="tooltip" title="Edit Role">
                                                    <i class="fa fa-edit  margin-r-5"></i> Edit
                                                </button>
                                            </a>
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
                <div class="tab-pane" id="menu">
                    <div class="active tab-pane" id="menu">
                            <button type="button" class="btn btn-primary btn-flat pull-left" data-toggle="modal" data-target="#myModalAddMenu" style="margin:5px 10px  ">
                                <span class="fa fa-plus"></span>
                                <span>Tambah Menu</span>
                            </button>
                        <table class="table table-bordered table-striped" id="tabel">
                            <thead class="">
                            <tr>
                                <th>Nama Menu</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            @foreach($getDataMenu as $row)
                                <tr>
                                    <td>{{$row->nama_menu}}</td>
                                    <td>{{$row->deskripsi}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('menu/editMenu/'.$row->id_menu)}}">
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
                <div class="tab-pane" id="roleMenu">
                    <div class="active tab-pane" id="roleMenu">
                            <button type="button" class="btn btn-primary btn-flat pull-left" data-toggle="modal" data-target="#myModalAddRoleMenu" style="margin:5px 10px  ">
                                <span class="fa fa-plus"></span>
                                <span>Buat Role Menu</span>
                            </button>
                        <table class="table table-bordered table-striped" id="tabel">
                            <thead class="">
                            <tr>
                                <th>Nama Role</th>
                                <th>Nama Menu</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            @foreach($getDataJoin as $row)
                                <tr>
                                    <td>{{$row->nama_role}}</td>
                                    <td>{{$row->nama_menu}}</td>
                                    <td>
                                        <input type="number" class="form-control" name="sisa">
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('menu/editRoleMenu/'.$row->id_role)}}">
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
                    <form class="form-horizontal" role="form" method="POST" action="{{url("menu/submit-role")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="hidden">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Id Role</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="id_role" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Role</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama_role">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                    <select name="status" class="form-control">
                                        <option></option>
                                        <option>Aktif</option>
                                        <option>Tidak Aktif</option>
                                    </select>
                                </div>
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

    <!-- Modal ADD MENU -->
    <div class="modal fade" id="myModalAddMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Menu</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("menu/submit-menu")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="hidden">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Id Menu</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="id_menu" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama Menu</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama_menu">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Deskripsi</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="deskripsi"></textarea>
                                </div>
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

    <!-- Modal Role Menu -->
    <div class="modal fade" id="myModalAddRoleMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Buat Role Menu</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("menu/submit")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nama Role</label>
                            <div class="col-md-6">
                                <select name="id_role" class="form-control">
                                    <option></option>
                                    @foreach($getDataRole as $row)
                                        <option value="{{$row->id_role}}">{{$row->nama_role}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Nama Menu</label>
                            <div class="col-md-6">
                                <select name="id_menu" class="form-control">
                                    <option></option>
                                    @foreach($getDataMenu as $row)
                                        <option value="{{$row->id_menu}}">{{$row->nama_menu}}</option>
                                    @endforeach
                                </select>
                            </div>
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
@endsection
<script src="{{asset('style/dist/js/pages/dashboard.js')}}"></script>