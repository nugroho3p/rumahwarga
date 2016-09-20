<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rumah Warga</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('style/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('style/costum.css')}}">
    <link rel="stylesheet" href="{{asset('style/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('style/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('style/dist/css/skins/_all-skins.min.css')}}">
    <!-- iCheck --
    <link rel="stylesheet" href="{asset('style/plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart --
    <link rel="stylesheet" href="{asset('style/plugins/morris/morris.css')}}">
    <!-- jvectormap ->
    <link rel="stylesheet" href="{asset('style/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}'">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('style/plugins/datepicker/datepicker3.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('style/plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('style/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <link rel="stylesheet" href="{{asset('style/plugins/select2/select2.min.css')}}">

    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/datatable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style/plugins/datatables/jquery.dataTables.min.css')}}">

    <![endif]-->
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>R</b>W</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Rumah</b>warga</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class=" notifications-menu" data-toggle="tooltip" title="Keranjang Belanja" data-placement="bottom">
                        <a href="{{url('katalog/keranjang-belanja')}}" >
                            <i class="fa fa-shopping-cart"></i>
                            <span id="cart" class="label label-danger">@if(Cart::count(false) > 0){{Cart::count(false)}}@endif</span>
                        </a>
                    </li>
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="notifPesanClick()">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-danger" id="notifPesan"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <ul class="menu" id="listNotifPesan">

                                </ul>
                            </li>

                            <li class="footer"><a href="{{url('/pesan')}}">Lihat Semua Pesan</a></li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="notifClick()">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-danger" id="notif"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu" id="listNotif">

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="user user-menu">
                        <a href="{{url('profil')}}" >
                            <img src="{{asset('dist/img/profil/'.Auth::user()->foto)}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- inner menu: contains the actual data -->
                            <li>
                                <a href="{{url('profil/edit/'.Auth::user()->id)}}">
                                    <i class="fa fa-edit text-aqua pull-left"></i>Edit Profil
                                </a>
                            </li>
                            <li >
                                <a href="{{url('profil/edit/'.Auth::user()->id)}}">
                                    <i class="fa fa-lock text-yellow pull-left"></i> Ubah Kata Sandi
                                </a>
                            </li>
                            <li>
                                <a href="{{url('logout')}}">
                                    <i class="fa fa-sign-out text-red pull-left"></i>Keluar
                                </a><!-- Menu Footer-->
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">

                @if (Auth::user()->id_role == 1 or Auth::user()->id_role == 2)
                    <li class="active treeview">
                        <a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-laptop"></i><span>Administrasi</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="padding-left: 25px">
                            <li><a href="{{url('jenisTagihan')}}">Jenis Tagihan</a></li>
                            <li><a href="{{url('jenisSurat')}}">Jenis Pengajuan Surat</a></li>
                            <li><a href="{{url('pengguna')}}">Pengguna</a></li>
                            <li><a href="{{url('pekerja')}}"> Pekerja</a></li>
                            <li><a href="{{url('hirarki')}}">Hirarki</a></li>
                            <li><a href="{{url('proses')}}">Proses</a></li>
                            <li><a href="{{url('akun')}}">Role-Akun</a></li>
                            <li><a href="{{url('nopenting')}}">Nomor Penting</a></li>
                        </ul>
                    </li>
                    @if(Auth::user()->id_role == 1)
                    <li class="treeview">
                        <a href="#"><i class="fa fa-gears"></i><span>Pengaturan</span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu" style="padding-left: 25px">
                            <li>
                                <a href="#"> Lokasi <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="{{url('lokasi/negara')}}"> Negara</a></li>
                                    <li><a href="{{url('lokasi/provinsi')}}"> Provinsi</a></li>
                                    <li><a href="{{url('lokasi/kota')}}"> Kota</a></li>
                                    <li><a href="{{url('lokasi/kecamatan')}}"> Kecamatan</a></li>
                                    <li><a href="{{url('lokasi/kelurahan')}}"> Kelurahan</a></li>
                                    <li><a href="{{url('lokasi/klaster')}}"> Klaster</a></li>
                                </ul>
                            </li>
                            <li><a href="{{url('lokasi/klaster')}}">Klaster</a></li>
                            <li><a href="{{url('peta')}}">Peta</a></li>
                        </ul>
                    </li>
                    @else
                        <li class="treeview">
                            <a href="{{url('peta')}}"><i class="fa fa-map-marker"></i><span>Peta</span></a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i><span>Belanja</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu " style="padding-left: 25px">
                                <li><a href="{{url('katalog')}}">Katalog</a></li>
                                <li><a href="{{url('produk/daftar-produk')}}">Daftar Produk</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{url('pesan')}}"><i class="fa fa-comment"></i><span>Pesan</span></a>
                        </li>
                        <li class="treeview">
                            <a href="{{url('nopenting')}}"><i class="fa fa-phone-square"></i><span>Nomor Penting</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('kalender')}}"><i class="fa fa-calendar"></i><span>Kalender</span><span class="label label-danger pull-right" id="notifKalender"></span></a>
                        </li>
                        <li class="treeview">
                            <a href="{{url('lapor/arsip')}}"><i class="fa fa-exclamation"></i><span>Laporan</span></a>
                        </li>
                    @endif
                @else
                    <li class="active treeview">
                        <a href="{{url('/dashboard')}}"><i class="fa fa-home"></i><span>Beranda</span></a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-th"></i><span>Informasi</span><i class="fa fa-angle-left pull-right"></i>
                        </a>

                        <ul class="treeview-menu" style="padding-left: 25px">
                            <li><a href="{{url('keluarga')}}">Keluarga</a></li>
                            <li><a href="{{url('suratTelusur')}}">Telusur Surat</a></li>
                            @if(Auth::user()->status == "Kepala Keluarga")
                                <li><a href="{{url('detailTagihan')}}">Tagihan</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-envelope"></i><span>Pengajuan Surat</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="padding-left: 25px">
                            <li><a href="{{url('surat')}}">Pengajuan Surat Personal</a></li>
                            <li><a href="{{url('suratPublic')}}">Pengajuan Surat Publik</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-cart"></i><span>Belanja</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu " style="padding-left: 25px">
                            <li><a href="{{url('katalog')}}">Katalog</a></li>
                            @if (Auth::user()->id_role == 10)
                                <li><a href="{{url('transaksi')}}">Transaksi</a></li>
                            @endif
                            <li><a href="{{url('pesanan')}}">Pesanan Anda</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="{{url('kalender')}}"><i class="fa fa-calendar"></i><span>Kalendar</span><span class="label label-danger pull-right" id="notifKalender"></span></a>
                    </li>
                    <li>
                        <a href="{{url('pesan')}}"><i class="fa fa-comment"></i><span>Pesan</span></a>
                    </li>
                @endif
                @if(Auth::user()->id_role == 9)
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-laptop"></i><span>Administrasi</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="padding-left: 25px">
                            <li><a href="{{url('tagihan')}}">Tagihan</a></li>
                        </ul>
                    </li>

                @elseif(Auth::user()->id_role == 4 || Auth::user()->id_role == 5)
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-laptop"></i><span>Administrasi</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="padding-left: 25px">
                            <li><a href="{{url('suratArsip')}}">Arsip Pengajuan Surat</a></li>
                        </ul>
                    </li>
                        <li class="treeview">
                            <a href="{{url('nopenting')}}"><i class="fa fa-phone-square"></i><span>Nomor Penting</span>
                            </a>
                        </li>
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @yield('isi')


    </div> <!--.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">

        </div>
        <strong>Copyright &copy; 2016 <a href="">Tomatech Mobile Dev</a>.</strong>
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{asset('style/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('style/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('style/plugins/morris/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('style/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->

<!-- jQuery Knob Chart -->
<script src="{{asset('style/plugins/knob/jquery.knob.js')}}"></script>

<!-- datepicker -->
<script src="{{asset('style/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('style/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('style/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('style/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('style/plugins/fastclick/fastclick.min.js')}}"></script>
<script src="{{asset('style/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('style/plugins/select2/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('style/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('style/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('style/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{asset('style/plugins/daterangepicker/daterangepicker.js')}}'"></script>
<!-- AdminLTE App -->
<script src="{{asset('style/dist/js/app.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('style/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('style/dist/js/demo.js')}}"></script>

<script src="{{asset('style/plugins/select2/select2.full.min.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('style/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('style/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

</body>
</html>
<script>
    $(function () {
        setNavigation();
    });

    function setNavigation() {
        var path = window.location.pathname;
        path = path.replace(/\/$/, "");
        path = decodeURIComponent(path);

        $(".nav a").each(function () {
            var href = $(this).attr('href');
            if (path.substring(0, href.length) === href) {
                $(this).closest('li').addClass('active');
            }
        });
    }

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip()
    });


   /* var auto_refresh = setInterval(function (){
        $('#notif').load("/rumahwarga/public/notif/notif");
    },1000);

    function notifClick(){
        $('#notif').hide();
        $('#listNotif').load("/rumahwarga/public/notif/list-notif");
    }
*
    var auto_refresh = setInterval(function (){
        $('#notifPesan').load("/rumahwarga/public/pesan/notif-pesan");
    },1000);

    function notifPesanClick(){
        $('#notifPesan').hide();
        $('#listNotifPesan').load("/rumahwarga/public/pesan/list-notif-pesan");
    }




</script>
