<?php

namespace App\Http\Controllers;

use App\Exports\ExportAnggota;
use App\Models\anggota;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class AnggotaController extends Controller
{

    public function index(Request $request)
    {
        $users = Anggota::with('users')->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return DataTables::of($users)
                ->addColumn('DT_RowIndex', function ($user) {
                    return $user->id_anggota;
                })
                ->addColumn('nik', function ($user) {
                    return $user->users->nik;
                })
                ->addColumn('nama', function ($user) {
                    return $user->users->nama;
                })
                ->addColumn('nama', function ($user) {
                    return $user->users->nama;
                })
                ->addColumn('alamat', function ($user) {
                    return $user->users->alamat;
                })
                ->addColumn('no_telp', function ($user) {
                    return $user->users->no_telp;
                })
                ->toJson();
        }

        return view('pages.anggota.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.anggota.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|digits:16|unique:users',
            'nama' => 'required',
            'username' => 'required|unique:users',
            'jeniskelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required',
            'noTelp' => 'required|numeric',
            'password' => 'required|min:8',
            'pekerjaan' => 'required',
            'jenisanggota' => 'required|in:Pendiri,Biasa',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $account = new User();
        $account->nik = $request->nik;
        $account->nama = $request->nama;
        $account->username = $request->username;
        $account->password = Hash::make($request->password);
        $account->jenis_kelamin = $request->jeniskelamin;
        $account->alamat = $request->alamat;
        $account->no_telp = $request->noTelp;
        $account->id_role = 3;

        if ($account->save()) {
            $anggota = new Anggota();
            $anggota->id_users = $account->id_users;
            $anggota->no_anggota = $this->generateMemberNumber();
            $anggota->pekerjaan = $request->pekerjaan;
            $anggota->jenis_anggota = $request->jenisanggota;
            if ($anggota->save()) {
                if (Auth::user()->id_role == 1) {
                    return redirect()->route('superadmin.anggota')->with('success', 'Data anggota berhasil disimpan.');
                } else {
                    return redirect()->route('admin.anggota')->with('success', 'Data anggota berhasil disimpan.');
                }
            } else {
                return response()->json(['message' => 'Gagal menambahkan data anggota'], 500);
            }
        } else {
            return response()->json(['message' => 'Gagal menambahkan akun anggota'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = anggota::with('users')->find($id);
        return view('pages.anggota.edit', ['users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = anggota::with('users')->find($id);

        if (!$anggota) {
            return back()->withErrors(['error' => 'Anggota tidak ditemukan. Silahkan coba kembali']);
        }

        $validator = Validator::make($request->all(), [
            // 'nik' => 'required|digits:16',
            // 'nama' => 'required',
            // 'jeniskelamin' => 'required|in:Laki-Laki,Perempuan',
            // 'alamat' => 'required',
            // 'noTelp' => 'required|numeric',
            // 'pekerjaan' => 'required',

            'nik' => 'required|digits:16',
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $anggota->users->id_users . ',id_users',
            'jeniskelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required',
            'noTelp' => 'required|numeric',
            'pekerjaan' => 'required',
            'jenisanggota' => 'required|in:Pendiri,Biasa',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $anggota->users->nik = $request->nik;
        $anggota->users->nama = $request->nama;
        $anggota->users->username = $request->username;
        $anggota->users->jenis_kelamin = $request->jeniskelamin;
        $anggota->users->alamat = $request->alamat;
        $anggota->users->no_telp = $request->noTelp;
        $anggota->pekerjaan = $request->pekerjaan;

        if ($anggota->save()) {
            if (Auth::user()->id_role == 1) {
                return redirect()->route('superadmin.anggota')->with('success', 'Data Anggota berhasil diperbarui.');
            } else {
                return redirect()->route('admin.anggota')->with('success', 'Data Anggota berhasil diperbarui.');
            }
        } else {
            return response()->json(['message' => 'Terjadi kesalahan saat menambahkan data'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = anggota::where('id_anggota', $id)->first();
        if ($anggota) {
            $user = User::where('id_users', $anggota->id_users)->first();
            if ($user->delete()) {
                if (Auth::user()->id_role == 1) {
                    return redirect()->route('superadmin.anggota')->with('success', 'Data anggota berhasil dihapus.');
                } else {
                    return redirect()->route('admin.anggota')->with('success', 'Data anggota berhasil dihapus.');
                }
            } else {
                return response()->json(['message' => 'Terjadi kesalahan saat menghapus data'], 500);
            }
        } else {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data'], 500);
        }
    }

    public function export()
    {
        $data = anggota::count();
        if ($data != 0) {
            $anggota = anggota::all();
            $tahun = Carbon::now()->format('Y');
            $html = view('pages.report.anggota', compact('anggota', 'tahun'))->render();

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $dompdf->stream('Anggota Koperasi.pdf');
        } else {
            return back()->withErrors(['error' => 'Data Anggota masih kosong. Silahkan coba kembali.']);
        }
    }

    private function generateMemberNumber()
    {
        $currentDate = now();
        $dateString = $currentDate->format('dmY');

        $randomNumber = '';
        for ($i = 0; $i < 6; $i++) {
            $randomNumber .= mt_rand(0, 9);
        }

        $memberNumber = $dateString . $randomNumber;

        return $memberNumber;
    }
}
