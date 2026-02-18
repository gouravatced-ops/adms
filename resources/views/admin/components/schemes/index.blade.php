@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Scheme Master</span></h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">
                <i class="bx bx-package me-2"></i>Scheme Master
            </h5>
            <div class="card-body mt-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <i class="bx bx-error-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="studentListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Scheme Details</th>
                                <th width="150">Lease Period & Units</th>
                                <th width="200">Financial</th>
                                <th width="100">Status</th>
                                <th width="150">Dates</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            #return getDebugIndex($schemes);
                            ?>
                            @forelse ($schemes as $key => $scheme)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="fw-semibold">{{ $scheme->scheme_name }} (<span
                                                    class="text-danger">{{ $scheme->propertyType->name }}</span>)</strong>
                                            <strong class="fw-semibold krutidev">{{ $scheme->scheme_name_hindi }}</strong>
                                            @if ($scheme->scheme_code)
                                                <small>Code: <span
                                                        class="text-success fw-bold">{{ $scheme->scheme_code }}</span></small>
                                            @endif
                                            <small class="text-muted">Created by:
                                                {{ $scheme->creator->admin_name ?? 'System' }}</small>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column">
                                            <span><i class="bx bx-time me-1"></i>{{ $scheme->lease_period }}
                                                Years </span>
                                            <span><i class="bx bx-buildings me-1"></i>{{ $scheme->total_units }}
                                                units</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong
                                                class="text-primary">₹{{ number_format($scheme->financial->property_total_cost, 2) }}</strong>
                                            <small>Down: ₹{{ number_format($scheme->financial->down_payment_amount, 2) }}
                                                ({{ $scheme->financial->down_payment_percentage }}%)
                                            </small>
                                            <small>EMI: ₹{{ number_format($scheme->financial->emi_without_penalty, 2) }} ×
                                                {{ $scheme->financial->emi_count }}</small>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            {{-- @if ($scheme->status == 'draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @elseif($scheme->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($scheme->status == 'completed')
                                                <span class="badge bg-info">Completed</span>
                                            @elseif($scheme->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif --}}

                                            @if ($scheme->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column">
                                            <small><strong>Start:</strong>
                                                {{ formatDate($scheme->scheme_start_date) }}</small>
                                            @if ($scheme->scheme_end_date)
                                                <small><strong>End:</strong>
                                                    {{ formatDate($scheme->scheme_end_date) }}</small>
                                            @else
                                                <small><strong>End:</strong> —</small>
                                            @endif
                                            <small><strong>Created:</strong>
                                                {{ formatDate($scheme->created_at) }}</small>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">

                                            <a href="{{ route('admin.schemes.blocks.manage', ['schemeId' => $scheme->encoded_id]) }}"
                                                class="btn btn-outline-info btn-sm" title="Add Blocks Types">
                                                <i class="bx bx-building"></i> Blocks
                                            </a>

                                            <a href="{{ route('admin.schemes.edit', $scheme->id) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>

                                            @if ($scheme->is_active)
                                                <form action="{{ route('admin.schemes.destroy', $scheme->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="return confirm('Inactive this scheme?')" title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.schemes.destroy', $scheme->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="return confirm('Active this scheme?')" title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <div class="py-3">
                                            <i class="bx bx-package bx-lg text-muted mb-3"></i>
                                            <h6>No Schemes Found</h6>
                                            <p class="mb-0">Start by adding your first scheme</p>
                                            <a href="{{ route('admin.schemes.create') }}"
                                                class="btn btn-primary btn-sm mt-2">
                                                <i class="bx bx-plus me-1"></i>Add New Scheme
                                            </a>
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

    <!-- Scheme Details Modal -->
    <div class="modal fade" id="schemeDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="bx bx-info-circle me-2"></i>Scheme Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="schemeDetailsContent">
                    <!-- Content will be loaded via AJAX -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="editSchemeBtn" class="btn btn-primary">
                        <i class="bx bx-edit me-1"></i>Edit Scheme
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        </script>

        <style>
            .table td {
                vertical-align: middle;
            }

            .btn-group-sm .btn {
                padding: 0.25rem 0.5rem;
            }

            .dropdown-menu .dropdown-item {
                font-size: 0.875rem;
            }
        </style>
    @endpush
@endsection
