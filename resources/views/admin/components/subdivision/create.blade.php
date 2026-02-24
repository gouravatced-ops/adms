@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Add Sub Divisions</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Add Sub Divisions</h5>
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
                <form action="{{ route('admin.subdivision.store') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Divisions <small class="text-danger">*</small>
                        </label>
                        <select name="division_id" id="division_id" class="form-control">
                            <option value="" selected> -- select division -- </option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Name of Sub Division <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Sub Division Name">
                    </div>

                    <div class="col-md-6">
                        <label for="subdivision_code" class="form-label">
                            Sub Division Code <small class="text-danger">*</small>  (e.g HR for Ranchi Division->Harmu Colony Sub Division)
                        </label>
                        <input type="text" class="form-control" id="subdivision_code" name="subdivision_code"
                            placeholder="Enter Sub Division Code">
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            Status <small class="text-danger">*</small>
                        </label>

                        <select class="form-select" id="status" name="status" required>
                            <option value="1">
                                Active
                            </option>
                            <option value="0">
                                Inactive
                            </option>
                        </select>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
