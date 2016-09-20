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
            Informasi
            <small>
                <ol class="breadcrumb">
                    <li><a href="dashboard"> Dashboard</a></li>
                    <li class="active">Laporan</li>
                </ol></small>
        </h1>
    </section>

    <section class="content">
        <div class="col-xs-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Laporan Warga</h3>
                </div>


            <div class="box-body">
                <table id="tabel" class="display" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th>Pengirim</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Isi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($getLapor as $row)
                     <tr>
                         <td>{{$row->pengirim}}</td>
                         <td>{{$row->created_at}}</td>
                         <td>{{$row->kategori}}</td>
                         <td>{{$row->isi}}</td>
                         <td>{{$row->status}}</td>
                         <td>
                             @if($row->status == "Belum Diproses")
                             @if($row->kategori == "Peta")
                                 <a href="{{url('peta')}}"></a>
                                     @else
                                         <a href="{{url('lapor/detail-lapor/'.$row->target)}}">
                                             @endif
                                 <button type="button" class="btn btn-primary flat" data-toggle="tooltip" title="Lihat Target" id="target">
                                     <i class="fa fa-eye margin-r-5"></i> Lihat
                                 </button>
                             </a>
                                     @endif

                             <a>
                                 <button type="button" title="hapus" class="btn btn-danger btn-flat pull-right" data-toggle="modal" data-target="#hapus{{$row->id_lapor}}">
                                     <span class="fa fa-trash"></span>
                                     <span>Hapus</span>
                                 </button>
                             </a>

                                 <!-- Modal Hapus Pesan -->
                                 <div class="modal fade" id="hapus{{$row->id_lapor}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                     <div class="modal-dialog" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h4 class="modal-title" id="myModalLabel">Konfirmasi Aksi</h4>
                                             </div>
                                             <div class="modal-body">
                                                 <label>Anda Yakin Ingin Menghapus Laporan?</label>
                                             </div>
                                             <div class="modal-footer">
                                                 <form class="form-horizontal" role="form" method="POST" action="{{url("lapor/hapus")}}">
                                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                     <span class="pull-right">
                                                         <input type="hidden" value="{{$row->id_lapor}}" name="id_lapor">
                                                           <button type="submit" class="btn btn-primary flat" data-toggle="tooltip" title="Ya">
                                                               <i class="fa fa-check  margin-r-5"></i> Ya </button>
                                                           <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" data-toggle="tooltip" title="Tidak">
                                                               <i class="fa fa-times-circle margin-r-5"></i> Tidak</button>
                                                       >
                                                         </span>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                         </td>

                     </tr>
                     <!-- Modal Pesan -->
                     <div class="modal fade" id="myChat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                         <div class="modal-dialog" role="document">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                     <h4 class="modal-title" id="myModalLabel">Respon Laporan</h4>
                                 </div>
                                 <div class="modal-body">
                                     <form class="form-horizontal" role="form" method="POST" action="{{url("lapor/submit-respon")}}" enctype="multipart/form-data">
                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                         <input type="hidden" name="id_lapor" value="{{$row->id_lapor}}">

                                         <div class="form-group required">
                                             <label class="col-md-4 control-label">Ke</label>
                                             <div class="col-md-6">
                                                 <input type="hidden" class="form-control" value="{{$row->id_pengirim}}" name="id_penerima">
                                                 <input type="text" class="form-control" value="{{$row->pengirim}}">
                                             </div>
                                             <div class="col-md-2"><span id="validateMsgWarga"></span></div>
                                         </div>

                                         <div class="form-group required">
                                             <label class="col-md-4 control-label">Komentar Respon</label>
                                             <div class="col-md-6">
                                                 <textarea class="form-control" rows="5" name="isi" placeholder="Komentar Respon"></textarea>
                                             </div>
                                             <div class="col-md-2"><span id="validateMsgIsi"></span></div>
                                         </div>

                                         <div class="modal-footer">
                                             <button type="submit" class="btn btn-primary flat" data-toggle="tooltip" title="Kirim">
                                                 <i class="fa fa-check  margin-r-5"></i> Kirim
                                             </button>
                                             <button type="reset" class="btn btn-default flat" data-toggle="tooltip" title="Batal">
                                                 <i class="fa fa-times  margin-r-5"></i> Batal
                                             </button>
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





    <!-- jQuery 2.1.4 -->
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- Select2 -->
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(function(){
            $("#tabel").dataTable({

                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                    "sEmptyTable": "Tidak ada data di database"
                }
            })
        });
    </script>



@endsection

