@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / Scheme Master / Add Scheme Blocks</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">
                <i class="bx bx-plus me-2"></i>Add Scheme Blocks
            </h5>
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
                <form action="{{ route('admin.schemes.blocks.create') }}" method="POST" class="row g-3"
                    id="schemeBlockForm">
                    @csrf

                    <!-- Hidden input for selected scheme ID -->
                    <input type="hidden" name="scheme_id" id="selected_scheme_id" value="">

                    <!-- Scheme Selection with Custom Search -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Select Scheme <small class="text-danger">*</small></label>
                        <div class="custom-select-wrapper">
                            <input type="text" class="form-control mb-2" id="schemeSearch"
                                placeholder="Type to search scheme by name, code, or value..." autocomplete="off" autofocus>

                            <div class="custom-options" id="customOptions">
                                @foreach ($schemes as $scheme)
                                    <div class="custom-option" data-value="{{ $scheme->scheme_id }}"
                                        data-property-type="{{ $scheme->property_type_name ?? '' }}"
                                        data-scheme-code="{{ $scheme->scheme_code ?? '' }}"
                                        data-scheme-name="{{ $scheme->scheme_name }}"
                                        data-scheme-hindi="{{ $scheme->scheme_name_hindi ?? '' }}"
                                        data-scheme-value="{{ $scheme->scheme_value ?? '' }}"
                                        data-block-count="{{ $scheme->total_blocks ?? '' }}"
                                        data-search="{{ strtolower(
                                            ($scheme->scheme_name ?? '') .
                                                ' ' .
                                                ($scheme->scheme_name_hindi ?? '') .
                                                ' ' .
                                                ($scheme->scheme_code ?? '') .
                                                ' ' .
                                                ($scheme->scheme_value ?? ''),
                                        ) }}">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="badge bg-secondary me-2">{{ $scheme->scheme_code ?? 'N/A' }}</span>
                                            <div>
                                                <strong>{{ $scheme->scheme_name }}</strong>
                                                @if ($scheme->scheme_name_hindi)
                                                    <span class="krutidev ms-2"
                                                        style="font-size: 16px;">({{ $scheme->scheme_name_hindi }})</span>
                                                @endif
                                                @if ($scheme->scheme_value)
                                                    <span class="badge bg-info ms-2">{{ $scheme->scheme_value }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted mt-1" id="searchResultCount">{{ $schemes->count() }} schemes
                                available</small>
                        </div>
                    </div>

                    <!-- Scheme Property Type (Auto-filled) -->
                    <div class="col-md-12">
                        <label for="scheme_property_type" class="form-label fw-bold">
                            Scheme Property Type <small class="text-danger">*</small>
                        </label>
                        <input type="text"
                            class="form-control bg-light @error('scheme_property_type') is-invalid @enderror"
                            id="scheme_property_type" name="scheme_property_type" value="{{ old('scheme_property_type') }}"
                            placeholder="Select a scheme to auto-fill" readonly>
                        @error('scheme_property_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dynamic Blocks Container -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0" style="color: #1b7504;">
                                <i class="bx bx-layer me-2"></i>Scheme Blocks
                            </h5>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info me-3" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                    <i class="bx bx-cube me-1"></i>
                                    <span id="blockCounter">1 / 10</span>
                                </span>
                            </div>
                        </div>

                        <div id="blocks-container">
                            <!-- Block Type 1 (Default) -->
                            <div class="block-item card border-primary mb-4" data-index="0">
                                <div class="card-header bg-primary py-2 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white">
                                        <i class="bx bx-cube me-2"></i>
                                        Block Name : <span class="block-name-display">Block Type </span>
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-light text-danger remove-block"
                                        style="display: none;" disabled>
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                                <div class="card-body shadow-sm"><br>
                                    <div class="row g-3">
                                        <!-- Block Name Input -->
                                        <div class="col-md-4">
                                            <label class="form-label">Block Name <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control block-name-input"
                                                name="blocks[0][name]" value="Block Type" placeholder="Enter block name"
                                                required>
                                        </div>

                                        <!-- Area Square Feet -->
                                        <div class="col-md-4">
                                            <label class="form-label">Area (Sq. Ft.) <small
                                                    class="text-danger">*</small></label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="blocks[0][area_sqft]"
                                                    placeholder="Enter area" step="0.01" min="1" required>
                                                <span class="input-group-text">sq. ft.</span>
                                            </div>
                                        </div>

                                        <!-- Property Specific Fields Container -->
                                        <div class="col-12 property-specific-fields" id="property-fields-0">
                                            <!-- Dynamic fields will be loaded here based on property type -->
                                        </div>

                                        <!-- Dimensions Section -->
                                        <div class="col-12 mt-3">
                                            <h6 class="border-bottom pb-2" style="color: #0d6efd;">
                                                <i class="bx bx-ruler me-2"></i>Dimensions
                                            </h6>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">East Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="blocks[0][dimensions][east]"
                                                placeholder="e.g., 30 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">West Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="blocks[0][dimensions][west]"
                                                placeholder="e.g., 30 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">North Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control"
                                                name="blocks[0][dimensions][north]" placeholder="e.g., 40 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">South Side <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control"
                                                name="blocks[0][dimensions][south]" placeholder="e.g., 40 ft" required>
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
                                            <input type="text" class="form-control"
                                                name="blocks[0][arms][east_west_north]" value="4 ft"
                                                placeholder="e.g., 4 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">East-West (South Side) <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control"
                                                name="blocks[0][arms][east_west_south]" value="4 ft"
                                                placeholder="e.g., 4 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">North-South (East Side) <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control"
                                                name="blocks[0][arms][north_south_east]" value="4 ft"
                                                placeholder="e.g., 4 ft" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">North-South (West Side) <small
                                                    class="text-danger">*</small></label>
                                            <input type="text" class="form-control"
                                                name="blocks[0][arms][north_south_west]" value="4 ft"
                                                placeholder="e.g., 4 ft" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" class="btn btn-success" id="addMoreBlocks">
                            <i class="bx bx-plus me-1"></i>Add More Block
                        </button>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="col-12 d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Create Scheme Blocks
                        </button>

                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bx bx-reset me-1"></i> Reset
                        </button>

                        <a href="{{ route('admin.schemes.index') }}" class="btn btn-outline-danger ms-auto">
                            <i class="bx bx-x me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Block Template (Hidden) -->
    <template id="block-template">
        <div class="block-item card border-secondary mb-4" data-index="__INDEX__">
            <div class="card-header bg-primary py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white">
                    <i class="bx bx-cube me-2"></i>
                    Block Name : <span class="block-name-display">Block Type __DISPLAY_INDEX__</span>
                </h6>
                <button type="button" class="btn btn-sm btn-light text-danger remove-block">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
            <div class="card-body shadow-sm"><br>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Block Name <small class="text-danger">*</small></label>
                        <input type="text" class="form-control block-name-input" name="blocks[__INDEX__][name]"
                            value="Block Type __DISPLAY_INDEX__" placeholder="Enter block name" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Area (Sq. Ft.) <small class="text-danger">*</small></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="blocks[__INDEX__][area_sqft]"
                                placeholder="Enter area" step="0.01" min="1" required>
                            <span class="input-group-text">sq. ft.</span>
                        </div>
                    </div>

                    <div class="col-12 property-specific-fields" id="property-fields-__INDEX__"></div>

                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2" style="color: #0d6efd;">
                            <i class="bx bx-ruler me-2"></i>Dimensions
                        </h6>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">East Side <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][dimensions][east]"
                            placeholder="e.g., 30 ft" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">West Side <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][dimensions][west]"
                            placeholder="e.g., 30 ft" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">North Side <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][dimensions][north]"
                            placeholder="e.g., 40 ft" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">South Side <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][dimensions][south]"
                            placeholder="e.g., 40 ft" required>
                    </div>

                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2" style="color: #0d6efd;">
                            <i class="bx bx-git-compare me-2"></i>Boundary Measurements
                        </h6>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">East-West (North Side) <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][arms][east_west_north]"
                            value="4 ft" placeholder="e.g., 4 ft" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">East-West (South Side) <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][arms][east_west_south]"
                            value="4 ft" placeholder="e.g., 4 ft" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">North-South (East Side) <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][arms][north_south_east]"
                            value="4 ft" placeholder="e.g., 4 ft" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">North-South (West Side) <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="blocks[__INDEX__][arms][north_south_west]"
                            value="4 ft" placeholder="e.g., 4 ft" required>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <style>
        .input-group-text {
            background-color: #f8f9fa;
        }

        .custom-select-wrapper {
            position: relative;
        }

        #schemeSearch {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        #schemeSearch:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .custom-options {
            border: 1px solid #dee2e6;
            border-top: none;
            max-height: 300px;
            overflow-y: auto;
            background: white;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            position: absolute;
            width: 100%;
            z-index: 1000;
        }

        .custom-options.show {
            display: block;
        }

        .custom-option {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .custom-option:last-child {
            border-bottom: none;
        }

        .custom-option:hover {
            background-color: #e7f1ff;
        }

        .custom-option.selected {
            background-color: #0d6efd;
            color: white;
        }

        .custom-option.selected .badge.bg-secondary {
            background-color: #fff !important;
            color: #0d6efd !important;
        }

        .custom-option.selected .badge.bg-info {
            background-color: #fff !important;
            color: #0d6efd !important;
        }

        .block-item:not(:last-child) {
            margin-bottom: 1.5rem;
        }

        .card-header .btn-light {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .card-header .btn-light:hover {
            background-color: #fff;
        }

        #searchResultCount {
            font-size: 0.85rem;
            padding-left: 5px;
        }

        .krutidev {
            font-family: 'Krutidev', 'Arial', sans-serif;
        }

        /* Add to your existing styles */
        .badge.bg-info {
            transition: all 0.3s ease;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
            transition: all 0.3s ease;
        }

        #blockCounter {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let blockCount = 1; // Will be updated based on selected scheme
            const MAX_BLOCKS = 10; // Maximum blocks limit
            const blocksContainer = document.getElementById('blocks-container');
            const template = document.getElementById('block-template');
            const propertyTypeInput = document.getElementById('scheme_property_type');
            const searchInput = document.getElementById('schemeSearch');
            const customOptions = document.getElementById('customOptions');
            const selectedSchemeId = document.getElementById('selected_scheme_id');
            const resultCountSpan = document.getElementById('searchResultCount');
            const addMoreBtn = document.getElementById('addMoreBlocks');
            const blockCounter = document.getElementById('blockCounter');

            let selectedOption = null;
            let schemes = [];

            // Initialize schemes data from PHP with block counts
            @foreach ($schemes as $scheme)
                schemes.push({
                    id: '{{ $scheme->scheme_id }}',
                    propertyType: '{{ $scheme->property_type_name ?? '' }}',
                    blockCount: {{ $scheme->total_blocks ?? 0 }},
                    searchText: `{{ strtolower(
                        ($scheme->scheme_name ?? '') .
                            ' ' .
                            ($scheme->scheme_name_hindi ?? '') .
                            ' ' .
                            ($scheme->scheme_code ?? '') .
                            ' ' .
                            ($scheme->scheme_value ?? ''),
                    ) }}`,
                    displayHtml: `{{ addslashes(
                        '<div class="d-flex align-items-center">' .
                            '<span class="badge bg-secondary me-2">' .
                            ($scheme->scheme_code ?? 'N/A') .
                            '</span>' .
                            '<div><strong>' .
                            ($scheme->scheme_name ?? '') .
                            '</strong>' .
                            ($scheme->scheme_name_hindi
                                ? '<span class=\"krutidev ms-2\" style=\"font-size: 20px;\">(' . $scheme->scheme_name_hindi . ')</span>'
                                : '') .
                            ($scheme->scheme_value ? '<span class=\"badge bg-info ms-2\">' . $scheme->scheme_value . '</span>' : '') .
                            '</div>' .
                            '<small class=\"ms-3 text-muted\">Blocks: ' .
                            ($scheme->total_blocks ?? 0) .
                            '</small>' .
                            '</div>',
                    ) }}`
                });
            @endforeach

            // Function to calculate default blocks based on total_blocks
            function calculateDefaultBlocks(totalBlocksFromDb) {
                if (totalBlocksFromDb === 2) {
                    return 3; // This means default index 3 (3 blocks total)
                } else if (totalBlocksFromDb === 0) {
                    return 1; // This means default index 1 (1 block total)
                } else {
                    return totalBlocksFromDb + 1; // For any other value, add 1
                }
            }

            // Function to initialize blocks based on scheme's existing block count
            function initializeSchemeBlocks(blockCountFromDb) {
                // Calculate default blocks based on total_blocks
                const defaultBlocks = calculateDefaultBlocks(blockCountFromDb);

                // Clear existing blocks except the first one
                const existingBlocks = document.querySelectorAll('.block-item');
                existingBlocks.forEach((block, index) => {
                    if (index > 0) {
                        block.remove();
                    }
                });

                // Set blockCount to the calculated default value
                blockCount = defaultBlocks;

                // Update UI
                updateRemoveButtons();
                updateAddMoreButtonState();

                // Log for debugging (optional)
                console.log(`Scheme has ${blockCountFromDb} existing blocks, setting default to ${defaultBlocks} blocks`);
            }

            // Rest of your existing functions remain the same...
            function updateBlockCounter() {
                blockCounter.textContent = blockCount + ' / ' + MAX_BLOCKS;

                // Optional: Change color when approaching limit
                if (blockCount >= MAX_BLOCKS) {
                    blockCounter.closest('.badge').classList.remove('bg-info');
                    blockCounter.closest('.badge').classList.add('bg-warning');
                } else if (blockCount >= MAX_BLOCKS - 2) {
                    blockCounter.closest('.badge').classList.remove('bg-info', 'bg-warning');
                    blockCounter.closest('.badge').classList.add('bg-warning');
                } else {
                    blockCounter.closest('.badge').classList.remove('bg-warning');
                    blockCounter.closest('.badge').classList.add('bg-info');
                }
            }

            // Function to update add more button state
            function updateAddMoreButtonState() {
                if (blockCount >= MAX_BLOCKS) {
                    addMoreBtn.disabled = true;
                    addMoreBtn.classList.add('disabled');
                    addMoreBtn.title = 'Maximum ' + MAX_BLOCKS + ' blocks allowed';

                    // Optional: Show a warning indicator
                    if (!document.getElementById('block-limit-warning')) {
                        const warning = document.createElement('div');
                        warning.id = 'block-limit-warning';
                        warning.className = 'alert alert-warning mt-2 py-2';
                        warning.innerHTML = '<i class="bx bx-info-circle me-2"></i>Maximum ' + MAX_BLOCKS +
                            ' blocks have been added. Cannot add more.';

                        // Insert after the add more button container
                        const btnContainer = addMoreBtn.closest('.d-flex');
                        if (btnContainer) {
                            btnContainer.parentNode.insertBefore(warning, btnContainer.nextSibling);
                        }
                    }
                } else {
                    addMoreBtn.disabled = false;
                    addMoreBtn.classList.remove('disabled');
                    addMoreBtn.title = 'Add more blocks (Max ' + MAX_BLOCKS + ')';

                    // Remove warning if exists
                    const warning = document.getElementById('block-limit-warning');
                    if (warning) {
                        warning.remove();
                    }
                }

                // Update counter
                updateBlockCounter();
            }

            // Function to add a new block
            function addNewBlock(index) {
                const displayIndex = index + 1;

                let newBlock = template.innerHTML.replace(/__INDEX__/g, index);
                newBlock = newBlock.replace(/__DISPLAY_INDEX__/g, displayIndex);

                // Set default values if needed
                newBlock = newBlock.replace(/value="Block Type __DISPLAY_INDEX__"/g, 'value="Block Type ' +
                    displayIndex + '"');

                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newBlock;
                const blockElement = tempDiv.firstElementChild;

                blocksContainer.appendChild(blockElement);

                // Update property fields if scheme is selected
                if (selectedSchemeId.value) {
                    updatePropertyFields(blockElement, propertyTypeInput.value, index);
                }
            }

            // Toggle options dropdown
            searchInput.addEventListener('focus', function() {
                customOptions.classList.add('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !customOptions.contains(e.target)) {
                    customOptions.classList.remove('show');
                }
            });

            // Search functionality with real-time filtering
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const options = document.querySelectorAll('.custom-option');
                let visibleCount = 0;

                options.forEach(option => {
                    const searchData = option.getAttribute('data-search') || '';
                    const optionText = option.textContent.toLowerCase();

                    if (searchTerm === '' || optionText.includes(searchTerm) || searchData.includes(
                            searchTerm)) {
                        option.style.display = 'block';
                        visibleCount++;
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Update result count
                resultCountSpan.textContent = visibleCount + ' schemes available';

                // Always show dropdown when typing
                customOptions.classList.add('show');
            });

            // Handle option click
            document.querySelectorAll('.custom-option').forEach(option => {
                option.addEventListener('click', function() {
                    selectScheme(this);
                    customOptions.classList.remove('show');
                });
            });

            // Function to select a scheme
            function selectScheme(option) {
                // Remove previous selection
                if (selectedOption) {
                    selectedOption.classList.remove('selected');
                }

                // Add new selection
                option.classList.add('selected');
                selectedOption = option;

                // Get data from selected option
                const schemeId = option.getAttribute('data-value');
                const propertyType = option.getAttribute('data-property-type');
                const schemeCode = option.getAttribute('data-scheme-code');
                const schemeName = option.getAttribute('data-scheme-name');

                // Find scheme in array to get block count
                const selectedSchemeData = schemes.find(s => s.id == schemeId);
                const schemeBlockCount = selectedSchemeData ? selectedSchemeData.blockCount : 0;

                // Update hidden input and property type field
                selectedSchemeId.value = schemeId;
                propertyTypeInput.value = propertyType || '';

                // Update search input with selected scheme display
                searchInput.value = `${schemeCode} - ${schemeName}`.trim();

                // Update property-specific fields for all blocks
                updateAllPropertyFields(propertyType);

                // Initialize blocks based on scheme's existing block count
                initializeSchemeBlocks(schemeBlockCount);

                // Trigger change event for any listeners
                const event = new Event('change');
                document.getElementById('selected_scheme_id').dispatchEvent(event);
            }

            // Function to update property-specific fields for all blocks
            function updateAllPropertyFields(propertyType) {
                const blocks = document.querySelectorAll('.block-item');
                blocks.forEach((block, index) => {
                    updatePropertyFields(block, propertyType, index);
                });
            }

            // Function to update property-specific fields for a single block
            function updatePropertyFields(block, propertyType, index) {
                const container = block.querySelector('.property-specific-fields');
                if (!container) return;

                let html = '';

                if (propertyType) {
                    const propertyTypeLower = propertyType.toLowerCase();

                    if (propertyTypeLower.includes('flat') || propertyTypeLower.includes('apartment')) {
                        html = `
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Undivided Land Share <small class="text-danger">*</small></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="blocks[${index}][undivided_land_share]" placeholder="e.g., 100 sq ft" required>
                        <span class="input-group-text">sq. ft.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Total Buildup Area <small class="text-danger">*</small></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="blocks[${index}][total_buildup]" placeholder="e.g., 1500 sq ft" required>
                        <span class="input-group-text">sq. ft.</span>
                    </div>
                </div>
            </div>
        `;
                    } else if (propertyTypeLower.includes('house')) {
                        html = `
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Total Build up Area <small class="text-danger">*</small></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="blocks[${index}][total_buildup]" placeholder="e.g., 2000 sq ft" required>
                        <span class="input-group-text">sq. ft.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Total Area of Construction <small class="text-danger">*</small></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="blocks[${index}][total_construction_area]" placeholder="e.g., 1800 sq ft" required>
                        <span class="input-group-text">sq. ft.</span>
                    </div>
                </div>
            </div>
        `;
                    }
                }

                container.innerHTML = html;
            }

            // Update block name display when input changes
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('block-name-input')) {
                    const blockItem = e.target.closest('.block-item');
                    const displaySpan = blockItem.querySelector('.block-name-display');
                    if (displaySpan) {
                        displaySpan.textContent = e.target.value || 'Block Type';
                    }
                }
            });

            // Add More Blocks button
            addMoreBtn.addEventListener('click', function() {
                // Check if maximum blocks limit reached
                if (blockCount >= MAX_BLOCKS) {
                    alert('Maximum ' + MAX_BLOCKS + ' blocks can be added per scheme.');
                    updateAddMoreButtonState();
                    return;
                }

                addNewBlock(blockCount);
                blockCount++;
                updateRemoveButtons();
                updateAddMoreButtonState(); // Update button state and counter after adding
            });

            // Remove block
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-block')) {
                    const button = e.target.closest('.remove-block');
                    const blockItem = button.closest('.block-item');
                    if (blockItem && blockCount > 1) {
                        blockItem.remove();
                        blockCount--;

                        // Renumber remaining blocks
                        const remainingBlocks = document.querySelectorAll('.block-item');
                        remainingBlocks.forEach((block, idx) => {
                            block.dataset.index = idx;
                            const displayIndex = idx + 1;

                            // Update name attributes
                            const inputs = block.querySelectorAll('[name*="blocks["]');
                            inputs.forEach(input => {
                                const name = input.getAttribute('name');
                                const updatedName = name.replace(/blocks\[\d+\]/,
                                    `blocks[${idx}]`);
                                input.setAttribute('name', updatedName);
                            });

                            // Update display
                            const displaySpan = block.querySelector('.block-name-display');
                            const nameInput = block.querySelector('.block-name-input');
                            const indexSmall = block.querySelector('small');

                            if (displaySpan && nameInput) {
                                displaySpan.textContent = nameInput.value ||
                                    `Block Type ${displayIndex}`;
                            }
                            if (indexSmall) {
                                indexSmall.textContent = `index:${idx}`;
                            }

                            // Update property fields container ID
                            const propFields = block.querySelector('.property-specific-fields');
                            if (propFields) {
                                propFields.id = `property-fields-${idx}`;
                            }

                            // Update property fields if needed
                            if (propertyTypeInput.value) {
                                updatePropertyFields(block, propertyTypeInput.value, idx);
                            }
                        });

                        updateRemoveButtons();
                        updateAddMoreButtonState(); // Update button state and counter after removing
                    }
                }
            });

            // Update remove buttons visibility
            function updateRemoveButtons() {
                const removeButtons = document.querySelectorAll('.remove-block');
                if (blockCount <= 1) {
                    removeButtons.forEach(btn => {
                        btn.style.display = 'none';
                        btn.disabled = true;
                    });
                } else {
                    removeButtons.forEach(btn => {
                        btn.style.display = 'block';
                        btn.disabled = false;
                    });
                }
            }

            // Initial update
            updateRemoveButtons();
            updateAddMoreButtonState(); // Initialize button state and counter
            addMoreBtn.setAttribute('title', 'Add more blocks (Max ' + MAX_BLOCKS + ')');

            // Check if there's a pre-selected scheme (for edit mode)
            @if (old('scheme_id'))
                // Find and select the scheme if it exists in edit mode
                const oldSchemeId = '{{ old('scheme_id') }}';
                const oldSchemeOption = Array.from(document.querySelectorAll('.custom-option')).find(
                    opt => opt.getAttribute('data-value') == oldSchemeId
                );
                if (oldSchemeOption) {
                    selectScheme(oldSchemeOption);
                }
            @endif

            // Form validation
            document.getElementById('schemeBlockForm').addEventListener('submit', function(e) {
                if (!selectedSchemeId.value) {
                    e.preventDefault();
                    alert('Please select a scheme');
                    searchInput.focus();
                    return;
                }

                // Validate blocks count doesn't exceed maximum
                const blocks = document.querySelectorAll('.block-item');
                if (blocks.length > MAX_BLOCKS) {
                    e.preventDefault();
                    alert('Maximum ' + MAX_BLOCKS +
                        ' blocks allowed per scheme. Please remove extra blocks.');
                    return;
                }

                // Validate at least one block has required fields
                let valid = true;
                let firstInvalid = null;

                blocks.forEach((block, index) => {
                    const requiredInputs = block.querySelectorAll('[required]');
                    requiredInputs.forEach(input => {
                        if (!input.value.trim()) {
                            valid = false;
                            input.classList.add('is-invalid');
                            if (!firstInvalid) firstInvalid = input;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Please fill all required fields');
                    if (firstInvalid) firstInvalid.focus();
                }
            });

            // Keyboard navigation
            searchInput.addEventListener('keydown', function(e) {
                const options = Array.from(document.querySelectorAll(
                    '.custom-option:not([style*="display: none"])'));
                if (options.length === 0) return;

                const currentIndex = options.findIndex(opt => opt.classList.contains('selected'));

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const nextIndex = currentIndex + 1 < options.length ? currentIndex + 1 : 0;
                    options[nextIndex].classList.add('selected');
                    if (selectedOption) selectedOption.classList.remove('selected');
                    selectedOption = options[nextIndex];
                    options[nextIndex].scrollIntoView({
                        block: 'nearest'
                    });
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prevIndex = currentIndex - 1 >= 0 ? currentIndex - 1 : options.length - 1;
                    options[prevIndex].classList.add('selected');
                    if (selectedOption) selectedOption.classList.remove('selected');
                    selectedOption = options[prevIndex];
                    options[prevIndex].scrollIntoView({
                        block: 'nearest'
                    });
                } else if (e.key === 'Enter' && selectedOption) {
                    e.preventDefault();
                    selectScheme(selectedOption);
                    customOptions.classList.remove('show');
                } else if (e.key === 'Escape') {
                    customOptions.classList.remove('show');
                }
            });
        });
    </script>
@endsection
