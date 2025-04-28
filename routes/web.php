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
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('admin/dashboard/line-chart-anggota', [DashboardController::class, 'index'])->name('admin.line.chart');
        Route::get('admin/dashboard/pie-chart-anggota', [DashboardController::class, 'index'])->name('admin.pie.chart');

        Route::get('admin/anggota', [AnggotaController::class, 'index'])->name('admin.anggota');
        Route::get('admin/anggota/add', [AnggotaController::class, 'create'])->name('admin.anggota.create');
        Route::post('admin/anggota/add', [AnggotaController::class, 'store'])->name('admin.anggota.store');
        Route::get('admin/anggota/edit/{id}', [AnggotaController::class, 'edit'])->name('admin.anggota.edit');
        Route::put('admin/anggota/edit/{id}', [AnggotaController::class, 'update'])->name('admin.anggota.update');
        Route::get('admin/anggota/export/pdf', [AnggotaController::class, 'export'])->name('admin.anggota.export');

        Route::get('admin/simpanan', [SimpananController::class, 'index'])->name('admin.simpanan');
        Route::get('admin/simpanan/add', [SimpananController::class, 'create'])->name('admin.simpanan.create');
        Route::post('admin/simpanan/add', [SimpananController::class, 'store'])->name('admin.simpanan.store');
        Route::get('admin/simpanan/view/{id}', [SimpananController::class, 'show'])->name('admin.simpanan.show');
        Route::get('admin/simpanan/edit/{id}', [SimpananController::class, 'edit'])->name('admin.simpanan.edit');
        Route::put('admin/simpanan/edit/{id}', [SimpananController::class, 'update'])->name('admin.simpanan.update');
        Route::get('admin/simpanan/export/pdf/{id}', [SimpananController::class, 'export'])->name('admin.simpanan.export');

        Route::get('admin/pinjaman', [PinjamanController::class, 'index'])->name('admin.pinjaman');
        Route::get('admin/pinjaman/add', [PinjamanController::class, 'create'])->name('admin.pinjaman.create');
        Route::post('admin/pinjaman/add', [PinjamanController::class, 'store'])->name('admin.pinjaman.store');
        Route::get('admin/pinjaman/belum-lunas', [PinjamanController::class, 'belumLunas'])->name('admin.pinjaman.belum.lunas');
        Route::get('admin/pinjaman/lunas', [PinjamanController::class, 'lunas'])->name('admin.pinjaman.lunas');
        Route::get('admin/pinjaman/view/{id}', [PinjamanController::class, 'show'])->name('admin.pinjaman.show');
        Route::get('admin/pinjaman/edit/{id}', [PinjamanController::class, 'edit'])->name('admin.pinjaman.edit');
        Route::get('admin/pinjaman/kredit', [PinjamanController::class, 'edit'])->name('admin.pinjaman.edit');
        Route::get('admin/pinjaman/diragukan', [PinjamanController::class, 'dataDiragukan'])->name('admin.pinjaman.diragukan');
        Route::get('admin/pinjaman/macet', [PinjamanController::class, 'dataMacet'])->name('admin.pinjaman.macet');
        Route::put('admin/pinjaman/edit/{id}', [PinjamanController::class, 'update'])->name('admin.pinjaman.update');
        Route::get('admin/pinjaman/export/pdf/{id}', [PinjamanController::class, 'export'])->name('admin.pinjaman.export');

        Route::get('admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
        Route::post('admin/laporan/add', [LaporanController::class, 'store'])->name('admin.laporan.store');
        Route::put('admin/laporan/update', [LaporanController::class, 'update'])->name('admin.laporan.update');
        Route::get('admin/laporan/{id}', [LaporanController::class, 'destroy'])->name('admin.laporan.destroy');
        Route::get('admin/laporan/export/pdf', [LaporanController::class, 'export'])->name('admin.laporan.export');

        Route::get('admin/rekap', [RekapTransaksiController::class, 'index'])->name('admin.rekap');
        Route::get('admin/rekap/filter', [RekapTransaksiController::class, 'index'])->name('admin.rekap.filter');
        Route::get('admin/rekap/export/pdf', [RekapTransaksiController::class, 'export'])->name('admin.rekap.export');

        Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::put('admin/profile/{id}', [ProfileController::class, 'update'])->name('admin.profile.update');
    });

    Route::group(['middleware' => 'anggota'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Route::get('dashboard/line-chart-anggota', [DashboardController::class, 'index'])->name('line.chart');
        // Route::get('dashboard/pie-chart-anggota', [DashboardController::class, 'index'])->name('pie.chart');

        // Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai');
        // Route::get('pegawai/add', [PegawaiController::class, 'create'])->name('pegawai.create');
        // Route::post('pegawai/add', [PegawaiController::class, 'store'])->name('pegawai.store');
        // Route::get('pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        // Route::put('pegawai/edit/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        // Route::get('pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        // Route::get('pegawai/export/pdf', [PegawaiController::class, 'export'])->name('pegawai.export');

        // Route::get('anggota', [AnggotaController::class, 'index'])->name('anggota');
        // Route::get('anggota/add', [AnggotaController::class, 'create'])->name('anggota.create');
        // Route::post('anggota/add', [AnggotaController::class, 'store'])->name('anggota.store');
        // Route::get('anggota/edit/{id}', [AnggotaController::class, 'edit'])->name('anggota.edit');
        // Route::put('anggota/edit/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
        // Route::get('anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
        // Route::get('anggota/export/pdf', [AnggotaController::class, 'export'])->name('anggota.export');

        Route::get('simpanan', [SimpananController::class, 'index'])->name('simpanan');
        Route::get('simpanan/add', [SimpananController::class, 'create'])->name('simpanan.create');
        Route::post('simpanan/add', [SimpananController::class, 'store'])->name('simpanan.store');
        Route::get('simpanan/view/{id}', [SimpananController::class, 'show'])->name('simpanan.show');
        Route::get('simpanan/edit/{id}', [SimpananController::class, 'edit'])->name('simpanan.edit');
        Route::put('simpanan/edit/{id}', [SimpananController::class, 'update'])->name('simpanan.update');
        Route::get('simpanan/export/pdf/{id}', [SimpananController::class, 'export'])->name('simpanan.export');

        Route::get('pinjaman', [PinjamanController::class, 'index'])->name('pinjaman');
        Route::get('pinjaman/add', [PinjamanController::class, 'create'])->name('pinjaman.create');
        Route::post('pinjaman/add', [PinjamanController::class, 'store'])->name('pinjaman.store');
        Route::get('pinjaman/belum-lunas', [PinjamanController::class, 'belumLunas'])->name('pinjaman.belum.lunas');
        Route::get('pinjaman/lunas', [PinjamanController::class, 'lunas'])->name('pinjaman.lunas');
        Route::get('pinjaman/view/{id}', [PinjamanController::class, 'show'])->name('pinjaman.show');
        Route::get('pinjaman/edit/{id}', [PinjamanController::class, 'edit'])->name('pinjaman.edit');
        // Route::get('pinjaman/kredit', [PinjamanController::class, 'edit'])->name('pinjaman.edit');
        // Route::get('pinjaman/diragukan', [PinjamanController::class, 'dataDiragukan'])->name('pinjaman.diragukan');
        // Route::get('pinjaman/macet', [PinjamanController::class, 'dataMacet'])->name('pinjaman.macet');
        Route::put('pinjaman/edit/{id}', [PinjamanController::class, 'update'])->name('pinjaman.update');
        Route::get('pinjaman/export/pdf/{id}', [PinjamanController::class, 'export'])->name('pinjaman.export');

        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::post('laporan/add', [LaporanController::class, 'store'])->name('laporan.store');
        Route::put('laporan/update', [LaporanController::class, 'update'])->name('laporan.update');
        Route::get('laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
        Route::get('laporan/export/pdf', [LaporanController::class, 'export'])->name('laporan.export');

        Route::get('rekap', [RekapTransaksiController::class, 'index'])->name('rekap');
        Route::get('rekap/filter', [RekapTransaksiController::class, 'index'])->name('rekap.filter');
        Route::get('rekap/export/pdf', [RekapTransaksiController::class, 'export'])->name('rekap.export');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    });
});