$(document).ready(function () {

    const $inputs = $('.otp-input, .numeral-mask');
    const $otpField = $('[name="otp"]');
    if ($inputs.length) {
        $inputs.first().focus();
    }

    function updateOTP() {
        let otp = '';
        $inputs.each(function () {
            otp += $(this).val();
        });
        $otpField.val(otp);
    }

    $inputs.on('input', function () {
        // Allow only numbers
        this.value = this.value.replace(/[^0-9]/g, '');

        if (this.value.length === this.maxLength) {
            $(this).next($inputs).focus();
        }

        updateOTP();
    });

    $inputs.on('keydown', function (e) {
        if (e.key === 'Backspace' && this.value === '') {
            $(this).prev($inputs).focus().val('');
            updateOTP();
        }
    });

    $('#twoStepsForm').on('submit', function (e) {
        e.preventDefault();

        let isValid = true;

        $inputs.each(function () {
            if ($(this).val() === '') {
                isValid = false;
                alert('Please enter OTP');
                $(this).focus();
                return false;
            }
        });

        if (isValid) {
            $("#jspc-loader").removeClass('d-none');
            $("#loading-text").text("Validating your account OTP.");

            $(this).off('submit').submit();
        }
    });

});
