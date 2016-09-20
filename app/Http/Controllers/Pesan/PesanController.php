<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/17/2016
 * Time: 12:19 PM
 */

namespace App\Http\Controllers\Pesan;

use App\Models\Pesan\PesanModel;
use App\Models\Pesan\PesanTerkirimModel;
use App\Models\Warga\WargaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PesanController extends Controller {

    public function getIndex($search="")
    {
        $warga = WargaModel::where("id_klaster","=",Auth::user()->id_klaster)
            ->whereNotIn('id',[2,3,Auth::user()->id])->get();

        $jo = DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
            ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
            //->where('pesan.parent','=',null)
            ->where('pesan.id_penerima','=',Auth::user()->id)
            //->orWhere('pesan.id_pengirim','=',Auth::user()->id)
            ->whereNull('pesan.parent')
            ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima','pesan.lampiran')
            ->orderBy('pesan.created_at','desc')
            ->get();

        $in = DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
            ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
            //->where('pesan.parent','=',null)
            //->where('pesan.id_penerima','=',Auth::user()->id)
            ->Where('pesan.id_pengirim','=',Auth::user()->id)
            ->whereNull('pesan.parent')
            ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima','pesan.lampiran')
            ->orderBy('pesan.created_at','desc')
            ->get();

        $join = array_merge($jo,$in);

        if(count($join) > 15 ) {
            $pesan = DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
                ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
                //->whereNull('pesan.parent')
                ->where('pesan.parent','=',null)
                ->where('pesan.id_penerima','=',Auth::user()->id)
                 ->orWhere('pesan.id_pengirim','=',Auth::user()->id)
                ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima','pesan.lampiran')
                ->orderBy('pesan.created_at','decs')
                ->paginate(15);
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
        return view('Pesan.semuapesan',$data);
    }

    public function getDetail($id_pesan){

        $p = PesanModel::join("users","users.id","=","pesan.id_pengirim")
            ->select("pesan.*","users.name as pengirim")
            ->find($id_pesan);

        $pa = PesanModel::join('users as tbl1','tbl1.id','=','pesan.id_pengirim')
            ->where("id_pesan",$id_pesan)
            ->orWhere("pesan.parent",$id_pesan)
            ->orderBy("pesan.created_at","asc")
            ->select("pesan.*","tbl1.name as pengirim")
            ->get();

        if($p->id_penerima == Auth::user()->id) {
            PesanModel::where("id_pesan", $id_pesan)
                ->orWhere("pesan.parent", $id_pesan)
                ->update([
                    'status' => 'read'
                ]);
        }

        $warga = WargaModel::where("id_klaster","=",Auth::user()->id_klaster)
            ->whereNotIn('id',[2,3])->get();

        if(count($p) > 0) {
            return view("pesan.detailpesan")->with([
                "join" => $pa,
                "p" => $p,
                "getDataWarga" => $warga
            ]);
        }else {
            return redirect('pesan');
        }
    }

    public function postSubmit(Request $request){
        try{
            /*$userdata = array('file' => Input::get('lampiran'),);
            $rules = array(
                'file'  => 'doc,docx,jpg,jpeg,png',
                'max'   => '5000'
                );  // validate file type image
            */

            $validator = Validator::make($request->all(), [
                'lampiran'  => 'max:3000000|mimes:doc,docx,jpg,jpeg,png,rar,zip,pdf',
            ]);

            if ($validator->fails()) {
                $warga = WargaModel::where("id_klaster","=",Auth::user()->id_klaster)
                    ->whereNotIn('id',[2,3,Auth::user()->id])->get();

                $jo = DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
                    ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
                    //->where('pesan.parent','=',null)
                    ->where('pesan.id_penerima','=',Auth::user()->id)
                    //->orWhere('pesan.id_pengirim','=',Auth::user()->id)
                    ->whereNull('pesan.parent')
                    ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima','pesan.lampiran')
                    ->orderBy('pesan.created_at','desc')
                    ->get();

                $in = DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
                    ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
                    //->where('pesan.parent','=',null)
                    //->where('pesan.id_penerima','=',Auth::user()->id)
                    ->Where('pesan.id_pengirim','=',Auth::user()->id)
                    ->whereNull('pesan.parent')
                    ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima','pesan.lampiran')
                    ->orderBy('pesan.created_at','desc')
                    ->get();

                $join = array_merge($jo,$in);

                if(count($join) > 15 ) {
                    $pesan = DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
                        ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
                        //->whereNull('pesan.parent')
                        ->where('pesan.parent','=',null)
                        ->where('pesan.id_penerima','=',Auth::user()->id)
                        ->orWhere('pesan.id_pengirim','=',Auth::user()->id)
                        ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima','pesan.lampiran')
                        ->orderBy('pesan.created_at','decs')
                        ->paginate(15);
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
                Session()->flash('message', 'File Terlalu Besar atau salah tipe');

                return view('Pesan.semuapesan',$data);
            } else {

                $id_penerima = $request->input("id_penerima");
                $count = count($id_penerima);

                for ($i = 1; $i <= $count; $i++) {

                    $data = new PesanModel();
                    $data->id_penerima = $id_penerima[$i - 1];
                    $data->isi_pesan = $request->input("isi_pesan");
                    $data->id_pengirim = Auth::user()->id;
                    $data->created_by = Auth::user()->id;
                    $data->updated_by = Auth::user()->id;
                    $data->status = "unread";

                    if ($request->hasFile('lampiran')) {
                        $file = Input::file('lampiran');
                        $name = time() . '-' . $file->getClientOriginalName();
                        $path = 'dist/pesan';
                        $unLink = 'dist/pesan' . $request->input('image_old');
                        if (file_exists($unLink) && $file->getClientOriginalName() != "" && $request->input("image_old")) {
                            unLink($unLink);
                        }
                        $file->move($path, $name);
                        $data->lampiran = $name;
                    } else if ($request->input("lampiranteruskan") != "") {
                        $data->lampiran = $request->input('lampiranteruskan');
                    }
                    $data->save();

                }
                \Session::flash('flash_message', 'Pesan Berhasil terkirim.');
                return redirect("pesan");
            }

        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            \Session::flash('error_message','Pesan Gagal dikirim.');
            return redirect('/pesan')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }

    public function getDownload($namaFile){
        return response()->file(public_path('dist/pesan/'.$namaFile));
    }

    public function postSubmitBalas(Request $request){
        try{
                $data=new PesanModel();
                $data->id_penerima = $request->input("id_penerima");
                $data->isi_pesan = $request->input("isi_pesan");
                $data->id_pengirim = Auth::user()->id;
                $data->created_by = Auth::user()->id;
                $data->updated_by = Auth::user()->id;
                $data->parent = $request->input("parent");
                $data->status = "unread";

                if($request->hasFile('lampiran')){
                    $file = Input::file('lampiran');
                    $name = time(). '-' .$file->getClientOriginalName();
                    $path = 'dist/pesan';

                    $unLink = 'dist/pesan'.$request->input('image_old');
                    if(file_exists($unLink) && $file->getClientOriginalName() != "" && $request->input("image_old")){
                        unLink($unLink);
                    }

                    $file->move($path,$name);
                    $data->lampiran = $name;
                }

                $data->save();

                $terkirim=new PesanTerkirimModel();
                $terkirim->id_penerima = $request->input("id_penerima");
                $terkirim->isi_pesan = $request->input("isi_pesan");
                $terkirim->id_pengirim = Auth::user()->id;
                $terkirim->created_by = Auth::user()->id;
                $terkirim->updated_by = Auth::user()->id;
                $data->status = "unread";
                $terkirim->save();

            return redirect()->back();
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/pesan')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postHapus(Request $request)
    {
        try {
            //$pesan = PesanModel::where('id_pesan','=',$id_pesan);
            $id_pesan = $request->input('id_pesan');
                DB::table('pesan')
                    ->where('id_pesan','=',$id_pesan)
                    ->delete();

            return redirect()->back()->with('Sukses dihapus');

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect('pesanTerkirim')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    }

       public function getBaca(Request $request){
        DB::table('pesan')
            ->where('id_pesan','=', $request->input('id_pesan'))
            ->update([
                'status' => 'read'
            ]);
        return redirect('pesan');
    }

    public function getDataPesan($id_pesan){
        $p = PesanModel::where('id_pesan',$id_pesan)->first();

        if( count($p->parent) > null ) {
            $pp = PesanModel::where('id_pesan', $p->parent)->first();
            $data = PesanModel::where('id_pesan', '=', $pp->id_pesan)
                ->orWhere('parent', '=', $pp->id_pesan)
                ->orderBy('created_at', 'asc')
                ->get();
        }else {
            $data = PesanModel::where('id_pesan',$p->id_pesan)->get();
        }

            $html =' <tbody>';
            foreach($data as $row) {
                    $html .= '<tr><td><div class="callout callout-success">
                <p>' . $row->isi_pesan . '</p>
            </div>
            </td>
            </tr>';
            }

            $html .= '</tbody>';

            return $html;
    }

    public function getNotifPesan(PesanModel $pesanModel){
        try {
            $pesan = $pesanModel->getNotifPesan();

            $count = count($pesan);

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

    public function getListNotifPesan(PesanModel $pesanModel){
        try{
            $pesan = $pesanModel->getNotifPesan();

            $html = '';

            if (count($pesan) > 0) {
                foreach ($pesan as $row) {
                    $html .=
                        '<li><a href=' . url("pesan/detail/" . $row->id_pesan) . '>
                            <i class="fa fa-envelope text-primary margin-r-5"></i>Pesan Baru dari ' . $row->pengirim

                        . '</li>';
                }
            } else {
                $html .= '';
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