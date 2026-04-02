// ============================================
// STEP 3 HANDLER - Property Financial Details
// ============================================
const Step3Handler = {
    manager: null,

    init: function () {
        console.log("Step 3 Handler Initialized");
        this.bindEvents();
        this.initializeCalculations();
    },

    // Utility function to parse numbers
    num: function (v) {
        return parseFloat(v) || 0;
    },

    // Disable all financial fields
    disableAllFields: function () {
        const ids = [
            // "high_income_percent",
            // "low_income_percent",
            // "deposited_amount",
            // "legal_fee",
            // "legal_document_fee",
            // "total_payment",
            // "interim_price",
            // "remaining_amount",
            // "payment_months",
            // "interest_type",
            // "pre_interest",
            // "late_interest",
            // "pre_interest_amount",
            // "late_interest_amount",
        ];

        ids.forEach((id) => {
            const el = document.getElementById(id);
            if (el) el.disabled = true;
        });
    },

    // Enable specific fields
    enableFields: function (fieldIds) {
        fieldIds.forEach((id) => {
            const el = document.getElementById(id);
            if (el) el.disabled = false;
        });
    },

    // Set auto-calculated field value
    setAutoValue: function (id, value) {
        const input = document.getElementById(id);
        if (!input) return;

        input.value = value.toFixed(2);
        input.disabled = true;

        // Create hidden input for form submission if not exists
        let hidden = document.querySelector(
            `input[type=hidden][name="${input.name}"]`,
        );
        if (!hidden && input.name) {
            hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = input.name;
            input.parentNode.appendChild(hidden);
        }
        if (hidden) {
            hidden.value = value.toFixed(2);
        }
    },

    bindEvents: function () {
        // Tentative price input
        const tentative = document.getElementById("tentative_price");
        if (tentative) {
            tentative.addEventListener("input", (e) =>
                this.handleTentativePrice(e),
            );
        }

        // High/Low income percent inputs
        const high = document.getElementById("high_income_percent");
        const low = document.getElementById("low_income_percent");

        if (high) {
            high.addEventListener("input", (e) =>
                this.handlePercentInput(e, "high"),
            );
        }
        if (low) {
            low.addEventListener("input", (e) =>
                this.handlePercentInput(e, "low"),
            );
        }

        // Legal fee inputs
        const legalFee = document.getElementById("legal_fee");
        const legalDocFee = document.getElementById("legal_document_fee");

        if (legalFee) {
            legalFee.addEventListener("input", () => this.calculateTotal());
        }
        if (legalDocFee) {
            legalDocFee.addEventListener("input", () => this.calculateTotal());
        }

        // Interest calculation triggers
        [
            "payment_months",
            "interest_type",
            "pre_interest",
            "late_interest",
        ].forEach((id) => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener("input", () => this.calculateInterest());
                el.addEventListener("change", () => this.calculateInterest());
            }
        });

        // EMI calculation
        const emiInput = document.getElementById("payment_months");
        const monthInput = document.getElementById("payment_start_month");
        const yearInput = document.getElementById("payment_start_year");

        [emiInput, monthInput, yearInput].forEach((el) => {
            if (el) {
                el.addEventListener("input", () => this.calculateLastEMI());
                el.addEventListener("change", () => this.calculateLastEMI());
            }
        });

        // State-District cascading (if present in step 3)
        document
            .querySelectorAll(".state-select, .state-select-hindi")
            .forEach((select) => {
                select.addEventListener("change", this.loadDistricts);
            });

        // Input restrictions
        this.applyInputRestrictions();
    },

    initializeCalculations: function () {
        // Disable all fields initially
        this.disableAllFields();

        // Check if tentative price has value and trigger calculations
        const tentative = document.getElementById("tentative_price");
        if (tentative && tentative.value) {
            this.handleTentativePrice({ target: tentative });
        }
    },

    handleTentativePrice: function (e) {
        const value = e.target.value;
        if (value) {
            this.enableFields(["high_income_percent", "low_income_percent"]);
            this.setAutoValue("interim_price", this.num(value));
        } else {
            this.disableAllFields();
        }
    },

    handlePercentInput: function (e, type) {
        // Clear the other percent field
        if (type === "high") {
            const low = document.getElementById("low_income_percent");
            if (low) low.value = "";
        } else {
            const high = document.getElementById("high_income_percent");
            if (high) high.value = "";
        }

        this.calculateDeposit();
    },

    calculateDeposit: function () {
        const tentative = document.getElementById("tentative_price");
        const high = document.getElementById("high_income_percent");
        const low = document.getElementById("low_income_percent");

        if (!tentative) return;

        const P = this.num(tentative.value);
        const percent = this.num(high?.value || low?.value);

        if (percent > 0) {
            this.enableFields(["legal_fee", "legal_document_fee"]);
        }

        const deposit = (P * percent) / 100;
        this.setAutoValue("deposited_amount", deposit);

        this.calculateRemaining();
        this.calculateTotal();
    },

    calculateRemaining: function () {
        const tentative = document.getElementById("tentative_price");
        const deposited = document.getElementById("deposited_amount");

        if (!tentative || !deposited) return;

        const P = this.num(tentative.value);
        const d = this.num(deposited.value);

        const remaining = P - d;
        this.setAutoValue("remaining_amount", remaining);

        if (remaining > 0) {
            this.enableFields([
                "payment_months",
                "interest_type",
                "pre_interest",
                "late_interest",
            ]);
        }
    },

    calculateTotal: function () {
        const deposited = document.getElementById("deposited_amount");
        const legalFee = document.getElementById("legal_fee");
        const legalDocFee = document.getElementById("legal_document_fee");

        if (!deposited || !legalFee || !legalDocFee) return;

        const d = this.num(deposited.value);
        const l1 = this.num(legalFee.value);
        const l2 = this.num(legalDocFee.value);

        const total = d - l1 + l2;
        this.setAutoValue("total_payment", total);

        this.calculateRemaining();
    },

    calculateInterest: function () {
        console.log("------ Interest Calculation Triggered ------");

        const remainingAmount = document.getElementById("remaining_amount");
        const paymentMonths = document.getElementById("payment_months");
        const preInterest = document.getElementById("pre_interest");
        const lateInterest = document.getElementById("late_interest");
        const interestType = document.getElementById("interest_type");

        if (
            !remainingAmount ||
            !paymentMonths ||
            !preInterest ||
            !lateInterest ||
            !interestType
        )
            return;

        const P = this.num(remainingAmount.value);
        const T = this.num(paymentMonths.value);
        const R1 = this.num(preInterest.value);
        const R2 = this.num(lateInterest.value);
        const type = interestType.value;

        const monthlyRate = R1 / 12 / 100;
        const TY = T / 12;

        if (!P || !T || !type) {
            console.log("❌ Missing Required Values");
            return;
        }

        let preInterestAmount = 0;
        let lateInterestAmount = 0;
        let SIAmount = 0;
        let PSIAmount = 0;
        let totalAmount = 0;
        let PtotalAmount = 0;

        if (type === "simple") {
            // Pre Interest Only
            SIAmount = (P * R1 * TY) / 100;
            totalAmount = P + SIAmount;
            preInterestAmount = totalAmount / T;

            // Combined (Pre + Late)
            let totalRate = R1 + R2;
            PSIAmount = (P * totalRate * TY) / 100;
            PtotalAmount = P + PSIAmount;
            lateInterestAmount = PtotalAmount / T;

            console.log("Total Rate (R1+R2):", totalRate);
        } else if (type === "compound") {
            // Normal EMI
            if (monthlyRate > 0 && T > 0) {
                let emi =
                    (P * monthlyRate * Math.pow(1 + monthlyRate, T)) /
                    (Math.pow(1 + monthlyRate, T) - 1);
                preInterestAmount = Math.ceil(emi);
            } else {
                preInterestAmount = T > 0 ? Math.ceil(P / T) : 0;
            }

            // Penalty EMI
            let penaltyRate = (R1 + R2) / 12 / 100;

            if (penaltyRate > 0 && T > 0) {
                let emiPen =
                    (P * penaltyRate * Math.pow(1 + penaltyRate, T)) /
                    (Math.pow(1 + penaltyRate, T) - 1);
                lateInterestAmount = Math.ceil(emiPen);
            } else {
                lateInterestAmount = T > 0 ? Math.ceil(P / T) : 0;
            }

            console.log("Total Rate (R1+R2):", penaltyRate);
        }

        this.setAutoValue("pre_interest_amount", preInterestAmount);
        this.setAutoValue("late_interest_amount", lateInterestAmount);
    },

    calculateLastEMI: function () {
        const emiInput = document.getElementById("payment_months");
        const monthInput = document.getElementById("payment_start_month");
        const yearInput = document.getElementById("payment_start_year");
        const result = document.getElementById("last_payment_due_date");

        if (!emiInput || !monthInput || !yearInput || !result) return;

        const emi = parseInt(emiInput.value) || 0;
        const month = parseInt(monthInput.value) || 0;
        const year = parseInt(yearInput.value) || 0;

        if (!emi || !month || !year) {
            result.value = "";
            return;
        }

        const monthNames = [
            "",
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];

        const startDate = new Date(year, month - 1);
        startDate.setMonth(startDate.getMonth() + emi - 1);

        const lastMonth = monthNames[startDate.getMonth() + 1];
        const lastYear = startDate.getFullYear();

        result.value = `${lastMonth} ${lastYear}`;
    },

    // Load districts for state select (reused from step 2)
    loadDistricts: function () {
        const stateId = this.value;
        const targetId = this.dataset.target;
        const districtSelect = document.getElementById(targetId);

        if (!districtSelect) return;

        districtSelect.innerHTML =
            '<option value="">-- Select District --</option>';

        if (!stateId) return;

        fetch(`/districts/${stateId}`)
            .then((res) => res.json())
            .then((data) => {
                const isHindi = targetId.includes("hi");
                districtSelect.innerHTML = isHindi
                    ? '<option value="">-- जिला चुनें --</option>'
                    : '<option value="">-- Select District --</option>';

                data.forEach((item) => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = isHindi ? item.name_hi : item.name_en;
                    districtSelect.appendChild(option);
                });
            })
            .catch((error) => console.error("Error loading districts:", error));
    },

    applyInputRestrictions: function () {
        // Only Numbers (0-9)
        document.querySelectorAll(".only-number").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, "");
            });
        });

        document.querySelectorAll(".only-number-amount").forEach((input) => {
            // Allow numbers and one dot
            input.addEventListener("input", function () {
                let value = this.value;

                // Remove invalid characters
                value = value.replace(/[^0-9.]/g, "");

                // Allow only one dot
                const parts = value.split(".");
                if (parts.length > 2) {
                    value = parts[0] + "." + parts.slice(1).join("");
                }

                this.value = value;
            });

            // On blur convert to .00 format
            input.addEventListener("blur", function () {
                let num = parseFloat(this.value);

                if (!isNaN(num)) {
                    this.value = num.toFixed(2); // always .00
                } else {
                    this.value = "";
                }
            });
        });

        // Only Alphabets (A-Z + space)
        document.querySelectorAll(".only-alphabet").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
            });
        });

        // English + Hindi
        document.querySelectorAll(".only-eng-hindi").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(
                    /[^a-zA-Z\u0900-\u097F\s]/g,
                    "",
                );
            });
        });

        // English + Hindi + Number + / -
        document
            .querySelectorAll(".only-eng-hindi-special")
            .forEach((input) => {
                input.addEventListener("input", function () {
                    this.value = this.value.replace(
                        /[^a-zA-Z0-9\u0900-\u097F\s\/-]/g,
                        "",
                    );
                });
            });

        // Float values between 0-100
        document.querySelectorAll(".only-float-100").forEach((input) => {
            input.addEventListener("input", function () {
                // Remove invalid characters (allow digits + dot)
                let value = this.value.replace(/[^0-9.]/g, "");

                // Prevent multiple dots
                let parts = value.split(".");
                if (parts.length > 2) {
                    value = parts[0] + "." + parts[1];
                }

                // Convert to number and check max limit
                let number = parseFloat(value);
                if (!isNaN(number) && number > 100) {
                    value = "100";
                }

                this.value = value;
            });
        });
    },

    validate: function () {
        const form = document.querySelector("#step3Form");
        if (!form) return true;

        let valid = true;
        let firstInvalid = null;

        // Required fields validation
        const requiredFields = [
            "tentative_price",
            "payment_type",
            "high_income_percent",
            "late_interest_amount",
            "payment_months",
            "payment_start_month",
            "payment_start_year",
            "last_payment_due_date",
            "interest_type",
            "pre_interest",
            "late_interest",
            "pre_interest_amount",
            "late_interest_amount",
            "remaining_amount",
        ];

        requiredFields.forEach((fieldName) => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value.trim()) {
                field.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = field;
            }
        });

        // Validate that either high_income_percent or low_income_percent is filled
        const highPercent = document.getElementById("high_income_percent");
        const lowPercent = document.getElementById("low_income_percent");

        if (highPercent && lowPercent) {
            const hasHigh = highPercent.value.trim();
            const hasLow = lowPercent.value.trim();

            if (!hasHigh && !hasLow) {
                highPercent.classList.add("is-invalid");
                lowPercent.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = highPercent;
            }
        }

        // Validate payment months if remaining amount > 0
        const remainingAmount = document.getElementById("remaining_amount");
        if (remainingAmount && this.num(remainingAmount.value) > 0) {
            const paymentMonths = document.getElementById("payment_months");
            const interestType = document.getElementById("interest_type");

            if (paymentMonths && !paymentMonths.value) {
                paymentMonths.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = paymentMonths;
            }

            if (interestType && !interestType.value) {
                interestType.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = interestType;
            }
        }

        if (firstInvalid) {
            firstInvalid.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
        }

        return valid;
    },

    destroy: function () {
        console.log("Step 3 Handler Destroyed");
        // Clean up any global event listeners if needed
    },
};

// Register with StepManager
StepManager.registerHandler(3, Step3Handler);
