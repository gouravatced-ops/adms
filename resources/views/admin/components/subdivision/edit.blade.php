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
                @php
                    $divisions = getDivisions();
                @endphp
                <form action="{{ route('admin.subdivision.update', $encode_id) }}" method="POST"
                    class="row g-3 align-items-end">
                    @csrf
                    @method('PUT')

                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Divisions <small class="text-danger">*</small>
                        </label>
                        <select name="division_id" id="division_id" class="form-control">
                            <option value="" selected> -- select division -- </option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ $division->id == $subdivision->division_id ? 'selected' : '' }}>{{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Name of Sub Division <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Division Name" value="{{ old('name', $subdivision->name) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="subdivision_code" class="form-label">
                            Sub Division Code <small class="text-danger">*</small> (e.g HR for Ranchi Division->Harmu Colony
                            Sub Division)
                        </label>
                        <input type="text" class="form-control" id="subdivision_code" name="subdivision_code"
                            placeholder="Enter Sub Division Code"
                            value="{{ old('subdivision_code', $subdivision->subdivision_code) }}">
                    </div>

                    <!-- Colony Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Colony Name <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="colony_name" name="colony_name"
                            placeholder="Sub Division Colony Name" value="{{ old('colony_name', $subdivision->colony_name) }}">
                    </div>

                    <!-- Locality Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Locality Address <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="locality_address" name="locality_address"
                            placeholder="Sub Division Locality Address" value="{{ old('locality_address', $subdivision->locality_address) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            Status <small class="text-danger">*</small>
                        </label>

                        <select class="form-select" id="status" name="status" required>
                            <option value="1" {{ old('status', $subdivision->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0" {{ old('status', $subdivision->status) == 0 ? 'selected' : '' }}>
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
