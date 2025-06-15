<x-app-layout>
    <div class="py-5">
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
                                <h2 class="text-xl font-semibold">{{ $greeting }}, Admin</h2>
                                <p class="text-blue-100">Admin Overview</p>
                            </div>
                        </div>
                        <div class="text-right text-white">
                            <p class="text-2xl font-bold">{{ $totalJurnals }}</p>
                            <p class="text-blue-100">Total Journals</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <x-stat-card 
                    title="Total Publisher" 
                    :value="$totalUsers" 
                    icon="user-group" 
                    color="blue" />
                    
                <x-stat-card 
                    title="Total Reviews" 
                    :value="$totalReviews" 
                    icon="check-circle" 
                    color="green" />
                    
                <x-stat-card 
                    title="Jurnal Revisi" 
                    :value="$totalRevisions" 
                    icon="arrow-path" 
                    color="yellow" />
                    
                <x-stat-card 
                    title="Kategori Aktifitas" 
                    :value="$popularCategories->count()" 
                    icon="squares-2x2" 
                    color="purple" />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Monthly Activity Chart -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Aktiftas Bulanan</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- Category Distribution Chart -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Kategori Jurnal</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and Top Reviewers -->
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
                                        <p class="text-sm text-gray-500">
                                            By: {{ $jurnal->user->name }} • 
                                            {{ $jurnal->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                Tidak ada jurnal terbaru
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Top Reviewers -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Top Reviewers</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($topReviewers as $reviewer)
                            <div class="p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $reviewer->name }}</h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $reviewer->review_count }} reviews completed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                Tidak ada reviewer teratas
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Popular Categories -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Kategori Penilaian</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($popularCategories as $category)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-2">{{ $category->aspek }}</h4>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Used {{ $category->usage_count }} times</span>
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
        // Monthly Activity Chart
        const monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: @json(collect($monthlyActivity)->pluck('month')),
                    datasets: [{
                        label: 'Journals',
                        data: @json(collect($monthlyActivity)->pluck('jurnals')),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Reviews',
                        data: @json(collect($monthlyActivity)->pluck('reviews')),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
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
                    labels: @json($jurnalByCategory->pluck('kategori')),
                    datasets: [{
                        data: @json($jurnalByCategory->pluck('total')),
                        backgroundColor: [
                            '#3b82f6',
                            '#8b5cf6',
                            '#ec4899',
                            '#f59e0b'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    </script>
    @endpush
</x-app-layout>