<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Tahun;
use App\Models\Progres;
use App\Models\Magang;
use App\Models\Topik_kmm;
use App\Models\Bimbingan_dosen;
use App\Models\Bobot_nilai;
use App\Models\Parameter_nilai_bimbingan;
use App\Models\Parameter_nilai_instansi;
use App\Models\Parameter_nilai_seminar;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function dashboard()
    {
        $me =  Auth::guard('dosen')->user();
        return view('dosen.dashboard', [ 'magangs' => ($me->magang()->exists())? $me->magang : null, 'tahuns' => Tahun::all() ]);
    }

    public function profil()
    {
        return view('dosen.profil', [ 'd' => Auth::guard('dosen')->user() ]);
    }

    public function profilUpdate(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:dosen|max:255',
            'nama' => 'required|max:255',
            'email' => [
                'required',
                'max:255',
                'unique:dosen',
                'email',
                "regex:/^[a-zA-Z0-9._%+-]+@(staff|mipa)\.uns\.ac\.id$/i"
            ],
        ], [
            'email.regex' => 'Email harus menggunakan email SSO',
        ]);
        if(!$validated)
        {
            return redirect()->route('dosen.profil')->withErrors($validated);
        }
        $d = Dosen::find(Auth::guard('dosen')->user()->id_dosen);

        if($d->update($validated))
        {
            return redirect()->route('dosen.profil')->with('berhasil', 'Profil berhasil diubah');
        }

        return redirect()->route('dosen.profil')->withErrors(['gagal' => 'Profil gagal diubah']);
    }

    public function profilUbahPassword()
    {
        return view('dosen.profil_password');
    }

    public function profilUbahPasswordUpdate(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password|min:8|max:255',
        ]);
        if(!$validated)
        {
            return redirect()->route('dosen.profil')->withErrors($validated);
        }
        $validated['password'] = Hash::make($validated['password']);
        $dosen = Dosen::find(Auth::guard('dosen')->user()->id_dosen)->update($validated);
        if($dosen)
        {
            return redirect()->route('dosen.profil')->with('berhasil', 'Password berhasil diubah');
        }
        return redirect()->route('dosen.profil')->withErrors(['gagal' => 'Password gagal diubah']);
    }

    public function bidangTopik()
    {
        return view('dosen.bidang_topik', [ 't' => Auth::guard('dosen')->user()->topik, 'lt' => Topik_kmm::all(), 'd' => Auth::guard('dosen')->user() ] );
    }

    public function bidangTopikPost(Request $request)
    {
        $validated = $request->validate([
            'id_topik' => 'required',
        ]);
        if (Topik_kmm::find($validated['id_topik'])->doesntExist()) {
            return redirect()->route('dosen.bidang-topik', ['error' => 'Topik tidak ditemukan']);
        }
        if (Auth::guard('dosen')->user()->topik->contains($validated['id_topik'])) {
            return redirect()->route('dosen.bidang-topik', ['error' => 'Topik sudah diambil']);
        }
        $d = Dosen::find(Auth::guard('dosen')->user()->id_dosen);

        if($d->topik()->attach($validated['id_topik']))
        {
            return redirect()->route('dosen.bidang-topik')->with('berhasil', 'Topik berhasil ditambahkan');
        }

        return redirect()->route('dosen.bidang-topik')->withErrors(['gagal' => 'Topik gagal ditambahkan']);
    }

    public function bidangTopikDelete(Request $request)
    {
        $validated = $request->validate([
            'id_topik' => 'required',
        ]);
        if (Topik_kmm::find($validated['id_topik'])->doesntExist()) {
            return redirect()->route('dosen.bidang-topik', ['error' => 'Topik tidak ditemukan']);
        }
        $d = Dosen::find(Auth::guard('dosen')->user()->id_dosen);

        if($d->topik()->detach($validated['id_topik']))
        {
            return redirect()->route('dosen.bidang-topik')->with('berhasil', 'Topik berhasil dihapus');
        }

        return redirect()->route('dosen.bidang-topik')->withErrors(['gagal' => 'Topik gagal dihapus']);
    }

    public function magang()
    {
        $tahun = Tahun::all();
        $progres = Progres::all();
        $me = Auth::guard('dosen')->user();
        return view('dosen.magang', ['magang' => ($me->magang()->exists())? $me->magang()->orderBy('id_magang', 'desc')->paginate(10) : null, 'magang_all' => ($me->magang()->exists())? $me->magang : null , 'progres' => $progres, 'tahun' => $tahun, 'd' => $me]);
    }

    public function magangShow(Magang $magang)
    {
        $magangg = Magang::find($magang)->first();
        return view('dosen.show_magang', ['magang' => $magangg, 'bimbingan' => $magangg->bimbingan_dosen, 'rencana' => $magangg->rencana_magang, 'a' => Auth::guard('dosen')->user()]);
    }

    public function magangApprove(Magang $magang)
    {
        $magangapp = $magang->update(['status_dosen' => 1, 'id_status_daftar' => 3]);
        if ($magangapp) {
            return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->with('berhasil', 'Magang berhasil disetujui');
        }
        return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->withErrors(['gagal' => 'Magang gagal disetujui']);
    }

    public function magangReject(Magang $magang)
    {
        $magangre = $magang->update(['id_dosen' => null, 'status_dosen' => 0, 'id_status_daftar' => 2]);
        if ($magangre) {
                return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->with('berhasil', 'Magang berhasil ditolak');
        }
        return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->withErrors(['gagal' => 'Magang gagal ditolak']);
    }

    public function MagangBimbinganApprove(Magang $magang, Bimbingan_dosen $bimbingan)
    {
        $bimbinganapp = $bimbingan->update(['status' => 1]);
        if ($bimbinganapp) {
            return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->with('berhasil', 'Bimbingan berhasil disetujui');
        }
        return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->withErrors(['gagal' => 'Bimbingan gagal disetujui']);
    }

    public function MagangBimbinganReject(Magang $magang, Bimbingan_dosen $bimbingan)
    {
        $bimbinganre = $bimbingan->update(['status' => 0]);
        if ($bimbinganre) {
            return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->with('berhasil', 'Bimbingan berhasil ditolak');
        }
        return redirect()->route('dosen.magang.show', ['magang' => $magang, 'active' => 'bimbinganmagang'])->withErrors(['gagal' => 'Bimbingan gagal ditolak']);
    }

    public function seminardanrevisi()
    {
        //all magang that have seminar table
        $me = Auth::guard('dosen')->user();
        $tahun = Tahun::all();
        $progres = Progres::all();
        return view('dosen.list_seminardanrevisi', ['magang' => ($me->magang()->exists())? $me->magang()->orderBy('id_magang', 'desc')->paginate(10) : null, 'magang_all' => ($me->magang()->exists())? $me->magang : null, 'progres' => $progres, 'tahun' => $tahun]);
    }

    public function seminardanrevisiShow(Magang $magang)
    {
        if ($magang->seminar()->exists() && $magang->id_dosen == Auth::guard('dosen')->user()->id_dosen)
        {
            $seminar = $magang->seminar;
            $revisi = ($magang->revisi()->exists())? $magang->revisi : null;
            return view('dosen.show_seminardanrevisi', ['magang' => $magang, 'seminar' => $seminar, 'revisi' => $revisi]);
        }
        return redirect()->route('dosen.seminarrevisi')->withErrors(['gagal' => 'Seminar tidak ditemukan']);
    }

    public function seminarApprove(Magang $magang)
    {
        if (!$magang->seminar()->exists() || $magang->id_dosen != Auth::guard('dosen')->user()->id_dosen)
        {
            return redirect()->route('dosen.seminarrevisi')->withErrors(['gagal' => 'Seminar tidak ditemukan']);
        }
        $seminar = $magang->seminar()->update(['status' => 1]);
        if ($seminar)
        {
            return redirect()->route('dosen.seminarrevisi.show', ['magang' => $magang, 'active' => 'seminar'])->with('berhasil', 'Seminar berhasil disetujui');
        }
        $magang->update(['id_progres' => 4]);
        return redirect()->route('dosen.seminarrevisi.show', ['magang' => $magang, 'active' => 'seminar'])->withErrors(['gagal' => 'Seminar gagal disetujui']);
    }

    public function seminarReject(Magang $magang)
    {
        if (!$magang->seminar()->exists() || $magang->id_dosen != Auth::guard('dosen')->user()->id_dosen)
        {
            return redirect()->route('dosen.seminarrevisi')->withErrors(['gagal' => 'Seminar tidak ditemukan']);
        }
        $seminar = $magang->seminar()->update(['status' => 0]);
        if ($seminar)
        {
            return redirect()->route('dosen.seminarrevisi.show', ['magang' => $magang, 'active' => 'seminar'])->with('berhasil', 'Seminar berhasil ditolak');
        }
        return redirect()->route('dosen.seminarrevisi.show', ['magang' => $magang, 'active' => 'seminar'])->withErrors(['gagal' => 'Seminar gagal ditolak']);
    }

    public function revisiApprove(Magang $magang)
    {
        if(!$magang->revisi()->exists() || $magang->id_dosen != Auth::guard('dosen')->user()->id_dosen)
        {
            return redirect()->route('dosen.seminarrevisi')->withErrors(['gagal' => 'Revisi tidak ditemukan']);
        }
        $revisi = $magang->revisi()->update(['status' => 1]);
        $magang->update(['id_progres' => 5]);
        if ($revisi)
        {
            return redirect()->route('dosen.seminarrevisi.show', ['magang' => $magang, 'active' => 'revisi'])->with('berhasil', 'Revisi berhasil disetujui');
        }
    }

    public function revisiReject(Magang $magang)
    {
        if(!$magang->revisi()->exists() || $magang->id_dosen != Auth::guard('dosen')->user()->id_dosen)
        {
            return redirect()->route('dosen.seminarrevisi')->withErrors(['gagal' => 'Revisi tidak ditemukan']);
        }
        $revisi = $magang->revisi()->update(['status' => 0]);
        if ($revisi)
        {
            return redirect()->route('dosen.seminarrevisi.show', ['magang' => $magang, 'active' => 'revisi'])->with('berhasil', 'Revisi berhasil ditolak');
        }
    }

    public function nilai()
    {
        //all magang that have seminar table
        $me = Auth::guard('dosen')->user();
        $tahun = Tahun::all();
        $progres = Progres::all();
        return view('dosen.list_nilai', ['magang' => ($me->magang()->exists())? $me->magang()->orderBy('id_magang', 'desc')->paginate(10) : null, 'magang_all' => ($me->magang()->exists())? $me->magang : null , 'progres' => $progres, 'tahun' => $tahun]);
    }

    public function nilaiShow(Magang $magang)
    {
        $tahun = $magang->tahun;
        return view('dosen.show_nilai', [
            'magang' => $magang,
            'nilaiseminar' => $magang->nilai_seminar()->exists()? $magang->nilai_seminar()->orderBy('id_parameter', 'asc')->get() : null,
            'nilaibimbingan' => $magang->nilai_bimbingan()->exists()? $magang->nilai_bimbingan()->orderBy('id_parameter', 'asc')->get() : null,      
            'nilaiinstansi' => $magang->nilai_instansi()->exists()? $magang->nilai_instansi : null,
            'nilaiakhir' => $magang->nilai_akhir()->exists()? $magang->nilai_akhir : null,
            'bobot_nilai' => Bobot_nilai::where('tahun', $tahun)->get(),
            'parameter_seminar' => Parameter_nilai_seminar::where('tahun', $tahun)->get(),
            'parameter_instansi' => Parameter_nilai_instansi::where('tahun', $tahun)->get(),
            'parameter_bimbingan' => Parameter_nilai_bimbingan::where('tahun', $tahun)->get()
        ]);
    }

    public function nilaiSeminar(Magang $magang, Request $request)
    {
        $validated = $request->validate([
            'id_parameter' => 'required',
            'nilai_pembimbing' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->route('dosen.nilai.show', $magang->id_magang)->withErrors($validated);
        }
        if ($magang->seminar()->exists() && $magang->id_dosen == Auth::guard('dosen')->user()->id_dosen)
        {
            if ($magang->nilai_seminar()->where('id_parameter',$validated['id_parameter'])->exists())
            {
                $nilai = $magang->nilai_seminar()->where('id_parameter',$validated['id_parameter'])->update(['nilai_pembimbing' => $validated['nilai_pembimbing'], 'nilai' => ($magang->nilai_seminar->nilai_penguji + $validated['nilai_pembimbing'])/2]);
            } else {
                $nilai = $magang->nilai_seminar()->create([
                    'tahun' => $magang->tahun,
                    'id_parameter' => $validated['id_parameter'],
                    'nilai_penguji' => null,
                    'nilai_pembimbing' => $validated['nilai_pembimbing'],
                    'nilai' => null
                ]);
            }
            if (!$nilai)
            {
                return redirect()->route('dosen.nilai.show', $magang->id_magang)->withErrors(['gagal' => 'nilai dimasukkan']);
            }
            return redirect()->route('dosen.nilai.show', $magang->id_magang)->with('berhasil', 'nilai berhasil dimasukkan');
        }
        return redirect()->route('dosen.list_nilai', $magang->id_magang)->with(['gagal' => 'Seminar tidak ditemukan']);
    }

    public function nilaiBimbingan(Magang $magang, Request $request)
    {
        $validated = $request->validate([
            'id_parameter' => 'required',
            'nilai' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->route('dosen.nilai.show', $magang->id_magang)->withErrors($validated);
        }
        if ($magang->nilai_bimbingan()->where('id_parameter',$validated['id_parameter'])->exists())
        {
            return redirect()->route('dosen.nilai.show', $magang->id_magang)->withErrors(['gagal' => 'nilai untuk parameter tersebut sudah ada']);
        }
        $nilai = $magang->nilai_bimbingan()->create([
            'tahun' => $magang->tahun,
            'id_parameter' => $validated['id_parameter'],
            'nilai' => $validated['nilai']
        ]);
        if (!$nilai)
        {
            return redirect()->route('dosen.nilai.show', $magang->id_magang)->withErrors(['gagal' => 'nilai gagal dimasukkan']);
        }
        return redirect()->route('dosen.nilai.show', $magang->id_magang)->with('berhasil', 'nilai berhasil dimasukkan');
    }
    
    public function nilaiAkhir(Magang $magang, Request $request)
    {
        $validated = $request->validate([
            'nilai_akhir' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->route('dosen.nilai.show', $magang->id_magang)->withErrors($validated);
        }
        $nilai = $magang->nilai_akhir()->create([
            'nilai_akhir' => $validated['nilai_akhir']
        ]);
        if (!$nilai)
        {
            return redirect()->route('dosen.nilai.show', $magang->id_magang)->withErrors(['gagal' => 'nilai dimasukkan']);
        }
        return redirect()->route('dosen.nilai.show', $magang->id_magang)->with('berhasil', 'nilai berhasil dimasukkan');
    }

    public function penguji()
    {
        $me = Auth::guard('dosen')->user();
        $tahun = Tahun::all();
        $progres = Progres::all();
        return view('dosen.list_penguji', ['magang' => ($me->magang_penguji()->exists())? $me->magang_penguji()->orderBy('id_magang', 'desc')->paginate(10) : null, 'magang_all' => ($me->magang_penguji()->exists())? $me->magang_penguji : null, 'progres' => $progres, 'tahun' => $tahun]);
    }

    public function pengujiShow(Magang $magang)
    {
        if ($magang->seminar()->exists() && $magang->id_dosen_penguji == Auth::guard('dosen')->user()->id_dosen)
        {
            $seminar = $magang->seminar;
            $tahun = $magang->tahun;
            return view('dosen.show_penguji', [
                'magang' => $magang, 'seminar' => $seminar,
                'dosen_penguji' => Auth::guard('dosen')->user(),
                'nilaiseminar' => $magang->nilai_seminar()->exists()? $magang->nilai_seminar()->orderBy('id_parameter', 'asc')->get() : null,
                'parameter_seminar' => Parameter_nilai_seminar::where('tahun', $tahun)->get()]);
        }
        return redirect()->route('dosen.penguji')->withErrors(['gagal' => 'Seminar tidak ditemukan']);
    }

    public function nilaiPengujiPost(Magang $magang, Request $request)
    {
        $validated = $request->validate([
            'id_parameter' => 'required',
            'nilai_penguji' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->route('dosen.penguji.show', $magang->id_magang)->withErrors($validated);
        }
        if ($magang->seminar()->exists() && $magang->id_dosen_penguji == Auth::guard('dosen')->user()->id_dosen)
        {
            if ($magang->nilai_seminar()->where('id_parameter',$validated['id_parameter'])->exists())
            {
                $nilai = $magang->nilai_seminar()->where('id_parameter',$validated['id_parameter'])->update(['nilai_penguji' => $validated['nilai_penguji'], 'nilai' => ($magang->nilai_seminar->nilai_pembimbing + $validated['nilai_penguji'])/2]);
            } else {
                $nilai = $magang->nilai_seminar()->create([
                    'tahun' => $magang->tahun,
                    'id_parameter' => $validated['id_parameter'],
                    'nilai_penguji' => $validated['nilai_penguji'],
                    'nilai_pembimbing' => null,
                    'nilai' => null
                ]);
            }
            if (!$nilai)
            {
                return redirect()->route('dosen.penguji.show', $magang->id_magang)->withErrors(['gagal' => 'nilai dimasukkan']);
            }
            return redirect()->route('dosen.penguji.show', $magang->id_magang)->with('berhasil', 'nilai berhasil dimasukkan');
        }
        return redirect()->route('dosen.penguji.show', $magang->id_magang)->with(['gagal' => 'Seminar tidak ditemukan']);
    }
}