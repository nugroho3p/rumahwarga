<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/17/2016
 * Time: 20:19
 */

namespace App\Http\Controllers\Belanja;


use App\Http\Controllers\Controller;
use App\Models\Belanja\BarangModel;
use App\Models\Belanja\DetailBarangModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller{
    public function getIndex(DetailBarangModel $detailBarangModel){
        if(Auth::check()){
            $data = [
                'produk' => $detailBarangModel->getProdukPenjual()
            ];
            return view('belanja.produk', $data);
        }else {
            return redirect('login');
        }
    }

    public function getTambah(){
        $id_barang = DB::table('detail_barang')
            ->where('id_penjual','=',Auth::user()->id)
            ->select('id_barang')
            ->get();

        $row = [];
        foreach($id_barang as $key => $detailbarang) {
            $row[] = $detailbarang->id_barang;
        }

        $produk = DB::table('barang')
            ->whereNotIn('id_barang',$row)
            ->select('id_barang','nama_barang')
            ->get();

        $barang = [];
        foreach($produk as $key => $namabarang) {
            $barang[] = $namabarang->nama_barang;
        }

        $data = [
            'barang' => json_encode($barang),
            'produk' => $produk
        ];

        return view('Belanja.tambahProduk',$data);
    }

    public function postTambah(Request $request){
        try {

            $data = new DetailBarangModel();
            $data->id_barang = $request->input('produk');
            $data->ukuran = $request->input('ukur');
            $data->harga = $request->input('harga');
            $data->stok = $request->input('stok');
            $data->id_penjual = Auth::user()->id;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            //print_r('<pre>' .$data. '</pre>'); exit();
            $data->save();


            Session::flash('flash_message','Produk berhasil ditambah.');
            return redirect('produk/tambah');
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');
            return redirect('produk/tambah');
        }
    }

    public function postBaru(Request $request){
        try{
            $data = new BarangModel();
            $data->nama_barang = $request->input('nama_barang');
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            if($request->hasFile('gambar')){

                $file = Input::file('gambar');
                $name = time(). '-' .$file->getClientOriginalName();
                $path = 'dist/img/produk';

                $unLink = 'dist/img/produk'.$request->input('image_old');
                if(file_exists($unLink) && $file->getClientOriginalName() != "" && $request->input('image_old')){
                    unLink($unLink);
                }

                $file->move($path, $name);
                $data->gambar = $name;
            };

            $data->save();
            \Session::flash('flash_message','Produk berhasil ditambah.');
            return redirect('produk/tambah');
        }catch (QueryException $e){
            \Log::error($e->getMessage());

        }
    }

    public function postUpdate(Request $request){
        try {
            DB::table('detail_barang')
                ->where('id_detail_barang', '=', $request->input('id'))
                ->update([
                    'harga' => $request->input('harga'),
                    'stok' => $request->input('stok')
                ]);
            Session::flash('flash_message','Produk berhasil diupdate.');

            return redirect('produk');
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('produk');
        }
    }

    public function postHapus($id_detail_barang){
        try {
            DetailBarangModel::find($id_detail_barang)->delete();
            Session::flash('flash_message','Produk berhasil dihapus.');
            return redirect('produk');

        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('produk');
        }
    }

    public function getDaftarProduk(BarangModel $barangModel){
        $dataBarang = $barangModel->getProduk();
        $data = [
            'data' => $dataBarang
        ];
        return view ('belanja.daftarProduk',$data);
    }

    public function postHapusBarang(Request $request){
        try {
            DB::table('barang')
                ->where('id_barang', '=', $request->input('id'))
                ->delete();
            Session::flash('flash_message','Produk berhasil dihapus.');
            return redirect('produk/daftar-produk');

        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('produk/daftar-produk');
        }
    }

    public function postUpdateBarang(Request $request){
        try {
            DB::table('barang')
                ->where('id_barang', '=', $request->input('id'))
                ->update([
                    'nama_barang' => $request->input('harga'),
                    'gambar' => $request->input('stok')
                ]);
            Session::flash('flash_message','Produk berhasil diupdate.');

            return redirect('produk/daftar-barang');
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('produk/daftar-barang');
        }
    }
}