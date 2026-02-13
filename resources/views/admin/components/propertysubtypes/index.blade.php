@extends('admin.layouts.main')

@section('admin-content')
<div class="container-xxl flex-grow-1 ">
    <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Property Sub Type</span>
    </h6>
    <div class="card mb-4">
        <h5 class="card-header text-white bg-info">Property Sub Type</h5>
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
                            <th>Category</th>
                            <th>Property Type</th>
                            <th>Property Sub Type</th>
                            <th>Status</th>
                            <th>Created On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($propertySubTypes as $key => $propertysubType)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td class="fw-semibold">
                                {{ $propertysubType->propertyCategory->name ?? '—' }}
                            </td>

                            <td class="fw-semibold">
                                {{ $propertysubType->propertyType->name ?? '—' }}
                            </td>

                            <td class="fw-semibold">
                                {{ $propertysubType->name }}
                            </td>

                            <td>
                                @if ($propertysubType->status == 1)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <td>
                                {{ $propertysubType->created_at ? $propertysubType->created_at : '—' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.propertysubtypes.fetch', $propertysubType->encode_id) }}"
                                    class="text-warning me-2" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>

                                @if ($propertysubType->status == 1)
                                <a href="{{ route('admin.propertysubtypes.delete', $propertysubType->encode_id) }}"
                                    class="text-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                    <i class="bx bx-trash"></i>
                                </a>
                                @endif

                                @if ($propertysubType->status == 0)
                                <a href="{{ route('admin.propertysubtypes.delete', $propertysubType->encode_id) }}"
                                    class="text-success" onclick="return confirm('Activate this Sub type?')"
                                    title="Activate">
                                    <i class="bx bx-check-circle"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No Property Sub type found.
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