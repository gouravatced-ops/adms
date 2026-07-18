//================================
// STEP 1 HANDLER - Allottee Details with Joint Allottees
// ============================================

const Step1Handler = {
    manager: null,
    maxJointMembers: 3,
    jointCounter: 0,

    init: function () {
        console.log("Step 1 Handler Initialized");
        this.bindEvents();
        this.initializeFields();
        this.initializeJointAllottees();
    },

    bindEvents: function () {
        // Year validation
        const yearInput = document.getElementById("allotmentYear");
        const applicationYearSelect =
            document.getElementById("application_year");
        const errorText = document.getElementById("yearError");

        if (yearInput) {
            yearInput.addEventListener("input", (e) =>
                this.validateYear(e, applicationYearSelect, errorText),
            );
        }

        if (applicationYearSelect) {
            applicationYearSelect.addEventListener("change", (e) =>
                this.handleApplicationYearChange(e),
            );
        }

        const allotmentYear = document.getElementById("allotment_year");
        if (allotmentYear) {
            allotmentYear.addEventListener("change", () =>
                this.togglePanAadhar(),
            );
        }

        // DOB calculation
        [
            "date_of_birth_day",
            "date_of_birth_month",
            "date_of_birth_year",
        ].forEach((fieldName) => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.addEventListener("change", () => this.calculateAge());
            }
        });

        // Add Joint Allottee Button
        const addBtn = document.getElementById("addJointAllotteeBtn");
        if (addBtn) {
            addBtn.addEventListener("click", () => this.addJointAllottee());
        }

        this.applyInputRestrictions();
    },

    initializeFields: function () {
        this.togglePanAadhar();
        this.calculateAge();
    },

    initializeJointAllottees: function () {
        const container = document.getElementById("jointAllotteesContainer");
        if (container) {
            const existingCards =
                container.querySelectorAll(".joint-member-card");
            if (existingCards.length > 0) {
                this.jointCounter = existingCards.length;
                // Re-index existing cards and apply restrictions
                existingCards.forEach((card, idx) => {
                    this.reindexCard(card, idx);
                    this.applyInputRestrictionsToCard(card);
                });
            }
        }
    },

    addJointAllottee: function () {
        const container = document.getElementById("jointAllotteesContainer");
        const currentCount =
            container.querySelectorAll(".joint-member-card").length;

        if (currentCount >= this.maxJointMembers) {
            alert(
                `Maximum ${this.maxJointMembers} joint allottees can be added.`,
            );
            return;
        }

        const template = document.getElementById("jointAllotteeCardTemplate");
        const newIndex = this.jointCounter;
        let html = template.innerHTML;

        // Replace placeholders
        html = html.replace(/__INDEX__/g, newIndex);
        html = html.replace(/__NUMBER__/g, currentCount + 1);

        // Create temporary container to parse HTML
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = html;
        const newCard = tempDiv.firstElementChild;

        container.appendChild(newCard);

        // Apply input restrictions to new fields
        this.applyInputRestrictionsToCard(newCard);

        this.jointCounter++;
    },

    removeJointAllottee: function (buttonElement) {
        const card = buttonElement.closest(".joint-member-card");
        if (card) {
            card.remove();
            // Re-index remaining cards
            const container = document.getElementById(
                "jointAllotteesContainer",
            );
            const remainingCards =
                container.querySelectorAll(".joint-member-card");
            remainingCards.forEach((card, idx) => {
                this.reindexCard(card, idx);
            });
        }
    },

    reindexCard: function (card, newIndex) {
        // Update joint number display
        const numberSpan = card.querySelector(".joint-number");
        if (numberSpan) {
            numberSpan.textContent = newIndex + 1;
        }

        // Update data attribute
        card.setAttribute("data-joint-index", newIndex);
    },

    applyInputRestrictions: function () {
        // Only Numbers (0-9)
        document.querySelectorAll(".only-number").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, "");
            });
        });

        // Only Alphabets (A-Z + space)
        document.querySelectorAll(".only-alphabet").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
            });
        });

        // Only Hindi
        document.querySelectorAll(".only-hindi").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^\u0900-\u097F\s]/g, "");
            });
        });

        // PAN Card Format: ABCDE1234F
        document.querySelectorAll(".pan-input").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, "");
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
        });
    },

    applyInputRestrictionsToCard: function (card) {
        card.querySelectorAll(".only-number").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, "");
            });
        });

        card.querySelectorAll(".only-alphabet").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
            });
        });

        card.querySelectorAll(".only-hindi").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^\u0900-\u097F\s]/g, "");
            });
        });

        card.querySelectorAll(".pan-input").forEach((input) => {
            input.addEventListener("input", function () {
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, "");
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
        });
    },

    validateYear: function (e, applicationYearSelect, errorText) {
        let value = e.target.value.trim().replace(/[^0-9]/g, "");
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

    handleApplicationYearChange: function (e) {
        let appYear = parseInt(e.target.value);
        let allotSelect = document.getElementById("allotment_year");

        if (!appYear) return;

        Array.from(allotSelect.options).forEach((option) => {
            if (!option.value) return;
            let allotYear = parseInt(option.value);
            option.hidden = allotYear < appYear;
        });

        if (parseInt(allotSelect.value) < appYear) {
            allotSelect.value = "";
        }
    },

    togglePanAadhar: function () {
        const yearInput = document.getElementById("allotment_year");
        const panField = document.getElementById("pan-field");
        const aadharField = document.getElementById("aadhar-field");

        if (!yearInput || !panField || !aadharField) return;

        const year = yearInput.value ? parseInt(yearInput.value) : null;
        const show = year && year >= 2009;

        panField.style.display = show ? "block" : "none";
        aadharField.style.display = show ? "block" : "none";
    },

    calculateAge: function () {
        const day = document.querySelector('[name="date_of_birth_day"]')?.value;
        const month = document.querySelector(
            '[name="date_of_birth_month"]',
        )?.value;
        const year = document.querySelector(
            '[name="date_of_birth_year"]',
        )?.value;

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

    validate: function () {
        const form = document.querySelector("#step1Form");
        if (!form) return true;

        let valid = true;
        let firstInvalid = null;

        // Required fields validation for main allottee
        const requiredFields = [
            "allotment_month",
            "allotment_year",
            "allottee_name",
            "allottee_religion",
        ];

        requiredFields.forEach((fieldName) => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value.trim()) {
                field.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = field;
            } else if (field) {
                field.classList.remove("is-invalid");
            }
        });

        // Validate joint allottees
        const jointCards = document.querySelectorAll(".joint-member-card");
        for (let i = 0; i < jointCards.length; i++) {
            const card = jointCards[i];
            const firstName = card.querySelector(".joint-first-name");
            const gender = card.querySelector(".joint-gender");

            if (!firstName.value.trim()) {
                firstName.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = firstName;
            } else {
                firstName.classList.remove("is-invalid");
            }

            if (!gender.value) {
                gender.classList.add("is-invalid");
                valid = false;
                if (!firstInvalid) firstInvalid = gender;
            } else {
                gender.classList.remove("is-invalid");
            }
        }

        // Check year validation
        const yearField = document.getElementById("allotmentYear");
        if (yearField && yearField.classList.contains("invalid-year")) {
            valid = false;
            if (!firstInvalid) firstInvalid = yearField;
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
        console.log("Step 1 Handler Destroyed");
    },
};

// Global functions for dynamic buttons
function removeJointAllottee(button) {
    Step1Handler.removeJointAllottee(button);
}

// Register with StepManager
if (typeof StepManager !== "undefined") {
    StepManager.registerHandler(1, Step1Handler);
}
