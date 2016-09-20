<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 4/14/2016
 * Time: 2:55 PM
 */

namespace App\Http\Controllers\Pesan;


use App\Http\Controllers\Controller;
use App\Models\Warga\WargaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesanTerkirimController extends Controller {
    public function getIndex()
    {
        $warga = WargaModel::where("id_klaster", "=", Auth::user()->id_klaster)
            ->whereNotIn('id', [2, 3])->get();

        $join = DB::table('users as tbl1')->join('pesan', 'tbl1.id', '=', 'pesan.id_penerima')
            ->join('users as tbl2', 'tbl2.id', '=', 'pesan.id_pengirim')
            ->where('pesan.id_pengirim', '=', Auth::user()->id)
            ->where('pesan.parent','=',null)
            ->select('tbl1.*', 'tbl2.*', 'pesan.*', 'tbl1.name as penerima', 'tbl2.name as pengirim')
            ->orderBy('pesan.created_at','desc')
            ->get();

        if(count($join) > 10 ) {
            $pesan = DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
                ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
                ->where('pesan.id_pengirim','=',Auth::user()->id)
                ->where('pesan.parent','=',null)
                ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima')
                ->orderBy('pesan.created_at','desc')
                ->paginate(10);;
            $p = true;
        }
        else{
            $pesan = $join;
            $p = false;
        }

        $data =[
            "getDataWarga" => $warga,
            "join" => $pesan,
            "p" => $p
        ];
        return view('pesan.pesanterkirim', $data);
    }
        public function postSubmit(Request $request){



    }

    public function getDownload($namaFile){
        return response()->file(public_path('dist/pesan/'.$namaFile));
    }

    public function getHapus($id_pesan)
    {
        try {
            $pesan = PesanModel::findOrNew($id_pesan);
            if (count($pesan) > 0) {
                $pesan->delete();
                return redirect('/pesan/pesan')->with('Sukses dihapus');
            } else {
                return redirect('/pesan')->withErrors([
                    'Data tidak ditemukan'
                ]);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect('/pesan')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    }



}


