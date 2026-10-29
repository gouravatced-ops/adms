@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-1">
                    <span class="text-muted fw-light">Dashboard / Manage Lot Files /</span>
                    Edit Data Entry File ({{ $allottee->property_number ?? $file->property_number }})
                </h6>
            </div>
            <div>
                <a href="{{ route('admin.manage.lots.file.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1]) }}"
                    class="btn btn-sm btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to Lot Files
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $currentDivisionId = old('division_id', $allottee->division_id ?? $file->division_id);
            $currentSubDivisionId = old('sub_division_id', $allottee->subdivision_id ?? $file->sub_division_id);
            $currentCategoryId = old('pcategory_id', $allottee->pcategory_id ?? $file->pcategory_id);
            $currentTypeId = old('p_type_id', $allottee->property_type_id ?? $file->p_type_id);
            $currentSubTypeId = old('property_subtype_id', $allottee->property_subtype_id ?? null);
            $currentQuarterId = old('quarter_type', $allottee->quarter_id ?? $file->quarter_type);

            $quarterTypes = getQuarterType();
            $getPropertyCategory = getPropertyCategory();
            $subdivisions = getSubDivisions($currentDivisionId);
            $propertyTypes = getPropertyType($currentCategoryId);
            $propertySubTypes = getPropertySubType($currentTypeId);

            $allotteeChain = isset($allotteeChain) && $allotteeChain->count() > 0 ? $allotteeChain : collect([$allottee]);
        @endphp

        <form action="{{ route('admin.dataentry.file.update', ['encryptedId' => $encryptedId]) }}" method="POST" id="dataentryEditForm">
            @csrf
            @method('PUT')

            {{-- 1. EDITABLE PROPERTY & CONNECTION DETAILS --}}
            <div class="card mb-4">
                <h5 class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span><i class="bx bx-building-house me-1"></i> Property & Connection Details (Editable)</span>
                    <span class="badge bg-light text-primary">
                        register_allottees.id: #{{ $file->id }} &leftrightarrow; Primary allottees.id: #{{ $allottee->id }} (register_file_id: #{{ $allottee->register_file_id }})
                        @if ($allotteeChain->count() > 1)
                            | Total Allottees (with Name Transfer): {{ $allotteeChain->count() }}
                        @endif
                    </span>
                </h5>
                <div class="card-body mt-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Register Number</label>
                            <input type="text" class="form-control bg-light" value="{{ $file->register_id ?? '-' }}" disabled readonly>
                        </div>

                        <div class="col-md-3">
                            <label for="property_number" class="form-label fw-semibold">
                                Property Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control fw-bold" id="property_number" name="property_number"
                                value="{{ old('property_number', $allottee->property_number ?? $file->property_number) }}"
                                placeholder="Enter Property Number" required>
                        </div>

                        <div class="col-md-3">
                            <label for="division_id" class="form-label fw-semibold">
                                Division <span class="text-danger">*</span>
                            </label>
                            <select name="division_id" id="division_id" class="form-select" required>
                                <option value="">Select Division</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}"
                                        {{ $division->id == $currentDivisionId ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="sub_division_id" class="form-label fw-semibold">
                                Sub Division <span class="text-danger">*</span>
                            </label>
                            <select name="sub_division_id" id="sub_division_id" class="form-select" required>
                                <option value="">Select Sub Division</option>
                                @foreach ($subdivisions as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ $sub->id == $currentSubDivisionId ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="property_category" class="form-label fw-semibold">
                                Property Category <span class="text-danger">*</span>
                            </label>
                            <select name="pcategory_id" id="property_category" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($getPropertyCategory as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $cat->id == $currentCategoryId ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="property_type" class="form-label fw-semibold">
                                Property Type <span class="text-danger">*</span>
                            </label>
                            <select name="p_type_id" id="property_type" class="form-select" required>
                                <option value="">Select Property Type</option>
                                @foreach ($propertyTypes as $ptype)
                                    <option value="{{ $ptype->id }}"
                                        {{ $ptype->id == $currentTypeId ? 'selected' : '' }}>
                                        {{ $ptype->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="property_sub_type" class="form-label fw-semibold">
                                Property Sub Type
                            </label>
                            <select name="property_subtype_id" id="property_sub_type" class="form-select">
                                <option value="">Select Property Sub Type</option>
                                @foreach ($propertySubTypes as $psub)
                                    <option value="{{ $psub->id }}"
                                        {{ $psub->id == $currentSubTypeId ? 'selected' : '' }}>
                                        {{ $psub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3" id="quarter_type_div">
                            <label for="quarter_type" class="form-label fw-semibold">
                                Quarter Type / Income Group <span class="text-danger">*</span>
                            </label>
                            <select name="quarter_type" id="quarter_type" class="form-select" required>
                                <option value="">Select Quarter Type</option>
                                @foreach ($quarterTypes as $qt)
                                    <option value="{{ $qt->quarter_id }}"
                                        {{ $qt->quarter_id == $currentQuarterId ? 'selected' : '' }}>
                                        {{ $qt->quarter_code }} - {{ $qt->quarter_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. READ-ONLY RECEIVING & SCANNED FILE DETAILS --}}
            <!-- <div class="card mb-4">
                <h5 class="card-header bg-secondary text-white">
                    <i class="bx bx-file me-1"></i> Receiving & Scanned File Details (View Only)
                </h5>
                <div class="card-body mt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">
                                Receiving / Scanned File Name (from <code>register_allottees</code>)
                            </label>
                            @php
                                $receivingFullName = trim(
                                    ($file->prefix ?? '') . ' ' .
                                    ($file->allottee_name ?? '') . ' ' .
                                    ($file->allottee_middle_name ?? '') . ' ' .
                                    ($file->allottee_surname ?? '')
                                );
                            @endphp
                            <input type="text" class="form-control bg-light"
                                value="{{ $receivingFullName ?: '-' }} ({{ $file->property_number }})" disabled readonly>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted">No. of Files</label>
                            <input type="text" class="form-control bg-light" value="{{ $file->no_of_files ?? 1 }}" disabled readonly>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted">Supplement Files</label>
                            <input type="text" class="form-control bg-light" value="{{ $file->no_of_supplement ?? 0 }}" disabled readonly>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-muted">Total Scanned Pages</label>
                            <input type="text" class="form-control bg-light" value="{{ $file->total_pages ?? 0 }}" disabled readonly>
                        </div>

                        @php
                            $pagesData = $file->json_pages ? json_decode($file->json_pages, true) : [];
                            if (!is_array($pagesData)) {
                                $pagesData = [];
                            }
                            $masterDocs = $file->masterDocuments && $file->masterDocuments->count() > 0
                                ? $file->masterDocuments
                                : ($allottee->masterDocuments ?? collect());
                        @endphp

                        @if (count($pagesData) > 0 || $masterDocs->count() > 0)
                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold text-primary">Scanned Files & Pages Details</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Scanned File Label / Name</th>
                                                <th>Pages</th>
                                                <th>Master Scanned File Name / Path</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $maxRows = max(count($pagesData), $masterDocs->count());
                                            @endphp
                                            @for ($i = 0; $i < $maxRows; $i++)
                                                @php
                                                    $pageItem = $pagesData[$i] ?? null;
                                                    $masterDoc = $masterDocs[$i] ?? null;
                                                    $label = $pageItem['file_name'] ?? ($masterDoc->file_label ?? 'File-' . ($i + 1));
                                                    $typeTag = $i === 0 ? ' (Main File)' : ' (Supplement ' . $i . ')';
                                                @endphp
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td class="fw-semibold">{{ $label }}{{ $typeTag }}</td>
                                                    <td>{{ $pageItem['pages'] ?? '-' }}</td>
                                                    <td>
                                                        @if ($masterDoc)
                                                            <span>{{ $masterDoc->file_name ?? basename($masterDoc->file_path) }}</span>
                                                            @if (!empty($masterDoc->file_path))
                                                                <a href="{{ asset($masterDoc->file_path) }}" target="_blank"
                                                                    class="btn btn-xs btn-outline-info ms-2">
                                                                    <i class="bx bx-show"></i> View PDF
                                                                </a>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div> -->

            {{-- 3. ALLOTTEE TABS (1ST PRIMARY ALLOTTEE + ANY SUBSEQUENT NAME TRANSFER ALLOTTEES) --}}
            <div class="card">
                <h5 class="card-header bg-info text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span><i class="bx bx-user-check me-1"></i> Update Allottee Name (English & Hindi)</span>
                    <span class="badge bg-white text-info">
                        {{ $allotteeChain->count() }} {{ $allotteeChain->count() === 1 ? 'Allottee Record' : 'Allottee Records (Original + Name Transfers)' }}
                    </span>
                </h5>
                <div class="card-body mt-3">
                    {{-- Bootstrap Tabs Navigation for Allottees --}}
                    <ul class="nav nav-tabs mb-3" id="allotteeTabs" role="tablist">
                        @foreach ($allotteeChain as $idx => $chainItem)
                            @php
                                $tabNumber = $idx + 1;
                                $ordinal = match($tabNumber) {
                                    1 => '1st Allottee (Main / Original)',
                                    2 => '2nd Allottee (1st Name Transfer)',
                                    3 => '3rd Allottee (2nd Name Transfer)',
                                    default => $tabNumber . 'th Allottee (Name Transfer ' . $idx . ')',
                                };
                                $itemFullName = trim(
                                    ($chainItem->prefix ?? '') . ' ' .
                                    ($chainItem->allottee_name ?? '') . ' ' .
                                    ($chainItem->allottee_middle_name ?? '') . ' ' .
                                    ($chainItem->allottee_surname ?? '')
                                );
                            @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $idx === 0 ? 'active fw-bold' : 'fw-semibold' }}"
                                    id="allottee-tab-{{ $chainItem->id }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#allottee-pane-{{ $chainItem->id }}"
                                    type="button"
                                    role="tab"
                                    aria-controls="allottee-pane-{{ $chainItem->id }}"
                                    aria-selected="{{ $idx === 0 ? 'true' : 'false' }}">
                                    <i class="bx {{ $idx === 0 ? 'bx-user' : 'bx-transfer-alt' }} me-1"></i>
                                    {{ $ordinal }}: <span class="text-primary">{{ $itemFullName ?: 'N/A' }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Tab Panes --}}
                    <div class="tab-content pt-2" id="allotteeTabsContent">
                        @php
                            $englishPrefixes = ['Shri', 'Smt.', 'Miss', 'Dr.', 'Md.', 'Late', 'M/S', 'M/s', 'Maj.', 'Capt.', 'Other'];
                            $hindiPrefixes = ['श्री', 'श्रीमती', 'सुश्री', 'डॉ.', 'मो.', 'स्व०', 'स्वर्गीय', 'मेसर्स', 'मेजर', 'कैप्टन', 'अन्य'];
                        @endphp

                        @foreach ($allotteeChain as $idx => $chainItem)
                            @php
                                $cid = $chainItem->id;
                                $currentEngPrefix = old("allottees.{$cid}.prefix", $chainItem->prefix ?? 'Shri');
                                $currentHindiPrefix = old("allottees.{$cid}.allottee_prefix_hindi", $chainItem->allottee_prefix_hindi ?? 'श्री');
                            @endphp
                            <div class="tab-pane fade {{ $idx === 0 ? 'show active' : '' }}"
                                id="allottee-pane-{{ $cid }}"
                                role="tabpanel"
                                aria-labelledby="allottee-tab-{{ $cid }}">

                                {{-- Connection & Document Path Info Banner --}}
                                <!-- <div class="alert alert-secondary d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <div>
                                        <strong>Allottee Primary ID (<code>allottees.id</code>):</strong> <code>#{{ $cid }}</code>
                                        @if (!empty($chainItem->register_file_id))
                                            <span class="ms-3">
                                                <strong>Connected <code>register_file_id</code>:</strong>
                                                <span class="badge bg-primary">#{{ $chainItem->register_file_id }}</span>
                                            </span>
                                        @else
                                            <span class="ms-3">
                                                <strong><code>register_file_id</code>:</strong>
                                                <span class="badge bg-warning text-dark">NULL (Name Transfer Record)</span>
                                            </span>
                                        @endif

                                        @if (!empty($chainItem->parent_id))
                                            <span class="ms-3">
                                                <strong>Connected <code>parent_id</code> (Previous Allottee ID):</strong>
                                                <span class="badge bg-info">#{{ $chainItem->parent_id }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div> -->

                                <div class="row g-3">
                                    {{-- View-Only Allottee Document Path & Files List for this Allottee --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-primary">
                                            Allottee Document Folder Path
                                        </label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text bg-light"><i class="bx bx-folder-open text-warning"></i></span>
                                            <input type="text" class="form-control bg-light fw-semibold"
                                                value="{{ $chainItem->allottee_document_path ?: 'N/A' }}" disabled readonly>
                                        </div>

                                        @php
                                            $folderFilesList = [];
                                            $seenFileNames = [];

                                            // Map DB document labels by filename for friendly display
                                            $dbLabelsByFileName = [];
                                            if ($chainItem->masterDocuments) {
                                                foreach ($chainItem->masterDocuments as $mDoc) {
                                                    $bName = $mDoc->file_name ?: basename((string) $mDoc->file_path);
                                                    if ($bName) {
                                                        $dbLabelsByFileName[$bName] = 'Master Scanned (' . ($mDoc->file_label ?? 'File') . ')';
                                                    }
                                                }
                                            }
                                            if ($chainItem->documentData) {
                                                foreach ($chainItem->documentData as $aDoc) {
                                                    $bName = $aDoc->file_name ?: basename((string) $aDoc->file_path);
                                                    if ($bName) {
                                                        $dbLabelsByFileName[$bName] = $aDoc->document->document_name ?? 'Basic Document';
                                                    }
                                                }
                                            }

                                            $cleanDocFolder = trim((string) $chainItem->allottee_document_path, '/\\');
                                            $fullFolderDir = !empty($cleanDocFolder) ? public_path($cleanDocFolder) : null;

                                            // 1. Read physical files directly from allottee_document_path folder
                                            if ($fullFolderDir && \Illuminate\Support\Facades\File::isDirectory($fullFolderDir)) {
                                                foreach (\Illuminate\Support\Facades\File::files($fullFolderDir) as $physFile) {
                                                    $fName = $physFile->getFilename();
                                                    $seenFileNames[$fName] = true;
                                                    $folderFilesList[] = [
                                                        'label' => $dbLabelsByFileName[$fName] ?? 'Uploaded Document',
                                                        'file_name' => $fName,
                                                        'file_path' => $cleanDocFolder . '/' . $fName,
                                                        'size_kb' => number_format($physFile->getSize() / 1024, 0) . ' KB',
                                                        'exists' => true,
                                                    ];
                                                }
                                            }

                                            // 2. Fallback: include any DB masterDocuments / documentData not already listed
                                            if ($chainItem->masterDocuments) {
                                                foreach ($chainItem->masterDocuments as $mDoc) {
                                                    $fName = $mDoc->file_name ?: basename((string) $mDoc->file_path);
                                                    if (!empty($mDoc->file_path) && !isset($seenFileNames[$fName])) {
                                                        $seenFileNames[$fName] = true;
                                                        $physExists = \Illuminate\Support\Facades\File::exists(public_path($mDoc->file_path));
                                                        $folderFilesList[] = [
                                                            'label' => 'Master Scanned (' . ($mDoc->file_label ?? 'File') . ')',
                                                            'file_name' => $fName,
                                                            'file_path' => $mDoc->file_path,
                                                            'size_kb' => $physExists ? number_format(\Illuminate\Support\Facades\File::size(public_path($mDoc->file_path)) / 1024, 0) . ' KB' : '-',
                                                            'exists' => $physExists,
                                                        ];
                                                    }
                                                }
                                            }
                                            if ($chainItem->documentData) {
                                                foreach ($chainItem->documentData as $aDoc) {
                                                    $fName = $aDoc->file_name ?: basename((string) $aDoc->file_path);
                                                    if (!empty($aDoc->file_path) && !isset($seenFileNames[$fName])) {
                                                        $seenFileNames[$fName] = true;
                                                        $physExists = \Illuminate\Support\Facades\File::exists(public_path($aDoc->file_path));
                                                        $folderFilesList[] = [
                                                            'label' => $aDoc->document->document_name ?? 'Basic Document',
                                                            'file_name' => $fName,
                                                            'file_path' => $aDoc->file_path,
                                                            'size_kb' => $physExists ? number_format(\Illuminate\Support\Facades\File::size(public_path($aDoc->file_path)) / 1024, 0) . ' KB' : '-',
                                                            'exists' => $physExists,
                                                        ];
                                                    }
                                                }
                                            }
                                        @endphp

                                        @if (count($folderFilesList) > 0)
                                            <div class="table-responsive mt-2">
                                                <table class="table table-bordered table-sm align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 50px;">#</th>
                                                            <th>Document Type</th>
                                                            <th>File Name (in Folder)</th>
                                                            <th style="width: 110px;">Size</th>
                                                            <th style="width: 130px;" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($folderFilesList as $fIdx => $fItem)
                                                            <tr>
                                                                <td>{{ $fIdx + 1 }}</td>
                                                                <td>
                                                                    <span class="badge bg-label-primary">{{ $fItem['label'] }}</span>
                                                                </td>
                                                                <td class="fw-semibold text-break">
                                                                    <i class="bx bxs-file-pdf text-danger me-1"></i>{{ $fItem['file_name'] }}
                                                                </td>
                                                                <td>{{ $fItem['size_kb'] }}</td>
                                                                <td class="text-center">
                                                                    @if ($fItem['exists'])
                                                                        <a href="{{ asset($fItem['file_path']) }}" target="_blank"
                                                                            class="btn btn-sm btn-outline-primary">
                                                                            <i class="bx bx-show me-1"></i> View File
                                                                        </a>
                                                                    @else
                                                                        <span class="badge bg-danger">File Missing</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="small text-muted mt-1">
                                                <i class="bx bx-info-circle me-1"></i> No uploaded PDF files found in this folder path yet.
                                            </div>
                                        @endif
                                    </div>

                                    {{-- English Name Fields --}}
                                    <div class="col-12 mt-3">
                                        <h6 class="fw-bold text-primary mb-1">Allottee Name (English)</h6>
                                        <hr class="mt-0 mb-2">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Prefix (English) <span class="text-danger">*</span></label>
                                        <select name="allottees[{{ $cid }}][prefix]" class="form-select" required>
                                            @foreach ($englishPrefixes as $prefixOption)
                                                <option value="{{ $prefixOption }}"
                                                    {{ $currentEngPrefix == $prefixOption ? 'selected' : '' }}>
                                                    {{ $prefixOption }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">First Name (English) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            name="allottees[{{ $cid }}][allottee_name]"
                                            value="{{ old("allottees.{$cid}.allottee_name", $chainItem->allottee_name) }}"
                                            placeholder="Enter First Name in English" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Middle Name (English)</label>
                                        <input type="text" class="form-control"
                                            name="allottees[{{ $cid }}][allottee_middle_name]"
                                            value="{{ old("allottees.{$cid}.allottee_middle_name", $chainItem->allottee_middle_name) }}"
                                            placeholder="Optional">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Surname / Last Name (English)</label>
                                        <input type="text" class="form-control"
                                            name="allottees[{{ $cid }}][allottee_surname]"
                                            value="{{ old("allottees.{$cid}.allottee_surname", $chainItem->allottee_surname) }}"
                                            placeholder="Enter Last Name in English">
                                    </div>

                                    {{-- Hindi Name Fields --}}
                                    <div class="col-12 mt-4">
                                        <h6 class="fw-bold text-primary mb-1">Allottee Name (Hindi / हिन्दी)</h6>
                                        <hr class="mt-0 mb-2">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Prefix (Hindi)</label>
                                        <select name="allottees[{{ $cid }}][allottee_prefix_hindi]" class="form-select">
                                            <option value="">-- Select --</option>
                                            @foreach ($hindiPrefixes as $hPrefix)
                                                <option value="{{ $hPrefix }}"
                                                    {{ $currentHindiPrefix == $hPrefix ? 'selected' : '' }}>
                                                    {{ $hPrefix }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">First Name (Hindi / प्रथम नाम)</label>
                                        <input type="text" class="form-control"
                                            name="allottees[{{ $cid }}][allottee_name_hindi]"
                                            value="{{ old("allottees.{$cid}.allottee_name_hindi", $chainItem->allottee_name_hindi) }}"
                                            placeholder="e.g. राजेश">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Middle Name (Hindi / मध्य नाम)</label>
                                        <input type="text" class="form-control"
                                            name="allottees[{{ $cid }}][allottee_middle_hindi]"
                                            value="{{ old("allottees.{$cid}.allottee_middle_hindi", $chainItem->allottee_middle_hindi) }}"
                                            placeholder="e.g. कुमार">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Surname / Last Name (Hindi / उपनाम)</label>
                                        <input type="text" class="form-control"
                                            name="allottees[{{ $cid }}][allottee_surname_hindi]"
                                            value="{{ old("allottees.{$cid}.allottee_surname_hindi", $chainItem->allottee_surname_hindi) }}"
                                            placeholder="e.g. सिंह">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Update Property & Allottee Details
                        </button>
                        <a href="{{ route('admin.manage.lots.file.index', ['encodedId' => base64_encode($file->register_id), 'page' => 1]) }}"
                            class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const divisionSelect = document.getElementById('division_id');
            const subDivisionSelect = document.getElementById('sub_division_id');
            const categorySelect = document.getElementById('property_category');
            const propertyTypeSelect = document.getElementById('property_type');
            const propertySubTypeSelect = document.getElementById('property_sub_type');
            const quarterSelect = document.getElementById('quarter_type');

            // Division -> Sub Division
            if (divisionSelect && subDivisionSelect) {
                divisionSelect.addEventListener('change', function() {
                    const divisionId = this.value;
                    subDivisionSelect.innerHTML = '<option value="">Loading...</option>';
                    if (!divisionId) {
                        subDivisionSelect.innerHTML = '<option value="">Select Sub Division</option>';
                        return;
                    }
                    fetch(`/get-sub-divisions/${divisionId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">Select Sub Division</option>';
                            data.forEach(item => {
                                options += `<option value="${item.id}">${item.name}</option>`;
                            });
                            subDivisionSelect.innerHTML = options;
                        })
                        .catch(() => {
                            subDivisionSelect.innerHTML = '<option value="">Error loading Sub Divisions</option>';
                        });
                });
            }

            // Property Category -> Property Type
            if (categorySelect && propertyTypeSelect) {
                categorySelect.addEventListener('change', function() {
                    const category = this.value;
                    propertyTypeSelect.innerHTML = '<option value="">Loading...</option>';
                    if (propertySubTypeSelect) {
                        propertySubTypeSelect.innerHTML = '<option value="">Select Property Sub Type</option>';
                    }
                    if (!category) {
                        propertyTypeSelect.innerHTML = '<option value="">Select Property Type</option>';
                        return;
                    }
                    fetch(`/get-property-types/${category}`)
                        .then(response => response.json())
                        .then(data => {
                            let options = '<option value="">Select Property Type</option>';
                            data.forEach(item => {
                                options += `<option value="${item.id}">${item.name}</option>`;
                            });
                            propertyTypeSelect.innerHTML = options;
                        })
                        .catch(() => {
                            propertyTypeSelect.innerHTML = '<option value="">Error loading Property Types</option>';
                        });
                });
            }

            // Property Type -> Property Sub Type + Quarter Type filter
            function filterQuarterOptions() {
                if (!propertyTypeSelect || !quarterSelect) return;
                const text = (propertyTypeSelect.options[propertyTypeSelect.selectedIndex]?.text || '').toLowerCase();

                Array.from(quarterSelect.options).forEach(option => {
                    if (!option.value) return;
                    const optionText = option.text.toLowerCase();
                    if (text.includes('plot')) {
                        if (optionText.includes('mig') || optionText.includes('hig') || optionText.includes('lig')) {
                            option.hidden = false;
                        } else {
                            option.hidden = true;
                        }
                    } else {
                        option.hidden = false;
                    }
                });
            }

            if (propertyTypeSelect) {
                propertyTypeSelect.addEventListener('change', function() {
                    const typeId = this.value;
                    filterQuarterOptions();

                    if (!propertySubTypeSelect) return;
                    propertySubTypeSelect.innerHTML = '<option value="">Loading...</option>';
                    if (!typeId) {
                        propertySubTypeSelect.innerHTML = '<option value="">Select Property Sub Type</option>';
                        return;
                    }
                    fetch(`/get-property-sub-types/${typeId}`)
                        .then(response => response.json())
                        .then(data => {
                            let options = '<option value="">Select Property Sub Type</option>';
                            data.forEach(item => {
                                options += `<option value="${item.id}">${item.name}</option>`;
                            });
                            propertySubTypeSelect.innerHTML = options;
                        })
                        .catch(() => {
                            propertySubTypeSelect.innerHTML = '<option value="">Error loading Sub Types</option>';
                        });
                });

                filterQuarterOptions();
            }
        });
    </script>
@endsection
