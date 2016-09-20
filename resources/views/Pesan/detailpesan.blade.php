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
                        <li><a href="{{url('pesan')}}">Pesan</a></li>
                        <li class="active">Detail Pesan</li>
                    </ol></small>
            </h1>
        </h1>
        </section>

    <div class="col-md-12">
        <div class="box box-success">
            <div class="container-fluid">
                <div class="box-header with-border ">
                    <h3 class="box-title">{{$p->pengirim}}</h3>
                </div>
                <div class="box-body ">
                    <div class="mailbox-controls">
                                   <!--if($p == true) $join->links()}} endif
                                       <button style="background-color: white; border:none;"></button>
                                   <div class="pull-right">

                                   </div>-->
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped" style="table-layout:fixed; word-wrap:break-word; max-height: 500px; overflow-y: scroll ">
                            <tbody>
                            <col width="15%" />
                            <col width="60%" />
                            <col width="5%" />
                            <col width="10%" />
                            <col width="10%" />
                            @foreach($join as $row)
                                <tr>
                                    <td class="mailbox-name">
                                        @if ($row->pengirim == Auth::user()->name)
                                            Anda
                                        @else
                                            {{$row->pengirim}}
                                        @endif
                                    </td>
                                    <td class="mailbox-subject">{{$row->isi_pesan}}</td>
                                    <td class="mailbox-attachment">
                                        <a href="{{url('dist/pesan/'.$row->lampiran)}}"  data-toggle="tooltip" title="{{$row->lampiran}}">
                                            @if ($row->lampiran != null)
                                                <i class="fa fa-file"></i>
                                            @endif
                                        </a>
                                    </td>
                                    <td class="mailbox-date">{{$row->created_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" title="teruskan" class="btn btn-sm flat btn-primary" data-toggle="modal" data-target="#teruskan{{$row->id_pesan}}" style="margin: 5px 2px"><i class="fa fa-mail-forward"></i></button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" title="hapus" class="btn btn-sm flat btn-danger" data-toggle="modal" data-target="#hapus{{$row->id_pesan}}" style="margin: 5px 2px"><i class="fa fa-trash"></i></button>
                                        </div>

                                               <!-- Modal Teruskan Pesan -->
                                        <div class="modal fade" id="teruskan{{$row->id_pesan}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Teruskan Pesan</h4>
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
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label">Pesan :</label>
                                                                <div class="col-md-6">
                                                                    <textarea class="form-control" rows="5" name="isi_pesan" >Diteruskan dari {{$row->pengirim}}                           ------------------------
                                                                                           {{$row->isi_pesan}}
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group required">
                                                                <label class="col-md-4 control-label">Lampiran</label>
                                                                <div class="col-md-6">
                                                                    <div class="input-group"><input type="text" name="lampiranteruskan" readonly class="form-control" value="{{$row->lampiran}}">
                                                                        <div class="input-group-btn">
                                                                            <a href="{{'/pesanTerkirim/download/'. $row->lampiran}}" type="button" class="btn btn-primary">Download</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-Success flat" data-toggle="tooltip" title="Kirim">
                                                                        <i class="fa fa-check  margin-r-5"></i> Kirim
                                                                    </button>
                                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" data-toggle="tooltip" title="Batal">
                                                                        <i class="fa fa-times-circle margin-r-5"></i> Batal</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                               <!-- Modal Hapus Pesan -->
                                        <div class="modal fade" id="hapus{{$row->id_pesan}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label>Anda Yakin Ingin Menghapus Pesan?</label>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form class="form-horizontal" role="form" method="POST" action="{{url("pesan/hapus")}}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <span class="pull-right">
                                                                <input type="hidden" value="{{$row->id_pesan}}" name="id_pesan">
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary flat" data-toggle="tooltip" title="Ya">
                                                                        <i class="fa fa-check  margin-r-5"></i> Ya
                                                                    </button>
                                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" data-toggle="tooltip" title="Tidak">
                                                                        <i class="fa fa-times-circle margin-r-5"></i> Tidak</button>
                                                                </div>
                                                            </span>
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
                <div class="box-footer">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("pesan/submit-balas")}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_pesan">
                        <input type="hidden" name="parent" value="{{$p->id_pesan}}">
                        <input type="hidden" name="id_penerima" value="{{$p->id_pengirim}}">

                            <div class="col-md-12 no-padding">
                                <textarea class="form-control" rows="3" name="isi_pesan" placeholder="Isikan pesan" required="true"></textarea>
                            </div>
                        <div class="col-md-12 input-group">
                            <div class="col-md-10 no-padding">
                                <input type="file" class="form-control" name="lampiran" >
                            </div>
                            <div class="col-md-2 no-padding">
                            <button type="submit" class="btn btn-Success flat" data-toggle="tooltip" title="Kirim" style="width: 100%;">
                                <i class="fa fa-arrow-circle-right margin-r-5"></i> Kirim
                            </button>
                                </div>
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
            $(".select2").select2()
        });

        function getPesan(){
            $('#data_pesan').load('{{ url('pesan/data-pesan') }}' + '/' + '{{$row->id_pesan}}');
        }


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