@extends('components.app')

@section('konten')
<section class="hero-section">
    <div class="container">
        <div class="hero-card">
            <!-- Hero Content -->
            <div class="hero-content">
                <!-- Left Content -->
                <div class="hero-text">
                    <p class="welcome-text">Halo, Selamat Datang di <span class="highlight">E-PRONOC</span></p>
                    
                    <h1 class="hero-title">
                        Kolaborasi Lebih Mudah,<br>
                        Persetujuan Lebih Cepat
                    </h1>
                    
                    <p class="hero-description">
                        <span class="highlight">E-Pronoc</span> (Proposal NOC Elektronik) adalah sistem digital yang
                        dirancang untuk mempermudah proses pengajuan, pengelolaan, dan
                        persetujuan proposal NOC secara terintegrasi. Aplikasi ini
                        menghadirkan solusi dalam tiga mitra utama yang membaca sistem
                        pengajuan — dari tahapan proposal — mulai dari pengajuan, verifikasi,
                        hingga pelaporan — secara cepat, transparan, dan terdokumentasi
                        dengan baik.
                    </p>
                </div>

                <!-- Right Content - Logo -->
                <div class="hero-logo">
                    <img src="{{ asset('image/logo NOA Indonesia.png') }}" alt="Logo Indonesia NOC" class="indonesia-logo">
                </div>
            </div>

            <!-- Information Center Section -->
            <div class="info-center-section">
                <!-- Tabs Navigation -->
                <div class="info-tabs">
                    <button class="tab-btn active" data-tab="manual">
                        📘 Instruction Manual
                    </button>
                    <button class="tab-btn" data-tab="video">
                        🎥 Video
                    </button>
                </div>

                <!-- Tab Content: Instruction Manual -->
                <div class="tab-content active" id="manual">
                    <h2 class="content-title">All about applying Research Proposal in E-PRONOC</h2>
                    <p class="content-subtitle">
                        Silakan unduh panduan resmi pada tombol di bawah ini:
                    </p>
                    
                    <a href="{{ asset('manual/Instruction_Manual_ePRONOC.pdf') }}" 
                       class="download-link" 
                       download>
                        📥 Download Instruction Manual E-PRONOC (PDF)
                    </a>
                </div>

                <!-- Tab Content: Video -->
                <div class="tab-content" id="video">
                    <h2 class="content-title">Video Tutorial E-PRONOC</h2>
                    <p class="content-subtitle">
                        Tonton video tutorial untuk memahami cara menggunakan E-PRONOC dengan lebih mudah.
                    </p>
                    
<div class="video-container">
    <iframe width="100%" height="400"
        src="https://www.youtube.com/embed/nnqc6_kOYkA?si"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>
    </iframe>
</div>

    </video>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Tab Switching Logic
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
});
</script>

@endsection