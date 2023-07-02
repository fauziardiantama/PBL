<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Informasi;
use App\Models\Topik_kmm;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Berita;
use App\Models\Gambar_berita;
use App\Models\Instansi;
use App\Models\Progres;
use App\Models\Tahun;
use Illuminate\Support\Facades\Mail;
use App\Models\Magang;
use App\Models\Bimbingan_instansi;
use App\Models\Bobot_nilai;
use App\Models\Parameter_nilai_bimbingan;
use App\Models\Parameter_nilai_instansi;
use App\Models\Parameter_nilai_seminar;
use App\Models\Hubungi_kami;

class AdminController extends Controller
{
    public function dashboard()
    {
        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $instansis = Instansi::all();
        $beritas = Berita::all();
        $magangs = Magang::all();
        $tahuns = Tahun::all();
        $progress = Progres::all();
        return view('admin.dashboard', [ 'mahasiswas' => $mahasiswas, 'progress' => $progress, 'tahuns' => $tahuns, 'dosens' => $dosens, 'instansis' => $instansis, 'beritas' => $beritas, 'magangs' => $magangs]);
    }

    public function profil()
    {
        return view('admin.profil', [ 'a' => Auth::guard('admin')->user() ]);
    }

    public function profilUpdate(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);
        if(!$validated)
        {
            return redirect()->route('admin.profil')->withErrors($validated);
        }
        $a = Admin::find(Auth::guard('admin')->user()->id_admin);

        if($a->update($validated))
        {
            return redirect()->route('admin.profil')->with('berhasil', 'Profil berhasil diubah');
        }

