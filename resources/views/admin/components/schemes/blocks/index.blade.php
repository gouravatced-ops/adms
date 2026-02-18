@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Scheme Master / List Scheme Blocks</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">

                <h5 class="mb-0 text-white">
                    List Scheme Blocks
                </h5>

                <a href="{{ route('admin.schemes.blocks.add.page', [
                    'schemeId' => $schemeId,
                ]) }}"
                    class="btn btn-light btn-sm">
                    <i class="bx bx-plus"></i> Add Blocks
                </a>

            </div>
            <div class="card-body mt-2">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @php
                    $scheme = $schemes->first();
                    $blocks = $scheme->blocks ?? collect([]);
                    $existingBlockCount = $blocks->count();
                @endphp

                <!-- Scheme Information Display -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Scheme Name</label>
                                        <p class="form-control-plaintext">{{ $scheme->scheme_name }} <span class="text-danger" style="font-weight:bold;">({{ $scheme->propertyType->name }})</span></p>
                                        @if ($scheme->scheme_name_hindi)
                                            <span class="krutidev text-success"
                                                style="font-size:20px; font-weight:bold;">{{ $scheme->scheme_name_hindi }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Scheme Code</label>
                                        <p class="form-control-plaintext">{{ $scheme->scheme_code }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Scheme Value</label>
                                        <p class="form-control-plaintext">₹{{ number_format($scheme->scheme_value, 2) }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-bold">Total Units</label>
                                        <p class="form-control-plaintext">{{ $scheme->total_units }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing Blocks Table -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-white">
                                    <i class="bx bx-list-ul me-2"></i>Existing Blocks ({{ $existingBlockCount }}/10)
                                </h5>
                                <span class="badge bg-light text-primary">{{ 10 - $existingBlockCount }} slots
                                    remaining</span>
                            </div>
                            <div class="card-body p-0   ">
                                @if ($blocks->isEmpty())
                                    <div class="alert alert-warning mb-0">
                                        <i class="bx bx-error-circle me-2"></i>
                                        No blocks found for this scheme. Please add blocks using the "Add New Block" form
                                        below.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Block Name</th>
                                                    <th>Area (sq.ft.)</th>
                                                    <th>Dimensions</th>
                                                    <th>Boundary Dimensions</th>
                                                    <th>Land Share</th>
                                                    <th>Total Buildup</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($blocks as $index => $block)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $block->block_name }}</td>
                                                        <td>{{ $block->area_sqft }}</td>
                                                        <td>
                                                            <span class="badge bg-primary">E:
                                                                {{ $block->dimension_east ?? 0 }}</span>
                                                            <span class="badge bg-success">W:
                                                                {{ $block->dimension_west ?? 0 }}</span>
                                                            <span class="badge bg-warning text-dark">N:
                                                                {{ $block->dimension_north ?? 0 }}</span>
                                                            <span class="badge bg-danger">S:
                                                                {{ $block->dimension_south ?? 0 }}</span>
                                                        </td>

                                                        <td>
                                                            <span class="badge bg-primary">
                                                                E/W-N: {{ $block->arm_east_west_north ?? 0 }}
                                                            </span>

                                                            <span class="badge bg-success">
                                                                E/W-S: {{ $block->arm_east_west_south ?? 0 }}
                                                            </span>

                                                            <span class="badge bg-warning text-dark">
                                                                N/S-E: {{ $block->arm_north_south_east ?? 0 }}
                                                            </span>

                                                            <span class="badge bg-danger">
                                                                N/S-W: {{ $block->arm_north_south_west ?? 0 }}
                                                            </span>
                                                        </td>

                                                        <td>{{ $block->undivided_land_share ?? 'N/A' }}</td>
                                                        <td>{{ $block->total_buildup ?? 'N/A' }}</td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary edit-block-btn"
                                                                data-block-id="{{ $block->id }}"
                                                                data-block-name="{{ $block->block_name }}"
                                                                data-area-sqft="{{ $block->area_sqft }}"
                                                                data-property-type="{{ $block->scheme_property_type }}"
                                                                data-undivided-share="{{ $block->undivided_land_share }}"
                                                                data-total-buildup="{{ $block->total_buildup }}"
                                                                data-construction-area="{{ $block->total_area_of_construction }}"
                                                                data-dim-east="{{ $block->dimension_east }}"
                                                                data-dim-west="{{ $block->dimension_west }}"
                                                                data-dim-north="{{ $block->dimension_north }}"
                                                                data-dim-south="{{ $block->dimension_south }}"
                                                                data-arm-ew-north="{{ $block->arm_east_west_north }}"
                                                                data-arm-ew-south="{{ $block->arm_east_west_south }}"
                                                                data-arm-ns-east="{{ $block->arm_north_south_east }}"
                                                                data-arm-ns-west="{{ $block->arm_north_south_west }}">
                                                                <i class="bx bx-edit"></i> Edit
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger delete-block-btn"
                                                                data-block-id="{{ $block->id }}"
                                                                data-block-name="{{ $block->block_name }}"
                                                                {{ $blocks->count() <= 1 ? 'disabled' : '' }}>
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Block Form (Hidden by default) -->
                <div class="row mb-4" id="editBlockFormContainer" style="display: none;">
                    <div class="col-md-12">
                        <div class="card border-warning">
                            <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-white">
                                    <i class="bx bx-edit-alt me-2"></i>Edit Block: <span id="editBlockNameDisplay"></span>
                                </h5>
                                <button type="button" class="btn btn-sm btn-light" id="cancelEdit">
                                    <i class="bx bx-x"></i> Cancel
                                </button>
                            </div>
                            <div class="card-body mt-2 shadow-sm">
                                <form id="editBlockForm" method="POST" action="{{ route('admin.schemes.blocks.individual.update') }}">
                                    @csrf

                                    <input type="hidden" name="edit_block_id" id="edit_block_id">
                                    <input type="hidden" name="scheme_id" value="{{ $scheme->id }}">

                                    <div class="row g-3">
                                        <!-- Block Name Input -->
                                        <div class="col-md-4">
                                            <label class="form-label">Block Name <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_block_name"
                                                name="edit_block[name]" placeholder="Enter block name" required>
                                        </div>

                                        <!-- Area Square Feet -->
                                        <div class="col-md-4">
                                            <label class="form-label">Area (Sq. Ft.) <small
                                                    class="text-danger">*</small></label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control"
                                                    id="edit_area_sqft" name="edit_block[area_sqft]"
                                                    placeholder="Enter area" min="1" required>
                                                <span class="input-group-text">sq. ft.</span>
                                            </div>
                                        </div>

                                        <!-- Property Type -->
                                        <div class="col-md-4">
                                            <label class="form-label">Property Type</label>
                                            <input type="text" class="form-control bg-light" id="edit_property_type"
                                                readonly>
                                            <input type="hidden" name="edit_block[property_type]"
                                                id="edit_property_type_hidden">
                                        </div>

                                        <!-- Property Specific Fields -->
                                        <div class="col-12 property-specific-fields" id="edit-property-fields"></div>

                                        <!-- Dimensions Section -->
                                        <div class="col-12 mt-3">
                                            <h6 class="border-bottom pb-2" style="color: #0d6efd;">
                                                <i class="bx bx-ruler me-2"></i>Dimensions
                                            </h6>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">East Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_dim_east"
                                                name="edit_block[dimensions][east]" placeholder="e.g., 30 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">West Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_dim_west"
                                                name="edit_block[dimensions][west]" placeholder="e.g., 30 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">North Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_dim_north"
                                                name="edit_block[dimensions][north]" placeholder="e.g., 40 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">South Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_dim_south"
                                                name="edit_block[dimensions][south]" placeholder="e.g., 40 ft" required>
                                        </div>

                                        <!-- Boundary Measurements Section -->
                                        <div class="col-12 mt-3">
                                            <h6 class="border-bottom pb-2" style="color: #0d6efd;">
                                                <i class="bx bx-git-compare me-2"></i>Boundary Measurements
                                            </h6>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">East-West (North Side) <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_arm_ew_north"
                                                name="edit_block[arms][east_west_north]" placeholder="e.g., 4 ft"
                                                required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">East-West (South Side) <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_arm_ew_south"
                                                name="edit_block[arms][east_west_south]" placeholder="e.g., 4 ft"
                                                required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">North-South (East Side) <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_arm_ns_east"
                                                name="edit_block[arms][north_south_east]" placeholder="e.g., 4 ft"
                                                required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">North-South (West Side) <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_arm_ns_west"
                                                name="edit_block[arms][north_south_west]" placeholder="e.g., 4 ft"
                                                required>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="bx bx-save me-1"></i> Update Block
                                            </button>
                                            <button type="button" class="btn btn-secondary" id="cancelEditBtn">
                                                <i class="bx bx-x me-1"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="row mt-4">
                    <div class="col-12 d-flex gap-2">
                        <a href="{{ route('admin.schemes.index') }}" class="btn btn-outline-danger">
                            <i class="bx bx-arrow-back me-1"></i> Back to Schemes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Block Form (Hidden) -->
    <form id="deleteBlockForm" method="POST" style="display: none;">
        @csrf
    </form>

    <style>
        .input-group-text {
            background-color: #f8f9fa;
        }

        .krutidev {
            font-family: 'Krutidev', 'Arial', sans-serif;
            font-size: 14px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .card-header {
            font-weight: 600;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editFormContainer = document.getElementById('editBlockFormContainer');
            const editBlockForm = document.getElementById('editBlockForm');
            const deleteBlockForm = document.getElementById('deleteBlockForm');

            // Edit button click
            document.querySelectorAll('.edit-block-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Populate edit form with block data
                    document.getElementById('edit_block_id').value = this.dataset.blockId;
                    document.getElementById('edit_block_name').value = this.dataset.blockName;
                    document.getElementById('edit_area_sqft').value = this.dataset.areaSqft;
                    document.getElementById('edit_property_type').value = this.dataset.propertyType;
                    document.getElementById('edit_property_type_hidden').value = this.dataset
                        .propertyType;

                    // Dimensions
                    document.getElementById('edit_dim_east').value = this.dataset.dimEast;
                    document.getElementById('edit_dim_west').value = this.dataset.dimWest;
                    document.getElementById('edit_dim_north').value = this.dataset.dimNorth;
                    document.getElementById('edit_dim_south').value = this.dataset.dimSouth;

                    // Arms
                    document.getElementById('edit_arm_ew_north').value = this.dataset.armEwNorth;
                    document.getElementById('edit_arm_ew_south').value = this.dataset.armEwSouth;
                    document.getElementById('edit_arm_ns_east').value = this.dataset.armNsEast;
                    document.getElementById('edit_arm_ns_west').value = this.dataset.armNsWest;

                    // Property specific fields
                    const propertyType = this.dataset.propertyType.toLowerCase();
                    const propFieldsContainer = document.getElementById('edit-property-fields');

                    let propHtml = '';
                    if (propertyType.includes('flat') || propertyType.includes('apartment')) {
                        propHtml = `
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Undivided Land Share <small class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" 
                                            name="edit_block[undivided_land_share]" 
                                            value="${this.dataset.undividedShare || ''}"
                                            placeholder="e.g., 100 sq ft">
                                        <span class="input-group-text">sq. ft.</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Total Buildup Area <small class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" 
                                            name="edit_block[total_buildup]" 
                                            value="${this.dataset.totalBuildup || ''}"
                                            placeholder="e.g., 1500 sq ft">
                                        <span class="input-group-text">sq. ft.</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    propFieldsContainer.innerHTML = propHtml;

                    // Show edit form
                    editFormContainer.style.display = 'block';

                    // Scroll to edit form
                    editFormContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // Delete button click
            document.querySelectorAll('.delete-block-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.disabled) return;

                    const blockId = this.dataset.blockId;
                    const blockName = this.dataset.blockName;

                    if (confirm(`Are you sure you want to delete block "${blockName}"?`)) {
                        deleteBlockForm.action = `{{ url('admin/schemes/blocks/delete/') }}/${blockId}`;
                        deleteBlockForm.submit();
                    }
                });
            });

            // Cancel edit
            function cancelEdit() {
                editFormContainer.style.display = 'none';
                document.getElementById('editBlockForm').reset();
            }

            document.getElementById('cancelEdit').addEventListener('click', cancelEdit);
            document.getElementById('cancelEditBtn').addEventListener('click', cancelEdit);

            // Form validation for add block
            document.getElementById('addBlockForm')?.addEventListener('submit', function(e) {
                const requiredInputs = this.querySelectorAll('[required]');
                let valid = true;
                let firstInvalid = null;

                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        valid = false;
                        input.classList.add('is-invalid');
                        if (!firstInvalid) firstInvalid = input;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Please fill all required fields');
                    if (firstInvalid) firstInvalid.focus();
                }
            });

            // Form validation for edit block
            editBlockForm.addEventListener('submit', function(e) {
                const requiredInputs = this.querySelectorAll('[required]');
                let valid = true;
                let firstInvalid = null;

                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        valid = false;
                        input.classList.add('is-invalid');
                        if (!firstInvalid) firstInvalid = input;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Please fill all required fields');
                    if (firstInvalid) firstInvalid.focus();
                }
            });
        });
    </script>
@endsection
