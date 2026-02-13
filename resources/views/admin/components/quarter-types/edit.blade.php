@extends('admin.layouts.main')

@section('admin-content')
<div class="container-xxl flex-grow-1">
    <h6 class="py-3 mb-2">
        <span class="invert-text-white">
            <a href="{{ route('admin.quarter-types.index') }}">Dashboard / Quarter Types</a> / Edit
            Quarter
        </span>
    </h6>

    <div class="card mb-4">
        <h5 class="card-header text-white bg-info">
            <i class="bx bx-edit me-2"></i>Edit Quarter Type
        </h5>
        <div class="card-body mt-2">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bx bx-error-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bx bx-error-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('admin.quarter-types.update', $quarterType->quarter_id) }}" method="POST"
                class="row g-3 align-items-end">
                @csrf
                @method('PUT')

                <!-- Quarter Code -->
                <div class="col-md-6">
                    <label for="quarter_code" class="form-label">
                        Quarter Code <small class="text-danger">*</small>
                    </label>
                    <input type="text" class="form-control @error('quarter_code') is-invalid @enderror"
                        id="quarter_code" name="quarter_code"
                        value="{{ old('quarter_code', $quarterType->quarter_code) }}"
                        placeholder="e.g., HIG, LIG, MIG, EWS" required maxlength="10">
                    @error('quarter_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Unique code for quarter type (max 10 characters)</small>
                </div>

                <!-- Quarter Name -->
                <div class="col-md-6">
                    <label for="quarter_name" class="form-label">
                        Quarter Name <small class="text-danger">*</small>
                    </label>
                    <input type="text" class="form-control @error('quarter_name') is-invalid @enderror"
                        id="quarter_name" name="quarter_name"
                        value="{{ old('quarter_name', $quarterType->quarter_name) }}"
                        placeholder="e.g., High Income Group" required maxlength="100">
                    @error('quarter_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">FUll Name Of Quarter</small>
                </div>

                <!-- Quarter Full Name -->
                <div class="col-md-6">
                    <label for="quarter_full_name" class="form-label">
                        Full Description
                    </label>
                    <input type="text" class="form-control @error('quarter_full_name') is-invalid @enderror"
                        id="quarter_full_name" name="quarter_full_name"
                        value="{{ old('quarter_full_name', $quarterType->quarter_full_name) }}"
                        placeholder="e.g., High Income Group Quarters" maxlength="200">
                    @error('quarter_full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Optional detailed description</small>
                </div>

                <!-- Display Order -->
                <div class="col-md-6">
                    <label for="display_order" class="form-label">
                        Display Order
                    </label>
                    <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                        id="display_order" name="display_order"
                        value="{{ old('display_order', $quarterType->display_order) }}" placeholder="e.g., 1, 2, 3..."
                        min="0" step="1">
                    @error('display_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Lower numbers appear first</small>
                </div>

                <!-- Minimum Income -->
                <div class="col-md-6">
                    <label for="min_income" class="form-label">
                        Minimum Income (in lakhs)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number" class="form-control @error('min_income') is-invalid @enderror"
                            id="min_income" name="min_income" value="{{ old('min_income', $quarterType->min_income) }}"
                            placeholder="e.g., 3.00" min="0" step="0.01">
                        <span class="input-group-text">Lakhs</span>
                    </div>
                    @error('min_income')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Leave empty for no minimum limit</small>
                </div>

                <!-- Maximum Income -->
                <div class="col-md-6">
                    <label for="max_income" class="form-label">
                        Maximum Income (in lakhs)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number" class="form-control @error('max_income') is-invalid @enderror"
                            id="max_income" name="max_income" value="{{ old('max_income', $quarterType->max_income) }}"
                            placeholder="e.g., 6.00" min="0" step="0.01">
                        <span class="input-group-text">Lakhs</span>
                    </div>
                    @error('max_income')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Leave empty for no maximum limit</small>
                </div>


                <!-- Income Range Helper -->
                <div class="col-12">
                    <div class="card border-info">
                        <div class="card-header bg-info bg-opacity-10 py-2">
                            <h6 class="mb-0 text-info">
                                <i class="bi bi-info-circle me-1"></i> Income Range Examples
                            </h6>
                        </div>
                        <div class="card-body py-2">
                            <div class="row small text-muted">
                                <div class="col-md-3">
                                    <strong>EWS:</strong> Max: 3.00
                                </div>
                                <div class="col-md-3">
                                    <strong>LIG:</strong> Min: 3.00, Max: 6.00
                                </div>
                                <div class="col-md-3">
                                    <strong>MIG:</strong> Min: 6.00, Max: 12.00
                                </div>
                                <div class="col-md-3">
                                    <strong>HIG:</strong> Min: 12.00
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label for="status" class="form-label">
                        Status <small class="text-danger">*</small>
                    </label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="1" {{ old('status', $quarterType->status) == 1 ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ old('status', $quarterType->status) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Readonly Fields -->
                <div class="col-md-6">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Created On</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $quarterType->created_at->format('d M Y, h:i A') }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $quarterType->updated_at->format('d M Y, h:i A') }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="col-12 d-flex gap-2 pt-3 border-top">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>
                        Update Quarter Type
                    </button>

                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bx bx-reset me-1"></i>
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
                // Income range validation
                const minIncome = document.getElementById('min_income');
                const maxIncome = document.getElementById('max_income');

                function validateIncomeRange() {
                    if (minIncome.value && maxIncome.value) {
                        const min = parseFloat(minIncome.value);
                        const max = parseFloat(maxIncome.value);

                        if (min >= max) {
                            maxIncome.setCustomValidity('Maximum income must be greater than minimum income');
                            maxIncome.classList.add('is-invalid');
                            document.querySelector('button[type="submit"]').disabled = true;
                        } else {
                            maxIncome.setCustomValidity('');
                            maxIncome.classList.remove('is-invalid');
                            document.querySelector('button[type="submit"]').disabled = false;
                        }
                    } else {
                        maxIncome.setCustomValidity('');
                        maxIncome.classList.remove('is-invalid');
                        document.querySelector('button[type="submit"]').disabled = false;
                    }
                }

                if (minIncome && maxIncome) {
                    minIncome.addEventListener('change', validateIncomeRange);
                    maxIncome.addEventListener('change', validateIncomeRange);
                    minIncome.addEventListener('input', validateIncomeRange);
                    maxIncome.addEventListener('input', validateIncomeRange);
                }

                // Auto-suggest based on quarter code
                const quarterCode = document.getElementById('quarter_code');
                const quarterName = document.getElementById('quarter_name');
                const quarterFullName = document.getElementById('quarter_full_name');

                if (quarterCode && quarterName) {
                    quarterCode.addEventListener('blur', function() {
                        const code = this.value.toUpperCase();
                        if (code && !quarterName.value) {
                            switch (code) {
                                case 'EWS':
                                    quarterName.value = 'Economically Weaker Section';
                                    quarterFullName.value = quarterFullName.value ||
                                        'Economically Weaker Section Quarters';
                                    break;
                                case 'LIG':
                                    quarterName.value = 'Low Income Group';
                                    quarterFullName.value = quarterFullName.value ||
                                    'Low Income Group Quarters';
                                    break;
                                case 'MIG':
                                    quarterName.value = 'Middle Income Group';
                                    quarterFullName.value = quarterFullName.value ||
                                        'Middle Income Group Quarters';
                                    break;
                                case 'HIG':
                                    quarterName.value = 'High Income Group';
                                    quarterFullName.value = quarterFullName.value ||
                                        'High Income Group Quarters';
                                    break;
                            }
                        }
                    });
                }

                // Form submission confirmation
                const form = document.querySelector('form');
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to update this quarter type?')) {
                        e.preventDefault();
                    }
                });
            });
</script>

<style>
    .form-label small.text-danger {
        font-size: 0.875em;
    }

    .input-group-text {
        background-color: #f8f9fa;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .card.border-info {
        border-left: 4px solid #0dcaf0 !important;
    }
</style>
@endpush
@endsection