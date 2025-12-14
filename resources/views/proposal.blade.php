<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('proposal') }}
        </h2>
    </x-slot>
</x-app-layout>

 <div class="py-24" >
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8  min-h-[700px]">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
                <div class="grid grid-cols-12 gap-6">

                    <!-- Sidebar Kiri -->
                    <div class="col-span-3 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow  min-h-[500px]">
                        <h3 class="text-lg font-semibold mb-3">Proposal Selection</h3>

                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('proposalsel.list') }}"
                                    class="block p-2 rounded : 'bg-gray-200 text-black' {{ $page=='list' ? 'bg-red-600 text-white' : '' }}">
                                 Project List
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('proposalsel.review') }}"
                                class="block p-2 rounded {{ $page=='review' ? 'bg-red-600 text-white' : '' }}">
                                Need To Be Reviewed
                                </a>
                            </li>
                             <li>
                                <a href="{{ route('proposalsel.done') }}"
                                class="block p-2 rounded {{ $page=='done' ? 'bg-red-600 text-white' : '' }}">
                                Grading
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('proposalsel.progress') }}"
                                class="block p-2 rounded {{ $page=='progress' ? 'bg-red-600 text-white' : '' }}">
                                Progress Report
                            </a>
                            </li>
                            <li>
                                <a href="{{ route('proposalsel.final') }}"
                                class="block p-2 rounded {{ $page=='final' ? 'bg-red-600 text-white' : '' }}">
                                Final Report
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Konten Utama -->
                    <div class="col-span-9 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        @include('proposalsel.' . $page)
                    </div>

                </div>
            </div>

        </div>
    </div>

