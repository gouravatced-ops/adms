@extends('applicant.auth_layouts.main')

@section('title', 'Online Certificate Renewal | Jharkhand State Housing Board | Ranchi | Jharkhand | India')

@section('content')
    <div class="col-lg-8 mb-3 pr-35 md-pr-15">
        <div class="row">
            <div class="col-lg-12 pr-40 md-pr-15 md-mb-50">
                <div class="sec-title4">
                    <span class="sub-text">Online Certificate Renewal</span>
                    <h2 class="title">Register yourself for Certificate Renewal</h2>
                    <div class="heading-line"></div>

                    {{-- <div class="card mt-3">
                        <div class="card-header bg-primary text-white">
                            <span>
                                Fee Calculator
                            </span>
                        </div>
                        <div class="container my-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="state">State</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="General">General</option>
                                        <option value="OBC">OBC</option>
                                        <option value="ST">ST</option>
                                        <option value="SC">SC</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="resultDate">Result Issuance Date</label>
                                    <input type="date" name="resultDate" id="resultDate" class="form-control"
                                        max="<?php echo date('Y-m-d'); ?>">
                                    <div class="invalid-feedback">
                                        Please enter a Issuance Date.
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4 pt-2">
                                    <input type="button" class="btn btn-success" id="calculateFee" value="Show Fees">
                                </div>

                            </div>
                            <table class="table-bordered my-4" id="feeTable" border="1" width="100%"
                                style="display:none;">
                                <thead class="bg-primary text-white py-4 text-center">
                                    <th>Basic Fee</th>
                                    <th>Late Fee</th>
                                    <th>Total Fee</th>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td><b id="basicFee"></b></td>
                                        <td><b id="lateFee"></b></td>
                                        <td><b id="totalFee"></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}

                    <div class="card my-3">
                        <div class="card-header bg-danger text-warning">
                            <span>Pay JSPC, Ranchi for Certificate Renewal Charge</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a class="btn btn-outline-success" href="https://www.iobnet.co.in/iobpay/entry.do"
                                        rel="nofollow" target="_blank"><span>Click
                                            Here to Pay</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card my-3"  style="background-image: linear-gradient(to right,rgba(255,0,0,0), rgba(218, 136, 239, 0.37),rgba(255,0,0,0) );">
                        <div class="card-header bg-warning text-white">
                            <span>Fee Structure</span>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <h5>Jharkhand Affiliated Colleges</h5>
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th>Fee</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>1000</td>
                                            <td>For all category students</td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>200 per year</td>
                                            <td>Late Fee for General & OBC category students</td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>100 per year</td>
                                            <td>Late Fee for ST & SC category students</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h5>Other States</h5>
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th>Fee</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>1000</td>
                                            <td>For all category students</td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>200 per year</td>
                                            <td>Late Fee for General & OBC category students</td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>100 per year</td>
                                            <td>Late Fee for ST & SC category students</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 order-last">
        <div class="container">
            <div class="login-container" style="max-width: 400px; margin: 100px auto;">
                <div class="card shadow">
                    <div class="card-header mt-2 py-2" style="background-color: white">
                        <h2 class="card-title text-center"
                            style="font-family: 'Arial', sans-serif;color: #950858;font-size: 28px;line-height: 26px;font-weight: 800;z-index: 1;background-image: linear-gradient(to right,rgba(255,0,0,0), rgba(218, 136, 239, 0.37),rgba(255,0,0,0) );">
                            Login</h2>
                    </div>
                    <div class="card-body" style="background-image: linear-gradient(to right,rgba(255,0,0,0), rgba(218, 136, 239, 0.37),rgba(255,0,0,0) );">
                        <div class="text-end mb-3">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Register New User</a>
                        </div>

                        @if (session('LoginError'))
                            <div class="alert alert-danger">
                                {{ session('LoginError') }}
                            </div>
                        @endif

                        <form action="{{ route('login.submit') }}" id="loginForm" method="POST" class="no-validation">
                            @csrf
                            <div class="mb-3">
                                <label for="mobileNumber" class="form-label">Mobile Number</label>
                                <input type="tel" name="mobileNumber"
                                    class="form-control @error('password') is-invalid @enderror" id="mobileNumber"
                                    value="{{ old('mobileNumber') }}" pattern="[0-9]{10}" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}" id="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('forgot-password') }}" class="text-muted">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const $togglePassword = $('#togglePassword');
            const $password = $('#password');

            function togglePasswordVisibility($inputField, $button) {
                const type = $inputField.attr('type') === 'password' ? 'text' : 'password';
                $inputField.attr('type', type);
                $button.find('i').toggleClass('fa-eye fa-eye-slash');
            }

            $togglePassword.on('click', function() {
                togglePasswordVisibility($password, $togglePassword);
            });

            $('#loginForm').on('submit', function(e) {
                // e.preventDefault();
                // Show loader
                $("#jspc-loader").removeClass('d-none');
                $("#loading-text").text(
                    "Validating your account. An OTP has been sent to your mobile number.");

                // Disable the submit button to prevent multiple submissions
                $('#submitButton').prop('disabled', true);

                // Let the form continue its submission
            });
        });
    </script>
@endpush
