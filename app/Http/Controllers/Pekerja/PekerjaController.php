<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 09-Feb-16
 * Time: 09:37 AM
 */

namespace App\Http\Controllers\Pekerja;


use App\Models\PekerjaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class PekerjaController extends Controller{

    public function getIndex(){

        $pekerja = PekerjaModel::all();

        $data = [
            "pekerja" => $pekerja
        ];

        return view("pekerja.pekerja",$data);
    }

    public function postSubmit(Request $request)
    {
        try {
            if ($request->input("id_pekerja") != null) {
                $data = PekerjaModel::findOrNew($request->input("id_pekerja"));
                \Session::flash('flash_message', 'Data Pekerja Berhasil diedit.');
                $data->updated_by = Auth::user()->id;
            } else {
                $data = new PekerjaModel();
                \Session::flash('flash_message', 'Data Pekerja Berhasil ditambahkan.');
            }

            $data->nama_pekerja = $request->input("nama_pekerja");
            $data->alamat = $request->input("alamat");
            $data->no_telp = $request->input("no_telp");
            $data->posisi = $request->input("posisi");
            $data->created_by = Auth::user()->id;


            if($request->hasFile('foto')){

                $file = Input::file('foto');
                $name = time(). '-' .$file->getClientOriginalName();
                $path = 'dist/img/pekerja';

                $unLink = 'dist/img/pekerja'.$request->input('image_old');
                if(file_exists($unLink) && $file->getClientOriginalName() != "" && $request->input('image_old')){
                    unLink($unLink);
                }

                $file->move($path, $name);
                $data->foto = $name;
            }

            $data->save();
            return redirect("pekerja");
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect('/pekerja')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function getDelete($id_pekerja)
    {
        try {
            $pekerja = PekerjaModel::find($id_pekerja);

            if (count($pekerja) > 0) {
                $pekerja->delete();
                \Session::flash('flash_message','Data Berhasil Dihapus.');
                return redirect('/pekerja')->with('Sukses dihapus');
            } else {
                return redirect('/pekerja')->withErrors([
                    'Data tidak ditemukan'
                ]);
            }
        } catch (QueryException  $e) {
            Log::error($e->getMessage());
            return redirect('/pekerja')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    }

    public function getEdit(PekerjaModel $pekerjaModel, $id_pekerja)
    {
        $pekerja = $pekerjaModel->find($id_pekerja);
        if (count($pekerja) == 0)
            return redirect('/pekerja')->withErrors(['Data tidak ditemukan']);

        $data = array('obj' => $pekerja);

        return view('pekerja.pekerjaEdit', $data);
    }
}