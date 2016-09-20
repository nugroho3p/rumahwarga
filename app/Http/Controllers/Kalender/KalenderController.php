<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/5/2016
 * Time: 11:09 AM
 */

namespace App\Http\Controllers\Kalender;

use App\Models\Kalender\KegiatanModel;
use App\Models\Kalender\Users_KegiatanModel;
use App\Models\Peta\KlasterModel;
use App\Models\Warga\WargaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class KalenderController extends Controller
{
    public function getIndex()
    {
        if(Auth::guest()){
            return redirect('login');
        }else {
            $dataWarga = WargaModel::all();
            $dataKlas = KlasterModel::where('id_klaster', '=', Auth::user()->id_klaster)->first();
            $kegiatan = [
                "getDataWarga" => $dataWarga,
                "klaster" => $dataKlas
            ];
            return view("kalender.kalender", $kegiatan);
        }
    }

    public function postSubmit(Request $request ){

        try{
            $start = $request->input('start');
            $end = $request->input('end');
            $title = $request->input('title');

            $cek = KegiatanModel::where("id_pembuat",Auth::user()->id)
                ->where('start',$start)
                ->where('end',$end)
                ->where('title',$title)
                ->first();
            //print_r($cek); exit;
            if(count($cek) > 0){
                $dataWarga =  WargaModel::where("id_klaster","=",Auth::user()->id_klaster)
                    ->whereNotIn('id',[2,3])->get();

                $kegiatan = [
                    "getDataWarga" => $dataWarga
                ];
                Session()->flash('message','Anda memiliki lebih dari satu kegiatan yang sama.');

                return view("kalender.kegiatanAdd",$kegiatan);
            } else {
                $kegiatan = new KegiatanModel();
                $kegiatan->title = $request->input("title");
                $kegiatan->start = $request->input("start");
                $kegiatan->end = $request->input("end");
                $kegiatan->description = $request->input("description");
                $kegiatan->id_pembuat = Auth::user()->id;
                $kegiatan->created_by = Auth::user()->id;
                $kegiatan->updated_by = Auth::user()->id;

                $kegiatan->save();

                $id = $request->input("id");
                $count = count($id);

                foreach ($id as $row) {
                    $user = new Users_KegiatanModel();

                    $user->id = $row;
                    $user->created_by = Auth::user()->id;
                    $user->updated_by = Auth::user()->id;
                    $kegiatan->Users_Kegiatan()->save($user);
                }

                \Session::flash('flash_message', 'Kegiatan Berhasil Ditambahkan.');
                return redirect("kalender");
            }
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/kalender')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }

    public function postSubmitEdit(Request $request){
        try{

                $data=KegiatanModel::find($request->input("id_kegiatan"));
                $data->title = $request->input("title");
                $data->start = $request->input("start");
                $data->end = $request->input("end");
                $data->description = $request->input("description");
                $data->created_by = Auth::user()->id;
                $data->updated_by = Auth::user()->id;

           /* $id = $request->input("id");
            $count = count($id);

            foreach ($id as $row){
                $user = new Users_KegiatanModel();

                $user->id = $row;
                $user->created_by = Auth::user()->id;
                $user->updated_by = Auth::user()->id;
                $data->Users_Kegiatan()->save($user);
            } */

                $data->save();

            \Session::flash('flash_message','Kegiatan Berhasil Diubah.');
            return redirect("kalender");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/kalender')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }

    public function getAdd(WargaModel $wargaModel){

        $dataWarga =  $wargaModel::where("id_klaster","=",Auth::user()->id_klaster)
            ->whereNotIn('id',[2,3])->get();

        $kegiatan = [
            "getDataWarga" => $dataWarga
        ];
        return view("kalender.kegiatanAdd",$kegiatan);
    }

    public function getEdit($id_kegiatan){

        $data = [
            "getData" => KegiatanModel::find($id_kegiatan),
            "getDataWarga" => $dataWarga = WargaModel::all()
        ];

        return view("kalender.kegiatanEdit",$data);
    }

    public function getDelete($id_kegiatan)
    {
        try {
            $kegiatan = KegiatanModel::find($id_kegiatan);
            $relasi  = Users_KegiatanModel::where('id_kegiatan',$id_kegiatan);

            if (count($relasi) > 0) {
                if($relasi->delete())
                    $kegiatan->delete();
            \Session::flash('flash_message','Data Berhasil Dihapus.');
                return redirect('kalender')->with('Sukses dihapus');
            } else if(count($kegiatan) > 0 &&count($relasi) ==0 ) {
                $kegiatan->delete();
                return redirect('kalender')->with('Sukses dihapus');
            }else{
                return redirect('kalender')->withErrors([
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

    public function getEvent(){
        try {
            $pembuat = DB::table('kegiatan')
                ->join('users','users.id','=','kegiatan.id_pembuat')
                ->Where('kegiatan.created_by','=',Auth::user()->id)
                ->select('kegiatan.*','users.name as namapembuatt')
                ->get();

            $warga = DB::table('users_kegiatan')
                ->join('users as u1','u1.id','=','users_kegiatan.id')
                ->join('kegiatan as k1','k1.id_kegiatan','=','users_kegiatan.id_kegiatan')
                ->where('users_kegiatan.id','=',Auth::user()->id)
                ->select('k1.*','u1.name as namapembuat')
                ->get();

            $pj = DB::table('kegiatan')
                ->join('users','users.id','=','kegiatan.id_pembuat')
                ->Where('users.id_klaster','=',Auth::user()->id_klaster)
                ->select('kegiatan.*','users.name')
                ->get();

            if(Auth::user()->id_role == 2) {
                $event = $pj;
            }else{
                $event = array_merge($pembuat, $warga);
            }

            return Response::json($event);
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            return redirect('/kalender');
        }
    }

    public function getInfo($id_kegiatan){
        $info = DB::table('kegiatan')
            ->join('users','users.id','=','kegiatan.id_pembuat')
            ->where('id_kegiatan','=',$id_kegiatan)
            ->first();

        $html = $info->name;

        return $html;
    }

    public function getNotif(){
        $pembuat = DB::table('kegiatan')
            ->join('users','users.id','=','kegiatan.id_pembuat')
            ->Where('kegiatan.id_pembuat','=',Auth::user()->id)
            ->select('kegiatan.*','users.name')
            ->get();

        $warga = DB::table('users_kegiatan')
            ->join('kegiatan','kegiatan.id_kegiatan','=','users_kegiatan.id_kegiatan')
            ->where('users_kegiatan.id','=',Auth::user()->id)
            ->select('kegiatan.*')
            ->get();

        $count = count($pembuat) + count($warga);

        if ($count > 0)
            $html = $count;
        else
            $html = "";
        return $html;
    }
}