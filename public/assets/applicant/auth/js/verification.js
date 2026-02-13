//  Calculate Fees
function calculateFee(resultDate, category, state) {
    // console.clear();
    var currentDate = new Date();
    var diffYears = currentDate.getFullYear() - resultDate.getFullYear();
    var monthDiff = currentDate.getMonth() - resultDate.getMonth();
    var dayDiff = currentDate.getDate() - resultDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff <= 0)) {
        diffYears--;
    }

    // Set the basic fee based on category and state
    // var basicFee = (category.toLowerCase() === 'general' || category.toLowerCase() === 'obc') ? 1500 : 750;
    // basicFee = (state.toLowerCase() == 'jharkhand') ? basicFee : 3000;

    var basicFee = 1000;

    // Calculate the late fee
    var lateFee = 0;
    if (diffYears >= 1) {
        if (state.toLowerCase() == 'jharkhand') {
            lateFee = (category.toLowerCase() === 'general' || category.toLowerCase() === 'obc') ? 200 : 100;
            lateFee *= diffYears;
        } else {
            lateFee = 200;
            lateFee *= diffYears;
        }
    }

    var totalFee = basicFee + lateFee;

    return {
        basicFee: basicFee,
        lateFee: lateFee,
        totalFee: totalFee
    };
}

function getAllExpiryDates() {
    const expiryInputs = document.querySelectorAll('.cert-expiry-date');
    const expiryDates = [];

    expiryInputs.forEach(input => {
        if (input.value) {
            expiryDates.push({
                element: input,
                value: input.value,
                date: new Date(input.value)
            });
        }
    });

    // Sort by date (earliest to latest)
    expiryDates.sort((a, b) => a.date - b.date);

    return expiryDates;
}

// Send OTP
function sendOTP() {
    var mobileNumber = document.getElementById('mobile_no').value;
    $("#jspc-loader").removeClass('d-none');
    $("#mobile_no").removeClass("is-invalid");
    if (mobileNumber.length == 10 && mobileNumber != null) {
        fetch("/send-otp"
            , {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    mobile_number: mobileNumber
                })
            })
            .then(response => response.json())
            .then(data => {
                // console.log("Response from send OTP:", data); // Debugging
                // alert(data.message);
                $("#jspc-loader").addClass('d-none');
                if (data.type === 'success') {
                    // Display the OTP input section
                    document.getElementById('otpSection').style.display = 'block';

                    // Change the button text to "Resend OTP"
                    document.getElementById('SendOtp').value = 'Resend OTP';

                    // Start the countdown (2 minutes = 120 seconds)
                    var countdownDuration = 2 * 60; // 2 minutes in seconds
                    var $countdownElement = $('#countdown');
                    var $resendElement = $('#SendOtp');

                    // Disable the "Resend OTP" button initially
                    $resendElement.addClass('disabled').css({
                        'pointer-events': 'none',
                        'opacity': '0.6'
                    });

                    // Start the countdown
                    var countdownInterval = setInterval(function () {
                        var minutes = Math.floor(countdownDuration / 60);
                        var seconds = countdownDuration % 60;

                        // Display the countdown
                        $countdownElement.text(
                            "Resend available in " +
                            (minutes < 10 ? '0' + minutes : minutes) + ":" +
                            (seconds < 10 ? '0' + seconds : seconds)
                        );

                        countdownDuration--;

                        // If countdown ends
                        if (countdownDuration < 0) {
                            clearInterval(countdownInterval); // Clear the interval
                            $countdownElement.text(''); // Clear the countdown text

                            // Enable the "Resend OTP" button
                            $resendElement.removeClass('disabled').css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });
                        }
                    }, 1000); // Run the function every second
                }
                else if (data.type === 'exists') {
                    $("#mobile_no").addClass("is-invalid");
                    $('#mobile_no').siblings('.invalid-feedback').text(data.message);
                }
            })
            .catch(error => {
                // console.error('Error:', error);
                $("#jspc-loader").addClass('d-none');
                // alert('Failed to send OTP');
            });
    } else {
        $("#mobile_no").addClass("is-invalid");
        $("#jspc-loader").addClass('d-none');
    }
}

