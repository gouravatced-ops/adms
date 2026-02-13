@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Add Property Sub Type</span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Add Property Sub Type</h5>
            <div class="card-body mt-2">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @php
                    $pcategoryType = getpcategoryType();
                @endphp
                <form action="{{ route('admin.propertysubtypes.store') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Property Type <small class="text-danger">*</small>
                        </label>
                        <select name="ptype_id" id="ptype_id" class="form-control">
                            @foreach ($pcategoryType as $type)
                                <option value="{{ $type->id }}">{{ $type->propertyCategory->name }} --
                                    {{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Division Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            Name of Type <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter type Name">
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
