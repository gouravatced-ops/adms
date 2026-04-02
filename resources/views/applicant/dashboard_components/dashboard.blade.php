@extends('applicant.dashboard_layouts.main')

@section('title', 'Dashboard | ' . config('config-system.app_name'))

@section('content')
    <!-- Dashboard Content -->
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <!-- Total Applications -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs" style="color: var(--text-gray); margin-bottom: 4px;">Total Files</p>
                    <div id="totalAppsCount" class="text-2xl font-bold" style="color: var(--navy-primary);">
                        <div class="spinner w-6 h-6"></div>
                    </div>
                </div>
                <div class="stat-icon navy">
                    <i class="fas fa-file-alt text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs" style="color: var(--success);">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>12% increase</span>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs" style="color: var(--text-gray); margin-bottom: 4px;">Pending Verification</p>
                    <div id="pendingApprovalsCount" class="text-2xl font-bold" style="color: var(--navy-primary);">
                        <div class="spinner w-6 h-6"></div>
                    </div>
                </div>
                <div class="stat-icon yellow">
                    <i class="fas fa-clock text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs" style="color: var(--warning);">
                <i class="fas fa-exclamation-circle mr-1"></i>
                <span>15 awaiting review</span>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs" style="color: var(--text-gray); margin-bottom: 4px;">Allotted Properties</p>
                    <div id="alloatedCount" class="text-2xl font-bold" style="color: var(--navy-primary);">
                        <div class="spinner w-6 h-6"></div>
                    </div>
                </div>
                <div class="stat-icon navy">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-home-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2" />
                        <path d="M19 13.488v-1.488h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h4.525" />
                        <path d="M15 19l2 2l4 -4" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs" style="color: var(--danger);">
                <i class="fas fa-arrow-down mr-1"></i>
                <span>3% decrease</span>
            </div>
        </div>

        <!-- Book Processing -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs" style="color: var(--text-gray); margin-bottom: 4px;">Ready for Handover
                    </p>
                    <div id="bookProcessingCount" class="text-2xl font-bold" style="color: var(--navy-primary);">
                        <div class="spinner w-6 h-6"></div>
                    </div>
                </div>
                <div class="stat-icon yellow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                        <path d="M3 9l4 0" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs" style="color: var(--info);">
                <i class="fas fa-sync-alt mr-1"></i>
                <span>3 books in progress</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4" style="grid-template-columns: repeat(1, minmax(0, 1fr));">
        <!-- Applications by Category Chart -->
        <div class="chart-container">
            <h3 class="text-sm font-semibold mb-3" style="color: var(--navy-primary);">Applications by
                Category</h3>
            <div id="categoryChartLoader" style="height: 250px;">
                <div class="spinner w-10 h-10"></div>
            </div>
            <canvas id="categoryChart" class="hidden" style="max-height: 250px;"></canvas>
        </div>

        <!-- Division Performance Chart -->
        <div class="chart-container">
            <h3 class="text-sm font-semibold mb-3" style="color: var(--navy-primary);">Division Performance
            </h3>
            <div id="divisionChartLoader" style="height: 250px;">
                <div class="spinner w-10 h-10"></div>
            </div>
            <canvas id="divisionChart" class="hidden" style="max-height: 250px;"></canvas>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ============= DASHBOARD DATA LOADING =============
        let categoryChartInstance = null;
        let divisionChartInstance = null;
        let currentPage = 1;
        const pageSize = 5;
        let allApplications = [];

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            loadStatsCards();
            loadCategoryChart();
            loadDivisionChart();
            loadApplicationsTable();
        });

        // ============= STATS CARDS =============
        function loadStatsCards() {
            const stats = [{
                    id: 'totalAppsCount',
                    value: '1,250',
                    icon: 'fas fa-file-alt',
                    color: 'navy'
                },
                {
                    id: 'pendingApprovalsCount',
                    value: '42',
                    icon: 'fas fa-clock',
                    color: 'yellow'
                },
                {
                    id: 'alloatedCount',
                    value: '15',
                    icon: 'fas fa-rupee-sign',
                    color: 'navy'
                },
                {
                    id: 'bookProcessingCount',
                    value: '15',
                    icon: 'fas fa-book',
                    color: 'yellow'
                }
            ];

            stats.forEach(stat => {
                const element = document.getElementById(stat.id);
                element.innerHTML = `<span class="count-animate">${stat.value}</span>`;
            });
        }

        // ============= CATEGORY CHART =============
        function loadCategoryChart() {
            const loader = document.getElementById('categoryChartLoader');
            const canvas = document.getElementById('categoryChart');

            // Simulate loading delay
            setTimeout(() => {
                loader.classList.add('hidden');
                canvas.classList.remove('hidden');

                const ctx = canvas.getContext('2d');

                // Destroy existing chart instance
                if (categoryChartInstance) {
                    categoryChartInstance.destroy();
                }

                // Create new chart
                categoryChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['EWS', 'LIG', 'MIG', 'HIG', 'Commercial'],
                        datasets: [{
                            label: 'Applications',
                            data: [320, 280, 450, 120, 80],
                            backgroundColor: [
                                '#EF4444', // EWS - Red
                                '#F59E0B', // LIG - Orange
                                '#10B981', // MIG - Green
                                '#3B82F6', // HIG - Blue
                                '#8B5CF6' // Commercial - Purple
                            ],
                            borderColor: [
                                '#DC2626',
                                '#D97706',
                                '#059669',
                                '#2563EB',
                                '#7C3AED'
                            ],
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.raw}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    stepSize: 100
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }, 1000);
        }

        // ============= DIVISION CHART =============
        function loadDivisionChart() {
            const loader = document.getElementById('divisionChartLoader');
            const canvas = document.getElementById('divisionChart');

            // Simulate loading delay
            setTimeout(() => {
                loader.classList.add('hidden');
                canvas.classList.remove('hidden');

                const ctx = canvas.getContext('2d');

                // Destroy existing chart instance
                if (divisionChartInstance) {
                    divisionChartInstance.destroy();
                }

                // Create new chart
                divisionChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [{
                                label: 'Ranchi',
                                data: [45, 52, 48, 55, 60, 58, 65],
                                borderColor: '#2563EB',
                                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'JSR',
                                data: [30, 35, 38, 42, 45, 48, 50],
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'DHN',
                                data: [25, 28, 32, 35, 38, 40, 42],
                                borderColor: '#F59E0B',
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                tension: 0.3,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 10
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                title: {
                                    display: true,
                                    text: 'Applications'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }, 1200);
        }

        // ============= APPLICATIONS TABLE =============
        function loadApplicationsTable() {
            // Mock data for applications
            allApplications = [{
                    id: 'APP-2023-001',
                    name: 'Shivam Kumar',
                    division: 'Ranchi',
                    category: 'EWS',
                    amount: '₹50,000',
                    status: 'Approved',
                    date: '2023-10-15',
                    avatar: 'SK'
                },
                {
                    id: 'APP-2023-002',
                    name: 'Priya Sharma',
                    division: 'JSR',
                    category: 'MIG',
                    amount: '₹1,50,000',
                    status: 'Pending',
                    date: '2023-10-18',
                    avatar: 'PS'
                },
                {
                    id: 'APP-2023-003',
                    name: 'Rahul Verma',
                    division: 'DHN',
                    category: 'HIG',
                    amount: '₹25,00,000',
                    status: 'Approved',
                    date: '2023-10-20',
                    avatar: 'RV'
                },
                {
                    id: 'APP-2023-004',
                    name: 'Anjali Singh',
                    division: 'Ranchi',
                    category: 'EWS',
                    amount: '₹10,000',
                    status: 'Rejected',
                    date: '2023-10-22',
                    avatar: 'AS'
                },
                {
                    id: 'APP-2023-005',
                    name: 'Vikram Patel',
                    division: 'JSR',
                    category: 'LIG',
                    amount: '₹75,000',
                    status: 'Pending',
                    date: '2023-10-25',
                    avatar: 'VP'
                },
                {
                    id: 'APP-2023-006',
                    name: 'Suresh Yadav',
                    division: 'DHN',
                    category: 'MIG',
                    amount: '₹1,00,000',
                    status: 'Approved',
                    date: '2023-10-28',
                    avatar: 'SY'
                },
                {
                    id: 'APP-2023-007',
                    name: 'Neha Gupta',
                    division: 'Ranchi',
                    category: 'HIG',
                    amount: '₹30,00,000',
                    status: 'Pending',
                    date: '2023-10-30',
                    avatar: 'NG'
                },
                {
                    id: 'APP-2023-008',
                    name: 'Rajesh Kumar',
                    division: 'JSR',
                    category: 'EWS',
                    amount: '₹30,000',
                    status: 'Approved',
                    date: '2023-11-01',
                    avatar: 'RK'
                },
                {
                    id: 'APP-2023-009',
                    name: 'Meena Devi',
                    division: 'DHN',
                    category: 'LIG',
                    amount: '₹80,000',
                    status: 'Rejected',
                    date: '2023-11-03',
                    avatar: 'MD'
                },
                {
                    id: 'APP-2023-010',
                    name: 'Amit Singh',
                    division: 'Ranchi',
                    category: 'MIG',
                    amount: '₹1,20,000',
                    status: 'Pending',
                    date: '2023-11-05',
                    avatar: 'AS'
                }
            ];

            updateTable();
            updatePagination();
        }

        // ============= RESPONSIVE HANDLER =============
        window.addEventListener('resize', () => {
            const layout = localStorage.getItem('layout') || 'sidebar';
            const mainContainer = document.getElementById('mainContainer');

            if (window.innerWidth > 768 && layout === 'sidebar') {
                mainContainer.style.marginLeft = '260px';
            } else if (window.innerWidth <= 768) {
                mainContainer.style.marginLeft = '0';
            }
        });
    </script>
@endpush
