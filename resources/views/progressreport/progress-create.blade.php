<x-layouts.app>
    <x-slot name="title">Update Progress Report</x-slot>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Quill Overrides */
        .ql-toolbar { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-color: #e5e7eb !important; background-color: #f9fafb; }
        .ql-container { border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-color: #e5e7eb !important; background-color: #ffffff; font-family: inherit; font-size: 1rem; }
        .ql-editor { min-height: 150px; }
        
        /* Slider Styling */
        input[type=range] { -webkit-appearance: none; width: 100%; background: transparent; }
        input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; height: 20px; width: 20px; border-radius: 50%; background: #dc2626; cursor: pointer; margin-top: -8px; box-shadow: 0 1px 3px rgba(0,0,0,0.3); }
        input[type=range]::-webkit-slider-runnable-track { width: 100%; height: 6px; cursor: pointer; background: #e5e7eb; border-radius: 4px; }
    </style>

    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Update Progress</h1>
                    <p class="mt-2 text-sm text-gray-600">Perbarui status pengerjaan dan hasil sementara proyek.</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="/progress" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            <form action="{{ route('progress.update', $proposal->id) }}" method="POST" id="progressForm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-blue-50 rounded-xl border border-blue-100 p-5">
                            <h3 class="text-xs font-bold text-blue-800 uppercase tracking-wide mb-3">Project Information</h3>
                            
                            <div class="mb-3">
                                <label class="block text-xs text-blue-600 mb-1">Project Title</label>
                                <p class="text-sm font-bold text-gray-900 leading-snug">{{ $proposal->title }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="block text-xs text-blue-600 mb-1">Focus Area</label>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-white text-blue-800 border border-blue-200">
                                    {{ $proposal->focus_area }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-xs text-blue-600 mb-1">Specific Output/Focus</label>
                                <p class="text-sm text-gray-700">{{ $proposal->output ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="bg-white shadow-lg rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-5 border-b pb-2">Status Update</h2>

                            <div class="mb-5">
                                <div class="flex justify-between items-center mb-1">
                                    <label class="block text-sm font-medium text-gray-700">Completion</label>
                                    <span class="text-sm font-bold text-red-600"><span id="progress-val">{{ $report->percentage_complete ?? 0 }}</span>%</span>
                                </div>
                                <input type="range" name="percentage" id="percentage" min="0" max="100" value="{{ $report->percentage_complete ?? 0 }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            </div>

                            <div class="mb-5">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Current Status</label>
                                <select name="status" id="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2.5 px-3">
                                    <option value="In Progress" {{ ($report->status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Blocked" {{ ($report->status ?? '') == 'Blocked' ? 'selected' : '' }}>Blocked (Ada Kendala)</option>
                                    <option value="Complete" {{ ($report->status ?? '') == 'Complete' ? 'selected' : '' }}>Complete (Selesai)</option>
                                    <option value="On Hold" {{ ($report->status ?? '') == 'On Hold' ? 'selected' : '' }}>On Hold (Ditunda)</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Quick Note</label>
                                <textarea name="notes" id="notes" rows="3" placeholder="Catatan singkat untuk admin..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2 px-3">{{ $report->notes }}</textarea>
                            </div>

                            <div class="pt-2">
                                <button type="button" onclick="confirmSubmission()" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                    Save Progress
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- 1. ACTIVITIES --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('activities') ? 'border-red-500' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Activities Conducted (Kegiatan yang telah dilakukan) <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Jelaskan kegiatan apa saja yang sudah berjalan sejak laporan terakhir.</p>
                            </div>
                            <div id="editor-abstract">{!! old('activities', $report->activities) !!}</div>
                            <textarea name="activities" id="input-abstract" class="hidden">{{ old('activities', $report->activities) }}</textarea>
                            
                            {{-- ERROR MESSAGE DISPLAY --}}
                            @error('activities')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 2. RESULTS --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('results') ? 'border-red-500' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Results Achieved (Hasil Sementara) <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Hasil data, survei, atau luaran yang sudah didapatkan.</p>
                            </div>
                            <div id="editor-results">{!! old('results', $report->results) !!}</div>
                            <textarea name="results" id="input-results" class="hidden">{{ old('results', $report->results) }}</textarea>
                            
                            @error('results')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 3. OBSTACLES --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('obstacles') ? 'border-red-500' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Obstacles & Solutions (Kendala & Solusi) <span class="text-red-500">*</span></label>
                                <p class="text-sm text-gray-500">Hambatan yang ditemui di lapangan dan rencana penyelesaiannya.</p>
                            </div>
                            <div id="editor-introduction">{!! old('obstacles', $report->obstacles) !!}</div>
                            <textarea name="obstacles" id="input-introduction" class="hidden">{{ old('obstacles', $report->obstacles) }}</textarea>
                            
                            @error('obstacles')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 4. NEXT STEPS --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('next_steps') ? 'border-red-500' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Next Plan (Rencana Selanjutnya) <span class="text-red-500">*</span></label>
                            </div>
                            <div id="editor-method">{!! old('next_steps', $report->next_steps) !!}</div>
                            <textarea name="next_steps" id="input-method" class="hidden">{{ old('next_steps', $report->next_steps) }}</textarea>
                            
                            @error('next_steps')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 5. ATTACHMENTS --}}
                        <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6 {{ $errors->has('attachments') ? 'border-red-500' : '' }}">
                            <div class="mb-2">
                                <label class="block text-base font-semibold text-gray-900">Supporting Documents / Links <span class="text-red-500">*</span></label>
                            </div>
                            <div id="editor-bibliography">{!! old('attachments', $report->attachments) !!}</div>
                            <textarea name="attachments" id="input-bibliography" class="hidden">{{ old('attachments', $report->attachments) }}</textarea>
                            
                            @error('attachments')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <script>
        // 1. Slider Logic
        const slider = document.getElementById('percentage');
        const output = document.getElementById('progress-val');
        slider.oninput = function() { 
            output.innerHTML = this.value; 
            
            // Otomatis ubah status ke 'Complete' jika 100%
            const statusSelect = document.getElementById('status');
            if (this.value == 100) {
                statusSelect.value = 'Complete';
            }
        }

        // 2. Quill Editors Init
        var toolbarOptions = [
            ['bold', 'italic', 'underline'],        
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'header': [2, 3, false] }],
            ['clean']                                         
        ];

        function initQuill(editorId, inputId) {
            var quill = new Quill('#' + editorId, {
                theme: 'snow',
                modules: { toolbar: toolbarOptions },
                placeholder: 'Tulis detail laporan di sini...'
            });
            quill.on('text-change', function() {
                document.getElementById(inputId).value = quill.root.innerHTML;
            });
        }

        initQuill('editor-abstract', 'input-abstract');
        initQuill('editor-introduction', 'input-introduction');
        initQuill('editor-method', 'input-method');
        initQuill('editor-results', 'input-results');
        initQuill('editor-bibliography', 'input-bibliography');

        // 3. Logic Pop-up SweetAlert2
        function confirmSubmission() {
            const percentage = document.getElementById('percentage').value;
            const status = document.getElementById('status').value;
            const form = document.getElementById('progressForm');

            // Cek kondisi: Jika 100% ATAU Status Complete
            if (percentage == 100 || status === 'Complete') {
                
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda menandai progres proyek ini 100% Selesai. Pastikan semua data sudah benar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#166534', // Hijau
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan Loading sebelum submit
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Submit Form
                        form.submit();
                    }
                });

            } else {
                // Jika tidak 100%, langsung submit dengan notifikasi standar (opsional bisa pakai pop-up juga)
                Swal.fire({
                    title: 'Menyimpan Progres...',
                    text: 'Data sedang diproses',
                    timer: 1500,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        }

        // 4. Notifikasi Berhasil (Dari Session Laravel)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#c8102e',
                timer: 3000
            });
        @endif
    </script>
</x-layouts.app>