<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Mail;

use App\Models\Chatbot_database;

use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use Sastrawi\Stemmer\StemmerFactory;

use Jstewmc\Rtf\Document;
use Jstewmc\Rtf\Element\Group;
use Jstewmc\Rtf\Element\Text;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::prefix('profil')->group(function () {
        Route::get('/', [AdminController::class, 'profil'])->name('profil');
        Route::put('/', [AdminController::class, 'profilUpdate']);
        Route::get('/ubahpassword', [AdminController::class, 'profilUbahPassword']);
        Route::put('/ubahpassword', [AdminController::class, 'profilUbahPasswordUpdate']);
    });
    Route::prefix('topik-kmm')->group(function () {
        Route::get('/', [AdminController::class, 'topikKmm'])->name('topik-kmm');
        Route::post('/', [AdminController::class, 'topikKmmPost']);
        Route::put('/{topik}', [AdminController::class, 'topikKmmUpdate']);
        Route::delete('/{topik}', [AdminController::class, 'topikKmmDelete']);
    });
    Route::prefix('informasi-kmm')->group(function () {
        Route::get('/', [AdminController::class, 'informasiKmm'])->name('informasi-kmm');
        Route::post('/', [AdminController::class, 'informasiKmmPost']);
        Route::put('/{informasi}', [AdminController::class, 'informasiKmmUpdate']);
        Route::put('/{informasi}/publish', [AdminController::class, 'informasiKmmPublish']);
        Route::put('/{informasi}/unpublish', [AdminController::class, 'informasiKmmUnpublish']);
        Route::delete('/{informasi}', [AdminController::class, 'informasiKmmDelete']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [AdminController::class, 'user'])->name('user');
        Route::prefix('/dosen')->group(function () {
            Route::post('/add', [AdminController::class, 'userDosenPost']);

            Route::get('/{dosen}', [AdminController::class, 'userDosen']);
            Route::put('/{dosen}', [AdminController::class, 'userDosenUpdate']);
            Route::delete('/{dosen}', [AdminController::class, 'userDosenDelete']);
        });
        Route::prefix('/mahasiswa')->group(function () {
            Route::get('/{mahasiswa}', [AdminController::class, 'userMahasiswa']);
            Route::put('/{mahasiswa}', [AdminController::class, 'userMahasiswaUpdate']);
            Route::delete('/{mahasiswa}', [AdminController::class, 'userMahasiswaDelete']);
            Route::put('/{mahasiswa}/aktif', [AdminController::class, 'userMahasiswaAktif']);
            Route::put('/{mahasiswa}/nonaktif', [AdminController::class, 'userMahasiswaNonaktif']);
        });
    });
    Route::prefix('berita')->group(function () {
        Route::get('/', [AdminController::class, 'berita'])->name('berita');
        Route::get('/add', [AdminController::class, 'beritaAdd'])->name('berita.add');
        Route::get('/{berita}', [AdminController::class, 'beritaShow']);
        Route::put('/{berita}', [AdminController::class, 'beritaUpdate']);
        Route::delete('/{berita}', [AdminController::class, 'beritaDelete']);
        Route::put('/{berita}/publish', [AdminController::class, 'beritaPublish']);
        Route::put('/{berita}/unpublish', [AdminController::class, 'beritaUnpublish']);
    });
    Route::prefix('instansi')->group(function () {
        Route::get('/', [AdminController::class, 'instansi'])->name('instansi');
        Route::get('/{instansi}/approve', [AdminController::class, 'approveInstansi']);
        Route::get('/{instansi}/unapprove', [AdminController::class, 'unapproveInstansi']);
        Route::delete('/{instansi}', [AdminController::class, 'deleteInstansi']);
    });
    Route::prefix('progres')->group(function () {
        Route::get('/', [AdminController::class, 'progres'])->name('progres');
        Route::post('/', [AdminController::class, 'progresPost']);
        Route::put('/{progres}', [AdminController::class, 'progresUpdate']);
    });
    Route::prefix('tahun')->group(function () {
        Route::get('/', [AdminController::class, 'tahun'])->name('tahun');
        Route::post('/', [AdminController::class, 'tahunPost']);
    });
    Route::prefix('magang')->group(function () {
        Route::get('/', [AdminController::class, 'magang'])->name('magang');
        Route::get('/{magang}', [AdminController::class, 'magangShow'])->name('magang.show');
        Route::get('/{magang}/pengajuan-instansi/approve', [AdminController::class, 'magangPengajuanInstansiApprove']);
        Route::get('/{magang}/diterima-instansi/approve', [AdminController::class, 'magangDiterimaInstansiApprove']);
        Route::get('/{magang}/pengajuan-instansi/reject', [AdminController::class, 'magangPengajuanInstansiReject']);
        Route::get('/{magang}/diterima-instansi/reject', [AdminController::class, 'magangDiterimaInstansiReject']);
        Route::get('/{magang}/approve-bimbingan', [AdminController::class, 'magangApproveBimbingan']);
        Route::get('/{magang}/reject-bimbingan', [AdminController::class, 'magangRejectBimbingan']);
        
        Route::delete('/{magang}', [AdminController::class, 'magangDelete']);

        Route::post('/{magang}/penguji',[AdminController::class,'seminarAddPenguji']);

        Route::get('/{magang}/instansi/{instansi}/approve', [AdminController::class, 'bimbinganInstansiApprove']);
        Route::get('/{magang}/instansi/{instansi}/reject', [AdminController::class, 'bimbinganInstansiReject']);
        Route::get('/{magang}/nilaiinstansi/approve',[AdminController::class, 'nilaiInstansiApprove']);
        Route::get('/{magang}/nilaiinstansi/reject',[AdminController::class, 'nilaiInstansiReject']);

        Route::post('/{magang}/nilaiinstansi', [AdminController::class, 'nilaiInstansi']);
        Route::get('/{magang}/kalkulasi', [AdminController::class, 'kalkulasiNilaiAkhir']);
        Route::put('/{magang}/nilaiakhir', [AdminController::class, 'updateNilaiAkhir']);
    });
    Route::prefix('nilai')->group(function () {
        Route::get('/', [AdminController::class, 'nilai'])->name('nilai');
        Route::post('/bobotnilai',[AdminController::class, 'bobotNilai']);
        Route::post('/parameternilaiseminar',[AdminController::class, 'parameterNilaiSeminar']);
        Route::post('/parameternilaibimbingan',[AdminController::class, 'parameterNilaiBimbingan']);
        Route::post('/parameternilaiinstansi',[AdminController::class, 'parameterNilaiInstansi']);
    });
    Route::prefix('kontak')->group(function () {
        Route::get('/', [AdminController::class, 'kontak'])->name('kontak');
        Route::delete('/{hubungi_kami}',[AdminController::class, 'kontakDelete']);
    });
}); 

Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('auth:mahasiswa')->group(function () {
    Route::get('dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::prefix('profil')->group(function () {
        Route::get('/', [MahasiswaController::class, 'profil'])->name('profil');
        Route::put('/', [MahasiswaController::class, 'profilUpdate']);
        Route::get('/ubahpassword', [MahasiswaController::class, 'profilUbahPassword']);
        Route::put('/ubahpassword', [MahasiswaController::class, 'profilUbahPasswordUpdate']);
        Route::post('/kondisi', [MahasiswaController::class, 'profilKondisiPost']);
        Route::put('/kondisi', [MahasiswaController::class, 'profilKondisiUpdate']);
        Route::delete('/kondisi', [MahasiswaController::class, 'profilKondisiDelete']);
    });
    Route::prefix('magang')->group(function () {

        Route::get('/', [MahasiswaController::class, 'magang'])->name('magang');
        Route::post('/serah-terima', [MahasiswaController::class, 'magangSerahTerimaPost']);
        Route::put('/serah-terima', [MahasiswaController::class, 'magangSerahTerimaUpdate']);
        Route::post('/pengajuan', [MahasiswaController::class, 'magangPengajuanPost']);
        Route::put('/pengajuan', [MahasiswaController::class, 'magangPengajuanUpdate']);
        Route::post('/jawaban', [MahasiswaController::class, 'magangJawabanPost']);
        Route::put('/jawaban', [MahasiswaController::class, 'magangJawabanUpdate']);
        Route::post('/bimbingan/dosen', [MahasiswaController::class, 'magangDaftarBimbinganDosenPost']);
        Route::put('/bimbingan/dosen/{bimbingan}', [MahasiswaController::class, 'magangDaftarBimbinganDosenUpdate']);
        Route::get('/bimbingan/dosen/{bimbingan}/delete', [MahasiswaController::class, 'magangDaftarBimbinganDosenDelete']);
        Route::post('/bimbingan/instansi', [MahasiswaController::class, 'magangDaftarBimbinganInstansiPost']);
        Route::put('/bimbingan/instansi/{bimbingan}', [MahasiswaController::class, 'magangDaftarBimbinganInstansiUpdate']);
        Route::get('/bimbingan/instansi/{bimbingan}/delete', [MahasiswaController::class, 'magangDaftarBimbinganInstansiDelete']);

        Route::prefix('/rencana')->group(function() {
            Route::post('/', [MahasiswaController::class, 'magangRencana'])->name('magang.rencana');
            Route::put('/{rencana}', [MahasiswaController::class, 'magangRencanaUpdate']);
            Route::delete('/', [MahasiswaController::class, 'magangRencanaDelete']);
        });

        Route::prefix('/daftar')->group(function () {
            Route::get('/', [MahasiswaController::class, 'magangDaftar'])->name('magang.daftar');
            Route::post('/tahun-topik-instansi', [MahasiswaController::class, 'magangDaftarTahunTopikInstansi']);
            Route::put('/tahun-topik-instansi', [MahasiswaController::class, 'magangDaftarTahunTopikInstansiUpdate']);
            Route::post('/rencana', [MahasiswaController::class, 'magangDaftarRencana']);
            Route::put('/rencana/{rencana}', [MahasiswaController::class, 'magangDaftarRencanaUpdate']);
            Route::delete('/rencana', [MahasiswaController::class, 'magangDaftarRencanaDelete']);
            Route::post('/dosen', [MahasiswaController::class, 'magangDaftarDosen']);
            Route::put('/dosen', [MahasiswaController::class, 'magangDaftarDosenUpdate']);
        });
    });
    Route::prefix('seminar')->group(function () {
        Route::get('/',[MahasiswaController::class,'seminar'])->name('seminar');
        Route::post('/',[MahasiswaController::class,'seminarPost']);
        Route::put('/tanggal',[MahasiswaController::class,'seminarTanggalUpdate']);
        Route::put('/',[MahasiswaController::class,'seminarUpdate']);
        Route::delete('/',[MahasiswaController::class,'seminarDelete']);
    });
    Route::prefix('nilai')->group(function () {
        Route::get('/',[MahasiswaController::class,'nilai'])->name('nilai');
        Route::post('/instansi', [MahasiswaController::class, 'nilaiInstansi']);
        Route::put('/instansi', [MahasiswaController::class, 'nilaiInstansiUpdate']);
    });
    Route::prefix('revisi')->group(function () {
        Route::get('/', [MahasiswaController::class,'revisi'])->name('revisi');
        Route::post('/', [MahasiswaController::class,'revisiPost']);
    });
});

Route::prefix('dosen')->name('dosen.')->middleware('auth:dosen')->group(function () {
    Route::get('dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::prefix('profil')->group(function () {
        Route::get('/', [DosenController::class, 'profil'])->name('profil');
        Route::put('/', [DosenController::class, 'profilUpdate']);
        Route::get('/ubahpassword', [DosenController::class, 'profilUbahPassword']);
        Route::put('/ubahpassword', [DosenController::class, 'profilUbahPasswordUpdate']);
    });
    Route::prefix('bidang-topik')->group(function () {
        Route::get('/', [DosenController::class, 'bidangTopik'])->name('bidang-topik');
        Route::post('/', [DosenController::class, 'bidangTopikPost']);
        Route::delete('/', [DosenController::class, 'bidangTopikDelete']);
    });

    Route::prefix('magang')->group(function () {
        Route::get('/',[DosenController::class,'magang'])->name('magang');
        Route::get('/{magang}',[DosenController::class,'magangShow'])->name('magang.show');
        Route::get('/{magang}/approve',[DosenController::class,'magangApprove']);
        Route::get('/{magang}/reject',[DosenController::class,'magangReject']);
        Route::get('/{magang}/bimbingan/{bimbingan}/approve', [DosenController::class, 'MagangBimbinganApprove']);
        Route::get('/{magang}/bimbingan/{bimbingan}/reject', [DosenController::class, 'MagangBimbinganReject']);
    });

    Route::prefix('seminardanrevisi')->group(function () {
        Route::get('/', [DosenController::class,'seminardanrevisi'])->name('seminarrevisi');
        Route::get('/{magang}',[DosenController::class,'seminardanrevisiShow'])->name('seminarrevisi.show');
        Route::get('/{magang}/seminar/approve',[DosenController::class,'seminarApprove']);
        Route::get('/{magang}/seminar/reject',[DosenController::class,'seminarReject']);
        Route::get('/{magang}/revisi/approve',[DosenController::class,'revisiApprove']);
        Route::get('/{magang}/revisi/reject',[DosenController::class,'revisiReject']);
    });

    Route::prefix('nilai')->group(function () {
        Route::get('/', [DosenController::class,'nilai'])->name('nilai');
        Route::get('/{magang}', [DosenController::class,'nilaiShow'])->name('nilai.show');
        Route::post('/{magang}/nilaiseminar', [DosenController::class,'nilaiSeminar']);
        Route::post('/{magang}/nilaibimbingan', [DosenController::class,'nilaiBimbingan']);
    });

    Route::prefix('penguji')->group(function () {
        Route::get('/', [DosenController::class,'penguji'])->name('penguji');
        Route::get('/{magang}',[DosenController::class,'pengujiShow'])->name('penguji.show');
        Route::post('/{magang}/nilai',[DosenController::class,'nilaiPengujiPost']);
    });
});

Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/informasi', [PagesController::class, 'informasi']);
Route::get('/kontak', [PagesController::class, 'kontak']);
Route::post('/kontak', [PagesController::class, 'kontakPost']);
Route::get('/tentang', [PagesController::class, 'tentang']);
Route::get('/berita', [PagesController::class, 'berita']);
Route::post('/berita', [PagesController::class, 'beritaPost']);
Route::get('/berita/{berita}', [PagesController::class, 'beritaDetail']);
Route::get('/auth', [PagesController::class, 'login'])->name('login');
Route::get('/logout', [PagesController::class, 'logout']);
Route::post('/login', [PagesController::class, 'loginPost']);
Route::post('/register', [PagesController::class, 'registerPost']);

