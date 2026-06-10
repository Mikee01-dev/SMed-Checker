<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Diagnosis - SMed Checker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #4f46e5;
            margin-bottom: 25px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }
        
        .subtitle {
            font-size: 12px;
            color: #666;
        }
        
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            color: #1f2937;
        }
        
        .badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
        .badge-rendah { background: #10b981; color: white; }
        .badge-sedang { background: #f59e0b; color: white; }
        .badge-tinggi { background: #ef4444; color: white; }
        .badge-tidak { background: #6b7280; color: white; }
        
        .info-box {
            background: #f3f4f6;
            padding: 12px 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #4f46e5;
        }
        
        .info-box p {
            margin: 5px 0;
        }
        
        .result-card {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #f9fafb;
            border-radius: 12px;
        }
        
        .percentage {
            font-size: 36px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        h3 {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #e5e7eb;
            color: #1f2937;
        }
        
        .solution-box {
            background: #eef2ff;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #4f46e5;
        }
        
        .warning-box {
            margin-top: 20px;
            padding: 12px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            font-size: 11px;
        }
        
        .info-box-blue {
            margin-top: 20px;
            padding: 12px;
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
            font-size: 11px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        
        th {
            background: #f3f4f6;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .gejala-tag {
            display: inline-block;
            background: #f3f4f6;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            margin: 3px;
        }
        
        .gejala-list {
            margin: 10px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .progress-bar {
            width: 100%;
            background: #e5e7eb;
            border-radius: 10px;
            height: 8px;
            margin: 8px 0;
        }
        
        .progress-fill {
            height: 8px;
            border-radius: 10px;
        }
        .progress-green { background: #10b981; }
        .progress-yellow { background: #f59e0b; }
        .progress-red { background: #ef4444; }
        .progress-gray { background: #6b7280; }
        
        .footer {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">SMed Checker</div>
        <div class="subtitle">Sistem Pakar Diagnosis Kecanduan Media Sosial</div>
        <div class="subtitle">Metode Forward Chaining</div>
    </div>

    <div class="title">
        HASIL DIAGNOSIS
    </div>

    <div class="info-box">
        <p><strong>Tanggal Diagnosis:</strong> {{ $riwayat->created_at->translatedFormat('d F Y H:i') }} WIB</p>
        @if($riwayat->nama_pengguna)
            <p><strong>Nama:</strong> {{ $riwayat->nama_pengguna }}</p>
        @endif
        <p><strong>ID Diagnosis:</strong> #{{ $riwayat->id }}</p>
    </div>

    @if($hasil['hasil_final']->kode == 'T00')
        <div class="result-card">
            <div class="badge badge-tidak">
                {{ $hasil['hasil_final']->nama }}
            </div>
        </div>

        <div class="warning-box">
            <strong>Informasi</strong><br>
            {{ $hasil['hasil_final']->deskripsi }}
        </div>

        @if(isset($hasil['saran']) && $hasil['saran'])
        <div class="info-box-blue">
            <strong>Kecenderungan Berdasarkan Gejala Anda</strong><br><br>
            <div style="text-align: center;">
                <span class="badge 
                    @if($hasil['saran']['tingkat']->kode == 'T01') badge-rendah
                    @elseif($hasil['saran']['tingkat']->kode == 'T02') badge-sedang
                    @else badge-tinggi
                    @endif" 
                    style="font-size: 14px; padding: 5px 15px;">
                    {{ $hasil['saran']['tingkat']->nama }}
                </span>
                <p style="font-size: 24px; font-weight: bold; margin-top: 10px;">
                    {{ round($hasil['saran']['persentase']) }}%
                </p>
            </div>
            
            @if(isset($hasil['saran']['gejala_kurang_ids']) && count($hasil['saran']['gejala_kurang_ids']) > 0)
            <div style="margin-top: 15px;">
                <p style="font-weight: bold;">Gejala yang kurang untuk diagnosis pasti:</p>
                <ul style="margin-top: 5px; padding-left: 20px;">
                    @foreach($gejalaKurangDetail as $g)
                    <li style="margin: 3px 0;">{{ $g->kode }} - {{ $g->deskripsi }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <p style="margin-top: 15px; font-size: 11px; font-style: italic;">
                <strong>Catatan:</strong> Ini adalah SARAN berdasarkan gejala Anda, 
                bukan diagnosis pasti. Konsultasikan dengan psikolog untuk hasil yang akurat.
            </p>
        </div>
        @endif

    @else
        <div class="result-card">
            <div class="badge 
                @if($hasil['hasil_final']->kode == 'T01') badge-rendah
                @elseif($hasil['hasil_final']->kode == 'T02') badge-sedang
                @else badge-tinggi
                @endif">
                {{ $hasil['hasil_final']->nama }}
            </div>
            <div class="percentage">
                100%
            </div>
            <div style="font-size: 11px; color: #666; margin-top: 5px;">
                Diagnosis Pasti - Semua Gejala Terpenuhi
            </div>
        </div>

        <h3>Deskripsi</h3>
        <p>{{ $hasil['hasil_final']->deskripsi }}</p>

        <h3>Solusi yang Disarankan</h3>
        <div class="solution-box">
            <div style="white-space: pre-line;">{{ $hasil['hasil_final']->solusi }}</div>
        </div>
    @endif

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
            @foreach($detailHasil as $key => $item)
            <tr>
                <td>
                    @if($key == 'R3') Kecanduan Tinggi
                    @elseif($key == 'R2') Kecanduan Sedang
                    @else Kecanduan Rendah
                    @endif
                </td>
                <td>{{ $item['total_cocok'] }}</td>
                <td>{{ $item['total_dibutuhkan'] }}</td>
                <td>
                    <strong>{{ round($item['persentase']) }}%</strong>
                    <div class="progress-bar">
                        <div class="progress-fill 
                            @if($key == 'R3') progress-red
                            @elseif($key == 'R2') progress-yellow
                            @else progress-green
                            @endif" 
                            style="width: {{ $item['persentase'] }}%">
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Gejala yang Anda Pilih</h3>
    <div class="gejala-list">
        @foreach($gejalaDipilih as $g)
            <span class="gejala-tag">{{ $g->kode }}</span>
        @endforeach
    </div>
    <p style="font-size: 11px; color: #666; margin-top: 5px;">Total: {{ count($gejalaDipilih) }} gejala</p>

    <div class="warning-box">
        <strong>Disclaimer</strong><br>
        Sistem pakar ini hanya memberikan diagnosis awal berdasarkan gejala yang Anda pilih.<br>
        Hasil diagnosis bukan merupakan pengganti konsultasi langsung dengan psikolog atau tenaga kesehatan mental profesional.
    </div>

    <div class="footer">
        <p>SMed Checker - Sistem Pakar Diagnosis Kecanduan Media Sosial</p>
        <p>Metode Forward Chaining dengan Prioritas Tingkat Kecanduan (R3 → R2 → R1)</p>
        <p>Dicetak pada {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
    </div>

</body>
</html>