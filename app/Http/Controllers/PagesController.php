<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Informasi;
use App\Models\Dokumen_registrasi;
use App\Models\Berita;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Magang;
use App\Models\Instansi;
use App\Models\Hubungi_kami;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function home()
    {
        $mahasiswa_count = Mahasiswa::where('status', true)->count();
        $instansi_count = Instansi::where('status_instansi', true)->count();
        $magang_count = Magang::count();
        $berita = Berita::where('status_publikasi',1)->get();
        return view('home', ['berita' => $berita, 'mahasiswa_count' => $mahasiswa_count, 'instansi_count' => $instansi_count, 'magang_count' => $magang_count, 'd' => Informasi::where('status_publikasi',1)->get()]);
    }

    public function informasi()
    {
        return view('informasi', ['d' => Informasi::where('status_publikasi',1)->get()]);
    }

    public function kontak()
    {
        return view('kontak', ['d' => Informasi::where('status_publikasi',1)->get()]);
    }

    public function kontakPost(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|max:255|email',
            'subjek' => 'max:255',
            'pesan' => 'required|max:255',
        ]);

        if (!$validated)
        {
            return redirect()->back()->withErrors($validated);
        }
        $validated['subjek'] = $validated['subjek'] ?? 'Tidak ada subjek';
        Hubungi_kami::create($validated);

        return redirect()->back()->with('berhasil', 'Pesan anda berhasil dikirim');
    }

    public function tentang()
    {
        $mahasiswa_count = Mahasiswa::where('status', true)->count();
        $instansi_count = Instansi::where('status_instansi', true)->count();
        $magang_count = Magang::count();
        return view('tentang', ['d' => Informasi::where('status_publikasi',1)->get(), 'mahasiswa_count' => $mahasiswa_count, 'instansi_count' => $instansi_count, 'magang_count' => $magang_count]);
    }

    public function login()
    {
        return view('login');
    }

    public function berita()
    {
        return view('berita', ['search' => null, 'berita' => Berita::where('status_publikasi',1)->get(), 'd' => Informasi::where('status_publikasi',1)->get()]);
    }

    public function beritaPost(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|max:255',
        ]);
        if(!$validated)
        {
            return redirect()->back()->withErrors($validated);
        }
        $berita = Berita::where('judul', 'like', '%'.$validated['query'].'%')
                ->orWhere('deskripsi', 'like', '%'.$validated['query'].'%')
                ->where('status_publikasi', 1)
                ->get();
        return view('berita', ['search' => $validated['query'], 'berita' => $berita, 'd' => Informasi::where('status_publikasi',1)->get()]);
    }

    public function beritaDetail($slug)
    {
        return view('detailberita', ['berita' => Berita::where('slug', $slug)->first(), 'd' => Informasi::where('status_publikasi',1)->get()]);
    }

    public function loginPost(Request $request)
    {
        $admin_email = Admin::first()->email;
        $validated = $request->validate([
            'email' => [
                'required',
                'max:255',
                'email',
                "regex:/^({$admin_email}|[a-zA-Z0-9._%+-]+@(student|staff|mipa)\.uns\.ac\.id)$/i"
            ],
            'password' => 'required|min:8|max:255',
        ], [
            'email.regex' => 'Email harus menggunakan email SSO',
        ]);
        if (!$validated)
        {
            return redirect()->route('login')->withErrors($validated);
        }
        if (Mahasiswa::where('email', $validated['email'])->first() && Mahasiswa::where('email', $validated['email'])->first()->status == false)
        {
            return redirect()->route('login')->withErrors(['gagallogin' => 'Akun anda belum diverifikasi oleh admin']);
        }
        if (Auth::guard('admin')->attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return redirect()->route('admin.dashboard')->with('berhasillogin', 'Berhasil login sebagai admin');
        }
        if (Auth::guard('dosen')->attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return redirect()->route('dosen.dashboard')->with('berhasillogin', 'Berhasil login sebagai dosen');
        }
        if (Auth::guard('mahasiswa')->attempt(['email' => $validated['email'], 'password' => $validated['password'], 'status' => true ]))
        {
            return redirect()->route('mahasiswa.dashboard')->with('berhasillogin', 'Berhasil login sebagai mahasiswa');
        }
        return redirect()->route('login')->withErrors(['gagallogin' => 'Gagal login, cek email dan password anda']);
    }

    public function registerPost(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:mahasiswa|max:255',
            'nama' => 'required|max:255',
            'email' => [
                'required',
                'max:255',
                'email',
                'unique:mahasiswa',
                "regex:/^[a-zA-Z0-9._%+-]+@student\.uns\.ac\.id$/i"
            ],
            'no_telp' => 'required|max:255',
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password|min:8|max:255',
            'krs' => 'required|file|mimes:pdf|max:2048',
            'transkrip' => 'required|file|mimes:pdf|max:2048',
            'bukti_seminar' => 'file|mimes:pdf|max:2048',
        ], [
            'email.regex' => 'Email harus menggunakan email SSO',
        ]);
        if (!$validated)
        {
            return redirect()->route('login', ['register' => 'true'])->withErrors($validated);
        }
        $krs = $request->file('krs');
        $transkrip = $request->file('transkrip');
        //check if bukti_seminar is has file
        if ($request->hasFile('bukti_seminar'))
        {
            $bukti_seminar = $request->file('bukti_seminar');
            $bukti_seminar_name = 'bukti_seminar_'.$validated['nim'].'.pdf';
            $bukti_seminar->move(public_path('documents/bukti-seminar'), $bukti_seminar_name);
        }
        else
        {
            $bukti_seminar_name = null;
        }

        $krs_name = 'krs_'.$validated['nim'].'.pdf';
        $transkrip_name = 'transkrip_'.$validated['nim'].'.pdf';

        $krs->move(public_path('documents/krs'), $krs_name);
        $transkrip->move(public_path('documents/transkrip'), $transkrip_name);
        
        $mahasiswa = Mahasiswa::create([
            'nim' => $validated['nim'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'],
            'password' => Hash::make($validated['password']),
            'status' => false,
        ]);

        $dokumen = Dokumen_registrasi::create([
            'nim' => $validated['nim'],
            'krs' => $krs_name,
            'transkrip' => $transkrip_name,
            'bukti_seminar' => $bukti_seminar_name,
        ]);

        if ($mahasiswa && $dokumen)
        {
            $data = array(
                'name' => $validated['nama'],
            );
        
            Mail::send('emails.register', $data, function ($message) use ($validated) {
        
                $message->from('no-reply@simkmmv2.com', 'SIMKMM D3TI');
        
                $message->to($validated['email'])->subject('Terimakasih telah mendaftar SIMKMM D3TI');
        
            });
            return redirect()->route('login')->with('berhasilregister', 'Berhasil mendaftar, silahkan tunggu verifikasi dari admin');
        }

        return redirect()->route('login', ['register' => 'true'])->withErrors(['gagalregister' => 'Gagal mendaftar, silahkan coba lagi']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('mahasiswa')->logout();
        Auth::guard('dosen')->logout();
        return redirect()->route('login');
    }
}