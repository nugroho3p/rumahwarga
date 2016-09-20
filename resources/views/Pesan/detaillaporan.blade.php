@extends('layouts.header')
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/dataTables.bootstrap.css')}}">
    <link href="{{asset('style/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <!--<meta id="token" name="_token" content="{!! csrf_token() !!}"/>-->
    <title>
        Rumah Warga | Detail Kegiatan
    </title>
</head>
@section('isi')
    <section class="content-header">

        <h1>Detail Kegiatan
            <small>
                <ol class="breadcrumb">
                    <li><a href="#"> Beranda</a></li>
                    <li><a href="{{url('lapor')}}"> Laporan </a></li>
                    <li class="active">Detail Kegiatan</li>
                </ol>
            </small>
        </h1>
    </section>

    <section class="content">

        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h1 class="box-title">Detail Kegiatan</h1>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table display text-center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Pemilik Acara</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Berakhir</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>{{$data->title}}</td>
                                <td>{{$data->description}}</td>
                                <td>{{$data->start}}</td>
                                <td>{{$data->end}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <a href="{{url ('lapor/delete/'. $data->id_kegiatan. '/' . $id_lapor)}}"><button class="btn btn-danger flat center-block">Hapus</button></a>
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