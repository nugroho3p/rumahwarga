@extends('layouts.header')
<head>
    <link rel="stylesheet" href="{{asset('style/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/plugins/timepicker/bootstrap-timepicker.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('style/plugins/datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet" href="{{asset('style/plugins/timepicker/bootstrap-timepicker.min.css')}}" />
    <link rel="stylesheet" href="{{asset('style/plugins/datetimepicker/bootstrap-datetimepicker.min.css')}}" />

</head>
@section('isi')

    <section class="content-header">
        <h1>
            Kalender
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li><a href="{{url('kalender')}}"> Kalender</a></li>
                    <li class="active">Edit</li>
                </ol></small>
        </h1>


    </section>

    <section class="content">
        <div class="col-xs-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Kegiatan</h3>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{url("kalender/submit-edit")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="hidden">
                            <div class="form-group">
                                <label class="hidden">Pemilik</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pemilik_acara" value="{{ $getData->pemilik_acara }}">
                                </div>
                            </div>
                        </div>

                        <div class="disabled">
                            <div class="form-group">
                                <label class="hidden">Id Kegiatan</label>
                                <div class="col-md-6">
                                    <input type="hidden" readonly class="form-control" name="id_kegiatan" value="{{ $getData->id_kegiatan }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Kegiatan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" value="{{ $getData->title }}" required="true">
                            </div>
                        </div>


                        <div class="form-group required">
                            <label class="col-md-4 control-label">Tanggal & Waktu Mulai</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="start" value="{{ $getData->start }}" required="true"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Tanggal & Waktu Selesai</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="end" value="{{ $getData->end }}" required="true"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Deskripsi</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="3" placeholder="Deskripsi ..." name="description" required="true">{{ $getData->description }}</textarea>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{url('kalender')}}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            </a>
                        </div>

                    </form>
                </div>
            </div>
    </section>

    <script src="{{asset('style/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('style/plugins/jQuery/jQuery.timepicker.js')}}"></script>
    <script src="{{asset('style/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('style/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('style/plugins/datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>

    <script src="{{asset('style/dist/js/app.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('style/dist/js/demo.js')}}"></script>

    <script>

        $('#datetimepicker1').datetimepicker(
                {
                    startDate : '2016-08-16 00:00'
                }
        );

        $('#datetimepicker2').datetimepicker({
            startDate : '2016-08-16 00:00'
        });

        $("#warga").select2();
        function setCheckbox(){
            if($(this).prop('checked', true) ){
                $("#warga > option").prop("selected","selected");// Select All Options
                $("#warga").trigger("change");// Trigger change to select 2
            }else{
                $("#warga > option").removeAttr("selected");
                $("#warga").trigger("change");// Trigger change to select 2
            }
        }


        // initialize input widgets first
        $('#datepairExample .time').timepicker({
            'showDuration': true,
            'timeFormat': 'g:ia'
        });

        $('#datepairExample .date').datepicker({
            'format': 'm-d-yy',
            'autoclose': true
        });

        // initialize datepair
        $('#datepairExample').datepair();
    </script>

    <script>
        $(function () {
            //Timepicker
            $(".timepicker").timepicker({
                showInputs: false
            });

            //Initialize Select2 Elements
            $(".select2").select2();

            //Datemask dd/mm/yyyy
            $("#datemask2").inputmask("dd/mm/yyyy ", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
            //Money Euro
            $("[data-mask]").inputmask();

            //Date range picker
            //$('').daterangepicker();
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
        });
    </script>
@endsection