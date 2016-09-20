<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/17/2016
 * Time: 01:54
 */

namespace App\Http\Controllers\Belanja;



use App\Http\Controllers\Controller;
use App\Models\Belanja\TransaksiModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PesananController extends Controller{
    public function getIndex(TransaksiModel $transaksiModel){
        if(Auth::check()){
            $pesanan = $transaksiModel->getTransPembeli()->get();
            return view('belanja.pesanan')->with('pesanan', $pesanan);
        }else {
            return redirect('login');
        }
    }

    public function postKonfirmasi(Request $request)
    {
        try {
            DB::table('detail_transaksi')
                ->where('id_detail_transaksi', '=', $request->input('id'))
                ->update([
                    'status' => 'Transaksi Berhasil',
                ]);
            Session::flash('flash_message', 'Transasksi telah berhasil.');
            return redirect('pesanan');
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('pesanan');
        }
    }

    public function postBatal(Request $request){
        try {
            DB::table('detail_transaksi')
                ->where('id_detail_transaksi', '=', $request->input('id'))
                ->update(['status' => 'Transaksi dibatalkan']);

            DB::table('detail_barang')->where('id_detail_barang','=',$request->input('id_det_barang'))
                ->increment('stok', $request->input('qty'));

            Session::flash('flash_message','Pesanan berhasil dibatalkan.');

            return redirect('pesanan');
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('pesanan');
        }
    }

    public function postHapus(Request $request){
        try {
            DB::table('detail_transaksi')
                ->where('id_detail_transaksi', '=', $request->input('id'))
                ->delete();
            Session::flash('flash_message','Pesanan berhasil dihapus.');
            return redirect('pesanan');

        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('pesanan');
        }
    }

    public function getRiwayat(TransaksiModel $transaksiModel){
        try{
            $data = [
                "data" => $transaksiModel->getRiwayatPesan()->get()
            ];

            return view('belanja.riwayat_pesan',$data);
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('pesanan');
        }
    }
}