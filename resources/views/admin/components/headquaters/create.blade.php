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
                <form action="{{ route('headquarters.store') }}" method="POST" class="row g-3 align-items-end">
                    @csrf

                    <!-- Headquarters Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Name of Headquarters <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Headquarters Name" required>
                    </div>

                    <!-- Status (Optional) -->
                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            Status <small class="text-danger">*</small>
                        </label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection