<x-slot name="title">Edit Fund Realization Report</x-slot>
<div class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Fund Realization</h1>
                <p class="text-slate-500 text-sm mt-1">Edit and update your budget realization details.</p>
            </div>
<<<<<<< HEAD
=======
            {{-- Tombol Back di Header (Opsional, sudah ada sebelumnya) --}}
>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
            <a href="{{ route('report.fund') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-medium text-slate-700 hover:bg-slate-50 transition shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to List
            </a>
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Card 1: Proposal --}}
            <div class="bg-white rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <svg class="w-24 h-24 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Proposal Title</label>
                <div class="text-lg font-semibold text-slate-800 leading-snug relative z-10">
                    {{ $budget->proposal->title }}
                </div>
            </div>

            {{-- Card 2: Fund Plan --}}
            <div class="bg-white rounded-xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <svg class="w-24 h-24 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Total Fund Plan</label>
                <div class="text-2xl font-bold text-slate-800 relative z-10">
                    Rp. {{ number_format($budget->total_plan ?? ($budget->direct_personnel_cost_proposal + $budget->non_personnel_cost_proposal + $budget->indirect_cost_proposal), 0, ',', '.') }}
                </div>
            </div>
        </div>

        {{-- Main Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-200 flex items-center gap-2">
                <div class="w-2 h-6 bg-red-600 rounded-full"></div>
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wide">Expenditure Details</h3>
            </div>

            <div class="p-6 space-y-6">
                
                {{-- Input 1: Direct Personnel Costs --}}
                <div class="group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2">
                        <label class="text-sm font-medium text-slate-700 flex items-center gap-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded bg-slate-100 text-slate-500 text-xs font-bold">1</span>
                            Direct Personnel Costs <span class="text-red-500">*</span>
                        </label>
                        <span class="hidden sm:inline-block text-xs text-slate-400">Biaya Tenaga Lapangan (Non Dosen)</span>
                    </div>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 sm:text-sm font-bold">Rp</span>
                        </div>
                        {{-- Added onfocus and onblur logic here --}}
                        <input type="number" wire:model.live="direct_cost_realization" 
                            onfocus="if(this.value==0){this.value=''}" 
                            onblur="if(this.value==''){this.value=0}"
                            class="block w-full rounded-lg border-0 py-3 pl-10 pr-4 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6 transition bg-slate-50 focus:bg-white @error('direct_cost_realization') ring-red-500 @enderror"
                            placeholder="0">
                    </div>
                    @error('direct_cost_realization') 
                        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Input 2: Non-Personnel Costs --}}
                <div class="group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2">
                        <label class="text-sm font-medium text-slate-700 flex items-center gap-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded bg-slate-100 text-slate-500 text-xs font-bold">2</span>
                            Direct Non-Personnel Costs <span class="text-red-500">*</span>
                        </label>
                        <span class="hidden sm:inline-block text-xs text-slate-400">Barang Habis Pakai (Non Aset)</span>
                    </div>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 sm:text-sm font-bold">Rp</span>
                        </div>
                        {{-- Added onfocus and onblur logic here --}}
                        <input type="number" wire:model.live="non_personnel_cost_realization" 
                            onfocus="if(this.value==0){this.value=''}" 
                            onblur="if(this.value==''){this.value=0}"
                            class="block w-full rounded-lg border-0 py-3 pl-10 pr-4 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6 transition bg-slate-50 focus:bg-white @error('non_personnel_cost_realization') ring-red-500 @enderror"
                            placeholder="0">
                    </div>
                    @error('non_personnel_cost_realization') 
                        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Input 3: Indirect Costs --}}
                <div class="group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2">
                        <label class="text-sm font-medium text-slate-700 flex items-center gap-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded bg-slate-100 text-slate-500 text-xs font-bold">3</span>
                            Indirect Costs <span class="text-red-500">*</span>
                        </label>
                        <span class="hidden sm:inline-block text-xs text-slate-400">Biaya Perjalanan Dinas & Pengelolaan</span>
                    </div>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 sm:text-sm font-bold">Rp</span>
                        </div>
                        {{-- Added onfocus and onblur logic here --}}
                        <input type="number" wire:model.live="indirect_cost_realization" 
                            onfocus="if(this.value==0){this.value=''}" 
                            onblur="if(this.value==''){this.value=0}"
                            class="block w-full rounded-lg border-0 py-3 pl-10 pr-4 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6 transition bg-slate-50 focus:bg-white @error('indirect_cost_realization') ring-red-500 @enderror"
                            placeholder="0">
                    </div>
                    @error('indirect_cost_realization') 
                        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p> 
                    @enderror
                </div>

                <hr class="border-slate-200 my-6">

                {{-- Summary Calculation Box --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Total Realization --}}
                    <div class="rounded-xl bg-red-50 border border-red-100 p-4 flex flex-col items-center justify-center text-center">
                        <span class="text-xs font-bold text-red-600 uppercase tracking-wide">Total Realization</span>
                        <div class="mt-1 text-2xl font-bold text-red-700">
                            <span class="text-sm font-normal text-red-500 mr-1">Rp.</span>
                            {{ number_format($this->totalRealization, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- Remaining Fund --}}
                    <div class="rounded-xl bg-gray-100 border border-gray-200 p-4 flex flex-col items-center justify-center text-center">
                        <span class="text-xs font-bold text-gray-600 uppercase tracking-wide">Remaining Funds</span>
                        <div class="mt-1 text-2xl font-bold text-gray-800">
                            <span class="text-sm font-normal text-gray-500 mr-1">Rp.</span>
                            {{ number_format($this->remainingFund, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- File Upload Area --}}
                <div class="mt-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Fund Realization Document (FAD) <span class="text-red-500">*</span></label>
                    
                    @error('document_rab_realization') 
                        <p class="mb-2 text-sm text-red-600 font-bold bg-red-50 p-2 rounded border border-red-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror

                    <div class="flex justify-center rounded-lg border border-dashed px-6 py-8 transition cursor-pointer relative
                        @error('document_rab_realization') border-red-400 bg-red-50/30 @else border-slate-300 hover:bg-slate-50 hover:border-red-400 @enderror">
                        
                        <div class="text-center">
                            @if($document_rab_realization)
                                <svg class="mx-auto h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="mt-2 text-sm text-slate-900 font-semibold">{{ $document_rab_realization->getClientOriginalName() }}</p>
                                <p class="text-xs text-slate-500">Ready to save</p>
                            @elseif($budget->document_rab_fundrealization)
                                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="mt-2 text-sm text-slate-900 font-semibold text-ellipsis overflow-hidden w-48 mx-auto whitespace-nowrap">Current: {{ basename($budget->document_rab_fundrealization) }}</p>
                                <p class="text-xs text-slate-500">Click to replace</p>
                            @else
                                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-slate-600 justify-center">
                                    <span class="relative cursor-pointer rounded-md bg-white font-semibold text-red-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-red-600 focus-within:ring-offset-2 hover:text-red-700">
                                        <span>Upload a file</span>
                                    </span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-slate-500">XLSX or XLS up to 10MB</p>
                            @endif
                            <input type="file" wire:model="document_rab_realization" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>
                    
                    <div wire:loading wire:target="document_rab_realization" class="text-xs text-center text-slate-500 mt-2 italic">
                        Uploading document... please wait.
                    </div>
                </div>

            </div>

            {{-- Footer / Action --}}
            <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-200">
                <a href="{{ route('report.fund') }}" class="inline-flex justify-center rounded-lg bg-white px-6 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button wire:click="save" class="inline-flex justify-center rounded-lg bg-red-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition">
                    <svg class="w-4 h-4 mr-2 -ml-1 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Submit Report
                </button>
            </div>
        </div>
    </div>
</div>