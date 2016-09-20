<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|

*/

    Route::get('/', function () {
        return redirect('login');

    });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::controllers([
        'dashboard' => 'DashboardController',
        'katalog'=> 'Belanja\BelanjaController',
        'transaksi' => 'Belanja\TransaksiController',
        'kalender' => 'Kalender\KalenderController',
        'lokasi' => 'Peta\LokasiController',
        'tagihan' => 'Tagihan\TagihanController',
        'profil' => 'Profil\ProfileController',
        'pengguna' => 'Pengguna\PenggunaController',
        'surat' => 'Surat\SuratController',
        'keluarga' => 'Keluarga\KeluargaController',
        'pekerja' => 'Pekerja\PekerjaController',
        'hirarki' => 'Surat\HirarkiController',
        'peta' => 'Peta\PetaController',
        'suratPublic' => 'Surat\SuratPublicController',
        'jenistagihan' => 'Tagihan\JenisTagihanController',
        'petaAdmin' => 'Peta\PetaAdminController',
        'konversi' => 'Peta\KonversiController',
        'pesan'=>'Pesan\PesanController',
        'pesanTerkirim'=>'Pesan\PesanTerkirimController',
        'event' => 'Kalender\EventController',
        'menu' => 'Role\MenuController',
        'akun' => 'Role\AkunController',
        'detailTagihan' => 'Tagihan\DetailTagihanController',
        'suratValidasi' => 'Surat\SuratValidasiController',
        'nopenting' => 'NomorPenting\NoPentingController',
        //'notif' => 'NotifikasiController',
        'pesanan' => 'Belanja\PesananController',
        'produk' => 'Belanja\ProdukController',

    ]);
    Route::get('/home', 'HomeController@index');
});
