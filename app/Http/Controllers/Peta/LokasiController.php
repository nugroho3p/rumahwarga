<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 04-Feb-16
 * Time: 01:41 PM
 */

namespace App\Http\Controllers\Peta;

use App\Models\Peta\KecamatanModel;
use App\Models\Peta\KelurahanModel;
use App\Models\Peta\KlasterModel;
use App\Models\Peta\KotaModel;
use App\Models\Peta\NegaraModel;
use App\Models\Peta\ProvinsiModel;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LokasiController extends Controller {

    public function getNegara(NegaraModel $negaraModel){
        $data = $negaraModel->getData();
        return view('lokasi.negara')->with([
            'data' => $data
        ]);
    }

    public function postSubmitNeg(Request $request){
        try{
            $data=NegaraModel::findOrNew($request->input("id_negara"));
            $data->nama_negara = $request->input("nama_negara");
            $data->kode_negara = $request->input("kode_negara");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("lokasi/negara");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/lokasi/negara')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postDeleteNegara($id_negara){
        NegaraModel::find($id_negara)->delete();
        return redirect('lokasi/negara');
    }

    public function getProvinsi(ProvinsiModel $provinsiModel){
        $data = $provinsiModel->getData();
        return view('lokasi.provinsi')->with([
            'data' => $data,
            'getDataNeg' => $dataNeg = NegaraModel::all()
        ]);
    }

    public function postSubmitProv(Request $request){
        try{
            $data=ProvinsiModel::findOrNew($request->input("id_prov"));
            $data->id_negara = $request->input("id_negara");
            $data->nama_prov = $request->input("nama_prov");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("lokasi/provinsi");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/lokasi/provinsi')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postDeleteProvinsi($id_prov){
        ProvinsiModel::find($id_prov)->delete();
        return redirect('lokasi/provinsi');
    }

    public function getKota(KotaModel $kotaModel){
        $data = $kotaModel->getData();
        return view('lokasi.kota')->with([
            'data' => $data,
            "getDataProv" => ProvinsiModel::all()
        ]);
    }

    public function postSubmitKota(Request $request){
        try{
            $data=KotaModel::findOrNew($request->input("id_kota"));
            $data->id_prov = $request->input("id_prov");
            $data->nama_kota = $request->input("nama_kota");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("lokasi/kota");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/lokasi/kota')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postDeleteKota($id_kota){
        KotaModel::find($id_kota)->delete();
        return redirect('lokasi/kota');
    }

    public function getKecamatan(KecamatanModel $kecamatanModel){
        $data = $kecamatanModel->getData();
        return view('lokasi.kecamatan')->with([
            'data' => $data,
            "getDataKot" => KotaModel::all()
        ]);
    }

    public function postSubmitKec(Request $request){
        try{
            $data=KecamatanModel::findOrNew($request->input("id_kec"));
            $data->id_kota = $request->input("id_kota");
            $data->nama_kec = $request->input("nama_kec");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("lokasi/kecamatan");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/lokasi/kecamatan')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postDeleteKecamatan($id_kec){
        KecamatanModel::find($id_kec)->delete();
        return redirect('lokasi/kecamatan');
    }

    public function getKelurahan(KelurahanModel $kelurahanModel){
        $data = $kelurahanModel->getData();
        return view('lokasi.kelurahan')->with([
            'data' => $data,
            "getDataKec" => KecamatanModel::all()
        ]);
    }

    public function postSubmitKel(Request $request){
        try{
            $data=KelurahanModel::findOrNew($request->input("id_kel"));
            $data->id_kec = $request->input("id_kec");
            $data->nama_kel = $request->input("nama_kel");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("lokasi/kelurahan");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/lokasi/kelurahan')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postDeleteKelurahan($id_kel){
        KelurahanModel::find($id_kel)->delete();
        return redirect('lokasi/kelurahan');
    }

    public function getKlaster(KlasterModel $klasterModel){
        $data = $klasterModel->getData();
        return view('lokasi.klaster')->with([
            'data' => $data,
            "getDataKel" => KelurahanModel::all()
        ]);
    }

    public function postSubmitKlas(Request $request){
        try{
            $data=KlasterModel::findOrNew($request->input("id_klaster"));
            $data->id_kel = $request->input("id_kel");
            $data->nama_klaster = $request->input("nama_klaster");
            $data->alamat = $request->input("alamat");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("lokasi/klaster");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/lokasi')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postDeleteKlaster($id_klaster){
        KlasterModel::find($id_klaster)->delete();
        return redirect('lokasi/klaster');
    }

    public function getIndex()
    {
        $dataNeg = NegaraModel::all();
        $dataProv = ProvinsiModel::all();
        $dataKot = KotaModel::all();
        $dataKec = KecamatanModel::all();
        $dataKel = KelurahanModel::all();
        $dataKlas = KlasterModel::all();
        $satuLokasi = [
            "getDataNeg" => $dataNeg,
            "getDataProv" => $dataProv,
            "getDataKot" => $dataKot,
            "getDataKec" => $dataKec,
            "getDataKel" => $dataKel,
            "getDataKlas" => $dataKlas
       ];


        return view("peta.lokasi",$satuLokasi);

    }

}