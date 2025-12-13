{{-- FILE: resources/views/components/layouts/sidebar.blade.php --}}
<div id="sidebar" class="gemini-sidebar">
    
    {{-- Tombol Close (Mobile Only) --}}
    <button id="closeSidebar" class="close-btn" aria-label="Close menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- HEADER: LOGO & BRAND --}}
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('image/logo.png') }}" alt="E-PRONOC Logo" class="brand-logo" />
            <div class="brand-text">
                <span class="font-extrabold text-gray-800 tracking-tight">E-</span><span class="font-black text-red-600 tracking-tight">PRONOC</span>
            </div>
            <span class="brand-badge">Beta</span>
        </a>
    </div>

    {{-- TOMBOL UTAMA (New Proposal) --}}
    <div class="action-container">
        <a href="{{ route('proposals.create') }}" class="new-action-btn group">
            <div class="icon-wrapper group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            </div>
            <span class="font-bold">New Proposal</span>
        </a>
    </div>

    {{-- NAVIGASI UTAMA --}}
    <nav class="nav-menu">
        
        <div class="nav-group">
            <div class="nav-label">Main Menu</div>
            
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="nav-text">Dashboard</span>
            </a>

            <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="nav-text">Profil Saya</span>
            </a>
        </div>

        <div class="nav-group mt-6">
            <div class="nav-label">Project Management</div>
            
            {{-- Proposals (Active jika url mengandung 'proposals' atau 'proposalutama') --}}
            <a href="{{ route('mainproposalutama') }}" class="nav-item {{ request()->is('proposal*') || request()->is('proposals*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="nav-text">Proposals</span>
            </a>

            <a href="{{ route('progress.index') }}" class="nav-item {{ request()->is('progress*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="nav-text">Progress Report</span>
            </a>

            <a href="{{ route('report.fund') }}" class="nav-item {{ request()->is('fund-realization*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="nav-text">Budget & Fund</span>
            </a>

            <a href="{{ route('final') }}" class="nav-item {{ request()->is('final*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="nav-text">Final Report</span>
            </a>
        </div>
    </nav>

    {{-- FOOTER MENU (Logout Form) --}}
    <div class="sidebar-footer">
        {{-- Gunakan FORM untuk logout agar aman (POST Method) --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item logout-btn w-full text-left">
                <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="nav-text text-red-600 font-semibold">Sign Out</span>
            </button>
        </form>
        
        <div class="footer-meta">
            <span class="opacity-75">E-PRONOC v1.0</span> &copy; 2025
        </div>
    </div>
</div>

{{-- Overlay untuk Mobile --}}
<div id="overlay" class="sidebar-overlay"></div>

{{-- CSS STYLING (Dioptimalkan) --}}
<style>
    /* 1. Base Layout */
    .gemini-sidebar {
        background-color: #ffffff;
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 280px;
        display: flex;
        flex-direction: column;
        padding: 24px 20px;
        border-right: 1px solid #f1f5f9;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 50; /* Z-Index Tinggi */
        font-family: 'Plus Jakarta Sans', 'Figtree', sans-serif;
        box-shadow: 4px 0 24px rgba(0,0,0,0.02);
    }

    /* 2. Header & Brand */
    .sidebar-header {
        margin-bottom: 32px;
        padding: 0 4px;
    }

    .brand-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .brand-logo {
        height: 42px;
        width: auto;
        object-fit: contain;
    }

    .brand-text {
        font-size: 20px;
        line-height: 1.2;
    }

    .brand-badge {
        font-size: 9px;
        background: #eff6ff;
        color: #3b82f6;
        padding: 2px 6px;
        border-radius: 6px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #dbeafe;
        align-self: flex-start;
        margin-top: -4px;
    }

    /* 3. Action Button */
    .action-container {
        margin-bottom: 32px;
    }

    .new-action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        padding: 14px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }

    .new-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
    }

    /* 4. Navigation */
    .nav-menu {
        flex: 1;
        overflow-y: auto;
        padding-right: 4px; /* Space for scrollbar */
    }

    .nav-label {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 8px;
        padding-left: 12px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 12px;
        border-radius: 10px;
        text-decoration: none;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        margin-bottom: 4px;
        cursor: pointer;
        background: transparent;
        border: none;
        width: 100%;
    }

    .nav-icon {
        width: 20px;
        height: 20px;
        color: #94a3b8;
        transition: color 0.2s;
    }

    /* Hover State */
    .nav-item:hover {
        background-color: #f8fafc;
        color: #1e293b;
    }
    
    .nav-item:hover .nav-icon {
        color: #475569;
    }

    /* Active State - Modern Style */
    .nav-item.active {
        background-color: #fef2f2; /* Light Red bg */
        color: #dc2626;
        font-weight: 600;
    }

    .nav-item.active .nav-icon {
        color: #dc2626;
    }

    /* Logout Button Specifics */
    .logout-btn {
        margin-top: 8px;
        border: 1px solid transparent;
    }
    .logout-btn:hover {
        background-color: #fef2f2;
        border-color: #fecaca;
    }

    /* 5. Footer */
    .sidebar-footer {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .footer-meta {
        font-size: 11px;
        color: #cbd5e1;
        text-align: center;
        margin-top: 16px;
        font-weight: 500;
    }

    /* Close Button (Mobile) */
    .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: transparent;
        border: none;
        color: #64748b;
        cursor: pointer;
        display: none;
        padding: 4px;
        border-radius: 8px;
    }
    .close-btn:hover { background-color: #f1f5f9; }

    /* Overlay */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(2px);
        z-index: 40;
        transition: opacity 0.3s;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .close-btn { display: block; }
    }
