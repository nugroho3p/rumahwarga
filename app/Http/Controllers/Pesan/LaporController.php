<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 5/24/2016
 * Time: 2:06 PM
 */

namespace App\Http\Controllers\Pesan;

use App\Models\Kalender\KegiatanModel;
use App\Models\Kalender\Users_KegiatanModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Pesan\LaporModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporController extends Controller{

    public function getIndex(){
        return view('pesan.pesanlapor');
    }

    public function postSubmit(Request $request){
        try{
            $pj = DB::table('users')
                ->where('id_klaster', '=', Auth::user()->id_klaster)
                ->where('id_role', '=', 2)
                ->first();

            $lapor = new LaporModel();

            $lapor->isi = $request->input("isi");
            $lapor->kategori = $request->input("kategori");
            $lapor->target = $request->input("target");
            $lapor->status = "Belum Diproses";
            $lapor->id_pengirim = Auth::user()->id;
            $lapor->id_penerima = $pj->id;
            $lapor->created_by = Auth::user()->id;
            $lapor->updated_by = Auth::user()->id;

            $lapor->save();

            \Session::flash('flash_message','Pelaporan Berhasil Dikirim.');
            return redirect("kalender");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/kalender')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postSubmitRespon(Request $request){
        try{
            DB::table('laporan')
                ->where('id_lapor','=',$request->input("id_lapor"))
                ->update([
                   'status' => 'Sudah Diproses',
                    'isi' => $request->input('isi'),
                    'id_penerima' => $request->input('id_penerima')
                ]);

            return view('pesan.arsiplapor');
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/lapor/arsip/')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postHapus(Request $request)
    {
        try {
            //$pesan = PesanModel::where('id_pesan','=',$id_pesan);
            $id_lapor = $request->input('id_lapor');


            DB::table('laporan')
                ->where('id_lapor','=',$id_lapor)
                ->delete();
            return redirect('/lapor/arsip/')->with('Sukses dihapus');

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect('/lapor/arsip')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    }

    public function getBaca($id_lapor){
        $join = DB::table('users as tbl1')->join('laporan','tbl1.id','=','laporan.id_pengirim')
            ->join('users as tbl2','tbl2.id','=','laporan.id_penerima')
            ->where('laporan.id_penerima','=',Auth::user()->id)
            ->where('laporan.id_lapor','=',$id_lapor)
            ->select('tbl1.*','tbl2.*','laporan.*','tbl1.name as pengirim','tbl2.name as penerima')
            ->get();

        $data =[
            "getLapor" => $join
        ];
        return view('pesan.pesanlaporbaca',$data);
    }

    public function getArsip(){
        $join = DB::table('users as tbl1')->join('laporan','tbl1.id','=','laporan.id_pengirim')
            ->join('users as tbl2','tbl2.id','=','laporan.id_penerima')
            ->select('tbl1.*','tbl2.*','laporan.*','tbl1.name as pengirim','tbl2.name as penerima')
            ->get();

        $data =[
            "getLapor" => $join
        ];
        return view('pesan.arsiplapor',$data);
    }

    public function getDetailLapor($target){
        try{
            $kegiatan = DB::table('kegiatan')
                ->join('users','users.id','=','kegiatan.id_pembuat')
                ->join('laporan','kegiatan.id_kegiatan','=','laporan.target')
                ->where('id_kegiatan','=',$target)
                ->first();
            $data = [
                "data" => $kegiatan,
                "id_lapor" => $kegiatan->id_lapor
            ];

            return view('pesan.detaillaporan',$data);

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect('/lapor/arsip')->withErrors([
            'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }

    }

    public function getDelete($id_kegiatan,$id_lapor)
    {
        try {
            $kegiatan = KegiatanModel::find($id_kegiatan);
            $relasi  = Users_KegiatanModel::where('id_kegiatan',$id_kegiatan);

            if (count($relasi) > 0) {
                if($relasi->delete())
                    $kegiatan->delete();
                DB::table('laporan')->where('id_lapor','=',$id_lapor)
                    ->update(['status' => 'Sudah Diproses']);

                \Session::flash('flash_message','Data Berhasil Dihapus.');
                return redirect('/lapor/arsip')->with('Sukses dihapus');
            } else if(count($kegiatan) > 0 &&count($relasi) ==0 ) {
                $kegiatan->delete();
                DB::table('laporan')->where('id_lapor','=',$id_lapor)
                    ->update(['status' => 'Sudah Diproses']);
                return redirect('/lapor/arsip')->with('Sukses dihapus');
            }else{
                return redirect('lapor')->withErrors([
                    'Data tidak ditemukan'
                ]);
            }
        } catch (QueryException  $e) {
            Log::error($e->getMessage());
            return "erorrrr" . $e->getMessage();/*redirect('/kalender')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);*/
        }
    }

}