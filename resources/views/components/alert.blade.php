@props(['type' => 'info', 'title' => '', 'message' => ''])

@php
    $title = $title ?: ucfirst($type);
@endphp

<div x-data="{ show: true }" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-90"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-90"
     x-init="setTimeout(() => show = false, 5000)"
     class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8 pointer-events-none">
    
    <div class="pointer-events-auto max-w-md w-full">
        <div class="relative overflow-hidden rounded-2xl shadow-2xl backdrop-blur-xl border 
                    {{ $type === 'success' ? 'bg-emerald-50/90 border-emerald-200/50' : '' }}
                    {{ $type === 'error' ? 'bg-red-50/90 border-red-200/50' : '' }}
                    {{ $type === 'warning' ? 'bg-amber-50/90 border-amber-200/50' : '' }}
                    {{ $type === 'info' ? 'bg-blue-50/90 border-blue-200/50' : '' }}">
            
            <!-- Animated background gradient -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute inset-0 
                            {{ $type === 'success' ? 'bg-gradient-to-br from-emerald-400 to-teal-500' : '' }}
                            {{ $type === 'error' ? 'bg-gradient-to-br from-red-400 to-pink-500' : '' }}
                            {{ $type === 'warning' ? 'bg-gradient-to-br from-amber-400 to-orange-500' : '' }}
                            {{ $type === 'info' ? 'bg-gradient-to-br from-blue-400 to-indigo-500' : '' }}
                            animate-pulse"></div>
            </div>
            
            <!-- Content -->
            <div class="relative p-6">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center
                                    {{ $type === 'success' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                    {{ $type === 'error' ? 'bg-red-100 text-red-600' : '' }}
                                    {{ $type === 'warning' ? 'bg-amber-100 text-amber-600' : '' }}
                                    {{ $type === 'info' ? 'bg-emerald-100 text-emerald-600' : '' }}">
                            
                            @if($type === 'success')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @elseif($type === 'error')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @elseif($type === 'warning')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Message -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold 
                                   {{ $type === 'success' ? 'text-emerald-800' : '' }}
                                   {{ $type === 'error' ? 'text-red-800' : '' }}
                                   {{ $type === 'warning' ? 'text-amber-800' : '' }}
                                   {{ $type === 'info' ? 'text-blue-800' : '' }}">
                            {{ $title ?? ucfirst($type) }}
                        </h3>
                        <p class="mt-1 text-sm 
                                  {{ $type === 'success' ? 'text-emerald-700' : '' }}
                                  {{ $type === 'error' ? 'text-red-700' : '' }}
                                  {{ $type === 'warning' ? 'text-amber-700' : '' }}
                                  {{ $type === 'info' ? 'text-blue-700' : '' }}">
                            {{ $message }}
                        </p>
                    </div>
                    
                    <!-- Close button -->
                    <button @click="show = false" 
                            class="flex-shrink-0 p-1 rounded-lg hover:bg-black/5 transition-colors duration-200">
                        <svg class="w-5 h-5 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Progress bar -->
                <div class="mt-4 h-1 bg-black/10 rounded-full overflow-hidden">
                    <div class="h-full rounded-full 
                                {{ $type === 'success' ? 'bg-emerald-500' : '' }}
                                {{ $type === 'error' ? 'bg-red-500' : '' }}
                                {{ $type === 'warning' ? 'bg-amber-500' : '' }}
                                {{ $type === 'info' ? 'bg-blue-500' : '' }}
                                animate-[shrink_5s_linear_forwards]"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes shrink {
    from { width: 100%; }
    to { width: 0%; }
}
</style>