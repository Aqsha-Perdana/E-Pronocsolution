@php
    $page = $page ?? 'final';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('proposal') }}
        </h2>
    </x-slot>
</x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto grid grid-cols-12 gap-6">

            <!-- SIDEBAR -->
            <div class="col-span-3 bg-white dark:bg-gray-800 shadow rounded-lg p-4">

                <ul class="space-y-2">

                    <li>
                        <a href="{{ route('proposalsel.list') }}"
                           class="block p-2 rounded {{ $page=='list' ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            Project List
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('proposalsel.review') }}"
                           class="block p-2 rounded {{ $page=='review' ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            Need To Be Reviewed
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('proposalsel.done') }}"
                           class="block p-2 rounded {{ $page=='done' ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            Need To Be Reviewed
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('proposalsel.progress') }}"
                           class="block p-2 rounded {{ $page=='progress' ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            Progress
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('proposalsel.final') }}"
                           class="block p-2 rounded {{ $page=='final' ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            Final Selection
                        </a>
                    </li>

                </ul>
            </div>  

            <!-- CONTENT -->
            <div class="col-span-9 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                @include('proposalsel.' . $page)
            </div>

        </div>
    </div>