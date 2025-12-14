@extends('components.app')

@section('konten')
<section class="hero-section">
    <div class="container">
        <div class="hero-card">
            <div class="hero-content">
                <!-- Left Content -->
                <div class="hero-text">
                    <p class="welcome-text">Halo, Selamat Datang di <span class="highlight">E-PRONOC</span></p>
                    
                    <h1 class="hero-title">
                        Kolaborasi Lebih Mudah,<br>
                        Persetujuan Lebih Cepat
                    </h1>
                    
                    <p class="hero-description">
                        <span class="highlight">e-Pronoc</span> (Proposal NOC Elektronik) adalah sistem digital yang
                        dirancang untuk mempermudah proses pengajuan, pengelolaan, dan
                        persetujuan proposal NOC secara terintegrasi. Aplikasi ini
                        menghadirkan solusi dalam tiga mitra utama yang membaca sistem
                        pengajuan — dari tahapan proposal — mulai dari pengajuan, verifikasi,
                        hingga pelaporan — secara cepat, transparan, dan terdokumentasi
                        dengan baik.
                    </p>
                </div>

                <!-- Right Content - Logo Indonesia -->
                <div class="hero-logo">
                    <img src="{{ asset('image/logo NOA Indonesia.png') }}" alt="Logo Indonesia NOC" class="indonesia-logo">
                </div>
            </div>

            <!-- Section Visi & Misi -->
            <div class="vision-mission-section">
                <h2 class="section-title">Visi & Misi</h2>

                <div class="vision-mission-grid">
                    <!-- Visi -->
                    <div class="vm-card">
                        <h3 class="vm-title">Visi</h3>
                        <p class="vm-text">
                            Menjadi platform pengelolaan proposal NOC terbaik yang memberikan 
                            kecepatan, transparansi, dan kemudahan bagi seluruh mitra.
                        </p>
                    </div>

                    <!-- Misi -->
                    <div class="vm-card">
                        <h3 class="vm-title">Misi</h3>
                        <ul class="vm-list">
                            <li>Menyediakan sistem pengajuan proposal yang terstandarisasi</li>
                            <li>Mempercepat proses persetujuan melalui digitalisasi</li>
                            <li>Meningkatkan transparansi dan akuntabilitas proses NOC</li>
                            <li>Mempermudah akses informasi terkait status proposal</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section Our Team -->
            <div class="team-section">
                <h2 class="section-title">Tim Kami</h2>

                <div class="team-grid">
                    <!-- Team Member 1 -->
                    <div class="team-card">
                        <div class="team-image-wrapper">
                            <img 
                                src="{{ asset('image/team1.jpeg') }}" 
                                class="team-image"
                                alt="Muhammad Aqsha Perdana">
                        </div>
                        <h3 class="team-name">Muhammad Aqsha Perdana</h3>
                        <p class="team-role">Fullstack Developer</p>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="team-card">
                        <div class="team-image-wrapper">
                            <img 
                                src="{{ asset('image/team2.jpeg') }}" 
                                class="team-image"
                                alt="Muhammad Ridho Febriansyah">
                        </div>
                        <h3 class="team-name">Muhammad Ridho Febriansyah</h3>
                        <p class="team-role">Fullstack Developer</p>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="team-card">
                        <div class="team-image-wrapper">
                            <img 
                                src="{{ asset('image/team3.jpeg') }}" 
                                class="team-image"
                                alt="Diaz Wirda Ramadhani">
                        </div>
                        <h3 class="team-name">Diaz Wirda Ramadhani</h3>
                        <p class="team-role">Fullstack Developer</p>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="team-card">
                        <div class="team-image-wrapper">
                            <img 
                                src="{{ asset('image/team4.jpeg') }}" 
                                class="team-image"
                                alt="Rahendra Narends Hendrata">
                        </div>
                        <h3 class="team-name">Rahendra Narends Hendrata</h3>
                        <p class="team-role">Business Analyst</p>
                    </div>

                    <!-- Team Member 5 -->
                    <div class="team-card">
                        <div class="team-image-wrapper">
                            <img 
                                src="{{ asset('image/team5.jpeg') }}" 
                                class="team-image"
                                alt="Hafiz Alfurqan">
                        </div>
                        <h3 class="team-name">Hafiz Alfurqan</h3>
                        <p class="team-role">UI/UX Design</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

 <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                mobileMenuBtn.classList.toggle('active');
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (navMenu && mobileMenuBtn) {
                const isClickInside = navMenu.contains(event.target) || mobileMenuBtn.contains(event.target);
                
                if (!isClickInside && navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                }
            }
        });

        // Close menu when clicking on a link
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (navMenu && mobileMenuBtn) {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                }
            });
        });

        // Login Dropdown Toggle
        const loginBtn = document.getElementById('loginBtn');
        const loginDropdown = document.getElementById('loginDropdown');

        if (loginBtn && loginDropdown) {
            loginBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                loginDropdown.classList.toggle('active');
                loginBtn.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideDropdown = loginDropdown.contains(event.target) || loginBtn.contains(event.target);
                
                if (!isClickInsideDropdown && loginDropdown.classList.contains('active')) {
                    loginDropdown.classList.remove('active');
                    loginBtn.classList.remove('active');
                }
            });

            // Handle dropdown item clicks - Biarkan redirect otomatis
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Tutup dropdown, biarkan href bekerja
                    loginDropdown.classList.remove('active');
                    loginBtn.classList.remove('active');
                });
            });
        }
    </script>
@endsection