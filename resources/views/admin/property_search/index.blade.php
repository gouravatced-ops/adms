@extends('admin.layouts.main')

@section('title', 'Property Search')

@section('admin-content')
<style>
    /* Compact & Classic UI Custom CSS */
    .premium-container {
        padding: 1.5rem;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        font-family: 'Inter', sans-serif;
    }

    .premium-card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
    }
    
    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        border-bottom: 2px solid #3b82f6;
        display: inline-block;
        padding-bottom: 0.25rem;
    }

    /* Search Form */
    .search-group {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
        max-width: 600px;
    }

    .input-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .search-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.25rem;
    }

    .search-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.95rem;
        color: #334155;
        background: #f8fafc;
    }

    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        background: #ffffff;
    }

    .btn-search {
        background: #2563eb;
        color: white;
        padding: 0.5rem 1.25rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        height: 38px;
    }

    .btn-search:hover {
        background: #1d4ed8;
    }

    /* Autocomplete List */
    .autocomplete-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-top: none;
        border-radius: 0 0 6px 6px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        list-style: none;
        margin: 0;
        padding: 0;
        z-index: 10;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }
    .autocomplete-item {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        font-size: 0.95rem;
        color: #334155;
    }
    .autocomplete-item:hover {
        background: #f1f5f9;
        color: #2563eb;
    }

    /* Alert */
    .alert-warning {
        background: #fffbeb;
        border-left: 4px solid #f59e0b;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        color: #b45309;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    /* Results Header */
    .result-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 0.75rem;
    }
    
    .allottee-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.15rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .current-badge {
        background: #10b981;
        color: #ffffff;
        font-size: 0.65rem;
        padding: 0.15rem 0.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .property-meta {
        font-size: 0.8rem;
        color: #475569;
        margin: 0;
        line-height: 1.4;
    }

    .property-meta strong {
        color: #1e293b;
    }

    .badge-success {
        background: #dcfce7;
        color: #166534;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    /* Grid layout - Using auto-fit for maximum density */
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    /* Detail Boxes */
    .detail-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0.85rem;
    }

    .detail-box h4 {
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        margin: 0 0 0.5rem 0;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #cbd5e1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .detail-list li {
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 0.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px dashed #e2e8f0;
        padding-bottom: 0.15rem;
    }
    
    .detail-list li:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .detail-list li strong {
        color: #1e293b;
        font-weight: 600;
    }
    
    .status-badge {
        font-weight: 600;
    }
    .status-completed { color: #10b981; }
    .status-incomplete { color: #f59e0b; }

    /* Special Sections */
    .box-transfer {
        background: #eff6ff;
        border-color: #bfdbfe;
    }
    .box-transfer h4 {
        color: #1e40af;
        border-color: #93c5fd;
    }
    
    .box-freehold {
        background: #faf5ff;
        border-color: #e9d5ff;
    }
    .box-freehold h4 {
        color: #6b21a8;
        border-color: #d8b4fe;
    }
    
    .box-emi {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .box-emi h4 {
        color: #166534;
        border-color: #86efac;
    }

    .doc-ul li {
        color: #475569;
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
        list-style-type: square;
    }

    .doc-ul {
        padding-left: 1rem;
        margin: 0;
    }

    /* Magnifier Glass Feature */
    .btn-magnifier-header {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-magnifier-header.active {
        background: #3b82f6;
    }
    .btn-magnifier-header:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .magnifier-glass {
        position: fixed;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        border: 4px solid #10b981;
        box-shadow: 0 10px 25px rgba(0,0,0,0.4), inset 0 0 20px rgba(0,0,0,0.1);
        background-color: #ffffff;
        pointer-events: none;
        overflow: hidden;
        z-index: 9999;
        display: none;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .magnifier-glass.visible {
        display: block;
        opacity: 1;
    }

    .magnifier-content {
        position: absolute;
        transform-origin: top left;
        background-color: #ffffff;
    }
</style>

<div class="premium-container" id="source-container">
    <div class="premium-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="page-title" style="margin-bottom: 0;">Property Search</h2>
            <button id="toggle-magnifier" class="btn-magnifier-header" title="Toggle Magnifier">
                <i class="fas fa-search-plus"></i> Magnifier
            </button>
        </div>
        
        <form action="{{ route('admin.property.search.submit') }}" method="POST">
            @csrf
            <div class="search-group">
                <div class="input-wrapper">
                    <label for="property_number" class="search-label">Property Number</label>
                    <input type="text" name="property_number" id="property_number" 
                           value="{{ $propertyNumber ?? '' }}"
                           class="search-input" 
                           placeholder="Enter Property Number (e.g. C-40)" required autocomplete="off">
                    <ul id="autocomplete-results" class="autocomplete-list"></ul>
                </div>
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>
    
    @if(isset($allottees))
        @if($allottees->isEmpty())
            <div class="alert-warning">
                <i class="fas fa-exclamation-triangle" style="margin-right: 10px;"></i>
                No records found for property number: <strong>&nbsp;{{ $propertyNumber }}</strong>
            </div>
        @else
            <div>
                @foreach($allottees as $index => $item)
                    @php
                        $allotteeName = trim(($item->prefix ?? '') . ' ' . ($item->allottee_name ?? '') . ' ' . ($item->allottee_middle_name ?? '') . ' ' . ($item->allottee_surname ?? ''));
                        $isNameTransfer = strtolower($item->name_transfer_status ?? '') === 'yes';
                        $isFreeHold = strtolower($item->free_hold_status ?? '') === 'yes';
                        $isCurrentAllottee = ($index === 0);
                    @endphp
                    
                    <div class="premium-card">
                        <div class="result-header">
                            <div>
                                <h3 class="allottee-name">
                                    {{ $allotteeName ?: 'Unknown Allottee' }}
                                    @if($isCurrentAllottee)
                                        <span class="current-badge">Current Allottee</span>
                                    @endif
                                </h3>
                                <p class="property-meta">
                                    Property No: <strong>{{ $item->property_number }}</strong> &nbsp;|&nbsp; 
                                    Lot No: <strong>{{ $item->registration->lot_no ?? 'N/A' }}</strong> &nbsp;|&nbsp; 
                                    File Reg No: <strong>{{ $item->registration->register_no ?? 'N/A' }}</strong> &nbsp;|&nbsp;
                                    Division: {{ $item->division->name ?? 'N/A' }} &nbsp;|&nbsp; 
                                    Sub Division: {{ $item->subDivision->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="grid-container">
                            <!-- Data Entry Details -->
                            <div class="detail-box">
                                <h4><i class="fas fa-list-alt" style="margin-right:4px;"></i> Data Entry</h4>
                                <ul class="detail-list">
                                    <li><strong>Category:</strong> <span>{{ $item->propertyCategory->name ?? 'N/A' }}</span></li>
                                    <li><strong>Type:</strong> <span>{{ $item->propertyType->name ?? 'N/A' }}</span></li>
                                    <li><strong>Quarter:</strong> <span>{{ $item->quarterType->quarter_code ?? 'N/A' }}</span></li>
                                    <li><strong>Stage:</strong> <span>Step {{ $item->current_step ?? 0 }}</span></li>
                                    <li><strong>Status:</strong> 
                                        @if($item->is_step_completed)
                                            <span class="status-badge status-completed">Completed</span>
                                        @else
                                            <span class="status-badge status-incomplete">Incomplete</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Document List -->
                            <div class="detail-box">
                                <h4>
                                    <i class="fas fa-file-pdf" style="margin-right:4px;"></i> 
                                    Documents (Total: {{ $item->documentData ? $item->documentData->count() : 0 }})
                                </h4>
                                @if($item->documentData && $item->documentData->isNotEmpty())
                                    <ul class="doc-ul">
                                        @foreach($item->documentData as $doc)
                                            <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding: 4px 0;">
                                                <span>Document {{ $loop->iteration }}</span>
                                                @if($doc->file_path)
                                                    <a href="{{ asset($doc->file_path) }}" target="_blank" class="badge-success" style="text-decoration: none; font-size: 0.65rem;">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                @else
                                                    <span style="font-size: 0.65rem; color: #94a3b8;">N/A</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p style="color: #94a3b8; font-style: italic; margin: 0; font-size: 0.8rem;">No documents</p>
                                @endif
                            </div>

                            <!-- EMI Status -->
                            @if($item->accountLedger)
                            <div class="detail-box box-emi">
                                <h4><i class="fas fa-money-bill-wave" style="margin-right:4px;"></i> EMI Ledger</h4>
                                <ul class="detail-list">
                                    <li><strong>Total EMI Count:</strong> <span>{{ $item->accountLedger->total_emi_count ?? '0' }}</span></li>
                                    <li><strong>Total Amount:</strong> <span>,1{{ number_format((float)($item->accountLedger->total_amount ?? 0), 2) }}</span></li>
                                    <li><strong>Total Paid:</strong> <span class="status-completed">,1{{ number_format((float)($item->accountLedger->total_paid ?? 0), 2) }}</span></li>
                                    <li><strong>Current Balance:</strong> <span>,1{{ number_format((float)($item->accountLedger->current_balance ?? 0), 2) }}</span></li>
                                    <li><strong>Remaining EMI:</strong> <span>{{ $item->accountLedger->remaining_emi ?? '0' }}</span></li>
                                </ul>
                            </div>
                            @endif

                            <!-- Name Transfer Section -->
                            @if($isNameTransfer)
                                <div class="detail-box box-transfer">
                                    <h4><i class="fas fa-exchange-alt" style="margin-right:4px;"></i> Name Transfer</h4>
                                    <ul class="detail-list mt-2">
                                        <li><strong>Data Entry:</strong> 
                                            <span class="{{ $item->is_trans_entry_completed ? 'status-completed' : 'status-incomplete' }} status-badge">
                                                {{ $item->is_trans_entry_completed ? 'Completed' : 'Pending' }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            @endif

                            <!-- Free Hold Section -->
                            @if($isFreeHold)
                                <div class="detail-box box-freehold">
                                    <h4><i class="fas fa-home" style="margin-right:4px;"></i> Free Hold</h4>
                                    <ul class="detail-list mt-2">
                                        <li><strong>Data Entry:</strong> 
                                            <span class="{{ $item->is_free_hold_completed ? 'status-completed' : 'status-incomplete' }} status-badge">
                                                {{ $item->is_free_hold_completed ? 'Completed' : 'Pending' }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

<!-- Magnifier Elements -->
<div id="magnifier-glass" class="magnifier-glass">
    <div id="magnifier-content" class="magnifier-content"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Autocomplete Logic
    const searchInput = document.getElementById('property_number');
    const autocompleteList = document.getElementById('autocomplete-results');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 1) {
            autocompleteList.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('admin.property.search.autocomplete') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    autocompleteList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.textContent = item;
                            li.className = 'autocomplete-item';
                            li.addEventListener('click', function() {
                                searchInput.value = this.textContent;
                                autocompleteList.style.display = 'none';
                                searchInput.closest('form').submit();
                            });
                            autocompleteList.appendChild(li);
                        });
                        autocompleteList.style.display = 'block';
                    } else {
                        autocompleteList.style.display = 'none';
                    }
                });
        }, 300);
    });

    // Hide autocomplete on click outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteList.contains(e.target)) {
            autocompleteList.style.display = 'none';
        }
    });

    // Magnifier Logic
    const toggleBtn = document.getElementById('toggle-magnifier');
    const magnifier = document.getElementById('magnifier-glass');
    const magnifierContent = document.getElementById('magnifier-content');
    const sourceContainer = document.getElementById('source-container');
    
    // Check local storage, default is ON
    let isMagnifierOn = localStorage.getItem('magnifierStateAdmin');
    if (isMagnifierOn === null) {
        isMagnifierOn = 'on'; // default on
        localStorage.setItem('magnifierStateAdmin', 'on');
    }
    
    let isCloned = false;
    const ZOOM_LEVEL = 1.6;

    function initMagnifier() {
        if (!isCloned) {
            const clone = sourceContainer.cloneNode(true);
            clone.removeAttribute('id');
            // Remove any ID attributes inside clone to prevent duplicates
            clone.querySelectorAll('[id]').forEach(el => el.removeAttribute('id'));
            
            clone.style.width = sourceContainer.offsetWidth + 'px';
            clone.style.margin = '0';
            
            magnifierContent.innerHTML = '';
            magnifierContent.appendChild(clone);
            
            magnifierContent.style.transform = `scale(${ZOOM_LEVEL})`;
            isCloned = true;
        }
    }

    function updateMagnifierState() {
        if (isMagnifierOn === 'on') {
            toggleBtn.classList.add('active');
            toggleBtn.innerHTML = '<i class="fas fa-search-minus"></i> Magnifier On';
            initMagnifier();
        } else {
            toggleBtn.classList.remove('active');
            toggleBtn.innerHTML = '<i class="fas fa-search-plus"></i> Magnifier Off';
            magnifier.classList.remove('visible');
        }
    }

    toggleBtn.addEventListener('click', () => {
        isMagnifierOn = isMagnifierOn === 'on' ? 'off' : 'on';
        localStorage.setItem('magnifierStateAdmin', isMagnifierOn);
        updateMagnifierState();
    });

    document.addEventListener('mousemove', (e) => {
        if (isMagnifierOn !== 'on') return;

        const rect = sourceContainer.getBoundingClientRect();
        
        // Add a slight margin around the container where magnifier still works
        const margin = 20; 
        const isHovering = e.clientX >= rect.left - margin && e.clientX <= rect.right + margin && 
                           e.clientY >= rect.top - margin && e.clientY <= rect.bottom + margin;
                           
        if (isHovering) {
            magnifier.classList.add('visible');
            
            const magWidth = magnifier.offsetWidth;
            const magHeight = magnifier.offsetHeight;
            
            // Position the glass center at cursor
            magnifier.style.left = (e.clientX - magWidth / 2) + 'px';
            magnifier.style.top = (e.clientY - magHeight / 2) + 'px';
            
            // Calculate relative mouse position inside the source container
            const relX = e.clientX - rect.left;
            const relY = e.clientY - rect.top;
            
            // Move the content inside the glass opposite to the cursor movement, scaled
            const contentX = - (relX * ZOOM_LEVEL) + (magWidth / 2);
            const contentY = - (relY * ZOOM_LEVEL) + (magHeight / 2);
            
            magnifierContent.style.left = contentX + 'px';
            magnifierContent.style.top = contentY + 'px';
        } else {
            magnifier.classList.remove('visible');
        }
    });
    
    // Update clone width on resize
    window.addEventListener('resize', () => {
        if (isCloned) {
            const clone = magnifierContent.firstElementChild;
            if (clone) clone.style.width = sourceContainer.offsetWidth + 'px';
        }
    });

    // Hide while scrolling for better performance
    document.addEventListener('scroll', (e) => {
        magnifier.classList.remove('visible');
    });

    // Run initial state setup
    setTimeout(updateMagnifierState, 300); // Slight delay to let rendering finish
});
</script>
@endsection
