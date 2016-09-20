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
                    <li><a href="#"> Home</a></li>
                    <li><a href="#"> Informasi</a></li>
                    <li class="active">event</li>
                </ol></small>
        </h1>


    </section>

    <section class="content">
        <div class="col-xs-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Event</h3>
                    </div>
                </div>

                <div class="box-body">
                    <table id="tabel" class="display" cellspacing="0" width="100%">
                        <thead class="">
                            <tr>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal Mulai</th>
                                <th>Waktu Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Waktu Selesai</th>
                                <th>Diundang</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getJoin as $row)
                                <tr>
                                    <td>{{$row->title}}</td>
                                    <td>{{$row->start}}</td>
                                    <td>{{$row->waktu_mulai}}</td>
                                    <td>{{$row->end}}</td>
                                    <td>{{$row->waktu_selesai}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->description}}</td>
                                </tr>
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
            $("#tabel").dataTable();
        });
    </script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Datemask dd/mm/yyyy
            $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
            //Money Euro
            $("[data-mask]").inputmask();

            //Date range picker
            $('#reservation').daterangepicker();
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                    {
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate: moment()
                    },
                    function (start, end) {
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    }
            );

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();

            //Timepicker
            $(".timepicker").timepicker({
                showInputs: false
            });
        });
    </script>

@endsection

