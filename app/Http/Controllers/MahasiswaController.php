<?php

namespace App\Http\Controllers;

use App\Models\Dokumen_registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Kondisi_mahasiswa;
use Illuminate\Support\Facades\Hash;
use App\Models\Tahun;
use App\Models\Instansi;
use App\Models\Dosen;
use App\Models\Topik_kmm;
use App\Models\Magang;
use App\Models\Rencana_magang;
use App\Models\Progres_pendaftaran_magang;
use App\Models\Bimbingan_dosen;
use Jstewmc\Rtf\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\Bimbingan_instansi;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.dashboard', ['magang' => ($mahasiswa->magang()->exists())? $mahasiswa->magang : null, 'mahasiswa' => $mahasiswa]);
    }

    public function profil()
    {
        return view('mahasiswa.profil', ['m' => Auth::guard('mahasiswa')->user() ]);
    }

    public function profilUpdate(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:mahasiswa|max:255',
            'nama' => 'required|max:255',
            'email' => [
                'required',
                'max:255',
                'email',
                'unique:mahasiswa',
                "regex:/^[a-zA-Z0-9._%+-]+@student\.uns\.ac\.id)$/i"
            ],
            'no_telp' => 'required|max:255'
        ], [
            'email.regex' => 'Email harus menggunakan email SSO',
        ]);

        if(!$validated)
        {
            return redirect()->route('mahasiswa.profil')->withErrors($validated);
        }
       // Find the current Mahasiswa record
        $m = Mahasiswa::find(Auth::guard('mahasiswa')->user()->nim);

        $krs = $m->dokumen->krs;
        $transkrip = $m->dokumen->transkrip;
        $bukti_seminar = $m->dokumen->bukti_seminar;

        $m->dokumen->delete();

        $ma = $m->update($validated);

        $dokumen = Dokumen_registrasi::create([
            'nim' => $validated['nim'],
            'krs' => $krs,
            'transkrip' => $transkrip,
            'bukti_seminar' => $bukti_seminar,
        ]);
        if(!$ma && !$dokumen)
        {
            return redirect()->route('mahasiswa.profil')->withErrors(['gagal' => 'Profil gagal diubah']);
        }
        Auth::guard('mahasiswa')->login($m);

        return redirect()->route('mahasiswa.profil')->with('berhasil', 'Profil berhasil diubah');
    }

    public function profilUbahPassword()
    {
        return view('mahasiswa.profil_password');
    }

    public function profilUbahPasswordUpdate(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|min:8|max:255',
            'password_confirmation' => 'required|same:password|min:8|max:255',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.profil')->withErrors($validated);
        }
        $validated['password'] = Hash::make($validated['password']);
        $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->user()->nim)->update($validated);
        if(!$mahasiswa)
        {
            return redirect()->route('mahasiswa.profil')->withErrors(['gagal' => 'Password gagal diubah']);
        }
        return redirect()->route('mahasiswa.profil')->with('berhasil', 'Password berhasil diubah');
    }

    public function profilKondisiPost(Request $request)
    {
        $validated = $request->validate([
            'fakultas' => 'required',
            'program_prodi' => 'required',
            'alamat_asal_jalan_dan_nomor_rumah' => 'required',
            'alamat_asal_RT_RW' => 'required',
            'alamat_asal_kelurahan' => 'required',
            'alamat_asal_kabupaten_kota' => 'required',
            'alamat_asal_provinsi' => 'required',
            'alamat_di_solo' => 'required',
            'alamat_solo_jalan_dan_nomor_rumah' => 'required',
            'alamat_solo_RT_RW' => 'required',
            'alamat_solo_kelurahan' => 'required',
            'alamat_solo_kecamatan' => 'required',
            'alamat_solo_kabupaten_kota' => 'required',
            'alamat_solo_provinsi' => 'required',
            'alamat_saat_isi' => 'required',
            'alamat_saat_isi_jalan_dan_nomor_rumah' => 'required',
            'alamat_saat_isi_RT_RW' => 'required',
            'alamat_saat_isi_kelurahan' => 'required',
            'alamat_saat_isi_kecamatan' => 'required',
            'alamat_saat_isi_kabupaten_kota' => 'required',
            'alamat_saat_isi_provinsi' => 'required',
            'tanggal_mulai_tinggal_alamat_sekarang' => 'required',
            'moda_dipakai_meninggalkan_solo_ke_alamat_sekarang' => 'required',
            'keadaan_sekarang' => 'required',
            'sakit_keterangan' => 'required',
            'sakit_status_periksa' => 'required',
            'sakit_periksa_diagnosa_saran_dokter' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.profil')->withErrors($validated);
        }
        $validated['nama_lengkap'] = Auth::guard('mahasiswa')->user()->nama;
        $validated['nomor_telepon'] = Auth::guard('mahasiswa')->user()->no_telp;
        $validated['email_SSO'] = Auth::guard('mahasiswa')->user()->email;
        $validated['nomor_induk_mahasiswa'] = Auth::guard('mahasiswa')->user()->nim;
        $validated['tanggal_submit'] = date('Y-m-d');
        $kondisi = Kondisi_mahasiswa::create($validated);
        if($kondisi)
        {
            return redirect()->route('mahasiswa.profil')->with('berhasil', 'Kondisi berhasil disimpan');
        }
        return redirect()->route('mahasiswa.profil')->withErrors(['gagal' => 'Kondisi gagal disimpan']);
    }

    public function profilKondisiUpdate(Request $request)
    {
        $validated = $request->validate([
            'fakultas' => 'required',
            'program_prodi' => 'required',
            'alamat_asal_jalan_dan_nomor_rumah' => 'required',
            'alamat_asal_RT_RW' => 'required',
            'alamat_asal_kelurahan' => 'required',
            'alamat_asal_kabupaten_kota' => 'required',
            'alamat_asal_provinsi' => 'required',
            'alamat_di_solo' => 'required',
            'alamat_solo_jalan_dan_nomor_rumah' => 'required',
            'alamat_solo_RT_RW' => 'required',
            'alamat_solo_kelurahan' => 'required',
            'alamat_solo_kecamatan' => 'required',
            'alamat_solo_kabupaten_kota' => 'required',
            'alamat_solo_provinsi' => 'required',
            'alamat_saat_isi' => 'required',
            'alamat_saat_isi_jalan_dan_nomor_rumah' => 'required',
            'alamat_saat_isi_RT_RW' => 'required',
            'alamat_saat_isi_kelurahan' => 'required',
            'alamat_saat_isi_kecamatan' => 'required',
            'alamat_saat_isi_kabupaten_kota' => 'required',
            'alamat_saat_isi_provinsi' => 'required',
            'tanggal_mulai_tinggal_alamat_sekarang' => 'required',
            'moda_dipakai_meninggalkan_solo_ke_alamat_sekarang' => 'required',
            'keadaan_sekarang' => 'required',
            'sakit_keterangan' => 'required',
            'sakit_status_periksa' => 'required',
            'sakit_periksa_diagnosa_saran_dokter' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.profil')->withErrors($validated);
        }
        $validated['nama_lengkap'] = Auth::guard('mahasiswa')->user()->nama;
        $validated['nomor_telepon'] = Auth::guard('mahasiswa')->user()->no_telp;
        $validated['email_SSO'] = Auth::guard('mahasiswa')->user()->email;
        $validated['nomor_induk_mahasiswa'] = Auth::guard('mahasiswa')->user()->nim;
        $validated['tanggal_submit'] = date('Y-m-d');
        $kondisi = Kondisi_mahasiswa::where('nomor_induk_mahasiswa', Auth::guard('mahasiswa')->user()->nim)->update($validated);
        if(!$kondisi)
        {
            return redirect()->route('mahasiswa.profil')->withErrors(['gagal' => 'Kondisi gagal diubah']);
        }
        return redirect()->route('mahasiswa.profil')->with('berhasil', 'Kondisi berhasil diubah');
    }

    public function profilKondisiDelete()
    {
        $kondisi = Kondisi_mahasiswa::where('nomor_induk_mahasiswa', Auth::guard('mahasiswa')->user()->nim)->delete();
        if(!$kondisi)
        {
            return redirect()->route('mahasiswa.profil')->withErrors(['gagal' => 'Kondisi gagal dihapus']);
        }
        return redirect()->route('mahasiswa.profil')->with('berhasil', 'Kondisi berhasil dihapus');
    }

    public function magang()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        if (!$mahasiswa->magang()->exists())
        {
            return redirect()->route('mahasiswa.magang.daftar');
        }
        $magang = $mahasiswa->magang;
        if (!$magang->progres_daftar_magang()->exists())
        {
            $magang->update([
                'id_status_daftar' => 5,
            ]);
        }
        $progres_daftar = $magang->progres_daftar_magang->id_status_daftar;
        $bimbingan = $magang->bimbingan_dosen;
        $bimbingan_instansi = $magang->bimbingan_instansi;
        if ($mahasiswa->magang->rencana_magang()->exists()) {
            $rencana = $mahasiswa->magang->rencana_magang;
        } else {
           $rencana = null;
        }
        return view('mahasiswa.detail_magang', ['magang' => $magang, 'bimbingan_instansi' => $bimbingan_instansi, 'm' => $mahasiswa, 'progres_daftar' => $progres_daftar, 'bimbingan' => $bimbingan, 'rencana' => $rencana]);
    }

    public function magangPengajuanPost(Request $request)
    {
        $validated = $request->validate([
            'file_surat' => 'required|max:2048',
        ]);

        if (!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->instansi->status_instansi != 1 || $magang->id_status_daftar < 3)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Instansi belum disetujui']);
        }
        if ($magang->id_status_daftar > 3)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Pengajuan magang sudah disetujui']);
        }
        if (!$request->hasFile('file_surat'))
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat tidak ditemukan']);
        }
        $file = $request->file('file_surat');
        $filename = $magang->tahun.'_'.$magang->mahasiswa->nim.'_surat_pengantar_magang.'.$file->getClientOriginalExtension();

        $upload = $file->move(public_path('documents/pengajuan-instansi'), $filename);

        if (!$upload)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat gagal diunggah']);
        }
        $validated['jenis_surat'] = 1;
        $validated['file_surat'] = $filename;
        $validated['no_urut'] = $magang->surat_magang()->count() + 1;
        $validated['nomor_surat'] = 'nomor_surat'; //TODO: nomor surat
        $data = $magang->surat_magang()->create($validated);
        if (!$data)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Surat gagal diunggah']);
        }
        $magang->update([
            'id_status_daftar' => 3,
        ]);
        return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->with('berhasil', 'Surat berhasil diunggah');
    }

    public function magangPengajuanUpdate(Request $request)
    {
        $validated = $request->validate([
            'file_surat' => 'required|max:2048',
        ]);
        if (!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        $surat = $magang->surat_magang->where('jenis_surat', 1)->first();
        if ($magang->instansi->status_instansi != 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Instansi belum disetujui']);
        }
        if ($magang->id_status_daftar > 3)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Pengajuan magang sudah disetujui']);
        }
        if (!$request->hasFile('file_surat'))
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat tidak ditemukan']);
        }
        $file = $request->file('file_surat');
        $filename = $magang->tahun.'_'.$magang->mahasiswa->nim.'_surat_pengantar_magang.'.$file->getClientOriginalExtension();
        //delete old file and replace with new one
        $old_file = public_path('documents/pengajuan-instansi/'.$surat->file_surat);
        if (File::exists($old_file))
        {
            File::delete($old_file);
        }
        $upload = $file->move(public_path('documents/pengajuan-instansi'), $filename);
        if (!$upload)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat gagal diunggah']);
        }
        $validated['file_surat'] = $filename;
        $validated['nomor_surat'] = 'nomor_surat'; //TODO: nomor surat
        $validated['no_urut'] = $surat->no_urut;
        $validated['jenis_surat'] = $surat->jenis_surat;
        $data = $surat->update($validated);
        if (!$data)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Surat gagal diunggah']);
        }
        $magang->update([
            'id_status_daftar' => 3,
        ]);
        return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->with('berhasil', 'Surat berhasil diunggah');
    }

    public function magangSerahTerimaPost(Request $request)
    {
        set_time_limit(3000);
        //validate
        $validated = $request->validate([
            'nama_mahasiswa' => 'required',
            'nim' => 'required',
            'nama_pembimbing' => 'required',
            'nik'=> 'required',
            'nomor_telepon_pembimbing' => 'required',
            'nama_instansi' => 'required',
            'alamat_instansi' => 'required',
            'rencana_judul' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);
        if (!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors($validated);
        }

        //check if magang exists
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->instansi->status_instansi > 2)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Instansi belum disetujui']);
        }
        if ($magang->id_status_daftar > 3)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Serah terima magang sudah disetujui']);
        }
        if ($magang->id_status_daftar < 3)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'pembimbing belum ditentukan']);
        }
        $path = 'documents/surat_serah_terima.rtf';

        $tahun_pelajaran = "...........";
        $tahun = date('Y');
        $bulan = date('n');
        if ($bulan < 7)
        {
            $tahun_pelajaran = ($tahun-1)."/".$tahun;
        } else
        {
            $tahun_pelajaran = $tahun."/".$tahun+1;
        }

        $array_bulan = ['Januari','Februari','Maret','April','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        $bulan_sekarang = $array_bulan[date('n')-1];

        $tgl_sekarang = date('d').' '.$bulan_sekarang.' '.date('Y');

        $tanggal_mulai = Carbon::parse($validated['tanggal_mulai']);
        $tanggal_selesai = Carbon::parse($validated['tanggal_selesai']);

        // Create a new RTF document from the file
        $document = new Document($path);
    
        // Access the content of the RTF document
        $content = $document->write();

        $content = str_replace("fill_nomor_dokumen", "...........", $content);
        $content = str_replace("fill_nama_pembimbing", $validated['nama_pembimbing'], $content);
        $content = str_replace("fill_nik", $validated['nik'], $content);
        $content = str_replace("fill_nomor_telepon_pembimbing", $validated['nomor_telepon_pembimbing'], $content);
        $content = str_replace("fill_nama_mahasiswa", $validated['nama_mahasiswa'], $content);
        $content = str_replace("fill_nim", $validated['nim'], $content);
        $content = str_replace("fill_nama_instansi", $validated['nama_instansi'], $content);
        $content = str_replace("fill_alamat_instansi", $validated['alamat_instansi'], $content);
        $content = str_replace("fill_tanggal_mulai", $tanggal_mulai->format('d') . ' ' . $array_bulan[$tanggal_mulai->month - 1] . ' ' . $tanggal_mulai->format('Y'), $content);
        $content = str_replace("fill_tanggal_selesai", $tanggal_selesai->format('d') . ' ' . $array_bulan[$tanggal_selesai->month - 1] . ' ' . $tanggal_selesai->format('Y'), $content);
        $content = str_replace("fill_tanggal_sekarang", $tgl_sekarang, $content);
        $content = str_replace("FILL_NAMA_PEMBIMBING", strtoupper($validated['nama_pembimbing']), $content);
        $content = str_replace("FILL_TAHUN_PELAJARAN", $tahun_pelajaran, $content);
        $content = str_replace("fill_rencana_judul", $validated['rencana_judul'], $content);
        $content = str_replace("FILL_NAMA_MAHASISWA", strtoupper($validated['nama_mahasiswa']), $content);
        

        //save the file to documents/pengajuan-instansi
        $filename = $magang->tahun.'_'.$magang->mahasiswa->nim.'_surat_serah_terima.rtf';
        $path = public_path('documents/pengajuan-instansi/'.$filename);
        //check if file exists
        if (File::exists($path))
        {
            File::delete($path);
        }

        //make file with content
        $document = new Document($content);
        $document->save($path);
        
        $data = $magang->surat_magang()->create([
            'jenis_surat' => 2, //2 = surat serah terima
            'nomor_surat' => '000/ST/2021',
            'file_surat' => $filename,
            'no_urut' => $magang->surat_magang()->count() + 1,
        ]);

        //return redirect to url $path
        return redirect()->to('documents/pengajuan-instansi/'.$filename);
    }

    public function magangSerahTerimaUpdate(Request $request)
    {
        set_time_limit(3000);
        //validate
        $validated = $request->validate([
            'nama_mahasiswa' => 'required',
            'nim' => 'required',
            'nama_pembimbing' => 'required',
            'nik'=> 'required',
            'nomor_telepon_pembimbing' => 'required',
            'nama_instansi' => 'required',
            'alamat_instansi' => 'required',
            'rencana_judul' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);
        if (!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors($validated);
        }

        //check if magang exists
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->instansi->status_instansi > 2)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Instansi belum disetujui']);
        }
        if ($magang->id_status_daftar > 3)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Serah terima magang sudah disetujui']);
        }
        if ($magang->id_status_daftar < 3)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'pembimbing belum ditentukan']);
        }
        $path = 'documents/surat_serah_terima.rtf';

        $tahun_pelajaran = "...........";
        $tahun = date('Y');
        $bulan = date('n');
        if ($bulan < 7)
        {
            $tahun_pelajaran = ($tahun-1)."/".$tahun;
        } else
        {
            $tahun_pelajaran = $tahun."/".$tahun+1;
        }

        $array_bulan = ['Januari','Februari','Maret','April','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        $bulan_sekarang = $array_bulan[date('n')-1];

        $tgl_sekarang = date('d').' '.$bulan_sekarang.' '.date('Y');

        // Create a new RTF document from the file
        $document = new Document($path);
    
        // Access the content of the RTF document
        $content = $document->write();

        $content = str_replace("fill_nomor_dokumen", "...........", $content);
        $content = str_replace("fill_nama_pembimbing", $validated['nama_pembimbing'], $content);
        $content = str_replace("fill_nik", $validated['nik'], $content);
        $content = str_replace("fill_nomor_telepon_pembimbing", $validated['nomor_telepon_pembimbing'], $content);
        $content = str_replace("fill_nama_mahasiswa", $validated['nama_mahasiswa'], $content);
        $content = str_replace("fill_nim", $validated['nim'], $content);
        $content = str_replace("fill_nama_instansi", $validated['nama_instansi'], $content);
        $content = str_replace("fill_alamat_instansi", $validated['alamat_instansi'], $content);
        $content = str_replace("fill_tanggal_mulai", $validated['tanggal_mulai'], $content);
        $content = str_replace("fill_tanggal_selesai", $validated['tanggal_selesai'], $content);
        $content = str_replace("fill_tanggal_sekarang", $tgl_sekarang, $content);
        $content = str_replace("FILL_NAMA_PEMBIMBING", strtoupper($validated['nama_pembimbing']), $content);
        $content = str_replace("FILL_TAHUN_PELAJARAN", $tahun_pelajaran, $content);
        $content = str_replace("fill_rencana_judul", $validated['rencana_judul'], $content);
        $content = str_replace("FILL_NAMA_MAHASISWA", strtoupper($validated['nama_mahasiswa']), $content);
        

        //save the file to documents/pengajuan-instansi
        $filename = $magang->tahun.'_'.$magang->mahasiswa->nim.'_surat_serah_terima.rtf';
        $path = public_path('documents/pengajuan-instansi/'.$filename);
        //check if file exists
        if (File::exists($path))
        {
            File::delete($path);
        }

        //make file with content
        $document = new Document($content);
        $document->save($path);
        
        $magang->surat_magang()->where('jenis_surat', 2)->update([
            'jenis_surat' => 2, //2 = surat serah terima
            'nomor_surat' => '000/ST/2021',
            'file_surat' => $filename,
            'no_urut' => $magang->surat_magang()->count() + 1,
        ]);

        //download the file
        return redirect()->to('documents/pengajuan-instansi/'.$filename);
    }

    public function magangJawabanPost(Request $request)
    {
        $validated = $request->validate([
            'file_surat' => 'required|max:2048',
        ]);
        if (!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->instansi->status_instansi != 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Instansi belum disetujui']);
        }
        if ($magang->id_status_daftar < 4)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Pengajuan belum disetujui']);
        }
        if ($magang->id_status_daftar > 4)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Jawban magang sudah diverifikasi']);
        }
        if (!$request->hasFile('file_surat'))
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat tidak ditemukan']);
        }
        if($magang->surat_jawaban()->exists())
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat sudah diunggah']);
        }
        $file = $request->file('file_surat');
        $filename = $magang->tahun.'_'.$magang->mahasiswa->nim.'_surat_jawaban.'.$file->getClientOriginalExtension();
        $upload = $file->move(public_path('documents/jawaban-instansi'), $filename);
        if (!$upload)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat gagal diunggah']);
        }
        $validated['file_surat'] = $filename;
        $data = $magang->surat_jawaban()->create($validated);
        $magang->update([
            'status_diterima_instansi' => null,
        ]);
        if (!$data)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Surat gagal diunggah']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->with('berhasil', 'Surat berhasil diunggah');
    }

    public function suratJawabanUpdate(Request $request)
    {
        $validated = $request->validate([
            'file_surat' => 'required|max:2048',
        ]);
        if (!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->instansi->status_instansi != 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Instansi belum disetujui']);
        }
        if ($magang->id_status_daftar < 4)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Pengajuan belum disetujui']);
        }
        if ($magang->id_status_daftar > 4)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Jawban magang sudah diverifikasi']);
        }
        if (!$request->hasFile('file_surat'))
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat tidak ditemukan']);
        }
        if($magang->surat_jawaban()->exists())
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat sudah diunggah']);
        }
        $file = $request->file('file_surat');
        $filename = $magang->tahun.'_'.$magang->mahasiswa->nim.'_surat_jawaban.'.$file->getClientOriginalExtension();
        //check if file exists then delete
        $path = public_path('documents/jawaban-instansi/'.$magang->surat_jawaban->file_surat);
        if (File::exists($path))
        {
            File::delete($path);
        }
        
        $upload = $file->move(public_path('documents/jawaban-instansi'), $filename);
        if (!$upload)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'File surat gagal diunggah']);
        }
        $validated['file_surat'] = $filename;
        $data = $magang->surat_jawaban()->update($validated);
        $magang->update([
            'status_diterima_instansi' => null,
            'id_status_daftar' => 4,
        ]);
        if (!$data)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->withErrors(['gagal' => 'Surat gagal diunggah']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'suratmagang'])->with('berhasil', 'Surat berhasil di update');
    }

    public function magangDaftar()
    {
        $tahun = Tahun::all();
        $instansi = Instansi::all();
        $dosen = Dosen::all();
        $topik = Topik_kmm::all();
        $mahasiswa = Auth::guard('mahasiswa')->user();
        if ($mahasiswa->magang()->exists())
        {
            $magang = $mahasiswa->magang;
            if (!$magang->progres_daftar_magang()->exists())
            {
                $magang->update(['id_status_daftar' => 4]);
            }
            if ($magang->id_status_daftar == 1 && $magang->instansi->status_instansi == 1)
            {
                $magang->update([
                    'id_status_daftar' => 2,
                ]);
            }
        } else {
            $magang = null;
        }
        return view('mahasiswa.daftar_magang', ['m' => $mahasiswa, 'magang' => $magang, 'tahun' => $tahun, 'instansi' => $instansi, 'd' => $dosen, 'topik' => $topik]);
    }

    public function magangDaftarTahunTopikInstansi(Request $request)
    {
        $validated1 = $request->validate([
            'instansi' => 'required|in:baru,lama',
            'id_topik' => 'required',
        ]);
        if(!$validated1)
        {
            return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Harap pilih instansi atau buat baru']);
        }
        $mahasiswa = Auth::guard('mahasiswa')->user();
        switch($validated1['instansi'])
        {
            case 'lama' :
                $validated2 = $request->validate([
                    'id_instansi' => 'required',
                ]);
                if(!$validated2)
                {
                    return redirect()->route('mahasiswa.magang.add')->withErrors($validated2);
                }
            break;
            case 'baru' :
                $validated2 = $request->validate([
                    'nama' => 'required',
                    'alamat' => 'required',
                    'no_telp' => 'required',
                    'email' => 'required|email',
                    'web' => 'required',
                ]);
                if(!$validated2)
                {
                    return redirect()->route('mahasiswa.magang.add')->withErrors($validated2);
                }
                $validated2['status_email'] = 0;
                $validated2['status_instansi'] = null;
                $instansi = Instansi::create($validated2);
                if(!$instansi)
                {
                    return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Instansi gagal ditambahkan']);
                }
                $validated2['id_instansi'] = $instansi->id_instansi;
                unset($validated2['nama']);
                unset($validated2['alamat']);
                unset($validated2['no_telp']);
                unset($validated2['email']);
                unset($validated2['web']);
                unset($validated2['status_email']);
                unset($validated2['status_instansi']);
            break;
        }
        if(!$validated2)
        {
            return redirect()->route('mahasiswa.magang.add')->withErrors($validated2);
        }
        $validated1['id_instansi'] = $validated2['id_instansi'];
        $validated1['status_pengajuan_instansi'] = null;
        $validated1['status_diterima_instansi'] = null;
        $validated1['id_dosen'] = null;
        $validated1['status_dosen'] = null;
        $validated1['id_progres'] = 1;
        $validated1['id_status_daftar'] = 1;
        $validated1['tahun'] = date('Y');
        unset($validated1['instansi']);

        if($mahasiswa->magang()->exists())
        {
            return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Magang sudah ada']);
        } else {
            $magang_create = $mahasiswa->magang()->create($validated1);
            if(!$magang_create)
            {
                return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Magang gagal ditambahkan']);
            }
            return redirect()->route('mahasiswa.magang')->with(['success' => 'Magang berhasil ditambahkan']);
        }
    }

    public function magangDaftarTahunTopikInstansiUpdate(Request $request)
    {
        $validated1 = $request->validate([
            'instansi' => 'required|in:baru,lama',
            'id_topik' => 'required',
        ]);
        if(!$validated1)
        {
            return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Harap pilih instansi atau buat baru']);
        }
        $mahasiswa = Auth::guard('mahasiswa')->user();
        switch($validated1['instansi'])
        {
            case 'lama' :
                $validated2 = $request->validate([
                    'id_instansi' => 'required',
                ]);
                if(!$validated2)
                {
                    return redirect()->route('mahasiswa.magang.add')->withErrors($validated2);
                }
            break;
            case 'baru' :
                $validated2 = $request->validate([
                    'nama' => 'required',
                    'alamat' => 'required',
                    'no_telp' => 'required',
                    'email' => 'required|email',
                    'web' => 'required',
                ]);
                if(!$validated2)
                {
                    return redirect()->route('mahasiswa.magang.add')->withErrors($validated2);
                }
                $validated2['status_email'] = 0;
                $validated2['status_instansi'] = null;
                $instansi = Instansi::create($validated2);
                if(!$instansi)
                {
                    return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Instansi gagal ditambahkan']);
                }
                $validated2['id_instansi'] = $instansi->id_instansi;
                unset($validated2['nama']);
                unset($validated2['alamat']);
                unset($validated2['no_telp']);
                unset($validated2['email']);
                unset($validated2['web']);
                unset($validated2['status_email']);
                unset($validated2['status_instansi']);
            break;
        }
        if(!$validated2)
        {
            return redirect()->route('mahasiswa.magang.add')->withErrors($validated2);
        }

        //instansi tidak disetujui, penerimaan magang belum diverifikasi
        if ($mahasiswa->magang()->exists()) {
            $magang = $mahasiswa->magang()->first();
            if ($magang->instansi->status_instansi == 0 || ($magang->instansi->status_instansi == 1 && ($magang->status_pengajuan_instansi == 0 || $magang->status_diterima_instansi == 0))) {
                $validated1['id_instansi'] = $validated2['id_instansi'];
                $validated1['status_pengajuan_instansi'] = null;
                $validated1['status_diterima_instansi'] = null;
                $validated1['id_dosen'] = null;
                $validated1['status_dosen'] = null;
                $validated1['id_progres'] = 1;
                $validated1['tahun'] = date('Y');
                $validated1['id_status_daftar'] = 1;
                unset($validated1['instansi']);
        
                //update magang
                $magang_update = $mahasiswa->magang()->update($validated1);
        
                if (!$magang_update) {
                    return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Magang gagal diupdate']);
                }
        
                $magang = $mahasiswa->magang()->first();
        
                if ($magang->surat_jawaban()->exists())
                {
                    $old_file = public_path('documents/jawaban-instansi/'.$magang->surat_jawaban->file_surat);
                    if (File::exists($old_file))
                    {
                        File::delete($old_file);
                    }
                    $magang->surat_jawaban()->delete();
                }
                if ($magang->surat_magang->count() > 0)
                {
                    foreach($magang->surat_magang as $surat)
                    {
                        $old_file = public_path('documents/pengajuan-instansi/'.$surat->file_surat);
                        if (File::exists($old_file))
                        {
                            File::delete($old_file);
                        }
                        $surat->delete();
                    }
                }
        
                return redirect()->route('mahasiswa.magang')->with(['sukses' => 'Magang berhasil diupdate']);
            }
            return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Magang tidak bisa diupdate']);
        }
        return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Magang tidak ada']);
    }

    public function magangDaftarDosen(Request $request)
    {
        //validated
        $validated = $request->validate([
            'id_dosen' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.magang.add')->withErrors($validated);
        }
        $mahasiswa = Auth::guard('mahasiswa')->user();
        if ($mahasiswa->magang->status_dosen == 1)
        {
            return redirect()->route('mahasiswa.magang')->withErrors(['gagal' => 'Dosen sudah ditentukan']);
        }
        $topik = $mahasiswa->magang->topik;
        $topik_dosen = $topik->dosen->pluck('id_dosen')->toArray();
        if(in_array($validated['id_dosen'], $topik_dosen))
        {
            $dosen_add = $mahasiswa->magang->dosen()->associate($validated['id_dosen']);
            if(!$dosen_add)
            {
                return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Dosen gagal ditambahkan']);
            }
            $progres = $mahasiswa->magang->update(['id_status_daftar' => 2, 'status_dosen' => null]);
            if (!$progres)
            {
                return redirect()->route('mahasiswa.magang')->withErrors(['gagal' => 'Progres gagal ditambahkan']);
            }
            return redirect()->route('mahasiswa.magang')->with('berhasil', 'Dosen berhasil ditambahkan');
        } else {
            return redirect()->route('mahasiswa.magang')->withErrors(['gagal' => 'Dosen tidak terdaftar pada topik magang']);
        }
    }

    public function magangDaftarDosenUpdate(Request $request)
    {
        //validated
        $validated = $request->validate([
            'id_dosen' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.magang.add')->withErrors($validated);
        }
        $mahasiswa = Auth::guard('mahasiswa')->user();
        if ($mahasiswa->magang->status_dosen == 1)
        {
            return redirect()->route('mahasiswa.magang')->withErrors(['gagal' => 'Dosen sudah ditentukan']);
        }
        $topik = $mahasiswa->magang->topik;
        $topik_dosen = $topik->dosen->pluck('id_dosen')->toArray();
        if(in_array($validated['id_dosen'], $topik_dosen))
        {
            $dosen_add = $mahasiswa->magang->update(['id_dosen' => $validated['id_dosen'], 'status_dosen' => null]);
            if(!$dosen_add)
            {
                return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Dosen gagal diubah']);
            }
            return redirect()->route('mahasiswa.magang.add')->with('berhasil', 'Dosen berhasil diubah');
        } else {
            return redirect()->route('mahasiswa.magang.add')->withErrors(['gagal' => 'Dosen tidak terdaftar pada topik magang']);
        }
    }

    public function magangDaftarBimbinganDosenPost(Request $request)
    {
        $validated = $request->validate([
            'data_bimbingan' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors($validated);
        }
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $dosen_exist = $mahasiswa->magang->dosen()->exists();
        $status_dosen = $mahasiswa->magang->status_dosen;
        if(!$dosen_exist || $status_dosen == 0)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Anda belum memiliki dosen pembimbing']);
        }
        if($mahasiswa->magang->id_status_daftar < 5)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Anda belum selesai daftar magang']);
        }

        $bimbingan = $mahasiswa->magang->bimbingan_dosen()->create([
            'data_bimbingan' => $validated['data_bimbingan'],
            'tanggal' => date('Y-m-d'),
            'status' => null
        ]);
        if (!$bimbingan) {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Bimbingan gagal ditambahkan']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->with('berhasil', 'Bimbingan berhasil ditambahkan');
    }

    public function magangDaftarBimbinganDosenUpdate(Bimbingan_dosen $bimbingan, Request $request)
    {
        $validated = $request->validate([
            'data_bimbingan' => 'required',
        ]);

        if(!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors($validated);
        }

        $mahasiswa = Auth::guard('mahasiswa')->user();

        $dosen_exist = $mahasiswa->magang->dosen()->exists();
        $status_dosen = $mahasiswa->magang->status_dosen;
        if(!$dosen_exist || $status_dosen == 0)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Anda belum memiliki dosen pembimbing']);
        }
        if($mahasiswa->magang->id_status_daftar < 5)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Anda belum selesai daftar magang']);
        }
        if ($bimbingan->id_magang != $mahasiswa->magang->id_magang)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Bimbingan tidak terdaftar']);
        }
        if ($bimbingan->status == 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Bimbingan sudah selesai']);
        }
        $bimbingan = $mahasiswa->magang->bimbingan_dosen()->where('id_bimbingan_dosen', $bimbingan->id_bimbingan_dosen)->update([
            'data_bimbingan' => $validated['data_bimbingan'],
            'tanggal' => date('Y-m-d'),
            'status' => null
        ]);
        if (!$bimbingan) {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Bimbingan gagal diubah']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->with('berhasil', 'Bimbingan berhasil diubah');
    }

    public function magangDaftarBimbinganDosenDelete(Bimbingan_dosen $bimbingan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $dosen_exist = $mahasiswa->magang->dosen()->exists();
        $status_dosen = $mahasiswa->magang->status_dosen;
        if(!$dosen_exist || $status_dosen == 0)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Anda belum memiliki dosen pembimbing']);
        }
        if($mahasiswa->magang->id_status_daftar < 5)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Anda belum selesai daftar magang']);
        }
        if ($bimbingan->id_magang != $mahasiswa->magang->id_magang)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Bimbingan tidak terdaftar']);
        }
        if ($bimbingan->status == 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Bimbingan sudah selesai']);
        }
        $bimbingan = $mahasiswa->magang->bimbingan_dosen()->where('id_bimbingan_dosen', $bimbingan->id_bimbingan_dosen)->delete();
        if (!$bimbingan) {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->withErrors(['gagal' => 'Bimbingan gagal dihapus']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'bimbingandosen'])->with('berhasil', 'Bimbingan berhasil dihapus');
    }

    public function magangDaftarBimbinganInstansiPost(Request $request)
    {
        $validated = $request->validate([
            'data_bimbingan' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors($validated);
        }
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if($mahasiswa->magang->id_status_daftar < 5)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Anda belum selesai daftar magang']);
        }

        $bimbingan = $mahasiswa->magang->bimbingan_instansi()->create([
            'data_bimbingan' => $validated['data_bimbingan'],
            'tanggal' => date('Y-m-d'),
            'status' => null
        ]);
        if (!$bimbingan) {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Bimbingan gagal ditambahkan']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->with('berhasil', 'Bimbingan berhasil ditambahkan');
    }

    public function magangDaftarBimbinganInstansiUpdate(Bimbingan_instansi $bimbingan, Request $request)
    {
        $validated = $request->validate([
            'data_bimbingan' => 'required',
        ]);

        if(!$validated)
        {
            return redirect()->route('mahasiswa.bimbingan_dosen', ['active' => 'bimbinganinstansi'])->withErrors($validated);
        }

        $mahasiswa = Auth::guard('mahasiswa')->user();

        if($mahasiswa->magang->id_status_daftar < 5)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Anda belum selesai daftar magang']);
        }
        if ($bimbingan->id_magang != $mahasiswa->magang->id_magang)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Bimbingan tidak terdaftar']);
        }
        if ($bimbingan->status == 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Bimbingan sudah selesai']);
        }

        $bimbingan = $mahasiswa->magang->bimbingan_instansi()->where('id_bimbingan_instansi', $bimbingan->id_bimbingan_instansi)->update([
            'data_bimbingan' => $validated['data_bimbingan'],
            'tanggal' => date('Y-m-d'),
            'status' => null
        ]);
        if (!$bimbingan) {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Bimbingan gagal diubah']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->with('berhasil', 'Bimbingan berhasil diubah');
    }

    public function magangDaftarBimbinganInstansiDelete(Bimbingan_instansi $bimbingan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if($mahasiswa->magang->id_status_daftar < 5)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Anda belum selesai daftar magang']);
        }
        if ($bimbingan->id_magang != $mahasiswa->magang->id_magang)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Bimbingan tidak terdaftar']);
        }
        if ($bimbingan->status == 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Bimbingan sudah selesai']);
        }
        $bimbingan = $mahasiswa->magang->bimbingan_instansi()->where('id_bimbingan_instansi', $bimbingan->id_bimbingan_instansi)->delete();
        if (!$bimbingan) {
            return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->withErrors(['gagal' => 'Bimbingan gagal dihapus']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'bimbinganinstansi'])->with('berhasil', 'Bimbingan berhasil dihapus');
    }

    public function magangRencana(Request $request)
    {
        $validated = $request->validate([
            'kegiatan' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->id_status_daftar > 2  || $magang->status_dosen == 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors(['gagal' => 'Anda tidak dapat menambahkan rencana magang']);
        }
        $rencana_last = $magang->rencana_magang()->orderBy('minggu', 'desc')->first();
        if($rencana_last)
        {
            $validated['minggu'] = $rencana_last->minggu + 1;
        } else {
            $validated['minggu'] = 1;
        }
        
        $rencana = $magang->rencana_magang()->create($validated);
        if(!$rencana)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors(['gagal' => 'Rencana Magang gagal ditambahkan']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->with('berhasil', 'Rencana Magang berhasil ditambahkan');;
    }

    public function magangRencanaUpdate(Rencana_magang $rencana, Request $request)
    {
        $validated = $request->validate([
            'kegiatan' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;

        if ($magang->id_status_daftar > 2  || $magang->status_dosen == 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors(['gagal' => 'Anda tidak dapat menambahkan rencana magang']);
        }

        $validated['id_magang'] = $magang->id_magang;

        $rencanaa = Rencana_magang::where('id_rencana', $rencana->id_rencana)->update($validated);
        if(!$rencanaa)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors(['gagal' => 'Rencana Magang gagal diubah']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->with('berhasil', 'Rencana Magang berhasil diubah');;
    }

    public function magangRencanaDelete()
    {
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->id_status_daftar > 2  || $magang->status_dosen == 1)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors(['gagal' => 'Anda tidak dapat menambahkan rencana magang']);
        }
        $rencanaa = Rencana_magang::orderBy('minggu', 'desc')->first()->delete();
        if(!$rencanaa)
        {
            return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->withErrors(['gagal' => 'Rencana Magang gagal dihapus']);
        }
        return redirect()->route('mahasiswa.magang', ['active' => 'rencanamagang'])->with('berhasil', 'Rencana Magang berhasil dihapus');;
    }
    
    public function seminar()
    {
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if (!$magang || $magang->id_status_daftar < 5) {
            return redirect()->route('mahasiswa.magang')->withErrors(['gagal' => 'Harap selesaikan bimbingan magang terlebih dahulu']);
        }
        if ($magang->seminar()->exists()) {
            $seminar = $magang->seminar;
        } else {
            $seminar = null;
        }
        return view('mahasiswa.seminar', ['magang' => $magang, 'seminar' => $seminar]);
    }

    public function seminarPost(Request $request)
    {
        $validated = $request->validate([
            'judul_kmm' => 'required',
            'draft_kmm' => 'required',
            'foto' => 'required',
            'krs' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang->bimbingan_dosen()->where('status',1)->count() < 5 || $magang->bimbingan_instansi()->where('status',1)->count() < 5)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors(['gagal' => 'Anda tidak dapat menambahkan seminar']);
        }
        if ($request->hasFile('draft_kmm')) {
            $validated['draft_kmm'] = $request->file('draft_kmm')->store('public/draft_kmm');
        }
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('public/foto');
        }
        if ($request->hasFile('krs')) {
            $validated['krs'] = $request->file('krs')->store('public/krs');
        }
        $validated['status'] = null;
        $validated['tgl_daftar'] = date('Y-m-d');
        $seminar = $magang->seminar()->create($validated);
        if(!$seminar)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors(['gagal' => 'Seminar gagal ditambahkan']);
        }
        $magang->update(['id_progres' => 3]);
        return redirect()->route('mahasiswa.seminar')->with('berhasil', 'Seminar berhasil ditambahkan');
    }

    public function seminarTanggalUpdate(Request $request)
    {
        $validated = $request->validate([
            'tgl_seminar' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        $seminar = $magang->seminar()->update($validated);
        if(!$seminar)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors(['gagal' => 'Seminar gagal diubah']);
        }
        return redirect()->route('mahasiswa.seminar')->with('berhasil', 'Seminar berhasil diubah');
    }

    public function seminarDelete()
    {
        $magang = Auth::guard('mahasiswa')->user()->magang;
        $seminar = $magang->seminar()->delete();
        if(!$seminar)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors(['gagal' => 'Seminar gagal dihapus']);
        }
        return redirect()->route('mahasiswa.seminar')->with('berhasil', 'Seminar berhasil dihapus');
    }

    public function revisi()
    {
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang == null)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors(['gagal' => 'Seminar belum selesai']);
        }
        if (!$magang->seminar()->exists() || $magang->seminar->status != 1)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors(['gagal' => 'Seminar belum selesai']);
        }
        if ($magang->revisi()->exists()) {
            $revisi = $magang->revisi;
        } else {
            $revisi = null;
        }
        return view('mahasiswa.revisi', ['magang' => $magang, 'revisi' => $revisi]);
    }

    public function revisiPost(Request $request)
    {
        $validated = $request->validate([
            'laporan_revisi' => 'required',
            'selesai_kmm' => 'required',
            'daftar_hadir' => 'required',
        ]);
        if(!$validated)
        {
            return redirect()->route('mahasiswa.revisi')->withErrors($validated);
        }
        if ($request->hasFile('laporan_revisi')) {
            $validated['laporan_revisi'] = $request->file('laporan_revisi')->store('public/laporan_revisi');
        }
        if ($request->hasFile('selesai_kmm')) {
            $validated['selesai_kmm'] = $request->file('selesai_kmm')->store('public/selesai_kmm');
        }
        if ($request->hasFile('daftar_hadir')) {
            $validated['daftar_hadir'] = $request->file('daftar_hadir')->store('public/daftar_hadir');
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;
        $validated['status'] = null;
        $validated['tgl_upload'] = date('Y-m-d');
        $revisi = $magang->revisi()->create($validated);
        if(!$revisi)
        {
            return redirect()->route('mahasiswa.revisi')->withErrors(['gagal' => 'Revisi gagal ditambahkan']);
        }
        return redirect()->route('mahasiswa.revisi')->with('berhasil', 'Revisi berhasil ditambahkan');
    }

    public function nilai()
    {
        $magang = Auth::guard('mahasiswa')->user()->magang;
        if ($magang == null)
        {
            return redirect()->route('mahasiswa.seminar')->withErrors(['gagal' => 'Seminar belum selesai']);
        }
        return view('mahasiswa.nilai', [
            'magang' => $magang,
            'nilaibimbingan' => $magang->nilai_bimbingan()->exists()? $magang->nilai_bimbingan()->orderBy('id_parameter', 'asc')->get() : null,
            'nilaiinstansi' => $magang->nilai_instansi()->exists()? $magang->nilai_instansi : null,
            'nilaiseminar' => $magang->nilai_seminar()->exists()? $magang->nilai_seminar()->orderBy('id_parameter', 'asc')->get() : null,
            'nilaiakhir' => $magang->nilai_akhir()->exists()? $magang->nilai_akhir : null
        ]);
    }

    public function nilaiInstansi(Request $request)
    {
        $validated = $request->validate([
            'dokumen' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;

        if ($magang->nilai_instansi()->exists())
        {
            return redirect()->route('mahasiswa.nilai')->withErrors(['gagal' => 'dokumen sudah ada']);
        }

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('public/documents/nilai-instansi');
        }

        $instansi = $magang->nilai_instansi()->create([
            'dokumen' => $validated['dokumen'],
            'status' => null
        ]);
        if (!$instansi)
        {
            return redirect()->route('mahasiswa.nilai')->withErrors(['gagal' => 'dokumen nilai gagal diupload']);
        }
        return redirect()->route('mahasiswa.nilai')->with('berhasil', 'dokumen nilai berhasil diupload');
    }

    public function nilaiInstansiUpdate(Request $request)
    {
        $validated = $request->validate([
            'dokumen' => 'required'
        ]);
        if (!$validated)
        {
            return redirect()->withErrors($validated);
        }
        $magang = Auth::guard('mahasiswa')->user()->magang;

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('public/nilai_instansi');
        }

        $instansi = $magang->nilai_instansi()->update([
            'dokumen' => $validated['dokumen'],
            'status' => null
        ]);
        
        if (!$instansi)
        {
            return redirect()->route('mahasiswa.nilai')->withErrors(['gagal' => 'dokumen nilai gagal diupload']);
        }
        return redirect()->route('mahasiswa.nilai')->with('berhasil', 'dokumen nilai berhasil diupload');
    }
}
