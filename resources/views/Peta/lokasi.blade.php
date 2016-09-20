@extends('layouts.header')
@section('isi')

    <section class="content-header">
        <h1>
            Lokasi
            <small>
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"> Dashboard</a></li>
                    <li><a href="#"> Pengaturan</a></li>
                    <li class="active">Lokasi</li>
                </ol>
            </small>
        </h1>


    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="col-md-12">
            <div class="box box-success flat">
                <div class="box-body">
                    <span>
                        <a href="{{url('lokasi/negara')}}">
                            <h4>Negara</h4>
                        </a>
                    </span>
                    <span >
                        <a href="{{url('lokasi/provinsi')}}">
                            <h4>Provinsi</h4>
                        </a>
                    </span>

                </div>
            </div>
        </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#negara" data-toggle="tab">Negara</a></li>
            <li><a href="#provinsi" data-toggle="tab">Provinsi</a></li>
            <li><a href="#kota" data-toggle="tab">Kota</a></li>
            <li><a href="#kecamatan" data-toggle="tab">Kecamatan</a></li>
            <li><a href="#kelurahan" data-toggle="tab">Kelurahan</a></li>
            <li><a href="#klaster" data-toggle="tab">Klaster</a></li>
        </ul>

        <!--NEGARA-->
        <div class="tab-content">
            <div class="active tab-pane" id="negara">
                <div class="active tab-pane" id="negara">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-neg")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <div class="form-group required">
                            <label class="col-md-4 control-label">Kode Negara</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="kode_negara" required="true" oninput="validateKodeNegara(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgKodeNegara"></span></div>
                        </div>


                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Negara</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_negara" required="true" oninput="validateNamaNegara(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaNegara"></span></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 ">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                <button type="reset" class="btn btn-default btn-flat">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!--PROVINSI-->
            <div class="tab-pane" id="provinsi">
                <div class="active tab-pane" id="provinsi">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-prov")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Negara</label>
                            <div class="col-md-6">
                                <select name="id_negara" class="form-control" required="true" oninput="validateNamaNegara2(this)">
                                    <option></option>
                                    @foreach($getDataNeg as $row)
                                        <option value="{{$row->id_negara}}">{{$row->nama_negara}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2"><span id="validateMsgNamaNegara2"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Provinsi</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_prov" required="true" oninput="validateNamaProv(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaProv"></span></div>
                        </div>

                        <div class="form-group required">
                            <div class="col-md-6 col-md-offset-4 ">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                <button type="reset" class="btn btn-default btn-flat">Batal</button>
                            </div>
                        </div>
                    </form>
            </div>
            </div>

            <!--KOTA-->
            <div class="tab-pane" id="kota">
                <div class="active tab-pane" id="kota">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-kot")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required">
                            <label class = "col-md-4 control-label">Nama Provinsi</label>
                            <div class="col-md-6">
                                <select name="id_prov" class="form-control" required="true" oninput="validateNamaProv2(this)">
                                    <option></option>
                                    @foreach($getDataProv as $row)
                                        <option value="{{$row->id_prov}}">{{$row->nama_prov}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaProv2"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Kota atau Kabupaten</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_kota" required="true" oninput="validateNamaKota(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaKota"></span></div>
                        </div>

                        <div class="form-group required">
                            <div class="col-md-6 col-md-offset-4 ">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                <button type="reset" class="btn btn-default btn-flat">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!--KECAMATAN-->
            <div class="tab-pane" id="kecamatan">
                <div class="active tab-pane" id="kecamatan">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-kec")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required">
                            <label class = "col-md-4 control-label">Nama Kota</label>
                            <div class="col-md-6">
                                <select name="id_kota" class="form-control" required="true" oninput="validateNamaKota2(this)">
                                    <option></option>
                                    @foreach($getDataKot as $row)
                                        <option value="{{$row->id_kota}}">{{$row->nama_kota}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaKota2"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Kecamatan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_kec" required="true" oninput="validateNamaKec(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaKec"></span></div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-6 col-md-offset-4 ">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                <button type="submit" class="btn btn-default btn-flat">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!--KELURAHAN-->
            <div class="tab-pane" id="kelurahan">
                <div class="active tab-pane" id="kelurahan">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-kel")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required">
                            <label class = "col-md-4 control-label">Nama Kecamatan</label>
                            <div class="col-md-6">
                                <select name="id_kec" class="form-control" required="true" oninput="validateNamaKec2(this)">
                                    <option></option>
                                    @foreach($getDataKec as $row)
                                        <option value="{{$row->id_kec}}">{{$row->nama_kec}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaKec2"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Kelurahan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_kel" required="true" oninput="validateNamaKel(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaKel"></span></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 ">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                <button type="submit" class="btn btn-default btn-flat">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!--KLASTER-->
            <div class="tab-pane" id="klaster">
                <div class="active tab-pane" id="klaster">
                    <form class="form-horizontal" role="form" method="POST" action="{{url("lokasi/submit-klas")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group required">
                            <label class = "col-md-4 control-label">Nama Kelurahan</label>
                            <div class="col-md-6">
                                <select name="id_kel" class="form-control" required="true" oninput="validateNamaKel2(this)">
                                    <option></option>
                                    @foreach($getDataKel as $row)
                                        <option value="{{$row->id_kel}}">{{$row->nama_kel}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaKel2"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Nama Klaster</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama_klaster" required="true" oninput="validateNamaKlaster(this)">
                            </div>
                                <div class="col-md-2"><span id="validateMsgNamaKlaster"></span></div>
                        </div>

                        <div class="form-group required">
                            <label class="col-md-4 control-label">Alamat </label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="alamat" required="true" oninput="validateInisialKlaster(this)"></textarea>
                            </div>
                                <div class="col-md-2"><span id="validateMsgInisialKlaster"></span></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 ">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                <button type="reset" class="btn btn-default btn-flat">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div><!-- /.tab-content -->
    </div><!-- /.nav-tabs-custom -->
</section>

    <script src="{{asset('style/dist/js/pages/dashboard.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        function validateKodeNegara(input) {
            var kode_negara = document.getElementById('validateMsgKodeNegara');
            if (input.validity) {
                if (input.validity.valid === true) {
                    kode_negara.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    kode_negara.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan Kode Negara' data-placement='auto-right'>" +
                            "</span>";
                }
            }
        }

        function validateNamaNegara(input) {
            var nama_negara = document.getElementById('validateMsgNamaNegara');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_negara.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_negara.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan nama negara' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaNegara2(input) {
            var nama_negara = document.getElementById('validateMsgNamaNegara2');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_negara.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_negara.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama negara' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaProv(input) {
            var nama_prov = document.getElementById('validateMsgNamaProv');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_prov.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_prov.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan nama provinsi' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaProv2(input) {
            var nama_prov = document.getElementById('validateMsgNamaProv2');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_prov.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_prov.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama provinsi' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaKota(input) {
            var nama_kota = document.getElementById('validateMsgNamaKota');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_kota.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_kota.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan nama kota' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaKota2(input) {
            var nama_kota = document.getElementById('validateMsgNamaKota2');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_kota.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_kota.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama kota' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaKec(input) {
            var nama_kec = document.getElementById('validateMsgNamaKec');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_kec.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_kec.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan nama kecamatan' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaKec2(input) {
            var nama_kec = document.getElementById('validateMsgNamaKec2');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_kec.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_kec.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama kecamatan' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaKel(input) {
            var nama_kel = document.getElementById('validateMsgNamaKel');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_kel.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_kel.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan nama kelurahan' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaKel2(input) {
            var nama_kel = document.getElementById('validateMsgNamaKel2');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_kel.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_kel.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Pilih nama kelurahan' data-placement='auto-top'></span>";
                }
            }
        }

        function validateNamaKlaster(input) {
            var nama_klaster = document.getElementById('validateMsgNamaKlaster');
            if (input.validity) {
                if (input.validity.valid === true) {
                    nama_klaster.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    nama_klaster.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan nama klaster' data-placement='auto-top'></span>";
                }
            }
        }
        function validateInisialKlaster(input) {
            var inisial_klaster = document.getElementById('validateMsgInisialKlaster');
            if (input.validity) {
                if (input.validity.valid === true) {
                    inisial_klaster.innerHTML = "<span class='valid'><i class='fa fa-2x fa-check'></span>";
                } else {
                    inisial_klaster.innerHTML = "<span class='invalid'>" +
                            "<i class='fa fa-2x fa-close' data-toggle='tooltip' title='Tuliskan inisial klaster' data-placement='auto-top'></span>";
                }
            }
        }

    </script>

@endsection