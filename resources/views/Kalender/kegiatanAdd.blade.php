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
                    <li class="active">Tambah</li>
                </ol></small>
        </h1>


    </section>

    <section class="content">
        <div class="col-xs-12" xmlns="http://www.w3.org/1999/html">
            @if(Session::has('message'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <em> {{Session::get('message')}}</em>
                </div>
            @endif
            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Kegiatan</h3>
                    <form class="form-horizontal" role="form" method="POST" action="{{url("kalender/submit")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <div class="hidden">
                            <div class="form-group">
                                <label class="hidden">Pemilik</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="pemilik_acara">
                                </div>
                            </div>
                        </div>

                        <div class="disabled">
                            <div class="form-group">
                                <label class="hidden">Id Kegiatan</label>
                                <div class="col-md-6">
                                    <input type="hidden" readonly class="form-control" name="id_kegiatan">
                                </div>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Kegiatan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Nama Kegiatan" name="title" required="true" oninput="validateNamaKegiatan(this)">
                            </div>
                            <!--<div class="col-md-2"><span id="validateMsgNamaKegiatan"></span></div>-->
                        </div>


                        <div class="form-group required">
                            <label class="col-md-4 control-label">Tanggal & Waktu Mulai</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="start" id='start' required="true" oninput="tglMulai(this)"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2"><span id="validateTanggalMulai"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Tanggal & Waktu Selesai</label>
                            <div class="col-md-6">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="end" required="true" oninput="validateTanggalSelesai(this)"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2"><span id="validateMsgTanggalSelesai"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Deskripsi</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="3" placeholder="Deskripsi ..." name="description" required="true" oninput="validateDeskripsi(this)"></textarea>
                            </div>
                            <div class="col-md-2"><span id="validateMsgDeskripsi"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Mengundang</label>
                            <div class="col-md-4">
                                <select id="warga" name="id[]" class="form-control select2" multiple="multiple" data-placeholder="Pilih Warga" style="width: 100%;">
                                    @foreach($getDataWarga as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <div class="col-md-2"><span id="validateMengundang"></span></div>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="checkbox" onchange="setCheckbox()"> Pilih Semua
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

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        function tglMulai(input) {
            var title = document.getElementById('validateMsgNamaKegiatan');
            if (input.validity) {
                if (input.validity.valid === true) {
                    title.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    title.innerHTML = "<span class='invalid'>" +
                    "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan nama kegiatan' data-placement='auto-right'>" +
                    "</span>";
                }
            }
        }

        function validateTanggalMulai(input) {
            var start = document.getElementById('validateMsgTanggalMulai');
            if (input.validity) {
                if (input.validity.valid === true) {
                    start.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    start.innerHTML = "<span class='invalid'>" +
                    "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan tanggal mulai' data-placement='auto-top'></span>";
                }
            }
        }

        function validateTanggalSelesai(input) {
            var end = document.getElementById('validateMsgTanggalSelesai');
            if (input.validity){
                if (input.validity.valid === true){
                    end.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                }else {
                    end.innerHTML = "<span class='invalid'>" +
                    "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan tanggal selesai' data-placement='auto-top'></span>";
                }
            }
        }

        function validateDeksripsi(input) {
            var description = document.getElementById('validateMsgDeskripsi');
            if (input.validity){
                if (input.validity.valid === true){
                    description.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                }else {
                    description.innerHTML = "<span class='invalid'>" +
                    "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Isikan deskripsi' data-placement='auto-top'></span>";
                }
            }
        }

        function validateMengundang(input) {
            var id_diundang = document.getElementById('validateMsgMengundang');
            if (input.validity){
                if (input.validity.valid === true){
                    id_diundang.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                }else {
                    id_diundang.innerHTML = "<span class='invalid'>" +
                    "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih Warga yang Diundang' data-placement='auto-top'></span>";
                }
            }
        }
    </script>
@endsection