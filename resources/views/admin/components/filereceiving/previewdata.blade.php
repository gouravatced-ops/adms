@extends('admin.layouts.main')

@section('admin-content')
    <style>
        .nav-tabs .nav-link.active {
            border-bottom-color: #fff;
            background: #0380ec;
            color: #fff !important;
        }
    </style>
    <div class="container-xxl flex-grow-1">
        <h6 class="py-3 mb-2">
            <span class="invert-text-white">Dashboard / File Preview</span>
        </h6>

        <div class="card mb-4">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0">File Preview</h5>
                <div class="btn-group">
                    &nbsp;
                    <button type="button" class="btn btn-light btn-sm">
                        <a href="javascript:history.back()" class="text-decoration-none text-dark">
                            ← Back
                        </a>
                    </button>
                </div>
            </div>

            @php
                // Determine if this is a name transfer case (has parent_id)
                $hasParent = isset($registration) && !empty($registration->parent_id);

                // Define tabs based on parent_id existence
                $tabsList = [];
                if ($hasParent) {
                    $tabsList = [
                        [
                            'id' => 1,
                            'name' => 'Allottee Details',
                            'icons' => 'fa-solid fa-user',
                            'active' => true,
                            'key' => 'allottee_details',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Contact Details',
                            'icons' => 'fa-solid fa-phone',
                            'active' => false,
                            'key' => 'contact_details',
                        ],
                        [
                            'id' => 3,
                            'name' => 'Documents',
                            'icons' => 'fa-solid fa-file-alt',
                            'active' => false,
                            'key' => 'documents',
                        ],
                    ];
                } else {
                    $tabsList = [
                        [
                            'id' => 1,
                            'name' => 'Allottee Details',
                            'icons' => 'fa-solid fa-user',
                            'active' => true,
                            'key' => 'allottee_details',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Contact Details',
                            'icons' => 'fa-solid fa-phone',
                            'active' => false,
                            'key' => 'contact_details',
                        ],
                        [
                            'id' => 3,
                            'name' => 'Property Details',
                            'icons' => 'fa-solid fa-home',
                            'active' => false,
                            'key' => 'property_details',
                        ],
                        [
                            'id' => 4,
                            'name' => 'EMI & Financial Details',
                            'icons' => 'fa-solid fa-money-bill',
                            'active' => false,
                            'key' => 'financial_details',
                        ],
                        [
                            'id' => 5,
                            'name' => 'Nominee Details',
                            'icons' => 'fa-solid fa-user-friends',
                            'active' => false,
                            'key' => 'nominee_details',
                        ],
                        [
                            'id' => 6,
                            'name' => 'Documents',
                            'icons' => 'fa-solid fa-file-alt',
                            'active' => false,
                            'key' => 'documents',
                        ],
                    ];
                }
            @endphp

            <div class="card-body mt-2">
                {{-- Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        {{ session('error') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- File Information Table --}}
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-info">
                            <tr>
                                <th colspan="4" class="text-center bg-secondary text-white">File Information</th>
                            </tr>
                            <tr>
                                <th width="25%">Field</th>
                                <th width="25%">Value</th>
                                <th width="25%">Field</th>
                                <th width="25%">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Register No</strong></td>
                                <td>{{ $registration->register_id ?? 'N/A' }}</td>
                                <td><strong>Property No</strong></td>
                                <td>{{ $registration->property_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Division</strong></td>
                                <td>{{ $registration->division->name ?? 'N/A' }}</td>
                                <td><strong>Sub Division</strong></td>
                                <td>{{ $registration->subDivision->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Property Category</strong></td>
                                <td>{{ $registration->propertyCategory->name ?? 'N/A' }}</td>
                                <td><strong>Property Type</strong></td>
                                <td>{{ $registration->propertyType->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Quarter Type</strong></td>
                                <td>{{ $registration->quarterType->quarter_name ?? 'N/A' }}</td>
                                <td><strong>Total Pages</strong></td>
                                <td>{{ $registration->total_pages ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Name Transfer Status</strong></td>
                                <td>
                                    @if (isset($registration->name_transfer_status))
                                        <span
                                            class="badge {{ $registration->name_transfer_status == 'yes' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($registration->name_transfer_status) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td><strong>Free Hold Status</strong></td>
                                <td>
                                    @if (isset($registration->free_hold_status))
                                        <span
                                            class="badge {{ $registration->free_hold_status == 'yes' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($registration->free_hold_status) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Created By</strong></td>
                                <td>{{ $registration->Usercreator->name ?? 'N/A' }}</td>
                                <td><strong>Created On</strong></td>
                                <td>{{ isset($registration->created_at) ? \Carbon\Carbon::parse($registration->created_at)->format('d-m-Y H:i:s') : 'N/A' }}
                                </td>
                            </tr>
                            @if ($hasParent)
                                <tr>
                                    <td><strong>Parent Name</strong></td>
                                    <td colspan="3">
                                        {{ isset($registration->parent_id) ? getAllotteeName($registration->parent_id) : 'N/A' }}
                                    </td>
                                </tr>
                            @endif

                            @if (!empty($registration->allottee_document_path))
                                <tr>
                                    <th class="bg-light" width="20%">Document Folder</th>
                                    <td colspan="8">
                                        {{ $registration->allottee_document_path }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Tab Navigation --}}
                <ul class="nav nav-tabs mb-3" id="filePreviewTab" role="tablist">
                    @foreach ($tabsList as $tab)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $tab['active'] ? 'active' : '' }}" id="tab-{{ $tab['key'] }}"
                                data-bs-toggle="tab" data-bs-target="#content-{{ $tab['key'] }}" type="button"
                                role="tab">
                                <i class="{{ $tab['icons'] }}"></i> {{ $tab['name'] }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content">
                    {{-- Tab 1: Allottee Details --}}
                    <div class="tab-pane fade {{ $tabsList[0]['active'] ? 'show active' : '' }}"
                        id="content-allottee_details" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%" class="bg-light">Full Name (English)</th>
                                        <td colspan="6">
                                            {{ trim(($registration->prefix ?? '') . ' ' . ($registration->allottee_name ?? '') . ' ' . ($registration->allottee_middle_name ?? '') . ' ' . ($registration->allottee_surname ?? '')) ?: 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Full Name (Hindi)</th>
                                        <td colspan="6">
                                            {{ trim(($registration->allottee_prefix_hindi ?? '') . ' ' . ($registration->allottee_name_hindi ?? '') . ' ' . ($registration->allottee_middle_hindi ?? '') . ' ' . ($registration->allottee_surname_hindi ?? '')) ?: 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Father/Relation Type</th>
                                        <td>{{ $registration->allottee_relation_type ?? 'N/A' }}</td>
                                        <th class="bg-light" colspan="3">Relation Name</th>
                                        <td>{{ $registration->relation_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Gender</th>
                                        <td>{{ $registration->allottee_gender ?? 'N/A' }}</td>
                                        <th class="bg-light" colspan="3">Marital Status</th>
                                        <td>{{ $registration->marital_status ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Category</th>
                                        <td>{{ $registration->allottee_category ?? 'N/A' }}</td>
                                        <th class="bg-light" colspan="3">Religion</th>
                                        <td>{{ $registration->allottee_religion ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Nationality</th>
                                        <td>{{ $registration->allottee_nationality ?? 'N/A' }}</td>
                                        <th class="bg-light" colspan="3">Age at Application</th>
                                        <td>{{ $registration->age_number_of_birth_application ?? 'N/A' }} Years</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Application No</th>
                                        <td>{{ $registration->application_no ?? 'N/A' }}</td>
                                        <th class="bg-light" colspan="3">Application Date</th>
                                        <td>{{ ($registration->application_day ?? '') . '/' . ($registration->application_month ?? '') . '/' . ($registration->application_year ?? '') ?: 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Allotment No</th>
                                        <td>{{ $registration->allotment_no ?? 'N/A' }}</td>
                                        <th class="bg-light" colspan="3">Allotment Date</th>
                                        <td>{{ ($registration->allotment_day ?? '') . '/' . ($registration->allotment_month ?? '') . '/' . ($registration->allotment_year ?? '') ?: 'N/A' }}
                                        </td>
                                    </tr>

                                    @if (!$hasParent && isset($registration->accountLedger))
                                        <tr>
                                            <th class="bg-light">EMI Status</th>
                                            <td>
                                                <span
                                                    class="badge {{ ($registration->accountLedger->emi_status ?? '') == 'Close' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $registration->accountLedger->emi_status ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <th class="bg-light">Completed EMIs</th>
                                            <td>{{ $registration->accountLedger->completed_emi ?? '0' }}</td>
                                        </tr>
                                    @endif

                                    @if ($hasParent)
                                        <tr>
                                            <th class="bg-light">This file is a name transfer from</th>
                                            <td colspan="6">
                                                {{ isset($registration->parent_id) ? getAllotteeName($registration->parent_id) : 'N/A' }}
                                            </td>
                                        </tr>

                                        @php
                                            $jointAllottees = $registration->jointAllottees ?? collect();
                                        @endphp

                                        {{-- Joint Allottees --}}
                                        @if ($jointAllottees->count() > 0)
                                            <tr class="table-info">
                                                <td colspan="6" class="text-center"><strong>Joint Allottees</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Aadhar No.</th>
                                                <th>Pan No.</th>
                                                <th>Other Documents</th>
                                            </tr>
                                            @foreach ($jointAllottees as $index => $joint)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ trim(($joint->prefix ?? '') . ' ' . ($joint->first_name ?? '') . ' ' . ($joint->middle_name ?? '') . ' ' . ($joint->last_name ?? '')) ?: 'N/A' }}
                                                    </td>
                                                    <td>{{ $joint->gender ?? 'N/A' }}</td>
                                                    <td>{{ $joint->aadhar_number ?? 'N/A' }}</td>
                                                    <td>{{ $joint->pan_number ?? 'N/A' }}</td>
                                                    <td>{{ $joint->other_doc_number ?? 'N/A' }} {{ ($joint->other_doc_type ?? 'N/A') }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tab 2: Contact & Address Details --}}
                    <div class="tab-pane fade" id="content-contact_details" role="tabpanel">
                        @php
                            $address = $registration->alloteeAdresses ?? null;
                        @endphp

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <tbody>
                                    <tr class="table-warning">
                                        <th colspan="2">Contact Details</th>
                                    </tr>
                                    <tr>
                                        <th width="30%" class="bg-light">Mobile Number</th>
                                        <td>{{ $address->mobile_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Alternate Mobile</th>
                                        <td>{{ $address->alternate_mobile ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">WhatsApp Number</th>
                                        <td>{{ $address->whatsapp_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Landline</th>
                                        <td>{{ isset($address->stdCode) && $address->stdCode ? $address->stdCode . '-' : '' }}{{ $address->landline ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Email Address</th>
                                        <td>{{ $address->email ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="table-warning">
                                        <th colspan="2">{{ ucfirst($address->relation_type ?? 'Relation') }} Details
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">{{ ucfirst($address->relation_type ?? 'Relation') }} Name</th>
                                        <td>{{ trim(($address->prefix_relation_eng ?? '') . ' ' . ($address->relation_name ?? '')) ?: 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">{{ ucfirst($address->relation_type ?? 'Relation') }} Address
                                        </th>
                                        <td>{{ $address->relation_address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">{{ ucfirst($address->relation_type ?? 'Relation') }} State /
                                            District</th>
                                        <td>State:
                                            {{ isset($address->relation_state) ? getStateName($address->relation_state) : 'N/A' }}
                                            | District:
                                            {{ isset($address->relation_district) ? getDistrictName($address->relation_district) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">{{ ucfirst($address->relation_type ?? 'Relation') }} PIN / PO
                                            / PS</th>
                                        <td>PIN: {{ $address->relation_pincode ?? 'N/A' }} | PO:
                                            {{ $address->relation_post_office ?? 'N/A' }} | PS:
                                            {{ $address->relation_police_station ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="table-warning">
                                        <th colspan="2">Communication Address</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Present Address</th>
                                        <td>{{ $address->present_address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Present State / District</th>
                                        <td>State:
                                            {{ isset($address->present_state) ? getStateName($address->present_state) : 'N/A' }}
                                            | District:
                                            {{ isset($address->present_district) ? getDistrictName($address->present_district) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Present PIN / PO / PS</th>
                                        <td>PIN: {{ $address->present_pincode ?? 'N/A' }} | PO:
                                            {{ $address->present_post_office ?? 'N/A' }} | PS:
                                            {{ $address->present_police_station ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="table-warning">
                                        <th colspan="2">Permanent Address</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Permanent Address</th>
                                        <td>{{ $address->permanent_address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Permanent State / District</th>
                                        <td>State:
                                            {{ isset($address->permanent_state) ? getStateName($address->permanent_state) : 'N/A' }}
                                            | District:
                                            {{ isset($address->permanent_district) ? getDistrictName($address->permanent_district) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Permanent PIN / PO / PS</th>
                                        <td>PIN: {{ $address->permanent_pincode ?? 'N/A' }} | PO:
                                            {{ $address->permanent_post_office ?? 'N/A' }} | PS:
                                            {{ $address->permanent_police_station ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tab 3: Property Details (Only for non-parent_id) --}}
                    @if (!$hasParent)
                        <div class="tab-pane fade" id="content-property_details" role="tabpanel">
                            @php
                                $property = $registration->allotProFinDetail ?? null;
                                $emi = $registration->accountLedger ?? ($registration->account_ledger ?? null);
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <tbody>
                                        <tr class="table-warning">
                                            <th colspan="2">Property Information</th>
                                        </tr>
                                        <tr>
                                            <th width="30%" class="bg-light">Property Number</th>
                                            <td>{{ $registration->property_number ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Colony Name</th>
                                            <td>{{ $property->colony_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Plot Number</th>
                                            <td>{{ $property->plot_number ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Area</th>
                                            <td>{{ $property->area_sqft ?? '0' }} Sq. Ft.</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Location</th>
                                            <td>{{ trim(($property->mohalla ?? '') . ', ' . ($property->city ?? '') . ', PO: ' . ($property->post_office ?? '') . ', PS: ' . ($property->police_station ?? '')) ?: 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">State / District</th>
                                            <td>State: {{ $property->state ?? 'N/A' }} | District:
                                                {{ $property->district ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="table-warning">
                                            <th colspan="2">Boundary Details</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">North Boundary</th>
                                            <td>{{ $property->north_boundary ?? 'N/A' }}@if (!empty($property->ew_north))
                                                    ({{ $property->ew_north }} ft)
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">South Boundary</th>
                                            <td>{{ $property->south_boundary ?? 'N/A' }}@if (!empty($property->ew_south))
                                                    ({{ $property->ew_south }} ft)
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">East Boundary</th>
                                            <td>{{ $property->east_boundary ?? 'N/A' }}@if (!empty($property->ns_east))
                                                    ({{ $property->ns_east }} ft)
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">West Boundary</th>
                                            <td>{{ $property->west_boundary ?? 'N/A' }}@if (!empty($property->ns_west))
                                                    ({{ $property->ns_west }} ft)
                                                @endif
                                            </td>
                                        </tr>

                                        <tr class="table-warning">
                                            <th colspan="2">Financial Details</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Tentative Price</th>
                                            <td>₹ {{ number_format($property->tentative_price ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Amount in Words</th>
                                            <td>{{ $property->amount_words ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Deposited Amount</th>
                                            <td>₹ {{ number_format($property->deposited_amount ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Remaining Amount</th>
                                            <td class="text-danger fw-semibold">₹
                                                {{ number_format($property->remaining_amount ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Legal Fee</th>
                                            <td>₹ {{ number_format($property->legal_fee ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Legal Document Fee</th>
                                            <td>₹ {{ number_format($property->legal_document_fee ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Deposit Type</th>
                                            <td>{{ ucfirst($property->deposit_type ?? 'N/A') }}</td>
                                        </tr>

                                        <tr class="table-warning">
                                            <th colspan="2">Interest & Payment Terms</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Payment Months</th>
                                            <td>{{ $property->payment_months ?? '0' }} Months</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Payment Start Date</th>
                                            <td>{{ isset($property->payment_start_month) ? \Carbon\Carbon::create()->month($property->payment_start_month)->format('F') : '' }}
                                                {{ $property->payment_start_year ?? '' }}</td>
                                        <tr>
                                        <tr>
                                            <th class="bg-light">Interest Mode</th>
                                            <td>{{ ucfirst($property->interest_calculation_mode ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Interest Type</th>
                                            <td>{{ ucfirst($property->interest_type ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Pre Interest</th>
                                            <td>{{ $property->pre_interest ?? '0' }}%@if (!empty($property->pre_interest_amount))
                                                    (₹ {{ number_format($property->pre_interest_amount, 2) }})
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Late Interest</th>
                                            <td>{{ $property->late_interest ?? '0' }}%@if (!empty($property->late_interest_amount))
                                                    (₹ {{ number_format($property->late_interest_amount, 2) }})
                                                @endif
                                            </td>
                                        </tr>

                                        <tr class="table-warning">
                                            <th colspan="2">Allotment & Due Dates</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Allotment Date</th>
                                            <td>{{ sprintf('%02d', $property->allot_day ?? 0) }}-{{ sprintf('%02d', $property->allot_month ?? 0) }}-{{ $property->allot_year ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Last Date for Payment</th>
                                            <td>{{ sprintf('%02d', $property->last_day ?? 0) }}-{{ sprintf('%02d', $property->last_month ?? 0) }}-{{ $property->last_year ?? 'N/A' }}
                                                @if (!empty($property->specified_days))
                                                    <span class="text-muted">({{ $property->specified_days }})</span>
                                                @endif
                                            </td>
                                        </tr>

                                        @if ($emi)
                                            <tr class="table-warning">
                                                <th colspan="2">EMI Summary</th>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Total EMI Count</th>
                                                <td>{{ $emi->total_emi_count ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Completed EMI</th>
                                                <td>{{ $emi->completed_emi ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Remaining EMI</th>
                                                <td>{{ $emi->remaining_emi ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">EMI Status</th>
                                                <td><span
                                                        class="badge bg-{{ ($emi->emi_status ?? '') === 'Close' ? 'success' : 'warning' }}">{{ $emi->emi_status ?? 'Pending' }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Tab 4: EMI Financial Details --}}
                        <div class="tab-pane fade" id="content-financial_details" role="tabpanel">
                            @php
                                $emi = $registration->accountLedger ?? null;
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-primary">
                                        <tr>
                                            <th colspan="4" class="text-center">EMI Financial Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th width="25%" class="bg-light">Calculation Type</th>
                                            <td>{{ ucfirst($emi->calculation_type ?? 'N/A') }}</td>
                                            <th width="25%" class="bg-light">EMI Status</th>
                                            <td><span
                                                    class="badge bg-{{ ($emi->emi_status ?? '') === 'Close' ? 'success' : 'warning' }}">{{ $emi->emi_status ?? 'N/A' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Total Amount</th>
                                            <td>₹ {{ number_format($emi->total_amount ?? 0) }}</td>
                                            <th class="bg-light">Total EMI Count</th>
                                            <td>{{ $emi->total_emi_count ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Start Month / Year</th>
                                            <td>{{ isset($emi->start_month) ? date('F Y', mktime(0, 0, 0, $emi->start_month, 1)) : '' }}
                                                {{ $emi->start_year ?? 'N/A' }}</td>
                                            <th class="bg-light">Last EMI</th>
                                            <td>{{ $emi->last_emi_month ?? 'N/A' }} {{ $emi->last_emi_year ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">EMI Without Penalty</th>
                                            <td>₹ {{ number_format($emi->amount_without_penalty ?? 0) }}</td>
                                            <th class="bg-light">EMI With Penalty</th>
                                            <td>₹ {{ number_format($emi->amount_with_penalty ?? 0) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Completed EMI</th>
                                            <td>{{ $emi->completed_emi ?? 0 }}</td>
                                            <th class="bg-light">Remaining EMI</th>
                                            <td>{{ $emi->remaining_emi ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Late EMI</th>
                                            <td>{{ $emi->late_emi ?? 0 }}</td>
                                            <th class="bg-light">Expected EMI</th>
                                            <td>{{ $emi->expected_emi ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Total Paid</th>
                                            <td class="text-success fw-bold">₹ {{ number_format($emi->total_paid ?? 0) }}
                                            </td>
                                            <th class="bg-light">Total Remaining</th>
                                            <td class="text-danger fw-bold">₹
                                                {{ number_format($emi->total_remaining ?? 0) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Current Balance</th>
                                            <td>₹ {{ number_format($emi->current_balance ?? 0) }}</td>
                                            <th class="bg-light">Payment Gap</th>
                                            <td>{{ $emi->payment_gap ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">EMI Active</th>
                                            <td><span
                                                    class="badge bg-{{ ($emi->emi_active ?? 'no') === 'yes' ? 'success' : 'secondary' }}">{{ ucfirst($emi->emi_active ?? 'No') }}</span>
                                            </td>
                                            <th class="bg-light">Created At</th>
                                            <td>{{ optional($emi?->created_at)->format('d M Y h:i A') ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Tab 5: Nominee & Joint Allottee Details --}}
                        <div class="tab-pane fade" id="content-nominee_details" role="tabpanel">
                            @php
                                $nominee = $registration->nominees_bank ?? null;
                                $jointAllottees = $registration->joint_allottees ?? collect();
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-warning">
                                        <tr>
                                            <th colspan="2" class="text-center">Nominee Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-light">
                                            <th colspan="2">Nominee Details</th>
                                        </tr>
                                        <tr>
                                            <th width="30%" class="bg-light">Nominee Name</th>
                                            <td>{{ trim(($nominee->nominee_prefix ?? '') . ' ' . ($nominee->nominee_name ?? '')) ?: 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Relationship</th>
                                            <td>{{ $nominee->nominee_relationship ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Aadhaar Number</th>
                                            <td>{{ $nominee->nominee_aadhaar ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">PAN Number</th>
                                            <td>{{ $nominee->nominee_pan_card ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="table-light">
                                            <th colspan="2">Family Member Details</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Family Member Name</th>
                                            <td>{{ trim(($nominee->family_name_prefix ?? '') . ' ' . ($nominee->family_name ?? '')) ?: 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Gender</th>
                                            <td>{{ $nominee->family_gender ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Date of Birth</th>
                                            <td>{{ optional($nominee?->family_dob)->format('d M Y') ?? ($nominee->family_dob ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Relationship</th>
                                            <td>{{ $nominee->family_relationship ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Aadhaar Number</th>
                                            <td>{{ $nominee->family_aadhaar ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">PAN Number</th>
                                            <td>{{ $nominee->family_pan ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="table-light">
                                            <th colspan="2">Bank Details</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Bank Name</th>
                                            <td>{{ $nominee->bank_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Branch Name</th>
                                            <td>{{ $nominee->bank_branch ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Account Holder Name</th>
                                            <td>{{ $nominee->bank_account_holder ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Account Number</th>
                                            <td>{{ $nominee->bank_account_no ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">IFSC Code</th>
                                            <td>{{ $nominee->bank_ifsc ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if ($jointAllottees->count() > 0)
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-info">
                                            <tr>
                                                <th colspan="6" class="text-center">Joint Allottees</th>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Relationship</th>
                                                <th>Aadhaar Number</th>
                                                <th>PAN Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jointAllottees as $index => $joint)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ trim(($joint->prefix ?? '') . ' ' . ($joint->first_name ?? '') . ' ' . ($joint->middle_name ?? '') . ' ' . ($joint->last_name ?? '')) ?: 'N/A' }}
                                                    </td>
                                                    <td>{{ $joint->gender ?? 'N/A' }}</td>
                                                    <td>{{ $joint->relationship ?? 'N/A' }}</td>
                                                    <td>{{ $joint->aadhar_number ?? 'N/A' }}</td>
                                                    <td>{{ $joint->pan_number ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Tab Documents (Common for both) --}}
                    <div class="tab-pane fade" id="content-documents" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-warning">
                                    <tr>
                                        <th colspan="9" class="text-center">
                                            Allottee Documents
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Doc No.</th>
                                        <th width="12%">Date</th>
                                        <th width="22%">Document Name</th>
                                        <th width="15%">File Name</th>
                                        <th width="15%">Additional Info</th>
                                        <th width="12%">Remarks</th>
                                        <th width="8%">Status</th>
                                        <th width="8%">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($registration->documentData ?? [] as $index => $doc)
                                        @php
                                            $document = $doc->document;
                                            $hasFile = !empty($doc->file_name) && !empty($doc->file_path);

                                            $docDate =
                                                $document &&
                                                $document->doc_day &&
                                                $document->doc_month &&
                                                $document->doc_year
                                                    ? sprintf(
                                                        '%02d-%02d-%s',
                                                        $document->doc_day,
                                                        $document->doc_month,
                                                        $document->doc_year,
                                                    )
                                                    : 'N/A';
                                        @endphp

                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $doc->doc_no ?? 'N/A' }}</td>

                                            <td>{{ $docDate }}</td>

                                            <td>
                                                {{ $document->document_name ?? 'N/A' }}

                                                @if (!empty($document?->document_category))
                                                    <br>
                                                    <small class="text-info">
                                                        {{ strtoupper($document->document_category) }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>{{ $doc->file_name ?? 'N/A' }}</td>

                                            <td>{{ $doc->additional_info ?? 'N/A' }}</td>

                                            <td>{{ $doc->remarks ?? 'N/A' }}</td>

                                            <td>
                                                <span class="badge bg-{{ $hasFile ? 'success' : 'secondary' }}">
                                                    {{ $hasFile ? 'Uploaded' : 'Pending' }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($hasFile)
                                                    <a href="{{ asset($doc->file_path) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        View
                                                    </a>
                                                @else
                                                    <span class="text-muted small">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                No documents available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Step Information --}}
                @if (isset($registration->current_step) || isset($registration->step_remarks))
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th colspan="2" class="text-center text-white">Workflow Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="30%" class="bg-light">Current Step</th>
                                    <td>{{ $registration->current_step ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Step Completed</th>
                                    <td><span
                                            class="badge {{ ($registration->is_step_completed ?? 0) == 1 ? 'bg-success' : 'bg-warning' }}">{{ ($registration->is_step_completed ?? 0) == 1 ? 'Yes' : 'No' }}</span>
                                    </td>
                                </tr>
                                @if (($registration->name_transfer_status ?? '') == 'yes')
                                    <tr>
                                        <th class="bg-light">Transaction Entry Completed</th>
                                        <td><span
                                                class="badge {{ ($registration->is_trans_entry_completed ?? 0) == 1 ? 'bg-success' : 'bg-warning' }}">{{ ($registration->is_trans_entry_completed ?? 0) == 1 ? 'Yes' : 'No' }}</span>
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($registration->step_remarks))
                                    <tr>
                                        <th class="bg-light">Step Remarks</th>
                                        <td>{{ $registration->step_remarks }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Verify BUtton center --}}
                <div class="d-flex justify-content-center my-4">
                    <a href="{{ route('admin.lots.dataentry.file.approve', $registration->encrypted_id) }}"
                        class="btn btn-primary btn-lg">
                        Verify Data Entry
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var triggerTabList = [].slice.call(document.querySelectorAll('#filePreviewTab button'))
            triggerTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        })
    </script>
@endsection
