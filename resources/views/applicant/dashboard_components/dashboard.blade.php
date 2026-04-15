@extends('applicant.dashboard_layouts.main')

@section('title', 'Dashboard | ' . config('config-system.app_name'))

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');

    /* ---------- DASHBOARD GRID: 2 CARDS PER ROW (strict) ---------- */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.75rem;
        margin-bottom: 2.5rem;
    }

    /* tablet + desktop: exactly 2 columns */
    @media (min-width: 640px) {
        .dashboard-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.75rem;
        }
    }

    /* ---------- CARD STYLES: NO BORDER RADIUS, LARGER PADDING, CLEAN ---------- */
    .stat-card {
        background: #ffffff;
        /* base fallback */
        padding: 1.6rem 1.8rem;
        transition: all 0.2s ease;
        border: none;
        /* NO border-radius */
        border-radius: 0px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 28px -12px rgba(0, 0, 0, 0.12), 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    /* inner flex layout */
    .card-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    /* text area */
    .stat-info p {
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        margin-bottom: 0.6rem;
        color: #2c3e50;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
        color: #0a1c2f;
        letter-spacing: -0.02em;
    }

    .stat-icon {
        width: 3.6rem;
        height: 3.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        /* no border radius */
        border-radius: 0px;
    }

    .stat-icon svg,
    .stat-icon i {
        width: 1.8rem;
        height: 1.8rem;
        font-size: 1.7rem;
    }

    /* Card scheme variations - light & distinct */
    .card-scheme-1 {
        background: #fef7e0;
    }

    /* soft cream */
    .card-scheme-2 {
        background: #e3f5ec;
    }

    /* light mint */
    .card-scheme-3 {
        background: #eef2ff;
    }

    /* periwinkle mist */
    .card-scheme-4 {
        background: #ffe6f0;
    }

    /* blush pink */
    .card-scheme-5 {
        background: #e0f2fe;
    }

    /* sky breath */
    .card-scheme-6 {
        background: #f0e7fe;
    }

    /* lavender cloud */
    .card-scheme-7 {
        background: #feefdd;
    }

    /* peach whisper */
    .card-scheme-8 {
        background: #dcfce7;
    }

    /* soft green */
    .card-scheme-9 {
        background: #ffedd5;
    }

    /* warm sand */
    .card-scheme-10 {
        background: #e6f7f6;
    }

    .card-scheme-1 .stat-icon {
        background: #faeec2;
        color: #7a5c1a;
    }

    .card-scheme-2 .stat-icon {
        background: #cdecdb;
        color: #1e6b3e;
    }

    .card-scheme-3 .stat-icon {
        background: #dfe4ff;
        color: #2c3e8f;
    }

    .card-scheme-4 .stat-icon {
        background: #ffd9e7;
        color: #ac3f6b;
    }

    .card-scheme-5 .stat-icon {
        background: #cde9ff;
        color: #1f6392;
    }

    .card-scheme-6 .stat-icon {
        background: #e2d9fc;
        color: #5141a3;
    }

    .card-scheme-7 .stat-icon {
        background: #ffe0c4;
        color: #b45f2b;
    }

    .card-scheme-8 .stat-icon {
        background: #c2efd4;
        color: #146b3a;
    }

    .card-scheme-9 .stat-icon {
        background: #ffe0b5;
        color: #b4682d;
    }

    .card-scheme-10 .stat-icon {
        background: #c8edea;
        color: #1f6e64;
    }

    /* ensure text inside icon (svg / i) has dark color */
    .stat-icon svg,
    .stat-icon i {
        color: currentColor;
        stroke: currentColor;
    }

    /* section header styling (no border radius, clean) */
    .section-header {
        margin-bottom: 1.5rem;
        margin-top: 0.25rem;
        padding-bottom: 0.65rem;
        border-bottom: 2px solid #cddfe7;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a2c3e;
        letter-spacing: -0.2px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-header i {
        color: #2c6e9e;
        font-size: 1.2rem;
    }

    /* small responsive */
    @media (max-width: 550px) {

        .stat-card {
            padding: 1.2rem 1.4rem;
        }

        .stat-number {
            font-size: 1.7rem;
        }

        .stat-icon {
            width: 3rem;
            height: 3rem;
        }
    }

    .stat-card,
    .stat-icon,
    .section-header,
    .section-header h3,
    .dashboard-grid,
    .card-content {
        border-radius: 0px;
    }

    .stat-icon svg,
    .stat-icon i {
        border-radius: 0px;
    }

    .count-animate {
        display: inline-block;
    }

    .stat-card:hover {
        border-radius: 0px;
    }
</style>
<div class="overflow-hidden1">
    <div class="section-header">
        <h3>
            <i class="fas fa-database"></i>
            Digitalization Stats
        </h3>
    </div>
</div>

<div class="dashboard-grid">
    <!-- 1. Total Receiving Files - scheme 1 -->
    <div class="stat-card card-scheme-1">
        <div class="card-content">
            <div class="stat-info">
                <p>Total Receiving Files</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalreceivingFile }}">0</span></div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
    </div>

    <!-- 2. Total Scanned Files - scheme 2 -->
    <div class="stat-card card-scheme-2">
        <div class="card-content">
            <div class="stat-info">
                <p>Total Scanned Files</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalscannedFile }}">0</span></div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7V4h4M20 7V4h-4M4 17v3h4M20 17v3h-4" />
                    <line x1="6" y1="12" x2="18" y2="12" />
                </svg>
            </div>
        </div>
    </div>

    <!-- 3. Total Allottees - scheme 3 -->
    <div class="stat-card card-scheme-3">
        <div class="card-content">
            <div class="stat-info">
                <p>Total Allottees</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalAllotteeFile }}">0</span></div>
            </div>
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2" />
                    <path d="M19 13.488v-1.488h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h4.525" />
                    <path d="M15 19l2 2l4 -4" />
                </svg>
            </div>
        </div>
    </div>

    <!-- 4. Total Data Entry File - scheme 4 -->
    <div class="stat-card card-scheme-4">
        <div class="card-content">
            <div class="stat-info">
                <p>Total Data Entry File</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalDataentryFile }}">0</span></div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <line x1="7" y1="8" x2="17" y2="8" />
                    <line x1="7" y1="12" x2="13" y2="12" />
                    <line x1="7" y1="16" x2="11" y2="16" />
                </svg>
            </div>
        </div>
    </div>

    <!-- 5. Total Checked File - scheme 5 -->
    <div class="stat-card card-scheme-5">
        <div class="card-content">
            <div class="stat-info">
                <p>Total Checked File</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalcheckedFile }}">0</span></div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M8 12l2.5 2.5L16 9" />
                </svg>
            </div>
        </div>
    </div>

    <!-- 6. Total Approved File - scheme 6 -->
    <div class="stat-card card-scheme-6">
        <div class="card-content">
            <div class="stat-info">
                <p>Total Approved File</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalapprovedFile }}">0</span></div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 3l7 4v5c0 5-3.5 7.5-7 9-3.5-1.5-7-4-7-9V7l7-4z" />
                    <path d="M9 12l2 2 4-4" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- USER STATISTICS SECTION -->
