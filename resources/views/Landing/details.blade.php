<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Kos - KosKu</title>    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS for star colors -->
    <style>
    .rating-filter-btn {
        position: relative;
    }
    
    .rating-filter-btn .star-yellow {
        color: #fbbf24 !important; /* Bright yellow color */
    }
    
    .rating-filter-btn .star-gray {
        color: #d1d5db !important; /* Light gray color */
    }
    
    .rating-filter-btn.active .star-yellow {
        color: #fcd34d !important; /* Lighter yellow when active */
    }
    
    .rating-filter-btn.active .star-gray {
        color: #9ca3af !important; /* Darker gray when active */
    }
    </style>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>
<!-- Header -->
<header class="header">
    @include('components.navbar')
</header>

<!-- Detail Section -->
<!-- Detail Section -->
<section class="property-detail">
    <div class="container">
        @php
            $locationInfo = $kos->location_info ?? ['city' => '', 'province' => ''];
            $images = is_array($kos->image) ? $kos->image : (empty($kos->image) ? [] : [$kos->image]);
            $mainImage = $images[0] ?? null;
        @endphp
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="#">Kos</a>
            <span class="breadcrumb-separator">></span>
            <a href="#">{{ $locationInfo['city'] ?? '' }}</a>
            <span class="breadcrumb-separator">></span>
            <a href="#">{{ $locationInfo['province'] ?? '' }}</a>
            <span class="breadcrumb-separator">></span>
            <span>{{ $kos->name }}</span>
        </nav>

        <!-- Gallery Header -->
        <div class="gallery-header">
            <h2 class="gallery-title"></h2>
            <button class="show-all-photos" onclick="showAllPhotos()">
                <i class="fas fa-images"></i> Lihat semua foto
            </button>
        </div>

        <!-- Image Gallery -->
        <div class="image-gallery">
            <div class="main-image">
                <img id="currentImage" src="{{ $mainImage ? asset('storage/' . $mainImage) : asset('images/default-kos.jpg') }}" alt="{{ $kos->name }}" width="480" height="320">
            </div>
            <div class="thumbnail-grid">
                <div class="thumbnail-row">
                    @foreach(array_slice($images, 0, 6) as $img)
                        <div class="thumbnail" style="cursor:pointer;">
                            <img src="{{ asset('storage/' . $img) }}" alt="Thumbnail" width="80" height="54">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Property Header -->
        <div class="property-header">
            <div class="property-info-left">                  <div class="property-badges">
                    <span class="badge badge-type">
                        {{ $kos->gender_label ?? 'Kos' }}
                    </span>
                    <button id="saveButton" class="save-button" onclick="toggleSave({{ $kos->id }})" title="Simpan properti ini">
                        <i id="saveIcon" class="far fa-bookmark"></i>
                    </button>
                </div><div class="title-with-save">
                    <h1 class="property-title">{{ $kos->name }}</h1>
                </div>

                <div class="property-rating">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa{{ $i <= ($kos->rating ?? 0) ? 's' : 'r' }} fa-star"></i>
                        @endfor
                    </div>
                    <span class="rating-info">{{ $kos->rating ?? 0 }}/5 ({{ $kos->review_count ?? 0 }} review)</span>
                </div>

                <div class="property-location">{{ $kos->address }}</div>
            </div>            <div class="price-section">
                <div class="price-label">Mulai dari</div>
                <div class="price-main">IDR {{ number_format($kos->price, 0, ',', '.') }}</div>
                <div class="price-period">/bulan</div>                <div class="action-buttons">
                    <button class="book-button">Yuk, Booking Sekarang!</button>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <nav class="property-nav">
            <div class="nav-tabs">
                <button class="nav-tab active" onclick="showTab('info')">Info Umum</button>
                @unless($hideReviews ?? false)
                    <button class="nav-tab" onclick="showTab('review')">Review</button>
                @endunless
                <button class="nav-tab" onclick="showTab('fasilitas')">Fasilitas Favorit</button>
                <button class="nav-tab" onclick="showTab('lokasi')">Lokasi</button>
                <button class="nav-tab" onclick="showTab('kebijakan')">Kebijakan Akomodasi</button>
                <button class="nav-tab" onclick="showTab('tentang')">Tentang</button>
                <button class="nav-tab" onclick="showTab('kamar')">Kamar</button>
            </div>
        </nav>

        <!-- Content Sections -->
        <div class="content-section active" id="info">
            <h3>Kenapa Sih Harus {{ $kos->name }} ?</h3>
            <p>{{ $kos->description }}</p>

            <h3>Peraturan Kos</h3>
            <p>{{ $kos->rules }}</p>

            <div class="contact-info">
                <i class="fas fa-phone"></i>
                <span>{{ $kos->contact_person }}</span>
            </div>

            <a href="#" class="action-button">
                <i class="fas fa-key"></i>
                Ajukan Sewa
            </a>
        </div>

        @unless($hideReviews ?? false)
        <div class="content-section" id="review">
            <div class="section-header">
                <h3>Ulasan Penghuni</h3>
                @auth
                    <button class="add-review-btn" onclick="openModal()">
                        <i class="fas fa-plus"></i>
                        Tambah Ulasan
                    </button>
                @else
                    <a class="add-review-btn" href="{{ route('login.show') }}">
                        <i class="fas fa-plus"></i>
                        Login untuk tambah ulasan
                    </a>
                @endauth            </div>            <!-- FILTER REVIEW (tidak mengubah tampilan lain) -->
            <div id="review-filters" style="
                margin: 32px 0 24px 0; 
                padding: 0; 
                display: flex; 
                gap: 8px; 
                align-items: center; 
                flex-wrap: wrap;
                border-bottom: 1px solid #e5e7eb;
                padding-bottom: 16px;
            ">
                <span style="font-size: 15px; font-weight: 500; color: #374151; margin-right: 8px;">Filter by:</span>
                
                <!-- Rating Filter Buttons -->
                <button class="rating-filter-btn active" data-rating="all" style="
                    padding: 8px 16px; 
                    border-radius: 20px; 
                    border: 1px solid #d1d5db; 
                    background: #111827; 
                    color: white; 
                    font-size: 14px; 
                    font-weight: 500;
                    cursor: pointer; 
                    transition: all 0.2s ease;
                    white-space: nowrap;
                    outline: none;
                ">All ratings</button>
                  <button class="rating-filter-btn" data-rating="5" style="
                    padding: 8px 16px; 
                    border-radius: 20px; 
                    border: 1px solid #d1d5db; 
                    background: white; 
                    color: #374151; 
                    font-size: 14px; 
                    font-weight: 500;
                    cursor: pointer; 
                    transition: all 0.2s ease;
                    white-space: nowrap;
                    outline: none;
                ">
                    <span class="star-yellow">★★★★★</span>
                </button>
                
                <button class="rating-filter-btn" data-rating="4" style="
                    padding: 8px 16px; 
                    border-radius: 20px; 
                    border: 1px solid #d1d5db; 
                    background: white; 
                    color: #374151; 
                    font-size: 14px; 
                    font-weight: 500;
                    cursor: pointer; 
                    transition: all 0.2s ease;
                    white-space: nowrap;
                    outline: none;
                ">
                    <span class="star-yellow">★★★★</span><span class="star-gray">★</span>
                </button>
                
                <button class="rating-filter-btn" data-rating="3" style="
                    padding: 8px 16px; 
                    border-radius: 20px; 
                    border: 1px solid #d1d5db; 
                    background: white; 
                    color: #374151; 
                    font-size: 14px; 
                    font-weight: 500;
                    cursor: pointer; 
                    transition: all 0.2s ease;
                    white-space: nowrap;
                    outline: none;
                ">
                    <span class="star-yellow">★★★</span><span class="star-gray">★★</span>
                </button>
                
                <button class="rating-filter-btn" data-rating="2" style="
                    padding: 8px 16px; 
                    border-radius: 20px; 
                    border: 1px solid #d1d5db; 
                    background: white; 
                    color: #374151; 
                    font-size: 14px; 
                    font-weight: 500;
                    cursor: pointer; 
                    transition: all 0.2s ease;
                    white-space: nowrap;
                    outline: none;
                ">
                    <span class="star-yellow">★★</span><span class="star-gray">★★★</span>
                </button>
                
                <button class="rating-filter-btn" data-rating="1" style="
                    padding: 8px 16px; 
                    border-radius: 20px; 
                    border: 1px solid #d1d5db; 
                    background: white; 
                    color: #374151; 
                    font-size: 14px; 
                    font-weight: 500;
                    cursor: pointer; 
                    transition: all 0.2s ease;
                    white-space: nowrap;
                    outline: none;
                ">
                    <span class="star-yellow">★</span><span class="star-gray">★★★★</span>
                </button>
                
                <!-- Separator -->
                <div style="width: 1px; height: 24px; background: #e5e7eb; margin: 0 8px;"></div>
                
                <!-- Image Filter Button -->
                <button id="filter-image" data-active="0" style="
                    padding: 8px 16px; 
                    border-radius: 20px; 
                    border: 1px solid #d1d5db; 
                    background: white; 
                    color: #374151; 
                    font-size: 14px; 
                    font-weight: 500;
                    cursor: pointer; 
                    transition: all 0.2s ease;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    outline: none;
                    white-space: nowrap;
                ">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="opacity: 0.7;">
                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                    </svg>
                    With photos
                </button>
            </div>

            <div id="reviews-container"></div>            <!-- Load More Button - Inside review section -->
            <div id="load-more-reviews-container" style="text-align:center;margin-top:24px;display:block;">
                <button id="loadMoreReviewsBtn" style="
                    background: #f8f9fa;
                    color: #495057;
                    border: 1px solid #dee2e6;
                    padding: 10px 24px;
                    border-radius: 6px;
                    font-size: 0.875rem;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                " 
                onmouseover="this.style.background='#e9ecef'; this.style.borderColor='#e9ecef';"
                onmouseout="this.style.background='#f8f9fa'; this.style.borderColor='#dee2e6';"
                onclick="loadMoreReviews()">
                    <i class="fas fa-chevron-down" style="font-size: 0.75rem;"></i>
                    Tampilkan Lebih Banyak
                </button>
            </div>
        </div>        @auth
        <div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
            <div class="modal" onclick="event.stopPropagation()">
                <div class="modal-header">
                    <h3 class="modal-title">Tambah Ulasan</h3>
                    <button class="close-btn" onclick="closeModal()">&times;</button>
                </div>
                <form id="reviewForm" method="POST">
                    <div class="form-group">
                        <label class="form-label" for="reviewerName">Nama</label>
                        <input type="text" id="reviewerName" class="form-input" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Rating</label>
                        <div class="star-rating" id="starRating">
                            <i class="fas fa-star star" data-rating="1"></i>
                            <i class="fas fa-star star" data-rating="2"></i>
                            <i class="fas fa-star star" data-rating="3"></i>
                            <i class="fas fa-star star" data-rating="4"></i>
                            <i class="fas fa-star star" data-rating="5"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reviewText">Ulasan</label>
                        <textarea id="reviewText" class="form-textarea" placeholder="Bagikan pengalaman Anda..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="reviewImages">Foto (Opsional)</label>
                        <div class="upload-section">
                            <label for="reviewImages" class="upload-label">
                                <div class="upload-icon">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <span class="upload-text">Klik untuk upload foto</span>
                                <span class="upload-hint">Maksimal 5 foto, 2MB per file</span>
                            </label>
                            <input type="file" id="reviewImages" class="upload-input" multiple accept="image/*">
                        </div>
                        <div id="imagePreview" class="image-preview-container"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel" onclick="closeModal()">Batal</button>
                        <button type="submit" class="btn btn-submit">Kirim Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
        @endauth
        @endunless

        @php
        $facilitiesList = [
            'wifi' => ['icon' => 'fas fa-wifi', 'label' => 'WiFi Gratis'],
            'shower' => ['icon' => 'fas fa-shower', 'label' => 'Kamar Mandi Dalam'],
            'parking' => ['icon' => 'fas fa-car', 'label' => 'Parkir'],
            'ac' => ['icon' => 'fas fa-fan', 'label' => 'AC'],
            'kitchen' => ['icon' => 'fas fa-utensils', 'label' => 'Dapur Bersama'],
            'security' => ['icon' => 'fas fa-shield-alt', 'label' => 'Keamanan 24 Jam'],
            'laundry' => ['icon' => 'fas fa-soap', 'label' => 'Laundry'],
            'pool' => ['icon' => 'fas fa-swimming-pool', 'label' => 'Kolam Renang'],
            'gym' => ['icon' => 'fas fa-dumbbell', 'label' => 'Gym'],
        ];
        @endphp

        <div class="content-section" id="fasilitas">
            <h3>Fasilitas Favorit</h3>
            <div class="facilities-grid">
                @foreach ($kos->facilities ?? [] as $facilityKey)
                    @if (isset($facilitiesList[$facilityKey]))
                        <div class="facility-item">
                            <i class="{{ $facilitiesList[$facilityKey]['icon'] }}"></i>
                            <span>{{ $facilitiesList[$facilityKey]['label'] }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="content-section" id="lokasi">
            <h3>Lokasi Strategis</h3>
            <p class="lokasi-desc">Akses mudah ke mana saja, bikin aktivitas harian makin praktis!</p>
            <div class="map-container" style="margin-top: 24px; border-radius: 12px; overflow: hidden;">
                <iframe src="https://www.google.com/maps?q={{ urlencode($kos->address) }}&output=embed"
                        width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="cta-buttons" style="margin-top: -10px; margin-left: -30px; justify-content: flex-start;">
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($kos->address) }}"
                   target="_blank" class="cta-btn primary">Lihat Lokasi di Google Maps</a>
            </div>
        </div>

        <div class="content-section" id="kebijakan">
            <h3>Kebijakan Akomodasi</h3>
            <p>{{ $kos->rules }}</p>
        </div>

        <div class="content-section" id="tentang">
            <h3>Tentang Properti</h3>
            <p>{{ $kos->description }}</p>
        </div>

        <div class="content-section" id="kamar">
            <h3>Kamar Tersedia</h3>
            <p>Status: <strong>{{ $kos->status ?? 'Tersedia' }}</strong></p>
            <p>Harga: <strong>Rp {{ number_format($kos->price, 0, ',', '.') }}/bulan</strong></p>
        </div>
    </div> <!-- Penutup div.container -->
