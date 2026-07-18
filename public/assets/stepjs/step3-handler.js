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

    // Parse integer safely
    int: function (v) {
        return parseInt(v) || 0;
    },

    // Month names for display
    monthNames: [
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
    ],

    // Disable auto-calculated fields
    disableAutoFields: function () {
        const autoFields = [
            // "deposited_amount",
            "remaining_amount",
            "pre_interest_amount",
            "late_interest_amount",
            "last_payment_due_date",
        ];

        autoFields.forEach((id) => {
            const el = document.getElementById(id);
            if (el) {
                el.disabled = true;
                el.readOnly = true;
            }
        });
    },

    getInterestMode: function () {
        const selected = document.querySelector(
            'input[name="interest_calculation_mode"]:checked',
        );
        return selected ? selected.value : "manual";
    },

    toggleInterestCalculationMode: function () {
        const mode = this.getInterestMode();

        const preInterestAmount = document.getElementById(
            "pre_interest_amount",
        );
        const lateInterestAmount = document.getElementById(
            "late_interest_amount",
        );

        if (!preInterestAmount || !lateInterestAmount) return;

        if (mode === "manual") {
            preInterestAmount.readOnly = false;
            preInterestAmount.disabled = false;

            lateInterestAmount.readOnly = false;
            lateInterestAmount.disabled = false;
        } else {
            preInterestAmount.readOnly = true;
            preInterestAmount.disabled = true;

            lateInterestAmount.readOnly = true;
            lateInterestAmount.disabled = true;

            this.calculateInterest();
        }
    },

    // Set auto-calculated field value
    setAutoValue: function (id, value, isFloat = true) {
        const input = document.getElementById(id);
        if (!input) return;

        const formattedValue = isFloat ? value.toFixed(2) : value;
        input.value = formattedValue;

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
            hidden.value = formattedValue;
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

        // Deposit type toggle
        const depositType = document.getElementById("deposit_type");
        if (depositType) {
            depositType.addEventListener("change", (e) =>
                this.toggleDepositType(e),
            );
        }

        // High income percent input
        const high = document.getElementById("high_income_percent");
        if (high) {
            high.addEventListener("input", () =>
                this.calculateFromPercentage(),
            );
        }

        // Deposited amount direct input
        const deposited = document.getElementById("deposited_amount");
        if (deposited) {
            deposited.addEventListener("input", () =>
                this.calculateFromAmount(),
            );
            deposited.addEventListener("blur", () =>
                this.formatAmount(deposited),
            );
        }

        // Interest mode toggle
        document
            .querySelectorAll('input[name="interest_calculation_mode"]')
            .forEach((radio) => {
                radio.addEventListener("change", () =>
                    this.toggleInterestCalculationMode(),
                );
            });

        // Interest calculation triggers
        [
            "payment_months",
            "interest_type",
            "pre_interest",
            "late_interest",
        ].forEach((id) => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener("input", () => {
                    if (this.getInterestMode() === "auto") {
                        this.calculateInterest();
                    }
                });
                el.addEventListener("change", () => {
                    if (this.getInterestMode() === "auto") {
                        this.calculateInterest();
                    }
                });
            }
        });

        // EMI Last Date calculation triggers
        const emiInput = document.getElementById("payment_months");
        const monthInput = document.getElementById("payment_start_month");
        const yearInput = document.getElementById("payment_start_year");
        const lastDueDate = document.getElementById("last_payment_due_date");

        [emiInput, monthInput, yearInput].forEach((el) => {
            if (el) {
                el.addEventListener("input", () => this.calculateLastEMI());
                el.addEventListener("change", () => this.calculateLastEMI());
            }
        });

        // Final Payment Date calculation triggers (specified days)
        const startMonth = document.getElementById("payment_start_month");
        const startYear = document.getElementById("payment_start_year");
        const specifiedDays = document.getElementById("specified_days");

        [startMonth, startYear, specifiedDays].forEach((el) => {
            if (el) {
                el.addEventListener("change", () =>
                    this.calculateFinalPaymentDate(),
                );
            }
        });

        // State-District cascading
        document
            .querySelectorAll(".state-select, .state-select-hindi")
            .forEach((select) => {
                select.addEventListener("change", this.loadDistricts);
            });

        // Input restrictions
        this.applyInputRestrictions();

        // Disable auto fields initially
        this.disableAutoFields();
    },

    initializeCalculations: function () {
        // Check if tentative price has value and trigger calculations
        const tentative = document.getElementById("tentative_price");
        const depositType = document.getElementById("deposit_type");

        if (tentative && tentative.value) {
            this.handleTentativePrice({ target: tentative });

            // Trigger appropriate calculation based on deposit type
            if (depositType && depositType.value === "percent") {
                this.toggleDepositType({ target: depositType });
            }
        }

        // Calculate EMI last date
        this.calculateLastEMI();

        // Calculate final payment date
        this.calculateFinalPaymentDate();
        this.toggleInterestCalculationMode();
    },

    handleTentativePrice: function (e) {
        const value = e.target.value;
        if (value) {
            // Enable deposit type selection
            const depositType = document.getElementById("deposit_type");
            if (depositType) depositType.disabled = false;

            // Trigger recalculation of remaining amount
            this.calculateRemaining();
        }
    },

    toggleDepositType: function (e) {
        const type = e.target.value;
        const percentRow = document.getElementById("percent_row");
        const highPercent = document.getElementById("high_income_percent");
        const depositedAmount = document.getElementById("deposited_amount");

        if (type === "percent") {
            percentRow.style.display = "";
            highPercent.disabled = false;
            depositedAmount.readOnly = true;
            depositedAmount.disabled = true;

            // Calculate from percentage if percent field has value
            if (highPercent.value) {
                this.calculateFromPercentage();
            }
        } else {
            percentRow.style.display = "none";
            highPercent.disabled = true;
            depositedAmount.readOnly = false;
            depositedAmount.disabled = false;

            // Calculate from amount if amount field has value
            if (depositedAmount.value) {
                this.calculateFromAmount();
            }
        }
    },

    calculateFromPercentage: function () {
        const tentative = document.getElementById("tentative_price");
        const highPercent = document.getElementById("high_income_percent");

        if (!tentative || !highPercent) return;

        const P = this.num(tentative.value);
        const percent = this.num(highPercent.value);

        if (P && percent) {
            const deposit = (P * percent) / 100;
            this.setAutoValue("deposited_amount", deposit);
            this.calculateRemaining();
        }
    },

    calculateFromAmount: function () {
        const deposited = document.getElementById("deposited_amount");
        const highPercent = document.getElementById("high_income_percent");

        if (deposited && deposited.value) {
            // Clear percentage field when manually entering amount
            if (highPercent) highPercent.value = "";
            this.calculateRemaining();
        }
    },

    formatAmount: function (input) {
        if (input && input.value) {
            const num = this.num(input.value);
            input.value = num.toFixed(2);
        }
    },

    calculateRemaining: function () {
        const tentative = document.getElementById("tentative_price");
        const deposited = document.getElementById("deposited_amount");

        if (!tentative || !deposited) return;

        const P = this.num(tentative.value);
        const d = this.num(deposited.value);

        if (P && d <= P) {
            const remaining = P - d;
            this.setAutoValue("remaining_amount", remaining);
            console.log(remaining);
            // Enable interest fields if remaining > 0
            const interestFields = [
                "payment_months",
                "interest_type",
                "pre_interest",
                "late_interest",
            ];

            interestFields.forEach((id) => {
                const el = document.getElementById(id);
                if (el) el.disabled = remaining <= 0;
            });

            if (remaining > 0) {
                this.calculateInterest();
            }
        }
    },

    calculateInterest: function () {
        if (this.getInterestMode() !== "auto") {
            return;
        }

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
            console.log("Missing Required Values");
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
            let totalRate = R2;
            PSIAmount = (P * totalRate * TY) / 100;
            PtotalAmount = P + PSIAmount;
            lateInterestAmount = PtotalAmount / T;

            console.log("Total Rate R2:", totalRate);
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
            let penaltyRate = R2 / 12 / 100;

            if (penaltyRate > 0 && T > 0) {
                let emiPen =
                    (P * penaltyRate * Math.pow(1 + penaltyRate, T)) /
                    (Math.pow(1 + penaltyRate, T) - 1);
                lateInterestAmount = Math.ceil(emiPen);
            } else {
                lateInterestAmount = T > 0 ? Math.ceil(P / T) : 0;
            }

            console.log("Total Rate R2:", penaltyRate);
        }

        this.setAutoValue("pre_interest_amount", preInterestAmount);
        this.setAutoValue("late_interest_amount", lateInterestAmount);
    },

    // Calculate Last EMI Due Date (for monthly installments)
    calculateLastEMI: function () {
        const emiInput = document.getElementById("payment_months");
        const monthInput = document.getElementById("payment_start_month");
        const yearInput = document.getElementById("payment_start_year");
        const result = document.getElementById("last_payment_due_date");

        if (!emiInput || !monthInput || !yearInput || !result) return;

        const emi = this.int(emiInput.value);
        const month = this.int(monthInput.value);
        const year = this.int(yearInput.value);

        if (!emi || !month || !year) {
            result.value = "";
            return;
        }

        // Create start date (first day of the month)
        const startDate = new Date(year, month - 1, 1);

        // Add EMI months - 1 to get the last EMI month
        startDate.setMonth(startDate.getMonth() + emi - 1);

        const lastMonth = this.monthNames[startDate.getMonth() + 1];
        const lastYear = startDate.getFullYear();

        result.value = `${lastMonth} ${lastYear}`;
    },

    // Calculate Final Payment Date based on specified days
    calculateFinalPaymentDate: function () {
        const startMonth = document.getElementById("payment_start_month");
        const startYear = document.getElementById("payment_start_year");
        const specifiedDays = document.getElementById("specified_days");

        const lastDay = document.getElementById("last_day");
        const lastMonth = document.getElementById("last_month");
        const lastYear = document.getElementById("last_year");

        if (
            !startMonth ||
            !startYear ||
            !specifiedDays ||
            !lastDay ||
            !lastMonth ||
            !lastYear
        )
            return;

        const month = this.int(startMonth.value);
        const year = this.int(startYear.value);

        // Extract days from specified_days value (e.g., "30 days" -> 30)
        const daysText = specifiedDays.value;
        const days = daysText ? this.int(daysText.split(" ")[0]) : 0;

        if (!month || !year || !days) {
            // Clear last payment date fields if inputs are missing
            lastDay.value = "";
            lastMonth.value = "";
            lastYear.value = "";
            return;
        }

        // Create start date (first day of the month)
        const startDate = new Date(year, month - 1, 1);

        // Add the specified days and subtract 1 to get the last day
        // Example: If start is March 1 + 30 days = March 31 (correct)
        startDate.setDate(startDate.getDate() + days - 1);

        // Get the resulting date components
        const resultDay = startDate.getDate();
        const resultMonth = startDate.getMonth() + 1;
        const resultYear = startDate.getFullYear();

        // Set the values in the selects
        lastDay.value = String(resultDay).padStart(2, "0");
        lastMonth.value = String(resultMonth).padStart(2, "0");
        lastYear.value = resultYear;

        // Log for debugging
        console.log(`Final Payment Date Calculation:
            Start: ${month}/${year}
            Days: ${days}
            Result: ${resultDay}/${resultMonth}/${resultYear}
        `);
    },

    // Load districts for state select
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

        // Amount with 2 decimal places
        document.querySelectorAll(".only-number-amount").forEach((input) => {
            input.addEventListener("input", function () {
                let value = this.value.replace(/[^0-9.]/g, "");
                const parts = value.split(".");
                // Allow only one decimal point
                if (parts.length > 2) {
                    value = parts[0] + "." + parts[1];
                }
                // Limit decimal to 2 digits
                if (parts[1]) {
                    parts[1] = parts[1].substring(0, 2);
                    value = parts[0] + "." + parts[1];
                }
                this.value = value;
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

        // English + Number + / - (for address fields)
        document.querySelectorAll(".only-address").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^a-zA-Z0-9\s\/-]/g, "");
            });
        });

        // Alpha-numeric with dash
        document.querySelectorAll(".alpha-num-dash").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^a-zA-Z0-9-]/g, "");
            });
        });

        // Float values between 0-100
        document.querySelectorAll(".only-float-100").forEach((input) => {
            input.addEventListener("input", function () {
                let value = this.value.replace(/[^0-9.]/g, "");
                let parts = value.split(".");
                if (parts.length > 2) {
                    value = parts[0] + "." + parts[1];
                }
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
            // "tentative_price",
            // "payment_months",
            // "payment_start_month",
            // "payment_start_year",
            // "interest_type",
            // "pre_interest",
            // "late_interest",
            // "specified_days",
        ];

        requiredFields.forEach((fieldName) => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value) {
                field.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = field;
            }
        });

        // Validate either percentage or amount is filled
        const depositType = document.getElementById("deposit_type")?.value;
        const highPercent = document.getElementById("high_income_percent");
        const depositedAmount = document.getElementById("deposited_amount");

        // if (depositType === "percent") {
        //     if (!highPercent?.value) {
        //         highPercent?.classList.add("is-invalid");
        //         valid = false;
        //         if (!firstInvalid) firstInvalid = highPercent;
        //     }
        // } else {
        //     if (!depositedAmount?.value) {
        //         depositedAmount?.classList.add("is-invalid");
        //         valid = false;
        //         if (!firstInvalid) firstInvalid = depositedAmount;
        //     }
        // }

        if (firstInvalid) {
            firstInvalid.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
        }

        const interestMode = this.getInterestMode();
        const preInterestAmount = document.getElementById(
            "pre_interest_amount",
        );
        const lateInterestAmount = document.getElementById(
            "late_interest_amount",
        );

        // if (interestMode === "manual") {
        //     if (!preInterestAmount?.value) {
        //         preInterestAmount?.classList.add("is-invalid");
        //         valid = false;
        //         if (!firstInvalid) firstInvalid = preInterestAmount;
        //     }

        //     if (!lateInterestAmount?.value) {
        //         lateInterestAmount?.classList.add("is-invalid");
        //         valid = false;
        //         if (!firstInvalid) firstInvalid = lateInterestAmount;
        //     }
        // }

        return valid;
    },

    destroy: function () {
        console.log("Step 3 Handler Destroyed");
    },
};

// Register with StepManager
StepManager.registerHandler(3, Step3Handler);
