@extends('admin.layouts.main')

@section('admin-content')
<style>
    .user-profile-header-banner img {
        width: 100%;
        object-fit: cover;
        height: 120px
    }

    .user-profile-header {
        margin-top: -2rem
    }

    .user-profile-header .user-profile-img {
        border: 5px solid;
        width: 120px
    }

    .light-style .user-profile-header .user-profile-img {
        border-color: #fff
    }

    .dark-style .user-profile-header .user-profile-img {
        border-color: #2b2c40
    }

    .dataTables_wrapper .card-header .dataTables_filter label {
        margin-top: 0 !important;
        margin-bottom: 0 !important
    }

    @media(max-width: 767.98px) {
        .user-profile-header-banner img {
            height: 150px
        }

        .user-profile-header .user-profile-img {
            width: 100px
        }
    }
</style>
{{-- <link rel="stylesheet" href="{{ asset('assets/admin/core1.css') }}" /> --}}

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row fv-plugins-icon-container">
        <div class="col-md-12">
            <div class="nav-align-top mb-3">
                <ul class="nav nav-pills flex-column flex-md-row mb-6">
                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                                class="bx bx-sm bx-user me-1_5"></i> Account</a></li>
                </ul>
            </div>
            <div class="card mb-6 p-2">

                <div class="card-body pt-4">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible mx-3 mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible mx-3 mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif
                    <form id="formAccountSettings" method="POST" action="{{ route('update.admin-details') }}"
                        class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                            <img src="{{ !empty(auth()->user()->profile_path) ? asset(auth()->user()->profile_path) : asset('assets/admin/assets/img/logo.png') }}"
                                alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">
                            &nbsp;&nbsp;&nbsp;<div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Choose new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="file"
                                        class="account-file-input @error('file') is-invalid @enderror" hidden=""
                                        accept="image/png, image/jpeg">
                                </label>

                                &nbsp;&nbsp;<div>Allowed JPG, GIF or PNG. Max size of 200K</div>

                                @error('file')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-6">
                            <div class="col-md-6 mb-2 fv-plugins-icon-container">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    id="name" name="name" value="{{ auth()->user()->admin_name }}"
                                    autofocus="">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="email" name="email" value="{{ auth()->user()->email_id }}"
                                    placeholder="Enter E-mail" readonly>
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="mobile_no ">Mobile Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">IN (+91)</span>
                                    <input type="text" id="mobile_no" name="mobile_no"
                                        class="form-control @error('mobile_no ') is-invalid @enderror"
                                        value="{{ auth()->user()->mobile_no }}" maxlength=10>
                                    @error('mobile_no ')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if(auth()->user()->role == 'approver')
                                @php
                                $divisions = getDivisions();
                                @endphp
                                <div class="col-md-6 mb-2">
                                    <label class="form-label" for="division_id">Division</label>
                                    <select class="form-select @error('division_id') is-invalid @enderror" name="division_id" disabled>
                                        @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}" {{ auth()->user()->division_id == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- <div class="col-md-6 mb-2">
                                    <label class="form-label" for="designation ">Designation</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="designation" name="designation"
                                            class="form-control @error('designation ') is-invalid @enderror"
                                            value="{{ auth()->user()->designation }}">
                                    </div>
                                </div> -->
                            @endif
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="newPassword">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="newPassword" name="newPassword"
                                        autocomplete="new-password"
                                        class="form-control @error('newPassword') is-invalid @enderror"
                                        placeholder="Enter new password">

                                    <span class="input-group-text cursor-pointer toggle-password">
                                        <i class="bx bx-hide"></i>
                                    </span>

                                    @error('newPassword')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="newPassword_confirmation">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="newPassword_confirmation"
                                        name="newPassword_confirmation" class="form-control"
                                        placeholder="Confirm new password">

                                    <span class="input-group-text cursor-pointer toggle-password">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="captcha">Captcha</label>
                                </div>

                                <div class="input-group input-group-merge">
                                    <!-- Captcha Image -->
                                    <span class="input-group-text p-1" id="captcha-image">
                                        {!! captcha_img('flat') !!}
                                    </span>

                                    <!-- Captcha Input -->
                                    <input type="text" id="captcha" name="captcha" required
                                        class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter captcha"
                                        aria-describedby="captcha" autocomplete="off" />

                                    <!-- Refresh Button -->
                                    <span class="input-group-text cursor-pointer" id="reload-captcha">
                                        <i class="bx bx-refresh"></i>
                                    </span>
                                </div>

                                @error('captcha')
                                <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="my-6">
                    <button type="submit" class="btn btn-primary me-3">Save changes</button>
                </div>
                <input type="hidden">
                </form>
            </div>
        </div>
        <!-- /Account -->
    </div>
</div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const toggleButtons = document.querySelectorAll(".toggle-password");

        toggleButtons.forEach(function(button) {
            button.addEventListener("click", function() {

                const input = this.closest(".input-group").querySelector("input");
                const icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("bx-hide");
                    icon.classList.add("bx-show");
                } else {
                    input.type = "password";
                    icon.classList.remove("bx-show");
                    icon.classList.add("bx-hide");
                }

            });
        });

    });
</script>

<script>
    // JavaScript to handle the real-time image preview
    document.getElementById('upload').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Set the `src` of the image to the file content
                document.getElementById('uploadedAvatar').src = e.target.result;
            };

            // Read the file content as a data URL
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush