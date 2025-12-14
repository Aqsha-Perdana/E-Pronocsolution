@php
    $page = $page ?? 'review';

    $proposals = \App\Models\Proposal::with(['teamMembers'])
        ->where('status', 'SUBMITTED')
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Hitung statistik
    $totalProposals = $proposals->count();
    $totalBudget = $proposals->sum('total_plan');
    $recentSubmissions = $proposals->where('created_at', '>=', now()->subDays(7))->count();
@endphp

<!-- Info Banner -->
<div class="mb-6 p-5 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-lg shadow-sm">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Pending Review Queue</h3>
            <p class="text-sm text-gray-600 leading-relaxed mb-3">
                Proposal-proposal berikut memerlukan review dan persetujuan Anda. Setiap proposal dengan status <span class="font-semibold text-yellow-700">"SUBMITTED"</span> menunggu keputusan untuk diterima atau ditolak.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="bg-white rounded-lg p-3 shadow-sm border border-yellow-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Pending Review</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $totalProposals }}</p>
                        </div>
                        <div class="relative">
                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            @if($totalProposals > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">!</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Budget</p>
                            <p class="text-lg font-bold text-blue-700">Rp {{ number_format($totalBudget / 1000000, 1) }}M</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-sm border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">This Week</p>
                            <p class="text-2xl font-bold text-green-700">{{ $recentSubmissions }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">New submissions</p>
                        </div>
                        <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold mb-4">Need to be Reviewed</h2>
<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NO</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">PROPOSAL INFORMATION</th>
            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">ACTION</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200">
        @forelse($proposals as $index => $proposal)
        <tr id="row-{{ $proposal->id }}" data-proposal-id="{{ $proposal->id }}">
            <td class="px-6 py-4 text-gray-800 align-top">{{ $index + 1 }}</td>
            <td class="px-6 py-4 text-gray-800">
                <div class="space-y-1">
                    <div>
                        <span class="font-semibold">Code-REG</span> : {{ $proposal->registration_code ?? 'N/A' }}
                    </div>
                    <div>
                        <span class="font-semibold">Title</span> : {{ $proposal->title }}
                    </div>
                    <div>
                        <span class="font-semibold">Team</span> : 
                        @if($proposal->teamMembers && $proposal->teamMembers->count() > 0)
                            @php
                                $memberNames = $proposal->teamMembers
                                    ->map(function($member) {
                                        return $member->name ?? 'N/A';
                                    })
                                    ->filter()
                                    ->join(', ');
                            @endphp
                            {{ $memberNames ?: 'N/A' }}
                        @else
                            N/A
                        @endif
                    </div>
                    <div>
                        <span class="font-semibold">Budget Planning: </span>Rp. {{ number_format($proposal->total_plan, 0, ',', '.') }}
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 text-center align-top action-column">
                <div class="flex flex-col gap-1.5">
                    <button 
                        type="button"
                        onclick="handleDetailClick({{ $proposal->id }})"
                        style="position: relative; z-index: 1;"
                        class="px-3 py-1.5 text-xs bg-gray-200 text-gray-900 rounded font-medium hover:bg-gray-300 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Detail</span>
                    </button>
                    
                    <button 
                        type="button"
                        onclick="handleAcceptClick({{ $proposal->id }})"
                        style="position: relative; z-index: 1;"
                        class="px-3 py-1.5 text-xs bg-green-600 text-white rounded font-medium hover:bg-green-700 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Accept</span>
                    </button>
                    
                    <button 
                        type="button"
                        onclick="handleRejectClick({{ $proposal->id }})"
                        style="position: relative; z-index: 1;"
                        class="px-3 py-1.5 text-xs bg-red-600 text-white rounded font-medium hover:bg-red-700 transition flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Reject</span>
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                Tidak ada proposal yang perlu direview
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal Accept -->
<div id="acceptModal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold mb-4">Ketentuan Persetujuan</h3>

        <p class="text-sm text-gray-700 mb-4">
            Dengan menyetujui proposal ini, Anda menyatakan telah membaca, memeriksa, dan memastikan bahwa:
        </p>

        <ul class="list-disc ml-5 text-sm text-gray-700 mb-4">
            <li>Proposal sesuai dengan regulasi dan pedoman yang berlaku</li>
            <li>Anggaran telah diperiksa dengan benar</li>
            <li>Tidak ada konflik kepentingan</li>
        </ul>

        <div class="mb-4">
            <label class="flex items-start gap-2 cursor-pointer">
                <input type="checkbox" id="confirmCheck" class="mt-1" onchange="toggleAcceptButton()">
                <span class="text-sm">Saya setuju dengan semua ketentuan</span>
            </label>
        </div>

        <div class="flex justify-end gap-2">
            <button 
                type="button"
                onclick="closeAcceptModal()" 
                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded transition">
                Batal
            </button>
            <button 
                type="button"
                id="submitAccept" 
                onclick="submitApproval()" 
                disabled
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                Setujui
            </button>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold mb-4">Tolak Proposal</h3>

        <p class="text-sm text-gray-700 mb-4">
            Silakan berikan alasan penolakan proposal ini:
        </p>

        <div class="mb-4">
            <textarea 
                id="rejectReason" 
                rows="4" 
                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                placeholder="Masukkan alasan penolakan..."></textarea>
            <p id="rejectError" style="display: none;" class="text-xs text-red-500 mt-1">Alasan penolakan wajib diisi</p>
        </div>

        <div class="flex justify-end gap-2">
            <button 
                type="button"
                onclick="closeRejectModal()" 
                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded transition">
                Batal
            </button>
            <button 
                type="button"
                id="submitReject" 
                onclick="submitRejection()" 
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                Tolak
            </button>
        </div>
    </div>
</div>

<script>
    // Global variables
    let currentRowId = null;
    let currentRowElement = null;

    // ======================
    // BUTTON CLICK HANDLERS
    // ======================
    
    function handleDetailClick(id) {
        console.log('Detail clicked:', id);
        window.location.href = '/proposalsel/review/' + id;
    }

    function handleAcceptClick(id) {
        console.log('Accept clicked:', id);
        openAcceptModal(id);
    }

    function handleRejectClick(id) {
        console.log('Reject clicked:', id);
        openRejectModal(id);
    }

    // ======================
    // ACCEPT MODAL FUNCTIONS
    // ======================
    
    function openAcceptModal(id) {
        console.log('Opening accept modal for ID:', id);
        
        currentRowId = id;
        currentRowElement = document.getElementById('row-' + id);

        const modal = document.getElementById('acceptModal');
        const confirmCheck = document.getElementById('confirmCheck');
        const submitButton = document.getElementById('submitAccept');

        // Reset
        confirmCheck.checked = false;
        submitButton.disabled = true;

        // Show modal
        modal.style.display = 'flex';
        
        console.log('Modal displayed');
    }

    function closeAcceptModal() {
        const modal = document.getElementById('acceptModal');
        modal.style.display = 'none';
        
        document.getElementById('confirmCheck').checked = false;
        document.getElementById('submitAccept').disabled = true;
    }

    function toggleAcceptButton() {
        const confirmCheck = document.getElementById('confirmCheck');
        const submitButton = document.getElementById('submitAccept');
        submitButton.disabled = !confirmCheck.checked;
    }

    async function submitApproval() {
        const submitBtn = document.getElementById('submitAccept');
        const originalText = submitBtn.innerHTML;
        
        // Set loading
        submitBtn.innerHTML = '⏳ Memproses...';
        submitBtn.disabled = true;

        const url = '/proposalsel/review/' + currentRowId + '/accept';
        console.log('Sending request to:', url);

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            });

            const data = await response.json();
            console.log('Response:', data);

            if (response.ok && data.success) {
                closeAcceptModal();
                removeRowWithAnimation(currentRowElement, 'accept');
                showNotification('Proposal berhasil disetujui', 'success');
                checkIfTableEmpty();
            } else {
                throw new Error(data.message || 'Gagal menyetujui proposal');
            }

        } catch (error) {
            console.error('Error:', error);
            showNotification(error.message || 'Terjadi kesalahan', 'error');
            
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    // ======================
    // REJECT MODAL FUNCTIONS
    // ======================
    
    function openRejectModal(id) {
        console.log('Opening reject modal for ID:', id);
        
        currentRowId = id;
        currentRowElement = document.getElementById('row-' + id);

        const modal = document.getElementById('rejectModal');
        const rejectReason = document.getElementById('rejectReason');
        const rejectError = document.getElementById('rejectError');

        // Reset
        rejectReason.value = '';
        rejectError.style.display = 'none';

        // Show modal
        modal.style.display = 'flex';
        
        console.log('Reject modal displayed');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.style.display = 'none';
        
        document.getElementById('rejectReason').value = '';
        document.getElementById('rejectError').style.display = 'none';
    }

    async function submitRejection() {
        const submitBtn = document.getElementById('submitReject');
        const originalText = submitBtn.innerHTML;
        const rejectReason = document.getElementById('rejectReason');
        const rejectError = document.getElementById('rejectError');
        
        // Validasi
        if (!rejectReason.value.trim()) {
            rejectError.style.display = 'block';
            rejectReason.focus();
            return;
        }

        rejectError.style.display = 'none';
        
        // Set loading
        submitBtn.innerHTML = '⏳ Memproses...';
        submitBtn.disabled = true;

        const url = '/proposalsel/review/' + currentRowId + '/reject';
        console.log('Sending rejection to:', url);

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    reason: rejectReason.value.trim()
                })
            });

            const data = await response.json();
            console.log('Response:', data);

            if (response.ok && data.success) {
                closeRejectModal();
                removeRowWithAnimation(currentRowElement, 'reject');
                showNotification('Proposal berhasil ditolak', 'success');
                checkIfTableEmpty();
            } else {
                throw new Error(data.message || 'Gagal menolak proposal');
            }

        } catch (error) {
            console.error('Error:', error);
            showNotification(error.message || 'Terjadi kesalahan', 'error');
            
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    // ======================
    // UTILITY FUNCTIONS
    // ======================
    
    function removeRowWithAnimation(row, type) {
        if (!row) {
            console.warn('Row not found');
            return;
        }
        
        row.style.transition = 'all 0.5s ease';
        row.style.backgroundColor = type === 'accept' ? '#d1fae5' : '#fee2e2';
        
        setTimeout(function() {
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            
            setTimeout(function() {
                row.remove();
                updateRowNumbers();
            }, 500);
        }, 500);
    }

    function updateRowNumbers() {
        const tbody = document.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr[id^="row-"]');
        
        rows.forEach(function(row, index) {
            const numberCell = row.querySelector('td:first-child');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
        });
    }

    function checkIfTableEmpty() {
        setTimeout(function() {
            const tbody = document.querySelector('tbody');
            const rows = tbody.querySelectorAll('tr[id^="row-"]');
            
            if (rows.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada proposal yang perlu direview</td></tr>';
            }
        }, 1000);
    }

    function showNotification(message, type) {
        const bgColor = type === 'success' ? '#10b981' : '#ef4444';
        const icon = type === 'success' ? 
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        
        const notification = document.createElement('div');
        notification.style.cssText = 'position: fixed; top: 1rem; right: 1rem; background-color: ' + bgColor + '; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 99999; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease-out;';
        notification.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' + icon + '</svg><span>' + message + '</span>';
        
        document.body.appendChild(notification);
        
        setTimeout(function() {
            notification.style.transition = 'opacity 0.3s ease';
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Close modal on background click
    document.addEventListener('click', function(e) {
        const acceptModal = document.getElementById('acceptModal');
        const rejectModal = document.getElementById('rejectModal');
        
        if (e.target === acceptModal) {
            closeAcceptModal();
        }
        if (e.target === rejectModal) {
            closeRejectModal();
        }
    });

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAcceptModal();
            closeRejectModal();
        }
    });

    console.log('Script loaded successfully');
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>