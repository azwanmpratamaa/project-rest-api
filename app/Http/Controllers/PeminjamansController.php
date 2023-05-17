<?php

namespace App\Http\Controllers;

use App\Models\Peminjamans;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class PeminjamansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search_nama;

        $limit = $request->limit;

        $peminjamans = Peminjamans::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();

        if ($peminjamans) {
            return ApiFormatter::createApi(200, 'success', $peminjamans);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // validasi data
        $request->validate([
            'nis' => 'required|numeric',
            'nama' => 'required|min:3',
            'rombel' => 'required',
            'rayon' => 'required',
        ]);

        //ngirim data atau tambah data
        $peminjamans = Peminjamans::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ]);

        // cari data baru yang berhasil di simpan, cari berdasarkan id lewat data id dari $Peminjamans yang diatas
        $hasilTambahData = Peminjamans::where('id', $peminjamans->id)->first();
        if ($hasilTambahData) {
            return ApiFormatter::createAPI(200, 'success', $peminjamans);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
        }catch (Exception $error) {
            // munculin deskripsi error yang bakal tampil di property data json nya
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    // coba baris kode didalam try
    try {  
            // ambil data dari table peminjamans $peminjamans yang id nya sama kaya $id dari path routenya
            // where & find fungsi mencari, bedanya : where nyari berdasarkan column apa aja boleh, kalau find cuma bisa cari berdasarkan id
            $peminjamans = Peminjamans::find($id);
            if ($peminjamans) {
                // kalau data berhasil diambil, tampilkan data dari $peminjamans nya dengann tanda status code 200
                return ApiFormatter::createAPI(200, 'success', $peminjamans);
            }else {
                return ApiFormatter::createAPI(400, 'failed',);
            }
        } catch (Exception $error) {
            // kalau pas try ada error, deskripsi error nya ditampilkan dengan status code 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjamans $peminjamans)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nis' => 'required|numeric',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);
            // ambil data yang akan di ubah
            $peminjamans = Peminjamans::find($id);
            // update data yang telah diambil diatas
            $peminjamans->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);
            // cari data yang berhasil diubah tadi, cari berdasarkan id dari $Peminjamans yang ngambil data di awal
            $dataTerbaru = Peminjamans::where('id', $peminjamans->id)->first();
            if ($dataTerbaru) {
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            // jika di baris kode try ada trouble, error dimunculkan dengan desc error nya dengan status code 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // ambil data yang mau dihapus
            $peminjamans = Peminjamans::find($id);
            // hapus data yang diambil diatas
            $cekBerhasil = $peminjamans->delete();
            if ($cekBerhasil) {
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            // kalau ada trouble di baris kode dalem try, error desc nya dimunculin
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            // ambil data yanag sudah dihapus sementara
            $peminjamans = Peminjamans::onlyTrashed()->get();
            if ($peminjamans) {
                // kalau data berhasil terambil, tampilkan status 200 dengan $peminjamans
                return ApiFormatter::createAPI(200, 'success', $peminjamans);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            // kalau ada error try, catch akan menampilkan desc error nya
            return ApiFormatter::createAPI(400, 'error', $error->getMessage);
        }
    }

    public function restore($id)
    {
        try {
            // ambil data yang akan di batal hapus, diambil berdasarkan id dari route nya
            $peminjamans = Peminjamans::onlyTrashed()->where('id', $id);
            // kembalikan data
            $peminjamans->restore();
            // ambil kembali data yang sudah di restore
            $dataKembali = Peminjamans::where('id', $id)->first();
            if ($dataKembali) {
                // jika seluruh proses nya dapat dijalankan, data yang sudah dikembalikan dan diambil tadi ditampilkan pada response 200
                return ApiFormatter::createAPI(200, 'success', $dataKembali);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage);
        } 
    }

    public function permanentDelete($id)
    {
        try {
            // ambil data yang akan dihapus
            $peminjamans = Peminjamans::onlyTrashed()->where('id', $id);
            // hapus permanen data yang diambil
            $proses = $peminjamans->forceDelete();
            if ($proses) {
                return ApiFormatter::createAPI(200, 'success', 'Berhasil hapus permanen!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }       
}