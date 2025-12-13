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
                            <span class="highlight">E-Pronoc</span> (Proposal NOC Elektronik) adalah sistem digital yang
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
@endsection