        return redirect()->route('admin.profil')->withErrors(['gagal' => 'Gagal mengubah profil']);
    }

    public function profilUbahPassword()
    {
        return view('admin.profil_password');
    }

    public function profilUbahPasswordUpdate(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|max:255|min:8',
            'password_confirmation' => 'required|same:password|max:255|min:8',
        ]);
        if(!$validated)
        {
            return redirect()->route('admin.profil')->withErrors($validated);
        }
        $validated['password'] = Hash::make($validated['password']);
        $admin = Admin::find(Auth::guard('admin')->user()->id_admin)->update($validated);
        if(!$admin)
        {
            return redirect()->route('admin.profil')->withErrors(['gagal' => 'Gagal mengubah password']);
        }
        return redirect()->route('admin.profil')->with('berhasil', 'Password berhasil diubah');
    }

    public function topikKmm()
    {
        return view('admin.topik_kmm', [ 'topik' => Topik_kmm::all() ]);
    }

    public function topikKmmPost(Request $request)
    {
        $validated = $request->validate([
            'nama_topik' => 'required|unique:topik_kmm|max:255',
        ]);
        if(!$validated)
        {
            return redirect()->route('admin.topik-kmm')->withErrors($validated);
        }
        $topik = Topik_kmm::create($validated);
        if(!$topik)
        {
            return redirect()->route('admin.topik-kmm')->withErrors(['gagal' => 'Gagal menambahkan topik KMM']);
        }
        return redirect()->route('admin.topik-kmm')->with('berhasil', 'Topik KMM berhasil ditambahkan');
    }

    public function topikKmmUpdate(Request $request, Topik_kmm $topik)
    {
        $validated = $request->validate([
            'nama_topik' => 'required|max:255|unique:topik_kmm',
        ]);
        if(!$validated)
        {
            return redirect()->route('admin.topik-kmm')->withErrors($validated);
        }
        $topik = Topik_kmm::find($topik)->first()->update($validated);
        if(!$topik)
        {
            return redirect()->route('admin.topik-kmm')->withErrors(['gagal' => 'Gagal mengubah topik KMM']);
        }
        return redirect()->route('admin.topik-kmm')->with('berhasil', 'Topik KMM berhasil diubah');
    }

    public function topikKmmDelete(Topik_kmm $topik)
    {
        $topik = Topik_kmm::find($topik)->first()->delete();
        if(!$topik)
        {
            return redirect()->route('admin.topik-kmm')->withErrors(['gagal' => 'Gagal menghapus topik KMM']);
        }
        return redirect()->route('admin.topik-kmm')->with('berhasil', 'Topik KMM berhasil dihapus');
    }

    public function informasiKmm()
    {
        return view('admin.informasi_kmm', ['d' => Informasi::orderBy('tanggal', 'desc')->paginate(5)]);
    }
    public function informasiKmmPost(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'dokumen' => 'required|mimes:pdf|max:2048',
            'submit' => 'required|in:Simpan,Publish',
        ]);

        if(!$validated)
        {
            return redirect()->route('admin.informasi-kmm')->withErrors($validated);
        }

        $fileName = $request->file('dokumen')->getClientOriginalName();
        $request->file('dokumen')->move(public_path('documents'), $fileName);
        $validated['dokumen'] = $fileName;
        
        if ($validated['submit'] == 'Publish') {
            $validated['status_publikasi'] = 1;
        } else {
            $validated['status_publikasi'] = 0;
        }

        $validated['submit'] = null;
        $validated['tanggal'] = date('Y-m-d');
        $informasi = Informasi::create($validated);

        if(!$informasi)
        {
            return redirect()->route('admin.informasi-kmm')->withErrors(['gagal' => 'Gagal menambahkan informasi KMM']);
        }

        return redirect()->route('admin.informasi-kmm')->with('berhasil', 'Informasi KMM berhasil ditambahkan');
    }

    public function informasiKmmUpdate(Request $request, Informasi $informasi)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'dokumen' => 'mimes:pdf|max:2048',
            'submit' => 'required|in:Simpan,Publish,Unpublish',
        ]);

        if(!$validated)
        {
            return redirect()->route('admin.informasi-kmm')->withErrors($validated);
        }

        $informasi_db = Informasi::find($informasi)->first();

        if($request->hasFile('dokumen')){
            $fileName = $request->file('dokumen')->getClientOriginalName();
            if(File::exists(public_path('documents/'.$fileName))){
                File::delete(public_path('documents/'.$fileName));
            }
            $request->file('dokumen')->move(public_path('documents'), $fileName);
            $validated['dokumen'] = $fileName;
        } else {
            $validated['dokumen'] = $informasi_db->dokumen;
        }
        
        switch($validated['submit']) {
            case 'Simpan':
                $validated['status_publikasi'] = $informasi_db->status_publikasi; 
                break;
            case 'Publish':
                $validated['status_publikasi'] = 1;
                break;
            case 'Unpublish':
                $validated['status_publikasi'] = 0;
                break;
        }
        
        $validated['submit'] = null;
        $validated['tanggal'] = date('Y-m-d');

        $informasi = $informasi_db->update($validated);
        if(!$informasi)
        {
            return redirect()->route('admin.informasi-kmm')->withErrors(['gagal' => 'Gagal mengubah informasi KMM']);
        }
        return redirect()->route('admin.informasi-kmm')->with('berhasil', 'Informasi KMM berhasil diubah');
    }

    public function informasiKmmPublish(Informasi $informasi)
    {
        $informasi_db = Informasi::find($informasi)->first();
        $informasi_db->status_publikasi = 1;
        if($informasi_db->save())
        {
            return redirect()->route('admin.informasi-kmm')->with('berhasil', 'Informasi KMM berhasil dipublish');
        }
        return redirect()->route('admin.informasi-kmm')->withErrors(['gagal' => 'Gagal mempublish informasi KMM']);
    }

    public function informasiKmmUnpublish(Informasi $informasi)
    {
        $informasi_db = Informasi::find($informasi)->first();
        $informasi_db->status_publikasi = 0;
        if($informasi_db->save())
        {
            return redirect()->route('admin.informasi-kmm')->with('berhasil', 'Informasi KMM berhasil diunpublish');
        }
        return redirect()->route('admin.informasi-kmm')->withErrors(['gagal' => 'Gagal mengunpublish informasi KMM']);
    }

    public function informasiKmmDelete(Informasi $informasi)
    {
        $informasi_db = Informasi::find($informasi)->first();
        if(File::exists(public_path('documents/'.$informasi_db->dokumen))){
            File::delete(public_path('documents/'.$informasi_db->dokumen));
        }
        if($informasi_db->delete())
        {
            return redirect()->route('admin.informasi-kmm')->with('berhasil', 'Informasi KMM berhasil dihapus');
        }
        return redirect()->route('admin.informasi-kmm')->withErrors(['gagal' => 'Gagal menghapus informasi KMM']);
    }

    public function user()
    {
        return view('admin.user', ['d' => Dosen::paginate(5, ['*'], 'd_page'), 'm' => Mahasiswa::orderBy('nim','desc')->paginate(10, ['*'], 'm_page'), 'a' => Auth::guard('admin')->user()]);
    }

    public function userDosenPost(Request $request)
    {
        $validated = $request->validate([
            'nik'  => 'required|max:255',
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:dosen|max:255',
            'password' => 'required|max:255',
            'password_confirmation' => 'required|same:password|max:255',
        ]);

        if(!$validated)
        {
            return redirect()->route('admin.user')->withErrors($validated);
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['password_confirmation'] = null;
        $dosen = Dosen::create($validated);
        if(!$dosen)
        {
            return redirect()->route('admin.user')->withErrors(['gagal' => 'Gagal menambahkan dosen']);
        }
        /**
         * $data = array(
         *     'name'     => $validated['nama'],
         *     'email'    => $validated['email'],
         *     'password' => $validated['password'],
         * );
         * 
         * Mail::send('emails.dosennew', $data, function ($message) use ($validated) {
         * 
         *     $message->from('no-reply@simkmmv2.com', 'Berhasil Terverifikasi');
         * 
         *     $message->to($validated['email'])->subject('Akun SIMKMM sudah dibuat');
         * 
         * });
         */
        return redirect()->route('admin.user')->with('berhasil', 'Dosen berhasil ditambahkan');
    }

    public function userDosen(Dosen $dosen)
    {
        return view('admin.user_dosen', ['d' => $dosen]);
    }

    public function userDosenUpdate(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nik'  => 'required|max:255',
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:dosen|max:255',
        ]);
        if(!$validated)
        {
            return redirect()->route('admin.user')->withErrors($validated);
        }
        $dosen = Dosen::find($dosen)->first()->update($validated);
        if(!$dosen)
        {
            return redirect()->route('admin.user')->withErrors(['gagal' => 'Gagal mengubah dosen']);
        }
        return redirect()->route('admin.user')->with('berhasil', 'Dosen berhasil diubah');
    }

    public function userDosenDelete(Dosen $dosen)
    {
        $dosen = Dosen::find($dosen)->first()->delete();
        if(!$dosen)
        {
            return redirect()->route('admin.user')->withErrors(['gagal' => 'Gagal menghapus dosen']);
        }
        return redirect()->route('admin.user')->with('berhasil', 'Dosen berhasil dihapus');
    }

    public function userMahasiswa(Mahasiswa $mahasiswa)
    {
        return view('admin.user_mahasiswa', ['m' => $mahasiswa]);
    }

    public function userMahasiswaUpdate(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim'  => 'required|max:255',
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:mahasiswa|max:255',
        ]);
        if(!$validated)
        {
            return redirect()->route('admin.user')->withErrors($validated);
        }
        $mahasiswa = Mahasiswa::where('nim',$mahasiswa->nim)->first()->update($validated);

        if(!$mahasiswa)
        {
            return redirect()->route('admin.user')->withErrors(['gagal' => 'Gagal mengubah mahasiswa']);
        }
        return redirect()->route('admin.user')->with('berhasil', 'Mahasiswa berhasil diubah');
    }

    public function userMahasiswaDelete(Mahasiswa $mahasiswa)
    {
        $mahasiswa_db = Mahasiswa::where('nim',$mahasiswa->nim)->first();
        $dokumen_db = $mahasiswa_db->dokumen;
        if(File::exists(public_path('documents/krs/'.$dokumen_db->krs))){
            File::delete(public_path('documents/krs/'.$dokumen_db->krs));
        }
        if(File::exists(public_path('documents/transkrip/'.$dokumen_db->transkrip))){
            File::delete(public_path('documents/transkrip/'.$dokumen_db->transkrip));
        }
        if(File::exists(public_path('documents/bukti-seminar/'.$dokumen_db->bukti_seminar))){
            File::delete(public_path('documents/bukti-seminar/'.$dokumen_db->bukti_seminar));
        }
        if(!$mahasiswa)
        {
            return redirect()->route('admin.user')->withErrors(['gagal' => 'Gagal menghapus mahasiswa']);
        }
        $doc = $mahasiswa_db->delete();
        if(!$doc)
        {
            return redirect()->route('admin.user')->withErrors(['gagal' => 'Gagal menghapus dokumen mahasiswa']);
        }
        return redirect()->route('admin.user')->with('berhasil', 'Mahasiswa berhasil dihapus');
    }

    public function userMahasiswaAktif(Mahasiswa $mahasiswa)
    {
        $mahasiswa_db = Mahasiswa::where('nim',$mahasiswa->nim)->first();
        $mahasiswa_db->status = 1;
        if($mahasiswa_db->save())
        {
            // $data = array(
            //     'name' => $mahasiswa_db->nama,
            // );
        
            // Mail::send('emails.register', $data, function ($message) use ($mahasiswa_db) {
        
            //     $message->from('no-reply@simkmmv2.com', 'SIMKMM D3TI');
        
            //     $message->to($mahasiswa_db->email)->subject('Akun kamu sudah diverifikasi!');
        
            // });
            return redirect()->route('admin.user')->with('berhasil', 'Mahasiswa berhasil diaktifkan');
        }
        return redirect()->back()->withErrors(['gagal' => 'Gagal mengaktifkan mahasiswa']);
    }

    public function userMahasiswaNonaktif(Mahasiswa $mahasiswa)
    {
        $mahasiswa_db = Mahasiswa::where('nim',$mahasiswa->nim)->first();
        $mahasiswa_db->status = 0;
        if($mahasiswa_db->save())
        {
            return redirect()->route('admin.user')->with('berhasil', 'Mahasiswa berhasil di nonaktifkan');
        }
        return redirect()->back()->withErrors(['gagal' => 'Gagal menonaktifkan mahasiswa']);
    }
    public function berita()
    {
        foreach(Berita::all() as $b){
            if($b->judul == null || $b->judul == ''){
                $b->delete();
            }
        }
        foreach(Gambar_berita::all() as $g){
            if(Berita::find($g->id_berita) == null){
                if(File::exists(public_path('images/berita/'.$g->gambar))){
                    File::delete(public_path('images/berita/'.$g->gambar));
                }
                $g->delete();
            }
        }
        return view('admin.berita', ['berita' => Berita::orderBy('tanggal','desc')->paginate(10), 'a' => Auth::guard('admin')->user()]);
    }

    public function beritaAdd()
    {
        $berita = Berita::create(
            [
                'judul' => '',
                'deskripsi' => '',
                'tanggal' => date('Y-m-d'),
                'id_admin' => Auth::guard('admin')->user()->id_admin,
                'slug' => '',
                'status_publikasi' => 0,
            ]
        );
        return view('admin.berita_add', ['b' => $berita, 'a' => Auth::guard('admin')->user()]);
    }

    public function uploadGambarBerita(Berita $berita, Request $request)
    {
        $file = $request->file('file');
        $fileName = time().'-'.$file->getClientOriginalName();
        Gambar_berita::create([
            'id_berita' => $berita->id_berita,
            'gambar' => $fileName,
        ]);
        $file->move(public_path('images/berita'), $fileName);
        return response()->json(['location' => asset('images/berita/'.$fileName)]);
    }

    public function deleteGambarBerita(Request $request)
    {
        $imageUrl = $request->input('image-url');
        if ($imageUrl) {

            $filename = basename(parse_url($imageUrl, PHP_URL_PATH));

            $gambar_berita = Gambar_berita::where('gambar', $filename)->first();
            $gambar_berita->delete();

            $filePath = public_path('images/berita/' . $filename);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function beritaShow(Berita $berita, Request $request)
    {
        //if request contain 'edit' with value true, then show edit page
        if($request->edit == 'true'){
            return view('admin.berita_edit', ['b' => $berita, 'a' => Auth::guard('admin')->user()]);
        }
        return view('admin.berita_show', ['b' => $berita, 'a' => Auth::guard('admin')->user()]);
    }

    public function beritaUpdate(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul'  => 'required|max:255',
            'deskripsi' => 'required',
            'slug' => 'required|max:255',
            'submit' => 'required|in:Unpublish,Publish,Simpan',
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $validated['tanggal'] = date('Y-m-d');
        $validated['id_admin'] = Auth::guard('admin')->user()->id_admin;
        switch($validated['submit']){
            case 'Unpublish':
                $validated['status_publikasi'] = 0;
                break;
            case 'Publish':
                $validated['status_publikasi'] = 1;
                break;
            case 'Simpan':
                $validated['status_publikasi'] = $berita->status_publikasi;
                break;
        }
        $berita = Berita::find($berita)->first()->update($validated);
        if($berita){
            return redirect()->route('admin.berita')->with('berhasil', 'Berita berhasil disimpan');
        }
        return redirect()->route('admin.berita')->withErrors(['gagal' => 'Gagal mengupdate berita']);
    }

    public function beritaDelete(Berita $berita)
    {
        $berita_db = Berita::find($berita)->first();
        foreach ($berita_db->gambar as $gb) {
            if(File::exists(public_path('images/berita/'.$gb->gambar))){
                File::delete(public_path('images/berita/'.$gb->gambar));
            }
        }
        $berita_db->gambar()->delete();
        $berita_db->delete();
        return redirect()->route('admin.berita');
    }

    public function beritaPublish(Berita $berita)
    {
        $berita_db = Berita::find($berita)->first();
        $berita_db->status_publikasi = 1;
        $berita_db->save();
        return redirect()->route('admin.berita');
    }

    public function beritaUnpublish(Berita $berita)
    {
        $berita_db = Berita::find($berita)->first();
        $berita_db->status_publikasi = 0;
        $berita_db->save();
        return redirect()->route('admin.berita');
    }

    public function instansi()
    {
        return view('admin.instansi', ['instansi' => Instansi::orderBy('id_instansi','desc')->paginate(10), 'a' => Auth::guard('admin')->user()]);
    }

    public function approveInstansi(Instansi $instansi)
    {
        $instansi->status_instansi = 1;
        $instansi->save();
        return redirect()->route('admin.instansi');
    }

    public function unapproveInstansi(Instansi $instansi)
    {
        $instansi->status_instansi = 0;
        $instansi->save();
        return redirect()->route('admin.instansi');
    }

    public function deleteInstansi(Instansi $instansi)
    {
        $instansi->delete();
        return redirect()->route('admin.instansi');
    }

    public function progres()
    {
        return view('admin.progres', ['progres' => Progres::all(), 'a' => Auth::guard('admin')->user()]);
    }

    public function progresPost(Request $request)
    {
        $validated = $request->validate([
            'progres'  => 'required|max:255',
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $progres = Progres::create($validated);
        if($progres){
            return redirect()->route('admin.progres')->with('berhasil', 'Progres berhasil ditambahkan');
        }
        return redirect()->route('admin.progres')->withErrors(['gagal' => 'Gagal menambahkan progres']);
    }

    public function progresUpdate(Request $request, Progres $progres)
    {
        $validated = $request->validate([
            'progres'  => 'required|max:255',
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $progres = Progres::find($progres)->first()->update($validated);
        if($progres){
            return redirect()->route('admin.progres')->with('berhasil', 'Progres berhasil disimpan');
        }
        return redirect()->route('admin.progres')->withErrors(['gagal' => 'Gagal mengupdate progres']);
    }

    public function tahun()
    {
        return view('admin.tahun', ['tahun' => Tahun::all(), 'a' => Auth::guard('admin')->user()]);
    }

    public function tahunPost(Request $request)
    {
        $validated = $request->validate([
            'tahun'  => 'required|max:255',
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $tahun = Tahun::create($validated);
        if($tahun){
            return redirect()->route('admin.tahun')->with('berhasil', 'Tahun berhasil ditambahkan');
        }
        return redirect()->route('admin.tahun')->withErrors(['gagal' => 'Gagal menambahkan tahun']);
    }

    public function magang()
    {
        set_time_limit(2000);
        $tahun = Tahun::all();
        $progres = Progres::all();
        $magang = Magang::all();
        foreach($magang as $m)
        {
            if (!$m->progres_daftar_magang()->exists())
            {
                $m->update([
                    'id_status_daftar' => 5,
                ]);
            }
        }
        return view('admin.list_magang', ['magang' => Magang::paginate(10), 'magang_all' => $magang, 'progres' => $progres, 'tahun' => $tahun, 'a' => Auth::guard('admin')->user()]);
    }

    public function magangShow(Magang $magang)
    {
        $m = $magang;
        if ($m->bimbingan_dosen()->exists())
        {
            $bimbingan_dosen = $m->bimbingan_dosen;
        } else {
            $bimbingan_dosen = null;
        }
        if ($m->bimbingan_instansi()->exists())
        {
            $bimbingan_instansi = $m->bimbingan_instansi;
        } else {
            $bimbingan_instansi = null;
        }
        if ($m->progres_daftar_magang()->exists())
        {
            $progres = $m->progres_daftar_magang;
        } else {
            $m->progres_daftar_magang()->attach(2);
            $progres = $m->progres_daftar_magang;
        }
        if ($m->dosen()->exists())
        {
            $dosen = $m->dosen;
        } else {
            $dosen = null;
        }
        if($m->rencana_magang()->exists())
        {
            $rencana_magang = $m->rencana_magang;
        } else {
            $rencana_magang = null;
        }
        if ($m->nilai_bimbingan()->exists())
        {
            $nilai_bimbingan = $m->nilai_bimbingan()->orderBy('id_parameter', 'asc')->get();
        } else {
            $nilai_bimbingan = null;
        }
        if ($m->nilai_instansi()->exists())
        {
            $nilai_instansi = $m->nilai_instansi;
        } else {
            $nilai_instansi = null;
        }
        if ($m->nilai_seminar()->exists())
        {
            $nilai_seminar = $m->nilai_seminar()->orderBy('id_parameter', 'asc')->get();
        } else {
            $nilai_seminar = null;
        }
        if ($m->nilai_akhir()->exists())
        {
            $nilai_akhir = $m->nilai_akhir;
        } else {
            $nilai_akhir = null;
        }
        if ($m->seminar()->exists())
        {
            $seminar = $m->seminar;
        } else {
            $seminar = null;
        }
        if ($m->revisi()->exists())
        {
            $revisi = $m->revisi;
        } else {
            $revisi = null;
        }
        $topik = $m->topik;
        $dosen_this_topik = ($topik->dosen()->exists()) ? $topik->dosen : null;
        if ($m->dosen_penguji()->exists())
        {
            $dosen_penguji = $m->dosen_penguji;
        } else {
            $dosen_penguji = null;
        }
        $parameter_bimbingan = Parameter_nilai_instansi::where('tahun', $magang->tahun)->get();
        return view('admin.show_magang', ['magang' => $m, 'bimbinganinstansi' => $bimbingan_instansi, 'rencana'=> $rencana_magang,'dosen' => $dosen, 'bimbingandosen' => $bimbingan_dosen, 'progres_daftar' => $progres, 'nilaibimbingan' => $nilai_bimbingan, 'nilaiinstansi' => $nilai_instansi, 'nilaiseminar' => $nilai_seminar, 'nilaiakhir' => $nilai_akhir, 'seminar' => $seminar, 'revisi' => $revisi, 'parameter_bimbingan' => $parameter_bimbingan, 'dosenthistopik' => $dosen_this_topik, 'dosenpenguji' => $dosen_penguji]);
    }

    public function seminarAddPenguji(Magang $magang, Request $request)
    {
        $validated = $request->validate([
            'id_dosen_penguji' => 'required|exists:dosen,id_dosen',
        ]);
        if (!$validated)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'Dosen tidak ditemukan']);
        }
        if ($magang->dosen_penguji()->exists())
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'Magang sudah memiliki penguji']);
        }
        $magang->dosen_penguji()->attach($request->id_dosen_penguji);
        return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'Penguji berhasil ditambahkan');
    }

    public function magangPengajuanInstansiApprove(Magang $magang)
    {
        $m = Magang::find($magang)->first();
        $m->update(['status_pengajuan_instansi' => 1, 'id_status_daftar' => 4]);
        return redirect()->route('admin.magang.show', $m->id_magang);
    }

    public function magangDiterimaInstansiApprove(Magang $magang)
    {
        $m = Magang::find($magang)->first();
        $m->update(['status_diterima_instansi' => 1, 'id_status_daftar' => 5, 'id_progress' => 2]);
        return redirect()->route('admin.magang.show', $m->id_magang);
    }

    public function magangPengajuanInstansiReject(Magang $magang)
    {
        $m = Magang::find($magang)->first();
        $m->update(['status_pengajuan_instansi' => 0]);
        return redirect()->route('admin.magang.show', $m->id_magang);
    }

    public function magangDiterimaInstansiReject(Magang $magang)
    {
        $m = Magang::find($magang)->first();
        $m->update(['status_diterima_instansi' => 0]);
        return redirect()->route('admin.magang.show', $m->id_magang);
    }

    public function magangApproveBimbingan(Magang $magang)
    {
        $m = Magang::find($magang)->first();
        $m->update(['status_dosen' => 1, 'id_status_daftar' => 3]);
        return redirect()->route('admin.magang.show', $m->id_magang);
    }

    public function magangRejectBimbingan(Magang $magang)
    {
        $m = Magang::find($magang)->first();
        $m->update(['id_dosen' => null, 'status_dosen' => 0, 'id_status_daftar' => 2]);
        return redirect()->route('admin.magang.show', $m->id_magang);
    }

    public function bimbinganInstansiApprove(Magang $magang, Int $bimbingan)
    {
        $bimbingan = Bimbingan_instansi::where('id_bimbingan_instansi', $bimbingan)->update(['status' => 1]);
        if ($bimbingan)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'Bimbingan berhasil disetujui');
        }
        return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'Bimbingan gagal disetujui']);
    }

    public function bimbinganInstansiReject(Magang $magang, Int $bimbingan)
    {
        $bimbingan = Bimbingan_instansi::where('id_bimbingan_instansi', $bimbingan)->update(['status' => 0]);
        if ($bimbingan)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'Bimbingan berhasil ditolak');
        }
        return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'Bimbingan gagal ditolak']);
    }

    public function nilai()
    {
        $tahun = Tahun::all();
        $bobotnilai = Bobot_nilai::all();
        $parameterbimbingan = Parameter_nilai_bimbingan::all();
        $parameterseminar = Parameter_nilai_seminar::all();
        $parameterinstansi = Parameter_nilai_instansi::all();
        return view('admin.nilai', ['tahun' => $tahun, 'bobotnilai' => $bobotnilai, 'parameterbimbingan' => $parameterbimbingan, 'parameterseminar' => $parameterseminar, 'parameterinstansi' => $parameterinstansi]);    
    }

    public function bobotNilai(Request $request)
    {
        $validated = $request->validate([
            'tahun'  => 'required',
            'jenis_nilai' => 'required',
            'persentase' => 'required'
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $bobot = Bobot_nilai::create($validated);
        if (!$bobot)
        {
            return redirect()->route('admin.nilai')->withErrors(['gagal' => 'gagal menambah bobot nilai']);
        }
        return redirect()->route('admin.nilai')->with('berhasil','berhasil menambah bobot nilai');
    }

    public function parameterNilaiSeminar(Request $request)
    {
        $validated = $request->validate([
            'tahun'  => 'required',
            'parameter' => 'required',
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $seminar = Parameter_nilai_seminar::create($validated);
        if (!$seminar)
        {
            return redirect()->route('admin.nilai')->withErrors(['gagal' => 'gagal menambah parameter']);
        }
        return redirect()->route('admin.nilai')->with('berhasil','berhasil menambah parameter');
    }

    public function parameterNilaiBimbingan(Request $request)
    {
        $validated = $request->validate([
            'tahun'  => 'required',
            'parameter' => 'required',
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $bimbingan = Parameter_nilai_bimbingan::create($validated);
        if (!$bimbingan)
        {
            return redirect()->route('admin.nilai')->withErrors(['gagal' => 'gagal menambah parameter']);
        }
        return redirect()->route('admin.nilai')->with('berhasil','berhasil menambah parameter');
    }

    public function parameterNilaiInstansi(Request $request)
    {
        $validated = $request->validate([
            'tahun'  => 'required',
            'parameter' => 'required',
        ]);
        if (!$validated) {
            return redirect()->withErrors($validated);
        }
        $instansi = Parameter_nilai_instansi::create($validated);
        if (!$instansi)
        {
            return redirect()->route('admin.nilai')->withErrors(['gagal' => 'gagal menambah parameter']);
        }
        return redirect()->route('admin.nilai')->with('berhasil','berhasil menambah parameter');
    }

    public function nilaiInstansiApprove(Magang $magang)
    {
        $dokumen = $magang->nilai_instansi()->update(['status' => 1]);
        if ($dokumen)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'dokumen nilai diverifikasi');
        }
    }

    public function nilaiInstansiReject(Magang $magang)
    {
        $dokumen = $magang->nilai_instansi()->update(['status' => 0]);
        if ($dokumen)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'dokumen nilai ditolak');
        }
    }

    public function nilaiInstansi(Magang $magang, Request $request)
    {
        $validated = $request->validate([
            'id_parameter' => 'required',
            'nilai' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors($validated);
        }
        if ($magang->nilai_instansi->detail_nilai_instansi()->where('id_parameter',$validated['id_parameter'])->exists())
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'nilai untuk parameter tersebut sudah ada']);
        }
        $nilai = $magang->nilai_instansi->detail_nilai_instansi()->create($validated);
        if (!$nilai)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'nilai dimasukkan']);
        }
        return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'nilai berhasil dimasukkan');
    }

    public function kontak()
    {
        return view('admin.kontak', ['hubungi_kami' => Hubungi_kami::orderBy('id','desc')->paginate(10)]);
    }

    public function kontakDelete(Hubungi_kami $hubungi_kami)
    {
        $hubungi_kami->delete();
        return redirect()->route('admin.kontak')->with('berhasil', 'pesan berhasil dihapus');
    }

    public function kalkulasiNilaiAkhir(Magang $magang)
    {
        $parameter_bimbingan = Parameter_nilai_bimbingan::where('tahun', $magang->tahun)->count();
        $parameter_seminar = Parameter_nilai_seminar::where('tahun', $magang->tahun)->count();
        $parameter_instansi = Parameter_nilai_instansi::where('tahun', $magang->tahun)->count();
        if (Bobot_nilai::where('tahun', $magang->tahun)->exists())
        {
            $bobot_nilai = Bobot_nilai::where('tahun', $magang->tahun)->pluck('persentase','jenis_nilai')->toArray();
        } else {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'bobot nilai belum ada']);
        }

        if ($magang->nilai_bimbingan()->exists() && $magang->nilai_bimbingan()->count() == $parameter_bimbingan)
        {
            $nilai_bimbingan_arr = $magang->nilai_bimbingan->pluck('nilai')->toArray();
        } else {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'nilai bimbingan belum diinputkan']);
        }

        if ($magang->nilai_seminar()->exists() && $magang->nilai_seminar()->count() == $parameter_seminar)
        {
            $nilai_seminar_arr = $magang->nilai_seminar->pluck('nilai')->toArray();
        } else {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'nilai seminar belum diinputkan']);
        }

        if ($magang->nilai_instansi()->exists() && $magang->nilai_instansi->detail_nilai_instansi()->exists() && $magang->nilai_instansi->detail_nilai_instansi()->count() == $parameter_instansi)
        {
            $nilai_instansi_arr = $magang->nilai_instansi->detail_nilai_instansi->pluck('nilai')->toArray();
        } else {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors(['gagal' => 'nilai instansi belum diinputkan']);
        }

        $rata_bimbingan = array_sum($nilai_bimbingan_arr) / (100 * $parameter_bimbingan);
        $rata_seminar = array_sum($nilai_seminar_arr) / (100 * $parameter_seminar);
        $rata_instansi = array_sum($nilai_instansi_arr) / (100 * $parameter_instansi);

        $nilai_akhir = ($rata_bimbingan * $bobot_nilai['bimbingan']) + ($rata_seminar * $bobot_nilai['seminar']) + ($rata_instansi * $bobot_nilai['instansi']);

        if ($magang->nilai_akhir()->exists())
        {
            $magang->nilai_akhir()->update(['nilai_akhir' => $nilai_akhir]);
        } else {
            $magang->nilai_akhir()->create(['nilai_akhir' => $nilai_akhir]);
        }
        return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'nilai berhasil diubah');
    }

    public function updateNilaiAkhir(Magang $magang, Request $request)
    {
        //validate
        $validated = $request->validate([
            'nilai_akhir' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->route('admin.magang.show', $magang->id_magang)->withErrors($validated);
        }
        //update
        $magang->nilai_akhir()->update($validated);

        //redirect to 'magang.show'
        return redirect()->route('admin.magang.show', $magang->id_magang)->with('berhasil', 'nilai berhasil diubah');
    }
}