</section>

<!-- Photo Modal -->
<div class="photo-modal" id="photoModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Semua Foto Properti</h3>
            <button class="close-modal" onclick="closePhotoModal()">&times;</button>
        </div>
        <div class="photo-grid" id="photoGrid">
            <!-- Photos will be dynamically loaded here -->
        </div>
    </div>
</div>

<!-- Large Photo View -->
<div class="large-photo-view" id="largePhotoView">
    <div class="large-photo-container">
        <button class="close-large-view" onclick="closeLargeView()">&times;</button>
        <button class="photo-nav prev" onclick="prevPhoto()">&#8249;</button>
        <img id="largePhoto" src="" alt="Large view">
        <button class="photo-nav next" onclick="nextPhoto()">&#8250;</button>
    </div>
</div>

<!-- Review Image Modal -->
<div class="review-image-modal" id="reviewImageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center;">
    <div class="review-image-container" style="position: relative; max-width: 90%; max-height: 90%;">
        <button class="close-review-modal" onclick="closeReviewImageModal()" style="position: absolute; top: -40px; right: 0; background: none; border: none; color: white; font-size: 30px; cursor: pointer; z-index: 10000;">&times;</button>
        <button class="review-nav prev" onclick="prevReviewImage()" style="position: absolute; left: -50px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; color: white; font-size: 30px; padding: 10px 15px; cursor: pointer; border-radius: 50%;">&#8249;</button>
        <img id="reviewImageLarge" src="" alt="Review image" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px;">
        <button class="review-nav next" onclick="nextReviewImage()" style="position: absolute; right: -50px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; color: white; font-size: 30px; padding: 10px 15px; cursor: pointer; border-radius: 50%;">&#8250;</button>
    </div>
