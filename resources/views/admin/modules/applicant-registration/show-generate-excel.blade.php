@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-4"><span class="invert-text-white">Registration Certificate / Generate Excel </span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Generate Excel</h5>
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

                <form action="{{ route('range-cert-excel') }}" method="post">
                    @csrf
                    <div class="row mt-3">
                        <h5>Certificate Regn. No. Range Wise Excel Generate</h5>
                        <hr>
                        <div class="col-md-3 mb-3">
                            <label for="cert_from" class="form-label">Certificate S.No. From <small
                                    class="text-danger">*</small></label>
                            <input type="number" name="cert_from" id="cert_from"
                                class="form-control @error('cert_from') is-invalid @enderror" value="{{ old('cert_from') }}" required>

                                @error('cert_from')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="cert_to" class="form-label">Certificate S.No. To <small
                                    class="text-danger">*</small></label>
                            <input type="number" name="cert_to" id="cert_to"
                                class="form-control @error('cert_to') is-invalid @enderror" value="{{ old('cert_to') }}" required>

                                @error('cert_to')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <input type="submit" value="Export Excel" class="btn btn-info mt-4">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
