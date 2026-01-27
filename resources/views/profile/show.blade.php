<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - NeedKos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        @include('components.navbar')
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="main-container">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="profile-section">
                    <div class="profile-avatar">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Profile">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Profile">
                        @endif
                    </div>
                    <div class="profile-info">
                        <h3>{{ $user->name }}</h3>
                        <p>{{ $user->email }}</p>
                        <p class="role">{{ $user->role }}</p>
                    </div>
                </div>
                
                <div class="profile-completion">
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                    <div class="progress-text">10%</div>
                    <div class="progress-detail">1 / 10 data profil terisi</div>
                    <p class="profile-help">Profil yang lengkap membantu kami memberikan rekomendasi yang lebih akurat.</p>
                </div>

                <nav class="profile-nav">
                    <ul class="menu-list">
                        <li class="menu-item active">
                            <a href="#"><i class="fas fa-home menu-icon"></i> Kos Saya</a>
                        </li>
                        <li class="menu-item">
                            <a href="#"><i class="fas fa-history menu-icon"></i> Riwayat Pengajuan</a>
                        </li>
                        <li class="menu-item">
                            <a href="#"><i class="fas fa-bed menu-icon"></i> Riwayat Kos</a>
                        </li>
                        <li class="menu-item">
                            <a href="#"><i class="fas fa-receipt menu-icon"></i> Riwayat Transaksi</a>
                        </li>
                        <li class="menu-item">
                            <a href="#"><i class="fas fa-coins menu-icon"></i> Poin Saya <span class="points-badge">0</span></a>
                        </li>
                        <li class="menu-item">
                            <a href="#"><i class="fas fa-ticket-alt menu-icon"></i> Voucher Saya</a>
                        </li>
                        <li class="menu-item">
                            <a href="#"><i class="fas fa-user-check menu-icon"></i> Verifikasi Akun</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('profile.settings') }}" class="menu-link">
                                <i class="fas fa-user-cog menu-icon"></i> Pengaturan
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="main-content">
                <div class="content-header">
                    <h1>Kamu belum menyewa kos</h1>
                </div>
                
                <div class="empty-state">
                    <p>Yuk, sewa di NeedKos atau masukkan kode dari pemilik kos untuk aktifkan halaman ini! Coba cara ngekos modern dengan manfaat berikut ini.</p>
                    
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="feature-text">Tagihan dan kontrak sewa tercatat rapi</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="feature-text">NeedKos menjaga keamanan transaksi</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="feature-text">Cashless, dengan beragam metode pembayaran</div>
                        </div>
                    </div>

                    <div class="btn-group">
                        <a href="#" class="btn btn-primary">Mulai cari dan sewa kos</a>
                        <a href="#" class="btn btn-secondary">Masukkan kode dari pemilik</a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        @include('components.footer')
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
</body>
</html>