<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('proposal') }}
        </h2>
    </x-slot>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


 <div class="py-24" >
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8  min-h-[700px]">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
                <div class="grid grid-cols-12 gap-6">

                    <!-- Sidebar Kiri -->
<div class="col-span-3 bg-gradient-to-br from-red-600 to-red-700 dark:bg-gray-700 p-6 rounded-xl shadow-xl">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <h1 class="text-xl font-bold text-gray-800 mb-6 pb-3 border-b-2 border-red-500">Proposal Information</h1>

        <!-- Code Reg -->
        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Code Reg</p>
            <p class="font-semibold text-gray-800 break-words">
                {{ strip_tags($proposal->registration_code) }}
            </p>
        </div>

        <!-- Title -->
        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Title</p>
            <p class="font-semibold text-gray-800 break-words">
                {{ strip_tags($proposal->title) }}
            </p>
        </div>

        <!-- Focus -->
        <div class="mb-4 bg-gray-50 p-3 rounded-lg">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Focus</p>
            <p class="font-semibold text-gray-800 break-words">
                {{ strip_tags($proposal->focus) }}
            </p>
        </div>

        <!-- Abstract -->
        <div class="mb-4 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 rounded-lg border-l-4 border-blue-500">
            <p class="text-xs font-medium text-blue-700 uppercase tracking-wide mb-2">Abstract</p>
            <p class="text-sm text-gray-700 break-words whitespace-pre-wrap leading-relaxed">
                {{ strip_tags($proposal->abstract) }}
            </p>
        </div>

        <!-- Project Method -->
        <div class="mb-4 bg-gradient-to-r from-green-50 to-emerald-50 p-3 rounded-lg border-l-4 border-green-500">
            <p class="text-xs font-medium text-green-700 uppercase tracking-wide mb-2">Project Method</p>
            <p class="text-sm text-gray-700 break-words whitespace-pre-wrap leading-relaxed">
                {{ strip_tags($proposal->project_method) }}
            </p>
        </div>

        <!-- Bibliography -->
        <div class="mb-4 bg-gradient-to-r from-purple-50 to-pink-50 p-3 rounded-lg border-l-4 border-purple-500">
            <p class="text-xs font-medium text-purple-700 uppercase tracking-wide mb-2">Bibliography</p>
            <p class="text-sm text-gray-700 break-words whitespace-pre-wrap leading-relaxed">
                {{ strip_tags($proposal->bibliography) }}
            </p>
        </div>

        <!-- Team -->
        <div class="bg-gradient-to-r from-red-50 to-orange-50 p-4 rounded-lg border-l-4 border-red-500">
            <p class="text-xs font-medium text-red-700 uppercase tracking-wide mb-3">Team Members</p>
            <div class="space-y-2">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <div>
                        <span class="text-xs font-semibold text-gray-600 uppercase">Name</span>
                        <p class="text-sm font-medium text-gray-800 break-words">
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
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

                    <!-- Konten Utama -->
<div class="col-span-9 bg-white p-6 rounded-lg shadow min-h-[500px]">
<h2 class="text-3xl font-bold text-gray-800 mb-2">Review Proposal</h2>
   @if(isset($proposal) && $proposal)
<form id="reviewForm" method="POST" action="{{ route('admin.proposals.submit-review', $proposal->id) }}">
@csrf
                    
