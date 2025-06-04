<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Grafik Harga {{ $title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 2rem;
            color: #1f2937;
        }
        .container {
            padding: 2rem;
            text-align: center;
        }
        .title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #111827;
        }
        .subtext {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }
        img {
            width: 100%;
            max-width: 600px;
            margin: auto;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Laporan Grafik Dinas</div>
        <div class="subtext"><strong>{{ $title }}</strong></div>
        <img src="{{ $image }}" alt="Grafik Dinas">
    </div>
</body>
</html>
