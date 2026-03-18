// ============================================
// STEP 1 HANDLER - Allottee Details
// ============================================
const Step1Handler = {
    manager: null, // Will be set by StepManager
    
    init: function() {
        console.log('Step 1 Handler Initialized');
        this.bindEvents();
        this.initializeFields();
    },

    bindEvents: function() {
        // Year validation
        const yearInput = document.getElementById("allotmentYear");
        const applicationYearSelect = document.getElementById("application_year");
        const errorText = document.getElementById("yearError");

        if (yearInput) {
            yearInput.addEventListener("input", (e) => this.validateYear(e, applicationYearSelect, errorText));
        }

        // Application year change
        if (applicationYearSelect) {
            applicationYearSelect.addEventListener("change", (e) => this.handleApplicationYearChange(e));
        }

        // Allotment year change (for PAN/Aadhar toggle)
        const allotmentYear = document.getElementById('allotment_year');
        if (allotmentYear) {
            allotmentYear.addEventListener('change', () => this.togglePanAadhar());
        }

        // DOB calculation
        ['date_of_birth_day', 'date_of_birth_month', 'date_of_birth_year'].forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.addEventListener('change', () => this.calculateAge());
            }
        });

        // Input restrictions
        this.applyInputRestrictions();
    },

    initializeFields: function() {
        // Initial PAN/Aadhar toggle
        this.togglePanAadhar();
        
        // Initial age calculation if DOB exists
        this.calculateAge();
    },

    validateYear: function(e, applicationYearSelect, errorText) {
        let value = e.target.value.trim().replace(/[^0-9]/g, '');
        e.target.value = value;

        if (value.length !== 4) {
            e.target.classList.remove("invalid-year");
            if (errorText) errorText.textContent = "";
            return;
        }

        const currentYear = new Date().getFullYear();
        const minYear = 1950;
        const appYear = parseInt(applicationYearSelect?.value || 0);
        const allotYear = parseInt(value);

        if (allotYear < minYear || allotYear > currentYear) {
            e.target.classList.add("invalid-year");
            if (errorText) {
                errorText.textContent = `Year must be between ${minYear} and ${currentYear}`;
            }
            return;
        }

        if (appYear && allotYear < appYear) {
            e.target.classList.add("invalid-year");
            if (errorText) {
                errorText.textContent = `Allotment Year cannot be less than Application Year (${appYear})`;
            }
            return;
        }

        e.target.classList.remove("invalid-year");
        if (errorText) errorText.textContent = "";
    },

    handleApplicationYearChange: function(e) {
        let appYear = parseInt(e.target.value);
        let allotSelect = document.getElementById("allotment_year");

        if (!appYear) return;

        Array.from(allotSelect.options).forEach(option => {
            if (!option.value) return;
            let allotYear = parseInt(option.value);
            option.hidden = allotYear < appYear;
        });

        if (parseInt(allotSelect.value) < appYear) {
            allotSelect.value = "";
        }
    },

    togglePanAadhar: function() {
        const yearInput = document.getElementById('allotment_year');
        const panField = document.getElementById('pan-field');
        const aadharField = document.getElementById('aadhar-field');

        if (!yearInput || !panField || !aadharField) return;

        const year = yearInput.value ? parseInt(yearInput.value) : null;
        const show = year && year >= 2009;

        panField.style.display = show ? 'block' : 'none';
        aadharField.style.display = show ? 'block' : 'none';
    },

    calculateAge: function() {
        const day = document.querySelector('[name="date_of_birth_day"]')?.value;
        const month = document.querySelector('[name="date_of_birth_month"]')?.value;
        const year = document.querySelector('[name="date_of_birth_year"]')?.value;

        if (!day || !month || !year) return;

        const dob = new Date(year, month - 1, day);
        const today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        const ageField = document.getElementById("current_age");
        if (ageField) {
            ageField.value = age + " years";
            ageField.readOnly = true;
        }
    },

    applyInputRestrictions: function() {
        // Only Numbers (0-9)
        document.querySelectorAll(".only-number").forEach(input => {
            input.addEventListener("input", function() {
                this.value = this.value.replace(/[^0-9]/g, "");
            });
        });

        // Only Alphabets (A-Z + space)
        document.querySelectorAll(".only-alphabet").forEach(input => {
            input.addEventListener("input", function() {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
            });
        });

        // Only Hindi
        document.querySelectorAll(".only-hindi").forEach(input => {
            input.addEventListener("input", function() {
                this.value = this.value.replace(/[^\u0900-\u097F\s]/g, "");
            });
        });

        // PAN Card Format: ABCDE1234F
        document.querySelectorAll(".pan-input").forEach((input) => {
            input.addEventListener("input", function () {
                // Convert to uppercase
                this.value = this.value.toUpperCase();

                // Remove invalid characters
                this.value = this.value.replace(/[^A-Z0-9]/g, "");

                // Limit length to 10
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
        });
    },

    validate: function() {
        const form = document.querySelector('#step1Form');
        if (!form) return true;

        let valid = true;
        let firstInvalid = null;

        // Required fields validation
        const requiredFields = [ 'allotment_month', 'allotment_year',
            'allottee_name', 'allotmentYear','allottee_category', 'allottee_religion',
            //, 'allottee_name_hindi', 'allottee_surname_hindi',
            // 'relation_name', 'marital_status', 'allottee_gender',
        ];

        requiredFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
                if (!firstInvalid) firstInvalid = field;
            }
        });

        // Check year validation
        const yearField = document.getElementById('allotmentYear');
        if (yearField && yearField.classList.contains('invalid-year')) {
            valid = false;
            if (!firstInvalid) firstInvalid = yearField;
        }

        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        return valid;
    },

    destroy: function() {
        console.log('Step 1 Handler Destroyed');
        // Clean up any global event listeners if needed
    }
};

// Register with StepManager
StepManager.registerHandler(1, Step1Handler);