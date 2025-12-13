<!DOCTYPE html>
<html>
<head>
    <title>Proposal - {{ $proposal->registration_code }}</title>
    <style>
        @page { margin: 2.5cm 2.5cm; }
        body { font-family: sans-serif; font-size: 11pt; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .title { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f4f4f4; font-weight: bold; }

        .section-header { 
            background-color: #eee; padding: 8px; font-weight: bold; 
            margin-top: 20px; margin-bottom: 10px; border-left: 5px solid #d32f2f; 
            font-size: 12pt;
        }

        .content-body { width: 100%; text-align: justify; margin-bottom: 20px; }
        .content-body p, .content-body div { word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; }
        .content-body img { max-width: 100%; height: auto; }
        .page-break { page-break-after: always; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="title">PROPOSAL PENELITIAN</div>
        <div>{{ $proposal->registration_code }}</div>
    </div>

    {{-- INFO DASAR --}}
    <table style="border: none;">
        <tr style="border: none;">
            <td style="border: none; width: 140px; font-weight: bold;">Judul Proposal</td>
            <td style="border: none;">: {{ $proposal->title }}</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; font-weight: bold;">Fokus Area</td>
            <td style="border: none;">: {{ $proposal->focus_area }}</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; font-weight: bold;">Tanggal</td>
            <td style="border: none;">: {{ \Carbon\Carbon::parse($proposal->date)->format('d F Y') }}</td>
        </tr>
    </table>

    {{-- A. TIM PENELITI --}}
    <div class="section-header">A. TIM PENELITI</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 30%;">Nama</th>
                <th style="width: 20%;">NIP</th>
                <th style="width: 25%;">Institusi</th>
                <th style="width: 20%;">Peran</th>
            </tr>
        </thead>
        <tbody>
            {{-- Gunakan teamMembers sesuai relasi baru --}}
            @forelse($proposal->teamMembers as $index => $user)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                {{-- Ambil NIP dari relasi member milik user --}}
                <td>{{ $user->member->nip ?? '-' }}</td>
                {{-- Ambil University dari relasi member milik user --}}
                <td>{{ $user->member->university ?? '-' }}</td>
                <td>{{ $user->pivot->role }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data tim peneliti.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- B. RENCANA ANGGARAN --}}
    {{-- PERBAIKAN: Nama kolom disesuaikan dengan database (_proposal) --}}
    <div class="section-header">B. RENCANA ANGGARAN</div>
    <table>
        <tr>
            <td>Biaya Personil</td>
            <td class="text-right">
                Rp {{ number_format($proposal->budget->direct_personnel_cost_proposal ?? 0, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td>Biaya Non-Personil</td>
            <td class="text-right">
                Rp {{ number_format($proposal->budget->non_personnel_cost_proposal ?? 0, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td>Biaya Tidak Langsung</td>
            <td class="text-right">
                Rp {{ number_format($proposal->budget->indirect_cost_proposal ?? 0, 0, ',', '.') }}
            </td>
        </tr>
        <tr style="background-color: #f9f9f9;">
            <td class="font-bold">TOTAL</td>
            <td class="font-bold text-right">
                Rp {{ number_format(
                    ($proposal->budget->direct_personnel_cost_proposal ?? 0) + 
                    ($proposal->budget->non_personnel_cost_proposal ?? 0) + 
                    ($proposal->budget->indirect_cost_proposal ?? 0), 
                0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    {{-- ISI CONTENT --}}
    <div class="section-header">C. ABSTRAK</div>
    <div class="content-body">{!! $proposal->abstract ?? '-' !!}</div>

    <div class="section-header">D. PENDAHULUAN</div>
    <div class="content-body">{!! $proposal->introduction ?? '-' !!}</div>

    <div class="section-header">E. METODE PELAKSANAAN</div>
    <div class="content-body">{!! $proposal->project_method ?? '-' !!}</div>

    <div class="section-header">F. DAFTAR PUSTAKA</div>
    <div class="content-body">{!! $proposal->bibliography ?? '-' !!}</div>

</body>
</html>