$("#otp").change(function () {
    verifyOTP();
});

// Verify OTP
function verifyOTP() {
    var mobileNumber = document.getElementById('mobile_no').value;
    $("#mobile_no").removeClass("is-invalid");
    var otp = document.getElementById('otp').value;
    if (otp.length == 6 && otp && mobileNumber.length == 10 && mobileNumber != null) {
        fetch('/verify-otp',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    otp: otp,
                    mobile_number: mobileNumber
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.type === 'error') {
                    $("#otp").addClass('is-invalid').removeClass('is-valid');
                    $("#verifyFeed").html(data.message);
                } else {
                    $("#otp").addClass('is-valid').removeClass('is-invalid');
                    $("#submitBtn").prop('disabled', false);
                }
            })
            .catch(error => {
                // console.error('Error:', error);
                // $("#mobileOtp").addClass('is-valid').removeClass('is-invalid');
                // $("#verifyFeed").html(data.message);
                // $("#submitBtn").prop('disabled', false);
            });
    } else {
        $("#otp").addClass('is-invalid').removeClass('is-valid');
        $("#verifyFeed").html('You have entered wrong OTP.');
    }

}

//  Validate Aadhaar
function validateAadhaar(input) {
    const aadhaarValue = input.value.replace(/[^0-9]/g, '').slice(0, 12);
    input.value = aadhaarValue;

    // Regex for detecting repeating digits (e.g., 111111111111) or alternating patterns (e.g., 121212121212)
    const repeatedPattern = /^(\d)\1{11}$/;
    const alternatingPattern = /^(\d)(\d)\1\2\1\2\1\2\1\2\1\2$/;
    const errorSpan = document.getElementById('aadhaar-error');

    if (repeatedPattern.test(aadhaarValue)) {
        errorSpan.textContent = 'Aadhaar number cannot be a repeating number.';
    } else if (alternatingPattern.test(aadhaarValue)) {
        errorSpan.textContent = 'Aadhaar number cannot be an alternating pattern.';
    } else {
        errorSpan.textContent = ''; // Clear the error message
    }
}

// Validate Form
function validateForm() {
    let isValid = true;

    // Remove existing 'is-invalid' classes
    $('form.needs-validation').find('.is-invalid').removeClass('is-invalid');

    // Check all required inputs and selects
    $('form.needs-validation').find('input[required], select[required]').each(function () {
        if ($(this).val().trim() === '') {
            $(this).addClass('is-invalid');
            isValid = false;
        }
    });

    // Check if passwords match
    let password = $('#password').val();
    let cnfPassword = $('#password_confirmation').val();
    if (password !== cnfPassword) {
        $('#password, #password_confirmation').addClass('is-invalid');
        isValid = false;
    }

    // If form is valid, submit it
    if (isValid) {
        // console.clear();
        $("#jspc-loader").removeClass('d-none');
        $('form.needs-validation')[0].submit();
    }
}

// Validate Password and Show and Hide Password in Registration

