@props(['title', 'color' => 'gray', 'content'])

<div class="mb-4 bg-gradient-to-r from-{{ $color }}-50 to-{{ $color }}-100
            p-3 rounded-lg border-l-4 border-{{ $color }}-500">
    <p class="text-xs font-medium text-{{ $color }}-700 uppercase mb-2">
        {{ $title }}
    </p>

    <div class="text-sm text-gray-700
                whitespace-pre-wrap
                leading-relaxed
                break-all
                overflow-hidden">
        {!! $content ?? 'Tidak ada data.' !!}
    </div>
</div>