</div>

<!-- Footer -->
<footer class="footer" id="contact">
    @include('components.footer')
</footer>

<script>
    // Semua foto dari backend, untuk modal "Lihat Semua Foto"
    const allPhotosFull = [
        @foreach($kos->image as $img)
            '{{ asset("storage/" . $img) }}'{{ !$loop->last ? ',' : '' }}
        @endforeach
    ];

    // Galeri utama hanya tampil 5 foto (maksimal)
    const galleryPhotos = allPhotosFull.slice(0, 6);

    let currentPhotoIndex = 0;

    // Fungsi untuk menampilkan waktu real-time
    function timeAgo(date) {
        const now = new Date();
        const diffMs = now - date;
        const diffSeconds = Math.floor(diffMs / 1000);
        const diffMinutes = Math.floor(diffSeconds / 60);
        const diffHours = Math.floor(diffMinutes / 60);
        const diffDays = Math.floor(diffHours / 24);
        const diffMonths = Math.floor(diffDays / 30);
        const diffYears = Math.floor(diffDays / 365);

        if (diffSeconds < 60) {
            return diffSeconds <= 5 ? 'Baru saja' : `${diffSeconds} detik yang lalu`;
        } else if (diffMinutes < 60) {
            return `${diffMinutes} menit yang lalu`;
        } else if (diffHours < 24) {
            return `${diffHours} jam yang lalu`;
        } else if (diffDays < 30) {
            return `${diffDays} hari yang lalu`;
        } else if (diffMonths < 12) {
            return `${diffMonths} bulan yang lalu`;
        } else {
            return `${diffYears} tahun yang lalu`;
        }
    }

    function showTab(tabName) {
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => section.classList.remove('active'));
        const tabs = document.querySelectorAll('.nav-tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        document.getElementById(tabName).classList.add('active');
        event.target.classList.add('active');
    }

    function showAllPhotos() {
        const modal = document.getElementById('photoModal');
        const photoGrid = document.getElementById('photoGrid');
        photoGrid.innerHTML = '';

        allPhotosFull.forEach((photo, index) => {
            const photoItem = document.createElement('div');
            photoItem.className = 'photo-item';
            photoItem.onclick = () => showLargePhoto(index);
            photoItem.innerHTML = `
                <img src="${photo}" alt="Foto ${index + 1}">
                <div class="photo-counter">${index + 1} / ${allPhotosFull.length}</div>
            `;
            photoGrid.appendChild(photoItem);
        });

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function showLargePhoto(index) {
        currentPhotoIndex = index;
        const largeView = document.getElementById('largePhotoView');
        const largePhoto = document.getElementById('largePhoto');
        largePhoto.src = allPhotosFull[currentPhotoIndex];
        largeView.classList.add('active');
    }

    function closeLargeView() {
        document.getElementById('largePhotoView').classList.remove('active');
    }

    function nextPhoto() {
        currentPhotoIndex = (currentPhotoIndex + 1) % allPhotosFull.length;
        document.getElementById('largePhoto').src = allPhotosFull[currentPhotoIndex];
    }

    function prevPhoto() {
        currentPhotoIndex = (currentPhotoIndex - 1 + allPhotosFull.length) % allPhotosFull.length;
        document.getElementById('largePhoto').src = allPhotosFull[currentPhotoIndex];
    }        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('currentImage');
            const thumbnails = document.querySelectorAll('.thumbnail img');
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    mainImage.src = thumb.src;
                });
            });

            document.getElementById('photoModal').addEventListener('click', function(e) {
                if (e.target === this) closePhotoModal();
            });

            document.getElementById('largePhotoView').addEventListener('click', function(e) {
                if (e.target === this) closeLargeView();
            });

            document.addEventListener('keydown', function(e) {
                if (document.getElementById('largePhotoView').classList.contains('active')) {
                    if (e.key === 'ArrowRight') nextPhoto();
                    if (e.key === 'ArrowLeft') prevPhoto();
                    if (e.key === 'Escape') closeLargeView();
                }
                if (document.getElementById('photoModal').classList.contains('active')) {
                    if (e.key === 'Escape') closePhotoModal();
                }
            });

            // Check if this kos is already saved
            checkSavedStatus();
        });

        // Save/Unsave functionality
        function toggleSave(kosId) {
            const saveButton = document.getElementById('saveButton');
            const saveIcon = document.getElementById('saveIcon');
            // Optimistic UI: langsung update icon
            const wasSaved = saveButton.classList.contains('saved');
            updateSaveButton(!wasSaved);
            
            // Check if user is logged in
            @auth
                // Disable button during request
                saveButton.disabled = true;
                
                fetch(`/kos/${kosId}/toggle-save`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // updateSaveButton(data.saved); // Sudah dioptimistic, tidak perlu update ulang
                })
                .catch(error => {
                    // Jika gagal, kembalikan ke status sebelumnya
                    updateSaveButton(wasSaved);
                })
                .finally(() => {
                    saveButton.disabled = false;
                });
            @else
                // Redirect to login if not authenticated
                showNotification('Silakan login terlebih dahulu untuk menyimpan properti.', 'info');
                setTimeout(() => {
                    window.location.href = '{{ route("login.show") }}';
                }, 1500);
            @endauth
        }

        function checkSavedStatus() {
            @auth
                fetch(`/kos/{{ $kos->id }}/check-saved`)
                .then(response => response.json())
                .then(data => {
                    updateSaveButton(data.saved);
                })
                .catch(error => {
                    console.error('Error checking saved status:', error);
                });
            @endauth
        }

        function updateSaveButton(isSaved) {
            const saveIcon = document.getElementById('saveIcon');
            const saveButton = document.getElementById('saveButton');
              if (isSaved) {
                saveIcon.className = 'fas fa-bookmark';
                saveButton.classList.add('saved');
                saveButton.title = 'Hapus dari simpanan';
            } else {
                saveIcon.className = 'far fa-bookmark';
                saveButton.classList.remove('saved');
                saveButton.title = 'Simpan properti ini';
            }
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            `;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Hide and remove notification
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
</script>
@unless($hideReviews ?? false)
 <script>
    let selectedRating = 0;

        // Star rating functionality
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.dataset.rating);
                updateStars();
            });

            star.addEventListener('mouseenter', function() {
                const hoverRating = parseInt(this.dataset.rating);
                highlightStars(hoverRating);
            });
        });

        document.getElementById('starRating').addEventListener('mouseleave', function() {
            updateStars();
        });

        function highlightStars(rating) {
            document.querySelectorAll('.star').forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function updateStars() {
            highlightStars(selectedRating);
        }

        // Modal functionality
        function openModal() {
            document.getElementById('modalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(event) {
            if (event && event.target !== event.currentTarget) return;
            
            document.getElementById('modalOverlay').classList.remove('active');
            document.body.style.overflow = 'auto';
            resetForm();
        }

        function resetForm() {
            document.getElementById('reviewForm').reset();
            selectedRating = 0;
            updateStars();
        }        // Form submission
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('reviewerName').value.trim();
            const reviewText = document.getElementById('reviewText').value.trim();
            const images = document.getElementById('reviewImages').files;
            
            if (!name || !reviewText || selectedRating === 0) {
                alert('Mohon lengkapi semua field dan berikan rating!');
                return;
            }            // Tampilkan loading state pada tombol
            const submitBtn = document.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            submitBtn.disabled = true;

            // Create FormData untuk mengirim file
            const formData = new FormData();
            formData.append('name', name);
            formData.append('comment', reviewText);
            formData.append('rating', selectedRating);
            formData.append('kos_id', {{ $kos->id }});
            
            // Tambahkan gambar ke FormData
            Array.from(images).forEach((image, index) => {
                formData.append('images[]', image);
            });

            fetch('/reviews', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(async response => {
                let text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    alert('Terjadi kesalahan pada server.');
                    return;
                }
                
                if (!response.ok) {
                    if (data.errors) {
                        let msg = Object.values(data.errors).map(arr => arr.join(', ')).join('\n');
                        alert(msg);                    } else {
                        alert('Terjadi kesalahan pada server.');
                    }
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    return;
                }
                
                // Reload reviews from first page after successful submission
                currentPage = 1;
                loadReviews(1, false);
                
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                closeModal();
            })
            .catch(error => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                alert("Terjadi kesalahan");
                console.error(error);
            });
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>    <script>
        // Review pagination dengan load more - tampilkan 7 pertama, load 7 lagi setiap klik
        let currentPage = 1;
        const reviewsPerPage = 7;
        let hasMoreReviews = true;
        let isLoadingReviews = false;

        function renderReviews(reviews, append = false) {
            const reviewsContainer = document.getElementById('reviews-container');
            if (!append) {
                reviewsContainer.innerHTML = '';
            }
            
            if (reviews.length === 0 && !append) {
                reviewsContainer.innerHTML = '<div class="review-card"><p class="review-text">Belum ada ulasan.</p></div>';
                return;
            }
              reviews.forEach(review => {
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    starsHtml += `<i class="${i <= review.rating ? 'fas' : 'far'} fa-star"></i>`;
                }
                const dateText = timeAgo(new Date(review.created_at));
                
                // Build reply HTML if owner replied
                let replyHtml = '';
                if (review.reply && review.reply.trim() !== '') {
                    replyHtml = `
                        <div class="review-reply" style="margin-top: 12px; padding: 12px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div style="font-weight: 600; color: #111827; margin-bottom: 6px;">Balasan Owner</div>
                            <div style="color: #374151;">${review.reply}</div>
                        </div>
                    `;
                }

                // Build images HTML if there are any
                let imagesHtml = '';
                if (review.images && review.images.length > 0) {
                    imagesHtml = '<div class="review-images" style="margin-top: 12px; display: flex; gap: 8px; flex-wrap: wrap;">';
                    review.images.forEach((imagePath, index) => {
                        imagesHtml += `
                            <div class="review-image-wrapper" style="position: relative; cursor: pointer;">
                                <img src="/storage/${imagePath}" 
                                     alt="Review image ${index + 1}" 
                                     class="review-image" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e0e0e0;"
                                     onclick="openReviewImageModal('${imagePath}', ${JSON.stringify(review.images).replace(/"/g, '&quot;')}, ${index})">
                            </div>
                        `;
                    });
                    imagesHtml += '</div>';
                }
                
                reviewsContainer.innerHTML += `
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(review.name)}&background=222222&color=ffffff&size=48" alt="${review.name}" class="reviewer-avatar">
                            <div class="reviewer-info">
                                <h4>${review.name}</h4>
                                <div class="review-stars">${starsHtml}</div>
                            </div>
                            <div class="review-date">${dateText}</div>
                        </div>
                        <p class="review-text">${review.comment}</p>
                        ${replyHtml}
                        ${imagesHtml}
                    </div>
                `;
            });
        }

        function loadReviews(page = 1, append = false) {
            if (isLoadingReviews) return;
            isLoadingReviews = true;
            
            const loadMoreBtn = document.getElementById('loadMoreReviewsBtn');
            if (append) {
                loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                loadMoreBtn.disabled = true;
            }
            
            fetch(`/reviews/{{ $kos->id }}?per_page=${reviewsPerPage}&page=${page}`)
                .then(response => response.json())                .then(data => {
                    const reviews = data.data || [];
                    renderReviews(reviews, append);
                    
                    // Check if there are more reviews - simplified logic
                    hasMoreReviews = reviews.length === reviewsPerPage;
                    
                    // Show/hide load more button
                    const loadMoreContainer = document.getElementById('load-more-reviews-container');
                    const loadMoreBtn = document.getElementById('loadMoreReviewsBtn');
                    
                    if (hasMoreReviews && reviews.length > 0) {
                        loadMoreContainer.style.display = 'block';
                        loadMoreBtn.style.display = 'inline-block';
                        loadMoreBtn.innerHTML = 'Lihat Lebih Banyak';
                        loadMoreBtn.disabled = false;
                    } else {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading reviews:', error);
                    if (append) {
                        loadMoreBtn.innerHTML = 'Lihat Lebih Banyak';
                        loadMoreBtn.disabled = false;
                    }
                })
                .finally(() => {
                    isLoadingReviews = false;
                });
        }

        // Load more button click handler
        function loadMoreReviews() {
            if (hasMoreReviews && !isLoadingReviews) {
                currentPage++;
                loadReviews(currentPage, true);
            }
        }

        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            loadReviews(1, false);            
            // Attach click handler to load more button
            document.getElementById('loadMoreReviewsBtn').addEventListener('click', loadMoreReviews);
              // Handle image preview
            document.getElementById('reviewImages').addEventListener('change', function(e) {
                const files = e.target.files;
                const previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = '';
                
                if (files.length > 5) {
                    alert('Maksimal 5 foto yang dapat diunggah');
                    e.target.value = '';
                    return;
                }
                
                Array.from(files).forEach((file, index) => {
                    if (file.size > 2 * 1024 * 1024) {
                        alert(`File ${file.name} terlalu besar. Maksimal 2MB per foto.`);
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'preview-item';
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" class="preview-image" alt="Preview ${index + 1}">
                            <button type="button" class="remove-image-btn" onclick="removeImage(${index})" title="Hapus foto">×</button>
                        `;
                        previewContainer.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
          function removeImage(index) {
            const fileInput = document.getElementById('reviewImages');
            const dt = new DataTransfer();
            const files = fileInput.files;
            
            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }
            
            fileInput.files = dt.files;
            fileInput.dispatchEvent(new Event('change'));
        }

        // Review Image Modal Functions
        let currentReviewImages = [];
        let currentReviewImageIndex = 0;

        function openReviewImageModal(imagePath, allImages, startIndex) {
            currentReviewImages = allImages;
            currentReviewImageIndex = startIndex;
            
            const modal = document.getElementById('reviewImageModal');
            const img = document.getElementById('reviewImageLarge');
            
            img.src = `/storage/${imagePath}`;
            modal.style.display = 'flex';
            
            // Update navigation button visibility
            updateReviewNavButtons();
        }

        function closeReviewImageModal() {
            const modal = document.getElementById('reviewImageModal');
            modal.style.display = 'none';
        }

        function prevReviewImage() {
            if (currentReviewImageIndex > 0) {
                currentReviewImageIndex--;
                updateReviewImage();
            }
        }

        function nextReviewImage() {
            if (currentReviewImageIndex < currentReviewImages.length - 1) {
                currentReviewImageIndex++;
                updateReviewImage();
            }
        }

        function updateReviewImage() {
            const img = document.getElementById('reviewImageLarge');
            img.src = `/storage/${currentReviewImages[currentReviewImageIndex]}`;
            updateReviewNavButtons();
        }

        function updateReviewNavButtons() {
            const prevBtn = document.querySelector('.review-nav.prev');
            const nextBtn = document.querySelector('.review-nav.next');
            
            prevBtn.style.display = currentReviewImageIndex > 0 ? 'block' : 'none';
            nextBtn.style.display = currentReviewImageIndex < currentReviewImages.length - 1 ? 'block' : 'none';
        }

        // Close modal when clicking outside
        document.getElementById('reviewImageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewImageModal();
            }
        });

        // Keyboard navigation for review images
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('reviewImageModal');
            if (modal.style.display === 'flex') {
                if (e.key === 'Escape') {
                    closeReviewImageModal();
                } else if (e.key === 'ArrowLeft') {
                    prevReviewImage();
                } else if (e.key === 'ArrowRight') {
                    nextReviewImage();
                }
            }
        });    </script>
      <!-- FILTER LOGIC REVIEW -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    function applyReviewFilters() {
        var activeRatingBtn = document.querySelector('.rating-filter-btn.active');
        var rating = activeRatingBtn ? activeRatingBtn.getAttribute('data-rating') : 'all';
        var imageActive = document.getElementById('filter-image').getAttribute('data-active') === '1';
        var cards = document.querySelectorAll('.review-card');
        var visibleCount = 0;
        
        cards.forEach(function(card) {
            var show = true;
            if (rating !== 'all') {
                var stars = card.querySelectorAll('.review-stars .fa-star.fas').length;
                if (parseInt(rating) !== stars) show = false;
            }
            if (imageActive) {
                var img = card.querySelector('.review-images');
                if (!img || img.children.length === 0) show = false;
            }
            card.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });
        
        // Tampilkan/sembunyikan pesan jika tidak ada hasil
        var noResultsMsg = document.getElementById('no-filter-results');
        var hasActiveFilter = rating !== 'all' || imageActive;
        
        if (hasActiveFilter && visibleCount === 0) {
            if (!noResultsMsg) {
                // Buat pesan baru jika belum ada
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'no-filter-results';
                noResultsMsg.style.cssText = 'text-align: center; padding: 48px 24px; color: #64748b; background: #f8fafc; border-radius: 12px; margin: 24px 0; border: 1px solid #e2e8f0;';
                noResultsMsg.innerHTML = '<div style="max-width: 400px; margin: 0 auto;"><h3 style="font-size: 18px; font-weight: 600; color: #334155; margin-bottom: 8px; line-height: 1.4;">No reviews match your criteria</h3><p style="font-size: 14px; color: #64748b; margin-bottom: 16px; line-height: 1.5;">Try adjusting your filters or clear all filters to see all reviews.</p><button onclick="resetAllFilters();" style="background: #000; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-size: 14px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background=\'#333\'" onmouseout="this.style.background=\'#000\'">Clear Filters</button></div>';
                document.getElementById('reviews-container').appendChild(noResultsMsg);
            }
            noResultsMsg.style.display = 'block';
        } else {
            if (noResultsMsg) {
                noResultsMsg.style.display = 'none';
            }
        }
    }
    
    // Reset all filters function
    function resetAllFilters() {
        // Reset rating buttons
        document.querySelectorAll('.rating-filter-btn').forEach(function(btn) {
            btn.classList.remove('active');
            btn.style.background = 'white';
            btn.style.color = '#374151';
        });
        var allBtn = document.querySelector('.rating-filter-btn[data-rating="all"]');
        if (allBtn) {
            allBtn.classList.add('active');
            allBtn.style.background = '#111827';
            allBtn.style.color = 'white';
        }
        
        // Reset image filter button
        var imgBtn = document.getElementById('filter-image');
        if (imgBtn) {
            imgBtn.setAttribute('data-active', '0');
            imgBtn.style.background = 'white';
            imgBtn.style.color = '#374151';
        }
        
        // Apply filters to show all reviews
        applyReviewFilters();
    }
    
    // Make resetAllFilters global for the inline onclick
    window.resetAllFilters = resetAllFilters;
    
    // Setup event listeners
    var ratingBtns = document.querySelectorAll('.rating-filter-btn');
    var imgBtn = document.getElementById('filter-image');
    
    console.log('Found rating buttons:', ratingBtns.length); // Debug log
    console.log('Found image button:', imgBtn); // Debug log
    
    if (ratingBtns.length > 0) {
        // Rating button click handlers
        ratingBtns.forEach(function(btn, index) {
            console.log('Setting up button', index, btn); // Debug log
            btn.addEventListener('click', function(e) {
                console.log('Button clicked:', btn.getAttribute('data-rating')); // Debug log
                e.preventDefault();
                
                // Remove active from all buttons
                ratingBtns.forEach(function(b) {
                    b.classList.remove('active');
                    b.style.background = 'white';
                    b.style.color = '#374151';
                });
                
                // Add active to clicked button
                btn.classList.add('active');
                btn.style.background = '#111827';
                btn.style.color = 'white';
                
                applyReviewFilters();
            });
            
            // Hover effects for non-active buttons
            btn.addEventListener('mouseenter', function() {
                if (!btn.classList.contains('active')) {
                    btn.style.background = '#f9fafb';
                    btn.style.borderColor = '#9ca3af';
                }
            });
            
            btn.addEventListener('mouseleave', function() {
                if (!btn.classList.contains('active')) {
                    btn.style.background = 'white';
                    btn.style.borderColor = '#d1d5db';
                }
            });
        });
    }
    
    if (imgBtn) {
        // Image filter button click handler
        imgBtn.addEventListener('click', function(e) {
            console.log('Image button clicked'); // Debug log
            e.preventDefault();
            
            var active = imgBtn.getAttribute('data-active') === '1';
            imgBtn.setAttribute('data-active', active ? '0' : '1');
            if (active) {
                // Reset to default state
                imgBtn.style.background = 'white';
                imgBtn.style.color = '#374151';
            } else {
                // Active state
                imgBtn.style.background = '#111827';
                imgBtn.style.color = 'white';
            }
            applyReviewFilters();
        });
        
        // Hover effects for image button
        imgBtn.addEventListener('mouseenter', function() {
            if (imgBtn.getAttribute('data-active') === '0') {
                imgBtn.style.background = '#f9fafb';
                imgBtn.style.borderColor = '#9ca3af';
            }
        });
        
        imgBtn.addEventListener('mouseleave', function() {
            if (imgBtn.getAttribute('data-active') === '0') {
                imgBtn.style.background = 'white';
                imgBtn.style.borderColor = '#d1d5db';
            }
        });
    }
      // Trigger filter on review render (if needed)
    document.addEventListener('reviews:rendered', applyReviewFilters);
    });
</script>
@endunless
</body>
</html>