$(document).ready(function () {
    const $password = $('#password');
    const $confirmPassword = $('#password_confirmation');
    const $submitBtn = $('#submitBtn');
    const $togglePassword = $('#togglePassword');
    const $toggleConfirmPassword = $('#toggleConfirmPassword');
    const $passwordHelp = $("#passwordHelpBlock");
    const $passwordFeedback = $('<div id="passwordFeedback"></div>').insertBefore($passwordHelp);

    function validatePassword() {
        const password = $password.val();
        const confirmPassword = $confirmPassword.val();

        const conditions = [{
            regex: /.{8,}/,
            message: "At least 8 characters."
        },
        {
            regex: /[A-Z]/,
            message: "At least one uppercase letter."
        },
        {
            regex: /[a-z]/,
            message: "At least one lowercase letter."
        },
        {
            regex: /[0-9]/,
            message: "At least one number."
        },
        {
            regex: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/,
            message: "At least one special character."
        }

        ];

        let isValid = true;
        let feedbackHtml = '';

        conditions.forEach(condition => {
            const meetsCondition = condition.regex.test(password);
            isValid = isValid && meetsCondition;
            feedbackHtml += `<div class="${meetsCondition ? 'text-success' : 'text-danger'}">
                        <i class="fas fa-${meetsCondition ? 'check' : 'times'}"></i> ${condition.message}
                     </div>`;
        });

        $passwordHelp.html(feedbackHtml);

        const doMatch = password === confirmPassword;
        $confirmPassword.toggleClass('is-invalid', !doMatch && confirmPassword.length > 0);

        if (confirmPassword.length > 0) {
            feedbackHtml += `<div class="${doMatch ? 'text-success' : 'text-danger'}">
                        <i class="fas fa-${doMatch ? 'check' : 'times'}"></i> Passwords match
                     </div>`;
        }

        $passwordHelp.html(feedbackHtml);
        $submitBtn.prop('disabled', !(isValid && doMatch));
    }

    $password.on('input', validatePassword);
    $confirmPassword.on('input', validatePassword);

    function togglePasswordVisibility($inputField, $button) {
        const type = $inputField.attr('type') === 'password' ? 'text' : 'password';
        $inputField.attr('type', type);
        $button.find('i').toggleClass('fa-eye fa-eye-slash');
    }

    $togglePassword.on('click', function () {
        togglePasswordVisibility($password, $togglePassword);
    });

    $toggleConfirmPassword.on('click', function () {
        togglePasswordVisibility($confirmPassword, $toggleConfirmPassword);
    });

    // Initial validation
    validatePassword();
});

$(document).ready(function () {
    // console.clear();

    $('#calculateFee').click(function () {
        const allExpiries = getAllExpiryDates();
        const mostRecentExpiry = allExpiries[allExpiries.length - 1];
        console.log('Most recent expiry:', mostRecentExpiry?.value);

        var issDate = mostRecentExpiry?.value;
        var category = $('#category').val();
        var state = $('#state').val();

        if (issDate && category && state) {
            $('#resultDate').removeClass('is-invalid');
            $('#category').removeClass('is-invalid');
            $('#state').removeClass('is-invalid');

            var resultDate = new Date(issDate);

            // Call the calculateFee function and get the fee details
            var feeDetails = calculateFee(resultDate, category, state);

            // Display the fee details
            $('#feeTable').show();
            $('#basicFee').text('Rs. ' + feeDetails.basicFee);
            $('#lateFee').text('Rs. ' + feeDetails.lateFee);
            $('#totalFee').text('Rs. ' + feeDetails.totalFee);
        } else {
            if (!issDate) {
                $('#resultDate').addClass('is-invalid');
            }
            if (!category) {
                $('#category').addClass('is-invalid');
            }
            if (!state) {
                $('#state').addClass('is-invalid');
            }
        }
    });

    // Handle form submission
    $('#submitBtn').on('click', function (event) {
        event.preventDefault();
        // console.clear();
        validateForm();
        // console.clear();
    });
});

// Applicant Payment Form
$(document).ready(function () {
    // console.clear();
    $('#resultDate, #category, #state').change(function () {
        const allExpiries = getAllExpiryDates();
        const mostRecentExpiry = allExpiries[allExpiries.length - 1];
        console.log('Most recent expiry:', mostRecentExpiry?.value);

        var issDate = mostRecentExpiry?.value;

        var category = $('#category').val();
        var state = $('#state').val();

        if (issDate && category && state) {
            $('#resultDate').removeClass('is-invalid');
            $('#category').removeClass('is-invalid');
            $('#state').removeClass('is-invalid');

            var resultDate = new Date(issDate);

            // Call the calculateFee function and get the fee details
            var feeDetails = calculateFee(resultDate, category, state);

            // Display the fee details
            $("#amount").val(feeDetails.totalFee);

        } else {
            if (!issDate) {
                $('#resultDate').addClass('is-invalid');
            }
            if (!category) {
                $('#category').addClass('is-invalid');
            }
            if (!state) {
                $('#state').addClass('is-invalid');
            }
        }
    });
});
