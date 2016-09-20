@extends('layouts.header')
<head>
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="{{asset('style/plugins/fullcalendar/fullcalendar.min.css')}}">
    <link rel="stylesheet" href="{{asset('style/plugins/fullcalendar/fullcalendar.print.css')}}" media="print">
    <!-- jQuery 2.1.4 -->
    <script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script src="{{asset('style/dist/js/demo.js')}}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{asset('style/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    <!-- Page specific script -->
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js'></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js'></script>
    <link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' rel='stylesheet' type='text/css'>
<title>Rumah Warga | Kalender</title>
</head>
@section('isi')

    <section class="content-header">

        <h1>
            Kalender
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Beranda</a></li>
                    <li class="active">Kalender</li>
                </ol>
            </small>
        </h1>


    </section>



    <section class="content">
        <div class="col-md-12" xmlns="http://www.w3.org/1999/html">
            @if(Session::has('flash_message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="submit" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <em> {!! session('flash_message') !!}</em>
                </div>
            @endif

                @if(Session::has('error_message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <em> {!! session('flash_message') !!}</em>
                    </div>
                @endif

            <div class="box box-success flat">
                <div class="box-header with-border">
                    <h1 class="box-title">Kalender Kegiatan <small>{{$klaster->nama_klaster}}</small>

                    </h1>

                    @if(Auth::user()->id_role != 2)
                    <a href="{{ url('kalender/add') }}">
                        <button type="button" class="btn btn-success btn-flat pull-right" >
                            <span class="fa fa-plus"></span>
                            <span>Tambah Kegiatan  </span>
                        </button>
                    </a>
                    @endif

                </div><!-- /.box-header -->
                <div id="fullCalModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                                <h2 class="modal-title"><span id="modalTitle"></span> <small id="pemilikAcara"></small></h2>
                            </div>
                            <div id="modalBody" class="modal-body">

                                Tanggal Mulai : <span id="startDate"></span><br>
                                Waktu Mulai : Pukul <span id="startTime"></span><br><br>
                                Tanggal Selesai : <span id="endDate"></span><br>
                                Waktu Selesai : Pukul <span id="endTime"></span><br><br>
                                Deskripsi : <span id="eventInfo"></span>
                            </div>
                            <div class="modal-footer">

                                    <a id="eventUrl"><button class="btn btn-warning flat">Edit Kegiatan</button></a>
                                    <a id="eventDelete"><button class="btn btn-danger flat">Hapus</button></a>

                                    <a href="#" class="pull-left" id="eventLapor">
                                        <button class="btn btn-danger flat" data-toggle="modal" data-target="#lapor">
                                            <span class="fa fa-phone margin-r-5"></span>
                                            <span>Lapor</span>
                                        </button>
                                    </a>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div id="calendar">

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Lapor -->
        <div class="modal fade" id="lapor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Lapor Kegiatan</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{url("lapor/submit")}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="target" id="target">
                            <input type="hidden" name="kategori" value="Kegiatan">

                            <div class="form-group required">
                                <label class="col-md-4 control-label">Isi Lapor</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="5" name="isi" placeholder="Isikan laporan"></textarea>
                                </div>
                                <div class="col-md-2"><span id="validateMsgIsi"></span></div>
                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success flat" data-toggle="tooltip" title="Kirim">
                                    <i class="fa fa-check  margin-r-5"></i> Kirim
                                </button>
                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" data-toggle="tooltip" title="Batal">
                                    <i class="fa fa-times-circle margin-r-5"></i>Batal</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <script>
        $(function () {


            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date();
            var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();


                /*var url = 'kalender/event';
                var json_events = {};

                $.ajax({
                    url: url,
                    type: 'get',
                    success : function(response){
                        json_events = response;
                        console.log(json_events);
                    }
                });*/


            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },

                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                },

                editable: false,
                droppable: false,

                events: 'kalender/event',

                eventClick:  function(event, jsEvent, view) {
                    $('#pemilikAcara').load('{{ url('kalender/info') }}' + '/' +(event.id_kegiatan));
                    $('#modalTitle').html(event.title);
                    //$('#pemilikAcara').html(event.namapembuatt);
                    $("#startDate").html(moment(event.start).format('DD MMMM YYYY'));
                    $("#id_kegiatan").html(event.id_kegiatan);
                    $("#endDate").html(moment(event.end).format('DD MMMM YYYY'));
                    $("#endTime").html(moment(event.end).format('hh:mm'));
                    $("#startTime").html(moment(event.start).format('hh:mm'));
                    $("#eventInfo").html(event.description);
                    $("#target").val(event.id_kegiatan);
                    $('#eventUrl').show();
                    $('#eventDelete').show();
                    $('#eventLapor').show();
                    if (event.created_by == '{{Auth::user()->id}}'){
                        $('#eventUrl').attr('href','kalender/edit' + '/' + (event.id_kegiatan));
                        $('#eventDelete').attr('href','kalender/delete' + '/' + (event.id_kegiatan));
                        $('#eventLapor').hide();
                    }else{
                        if('{{Auth::user()->id_role}}' == 2){
                            $('#eventDelete').attr('href','kalender/delete' + '/' + (event.id_kegiatan));
                            $('#eventUrl').hide();
                            $('#eventLapor').hide();
                        }else{
                            $('#eventUrl').hide();
                            $('#eventDelete').hide();
                        }

                    }

                    $('#fullCalModal').modal();

                },
                // this allows things to be dropped onto the calendar !!!
                drop: function (date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.backgroundColor = $(this).css("background-color");
                    copiedEventObject.borderColor = $(this).css("border-color");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }

                }
            });

            /* ADDING EVENTS */
            var currColor = "#3c8dbc"; //Red by default
            //Color chooser button
            var colorChooser = $("#color-chooser-btn");
            $("#color-chooser > li > a").click(function (e) {
                e.preventDefault();
                //Save color
                currColor = $(this).css("color");
                //Add color effect to button
                $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
            });
            $("#add-new-event").click(function (e) {
                e.preventDefault();
                //Get value and make sure it is not null
                var val = $("#new-event").val();
                if (val.length == 0) {
                    return;
                }

                //Create events
                var event = $("<div />");
                event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
                event.html(val);
                $('#external-events').prepend(event);

                //Add draggable funtionality
                ini_events(event);

                //Remove event from text input
                $("#new-event").val("");
            });
        });

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