<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/16/2016
 * Time: 21:06
 */

namespace App\Http\Controllers;


use App\Models\Belanja\TransaksiModel;
use App\Models\Pesan\PesanModel;
use App\Models\Surat\SuratModel;
use App\Models\Tagihan\Users_TagihanModels;
use Illuminate\Database\QueryException;

class NotifikasiController extends Controller{
    public function getNotif(TransaksiModel $transaksiModel){
        try {
            $penjual = $transaksiModel->getNotifPenjual();
            $pembeli = $transaksiModel->getNotifPembeli();

            $count = count($penjual) + count($pembeli);

            if ($count > 0)
                $html = $count;
            else
                $html = "";
            return $html;
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            return null;
        }
    }

    public function getListNotif(TransaksiModel $transaksiModel){
        try{
            $penjual = $transaksiModel->getNotifPenjual();
            $pembeli = $transaksiModel->getNotifPembeli();


            $html = '';

                if (count($pembeli) > 0) {
                    foreach ($pembeli as $row) {
                        $html .=
                            '<li><a href=' . url("transaksi/detail-pesanan/" . $row->id_detail_transaksi) . '>
                            <i class="fa fa-shopping-cart text-danger"></i>Pesanan ditolak penjual ' .
                            $row->name
                            . '</li>';
                    }
                } else {
                    $html .= '';
                }

                if (count($penjual) > 0) {
                    foreach ($penjual as $row) {
                        $html .=
                            '<li><a href=' . url("transaksi/detail-transaksi/" . $row->id_detail_transaksi) . '>
                            <i class="fa fa-shopping-cart text-aqua"></i>Pesanan Belum dikonfirmasi dari ' .
                            $row->name
                            . '</li>';
                    }
                }else{
                    $html .='';
                }


            if($html == '')
                $html = '<div class="text-center margin">Tidak Ada Pemberitahuan</div>';

            return $html;
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            return null;
        }
    }



}