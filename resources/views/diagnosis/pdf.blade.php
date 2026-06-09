<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Diagnosis - SMed Checker</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #4f46e5;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .badge-rendah { background: #10b981; color: white; }
        .badge-sedang { background: #f59e0b; color: white; }
        .badge-tinggi { background: #ef4444; color: white; }
        .info-box {
            background: #f3f4f6;
            padding: 10px;
            border-radius: 8px;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f3f4f6;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">SMed Checker</div>
        <div>Social Media Checker - Sistem Pakar Diagnosis Kecanduan Media Sosial</div>
        <div>Metode Forward Chaining</div>
    </div>

    <div class="title">
        HASIL DIAGNOSIS
    </div>

    <div class="info-box">
        <strong>Tanggal Diagnosis:</strong> {{ $riwayat->created_at->format('d/m/Y H:i') }}<br>
        @if($riwayat->nama_pengguna)
            <strong>Nama:</strong> {{ $riwayat->nama_pengguna }}<br>
        @endif
        <strong>Session ID:</strong> {{ $riwayat->session_id }}
    </div>

    <div style="text-align: center; margin: 20px 0;">
        <div class="badge 
            @if($riwayat->tingkatKecanduan->kode == 'T01') badge-rendah
            @elseif($riwayat->tingkatKecanduan->kode == 'T02') badge-sedang
            @else badge-tinggi
            @endif" 
            style="font-size: 16px; padding: 8px 20px;">
            {{ $riwayat->tingkatKecanduan->nama }}
        </div>
        <div style="margin-top: 10px;">
            <strong>Tingkat Kecocokan:</strong> {{ round($riwayat->persentase) }}%
        </div>
        <div style="margin-top: 5px; font-size: 11px; color: #666;">
            Dari {{ $semuaHasil[0]['total_dibutuhkan'] }} gejala yang dibutuhkan, 
            Anda mengalami {{ $semuaHasil[0]['total_cocok'] }} gejala
        </div>
    </div>

    <h3>Deskripsi</h3>
    <p>{{ $riwayat->tingkatKecanduan->deskripsi }}</p>

    <h3>Solusi yang Disarankan</h3>
    <div style="white-space: pre-line;">{{ $riwayat->tingkatKecanduan->solusi }}</div>

    <h3>Gejala yang Anda Pilih</h3>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gejalaDipilih as $g)
            <tr>
                <td>{{ $g->kode }}</td>
                <td>{{ $g->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Detail Kecocokan per Tingkat Kecanduan</h3>
    <table>
        <thead>
            <tr>
                <th>Tingkat Kecanduan</th>
                <th>Gejala Cocok</th>
                <th>Total Gejala</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semuaHasil as $hasil)
            <tr>
                <td>
                    @if($hasil['kode'] == 'T01') Kecanduan Rendah
                    @elseif($hasil['kode'] == 'T02') Kecanduan Sedang
                    @else Kecanduan Tinggi
                    @endif
                </td>
                <td>{{ $hasil['total_cocok'] }}</td>
                <td>{{ $hasil['total_dibutuhkan'] }}</td>
                <td>{{ round($hasil['persentase']) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; padding: 10px; background: #fef3c7; border-left: 3px solid #f59e0b;">
        <strong>⚠️ Disclaimer</strong><br>
        Diagnosis ini bersifat awal dan bukan pengganti konsultasi dengan psikolog profesional.
    </div>

    <div class="footer">
        <p>SMed Checker - Sistem Pakar Diagnosis Kecanduan Media Sosial</p>
        <p>Metode Forward Chaining | Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</body>
</html>