@props(['title', 'value', 'icon', 'color'])

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-{{ $color }}-100 text-{{ $color }}-600">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($icon === 'document')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    @elseif($icon === 'clock')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    @elseif($icon === 'exclamation')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    @elseif($icon === 'check')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    @endif
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $value }}</h3>
                <p class="text-gray-600">{{ $title }}</p>
            </div>
        </div>
    </div>
</div>