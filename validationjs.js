    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Only Numbers (0-9)
            document.querySelectorAll(".only-number").forEach(function(input) {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/[^0-9]/g, "");
                });
            });

            // Only Alphabets (A-Z + space)
            document.querySelectorAll(".only-alphabet").forEach(function(input) {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
                });
            });

                        document.querySelectorAll(".only-hindi").forEach(function(input) {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/[^\u0900-\u097F\s]/g, "");
                });
            });

            // Only Email Allowed Characters
            document.querySelectorAll(".only-email").forEach(function(input) {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/[^a-zA-Z0-9@._\-]/g, "");
                });
            });

            // Address Field (Text + Number + / . , - @)
            document.querySelectorAll(".only-address").forEach(function(input) {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/[^a-zA-Z0-9\s\/\.,\-@]/g, "");
                });
            });

            // Only Hindi + special characters
            document.querySelectorAll(".only-hindi-address").forEach(function(input) {
                input.addEventListener("input", function() {

                    this.value = this.value.replace(
                        /[^\u0900-\u097F\s\/\.,\-@]/g,
                        ""
                    );

                });
            });

            // Mobile Number (+ and numbers only)
            document.querySelectorAll(".only-mobile").forEach(function(input) {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/[^0-9+]/g, "");

                    // Ensure + only at start
                    if (this.value.indexOf('+') > 0) {
                        this.value = this.value.replace(/\+/g, '');
                    }
                });
            });


            document.querySelectorAll(".alpha-num-dash").forEach(function(input) {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/[^a-zA-Z0-9\-]/g, "");
                });
            });
        });
    </script>