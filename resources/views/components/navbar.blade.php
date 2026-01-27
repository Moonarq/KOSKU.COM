<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<nav class="nav-modern">
    <div class="nav-container">        <!-- Logo -->
        <a href="{{ url('/') }}" class="nav-logo">
            <span class="logo-text">KosKu</span>
        </a>

        <!-- Search Container -->
        <div class="nav-search-container">
            <form action="{{ route('landing.search') }}" method="GET" class="nav-search-form">
                <div class="nav-search-input-container">                    <input 
                        type="text" 
                        name="query"
                        class="nav-search-input" 
                        placeholder="Cari lokasi..."
                        value="{{ request('query') ?? '' }}"
                        autocomplete="off"
                        id="nav-search-input"
                    >
                    <div class="nav-city-suggestions">
                        @isset($locations)
                            @foreach($locations as $city)
                                <div class="nav-city-header" data-city-header="{{ $city['name'] }}">
                                    <div class="nav-city-suggestion" data-city="{{ $city['name'] }}" data-type="city">
                                        <i class="fas fa-city"></i> {{ $city['name'] }}
                                    </div>
                                    @foreach($city['areas'] as $area)
                                        <div class="nav-city-suggestion nav-area-suggestion" 
                                             data-city="{{ $area['name'] }}" 
                                             data-type="area"
                                             data-parent="{{ $city['name'] }}">
                                            <i class="fas fa-map-marker-alt"></i> {{ $area['name'] }}
                                            <span class="nav-area-city">{{ $city['name'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <button type="submit" class="nav-search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Menu -->
        <ul class="nav-menu">
            <li><a href="{{ route('index') }}" class="nav-link">Explore</a></li>
            <li><a href="{{ route('help.center') }}" class="nav-link">Pusat Bantuan</a></li>
            <li><a href="{{ route('terms') }}" class="nav-link">Syarat & Ketentuan</a></li>
        </ul>

        <!-- Right Side (auth / non-auth) -->
        <div class="nav-end">
            @auth
                <div class="nav-profile">                    <div class="profile-wrapper">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                                 alt="Profile" 
                                 class="profile-image">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}" 
                                 alt="Default Profile" 
                                 class="profile-image">
                        @endif
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down" id="profile-dropdown-icon"></i>
                    </div>

                    <div class="profile-dropdown" id="profile-dropdown">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a href="{{ route('saved.index') }}" class="dropdown-item">
                            <i class="fas fa-bookmark"></i> Saved
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="nav-auth">
                    <a href="{{ route('login.show') }}" class="login-btn">Sign In</a>
                    <a href="{{ route('register.show') }}" class="register-btn">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
.nav-modern {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: #fff;
    padding: 1rem 0;
    box-shadow: 0 1px 0 rgba(0,0,0,0.08);
}

.nav-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-logo {
    text-decoration: none;
    flex-shrink: 0;
}

.logo-text {
    font-size: 1.5rem;
    font-weight: 700;
    color: #222;
    letter-spacing: -0.5px;
}

/* --- Search Container - Right after logo --- */
.nav-search-container {
    flex: 0 0 350px;
    margin-left: 1.5rem;
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin: 0;
    padding: 0;
    list-style: none;
    flex-shrink: 0;
    margin-left: 2rem;
}

.nav-link {
    color: #555;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 0;
    transition: color 0.2s;
}

.nav-link:hover {
    color: #000;
}

/* --- Search Container - Right after logo --- */
.nav-search-container {
    flex: 0 0 350px;
    margin-left: 1.5rem;
}

.nav-search-form {
    position: relative;
    display: flex;
    align-items: center;
}

.nav-search-input-container {
    position: relative;
    flex: 1;
}

.nav-search-input {
    width: 100%;
    padding: 10px 16px;
    padding-right: 45px;
    border: 1px solid #e1e5e9;
    border-radius: 25px;
    font-size: 0.9rem;
    color: #333;
    background: #f8f9fa;
    transition: all 0.2s ease;
}

.nav-search-input:focus {
    outline: none;
    border-color: #e1e5e9;
    background: #fff;
}

/* Placeholder slide animation */
.nav-search-input.placeholder-slide-out {
    animation: slideOut 250ms cubic-bezier(0.4, 0.0, 0.2, 1);
}

.nav-search-input.placeholder-slide-in {
    animation: slideIn 400ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

@keyframes slideOut {
    0% {
        transform: translateY(0px);
        opacity: 1;
    }
    100% {
        transform: translateY(-12px);
        opacity: 0;
    }
}

@keyframes slideIn {
    0% {
        transform: translateY(12px);
        opacity: 0;
    }
    60% {
        transform: translateY(-2px);
        opacity: 0.8;
    }
    100% {
        transform: translateY(0px);
        opacity: 1;
    }
}

.nav-search-btn {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    background: #222;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.nav-search-btn:hover {
    background: #000;
}

.nav-city-suggestions {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    border: 1px solid #e1e5e9;
}

.nav-city-header {
    border-bottom: 1px solid #f1f1f1;
}

.nav-city-header:last-child {
    border-bottom: none;
}

.nav-city-suggestion {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    font-size: 0.9rem;
}

.nav-city-suggestion:hover,
.nav-city-suggestion.active {
    background: #f8f9fa;
}

.nav-city-suggestion i {
    color: #666;
    width: 16px;
    text-align: center;
}

.nav-area-suggestion {
    padding-left: 32px;
}

.nav-area-city {
    margin-left: auto;
    font-size: 0.8rem;
    color: #999;
}

/* --- Right Side: Profile / Auth --- */
.nav-end {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-shrink: 0;
    margin-left: auto;
}

.nav-profile {
    position: relative;
}

.profile-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem;
    cursor: pointer;
    border: 1px solid #eee;
    border-radius: 100px;
    transition: all 0.2s;
}

.profile-wrapper:hover {
    background: #f8f8f8;
}

.profile-image {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-name {
    color: #333;
    font-weight: 500;
    font-size: 0.9rem;
}

.profile-wrapper i {
    color: #666;
    font-size: 0.8rem;
}

.profile-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 0.75rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    min-width: 220px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease;
    border: 1px solid #eee;
    padding: 0.5rem;
    z-index: 10;
}

.profile-dropdown::before {
    content: '';
    position: absolute;
    top: -6px;
    right: 24px;
    width: 12px;
    height: 12px;
    background: #fff;
    border-left: 1px solid #eee;
    border-top: 1px solid #eee;
    transform: rotate(45deg);
}

.profile-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    color: #333;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.2s;
    border-radius: 8px;
    margin: 0.125rem 0;
}

.dropdown-item i {
    font-size: 1rem;
    color: #666;
    width: 20px;
    text-align: center;
}

.dropdown-item:hover {
    background: #f8f9fa;
    color: #000;
}

.dropdown-item:hover i {
    color: #222;
}

button.dropdown-item {
    width: 100%;
    border: none;
    background: none;
    cursor: pointer;
    font-family: inherit;
}

.dropdown-divider {
    height: 1px;
    background: #eee;
    margin: 0.5rem;
}

.nav-auth {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.login-btn, .register-btn {
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.6rem 1.25rem;
    border-radius: 100px;
    transition: all 0.2s;
}

.login-btn {
    color: #555;
}

.login-btn:hover {
    color: #000;
}

.register-btn {
    color: #fff;
    background: #222;
}

.register-btn:hover {
    background: #000;
}

@media (max-width: 1024px) {
    .nav-search-container {
        flex: 0 0 280px;
        margin-left: 1rem;
    }
    
    .nav-menu {
        gap: 1.5rem;
    }
}

/* Mobile */
@media (max-width: 768px) {
    .nav-container {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .nav-menu {
        display: none;
    }
    
    .nav-search-container {
        order: 3;
        width: 100%;
        margin: 0.5rem 0 0 0;
        flex: none;
    }
    
    .nav-end {
        margin-left: auto;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navSearchForm = document.querySelector('.nav-search-form');
    const navSearchInput = document.querySelector('.nav-search-input');
    const navCitySuggestions = document.querySelector('.nav-city-suggestions');
    const navCityItems = document.querySelectorAll('.nav-city-suggestion');
    let currentFocus = -1;

    if (!navSearchInput || !navCitySuggestions) return;    // Show suggestions on input focus
    navSearchInput.addEventListener('focus', () => {
        navSearchForm.classList.add('focused');
        // Comment out location suggestions display
        // if (navSearchInput.value.length > 0) {
        //     filterNavLocations(navSearchInput.value);
        // }
        // navCitySuggestions.style.display = 'block';
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', (e) => {
        if (!navSearchForm.contains(e.target)) {
            navCitySuggestions.style.display = 'none';
        }
    });

    // Handle keyboard navigation
    navSearchInput.addEventListener('keydown', (e) => {
        const activeItems = [...navCityItems].filter(item => item.style.display !== 'none');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentFocus++;
            addActiveNav(activeItems);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentFocus--;
            addActiveNav(activeItems);
        } else if (e.key === 'Enter' && currentFocus > -1) {
            e.preventDefault();
            if (activeItems[currentFocus]) {
                activeItems[currentFocus].click();
            }
        }
    });    // Filter locations as user types
    navSearchInput.addEventListener('input', (e) => {
        // Comment out location filtering and suggestions display
        // filterNavLocations(e.target.value);
        // currentFocus = -1;
    });

    // Handle location selection
    navCityItems.forEach(item => {
        item.addEventListener('click', () => {
            navSearchInput.value = item.dataset.city;
            navCitySuggestions.style.display = 'none';
            navSearchForm.submit();
        });
    });

    function addActiveNav(items) {
        removeActiveNav(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;
        if (items[currentFocus]) {
            items[currentFocus].classList.add('active');
            items[currentFocus].scrollIntoView({ block: 'nearest' });
        }
    }

    function removeActiveNav(items) {
        items.forEach(item => item.classList.remove('active'));
    }

    function filterNavLocations(query) {
        const q = query.toLowerCase();
        let hasMatches = false;

        navCityItems.forEach(item => {
            const location = item.dataset.city.toLowerCase();
            const type = item.dataset.type;
            const isMatch = location.includes(q);

            if (isMatch) {
                item.style.display = 'flex';
                if (type === 'area') {
                    const cityHeader = document.querySelector(`[data-city-header="${item.dataset.parent}"]`);
                    if (cityHeader) cityHeader.style.display = 'block';
                }
                hasMatches = true;
            } else {
                item.style.display = 'none';
            }
        });        navCitySuggestions.style.display = hasMatches ? 'block' : 'none';
    }    // Rotating placeholder text with slide down animation (like Tiket.com)
    const placeholderTexts = [
        "Kos dekat kampus",
        "Hunian terjangkau",
        "Kos putra & putri",
        "Fasilitas lengkap",
        "Lokasi strategis",
        "Kos nyaman & aman",
        "Cari kos Jakarta..."
    ];
    
    let currentPlaceholderIndex = 0;
    let slideInterval;
      function slidePlaceholder() {
        if (!navSearchInput || navSearchInput.matches(':focus') || navSearchInput.value !== '') {
            return;
        }
        
        // Add slide-out class
        navSearchInput.classList.add('placeholder-slide-out');
        
        setTimeout(() => {
            // Change text
            navSearchInput.placeholder = placeholderTexts[currentPlaceholderIndex];
            currentPlaceholderIndex = (currentPlaceholderIndex + 1) % placeholderTexts.length;
            
            // Remove slide-out and add slide-in
            navSearchInput.classList.remove('placeholder-slide-out');
            navSearchInput.classList.add('placeholder-slide-in');
            
            setTimeout(() => {
                navSearchInput.classList.remove('placeholder-slide-in');
            }, 400);
        }, 250);
    }
    
    // Start slide animation
    setTimeout(() => {
        slidePlaceholder();
        slideInterval = setInterval(slidePlaceholder, 3500);
    }, 1500);
    
    // Handle focus events
    navSearchInput.addEventListener('focus', () => {
        clearInterval(slideInterval);
        navSearchInput.classList.remove('placeholder-slide-out', 'placeholder-slide-in');
        if (navSearchInput.value === '') {
            navSearchInput.placeholder = "Ketik lokasi...";
        }
    });
      // Resume animation when input loses focus
    navSearchInput.addEventListener('blur', () => {
        if (navSearchInput.value === '') {
            setTimeout(() => {
                if (!navSearchInput.matches(':focus')) {
                    slidePlaceholder();
                    slideInterval = setInterval(slidePlaceholder, 3000);
                }
            }, 500);
        }
    });

    // Profile dropdown click functionality
    const profileDropdownIcon = document.getElementById('profile-dropdown-icon');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    if (profileDropdownIcon && profileDropdown) {
        profileDropdownIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-profile')) {
                profileDropdown.classList.remove('show');
            }
        });
    }
});
</script>