</style>

{{-- SCRIPT JAVASCRIPT (Dipertahankan) --}}
// SCRIPT JAVASCRIPT (Dipertahankan)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const hamburger = document.getElementById('hamburger'); // ID TOMBOL di Topbar
        const closeBtn = document.getElementById('closeSidebar');

        // Fungsi Buka/Tutup Sidebar
        function toggleSidebar(forceOpen = null) {
            // Cek apakah sidebar sedang terbuka
            const isOpen = sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === 'translateX(0%)';
            
            // Tentukan aksi: Jika null, lakukan toggle (kebalikan status saat ini)
            const shouldOpen = forceOpen !== null ? forceOpen : !isOpen;

            if (shouldOpen) {
                sidebar.style.transform = 'translateX(0)';
                overlay.style.display = 'block';
                // Kunci scroll body hanya di mobile
                if (window.innerWidth < 1024) document.body.style.overflow = 'hidden';
            } else {
                sidebar.style.transform = 'translateX(-100%)';
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        if (hamburger) {
            hamburger.addEventListener('click', (e) => {
                e.stopPropagation(); 
                toggleSidebar(); // Mode Toggle aktif
            });
        }

        // Tombol Close selalu menutup
        if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(false));
        
        // Klik Overlay selalu menutup
        if (overlay) overlay.addEventListener('click', () => toggleSidebar(false));
        
        // Tombol ESC menutup sidebar
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') toggleSidebar(false);
        });
        
        // LOGIKA INITIALISASI DAN RESIZE BARU: Sidebar selalu tertutup di awal
        const initialStateCheck = () => {
            // Sidebar selalu tertutup di awal load (kecuali jika diresize dari kecil ke besar)
            sidebar.style.transform = 'translateX(-100%)';
            overlay.style.display = 'none';
            document.body.style.overflow = '';

            // Khusus untuk Desktop (layar lebar), kita BISA MEMBUKA sidebar secara default
            // jika memang itu yang diinginkan untuk layout desktop.
            // Namun, karena Anda minta defaultnya tertutup di awal:
            if (window.innerWidth >= 1024) {
                 // Di sini, Anda bisa memutuskan apakah di desktop harusnya terbuka
                 // atau tetap tertutup (sesuai permintaan terakhir Anda).
                 // Saya pertahankan logika toggle, tapi CSS defaultnya tertutup.
                 // PENTING: Jika di desktop Anda ingin selalu terbuka, hapus baris ini dan biarkan CSS yang bekerja.
                 // Jika Anda *memaksa* tertutup di desktop, pastikan elemen konten Anda bergeser ke kiri.
            }
        }

        // Panggil saat DOM siap (Init State)
        initialStateCheck(); 
        
        // Panggil saat resize (Desktop vs Mobile handling)
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                // Di desktop, kita tetap ingin toggle berfungsi, tapi kita harus pastikan
                // overlay tidak muncul dan scroll tidak terkunci saat toggle tertutup.
                
                // Jika ingin Sidebar selalu terlihat di desktop, GANTI ini:
                // sidebar.style.transform = 'translateX(0)';
                
                // Jika ingin tetap tertutup (sesuai permintaan):
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            } else {
                 // Di mobile, pastikan overlay/scroll handling bekerja
                 if (sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === 'translateX(0%)') {
                     document.body.style.overflow = 'hidden';
                 }
            }
        });
    });
</script>