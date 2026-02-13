@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Head Quaters</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">HeadQuaters</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mx-3 mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible mx-3 mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table id="studentListTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Headquarter Name</th>
                                <th>Status</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($headquarters as $key => $hq)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td class="fw-semibold">
                                        {{ $hq->name }}
                                    </td>

                                    <td>
                                        @if ($hq->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $hq->created_at ? $hq->created_at : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No headquarters found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