<div class="space-y-6">
    <!-- Review Sections -->
    <div id="sections-container" class="space-y-4">
                    !-- Section 1 -->
        <div class="section-item bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200 hover:border-blue-400 transition-all duration-300">
    <div class="grid md:grid-cols-12 gap-4 items-start">
        <div class="md:col-span-3">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
            <input type="text" 
                   name="sections[0][name]" 
                   value="Kesesuaian Latar Belakang dengan Permasalahan"
                   readonly
                   class="w-full px-4 py-2.5 border-2 border-gray-200 bg-gray-100 rounded-lg text-gray-700 cursor-not-allowed">
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
            <input type="number" 
                   name="sections[0][score]" 
                   min="0" 
                   max="10" 
                   placeholder="0-10"
                   class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                   oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
        </div>
        
        <div class="md:col-span-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
            <textarea name="sections[0][notes]" 
                      rows="2" 
                      placeholder="Optional notes..."
                      class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"></textarea>
        </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="section-item bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200 hover:border-purple-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[1][name]" 
                                               value="Kejelasan Tujuan Program"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[1][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[1][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="section-item bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200 hover:border-green-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[2][name]" 
                                               value="Relevansi dan Kualitas Solusi yang Diajukan"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[2][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[2][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4 -->
                            <div class="section-item bg-gradient-to-r from-orange-50 to-yellow-50 rounded-xl p-6 border-2 border-orange-200 hover:border-orange-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[3][name]" 
                                               value="Ketepatan Metodologi dan Tahapan Pelaksanaan"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[3][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[3][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 5 -->
                            <div class="section-item bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 border-2 border-pink-200 hover:border-pink-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[4][name]" 
                                               readonly
                                               value="Keterlibatan dan Peran Masyarakat Sasaran"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[4][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[4][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 6 -->
                            <div class="section-item bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 border-2 border-pink-200 hover:border-pink-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[5][name]" 
                                               value="Inovasi Program"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[5][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[5][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                <!-- Section 7 -->
                            <div class="section-item bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 border-2 border-pink-200 hover:border-pink-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[6][name]" 
                                               value="Keberlanjutan (Sustainability) Program"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[6][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[6][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 8 -->
                            <div class="section-item bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 border-2 border-pink-200 hover:border-pink-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[7][name]" 
                                               value="Kelayakan Anggaran"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[7][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[7][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                <!-- Section 9 -->
                            <div class="section-item bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 border-2 border-pink-200 hover:border-pink-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[8][name]" 
                                               value="Kelayakan Output dan Indikator Keberhasilan"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[8][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[8][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 10 -->
                            <div class="section-item bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 border-2 border-pink-200 hover:border-pink-400 transition-all duration-300">
                                <div class="grid md:grid-cols-12 gap-4 items-start">
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                                        <input type="text" 
                                               name="sections[9][name]" 
                                               value="Kualitas Penyusunan Proposal"
                                               readonly
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                                        <input type="number" 
                                               name="sections[9][score]" 
                                               min="0" 
                                               max="10" 
                                               placeholder="0-10"
                                               class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                                               oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()">
                                    </div>
                                    
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                        <textarea name="sections[9][notes]" 
                                                  rows="2" 
                                                  placeholder="Optional notes..."
                                                  class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all resize-none"></textarea>
                                    </div>
                                    
                                    <div class="md:col-span-1 flex items-end justify-center">
                                        <button type="button" 
                                                onclick="removeSection(this)" 
                                                class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Score Display -->
                        <div class="bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl p-6 border-2 border-indigo-300">
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-gray-800">Total Score:</span>
                                <span id="totalScore" class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">0.00</span>
                            </div>
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div id="scoreBar" class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-8">
        <button type="button" 
                onclick="window.history.back()" 
                class="flex-1 py-4 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 flex items-center justify-center gap-2 border-2 border-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Cancel
        </button>
                <button type="submit" 
                class="flex-1 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Submit Review
                </button>
            </div>
                </form>
            </div>
            @else
            <!-- No Proposal Selected -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Proposal Selected</h3>
                <p class="text-gray-600 mb-6">Please select a proposal to review.</p>
                <a href="{{ route('proposalsel.done') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Proposals
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
let sectionCount = 5;
const colors = [
    'from-blue-50 to-indigo-50 border-blue-200 hover:border-blue-400',
    'from-purple-50 to-pink-50 border-purple-200 hover:border-purple-400',
    'from-green-50 to-emerald-50 border-green-200 hover:border-green-400',
    'from-orange-50 to-yellow-50 border-orange-200 hover:border-orange-400',
    'from-pink-50 to-rose-50 border-pink-200 hover:border-pink-400',
    'from-cyan-50 to-blue-50 border-cyan-200 hover:border-cyan-400',
    'from-violet-50 to-purple-50 border-violet-200 hover:border-violet-400'
];

function addSection() {
    const container = document.getElementById('sections-container');
    const colorClass = colors[sectionCount % colors.length];

    const newSection = `
        <div class="section-item bg-gradient-to-r ${colorClass} rounded-xl p-6 border-2 transition-all duration-300">
            <div class="grid md:grid-cols-12 gap-4 items-start">
                
                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Section Name</label>
                    <input type="text" 
                        name="sections[${sectionCount}][name]" 
                        placeholder="Enter section name"
                        class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Score (0-10)</label>
                    <input type="number" 
                        name="sections[${sectionCount}][score]" 
                        min="0" 
                        max="10" 
                        placeholder="0-10"
                        oninput="if(this.value > 10) this.value = 10; if(this.value < 0) this.value = 0; calculateTotal()"
                        class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea name="sections[${sectionCount}][notes]" 
                        rows="2" 
                        placeholder="Optional notes..."
                        class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"></textarea>
                </div>

                <div class="md:col-span-1 flex items-end justify-center">
                    <button type="button" onclick="removeSection(this)" 
                        class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300 hover:scale-110">
                        ❌
                    </button>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML("beforeend", newSection);
    sectionCount++;

    Swal.fire({
        icon: "success",
        title: "New Section Added!",
        timer: 1200,
        showConfirmButton: false
    });
}

function removeSection(button) {
    Swal.fire({
        title: "Delete this section?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it"
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest(".section-item").remove();
            calculateTotal();

            Swal.fire({
                icon: "success",
                title: "Section Removed",
                timer: 1000,
                showConfirmButton: false
            });
        }
    });
}

// ========================
// CALCULATE TOTAL SCORE
// ========================
function calculateTotal() {
    let scores = document.querySelectorAll('input[type="number"][name*="[score]"]');
    let total = 0;

    scores.forEach(input => {
        if (input.value !== "") {
            total += parseFloat(input.value);
        }
    });

    document.getElementById("totalScore").innerText = total;
    document.getElementById("scoreBar").style.width = `${total}%`; 
}

// ========================
// SUBMIT REVIEW WITH ALERT
// ========================
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById("reviewForm");
    
    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            
            // Validasi: pastikan semua section memiliki score
            let scores = document.querySelectorAll('input[type="number"][name*="[score]"]');
            let allFilled = true;
            
            scores.forEach(input => {
                if (input.value === "" || input.value === null) {
                    allFilled = false;
                }
            });
            
            if (!allFilled) {
                Swal.fire({
                    title: "Incomplete!",
                    text: "Please fill all scores before submitting.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            Swal.fire({
                title: "Submit Review?",
                text: "Make sure all scores are correct.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yes, submit!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    form.submit();
                }
            });
        });
    }
});
</script>