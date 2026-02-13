@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Quaters</span>
        </h6>
        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Quaters</h5>
            <div class="card-body mt-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="studentListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Quarter Type</th>
                                <th>Income Range</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quarterTypes as $key => $quarter)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <span class="badge bg-info">{{ $quarter->quarter_code }}</span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $quarter->quarter_name }}</div>
                                        @if ($quarter->quarter_full_name)
                                            <small class="text-muted">{{ $quarter->quarter_full_name }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        @if (is_null($quarter->min_income) && is_null($quarter->max_income))
                                            <span class="text-muted">Any Income</span>
                                        @elseif(is_null($quarter->min_income))
                                            Up to ₹{{ number_format($quarter->max_income, 2) }} lakh
                                        @elseif(is_null($quarter->max_income))
                                            Above ₹{{ number_format($quarter->min_income, 2) }} lakh
                                        @else
                                            ₹{{ number_format($quarter->min_income, 2) }} -
                                            ₹{{ number_format($quarter->max_income, 2) }} lakh
                                        @endif
                                    </td>

                                    <td>
                                        @if ($quarter->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $quarter->created_at->format('d M Y') }}
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.quarter-types.edit', $quarter->quarter_id) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>

                                            @if ($quarter->status == 1)
                                                <form
                                                    action="{{ route('admin.quarter-types.destroy', $quarter->quarter_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="return confirm('Delete {{ $quarter->quarter_code }}?')"
                                                        title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form
                                                    action="{{ route('admin.quarter-types.destroy', $quarter->quarter_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Activate">
                                                        <i class="bx bx-check-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No quarter types found. <a href="{{ route('admin.quarter-types.create') }}">Add
                                            one</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
