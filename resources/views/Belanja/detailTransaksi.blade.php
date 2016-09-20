@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
    <link href="{{asset('style/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <!--<meta id="token" name="_token" content="{!! csrf_token() !!}"/>-->
    <title>
        Rumah Warga | Detail Transaksi
    </title>
</head>
@section('isi')
    <section class="content-header">

        <h1>Transaksi
            <small>
                <ol class="breadcrumb">
                    <li><a href="#"> Beranda</a></li>
                    <li><a href="{{url('transaksi')}}"> Transaksi</a></li>
                    <li class="active">Detail Transaksi</li>
                </ol>
            </small>
        </h1>
    </section>

    <section class="content">

        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h1 class="box-title">Detail Transaksi</h1>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table display text-center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Tanggal Pesan</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                            <th>Pemesan</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$data->created_at}}</td>
                                <td>{{$data->nama_barang}}</td>
                                <td>Rp. {{$data->harga}}</td>
                                <td>{{$data->kuantitas}}</td>
                                <td>Rp. {{$data->sub_total}}</td>
                                <td>{{$data->name}}</td>
                                <td>
                                    {{$data->status}}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="box-footer">

                    @if($data->status != 'Transaksi dibatalkan')
                    <div class="col-md-6">
                        <a data-toggle="modal" data-target="#myModalKonfirmasi">
                            <button type="submit" class="btn btn-success flat pull-right" data-toggle="tooltip" title="Konfirmasi Pesanan" id="konfirmasi">
                                <i class="fa fa-check-circle  margin-r-5"></i> Konfirmasi
                            </button>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a data-toggle="modal" data-target="#myModalBatal">
                            <button type="button" class="btn btn-danger flat pull-left" data-toggle="tooltip" title="Batalkan Pesanan" style="min-width: 110px">
                                <i class="fa fa-times-circle margin-r-5"></i> Batal
                            </button>
                        </a>
                    </div>
                    @else
                    <a data-toggle="modal" data-target="#myModalDelete"><button type="button" class="btn-lg btn-danger flat center-block" data-toggle="tooltip" title="Hapus Pesanan">
                            <i class="fa fa-trash margin-r-5"></i> Hapus
                        </button>
                    </a>
                    @endif
                    <div class="modal fade" id="myModalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabelKonfirmasi">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" method="post" action="{{url("transaksi/konfirmasi")}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id" value="{{$data->id_detail_transaksi}}">
                                        <div class="modal-body">
                                            <label>Konfirmasi Pesanan?</label>
                                        </div>
                                        <div class="modal-footer">
                                            <span class="pull-right">
                                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check margin-r-5"></i> Ya </button>
                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times margin-r-5"></i> Tidak</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Modal Batal -->
                        <div class="modal fade" id="myModalBatal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelBatal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" role="form" method="post" action="{{url("transaksi/batal")}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="{{$data->id_detail_transaksi}}">
                                                <label>Anda Yakin Ingin Membatalkan Pesanan?</label>
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

                        <!-- Modal DELETE -->
                        <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" role="form" method="post" action="{{url("transaksi/hapus")}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="{{$data->id_detail_transaksi}}">
                                                <label>Anda Yakin Ingin Menghapus Pesanan?</label>
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
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('style/bootstrap/js/bootstrap-toggle.min.js')}}"></script>
    <script>
        $(function(){
            $("#example").dataTable();
        });

        $(function() {
            $('#toggle-two').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
        });


        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('input[name=_token]').attr('content') }
        });

        function postKonfirmasi(){
            var id = $('#id').val();
            $.ajax({
                type: "POST",
                url: "/transaksi/konfirmasi" + "/" + id,
                data: {'_token':  $('input[name=_token]').val()},
                success: function(data){
                    return data
                }
            })
        }

        $(document).ready(function() {

/*
            var id = document.getElementById('id');
            $('#konfirmasi').onchange(function(){
                if( $('#konfirmasi').prop('checked') )
                {checkboxstatus = "YES";}
                else
                {checkboxstatus = "NO";}
                $.ajax({
                    type: "POST",
                    url: "transaksi/konfirmasi" + id,
                    data: {checkboxstatus: checkboxstatus}
                })
                        .done(function(data, textStatus, jqXHR){alert(textStatus);})
                        .fail(function(jqXHR, textStatus, errorThrown){alert(jqXHR+"--"+textStatus+"--"+errorThrown);});
            });//end change*/
        });//end ready

    </script>
@endsection