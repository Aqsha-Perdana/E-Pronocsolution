<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PRONOC - Kolaborasi Lebih Mudah, Persetujuan Lebih Cepat</title>
    <link rel="shortcut icon" type="image/png" href="image/tab1.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper"hb6f5fvgbvr5ggbfcdfghjgfffghj>
                <!-- Mobile menu button -->
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
                    <span class="hamburger"></span>
                    <span class="hamburger"></span>
                    <span class="hamburger"></span>
                </button>
                
                <!-- Logo -->
                <div class="nav-brand">
                    <img src="{{ asset('image/image.png') }}" alt="E-PRONOC Logo" class="logo-img-large">
                </div>
                
                <!-- Desktop Menu -->
                <div class="nav-menu" id="navMenu">
                    <a href="/" class="nav-link">Beranda</a>
                    <a href="pusatinformasi" class="nav-link">Pusat Informasi</a>
                    <a href="proyek" class="nav-link">Proyek</a>
                    <a href="tentang" class="nav-link">Tentang</a>
                </div>
                
                <!-- Login Button -->
                <div class="login-dropdown">
                    <button class="btn-login" id="loginBtn">
                        Login
                        <svg class="dropdown-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="dropdown-menu" id="loginDropdown">
                        <a href="{{ route('login.admin') }}" class="dropdown-item">
                            <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <polyline points="17 11 19 13 23 9" />
                            </svg>
                            Admin
                        </a>
                        <a href="{{ route('researcher.login') }}" class="dropdown-item">
                            <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            Researcher
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div>
        @yield('konten')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <h3 class="footer-title">Powered by :</h3>
                <p class="footer-subtitle">E-PRONOC Kolaborasi Lebih Mudah, Persetujuan Lebih Cepat</p>
                
                <!-- Logo KOI -->
                <div class="footer-logo">
                    <img src="{{ asset('image/logo NOA Indonesia.png') }}" alt="Logo KOI" class="koi-logo">
                </div>

                <div class="footer-address">
                    <p class="address-title">MOS Building Flr 17</p>
                    <p>Jl. Pintu Senayan 1 Jakarta 10270</p>
                    <p>INDONESIA</p>
                </div>

                <p class="footer-social-text">Komite Olimpiade Indonesia on Social Media</p>

                <div class="social-icons">
    <!-- YouTube -->
    <a href="https://www.youtube.com/@IndonesiaNOA/about" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="social-icon" 
       aria-label="YouTube KOI Indonesia">
        <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
        </svg>
    </a>
    
    <!-- Instagram -->
    <a href="https://www.instagram.com/indonesia.noa?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="social-icon" 
       aria-label="Instagram KOI Indonesia">
        <svg viewBox="0 0 24 24" fill="currentColor">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
            <path fill="#DC2626" d="M12 7c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8.2c-1.8 0-3.2-1.4-3.2-3.2s1.4-3.2 3.2-3.2 3.2 1.4 3.2 3.2-1.4 3.2-3.2 3.2z"/>
            <circle fill="#DC2626" cx="17.5" cy="6.5" r="1"/>
        </svg>
    </a>
    
    <!-- Facebook -->
    <a href="https://www.facebook.com/koi.indonesia/" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="social-icon" 
       aria-label="Facebook KOI Indonesia">
        <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
    </a>
</div>