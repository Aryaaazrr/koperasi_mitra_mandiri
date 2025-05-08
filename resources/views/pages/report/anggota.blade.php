<!DOCTYPE html>
<html>

<head>
    <title>Laporan PDF</title>
    <style>
        /* CSS untuk styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
            border: 2px solid black;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .header p {
            font-size: 18px;
            margin: 0;
        }

        .content {
            text-align: center;
            border: 2px solid black;
            border-top: none;
        }

        .content h3 {
            margin: 0;
        }

        .content .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .content .table th,
        .content .table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .content .table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .jumlah {
            text-align: end;
        }

        .content .ttd {
            width: 100%;
            border: none;
            margin-bottom: 20px;
        }

        .content .ttd th {
            font-weight: normal;
        }

        .content .ttd td {
            text-align: center;
            padding-top: 60px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>KOPERASI SIMPAN PINJAM</h1>
        <h1>"MITRA MANDIRI"</h1>
        <p>BH Nomor : AHU-000032.AH.01.26.TAHUN 2019, 15-11-2019</p>
        <p>Jl. Raya Kosambi-Telagasari Perum Mustika Prakarsa Blok C2 No.7</p>
    </div>
    <div class="content">
        <h3>DATA ANGGOTA {{ $tahun }}</h3>
        <h3>KSP MITRA MANDIRI</h3>
        <table class="table" style="margin-bottom: 20px; font-size: x-small;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>No Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>No. Handphone</th>
                    <th>Pekerjaan</th>
                    <th>Tanggal Masuk</th>
                    <th>Jenis Anggota</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggota as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->users->nik }}</td>
                        <td>{{ $item->no_anggota }}</td>
                        <td>{{ $item->users->nama }}</td>
                        <td>{{ $item->users->jenis_kelamin }}</td>
                        <td>{{ $item->users->alamat }}</td>
                        <td>{{ $item->users->no_telp }}</td>
                        <td>{{ $item->pekerjaan }}</td>
                        <td>{{ $item->users->created_at }}</td>
                        <td>{{ $item->jenis_anggota }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="ttd">
            <thead>
                <tr>
                    <th style="width: 33,3%"></th>
                    <th style="width: 33,3%">PENGURUS KOPERASI</th>
                    <th style="width: 33,3%"></th>
                </tr>
                <tr>
                    <th style="width: 33,3%">Ketua</th>
                    <th style="width: 33,3%">Sekretaris</th>
                    <th style="width: 33,3%">Bendahara</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>WARYONO</td>
                    <td>TARKIM</td>
                    <td>FEBBY MAHA ZULFA</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
