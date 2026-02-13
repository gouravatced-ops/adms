@extends('applicant.dashboard_layouts.main')

@section('title', 'Account Settings')

@section('page-title', 'Account Settings')

@section('content')
    <style>
        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .custom-input-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-input {
            width: 100%;
            padding: 10px 40px 10px 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            outline: none;
            transition: all 0.2s ease;
        }

        .custom-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
            display: flex;
            align-items: center;
        }

        .password-toggle:hover {
            color: #2563eb;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
    <!-- Change Password Card -->
    <div class="card mt-4">
        <div class="modern-card-header">
            <div class="header-flex">
                <div>
                    <h1 class="header-title">Change Password</h1>
                    <p class="header-subtitle">Update your account password securely</p>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('password.update') }}" method="POST" class="form-body">
            @csrf
            <!-- Single Allottee Section -->
            <div class="dynamic-section">
                <div class="form-grid">
                    <!-- Dynamic Property Number Field -->
                    <div class="field">
                        <label class="label required property-number-label">
                            Name
                        </label>
                        <input type="text" class="property-number-input" value="{{ $studentRegis['name'] }}" readonly>
                    </div>

                    <!-- Dynamic Property Number Field -->
                    <div class="field">
                        <label class="label required">
                            Mobile.
                        </label>
                        <input type="text" class="property-number-input" value="{{ $studentRegis['mobile_no'] }}"
                            readonly>
                    </div>

                    <!-- New Password -->
                    <div class="field">
                        <label class="label required">New Password</label>

                        <div class="custom-input-wrapper">
                            <input type="password" name="newPassword" id="newPassword"
                                class="custom-input @error('newPassword') is-invalid @enderror"
                                placeholder="Enter new password">

                            <span class="password-toggle" data-target="newPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </span>
                        </div>

                        @error('newPassword')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="field">
                        <label class="label required">Confirm New Password</label>

                        <div class="custom-input-wrapper">
                            <input type="password" name="newPassword_confirmation" id="confirmPassword" class="custom-input"
                                placeholder="Confirm new password">

                            <span class="password-toggle" data-target="confirmPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Form Footer with Submit Button -->
            <div class="form-footer">
                <button type="submit" class="submit-btn">
                    Update Password
                    <svg viewBox="0 0 24 24">
                        <path d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const toggles = document.querySelectorAll(".password-toggle");

            toggles.forEach(function(toggle) {

                toggle.addEventListener("click", function() {

                    const input = document.getElementById(this.dataset.target);
                    const svg = this.querySelector("svg");

                    if (input.type === "password") {
                        input.type = "text";

                        svg.innerHTML = `
                    <path d="M17.94 17.94A10.94 10.94 0 0112 20C5 20 1 12 1 12a21.77 21.77 0 015.06-7.94M9.9 4.24A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.82 21.82 0 01-4.16 5.94M1 1l22 22"/>
                `;
                    } else {
                        input.type = "password";

                        svg.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
                    }

                });

            });

        });
    </script>
@endpush
