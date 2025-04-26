<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapTransaksiController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\UserController;
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

Route::middleware('only_sign_in')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'authenticate']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'destroy'])->name('logout');

    Route::group(['middleware' => 'superadmin'], function () {
        Route::get('superadmin/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');
        Route::get('superadmin/dashboard/line-chart-anggota', [DashboardController::class, 'index'])->name('superadmin.line.chart');
        Route::get('superadmin/dashboard/pie-chart-anggota', [DashboardController::class, 'index'])->name('superadmin.pie.chart');

        Route::get('superadmin/pegawai', [PegawaiController::class, 'index'])->name('superadmin.pegawai');
        Route::get('superadmin/pegawai/add', [PegawaiController::class, 'create'])->name('superadmin.pegawai.create');
        Route::post('superadmin/pegawai/add', [PegawaiController::class, 'store'])->name('superadmin.pegawai.store');
        Route::get('superadmin/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('superadmin.pegawai.edit');
        Route::put('superadmin/pegawai/edit/{id}', [PegawaiController::class, 'update'])->name('superadmin.pegawai.update');
        Route::get('superadmin/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('superadmin.pegawai.destroy');
        Route::get('superadmin/pegawai/export/pdf', [PegawaiController::class, 'export'])->name('superadmin.pegawai.export');

        Route::get('superadmin/anggota', [AnggotaController::class, 'index'])->name('superadmin.anggota');
        Route::get('superadmin/anggota/add', [AnggotaController::class, 'create'])->name('superadmin.anggota.create');
        Route::post('superadmin/anggota/add', [AnggotaController::class, 'store'])->name('superadmin.anggota.store');
        Route::get('superadmin/anggota/edit/{id}', [AnggotaController::class, 'edit'])->name('superadmin.anggota.edit');
        Route::put('superadmin/anggota/edit/{id}', [AnggotaController::class, 'update'])->name('superadmin.anggota.update');
        Route::get('superadmin/anggota/{id}', [AnggotaController::class, 'destroy'])->name('superadmin.anggota.destroy');
        Route::get('superadmin/anggota/export/pdf', [AnggotaController::class, 'export'])->name('superadmin.anggota.export');

        Route::get('superadmin/simpanan', [SimpananController::class, 'index'])->name('superadmin.simpanan');
        Route::get('superadmin/simpanan/add', [SimpananController::class, 'create'])->name('superadmin.simpanan.create');
        Route::post('superadmin/simpanan/add', [SimpananController::class, 'store'])->name('superadmin.simpanan.store');
        Route::get('superadmin/simpanan/view/{id}', [SimpananController::class, 'show'])->name('superadmin.simpanan.show');
        Route::get('superadmin/simpanan/edit/{id}', [SimpananController::class, 'edit'])->name('superadmin.simpanan.edit');
        Route::put('superadmin/simpanan/edit/{id}', [SimpananController::class, 'update'])->name('superadmin.simpanan.update');
        Route::get('superadmin/simpanan/{id}', [SimpananController::class, 'destroy'])->name('superadmin.simpanan.destroy');
        Route::get('superadmin/simpanan/view/delete/{id}', [SimpananController::class, 'destroyDetail'])->name('superadmin.simpanan.destroy.detail');
        Route::get('superadmin/simpanan/export/pdf/{id}', [SimpananController::class, 'export'])->name('superadmin.simpanan.export');

        Route::get('superadmin/pinjaman', [PinjamanController::class, 'index'])->name('superadmin.pinjaman');
        Route::get('superadmin/pinjaman/belum-lunas', [PinjamanController::class, 'belumLunas'])->name('superadmin.pinjaman.belum.lunas');
        Route::get('superadmin/pinjaman/lunas', [PinjamanController::class, 'lunas'])->name('superadmin.pinjaman.lunas');
        Route::get('superadmin/pinjaman/add', [PinjamanController::class, 'create'])->name('superadmin.pinjaman.create');
        Route::post('superadmin/pinjaman/add', [PinjamanController::class, 'store'])->name('superadmin.pinjaman.store');
        Route::get('superadmin/pinjaman/view/{id}', [PinjamanController::class, 'show'])->name('superadmin.pinjaman.show');
        Route::get('superadmin/pinjaman/kredit', [PinjamanController::class, 'edit'])->name('superadmin.pinjaman.edit');
        Route::get('superadmin/pinjaman/diragukan', [PinjamanController::class, 'dataDiragukan'])->name('superadmin.pinjaman.diragukan');
        Route::get('superadmin/pinjaman/macet', [PinjamanController::class, 'dataMacet'])->name('superadmin.pinjaman.macet');
        Route::put('superadmin/pinjaman/view/{id}', [PinjamanController::class, 'update'])->name('superadmin.pinjaman.update');
        Route::get('superadmin/pinjaman/{id}', [PinjamanController::class, 'destroy'])->name('superadmin.pinjaman.destroy');
        Route::get('superadmin/pinjaman/export/pdf/{id}', [PinjamanController::class, 'export'])->name('superadmin.pinjaman.export');

        Route::get('superadmin/laporan', [LaporanController::class, 'index'])->name('superadmin.laporan');
        Route::post('superadmin/laporan/add', [LaporanController::class, 'store'])->name('superadmin.laporan.store');
        Route::put('superadmin/laporan/update', [LaporanController::class, 'update'])->name('superadmin.laporan.update');
        Route::get('superadmin/laporan/{id}', [LaporanController::class, 'destroy'])->name('superadmin.laporan.destroy');
        Route::get('superadmin/laporan/export/pdf', [LaporanController::class, 'export'])->name('superadmin.laporan.export');

        Route::get('superadmin/rekap', [RekapTransaksiController::class, 'index'])->name('superadmin.rekap');
        Route::get('superadmin/rekap/filter', [RekapTransaksiController::class, 'index'])->name('superadmin.rekap.filter');
        Route::get('superadmin/rekap/export/pdf', [RekapTransaksiController::class, 'export'])->name('superadmin.rekap.export');

        Route::get('superadmin/profile', [ProfileController::class, 'index'])->name('superadmin.profile');
        Route::put('superadmin/profile/{id}', [ProfileController::class, 'update'])->name('superadmin.profile.update');
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('pegawai.dashboard');
        Route::get('admin/dashboard/line-chart-anggota', [DashboardController::class, 'index'])->name('pegawai.line.chart');
        Route::get('admin/dashboard/pie-chart-anggota', [DashboardController::class, 'index'])->name('pegawai.pie.chart');

        Route::get('admin/anggota', [AnggotaController::class, 'index'])->name('pegawai.anggota');
        Route::get('admin/anggota/add', [AnggotaController::class, 'create'])->name('pegawai.anggota.create');
        Route::post('admin/anggota/add', [AnggotaController::class, 'store'])->name('pegawai.anggota.store');
        Route::get('admin/anggota/edit/{id}', [AnggotaController::class, 'edit'])->name('pegawai.anggota.edit');
        Route::put('admin/anggota/edit/{id}', [AnggotaController::class, 'update'])->name('pegawai.anggota.update');
        Route::get('admin/anggota/export/pdf', [AnggotaController::class, 'export'])->name('pegawai.anggota.export');

        Route::get('admin/simpanan', [SimpananController::class, 'index'])->name('pegawai.simpanan');
        Route::get('admin/simpanan/add', [SimpananController::class, 'create'])->name('pegawai.simpanan.create');
        Route::post('admin/simpanan/add', [SimpananController::class, 'store'])->name('pegawai.simpanan.store');
        Route::get('admin/simpanan/view/{id}', [SimpananController::class, 'show'])->name('pegawai.simpanan.show');
        Route::get('admin/simpanan/edit/{id}', [SimpananController::class, 'edit'])->name('pegawai.simpanan.edit');
        Route::put('admin/simpanan/edit/{id}', [SimpananController::class, 'update'])->name('pegawai.simpanan.update');
        Route::get('admin/simpanan/export/pdf/{id}', [SimpananController::class, 'export'])->name('pegawai.simpanan.export');

        Route::get('admin/pinjaman', [PinjamanController::class, 'index'])->name('pegawai.pinjaman');
        Route::get('admin/pinjaman/add', [PinjamanController::class, 'create'])->name('pegawai.pinjaman.create');
        Route::post('admin/pinjaman/add', [PinjamanController::class, 'store'])->name('pegawai.pinjaman.store');
        Route::get('admin/pinjaman/view/{id}', [PinjamanController::class, 'show'])->name('pegawai.pinjaman.show');
        Route::get('admin/pinjaman/edit/{id}', [PinjamanController::class, 'edit'])->name('pegawai.pinjaman.edit');
        Route::get('admin/pinjaman/kredit', [PinjamanController::class, 'edit'])->name('pegawai.pinjaman.edit');
        Route::get('admin/pinjaman/diragukan', [PinjamanController::class, 'dataDiragukan'])->name('pegawai.pinjaman.diragukan');
        Route::get('admin/pinjaman/macet', [PinjamanController::class, 'dataMacet'])->name('pegawai.pinjaman.macet');
        Route::put('admin/pinjaman/edit/{id}', [PinjamanController::class, 'update'])->name('pegawai.pinjaman.update');
        Route::get('admin/pinjaman/export/pdf/{id}', [PinjamanController::class, 'export'])->name('pegawai.pinjaman.export');

        Route::get('admin/laporan', [LaporanController::class, 'index'])->name('pegawai.laporan');
        Route::post('admin/laporan/add', [LaporanController::class, 'store'])->name('pegawai.laporan.store');
        Route::put('admin/laporan/update', [LaporanController::class, 'update'])->name('pegawai.laporan.update');
        Route::get('admin/laporan/export/pdf', [LaporanController::class, 'export'])->name('pegawai.laporan.export');

        Route::get('admin/rekap', [RekapTransaksiController::class, 'index'])->name('pegawai.rekap');
        Route::get('admin/rekap/filter', [RekapTransaksiController::class, 'index'])->name('pegawai.rekap.filter');
        Route::get('admin/rekap/export/pdf', [RekapTransaksiController::class, 'export'])->name('pegawai.rekap.export');

        Route::get('admin/profile', [ProfileController::class, 'index'])->name('pegawai.profile');
        Route::put('admin/profile/{id}', [ProfileController::class, 'update'])->name('pegawai.profile.update');
    });

    Route::group(['middleware' => 'anggota'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard/line-chart-anggota', [DashboardController::class, 'index'])->name('line.chart');
        Route::get('dashboard/pie-chart-anggota', [DashboardController::class, 'index'])->name('pie.chart');

        Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai');
        Route::get('pegawai/add', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('pegawai/add', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('pegawai/edit/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::get('pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        Route::get('pegawai/export/pdf', [PegawaiController::class, 'export'])->name('pegawai.export');

        Route::get('anggota', [AnggotaController::class, 'index'])->name('anggota');
        Route::get('anggota/add', [AnggotaController::class, 'create'])->name('anggota.create');
        Route::post('anggota/add', [AnggotaController::class, 'store'])->name('anggota.store');
        Route::get('anggota/edit/{id}', [AnggotaController::class, 'edit'])->name('anggota.edit');
        Route::put('anggota/edit/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
        Route::get('anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
        Route::get('anggota/export/pdf', [AnggotaController::class, 'export'])->name('anggota.export');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    });
});
