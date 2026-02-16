@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Scheme Master / Add Scheme Block</span>
        </h6>
        @php
            $scheme = $schemes->first();
            $blocks = $scheme->blocks ?? collect([]);
            $existingBlockCount = $blocks->count();
        @endphp
        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Add Scheme Block <span>
                ({{ $existingBlockCount + 1 }})</span></h5> 
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

                <!-- Add New Block Form -->
                @if ($existingBlockCount < 10)
                    <form action="{{ route('admin.schemes.blocks.individual.store') }}" method="POST" class="row g-3"
                        id="addBlockForm">
                        @csrf

                        <input type="hidden" name="scheme_id" value="{{ $scheme->scheme_id }}">
                        <input type="hidden" name="scheme_property_type" value="{{ $scheme->propertyType->name }}">

                        <div class="row g-3">
                            <!-- Block Name Input -->
                            <div class="col-md-4">
                                <label class="form-label">Block Name <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[name]"
                                    placeholder="Enter block name" value="Block {{ $existingBlockCount + 1 }}" required>
                            </div>

                            <!-- Area Square Feet -->
                            <div class="col-md-4">
                                <label class="form-label">Area (Sq. Ft.) <small class="text-danger">*</small></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="new_block[area_sqft]"
                                        placeholder="Enter area" min="1" required>
                                    <span class="input-group-text">sq. ft.</span>
                                </div>
                            </div>

                            <!-- Property Type -->
                            <div class="col-md-4">
                                <label class="form-label">Property Type</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $scheme->propertyType->name }}" readonly>
                            </div>

                            <!-- Property Specific Fields -->
                            <div class="col-12 property-specific-fields" id="add-property-fields">
                                @php
                                    $propertyType = $scheme->propertyType->name;
                                @endphp

                                @if (str_contains($propertyType, 'flat') || str_contains($propertyType, 'Flat'))
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Undivided Land Share <small
                                                    class="text-danger">*</small></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    name="new_block[undivided_land_share]" placeholder="e.g., 100 sq ft">
                                                <span class="input-group-text">sq. ft.</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Total Buildup Area <small
                                                    class="text-danger">*</small></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="new_block[total_buildup]"
                                                    placeholder="e.g., 1500 sq ft">
                                                <span class="input-group-text">sq. ft.</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (str_contains($propertyType, 'House') || str_contains($propertyType, 'house'))
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Total Area of Construction<small
                                                    class="text-danger">*</small></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    name="new_block[total_construction_area]" placeholder="e.g., 100 sq ft">
                                                <span class="input-group-text">sq. ft.</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Total Buildup Area <small
                                                    class="text-danger">*</small></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="new_block[total_buildup]"
                                                    placeholder="e.g., 1500 sq ft">
                                                <span class="input-group-text">sq. ft.</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Dimensions Section -->
                            <div class="col-12 mt-3">
                                <h6 class="border-bottom pb-2" style="color: #0d6efd;">
                                    <i class="bx bx-ruler me-2"></i>Dimensions
                                </h6>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">East Side <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[dimensions][east]"
                                    placeholder="e.g., 30 ft" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">West Side <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[dimensions][west]"
                                    placeholder="e.g., 30 ft" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">North Side <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[dimensions][north]"
                                    placeholder="e.g., 40 ft" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">South Side <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[dimensions][south]"
                                    placeholder="e.g., 40 ft" required>
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
                                <input type="text" class="form-control" name="new_block[arms][east_west_north]"
                                    value="4 ft" placeholder="e.g., 4 ft" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">East-West (South Side) <small
                                        class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[arms][east_west_south]"
                                    value="4 ft" placeholder="e.g., 4 ft" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">North-South (East Side) <small
                                        class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[arms][north_south_east]"
                                    value="4 ft" placeholder="e.g., 4 ft" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">North-South (West Side) <small
                                        class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="new_block[arms][north_south_west]"
                                    value="4 ft" placeholder="e.g., 4 ft" required>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="bx bx-save me-1"></i> Add Block
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning mt-3">
                        <i class="bx bx-error-circle me-2"></i>
                        Maximum blocks limit (10) reached. Cannot add more blocks.
                    </div>
                    <span>Maximum blocks limit (10) reached. Cannot add more blocks.</span>
                @endif

                <!-- ACTION BUTTONS -->
                <div class="row mt-4">
                    <div class="col-12 d-flex gap-2">
                        <a href="{{ route('admin.schemes.blocks.manage', ['schemeId' => $schemeId]) }}"
                            class="btn btn-outline-danger">
                            <i class="bx bx-arrow-back me-1"></i> Back to Schemes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        deleteBlockForm.action = `{{ url('admin/schemes/blocks') }}/${blockId}`;
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
