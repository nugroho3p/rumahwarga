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
            Pesan
            <small>
                <ol class="breadcrumb">
                    <li>Beranda</li>
                    <li>Pesan</li>
                    <li class="active">Pesan Lapor</li>
                </ol></small>
        </h1>


    </section>

    <section class="content">
        <div class="col-xs-12" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">Lapor</h3>
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lapor/submit")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Jenis Laporan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="jenis_lapor" value="{{$getLapor->jenis_lapor}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Isi Laporan</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="10" placeholder="Isi Laporan ..." name="isi" >value="{{ $getLapor->isi }}"</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a>
                                <button type="button" class="btn btn-success btn-flat pull-right" data-toggle="modal" data-target="#myChat">
                                    <span class="fa fa-check"></span>
                                    <span>Respon</span>
                                </button>
                            </a>
                        </div>
                    </form>
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
                    <h4 class="modal-title" id="myModalLabel">Respon Laporan</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lapor/submit")}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="id_lapor">

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Ke</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="id_pengirim" placeholder="judul" value="{{$row-pengirim}}">
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

        $('#datetimepicker1').datetimepicker();

        $('#datetimepicker2').datetimepicker();

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