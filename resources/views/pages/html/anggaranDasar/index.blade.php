<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peraturan Organisasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .anggaran-container {
            margin: 0 auto;
            max-width: 800px;
        }
        .anggaran-item {
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .anggaran-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .anggaran-desc {
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="anggaran-container">
        @forelse($anggaran_dasar as $anggaran)
            <div class="anggaran-item">
                <h1 class="anggaran-title"> {{ $anggaran->judul_utama }}</h1>
                <h3 class="anggaran-desc">{{ $anggaran->sub_judul }}</h3>
                <div class="anggaran-desc">{{ $anggaran->deskripsi }}</div>
            </div>
        @empty
            <p>Tidak ada data anggaran organisasi yang tersedia.</p>
        @endforelse
    </div>
</body>
</html>
