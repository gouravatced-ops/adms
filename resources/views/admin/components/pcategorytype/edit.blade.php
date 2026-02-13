@extends('admin.layouts.main')

@section('admin-content')
<div class="container-xxl flex-grow-1 ">
    <h6 class="py-3 mb-2"><span class="invert-text-white">Dashboard / Edit Property Type</span>
    </h6>

    <div class="card mb-4">
        <h5 class="card-header text-white bg-info">Edit Property Type</h5>
        <div class="card-body mt-2">
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @php
                $propertyCategories = getPropertyCategory();
            @endphp
            <form action="{{ route('admin.pcategorytype.update', $encode_id) }}" method="POST"
                class="row g-3 align-items-end">
                @csrf
                @method('PUT')

                <!-- Division Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">
                        Category Type <small class="text-danger">*</small>
                    </label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="" selected> -- select category -- </option>
                        @foreach ($propertyCategories as $categorie)
                        <option value="{{ $categorie->id }}" {{ $categorie->id == $pcategorytype->category_id ? 'selected' : '' }}>{{ $categorie->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Division Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">
                        Name of Type <small class="text-danger">*</small>
                    </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Division Name"
                        value="{{ old('name', $pcategorytype->name) }}">
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">
                        Status <small class="text-danger">*</small>
                    </label>

                    <select class="form-select" id="status" name="status" required>
                        <option value="1" {{ old('status', $pcategorytype->status) == 1 ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ old('status', $pcategorytype->status) == 0 ? 'selected' : '' }}>
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