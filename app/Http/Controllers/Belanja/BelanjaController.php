<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/3/2016
 * Time: 22:46
 */

namespace App\Http\Controllers\Belanja;

use App\Models\Belanja\BarangModel;
use App\Models\Belanja\DetailTransaksiModel;
use App\Models\Belanja\TransaksiModel;
use App\Models\Peta\DetailPetaModel;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BelanjaController extends Controller{

    public function getIndex(BarangModel $barangModel, Request $request){
        if(Auth::check()){
            $barang = $barangModel->getDataSearch($request->get("search"));
            $data = [
                "barang"    => $barang,
                "keranjang" => $barangModel->keranjang(),
            ];
            return view('belanja.belanja', $data);
        }else {
            return redirect('login');
        }
    }

    public function getDetailBarang(BarangModel $barangModel, $id_barang){
        if(Auth::check()){
            $detail_barang = [
                "ukuran"        => $barangModel->getUkuran($id_barang),
                "detail_barang" => $barangModel->getDetail($id_barang),
                "penjual"       => $barangModel->getUkuranBarang($id_barang),
                "keranjang"     => $barangModel->keranjang()
            ];
            return view('belanja.detailBarang', $detail_barang);
        }else {
            return redirect('login');
        }
    }

    public function getKeranjangBelanja(BarangModel $barangModel){
        if(Auth::check()){
            return view('belanja.keranjangBelanja')->with('keranjang', $barangModel->keranjang());
        }else {
            return redirect('login');
        }
    }

    public function postAddCart(Request $request)
    {
        try {
            $id_detail_barang = $request->input('id_detail_barang');
            $jumlah_barang = $request->input('jumlah');
            $nama_barang = $request->input('nama_barang');
            $harga = $request->input('harga');
            $penjual = $request->input('penjual');
            $penjualID = $request->input('penjualID');

            DB::table('detail_barang')->where('id_detail_barang','=',$id_detail_barang)
                ->decrement('stok',$jumlah_barang);

            $data = array(
                'id' => $id_detail_barang,
                'name' => $nama_barang,
                'qty' => $jumlah_barang,
                'price' => $harga,
                'options' => array(
                    'seller' => $penjual,
                    'sellerID' => $penjualID
                )
            );
            Cart::add($data);

            Session::flash('flash_message', 'Barang berhasil ditambahkan ke keranjang belanja.');
            return redirect('katalog');

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            Session::flash('error_message', 'Terjadi kesalahan. Mohon coba beberapa saat lagi');
            return redirect('katalog');
        }
    }

    public function getRemoveItem($id, $qty){
        $rowId = Cart::search(array('id' => $id));

        DB::table('detail_barang')->where('id_detail_barang','=',$id)
            ->increment('stok',$qty);

        Cart::remove($rowId[0]);
        return redirect("katalog/keranjang-belanja");
    }

    public function getPesan(){
        try{
            $transaksi = new TransaksiModel();
            $items = Cart::content();

            $transaksi->jumlah_barang = Cart::count();
            $transaksi->total_harga = Cart::total();
            $transaksi->pembeli = Auth::user()->id;
            $transaksi->created_by = Auth::user()->id;
            $transaksi->updated_by = Auth::user()->id;
            $transaksi->save();

            foreach($items as $row){
                $det_trans = new DetailTransaksiModel();
                $det_trans->id_detail_barang = $row->id;
                $det_trans->kuantitas = $row->qty;
                $det_trans->sub_total = $row->subtotal;
                $det_trans->penjual = $row->options->sellerID;
                $det_trans->status = "Belum dikonfirmasi";
                $det_trans->created_by = Auth::user()->id;
                $det_trans->updated_by = Auth::user()->id;
                $transaksi->DetailTransaksi()->save($det_trans);
            }

            Cart::destroy();
            Session::flash('flash_message','Pemesanan berhasil dan sedang diproses.');
            return redirect('pesanan');
        }catch (QueryException $e){
            Log::error($e->getMessage());
            Session::flash('error_message','Terjadi kesalahan. Mohon ulangi beberapa saat lagi.');
            return redirect('pesanan');
        }
    }

    public function getPenjual(BarangModel $barangModel, $id_barang, $ukuran){
        $data = $barangModel->getBarangUkur($id_barang, $ukuran);

        $html = '
            <thead>
                <tr>
                    <th>Penjual</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Pesan</th>
                </tr>
            </thead>
            <tbody>';


        foreach($data as $row) {
            $html .= '

                <tr>


                    <td>' . $row->name . '</td>
                    <td>Rp. ' . $row->harga . '</td>
                    <td>' . $row->stok . '</td>

                    <td class="col-md-4">
                        <form role="form" method="POST" action="'. url('katalog/add-cart').'">
                        <input type="hidden" name="_token" value="'. csrf_token() .'">
                        <input name="id_detail_barang" type="hidden"  value="'.$row->id_detail_barang.'">
                        <input name="id_transaksi" type="hidden">
                        <input name="penjual" type="hidden" value="'.$row->name.'">
                        <input name="penjualID" type="hidden" value="'.$row->id.'">
                        <input name="nama_barang" type="hidden" value="'.$row->nama_barang.'">
                        <input id="stok'.$row->id_detail_barang.'" name="stok" type="hidden" value="'.$row->stok.'">
                        <input id="harga'.$row->id_detail_barang.'" name="harga" type="hidden" value="'.$row->harga.'">

                        <div class="input-group input-group-sm flat">
                            <input id="jumlah'.$row->id_detail_barang.'" name="jumlah" type="number" class="form-control flat" min="0" max="'.$row->stok.'"><br>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat" data-toggle="tooltip" title="Masukan kekeranjang" data-placement="right">
                                <i class="fa fa-shopping-cart"></i></button>
                            </span>
                        </div><!-- /input-group -->
                        </form>
                    </td>
                    </tr>

                </tbody>';
        }

        return $html;
        //return $data;
    }
}