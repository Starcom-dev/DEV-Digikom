<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Iuran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            text-align: center;
        }

        th,
        td {
            padding: 6px;
            border: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">
        Laporan Iuran Periode :
        {{ $tahun ?? '-' }}
        @if (!empty($bulan))
            {{ \Carbon\Carbon::create()->month((int) $bulan)->format('F') }}
        @endif
    </h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User ID</th>
                <th>Nama</th>
                <th>Jenis Iuran</th>
                <th>Tanggal Bayar</th>
                <th>Metode Bayar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->user_id }}</td>
                    <td>{{ $item->users->full_name }}</td>
                    <td class="text-center">{{ $item->iuran->keterangan }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal_bayar'])->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $item->metode_pembayaran }}</td>
                    <td>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
