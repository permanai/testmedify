<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kategori - {{ $data->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 30px 40px;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            font-size: 11px;
            color: #666;
        }

        .info-section {
            margin-bottom: 25px;
        }
        .info-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #222;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .info-table {
            width: auto;
        }
        .info-table td {
            padding: 3px 10px 3px 0;
            vertical-align: top;
        }
        .info-table td.label {
            font-weight: bold;
            width: 120px;
        }
        .info-table td.separator {
            width: 15px;
            text-align: center;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 25px;
        }
        .items-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #222;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table thead th {
            background-color: #343a40;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .items-table tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        .items-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .items-table tbody tr:hover {
            background-color: #e9ecef;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .empty-message {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 40px;
            right: 40px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            font-size: 10px;
            color: #888;
            display: table;
            width: calc(100% - 80px);
        }
        .footer-left {
            display: table-cell;
            text-align: left;
        }
        .footer-right {
            display: table-cell;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Kategori Item</h1>
        <p>Sistem Manajemen Master Items</p>
    </div>

    <div class="info-section">
        <h3>Informasi Kategori</h3>
        <table class="info-table">
            <tr>
                <td class="label">Kode Kategori</td>
                <td class="separator">:</td>
                <td>{{ $data->kode }}</td>
            </tr>
            <tr>
                <td class="label">Nama Kategori</td>
                <td class="separator">:</td>
                <td>{{ $data->nama }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Item</td>
                <td class="separator">:</td>
                <td>{{ $data->masterItems->count() }} item</td>
            </tr>
        </table>
    </div>

    <div class="items-section">
        <h3>Daftar Item dalam Kategori "{{ $data->nama }}"</h3>

        @if($data->masterItems->count() > 0)
        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 40px;">No</th>
                    <th>Kode</th>
                    <th>Nama Item</th>
                    <th>Jenis</th>
                    <th class="text-right">Harga Beli</th>
                    <th class="text-right">Laba (%)</th>
                    <th class="text-right">Harga Jual</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->masterItems as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td class="text-right">{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->laba }}%</td>
                    <td class="text-right">{{ number_format($item->harga_beli + ($item->harga_beli * $item->laba / 100), 0, ',', '.') }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="empty-message">Belum ada item dalam kategori ini.</p>
        @endif
    </div>

    <div class="footer">
        <span class="footer-left">Kategori: {{ $data->kode }} - {{ $data->nama }}</span>
        <span class="footer-right">Dicetak pada: {{ $tanggal_cetak }}</span>
    </div>

</body>
</html>
