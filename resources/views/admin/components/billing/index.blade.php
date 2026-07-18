@extends('admin.layouts.main')
@section('admin-content')
    <div class="container-xxl flex-grow-1">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center py-3 mb-3">
            <h5 class="mb-0 text-dark fw-semibold">
                Dashboard / INDBNK Billing
            </h5>
            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#generateBillModal">
                <i class="bx bx-receipt me-1"></i>
                Generate Bank Bill
            </button>
        </div>

        <div class="card-body">
            {{-- Stats --}}
            @php
                $totalAllottee = $totalAllottee;
                $lastGenerated = $generatedAllottee;
                $nextStart = $nextStart;
                $remaining = $remainingAllottee;
            @endphp
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-primary text-white shadow-sm h-100">
                        <div class="card-body">
                            <div class="small text-uppercase">
                                Total Allottee
                            </div>
                            <h3 class="mb-0 fw-bold text-white">
                                {{ $totalAllottee }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-success text-white shadow-sm h-100">
                        <div class="card-body">
                            <div class="small text-uppercase">
                                Generated Bills
                            </div>
                            <h3 class="mb-0 fw-bold text-white">
                                {{ $lastGenerated }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-warning text-white shadow-sm h-100">
                        <div class="card-body">
                            <div class="small text-uppercase">
                                Next Start
                            </div>
                            <h3 class="mb-0 fw-bold text-white">
                                {{ $nextStart }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-danger text-white shadow-sm h-100">
                        <div class="card-body">
                            <div class="small text-uppercase">
                                Remaining Files
                            </div>
                            <h3 class="mb-0 fw-bold text-white">
                                {{ $remaining }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">
                    Allottee Billing Management
                </h5>
            </div>
            {{-- Session Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible m-3 mb-0">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible m-3 mb-0">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="card-body">
                {{-- Billing Table --}}
                <div class="table-responsive">
                    <table id="studentListTable" class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Bill No</th>
                                <th>Start From</th>
                                <th>End At</th>
                                <th>Total Files</th>
                                <th>Generated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($billingList as $key => $bill)
                                <tr>

                                    {{-- Serial No --}}
                                    <td>
                                        {{ $key + 1 }}
                                    </td>

                                    {{-- Bill Number --}}
                                    <td>
                                        <span class="fw-semibold text-primary">
                                            <a href="{{ asset($bill->generated_pdf_path) }}" target="_blank">
                                                {{ $bill->bill_no }}
                                            </a>
                                        </span>
                                    </td>

                                    {{-- Start From --}}
                                    <td>
                                        <span class="fw-bold">
                                            {{ $bill->start_from }}
                                        </span>
                                    </td>

                                    {{-- End At --}}
                                    <td>
                                        <span class="fw-bold">
                                            {{ $bill->end_at }}
                                        </span>
                                    </td>

                                    {{-- Total Files --}}
                                    <td>
                                        <span class="fw-bold text-success">
                                            {{ $bill->total_allottee }}
                                        </span>
                                    </td>

                                    {{-- Generated Date --}}
                                    <td>
                                        {{ \Carbon\Carbon::parse($bill->created_at)->format('d M Y h:i A') }}
                                    </td>

                                    {{-- Action --}}
                                    <td>
                                        <div class="d-flex gap-2">

                                            {{-- Download PDF --}}
                                            @if ($bill->generated_pdf_path)
                                                <a href="{{ asset($bill->generated_pdf_path) }}" target="_blank"
                                                    class="btn btn-sm btn-primary">

                                                    <i class="bx bx-download"></i>
                                                </a>
                                            @endif

                                            {{-- Delete --}}
                                            <form
                                                action="{{ route('admin.indbnk.generate.delete', $bill->encrypted_bill_id) }}"
                                                method="POST" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this billing?')">

                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            No billing records found.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Generate Bill Modal --}}
    <div class="modal fade" id="generateBillModal" tabindex="-1" aria-hidden="true">
        {{-- TOP MODAL FIX --}}
        <div class="modal-dialog modal-lg mt-5">
            <div class="modal-content border-0 shadow-lg">
                {{-- Modal Header --}}
                <div class="modal-header bg-primary p-2">
                    <div>
                        <h5 class="modal-title text-white mb-1">
                            Generate Bank Billing
                        </h5>
                        {{-- <small class="text-white">
                            Generate allottee billing file range for bank
                        </small> --}}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                {{-- Modal Body --}}
                <div class="modal-body p-4">
                    {{-- Statistics Table --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th width="30%" class="bg-light">
                                        Total Allottee Files
                                    </th>
                                    <td>
                                        <span class="badge bg-primary fs-6">
                                            {{ $totalAllottee }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">
                                        Bills Already Generated
                                    </th>
                                    <td>
                                        <span class="badge bg-success fs-6">
                                            {{ $lastGenerated }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">
                                        Billing Start From
                                    </th>
                                    <td>
                                        <span class="badge bg-warning fs-6">
                                            {{ $nextStart }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">
                                        Remaining Allottee Files
                                    </th>
                                    <td>
                                        <span class="badge bg-danger fs-6">
                                            {{ $remaining }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- Form --}}
                    <form action="{{ route('admin.indbnk.generate.bill') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Start Lot --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Start Lot
                                </label>
                                <select name="start_lot" id="start_lot" class="form-select form-select-lg" required>
                                    <option value="">Select Start Lot</option>
                                    @foreach($pendingLots as $lot)
                                        <option value="{{ $lot }}">{{ $lot }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- End Lot --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    End Lot
                                </label>
                                <select name="end_lot" id="end_lot" class="form-select form-select-lg" required>
                                    <option value="">Select End Lot</option>
                                    @foreach($pendingLots as $lot)
                                        <option value="{{ $lot }}">{{ $lot }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Total File --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Number Of Allottee Files
                                </label>
                                <input type="number" name="total_files" id="total_files" class="form-control form-control-lg bg-light"
                                    placeholder="0" readonly required>
                            </div>
                        </div>
                        <input type="hidden" name="start_from" id="start_from" value="{{ $nextStart }}">
                        <input type="hidden" name="end_at" id="end_at" value="{{ $nextStart }}">
                        {{-- Footer --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bx bx-file me-1"></i>
                                Generate Billing
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let startLotInput = document.getElementById('start_lot');
            let endLotInput = document.getElementById('end_lot');
            let totalFilesInput = document.getElementById('total_files');
            let startFromInput = document.getElementById('start_from');
            let endAtInput = document.getElementById('end_at');
            
            let lotData = @json($lotData);
            let pendingLots = @json($pendingLots);
            let nextStart = {{ $nextStart }};

            function calculateTotal() {
                let startLot = startLotInput.value;
                let endLot = endLotInput.value;
                
                if (startLot && endLot) {
                    let startIndex = pendingLots.indexOf(startLot);
                    let endIndex = pendingLots.indexOf(endLot);
                    
                    if (startIndex <= endIndex && startIndex !== -1 && endIndex !== -1) {
                        let total = 0;
                        for (let i = startIndex; i <= endIndex; i++) {
                            let lot = pendingLots[i];
                            total += lotData[lot] || 0;
                        }
                        totalFilesInput.value = total;
                        endAtInput.value = nextStart + total - 1;
                    } else {
                        totalFilesInput.value = 0;
                        endAtInput.value = nextStart;
                    }
                } else {
                    totalFilesInput.value = '';
                    endAtInput.value = nextStart;
                }
            }

            startLotInput.addEventListener('change', function() {
                let startLot = this.value;
                let startIndex = pendingLots.indexOf(startLot);
                
                // Clear current options in end_lot
                endLotInput.innerHTML = '<option value="">Select End Lot</option>';
                
                if (startLot && startIndex !== -1) {
                    // Only add options that are >= startIndex
                    for (let i = startIndex; i < pendingLots.length; i++) {
                        let lot = pendingLots[i];
                        let option = document.createElement('option');
                        option.value = lot;
                        option.textContent = lot;
                        endLotInput.appendChild(option);
                    }
                } else {
                    // If no start lot selected, show all lots
                    for (let i = 0; i < pendingLots.length; i++) {
                        let lot = pendingLots[i];
                        let option = document.createElement('option');
                        option.value = lot;
                        option.textContent = lot;
                        endLotInput.appendChild(option);
                    }
                }
                
                calculateTotal();
            });

            endLotInput.addEventListener('change', calculateTotal);
        });
    </script>
@endsection
