<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - KosKu</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">    <style>
        body {
            zoom: 0.9;
        }
        
        .help-center {
            padding-top: 100px;
            padding-bottom: 80px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .help-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .help-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 16px;
        }

        .help-header p {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-container {
            max-width: 600px;
            margin: 0 auto 48px;
        }

        .search-form {
            display: flex;
            gap: 12px;
            background: #fff;
            padding: 8px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #eee;
            border-radius: 8px;
            font-size: 1rem;
        }

        .search-button {
            padding: 12px 24px;
            background: #222;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-button:hover {
            background: #000;
        }

        .search-results {
            margin-top: 24px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .search-result-item {
            padding: 20px;
            border-bottom: 1px solid #eee;
            transition: background 0.3s;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background: #f8f9fa;
        }

        .search-result-item h3 {
            color: #222;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .search-result-item p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0;
        }

        .no-results {
            padding: 32px;
            text-align: center;
            color: #666;
        }

        .help-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
        }

        .help-card {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            cursor: pointer;
        }

        .help-card:hover {
            transform: translateY(-4px);
        }

        .help-card i {
            font-size: 2rem;
            color: #222;
            margin-bottom: 16px;
        }

        .help-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 12px;
        }

        .help-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .help-card .learn-more {
            color: #222;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .help-card .learn-more:hover {
            text-decoration: underline;
        }

        .faq-section {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .faq-section h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 24px;
        }

        .faq-item {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }

        .faq-question {
            font-weight: 600;
            color: #222;
            margin-bottom: 12px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }        .faq-answer {
            color: #666;
            line-height: 1.6;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            padding: 0 16px;
        }

        .faq-answer.active {
            max-height: 200px;
            padding: 16px;
        }

        .faq-question i {
            transition: transform 0.3s ease;
        }

        .faq-question i.fa-chevron-up {
            transform: rotate(-180deg);
        }

        @media (max-width: 768px) {
            .help-header h1 {
                font-size: 2rem;
            }

            .help-grid {
                grid-template-columns: 1fr;
            }

            .faq-section {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        @include('components.navbar')
    </header>

    <!-- Help Center Content -->
    <section class="help-center">
        <div class="container">
            <div class="help-header">
                <h1>Pusat Bantuan KosKu</h1>
                <p>Temukan jawaban untuk pertanyaan Anda seputar layanan KosKu</p>
            </div>

            <div class="search-container">
                <form class="search-form" action="{{ route('help.search') }}" method="GET">
                    @csrf
                    <input type="text" name="query" class="search-input" placeholder="Cari bantuan..." value="{{ request('query') }}">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>

                @if(request('query'))
                <div class="search-results">
                    @if(isset($results) && count($results) > 0)
                        @foreach($results as $result)
                            <div class="search-result-item">
                                <h3>{{ $result->title }}</h3>
                                <p>{{ $result->excerpt }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="no-results">
                            <p>Tidak ada hasil ditemukan untuk "{{ request('query') }}"</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <div class="help-grid">
                <div class="help-card">
                    <i class="fas fa-home"></i>
                    <h3>Pencarian Kos</h3>
                    <p>Pelajari cara mencari dan memesan kos yang sesuai dengan kebutuhan Anda.</p>
                    <a href="#" class="learn-more">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="help-card">
                    <i class="fas fa-money-bill-wave"></i>
                    <h3>Pembayaran</h3>
                    <p>Informasi tentang metode pembayaran dan proses transaksi di KosKu.</p>
                    <a href="#" class="learn-more">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="help-card">
                    <i class="fas fa-user-shield"></i>
                    <h3>Keamanan Akun</h3>
                    <p>Tips dan panduan untuk menjaga keamanan akun Anda di KosKu.</p>
                    <a href="#" class="learn-more">
                        Pelajari lebih lanjut <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="faq-section">
                <h2>Pertanyaan yang Sering Diajukan</h2>

                <div class="faq-item">
                    <div class="faq-question">
                        Bagaimana cara memesan kos di KosKu? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Untuk memesan kos, Anda perlu membuat akun terlebih dahulu. Setelah itu, Anda dapat mencari kos yang sesuai, memilih kamar, dan melakukan pembayaran melalui berbagai metode yang tersedia.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        Apa saja metode pembayaran yang tersedia? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        KosKu menyediakan berbagai metode pembayaran, termasuk transfer bank, kartu kredit, e-wallet, dan pembayaran virtual account untuk kemudahan transaksi Anda.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        Bagaimana jika saya ingin membatalkan pesanan? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Kebijakan pembatalan dapat berbeda untuk setiap kos. Silakan periksa syarat dan ketentuan pembatalan yang tertera pada halaman detail kos sebelum melakukan pemesanan.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        Apakah saya bisa melihat kos secara langsung? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Ya, Anda dapat mengatur jadwal survey dengan pemilik kos melalui fitur chat yang tersedia di platform KosKu.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        @include('components.footer')
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // FAQ Toggle functionality
            document.querySelectorAll('.faq-question').forEach(question => {
                question.addEventListener('click', () => {
                    const answer = question.nextElementSibling;
                    const icon = question.querySelector('i');
                    const currentActive = document.querySelector('.faq-answer.active');
                    const currentActiveIcon = document.querySelector('.faq-question i.fa-chevron-up');
                    
                    // Close currently active FAQ if it's not the one being clicked
                    if (currentActive && currentActive !== answer) {
                        currentActive.classList.remove('active');
                        if (currentActiveIcon) {
                            currentActiveIcon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                        }
                    }
                    
                    // Toggle clicked FAQ
                    answer.classList.toggle('active');
                    if (answer.classList.contains('active')) {
                        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                    } else {
                        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                    }
                });
            });

            // Search input enhancement
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    if (e.target.value.length > 2) {
                        e.target.closest('form').classList.add('active');
                    } else {
                        e.target.closest('form').classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>
</html>