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
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
    <!-- Applications by Category Chart -->
    <div class="chart-container">
        <h3 class="text-sm font-semibold mb-3" style="color: var(--navy-primary);">Applications by
            Category</h3>
        <div id="categoryChartLoader"  style="height: 250px;">
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

<!-- Recent Applications Table -->
<div class="compact-card overflow-hidden">
    <div class="p-4 border-b flex flex-col gap-3" style="border-color: var(--gray-border);">

        <!-- HEADER ROW -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <h3 class="flex items-center gap-2 text-sm font-semibold">
                <i class="fas fa-file-alt"></i>
                Recent Applications
            </h3>

            <!-- Actions Row -->
            <div class="flex items-center gap-3">

                <!-- Filter Toggle Button -->
                <button onclick="toggleFilterDropdown()" class="btn btn-outline flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>

                <!-- Export Buttons -->
                <div class="flex items-center gap-2">
                    <button onclick="exportTableToCSV()" class="btn btn-outline">
                        <i class="fas fa-file-csv"></i>
                        <span>CSV</span>
                    </button>
                    <button onclick="exportTableToPDF()" class="btn btn-navy">
                        <i class="fas fa-file-pdf"></i>
                        <span>PDF</span>
                    </button>
                    <button onclick="printTable()" class="btn btn-yellow">
                        <i class="fas fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- FILTER DIVIDER -->
        <hr class="hidden" id="filterDivider" style="border-color: var(--gray-border);">

        <!-- FULL WIDTH FILTER FORM -->
        <div id="filterDropdown" class="hidden w-full">
            <div class="flex flex-wrap items-end gap-3 bg-white p-3">

                <!-- Division -->
                <div class="flex flex-col w-44">
                    <label class="text-xs font-medium mb-1">Division</label>
                    <select class="p-2 border rounded text-sm" id="filterDivision" onchange="filterApplications()">
                        <option value="">All Divisions</option>
                        <option value="Ranchi">Ranchi</option>
                        <option value="JSR">JSR</option>
                        <option value="DHN">DHN</option>
                    </select>
                </div>

                <!-- Category -->
                <div class="flex flex-col w-44">
                    <label class="text-xs font-medium mb-1">Category</label>
                    <select class="p-2 border rounded text-sm" id="filterCategory" onchange="filterApplications()">
                        <option value="">All Categories</option>
                        <option value="EWS">EWS</option>
                        <option value="LIG">LIG</option>
                        <option value="MIG">MIG</option>
                        <option value="HIG">HIG</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="flex flex-col w-40">
                    <label class="text-xs font-medium mb-1">Status</label>
                    <select class="p-2 border rounded text-sm" id="filterStatus" onchange="filterApplications()">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full" id="applicationsTable">
            <thead>
                <tr>
                    <th class="text-left text-xs font-semibold">Application ID</th>
                    <th class="text-left text-xs font-semibold">Applicant Name</th>
                    <th class="text-left text-xs font-semibold">Division</th>
                    <th class="text-left text-xs font-semibold">Category</th>
                    <th class="text-left text-xs font-semibold">Amount</th>
                    <th class="text-left text-xs font-semibold">Status</th>
                    <th class="text-left text-xs font-semibold">Applied Date</th>
                </tr>
            </thead>
            <tbody id="applicationsTableBody">
                <tr>
                    <td colspan="7" class="text-center py-8">
                        <div class="flex items-center justify-center">
                            <div class="spinner w-8 h-8"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-3 border-t flex items-center justify-between" style="border-color: var(--gray-border);">
        <div class="text-xs text-gray-500">
            Showing <span id="currentPageRange">1-5</span> of <span id="totalApplicationsCount">50</span>
            applications
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="previousPage()" class="p-2 rounded border hover:bg-gray-50 disabled:opacity-50" disabled
                id="prevBtn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="nextPage()" class="p-2 rounded border hover:bg-gray-50" id="nextBtn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
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
            document.addEventListener('DOMContentLoaded', function () {
                loadStatsCards();
                loadCategoryChart();
                loadDivisionChart();
                loadApplicationsTable();
            });

            // ============= STATS CARDS =============
            function loadStatsCards() {
                const stats = [
                    {
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
                                    '#8B5CF6'  // Commercial - Purple
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
                                        label: function (context) {
                                            return `${context.dataset.label}: ${context.raw}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                                    ticks: { stepSize: 100 }
                                },
                                x: {
                                    grid: { display: false }
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
                            datasets: [
                                {
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
                                    labels: { padding: 10 }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                                    title: { display: true, text: 'Applications' }
                                },
                                x: {
                                    grid: { display: false }
                                }
                            }
                        }
                    });
                }, 1200);
            }

            // ============= APPLICATIONS TABLE =============
            function loadApplicationsTable() {
                // Mock data for applications
                allApplications = [
                    { id: 'APP-2023-001', name: 'Shivam Kumar', division: 'Ranchi', category: 'EWS', amount: '₹50,000', status: 'Approved', date: '2023-10-15', avatar: 'SK' },
                    { id: 'APP-2023-002', name: 'Priya Sharma', division: 'JSR', category: 'MIG', amount: '₹1,50,000', status: 'Pending', date: '2023-10-18', avatar: 'PS' },
                    { id: 'APP-2023-003', name: 'Rahul Verma', division: 'DHN', category: 'HIG', amount: '₹25,00,000', status: 'Approved', date: '2023-10-20', avatar: 'RV' },
                    { id: 'APP-2023-004', name: 'Anjali Singh', division: 'Ranchi', category: 'EWS', amount: '₹10,000', status: 'Rejected', date: '2023-10-22', avatar: 'AS' },
                    { id: 'APP-2023-005', name: 'Vikram Patel', division: 'JSR', category: 'LIG', amount: '₹75,000', status: 'Pending', date: '2023-10-25', avatar: 'VP' },
                    { id: 'APP-2023-006', name: 'Suresh Yadav', division: 'DHN', category: 'MIG', amount: '₹1,00,000', status: 'Approved', date: '2023-10-28', avatar: 'SY' },
                    { id: 'APP-2023-007', name: 'Neha Gupta', division: 'Ranchi', category: 'HIG', amount: '₹30,00,000', status: 'Pending', date: '2023-10-30', avatar: 'NG' },
                    { id: 'APP-2023-008', name: 'Rajesh Kumar', division: 'JSR', category: 'EWS', amount: '₹30,000', status: 'Approved', date: '2023-11-01', avatar: 'RK' },
                    { id: 'APP-2023-009', name: 'Meena Devi', division: 'DHN', category: 'LIG', amount: '₹80,000', status: 'Rejected', date: '2023-11-03', avatar: 'MD' },
                    { id: 'APP-2023-010', name: 'Amit Singh', division: 'Ranchi', category: 'MIG', amount: '₹1,20,000', status: 'Pending', date: '2023-11-05', avatar: 'AS' }
                ];

                updateTable();
                updatePagination();
            }

            function updateTable(filters = {}) {
                const tbody = document.getElementById('applicationsTableBody');
                const primaryColor = getComputedStyle(document.documentElement)
                        .getPropertyValue('--primary-color')
                        .trim()
                        .replace('#', '');

                // Destructure filters (safe defaults)
                const {
                    division = '',
                    category = '',
                    status = ''
                } = filters;

                let filteredApplications = allApplications.filter(app => {
                    return (
                        (!division || app.division === division) &&
                        (!category || app.category === category) &&
                        (!status || app.status === status)
                    );
                });

                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = startIndex + pageSize;
                const currentApplications = filteredApplications.slice(startIndex, endIndex);

                if (!currentApplications.length) {
                    tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-2xl mb-2"></i>
                    <p>No applications found</p>
                </td>
            </tr>
        `;
                    return;
                }

                tbody.innerHTML = currentApplications.map(app => `
        <tr class="hover:bg-gray-50">
            <td class="py-3">
                <div class="flex items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded mr-2 bg-gray-100">
                        <i class="fas fa-file-alt text-gray-600"></i>
                    </div>
                    <a href="javascript:void(0)"
                       onclick="viewApplication('${app.id}')"
                       class="font-medium text-sm text-blue-600 hover:text-blue-800">
                        ${app.id}
                    </a>
                </div>
            </td>

            <td class="py-3">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(app.avatar)}&background=${primaryColor}&color=ffffff&size=32"
                         alt="${app.name}"
                         class="w-7 h-7 rounded-full mr-2">
                    <span class="font-medium text-sm">${app.name}</span>
                </div>
            </td>

            <td class="py-3 text-sm">${app.division}</td>

            <td class="py-3">
                <span class="category-badge ${app.category.toLowerCase()}">
                    ${app.category}
                </span>
            </td>

            <td class="py-3 font-medium text-sm">${app.amount}</td>

            <td class="py-3">
                <span class="status-badge ${app.status.toLowerCase()}">
                    <i class="fas ${getStatusIcon(app.status)} mr-1"></i>
                    ${app.status}
                </span>
            </td>

            <td class="py-3 text-sm text-gray-500">
                ${formatDate(app.date)}
            </td>
        </tr>
    `).join('');
            }

            function getStatusIcon(status) {
                switch (status) {
                    case 'Approved': return 'fa-check-circle';
                    case 'Pending': return 'fa-clock';
                    case 'Rejected': return 'fa-times-circle';
                    default: return 'fa-circle';
                }
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-IN', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            // ============= PAGINATION =============
            function updatePagination() {
                const totalPages = Math.ceil(allApplications.length / pageSize);
                const startIndex = (currentPage - 1) * pageSize + 1;
                const endIndex = Math.min(currentPage * pageSize, allApplications.length);

                // Update page range text
                document.getElementById('currentPageRange').textContent = `${startIndex}-${endIndex}`;
                document.getElementById('totalApplicationsCount').textContent = allApplications.length;

                // Update button states
                document.getElementById('prevBtn').disabled = currentPage === 1;
                document.getElementById('nextBtn').disabled = currentPage === totalPages;
            }

            function nextPage() {
                const totalPages = Math.ceil(allApplications.length / pageSize);
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                    updatePagination();
                }
            }

            function previousPage() {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                    updatePagination();
                }
            }

            // ============= FILTER FUNCTIONS =============
            function toggleFilterDropdown() {
                const dropdown = document.getElementById('filterDropdown');
                const hrline = document.getElementById('filterDivider');
                dropdown.classList.toggle('hidden');
                hrline.classList.toggle('hidden');
            }

            function filterApplications() {

                // Get filter values (SAFE & CLEAN)
                const divisionFilter = document.getElementById('filterDivision').value;
                const categoryFilter = document.getElementById('filterCategory').value;
                const statusFilter = document.getElementById('filterStatus').value;

                // Optional: close filter panel AFTER selection

                // Show loading state
                const tbody = document.getElementById('applicationsTableBody');
                tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-8">
                        <div class="flex items-center justify-center">
                            <div class="spinner w-8 h-8"></div>
                        </div>
                    </td>
                </tr>
            `;

                // Simulate API delay
                setTimeout(() => {

                    // Reset pagination
                    currentPage = 1;

                    // Apply filters (you’ll use these inside updateTable)
                    updateTable({
                        division: divisionFilter,
                        category: categoryFilter,
                        status: statusFilter
                    });

                    updatePagination();

                    // UX feedback
                    //showToast(
                    //'Filters Applied',
                    //'Applications filtered successfully',
                    //'success'
                    //);

                }, 400);
            }

            // ============= EXPORT FUNCTIONS =============
            function exportTableToCSV() {
                const table = document.getElementById('applicationsTable');
                let csv = [];

                // Get headers
                const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent);
                csv.push(headers.join(','));

                // Get all rows data
                allApplications.forEach(app => {
                    const row = [
                        `"${app.id}"`,
                        `"${app.name}"`,
                        `"${app.division}"`,
                        `"${app.category}"`,
                        `"${app.amount}"`,
                        `"${app.status}"`,
                        `"${formatDate(app.date)}"`
                    ];
                    csv.push(row.join(','));
                });

                // Download
                const csvContent = csv.join('\n');
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `housing_board_applications_${new Date().toISOString().split('T')[0]}.csv`;
                a.click();

                showToast('Export Successful', 'Applications exported to CSV', 'success');
            }

            function exportTableToPDF() {
                showToast('Generating PDF', 'Please wait while we generate the report...', 'info');

                // Simulate PDF generation
                setTimeout(() => {
                    // In a real application, you would use a library like jsPDF or html2pdf
                    const a = document.createElement('a');
                    a.href = '#';
                    a.download = `housing_board_report_${new Date().toISOString().split('T')[0]}.pdf`;
                    a.click();

                    showToast('PDF Ready', 'Download started successfully', 'success');
                }, 1500);
            }

            function printTable() {
                const printWindow = window.open('', '', 'height=700,width=900');
                const tableHtml = document.getElementById('applicationsTable').outerHTML;

                printWindow.document.write('<html><head><title>Housing Board Applications Report</title>');
                printWindow.document.write('<style>');
                printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
                printWindow.document.write('h1 { color: #1c336e; margin-bottom: 20px; }');
                printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
                printWindow.document.write('th { background-color: #1c336e; color: white; padding: 10px; text-align: left; }');
                printWindow.document.write('td { border: 1px solid #ddd; padding: 8px; }');
                printWindow.document.write('.status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }');
                printWindow.document.write('.approved { background-color: #d1fae5; color: #065f46; }');
                printWindow.document.write('.pending { background-color: #fef3c7; color: #92400e; }');
                printWindow.document.write('.rejected { background-color: #fee2e2; color: #991b1b; }');
                printWindow.document.write('</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h1><i class="fas fa-building"></i> Housing Board Applications Report</h1>');
                printWindow.document.write('<p>Generated on: ' + new Date().toLocaleDateString('en-IN') + '</p>');
                printWindow.document.write('<p>Total Applications: ' + allApplications.length + '</p>');
                printWindow.document.write(tableHtml);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();

                showToast('Print Dialog', 'Opening print dialog...', 'info');
            }

            // ============= UTILITY FUNCTIONS =============
            function viewApplication(appId) {
                showToast('Loading Application', `Opening application ${appId}...`, 'info');
                // In real implementation, this would navigate to the application detail page
                setTimeout(() => {
                    // Simulate navigation
                    console.log(`Viewing application: ${appId}`);
                    // You would typically do: setActiveMenu(event, 'application-detail', appId);
                }, 300);
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function (event) {
                // Ctrl+F for filter
                if (event.ctrlKey && event.key === 'f') {
                    event.preventDefault();
                }
                // Ctrl+P for print
                if (event.ctrlKey && event.key === 'p') {
                    event.preventDefault();
                    printTable();
                }
                // Ctrl+S for export CSV
                if (event.ctrlKey && event.key === 's') {
                    event.preventDefault();
                    exportTableToCSV();
                }
            });


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