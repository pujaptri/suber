<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Surat Masuk</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .kop {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
        .kop h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            color: #111827;
            letter-spacing: 1px;
        }
        .kop p {
            margin: 4px 0 0 0;
            font-size: 9px;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
            color: #111827;
            letter-spacing: 0.5px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 3px 0;
            font-size: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 8px 6px;
            font-weight: bold;
            font-size: 9px;
            text-align: left;
            text-transform: uppercase;
            color: #374151;
        }
        .table td {
            border: 1px solid #e5e7eb;
            padding: 8px 6px;
            font-size: 9px;
            vertical-align: top;
        }
        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-kategori {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }
        .badge-sifat {
            background-color: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .badge-sifat-penting {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .footer-container {
            margin-top: 50px;
            width: 100%;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-title {
            font-size: 10px;
            margin-bottom: 45px;
        }
        .ttd-signature {
            position: relative;
            height: 60px;
            margin: 5px 0;
        }
        .stamp {
            position: absolute;
            top: -15px;
            left: 35px;
            width: 90px;
            height: 90px;
            border: 3px double #1d4ed8;
            border-radius: 50%;
            color: #1d4ed8;
            text-align: center;
            font-weight: bold;
            font-size: 7px;
            opacity: 0.65;
            transform: rotate(-15deg);
            background-color: transparent;
        }
        .stamp-text-top {
            margin-top: 18px;
            font-size: 8px;
            text-transform: uppercase;
        }
        .stamp-text-mid {
            border-top: 1px dashed #1d4ed8;
            border-bottom: 1px dashed #1d4ed8;
            margin: 4px 10px;
            padding: 2px 0;
            font-size: 9px;
        }
        .stamp-text-bot {
            font-size: 7px;
        }
        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 10px;
        }
        .ttd-nip {
            font-size: 9px;
            color: #4b5563;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <!-- KOP Surat -->
    <div class="kop">
        <h1>SUBER</h1>
        <p>Sistem Informasi Persuratan & Administrasi Dokumen Resmi</p>
    </div>

    <!-- Title -->
    <div class="title">
        Laporan Data Surat Masuk
    </div>

    <!-- Metadata -->
    <table class="meta-table">
        <tr>
            <td style="width: 12%;">Tanggal Cetak</td>
            <td style="width: 3%;">:</td>
            <td style="width: 35%;">{{ now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</td>
            <td style="width: 12%;">Dicetak Oleh</td>
            <td style="width: 3%;">:</td>
            <td style="width: 35%;">{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <td>Total Dokumen</td>
            <td>:</td>
            <td>{{ count($suratMasuk) }} Surat Masuk</td>
            <td>Status Server</td>
            <td>:</td>
            <td>ONLINE</td>
        </tr>
    </table>

    <!-- Table -->
    <table class="table">
        <thead>
            <tr>
                <th class="text-center" style="width: 4%;">No</th>
                <th style="width: 20%;">Nomor Surat</th>
                <th style="width: 12%;">Tgl. Surat</th>
                <th style="width: 12%;">Tgl. Diterima</th>
                <th style="width: 18%;">Asal Surat</th>
                <th style="width: 20%;">Perihal</th>
                <th style="width: 14%;">Kategori / Sifat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratMasuk as $index => $surat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #111827;">{{ $surat->nomor_surat }}</td>
                    <td>{{ $surat->tanggal_surat->locale('id')->isoFormat('DD MMM Y') }}</td>
                    <td>{{ $surat->tanggal_diterima->locale('id')->isoFormat('DD MMM Y') }}</td>
                    <td>{{ $surat->asal_surat }}</td>
                    <td>{{ $surat->perihal ?? '-' }}</td>
                    <td>
                        <span class="badge badge-kategori">{{ $surat->kategori }}</span>
                        <div style="margin-top: 4px;">
                            <span class="badge {{ $surat->sifat_surat === 'penting' || $surat->sifat_surat === 'rahasia' || $surat->sifat_surat === 'sangat_rahasia' ? 'badge-sifat-penting' : 'badge-sifat' }}">
                                {{ $surat->sifat_surat }}
                            </span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="color: #9ca3af; padding: 20px 0;">Tidak ada data surat masuk ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan & Stempel -->
    <div class="footer-container">
        <div class="ttd-box">
            <div class="ttd-title">
                Jakarta, {{ now()->locale('id')->isoFormat('D MMMM Y') }}<br>
                <strong>Sekretaris Utama Instansi</strong>
            </div>
            
            <div class="ttd-signature">
                <!-- Stempel Instansi Otomatis -->
                <div class="stamp">
                    <div class="stamp-text-top">SUBER PERSURATAN</div>
                    <div class="stamp-text-mid">STEMPEL</div>
                    <div class="stamp-text-bot">RESMI INSTANSI</div>
                </div>
                
                <!-- Placeholder Tanda Tangan Digital -->
                <div style="margin-top: 15px; font-style: italic; color: #4b5563; font-size: 9px; font-weight: bold; border: 1px dashed #d1d5db; display: inline-block; padding: 6px 12px; border-radius: 4px; background-color: #fafafa; position: relative; z-index: 10;">
                    TANDATANGAN DIGITAL RESMI
                </div>
            </div>

            <div class="ttd-name">
                {{ Auth::user()->name }}
            </div>
            <div class="ttd-nip">
                NIP. 19920824 {{ date('Y') }}12 1 001
            </div>
        </div>
    </div>
</body>
</html>
