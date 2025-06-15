<x-app-layout>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Card -->
            <div class="mb-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-purple-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="ml-4 text-white">
                                <h2 class="text-xl font-semibold"> {{ $greeting }}, {{ $user->name }}👋🏻</h2>
                            </div>
                        </div>
                        <div class="text-right text-white">
                            <p class="text-2xl font-bold">{{ number_format($completionRate, 1) }}%</p>
                            <p class="text-blue-100">Tingkat Penyelesaian</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <x-stat-card 
                    title="Total Jurnal" 
                    :value="$totalJurnals" 
                    icon="document" 
                    color="blue" />
                    
                <x-stat-card 
                    title="Menunggu Review" 
                    :value="$pendingReviews" 
                    icon="clock" 
                    color="yellow" />
                    
                <x-stat-card 
                    title="Perlu Revisi" 
                    :value="$needsRevision" 
                    icon="exclamation" 
                    color="red" />
                    
                <x-stat-card 
                    title="Jurnal Diterima" 
                    :value="$acceptedJurnals" 
                    icon="check" 
                    color="green" />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Monthly Submission Chart -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Statistik Bulanan</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- Category Distribution Chart -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Distribusi Kategori</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and Deadlines -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Recent Journals -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Jurnal Terbaru</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($recentJurnals as $jurnal)
                            <div class="p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $jurnal->judul }}</h4>
                                        <p class="text-sm text-gray-500">{{ $jurnal->created_at->format('d M Y') }}</p>
                                    </div>
                                    <x-status-badge :jurnal="$jurnal" />
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                Belum ada jurnal yang diupload
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Latest Reviews -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Review Terbaru</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($latestReviews as $review)
                            <div class="p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $review->kategoriPenilaian->aspek }}</h4>
                                        <p class="text-sm text-gray-500">
                                            Oleh: {{ $review->reviewer->name }} • 
                                            {{ $review->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $review->is_accepted ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $review->is_accepted ? 'Diterima' : 'Revisi' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                Belum ada review
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Review Scores -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Skor Review per Aspek</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($reviewScores as $aspek => $score)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-2">{{ $aspek }}</h4>
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                        <div style="width:{{ $score['average'] }}%" 
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-600">
                                        <span>{{ number_format($score['average'], 1) }}% Diterima</span>
                                        <span>{{ $score['count'] }} Review</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Stats Chart
        const monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: @json($monthlyStats->keys()),
                    datasets: [{
                        label: 'Jurnal per Bulan',
                        data: @json($monthlyStats->values()),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($categoryStats->keys()),
                    datasets: [{
                        data: @json($categoryStats->values()),
                        backgroundColor: [
                            '#3b82f6', // Blue
                            '#8b5cf6', // Purple
                            '#ec4899', // Pink
                            '#f59e0b'  // Yellow
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    </script>
@endpush

</x-app-layout>

