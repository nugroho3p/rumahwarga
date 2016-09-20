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
    return redirect('dashboard');

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
        'lokasi' => 'Peta\LokasiController',
        'profil' => 'Profil\ProfileController',
        'pengguna' => 'Pengguna\PenggunaController',
        'keluarga' => 'Keluarga\KeluargaController',
        'pekerja' => 'Pekerja\PekerjaController',
        'peta' => 'Peta\PetaController',
        'petaAdmin' => 'Peta\PetaAdminController',
        'konversi' => 'Peta\KonversiController',
        'menu' => 'Role\MenuController',
        'akun' => 'Role\AkunController',
        'notif' => 'NotifikasiController',
        'pesanan' => 'Belanja\PesananController',
        'produk' => 'Belanja\ProdukController',
        'pesan'=>'Pesan\PesanController',
        'pesanTerkirim'=>'Pesan\PesanTerkirimController',
        'kalender' => 'Kalender\KalenderController',
        'lapor' => 'Pesan\LaporController',

    ]);
    Route::get('/home', 'HomeController@index');
});
