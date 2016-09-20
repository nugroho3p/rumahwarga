@extends('layouts.header')
<head>
    <title>Rumah Warga | Pesan</title>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
</head>
@section('isi')

    <section class="content-header">
        <h1>
            Pesan
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li>Pesan</li>
                    <li class="active">Pesan Terkirim</li>
                </ol></small>
        </h1>
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
            @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <em> {!! session('error_message') !!}</em>
                </div>
            @endif
            <div class="box box-success">
                <div class="container-fluid">
                    <section class="content">
                        <div class="row">

                            <div class="col-md-3">
                                <a class="btn btn-success btn-block margin-bottom flat" data-toggle="modal" data-target="#myChat" style="max-resolution: 5px 10px ">Tulis Pesan Baru</a>
                                <div class="box box-solid">

                                    <div class="box-body no-padding flat">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="{{url('pesan')}}"><i class="fa fa-inbox"></i> Pesan Masuk </a></li>
                                            <li class="active"><a href="{{url('pesanTerkirim')}}"><i class="fa fa-envelope-o"></i> Pesan Terkirim </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="box box-primary flat">
                                    <div class="box-header with-border ">
                                        <h3 class="box-title">Pesan Terkirim</h3>
                                        <div class="box-tools pull-right">
                                            <!-- <div class="has-feedback">
                                               <form action="{{url('pesan')}}" method="get" class="sidebar-form pull-left" style="margin-top: 0; ">
                                                   <div class="input-group">
                                                       <input type="text" name="search" class="form-control" placeholder="Cari Pesan..." >
                                                        <span class="input-group-btn">
                                                            <button type="submit" id="search-btn" class="btn btn-flat">
                                                                <i class="fa fa-search"></i>
                                                                </button>
                                                        </span>
                                                   </div>
                                               </form>
                                           </div> -->
                                        </div>
                                    </div>


                                    <div class="box-body no-padding">

                                        <div class="table-responsive mailbox-messages">
                                            <table class="table table-hover table-striped">
                                                <tbody>
                                                @foreach($join as $row)
                                                    <tr>
                                                        <td>{{$row->penerima}}</td>
                                                        <td >{{substr($row->isi_pesan,0,10)}}...</td>
                                                        <td ></td>
                                                        <td >{{$row->created_at}}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{url("pesan/detail/".$row->id_pesan)}}">
                                                                    <button type="button" title="baca" class="btn flat btn-info " data-toggle="modal" data-target="#baca{{$row->id_pesan}}" style="margin: 5px 2px; width: 100%;" onclick="getPesan()"><i class="fa fa-eye"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                            <!-- <div class="btn-group">
                                                       <button type="button" title="balas" class="btn btn-sm flat btn-success" data-toggle="modal" data-target="#balas{{$row->id_pesan}}" style="margin: 5px 2px"><i class="fa fa-mail-reply"></i>
                                                       </button>
                                                   </div>
                                                   <div class="btn-group">
                                                           <button type="button" title="teruskan" class="btn btn-sm flat btn-primary" data-toggle="modal" data-target="#teruskan{{$row->id_pesan}}" style="margin: 5px 2px"><i class="fa fa-mail-forward"></i>
                                                       </button>
                                                   </div>
                                                   <div class="btn-group">
                                                        <button type="button" title="hapus" class="btn btn-sm flat btn-danger" data-toggle="modal" data-target="#hapus{{$row->id_pesan}}" style="margin: 5px 2px"><i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>-->
                                                        </td>

                                                    </tr>


                                                @endforeach
                                                </tbody>

                                            </table>

                                        </div>
                                        <div class="text-center">
                                            @if($p == true) {{$join->links()}} @endif
                                        </div>
                                    </div> </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Pesan -->
    <div class="modal fade" id="myChat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pesan Baru</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("pesan/submit")}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_pesan">

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Ke :</label>
                            <div class="col-md-6">
                                <select name="id_penerima[]" class="form-control select2" multiple="multiple" data-placeholder="Pilih Warga" style="width: 100%;" required="true" oninput="validateWarga(this)">
                                    @foreach($getDataWarga as $warga)
                                        <option value="{{$warga->id}}">{{$warga->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2"><span id="validateMsgWarga"></span></div>
                        </div>


                        <div class="form-group required">
                            <label class="col-md-4 control-label">Isi Pesan</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="5" name="isi_pesan" placeholder="Isikan pesan" required="true"></textarea>
                            </div>
                            <div class="col-md-2"><span id="validateMsgIsi"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Lampiran</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="lampiran">
                            </div>
                            <div class="col-md-2"><span id="validateMsgIsi"></span></div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success flat" data-toggle="tooltip" title="Kirim">
                                <i class="fa fa-check  margin-r-5"></i> Kirim
                            </button>
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" data-toggle="tooltip" title="Batal">
                                <i class="fa fa-times-circle margin-r-5"></i> Batal</button>
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
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();



        });




        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        function validateIsi(input) {
            var isi_pesan = document.getElementById('validateMsgWarga');
            if (input.validity) {
                if (input.validity.valid === true) {
                    isi_pesan.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    isi_pesan.innerHTML = "<span class='invalid'>" +
                    "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan pesan' data-placement='auto-top'></span>";
                }
            }
        }
    </script>

    <script>
        function myFunction() {
            alert("Pesan Berhasil dikriim");
        }
    </script>

@endsection