Route::get('/login', function () {
    return redirect()->route('login');
});
Route::get('/register', function () {
    return redirect()->route('login', ['register' => 'true']);
});

//tes fungsi email
// Route::get('tesemail', function () {

//     $data = array(
//         'name' => "Fauzi",
//     );

//     Mail::send('emails.register', $data, function ($message) {

//         $message->from('no-reply@simkmmv2.com', 'SIMKMM D3TI');

//         $message->to('cyberfauzi3@gmail.com')->subject('Terimakasih telah mendaftar SIMKMM D3TI');

//     });
//     return redirect()->back()->with('berhasil', 'Berhasil dikirim!');
// });


Route::get('/chat', function () {
    try {
        $kalimat = request()->kalimat;
    
        // Preprocessing
        $kalimat = trim($kalimat);
        $kalimat = preg_replace("/\d+/", "", $kalimat);
    
        // Stopword Removal
        $stopWordRemoverFactory = new StopWordRemoverFactory();
        $stopword = $stopWordRemoverFactory->createStopWordRemover();
        $kalimat = $stopword->remove($kalimat);
    
        // Stemming
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $kalimat = $stemmer->stem($kalimat);
    
        $userInput = explode(" ", $kalimat);

        return dd($userInput);

        $database = Chatbot_database::all();
    
        if (empty($database)) {
            throw new Exception("I have no data.");
        }
    
        $database_keyword = [];
        foreach ($database as $record) {
            $keywordArray = json_decode(str_replace("'", '"', $record->keyword));
            $database_keyword[] = $keywordArray;
        }
    
        $commonWords = array_map(function ($entry) use ($userInput) {
            return count(array_intersect($entry, $userInput));
        }, $database_keyword);
        if (max($commonWords) === 0) {
            throw new Exception("I don't understand.");
        }
        $maxCommonIndex = array_search(max($commonWords), $commonWords);
        if ($maxCommonIndex === false) {
            throw new Exception("No matching response found. so weird.");
        }
    
        $data_result = $database[$maxCommonIndex];
    
        $keywordArray = json_decode(str_replace("'", '"', $data_result->keyword));
        $responseArray = json_decode(str_replace("'", '"', $data_result->response));
    
        $formattedResult = [
            'success' => true,
            'keyword' => $keywordArray,
            'expression' => $data_result->expression,
            'response' => $responseArray,
        ];
    
        return response()->json($formattedResult);
    } catch (Exception $e) {
        $errorResponse = [
            'success' => false,
            'error' => $e->getMessage(),
        ];
    
        return response()->json($errorResponse);
    }      
});