<div class="overflow-hidden1" style="margin-top: 0.5rem;">
    <div class="section-header">
        <h3>
            <i class="fas fa-users"></i>
            User Statistics
        </h3>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Today's Data Entry - scheme 7 -->
    <div class="stat-card card-scheme-7">
        <div class="card-content">
            <div class="stat-info">
                <p>Today's Data Entry</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $todayDataentryCount }}">0</span></div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <line x1="7" y1="8" x2="15" y2="8" />
                    <line x1="7" y1="12" x2="13" y2="12" />
                    <path d="M9 16l2 2 4-4" />
                </svg>
            </div>
        </div>
    </div>

    <!-- In Progress Files - scheme 8 -->
    <div class="stat-card card-scheme-8">
        <div class="card-content">
            <div class="stat-info">
                <p>In Progress Files</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalPendingdataentryFile }}">0</span></div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Total Data Entry (by user) - scheme 9 -->
    <div class="stat-card card-scheme-9">
        <div class="card-content">
            <div class="stat-info">
                <p>Total Data Entry</p>
                <div class="stat-number"><span class="count-animate" data-target="{{ $totalDataentryByUser }}">0</span></div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <line x1="7" y1="8" x2="17" y2="8" />
                    <line x1="7" y1="12" x2="13" y2="12" />
                    <line x1="7" y1="16" x2="11" y2="16" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4" style="grid-template-columns: repeat(1, minmax(0, 1fr));">
    Applications by Category Chart
    <div class="chart-container">
        <h3 class="text-sm font-semibold mb-3" style="color: var(--navy-primary);">Applications by
            Category</h3>
        <div id="categoryChartLoader" style="height: 250px;">
            <div class="spinner w-10 h-10"></div>
        </div>
        <canvas id="categoryChart" class="hidden" style="max-height: 250px;"></canvas>
    </div>

    Division Performance Chart
    <div class="chart-container">
        <h3 class="text-sm font-semibold mb-3" style="color: var(--navy-primary);">Division Performance
        </h3>
        <div id="divisionChartLoader" style="height: 250px;">
            <div class="spinner w-10 h-10"></div>
        </div>
        <canvas id="divisionChart" class="hidden" style="max-height: 250px;"></canvas>
    </div>
