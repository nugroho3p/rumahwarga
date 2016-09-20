<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/13/2016
 * Time: 00:47
 */

namespace App\Http\Controllers\Belanja;


use App\Models\Belanja\DetailTransaksiModel;
use App\Models\Belanja\TransaksiModel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller{

    public function getIndex(TransaksiModel $transaksiModel){
        if(Auth::check()){
            $data = [
                "transDetail" => $transaksiModel->getTransDetail()->get(),
                "transPembeli" => $transaksiModel->getTransPembeli()->get()
            ];

            return view("belanja.transaksi", $data);
        }else {
            return redirect('login');
        }

    }

    public function getDetailTransaksi($id_detail_transaksi, TransaksiModel $transaksiModel){
        return view("belanja.detailTransaksi")
            ->with('data',
                $transaksiModel->getTransDetail()
                    ->where('detail_transaksi.penjual','=',Auth::user()->id)
                    ->where('id_detail_transaksi','=',$id_detail_transaksi)
                    ->first()
            );
    }

    public function getDetailPesanan($id_detail_transaksi, TransaksiModel $transaksiModel){
        return view("belanja.detailTransaksi")
            ->with('data',
                $transaksiModel->getTransDetail()
                    ->where('transaksi.pembeli','=',Auth::user()->id)
                    ->where('id_detail_transaksi','=',$id_detail_transaksi)
                    ->first()
            );
    }

    public function postKonfirmasi(Request $request){
        try {
            DB::table('detail_transaksi')
                ->where('id_detail_transaksi', '=', $request->input('id'))
                ->update(['status' => 'Sedang diproses']);
            Session::flash('flash_message','Pesanan berhasil di konfirmasi.');

            return redirect('transaksi');

        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('transaksi');
        }
    }

    public function postBatal(Request $request){
        try {
            DB::table('detail_transaksi')
                ->where('id_detail_transaksi', '=', $request->input('id'))
                ->update(['status' => 'Transaksi dibatalkan']);
            Session::flash('flash_message','Pesanan berhasil dibatalkan.');

            DB::table('detail_barang')->where('id_detail_barang','=',$request->input('id_det_barang'))
                ->increment('stok', $request->input('qty'));

            return redirect('transaksi');
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('transaksi');
        }
    }

    public function postHapus(Request $request){
        try {
            DB::table('detail_transaksi')
                ->where('id_detail_transaksi', '=', $request->input('id'))
                ->delete();
            Session::flash('flash_message','Pesanan berhasil dihapus.');
            return redirect('transaksi/riwayat');

        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('transaksi/riwayat');
        }
    }

    public function getRiwayat(TransaksiModel $transaksiModel){
        try{
            $data = [
                "data" => $transaksiModel->getRiwayatTrans()->get(),
                "total" => $transaksiModel->getRiwayatTrans()->sum('sub_total')
            ];

            return view('belanja.riwayat_trans',$data);
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan.');

            return redirect('transaksi');
        }
    }
}