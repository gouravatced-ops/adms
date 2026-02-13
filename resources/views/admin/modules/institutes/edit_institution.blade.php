<!-- resources/views/admins/create.blade.php -->
@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-4"><span class="invert-text-white">Affliated College / Edit Affliated College</span>
        </h6>
        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Edit Affliated College</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mx-3 mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible mx-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-body mt-2">
                <form action="{{ route('update.affiliated-college', $data->code) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <textarea id="name" name="name" class="form-control @error('name') is-invalid @enderror">{{ old('name', $data->name) }}</textarea>

                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror"">{{ old('address', $data->address) }}</textarea>

                                    @error('address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror""
                                    value="{{ old('city', $data->city) }}">

                                    @error('city')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="district">District:</label>
                                <input type="text" id="district" name="district" class="form-control @error('district') is-invalid @enderror""
                                    value="{{ old('district', $data->district) }}">

                                    @error('district')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="pin">Pin Code:</label>
                                <input type="text" id="pin" name="pin" class="form-control @error('pin') is-invalid @enderror""
                                    value="{{ old('pin', $data->pin) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6)"
                                    maxlength="6">

                                    @error('pin')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="state">State:</label>
                                <input type="text" id="state" name="state" class="form-control @error('state') is-invalid @enderror""
                                    value="{{ old('state', $data->state) }}">

                                    @error('state')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="primary_mobile_no">Primary Mobile No:</label>
                                <input type="text" id="primary_mobile_no" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" maxlength="10" name="primary_mobile_no" class="form-control @error('primary_mobile_no') is-invalid @enderror""
                                    value="{{ old('primary_mobile_no', $data->primary_mobile_no) }}">

                                    @error('primary_mobile_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="alternate_mobile_no">Alternate Mobile No:</label>
                                <input type="text" id="alternate_mobile_no" name="alternate_mobile_no"
                                    class="form-control @error('alternate_mobile_no') is-invalid @enderror"" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" maxlength="10"
                                    value="{{ old('alternate_mobile_no', $data->alternate_mobile_no) }}">

                                    @error('alternate_mobile_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="whatsapp_mobile_no">WhatsApp No:</label>
                                <input type="text" id="whatsapp_mobile_no" name="whatsapp_mobile_no" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" maxlength="10"
                                    class="form-control @error('whatsapp_mobile_no') is-invalid @enderror""
                                    value="{{ old('whatsapp_mobile_no', $data->whatsapp_mobile_no) }}">

                                    @error('whatsapp_mobile_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror""
                                    value="{{ old('email', $data->email) }}">

                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="website">Website:</label>
                                <input type="test" id="website" name="website" class="form-control @error('website') is-invalid @enderror""
                                    value="{{ old('website', $data->website) }}">

                                    @error('website')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <label for="principal_name">Principal Name:</label>
                                <input type="text" id="principal_name" name="principal_name" class="form-control @error('principal_name') is-invalid @enderror""
                                    value="{{ old('principal_name', $data->principal_name) }}">

                                    @error('principal_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="javascript:void(0);" class="btn btn-danger" onclick="window.history.back();">Back</a>
  {{-- <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancel</a> --}}
                </form>
            </div>
        </div>
    </div>
@endsection
