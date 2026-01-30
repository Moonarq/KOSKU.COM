<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - KosKu</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            zoom: 0.9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .about-hero {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
        }

        .about-hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-hero-content p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .about-section {
            padding: 80px 0;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .about-content {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e5e9;
        }

        .about-content h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 24px;
            color: #1a1a1a;
        }

        .about-content p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
            margin-bottom: 16px;
        }

        .about-image {
            text-align: center;
        }

        .about-image img {
            width: 100%;
            max-width: 500px;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .mission-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 80px 0;
        }

        .mission-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .mission-card {
            background: white;
            padding: 40px 32px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border: 1px solid #e1e5e9;
            position: relative;
            overflow: hidden;
        }

        .mission-card i {
            font-size: 2.5rem;
            color: #1a1a1a;
            margin-bottom: 20px;
            display: block;
        }

        .mission-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1a1a1a;
        }

        .mission-card p {
            color: #555;
            line-height: 1.6;
            font-size: 1rem;
        }

        .stats-section {
            padding: 80px 0;
            background: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }

        .stat-card {
            text-align: center;
            padding: 32px 24px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 1px solid #e1e5e9;
        }

        .stat-card h3 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-card p {
            color: #555;
            font-size: 1.1rem;
            font-weight: 500;
        }

        @media (max-width: 1024px) {
            .about-grid,
            .mission-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-content,
            .mission-card {
                padding: 32px 24px;
            }
        }

        @media (max-width: 768px) {
            .about-hero {
                padding: 100px 0 60px;
            }

            .about-hero-content h1 {
                font-size: 2.5rem;
            }

            .about-hero-content p {
                font-size: 1.1rem;
            }

            .about-content h2 {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .mission-grid {
                gap: 24px;
            }

            .about-section,
            .mission-section,
            .stats-section {
                padding: 60px 0;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
            }

            .about-hero-content h1 {
                font-size: 2rem;
            }

            .stat-card h3 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>

@include('components.navbar')

<div class="about-hero">
    <div class="container">
        <div class="about-hero-content">
            <h1>Tentang KosKu</h1>
            <p>Menghubungkan mahasiswa dan profesional muda dengan hunian berkualitas di seluruh Indonesia</p>
        </div>
    </div>
</div>

<div class="about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <h2>Cerita Kami</h2>
                <p>Didirikan pada tahun 2025, KosKu lahir dari sebuah ide sederhana namun kuat: untuk mempermudah pencarian dan pemesanan hunian berkualitas bagi mahasiswa dan profesional muda di Indonesia.</p>
                <p>Berawal dari platform kecil, kini kami telah berkembang menjadi marketplace terpercaya yang menghubungkan ribuan pemilik kos dengan penyewa di seluruh negeri.</p>
            </div>
            <div class="about-image">
                <img src="{{ asset('images/modernnnnnn-room.png') }}" alt="Cerita KosKu">
            </div>
        </div>
    </div>
</div>

<div class="mission-section">
    <div class="container">
        <div class="mission-grid">
            <div class="mission-card">
                <i class="fas fa-home"></i>
                <h3>Misi Kami</h3>
                <p>Menyediakan solusi hunian yang terjangkau, terpercaya, dan berkualitas untuk meningkatkan pengalaman tinggal pengguna kami.</p>
            </div>
            <div class="mission-card">
                <i class="fas fa-handshake"></i>
                <h3>Nilai-Nilai Kami</h3>
                <p>Kepercayaan, transparansi, dan kepuasan pengguna adalah inti dari setiap langkah kami.</p>
            </div>
            <div class="mission-card">
                <i class="fas fa-chart-line"></i>
                <h3>Visi Kami</h3>
                <p>Menjadi platform terpercaya nomor satu di Indonesia untuk mencari dan mengelola hunian berkualitas.</p>
            </div>
        </div>
    </div>
</div>

<div class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <h3>10K+</h3>
                <p>Properti Terdaftar</p>
            </div>
            <div class="stat-card">
                <h3>50K+</h3>
                <p>Pengguna Puas</p>
            </div>
            <div class="stat-card">
                <h3>20+</h3>
                <p>Kota Terjangkau</p>
            </div>
            <div class="stat-card">
                <h3>100%</h3>
                <p>Transaksi Aman</p>
            </div>
        </div>
    </div>
</div>

@include('components.footer')

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
