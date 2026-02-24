@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Edit Divisions</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Edit Divisions</h5>
            <div class="card-body mt-2">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('admin.division.update', $encode_id) }}" method="POST"
                    class="row g-3 align-items-end">
                    @csrf
                    @method('PUT')
                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Name of Division <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Division Name" value="{{ old('name', $division->name) }}">
                    </div>

                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="division_code" class="form-label">
                            Division Code <small class="text-danger">*</small>  (e.g RNC for Ranchi Division)
                        </label>
                        <input type="text" class="form-control" id="division_code" name="division_code"
                            placeholder="Enter Division Code" value="{{ old('division_code', $division->division_code) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            Status <small class="text-danger">*</small>
                        </label>

                        <select class="form-select" id="status" name="status" required>
                            <option value="1" {{ old('status', $division->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0" {{ old('status', $division->status) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
