<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/9/2016
 * Time: 13:21
 */

namespace App\Http\Controllers\Peta;

use App\Models\Peta\DetailPetaModel;
use App\Models\Peta\KlasterModel;
use App\Models\Peta\PetaModel;
use App\Models\Warga\WargaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;


class PetaController extends Controller {
    public function getIndex(){
        if(Auth::guest()){
            return redirect('login');
        }else {
            if (Auth::user()->id == 2) {
                $data = [
                    "peta" => $peta = PetaModel::all()
                ];
                return view('peta.petaAdmin', $data);
            } else {

                $peta = DB::table('peta')->join('klaster', 'peta.id_klaster', '=', 'klaster.id_klaster')
                    ->join('users', 'klaster.id_klaster', '=', 'users.id_klaster')
                    ->select('peta.*', 'klaster.*')
                    ->where('klaster.id_klaster', '=', Auth::user()->id_klaster)
                    ->first();

                $warga = DB::table('detail_peta')
                    ->whereNotNull('id_warga')
                    ->get();

                $wargaID = [];
                foreach ($warga as $key => $row) {
                    $wargaID[] = $row->id_warga;
                }

                $dataWarga = WargaModel::where("status", "=", "Kepala Keluarga")
                    ->where('id_klaster', '=', $peta->id_klaster)
                    ->get();

                $detailpeta = DB::table('detail_peta')
                    ->where('id_peta', '=', $peta->id_peta)
                    ->select('detail_peta.kode_svg', 'detail_peta.warna')
                    ->get();

                $colors = [];
                foreach ($detailpeta as $data) {
                    $colors[$data->kode_svg] = "'" . $data->warna . "'";
                }
                $data = [
                    "getDataWarga" => $dataWarga,
                    "peta" => $peta,
                    "colors" => json_encode($colors),
                    "wargaID" => json_encode($wargaID)
                ];
                return view('peta.peta', $data);
            }
        }
    }

    public function getInfo($kode_svg){
        try {
            $detail = new DetailPetaModel();
            $obj = $detail->getDetail($kode_svg);
            if (count($obj) > 0){
                return Response::json(array(
                    'success' => true,
                    'jenis'   => $obj->jenis,
                    'alamat' => $obj->alamat,
                    'nomor_rumah' =>$obj->no_rumah,
                    'id_warna' => $obj->id_warna,
                    'pemilik' => $obj->id_warga,
                    'warna' => $obj->warna,
                ));
            }else{
                return Response::json(array(
                    'success' => false
                ));
            }
        }catch (QueryException  $e) {
            Log::error($e->getMessage());
            return redirect('/peta');
        }
    }

    public function getColor(){
        try{
            $detail = new DetailPetaModel();
            $obj = $detail->getDataColor();
            return Response::json($obj);
        } catch (QueryException $e){
            \Log::error($e->getMessage());
            return redirect('/peta');
        }
    }

    public function getDelete($kode_svg){
        try {
            $detail = new DetailPetaModel();
            $obj = $detail->getDelete($kode_svg);
            if (count($obj) > 0) {
                $obj->delete();
                Session::flash('delete_message','Data Berhasil dihapus');
                return redirect('/peta');
            } else {
                return redirect('/peta')->withErrors([
                    'Data tidak ditemukan'
                ]);
            }
        } catch (QueryException  $e) {
            \Log::error($e->getMessage());
            return redirect('/peta')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    }

    public function postSubmit(Request $request){
        try{
            $data=DetailPetaModel::findOrNew($request->input("kode_svg"));
            $data->kode_svg = $request->input("kode_svg");
            $data->no_rumah = $request->input("nomor_rumah");
            $data->alamat = $request->input("alamat");
            $data->id_warna = $request->input("jenis");
            $data->id_warga = $request->input("pemilik");
            $data->id_peta = $request->input("id_peta");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            switch ($request->input("jenis")){
                case "1":
                    $data->jenis = "Rumah";
                    $data->warna = "#e53939";
                    break;
                case "2":
                    $data->jenis = "Kavling";
                    $data->warna = "#f2d5d5";
                    break;
                case "3":
                    $data->jenis = "Toko";
                    $data->warna = "#4b74dd";
                    break;
                case "4":
                    $data->jenis = "Taman";
                    $data->warna = "#50aa53";
                    break;
                case "5":
                    $data->jenis = "Lapangan";
                    $data->warna = "#e09d38";
                    break;
                case "6":
                    $data->jenis = "Jalan";
                    $data->warna = "#bcb7a9";
                    break;
                case "7":
                    $data->jenis = "Tempat Ibadah";
                    $data->warna = "#e0d93c";
                    break;
                case "8":
                    $data->jenis = "Pos Satpam";
                    $data->warna = "#444444";
                    break;
            }

            $data->save();
            Session::flash('flash_message','Data Berhasil ditambahkan.');
            return redirect("peta");//->with('flash_message','Data Berhasil ditambahkan.');
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            Session::flash('error_message','Gagal menyimpan. Coba ulangi');
            return redirect('/peta');
        }
    }

    public function postDeletePeta($id_peta){
        try {
            $peta = PetaModel::find($id_peta);
            $det_peta = DetailPetaModel::where('id_peta','=', $id_peta)->get();
            if (count($det_peta) > 0) {
                if ($det_peta->delete())
                    $peta->delete();
                \Session::flash('flash_message', 'Data Berhasil dihapus.');
                return redirect('peta');
            } else if(count($peta) > 0 &&count($det_peta) == 0){
                $peta->delete();
                return redirect('peta');
            } else {
                \Session::flash('error_message','Data tidak ditemukan');
                return redirect('peta');
            }
        } catch (QueryException  $e) {
            Log::error($e->getMessage());
            \Session::flash('error_message','Terjadi kesalahan cobalah beberapa saat lagi');
            return redirect('peta');
        }
    }

    public function getDataPeta($id_peta, PetaModel $petaModel, KlasterModel $klasterModel){
        if(Auth::guest()){
            return redirect('login');
        }else {
            $peta = $petaModel->getPeta($id_peta);
            $klaster = $klasterModel->getDataKlaster($peta->id_klaster);

            return view('peta.dataPeta')->with([
                'peta' => $peta,
                'klaster' => $klaster
            ]);
        }
    }

    public function getUbahPeta($id_peta){
        $klas = PetaModel::select('id_klaster')->get();
        $data =[
            'data' => $peta = DB::table('peta')->where('id_peta','=',$id_peta)->first(),
            'getKlaster' => $dataKlaster = KlasterModel::whereNotIn('id_klaster', $klas)->get()
        ];

        return view('peta.ubahpeta',$data);
    }
    

}