</div> -->

@endsection

@push('scripts')
<script>
    (function() {
        const ANIMATION_DURATION = 2000;

        // Select all counter elements
        const counters = document.querySelectorAll('.count-animate');

        // Store initial values and targets
        const counterItems = [];

        counters.forEach(counter => {
            const targetAttr = counter.getAttribute('data-target');
            if (targetAttr === null) return;

            const targetNumber = parseInt(targetAttr, 10);
            if (isNaN(targetNumber)) return;

            // Store initial state
            counterItems.push({
                element: counter,
                target: targetNumber,
                current: 0,
                startTime: null,
                isAnimating: false,
            });
            // set initial text to 0
            counter.innerText = '0';
        });

        function easeOutQuad(t) {
            return t * (2 - t);
        }

        // Animation loop for each counter
        function animateCounter(item, now) {
            if (!item.isAnimating) return;

            if (!item.startTime) {
                item.startTime = now;
                requestAnimationFrame(function(timestamp) {
                    animateCounter(item, timestamp);
                });
                return;
            }

            const elapsed = now - item.startTime;
            let progress = Math.min(1, elapsed / ANIMATION_DURATION);
            // apply easing
            const easedProgress = easeOutQuad(progress);
            const nextValue = Math.floor(easedProgress * item.target);

            // Update the DOM
            if (item.element.innerText !== nextValue.toString()) {
                item.element.innerText = nextValue;
            }

            // If animation is not complete, continue
            if (progress < 1) {
                requestAnimationFrame(function(timestamp) {
                    animateCounter(item, timestamp);
                });
            } else {
                item.element.innerText = item.target;
                item.isAnimating = false;
            }
        }

        function startAllCounters() {
            for (let i = 0; i < counterItems.length; i++) {
                const item = counterItems[i];
                if (item.isAnimating) continue;
                // reset
                item.current = 0;
                item.startTime = null;
                item.isAnimating = true;
                // initial set to 0
                item.element.innerText = '0';
                // begin animation
                requestAnimationFrame(function(timestamp) {
                    animateCounter(item, timestamp);
                });
            }
        }

        function initCounters() {
            // Reset all counters to 0 before starting fresh (in case they have content)
            for (let i = 0; i < counterItems.length; i++) {
                const item = counterItems[i];
                item.element.innerText = '0';
                item.isAnimating = false;
                item.startTime = null;
                item.current = 0;
            }
            // slight delay to ensure DOM ready and numbers are fresh
            setTimeout(() => {
                startAllCounters();
            }, 100);
        }

        // If page already loaded, init; else wait for events
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCounters);
        } else {
            initCounters();
        }

        window.addEventListener('load', function() {
            // For any counters that might not have started (re-run safety)
            for (let i = 0; i < counterItems.length; i++) {
                const item = counterItems[i];
                if (!item.isAnimating && item.element.innerText !== item.target.toString()) {
                    // restart if not finished
                    item.isAnimating = false;
                    item.startTime = null;
                    item.element.innerText = '0';
                    requestAnimationFrame(function(timestamp) {
                        item.isAnimating = true;
                        animateCounter(item, timestamp);
                    });
                }
            }
        });

    })();
</script>
<script>
    // ============= DASHBOARD DATA LOADING =============
    let categoryChartInstance = null;
    let divisionChartInstance = null;
    let currentPage = 1;
    const pageSize = 5;
    let allApplications = [];

    // Initialize dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // loadStatsCards();
        loadCategoryChart();
        loadDivisionChart();
        loadApplicationsTable();
    });

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