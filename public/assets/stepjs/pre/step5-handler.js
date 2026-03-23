// ============================================
// OPTIMIZED STEP 5 HANDLER - Documents Uploads with Name Transfer
// ============================================
const Step5Handler = (function() {
    // Configuration constants
    const CONFIG = {
        submitUrl: "/applicant/documents/store",
        reuploadUrl: "/applicant/documents/reupload",
        saveEmiUrl: "/applicant/save-emi-ledger",
        monthNames: [
            "", "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December",
        ],
        documentTypes: {
            basic: "basic",
            nameTransfer: "nameTransfer"
        },
        ui: {
            selectors: {
                basicRows: "#basicDocumentRows",
                additionalRows: "#additionalDocumentRows",
                nameTransferSection: "#nameTransferSection",
                nameTransferSelect: "#nameTransfer",
                nametransferValue: "#nametransferValue",
                progressCount: "#progressCount",
                progressBar: "#progressBar",
                finalSubmitBtn: "#nextBtn",
                applicantId: "#applicant_id",
                totalEmiAmount: "#remaining_amount",
                emiMonthCount: "#emi_month_count",
                emiStartMonth: "#payment_start_month",
                emiStartYear: "#payment_start_year",
                emiLastDueDate: "#last_payment_due_date",
                emiAmount: "#pre_interest_amount",
                emiAmountLateAmount: "#late_interest_amount",
                csrfToken: 'meta[name="csrf-token"]',
            },
        },
    };

    // Document configurations - Including nameTransfer as requested
    const DOCUMENT_CONFIGS = {
        basic: window.documentBasicList || [],
        nameTransfer: []
    };

    // Completed documents from server
    const COMPLETED_DOCUMENTS = window.completedDocumentsList || [];

    // State management
    const state = {
        manager: null,
        isNameTransfer: false,
        completedBasicDocs: [],
        completedNameTransferDocs: [],
        emiFormSaved: false,
        applicantId: null,
        documentConfigs: DOCUMENT_CONFIGS,
        isLoading: false,
        // EMI Status: 'yes', 'no', 'no_information'
        emiStatus: null,
        // EMI Mode: 'manual' or 'auto' (default manual)
        emiMode: 'manual',
        // EMI Configuration from hidden inputs
        emiConfig: {
            totalAmount: 0,
            totalCount: 60,
            startMonth: "",
            startYear: "",
            endDate: "",
            amountWithoutPenalty: 0,
            amountWithPenalty: 0,
            lastEmiMonth: "",
            lastEmiYear: "",
        },
        // EMI Data
        emiData: {
            // Manual Mode
            manual: {
                totalCount: 0,
                expectedCount: 0,
                completedCount: 0,
                lateCount: 0,
                remainingCount: 0,
                penaltyAmount: 0,
                withoutPenaltyAmount: 0,
                totalPaid: 0,
                totalBalance: 0,
                status: "Pending"
            },
            // Auto Mode
            auto: {
                withoutPenaltyCount: 0,
                withPenaltyCount: 0,
                completedCount: 0,
                lateCount: 0,
                remainingCount: 0,
                totalPaid: 0,
                totalRemaining: 0,
                currentBalance: 0,
                status: "Pending",
                expectedCount: 0,
                paymentGap: 0,
                penaltyApplied: false
            }
        }
    };

    // Cache DOM elements
    let elements = {};

    // ==================== INITIALIZATION ====================

    function init() {
        console.log("Step 5 Handler Initialized - With Name Transfer");

        cacheElements();
        state.applicantId = elements.applicantId?.value || "";

        bindEvents();
        initializeUI();

        // Load EMI configuration from DOM
        loadEmiConfiguration();

        // Check if EMI status was previously saved
        checkExistingEmiStatus();

        // Set initial button state - DISABLED by default
        setNextButtonState(true);
    }

    function cacheElements() {
        elements = {
            basicRows: document.querySelector(CONFIG.ui.selectors.basicRows),
            additionalRows: document.querySelector(CONFIG.ui.selectors.additionalRows),
            nameTransferSection: document.querySelector(CONFIG.ui.selectors.nameTransferSection),
            nameTransferSelect: document.querySelector(CONFIG.ui.selectors.nameTransferSelect),
            nametransferValue: document.querySelector(CONFIG.ui.selectors.nametransferValue),
            progressCount: document.querySelector(CONFIG.ui.selectors.progressCount),
            progressBar: document.querySelector(CONFIG.ui.selectors.progressBar),
            finalSubmitBtn: document.querySelector(CONFIG.ui.selectors.finalSubmitBtn),
            applicantId: document.querySelector(CONFIG.ui.selectors.applicantId),
            csrfToken: document.querySelector(CONFIG.ui.selectors.csrfToken)?.content || "",
        };
    }

    function bindEvents() {
        document.addEventListener("click", handleDocumentClick);

        if (elements.nameTransferSelect) {
            elements.nameTransferSelect.addEventListener("change", handleNameTransferChange);
        }
    }

    function initializeUI() {
        if (elements.basicRows) {
            elements.basicRows.innerHTML = "";
            loadNextDocument(CONFIG.documentTypes.basic);
        }
        
        // Initially hide name transfer section
        setupNameTransfer();
        
        updateProgress();
    }

    // ==================== NAME TRANSFER SECTION MANAGEMENT ====================

    function setupNameTransfer() {
        if (!elements.nameTransferSection) return;
        
        // Initially hide the name transfer section
        elements.nameTransferSection.style.display = "block";
        console.log("Name transfer section hidden initially");
    }

    function checkAndShowNameTransfer() {
        const totalBasicDocs = state.documentConfigs.basic.length;
        const completedBasicCount = state.completedBasicDocs.length;
        
        // Show name transfer section only when ALL basic documents are completed
        if (completedBasicCount === totalBasicDocs && totalBasicDocs > 0) {
            if (elements.nameTransferSection) {
                elements.nameTransferSection.style.display = "block";
                console.log("All basic documents completed - showing name transfer section");
                
                // Scroll to name transfer section smoothly
                setTimeout(() => {
                    elements.nameTransferSection.scrollIntoView({ 
                        behavior: "smooth", 
                        block: "center" 
                    });
                }, 300);
            }
        } else {
            // Keep hidden if not all basic docs are completed
            if (elements.nameTransferSection) {
                elements.nameTransferSection.style.display = "block";
            }
        }
    }

    function handleNameTransferChange(e) {
        const isTransfer = e.target.value === "yes";
        state.isNameTransfer = isTransfer;
        console.log("Name transfer selected:", isTransfer ? "Yes" : "No");

        if (elements.nametransferValue) {
            elements.nametransferValue.value = isTransfer ? "yes" : "no";
        }

        // Handle additional documents section visibility
        const additionalSection = document.querySelector("#additionalDocumentsSection");
        if (additionalSection) {
            if (isTransfer) {
                additionalSection.style.display = "block";
                // Load first name transfer document if not already loaded
                if (state.completedNameTransferDocs.length === 0) {
                    loadNextDocument(CONFIG.documentTypes.nameTransfer);
                }
            } else {
                additionalSection.style.display = "none";
                // Clear any in-progress name transfer documents
                if (elements.additionalRows) {
                    elements.additionalRows.innerHTML = "";
                }
            }
        }

        // Update progress and button state
        updateProgress();
        // validateAndUpdateNextButton();
    }

    // ==================== NEXT BUTTON STATE MANAGEMENT ====================

    function setNextButtonState(enable) {
        if (!elements.finalSubmitBtn) return;
        
        elements.finalSubmitBtn.disabled = !enable;
        
        if (enable) {
            elements.finalSubmitBtn.classList.remove('disabled');
            elements.finalSubmitBtn.style.opacity = '1';
            elements.finalSubmitBtn.style.cursor = 'pointer';
        } else {
            elements.finalSubmitBtn.classList.add('disabled');
            elements.finalSubmitBtn.style.opacity = '0.5';
            elements.finalSubmitBtn.style.cursor = 'not-allowed';
        }
        
        console.log(`Next button ${enable ? 'enabled' : 'disabled'}`);
    }

    function validateAndUpdateNextButton() {
        const totalBasic = state.documentConfigs.basic.length;
        const totalNameTransfer = state.documentConfigs.nameTransfer.length;
        
        const completedBasicCount = state.completedBasicDocs.length;
        const completedNameTransferCount = state.completedNameTransferDocs.length;
        
        // Check if all basic documents are completed
        const allBasicCompleted = completedBasicCount === totalBasic;
        
        // Check name transfer requirements
        let nameTransferRequirementMet = true;
        if (state.isNameTransfer) {
            // If name transfer is yes, all name transfer docs must be completed
            nameTransferRequirementMet = completedNameTransferCount === totalNameTransfer;
        } else {
            // If name transfer is no or not selected, no requirement
            nameTransferRequirementMet = true;
        }
        
        // Check if EMI is required and saved
        let emiRequirementMet = true;
        if (state.emiStatus === 'yes') {
            emiRequirementMet = state.emiFormSaved;
        } else if (state.emiStatus === 'no' || state.emiStatus === 'no_information') {
            emiRequirementMet = true;
        } else {
            emiRequirementMet = false; // EMI status not selected yet
        }
        
        // Enable button only when ALL conditions are met
        const shouldEnable = allBasicCompleted && emiRequirementMet;
        
        setNextButtonState(shouldEnable);
        
        console.log('Validation check:', {
            allBasicCompleted,
            isNameTransfer: state.isNameTransfer,
            nameTransferRequirementMet,
            emiStatus: state.emiStatus,
            emiFormSaved: state.emiFormSaved,
            emiRequirementMet,
            shouldEnable
        });
        
        return shouldEnable;
    }

    // ==================== EVENT HANDLERS ====================

    function handleDocumentClick(e) {
        const target = e.target;

        // Preview button handler
        if (target.classList.contains("preview-btn") && !target.disabled) {
            const docId = parseInt(target.dataset.docId);
            const row = target.closest("tr");
            const doc = findDocumentById(docId);

            if (doc && row) {
                showPreviewModal(doc, row);
            }
        }

        // EMI Status button handler
        if (target.classList.contains("emi-status-btn")) {
            handleEmiStatusResponse(target.dataset.status);
        }

        // Mode selection buttons
        if (target.id === "modeManualBtn" || target.id === "modeAutoBtn") {
            handleModeChange(target.dataset.mode || (target.id === "modeManualBtn" ? "manual" : "auto"));
        }

        // Change Selection button
        if (target.id === "changeEmiSelectionBtn") {
            resetEmiSelection();
        }

        // Calculate Auto button
        if (target.id === "calculateAutoBtn") {
            calculateAutoMode();
        }

        // Save button
        if (target.id === "saveEmiDetailsBtn") {
            saveEmiDetails();
        }

        // Manual field inputs - update display on any change
        if (target.id === "manualCompletedCount" || target.id === "manualLateCount" ||
            target.id === "manualPenaltyAmount" || target.id === "manualWithoutPenaltyAmount" ||
            target.id === "manualTotalPaidInput" || target.id === "manualBalanceInput" ||
            target.id === "manualStatus") {
            updateManualDisplay();
        }
    }

    function handleEmiStatusResponse(status) {
        state.emiStatus = status;

        // Update hidden input
        updateEmiHiddenInputs();

        // Hide status section
        const statusSection = document.getElementById("emiStatusSection");
        if (statusSection) {
            statusSection.style.display = "none";
        }

        // Remove existing sections
        removeElement("#emiConfigurationSection");
        removeElement("#emiClosedSection");
        removeElement("#emiNoInfoSection");

        // Show appropriate UI
        if (status === "yes") {
            showYesSection();
        } else if (status === "no") {
            showNoSection();
            // For "no" status, EMI is automatically considered saved
            state.emiFormSaved = true;
            validateAndUpdateNextButton();
        } else if (status === "no_information") {
            showNoInformationSection();
            // For "no_information", EMI is automatically considered saved
            state.emiFormSaved = true;
            
            // Auto load next document
            setTimeout(() => {
                loadNextDocument(CONFIG.documentTypes.basic);
            }, 500);
        }

        setTimeout(() => {
            const newSection = document.getElementById("emiConfigurationSection") ||
                document.getElementById("emiClosedSection") ||
                document.getElementById("emiNoInfoSection");
            if (newSection) {
                newSection.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        }, 100);
    }

    function handleModeChange(mode) {
        if (mode === state.emiMode) return;

        state.emiMode = mode;

        // Update hidden input
        document.getElementById("emi_mode_hidden").value = mode;

        // Update button styles
        const manualBtn = document.getElementById("modeManualBtn");
        const autoBtn = document.getElementById("modeAutoBtn");

        if (manualBtn && autoBtn) {
            if (mode === "manual") {
                manualBtn.style.background = "#b11226";
                autoBtn.style.background = "#6c757d";
                document.getElementById("manualModeSection").style.display = "block";
                document.getElementById("autoModeSection").style.display = "none";
                document.getElementById("autoTimelineSection").style.display = "none";

                // Update manual display
                updateManualDisplay();
            } else {
                manualBtn.style.background = "#6c757d";
                autoBtn.style.background = "#4caf50";
                document.getElementById("manualModeSection").style.display = "none";
                document.getElementById("autoModeSection").style.display = "block";
                document.getElementById("autoTimelineSection").style.display = "block";
            }
        }
    }

    // ==================== UI SECTION RENDERING ====================

    function showYesSection() {
        const insertAfter = document.getElementById("emiStatusSection") ||
            elements.basicRows?.closest("table");

        if (!insertAfter) return;

        // Insert configuration container
        insertAfter.insertAdjacentHTML("afterend", EMI_CONFIG_TEMPLATE);

        const configSection = document.getElementById("emiConfigurationSection");
        if (configSection) {
            // Add manual mode section (default)
            configSection.insertAdjacentHTML("beforeend", EMI_MANUAL_TEMPLATE);

            // Add auto mode section
            configSection.insertAdjacentHTML("beforeend", EMI_AUTO_TEMPLATE);

            // Add ledger
            configSection.insertAdjacentHTML("beforeend", FINANCIAL_LEDGER_TEMPLATE);
        }

        // Update configuration display
        updateEmiConfigurationDisplay();

        // Set initial expected count
        const expectedCount = calculateExpectedEmiCount();
        document.getElementById("manualExpectedCount").value = expectedCount;
        state.emiData.manual.expectedCount = expectedCount;

        // Bind mode buttons
        document.getElementById("modeManualBtn")?.addEventListener("click", () => handleModeChange("manual"));
        document.getElementById("modeAutoBtn")?.addEventListener("click", () => handleModeChange("auto"));

        // Set default values
        document.getElementById("manualLateCount").value = 0;
        document.getElementById("manualTotalCount").value = state.emiConfig.totalCount;

        // Set default amounts from config if available
        if (state.emiConfig.amountWithoutPenalty > 0) {
            document.getElementById("manualWithoutPenaltyAmount").value = state.emiConfig.amountWithoutPenalty;
        }
        if (state.emiConfig.amountWithPenalty > 0) {
            document.getElementById("manualPenaltyAmount").value = state.emiConfig.amountWithPenalty;
        }

        // Check for pre-filled data
        checkForPrefilledEmiData();
    }

    function showNoSection() {
        const insertAfter = document.getElementById("emiStatusSection") ||
            elements.basicRows?.closest("table");

        if (!insertAfter) return;

        insertAfter.insertAdjacentHTML("afterend", EMI_CLOSED_TEMPLATE);

        // Update configuration display
        updateEmiConfigurationDisplay();
        console.log(state.emiConfig);
        // Set zero values
        updateLedgerDisplay(state.emiConfig.totalCount, 0, 0, state.emiConfig.amountWithoutPenalty, state.emiConfig.amountWithPenalty , state.emiConfig.totalCount * state.emiConfig.amountWithoutPenalty , 0 , 0);

        document.getElementById("current_emi_status").textContent = "Closed";
        document.getElementById("current_emi_status").style.background = "#6c757d";
        document.getElementById("current_emi_status").style.color = "white";

        // Enable save button
        setTimeout(() => {
            document.getElementById("saveEmiDetailsBtn").disabled = false;
        }, 100);
    }

    function showNoInformationSection() {
        const insertAfter = document.getElementById("emiStatusSection") ||
            elements.basicRows?.closest("table");

        if (!insertAfter) return;

        insertAfter.insertAdjacentHTML("afterend", NO_INFORMATION_TEMPLATE);

        // Mark as saved and load next document
        state.emiFormSaved = true;
        
        // Update next button state
        validateAndUpdateNextButton();

        setTimeout(() => {
            loadNextDocument(CONFIG.documentTypes.basic);
        }, 500);
    }

    // ==================== MANUAL MODE DISPLAY UPDATES ====================

    function updateManualDisplay() {
        const completedCount = parseInt(document.getElementById("manualCompletedCount")?.value) || 0;
        let lateCount = parseInt(document.getElementById("manualLateCount")?.value) || 0;
        const withoutPenaltyAmount = parseFloat(document.getElementById("manualWithoutPenaltyAmount")?.value) || 0;
        const penaltyAmount = parseFloat(document.getElementById("manualPenaltyAmount")?.value) || 0;
        
        // Get manually entered financial values
        const totalPaidManual = parseFloat(document.getElementById("manualTotalPaidInput")?.value) || 0;
        const balanceManual = parseFloat(document.getElementById("manualBalanceInput")?.value) || 0;

        const totalCount = state.emiConfig.totalCount;

        // Validate late count (cannot exceed completed count)
        if (lateCount > completedCount) {
            lateCount = completedCount;
            document.getElementById("manualLateCount").value = lateCount;
        }

        // Calculate remaining count
        const remainingCount = totalCount - completedCount - lateCount;
        document.getElementById("manualRemainingCount").value = remainingCount;

        // Determine status based on late count
        let status = document.getElementById("manualStatus").value;
        if (completedCount === totalCount) {
            status = "Completed";
        } else if (lateCount > 0) {
            status = "Late Payment";
        } else if (completedCount > 0) {
            status = "On Schedule";
        }
        document.getElementById("manualStatus").value = status;

        // Update summary displays with manually entered values
        document.getElementById("manualTotalPaidDisplay").textContent = "₹" + formatNumber(totalPaidManual);
        document.getElementById("manualTotalBalanceDisplay").textContent = "₹" + formatNumber(balanceManual);

        // Store manual data including manual financial entries
        state.emiData.manual = {
            totalCount: totalCount,
            expectedCount: state.emiData.manual.expectedCount,
            completedCount: completedCount,
            lateCount: lateCount,
            remainingCount: remainingCount,
            penaltyAmount: penaltyAmount,
            withoutPenaltyAmount: withoutPenaltyAmount,
            totalPaid: totalPaidManual,
            totalBalance: balanceManual,
            status: status
        };

        // Update ledger display with all values
        updateLedgerDisplay(
            completedCount,
            lateCount,
            remainingCount,
            withoutPenaltyAmount,
            penaltyAmount,
            totalPaidManual,
            balanceManual,
            totalPaidManual
        );

        // Update status display with color
        const statusEl = document.getElementById("current_emi_status");
        if (statusEl) {
            statusEl.textContent = status;
            applyStatusColor(status);
        }

        // Enable save button
        document.getElementById("saveEmiDetailsBtn").disabled = false;
    }

    // ==================== AUTO MODE CALCULATIONS ====================

    function calculateAutoMode() {
        const withoutPenalty = parseInt(document.getElementById("autoWithoutPenaltyCount")?.value) || 0;
        const withPenalty = parseInt(document.getElementById("autoWithPenaltyCount")?.value) || 0;

        const totalCount = state.emiConfig.totalCount;
        const amountWithoutPenalty = state.emiConfig.amountWithoutPenalty;
        const amountWithPenalty = state.emiConfig.amountWithPenalty;

        const total = withoutPenalty + withPenalty;

        // Validate
        if (total > totalCount) {
            alert(`Total EMIs (${total}) cannot exceed total EMI count (${totalCount})`);
            return;
        }

        // Timeline calculations
        const expectedCount = calculateExpectedEmiCount();
        const isEndDatePassed = checkEndDatePassed();
        const paymentGap = Math.max(expectedCount - total, 0);

        const completedCount = total;
        const remainingCount = totalCount - completedCount;

        // Calculate paid amount
        const totalPaid = (withoutPenalty * amountWithoutPenalty) + (withPenalty * amountWithPenalty);

        // Calculate remaining amount
        const penaltyApplied = isEndDatePassed || paymentGap > 0;
        const remainingAmount = remainingCount * (penaltyApplied ? amountWithPenalty : amountWithoutPenalty);

        const currentBalance = totalPaid;

        // Determine status
        let status = "Pending";
        if (completedCount === totalCount) {
            status = "Completed";
        } else if (completedCount > 0) {
            status = (withPenalty > 0 || penaltyApplied) ? "Late Payment" : "On Schedule";
        }

        // Store auto data
        state.emiData.auto = {
            withoutPenaltyCount: withoutPenalty,
            withPenaltyCount: withPenalty,
            completedCount: completedCount,
            lateCount: withPenalty,
            remainingCount: remainingCount,
            totalPaid: totalPaid,
            totalRemaining: remainingAmount,
            currentBalance: currentBalance,
            status: status,
            expectedCount: expectedCount,
            paymentGap: paymentGap,
            penaltyApplied: penaltyApplied
        };

        // Update timeline displays
        document.getElementById("expected_count").textContent = expectedCount;
        document.getElementById("payment_gap").textContent = paymentGap;

        const penaltyStatusEl = document.getElementById("penalty_status");
        if (penaltyStatusEl) {
            penaltyStatusEl.textContent = penaltyApplied ? "Penalty Applied" : "No Penalty";
            penaltyStatusEl.style.color = penaltyApplied ? "#c62828" : "#2e7d32";
        }

        // Update ledger
        updateLedgerDisplay(
            completedCount,
            withPenalty,
            remainingCount,
            amountWithoutPenalty,
            amountWithPenalty,
            totalPaid,
            remainingAmount,
            currentBalance
        );

        // Update status
        document.getElementById("current_emi_status").textContent = status;
        applyStatusColor(status);

        // Enable save button
        document.getElementById("saveEmiDetailsBtn").disabled = false;
    }

    function updateLedgerDisplay(completed, late, remaining, amountWithout, amountWith, paid, balanceRemaining, currentBal = null) {
        // Update count displays
        document.getElementById("completed_count").textContent = completed;
        document.getElementById("late_count").textContent = late;
        document.getElementById("remaining_count").textContent = remaining;

        // Update ledger counts
        document.getElementById("ledger_total_count").textContent = state.emiConfig.totalCount;
        document.getElementById("ledger_completed_count").textContent = completed;
        document.getElementById("ledger_late_count").textContent = late;
        document.getElementById("ledger_remaining_count").textContent = remaining;

        // Update financial displays
        document.getElementById("display_emi_amount").textContent = "₹" + formatNumber(amountWithout);
        document.getElementById("display_emi_late_amount").textContent = "₹" + formatNumber(amountWith);
        document.getElementById("total_paid_amount").textContent = "₹" + formatNumber(paid);
        document.getElementById("remaining_balance").textContent = "₹" + formatNumber(balanceRemaining);
        document.getElementById("current_balance").textContent = "₹" + formatNumber(currentBal !== null ? currentBal : paid);
    }

    function applyStatusColor(status) {
        const statusEl = document.getElementById("current_emi_status");
        if (!statusEl) return;

        let bgColor;
        switch (status) {
            case "Completed":
                bgColor = "#4caf50";
                break;
            case "Late Payment":
                bgColor = "#f44336";
                break;
            case "On Schedule":
                bgColor = "#2196f3";
                break;
            default:
                bgColor = "#ff9800";
        }
        statusEl.style.background = bgColor;
        statusEl.style.color = "white";
        statusEl.style.padding = "5px 15px";
        statusEl.style.borderRadius = "20px";
        statusEl.style.display = "inline-block";
    }

    // ==================== CONFIGURATION LOADING ====================

    function loadEmiConfiguration() {
        const totalAmountEl = document.querySelector(CONFIG.ui.selectors.totalEmiAmount);
        const emiCountEl = document.querySelector(CONFIG.ui.selectors.emiMonthCount);
        const startMonthEl = document.querySelector(CONFIG.ui.selectors.emiStartMonth);
        const startYearEl = document.querySelector(CONFIG.ui.selectors.emiStartYear);
        const amountWithoutPenaltyEl = document.querySelector(CONFIG.ui.selectors.emiAmount);
        const amountWithPenaltyEl = document.querySelector(CONFIG.ui.selectors.emiAmountLateAmount);

        state.emiConfig = {
            totalAmount: parseFloat(totalAmountEl?.value || 0),
            totalCount: parseInt(emiCountEl?.value || 60),
            startMonth: startMonthEl?.value || "",
            startYear: startYearEl?.value || "",
            amountWithoutPenalty: parseFloat(amountWithoutPenaltyEl?.value || 0),
            amountWithPenalty: parseFloat(amountWithPenaltyEl?.value || 0),
        };

        // Calculate last EMI date
        if (state.emiConfig.startMonth && state.emiConfig.startYear) {
            const startDate = new Date(
                state.emiConfig.startYear,
                parseInt(state.emiConfig.startMonth) - 1,
                1,
            );
            const lastDate = new Date(startDate);
            lastDate.setMonth(startDate.getMonth() + state.emiConfig.totalCount - 1);
            state.emiConfig.lastEmiMonth = CONFIG.monthNames[lastDate.getMonth() + 1];
            state.emiConfig.lastEmiYear = lastDate.getFullYear().toString();
            state.emiConfig.endDate = state.emiConfig.lastEmiMonth + " " + state.emiConfig.lastEmiYear;
        }

        updateEmiHiddenInputs();
    }

    function updateEmiConfigurationDisplay() {
        const displayTotalAmount = document.getElementById("display_total_emi_amount");
        const displayTotalCount = document.getElementById("display_total_emi_count");
        const displayEmiPeriod = document.getElementById("display_emi_period");
        const lastEmiDate = document.getElementById("last_emi_date");

        if (displayTotalAmount) {
            displayTotalAmount.textContent = "₹" + formatNumber(state.emiConfig.totalAmount);
        }

        if (displayTotalCount) {
            displayTotalCount.textContent = state.emiConfig.totalCount;
        }

        if (displayEmiPeriod && state.emiConfig.startMonth && state.emiConfig.startYear) {
            const startMonthName = CONFIG.monthNames[parseInt(state.emiConfig.startMonth)];
            displayEmiPeriod.textContent = `${startMonthName} ${state.emiConfig.startYear} to ${state.emiConfig.endDate}`;
        }

        if (lastEmiDate) {
            lastEmiDate.textContent = state.emiConfig.endDate || "-";
        }
    }

    function calculateExpectedEmiCount() {
        if (!state.emiConfig.startMonth || !state.emiConfig.startYear) return 0;

        const startDate = new Date(state.emiConfig.startYear, parseInt(state.emiConfig.startMonth) - 1, 1);
        const currentDate = new Date();

        const startYear = startDate.getFullYear();
        const startMonth = startDate.getMonth();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();

        let monthsDiff = (currentYear - startYear) * 12 + (currentMonth - startMonth);

        if (currentDate.getDate() >= startDate.getDate()) {
            monthsDiff += 1;
        }

        return Math.min(Math.max(monthsDiff, 0), state.emiConfig.totalCount);
    }

    function checkEndDatePassed() {
        if (!state.emiConfig.lastEmiYear || !state.emiConfig.lastEmiMonth) return false;

        const lastEmiDate = new Date(
            parseInt(state.emiConfig.lastEmiYear),
            CONFIG.monthNames.indexOf(state.emiConfig.lastEmiMonth) - 1,
            1,
        );
        const currentDate = new Date();

        return currentDate > lastEmiDate;
    }

    // ==================== HIDDEN INPUT MANAGEMENT ====================

    function addHiddenInputsToForm() {
        const step5Form = document.getElementById("step5Form");
        if (!step5Form) return;

        if (!document.getElementById("emi_status_hidden")) {
            step5Form.insertAdjacentHTML("beforeend", EMI_HIDDEN_INPUTS);
        }
    }

    function updateEmiHiddenInputs() {
        const statusInput = document.getElementById("emi_status_hidden");
        if (statusInput) {
            statusInput.value = state.emiStatus || "";
        }

        const modeInput = document.getElementById("emi_mode_hidden");
        if (modeInput) {
            modeInput.value = state.emiMode;
        }

        const configInput = document.getElementById("emi_config_hidden");
        if (configInput) {
            configInput.value = JSON.stringify(state.emiConfig);
        }

        const dataInput = document.getElementById("emi_data_hidden");
        if (dataInput) {
            dataInput.value = JSON.stringify(state.emiData);
        }
    }

    // ==================== EXISTING DATA CHECK ====================

    function checkExistingEmiStatus() {
        const savedEmiStatus = document.getElementById("emi_status_hidden")?.value;

        if (savedEmiStatus === "yes" || savedEmiStatus === "no" || savedEmiStatus === "no_information") {
            state.emiStatus = savedEmiStatus;

            try {
                const savedMode = document.getElementById("emi_mode_hidden")?.value;
                if (savedMode) state.emiMode = savedMode;

                const savedConfig = document.getElementById("emi_config_hidden")?.value;
                const savedData = document.getElementById("emi_data_hidden")?.value;

                if (savedConfig) state.emiConfig = JSON.parse(savedConfig);
                if (savedData) state.emiData = JSON.parse(savedData);

                setTimeout(() => {
                    const statusSection = document.getElementById("emiStatusSection");
                    if (statusSection) statusSection.style.display = "none";

                    if (savedEmiStatus === "yes") {
                        showYesSection();
                        setTimeout(() => {
                            if (state.emiMode === "manual") {
                                // Pre-fill manual fields
                                document.getElementById("manualCompletedCount").value = state.emiData.manual.completedCount || 0;
                                document.getElementById("manualLateCount").value = state.emiData.manual.lateCount || 0;
                                document.getElementById("manualWithoutPenaltyAmount").value = state.emiData.manual.withoutPenaltyAmount || 0;
                                document.getElementById("manualPenaltyAmount").value = state.emiData.manual.penaltyAmount || 0;
                                document.getElementById("manualTotalPaidInput").value = state.emiData.manual.totalPaid || 0;
                                document.getElementById("manualBalanceInput").value = state.emiData.manual.totalBalance || 0;
                                document.getElementById("manualStatus").value = state.emiData.manual.status || "Pending";
                                updateManualDisplay();
                            } else {
                                document.getElementById("modeAutoBtn")?.click();
                                document.getElementById("autoWithoutPenaltyCount").value = state.emiData.auto.withoutPenaltyCount || 0;
                                document.getElementById("autoWithPenaltyCount").value = state.emiData.auto.withPenaltyCount || 0;
                            }
                        }, 200);
                    } else if (savedEmiStatus === "no") {
                        showNoSection();
                        state.emiFormSaved = true;
                    } else if (savedEmiStatus === "no_information") {
                        showNoInformationSection();
                        state.emiFormSaved = true;
                    }
                    
                    // Update next button state after restoring data
                    setTimeout(validateAndUpdateNextButton, 500);
                }, 100);
            } catch (e) {
                console.error("Error restoring EMI data:", e);
            }
        }
    }

    function checkForPrefilledEmiData() {
        if (state.emiData.manual.completedCount > 0) {
            setTimeout(() => {
                document.getElementById("manualCompletedCount").value = state.emiData.manual.completedCount;
                document.getElementById("manualLateCount").value = state.emiData.manual.lateCount;
                document.getElementById("manualWithoutPenaltyAmount").value = state.emiData.manual.withoutPenaltyAmount;
                document.getElementById("manualPenaltyAmount").value = state.emiData.manual.penaltyAmount;
                document.getElementById("manualTotalPaidInput").value = state.emiData.manual.totalPaid;
                document.getElementById("manualBalanceInput").value = state.emiData.manual.totalBalance;
                document.getElementById("manualStatus").value = state.emiData.manual.status || "Pending";
                updateManualDisplay();
            }, 200);
        }
    }

    // ==================== SAVE EMI DETAILS ====================

    async function saveEmiDetails() {
        const saveBtn = document.getElementById("saveEmiDetailsBtn");
        const originalText = saveBtn.textContent;
        setButtonLoading(saveBtn, true, "Saving...");

        try {
            // Update hidden inputs
            updateEmiHiddenInputs();

            // If no information, just mark as saved
            if (state.emiStatus === "no_information") {
                state.emiFormSaved = true;
                saveBtn.textContent = "Saved ✓";
                saveBtn.style.background = "#4caf50";
                saveBtn.disabled = true;

                alert("EMI status recorded as 'No Information'");
                
                // Update next button state
                validateAndUpdateNextButton();
                
                loadNextDocument(CONFIG.documentTypes.basic);
                return;
            }

            // Prepare data for API
            const formData = new FormData();
            formData.append("_token", elements.csrfToken);
            formData.append("allottee_id", state.applicantId);
            formData.append("emi_status", state.emiStatus || "");
            formData.append("emi_mode", state.emiMode);
            formData.append("emi_config", JSON.stringify(state.emiConfig));
            formData.append("emi_data", JSON.stringify(state.emiData));

            const response = await fetch(CONFIG.saveEmiUrl, {
                method: "POST",
                headers: { Accept: "application/json" },
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                state.emiFormSaved = true;
                saveBtn.textContent = "Saved ✓";
                saveBtn.style.background = "#4caf50";
                saveBtn.disabled = true;

                // Disable inputs
                if (state.emiStatus === "yes") {
                    if (state.emiMode === "manual") {
                        document.querySelectorAll(".manual-field").forEach(field => {
                            field.disabled = true;
                        });
                        document.getElementById("manualStatus").disabled = true;
                    } else {
                        document.querySelectorAll(".auto-field").forEach(field => {
                            field.disabled = true;
                        });
                        document.getElementById("calculateAutoBtn").disabled = true;
                    }
                }

                alert("EMI details saved successfully");
                
                // Update next button state after saving EMI
                validateAndUpdateNextButton();
                
                loadNextDocument(CONFIG.documentTypes.basic);
            } else {
                throw new Error(data.message || "Error saving EMI details");
            }
        } catch (error) {
            console.error("Error:", error);
            alert(error.message);
            setButtonLoading(saveBtn, false, originalText);
        }
    }

    function resetEmiSelection() {
        // Reset state
        state.emiStatus = null;
        state.emiMode = 'manual';
        state.emiFormSaved = false;
        state.emiData = {
            manual: {
                totalCount: 0, expectedCount: 0, completedCount: 0, lateCount: 0,
                remainingCount: 0, penaltyAmount: 0, withoutPenaltyAmount: 0,
                totalPaid: 0, totalBalance: 0, status: "Pending"
            },
            auto: {
                withoutPenaltyCount: 0, withPenaltyCount: 0, completedCount: 0,
                lateCount: 0, remainingCount: 0, totalPaid: 0, totalRemaining: 0,
                currentBalance: 0, status: "Pending", expectedCount: 0,
                paymentGap: 0, penaltyApplied: false
            }
        };

        updateEmiHiddenInputs();

        // Remove all sections
        removeElement("#emiConfigurationSection");
        removeElement("#emiClosedSection");
        removeElement("#emiNoInfoSection");

        // Show status question again
        const statusSection = document.getElementById("emiStatusSection");
        if (statusSection) {
            statusSection.style.display = "block";
        } else {
            const basicTable = elements.basicRows?.closest("table");
            if (basicTable) {
                basicTable.insertAdjacentHTML("afterend", EMI_STATUS_TEMPLATE);
            }
        }

        addHiddenInputsToForm();

        // Update next button state (should be disabled now)
        validateAndUpdateNextButton();

        setTimeout(() => {
            document.getElementById("emiStatusSection")?.scrollIntoView({
                behavior: "smooth", block: "center"
            });
        }, 100);
    }

    // ==================== DOCUMENT SUBMISSION ====================

    function isRowValid(row) {
        const file = row.querySelector(".document-file")?.files[0];
        const remarks = row.querySelector(".remarks")?.value.trim();

        return file || (remarks && remarks.length > 0);
    }

    function updatePreviewButtonState(row) {
        const previewBtn = row.querySelector(".preview-btn");
        const file = row.querySelector(".document-file")?.files[0];

        if (previewBtn) {
            const isValid = isRowValid(row);
            previewBtn.disabled = !isValid;
            previewBtn.style.opacity = isValid ? "1" : "0.5";
            previewBtn.style.cursor = isValid ? "pointer" : "not-allowed";
            previewBtn.textContent = file ? "Preview Document" : "Preview Remarks";
        }
    }

    function createDocumentRow(doc, sl, type, isCompleted = false, data = null) {
        const dateOptions = generateDateOptions(data || {});
        const rowId = `row_${doc.id}`;
        const completedClass = isCompleted ? "completed-row" : "current-row";

        return `
            <tr class="document-row ${completedClass}" id="${rowId}" 
                data-document-id="${doc.id}" data-document-type="${type}" data-document-key="${doc.key}">
                <td style="padding: 8px 5px; border: 1px solid #ddd; text-align: center; width:5%;">
                    <span class="sl-badge">${sl}</span>
                </td>
                <td style="padding: 8px 5px; border: 1px solid #ddd; width:11%;" class="doc-name-cell">
                    ${doc.name}
                    <span class="status-completed" style="${isCompleted ? "display: inline-block;" : "display: none;"}">✓</span>
                </td>
                <td style="padding: 8px 5px; border: 1px solid #ddd; width:12%;">
                    <input type="text" class="compact-input doc-no" placeholder="Doc No. (Optional)" 
                        value="${data?.doc_no || ""}" ${isCompleted ? "disabled" : ""}>
                </td>
                <td style="padding: 8px 5px; border: 1px solid #ddd; width:10%;">
                    <div style="display: flex; gap: 2px;">
                        <select class="compact-input day" style="width: 55px;" ${isCompleted ? "disabled" : ""}>
                            ${dateOptions.days}
                        </select>
                        <select class="compact-input month" style="width: 58px;" ${isCompleted ? "disabled" : ""}>
                            ${dateOptions.months}
                        </select>
                        <select class="compact-input year" style="width: 70px;" ${isCompleted ? "disabled" : ""}>
                            ${dateOptions.years}
                        </select>
                    </div>
                </td>
                <td style="padding: 8px 5px; border: 1px solid #ddd; width:15%;">
                    <textarea class="compact-input additional-info" rows="2" placeholder="Additional Information (Optional)" 
                            ${isCompleted ? "disabled" : ""}>${data?.additional_info || ""}</textarea>
                </td>
                <td style="padding: 8px 5px; border: 1px solid #ddd; width:18%;">
                    <input type="file" class="file-input document-file" accept=".pdf,.jpg,.jpeg,.png" 
                        ${isCompleted ? "disabled" : ""}>
                    ${isCompleted && data?.has_file ? "<div><small>File uploaded</small></div>" : ""}
                </td>
                <td style="padding: 8px 5px; border: 1px solid #ddd; width:25%;">
                    <textarea class="compact-input remarks-field remarks" rows="2" placeholder="Remarks (Required)" 
                            ${isCompleted ? "disabled" : ""}>${data?.remarks || ""}</textarea>
                </td>
                <td style="padding: 8px 5px; border: 1px solid #ddd; width:10%; text-align: center;">
                    ${
                        !isCompleted
                            ? `<button type="button" class="btn-submit preview-btn" data-doc-id="${doc.id}" disabled>Preview</button>`
                            : '<span class="status-completed" style="display: inline-block; font-size: 15px; color: #ffffff;">✓</span>'
                    }
                </td>
            </tr>
        `;
    }

    function attachInputListeners(row) {
        const fileInput = row.querySelector(".document-file");
        const remarksInput = row.querySelector(".remarks");

        function updateRemarksRequired() {
            const hasFile = fileInput?.files?.length > 0;

            if (remarksInput) {
                remarksInput.placeholder = hasFile
                    ? "Remarks (Optional - file uploaded)"
                    : "Remarks (Required)";

                if (hasFile) {
                    remarksInput.removeAttribute("required");
                } else {
                    remarksInput.setAttribute("required", "required");
                }
            }

            updatePreviewButtonState(row);
        }

        if (fileInput) {
            fileInput.addEventListener("change", updateRemarksRequired);
        }

        if (remarksInput) {
            remarksInput.addEventListener("input", () => updatePreviewButtonState(row));
        }

        updateRemarksRequired();
    }

    function collectDocumentData(row) {
        return {
            doc_no: row.querySelector(".doc-no")?.value || "",
            day: row.querySelector(".day")?.value || "",
            month: row.querySelector(".month")?.value || "",
            year: row.querySelector(".year")?.value || "",
            additional_info: row.querySelector(".additional-info")?.value || "",
            remarks: row.querySelector(".remarks")?.value || "",
            file: row.querySelector(".document-file")?.files[0],
        };
    }

    function findDocumentById(docId) {
        return [...state.documentConfigs.basic, ...state.documentConfigs.nameTransfer].find((d) => d.id === docId);
    }

    // ==================== MODAL ====================

    function showPreviewModal(doc, row) {
        const docData = collectDocumentData(row);
        const filePreview = docData.file ? generateFilePreview(docData.file) : "<p>No file attached</p>";

        removeElement("#filePreviewModal");

        document.body.insertAdjacentHTML("beforeend", generateModalTemplate(doc.name, filePreview, docData));

        document.getElementById("confirmFileBtn").addEventListener("click", () => {
            submitDocument(doc.id, row, docData);
            removeElement("#filePreviewModal");
        });
    }

    function generateModalTemplate(docName, filePreview, docData) {
        return `
            <div id="filePreviewModal" class="modal-overlay" style="display: flex; padding-top:0px; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
                <div class="modal modal-top" style="background: white; margin: 50px auto; width: 90%; max-width: 800px; border-radius: 4px;">
                    <div class="modal-header" style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0;">Preview: ${docName}</h4>
                        <button class="modal-close" onclick="document.getElementById('filePreviewModal').remove()" style="background: none; border: none; font-size: 24px; cursor: pointer;">×</button>
                    </div>
                    <div class="modal-body" style="padding: 15px; max-height: 400px; overflow-y: auto;">
                        ${filePreview}
                        ${generateModalDetails(docData)}
                    </div>
                    <div class="modal-footer" style="padding: 15px; border-top: 1px solid #ddd; text-align: right;">
                        <button class="btn btn-secondary" onclick="document.getElementById('filePreviewModal').remove()" style="margin-right: 10px;">Cancel</button>
                        <button class="btn btn-danger" id="confirmFileBtn" style="background: #b11226; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Confirm & Submit</button>
                    </div>
                </div>
            </div>
        `;
    }

    function generateModalDetails(docData) {
        let details = "";

        if (docData.remarks) {
            details += `
                <div style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-left: 3px solid #b11226;">
                    <strong>Remarks:</strong> ${docData.remarks}
                </div>`;
        }

        if (docData.doc_no) {
            details += `
                <div style="margin-top: 10px; padding: 10px; background: #f9f9f9;">
                    <strong>Document No:</strong> ${docData.doc_no}
                </div>`;
        }

        if (docData.day && docData.month && docData.year) {
            details += `
                <div style="margin-top: 10px; padding: 10px; background: #f9f9f9;">
                    <strong>Date:</strong> ${docData.day}/${docData.month}/${docData.year}
                </div>`;
        }

        return details;
    }

    // ==================== DOCUMENT SUBMISSION ====================

    async function submitDocument(docId, row, docData) {
        if (state.isLoading) return;

        const doc = findDocumentById(docId);
        const type = row?.dataset?.documentType;

        const submitBtn = row.querySelector(".preview-btn");
        const originalText = submitBtn.textContent;

        state.isLoading = true;
        setButtonLoading(submitBtn, true, "Submitting...");

        try {
            const formData = new FormData();
            formData.append("_token", elements.csrfToken);
            formData.append("allottee_id", state.applicantId);
            formData.append("document_id", docId);
            formData.append("document_type", type);
            formData.append("document_key", doc?.key || "");

            Object.entries(docData).forEach(([key, value]) => {
                if (key !== "file" && value) {
                    formData.append(key, value);
                }
            });

            if (docData.file) {
                formData.append("document_file", docData.file);
            }

            const response = await fetch(CONFIG.submitUrl, {
                method: "POST",
                headers: { Accept: "application/json" },
                body: formData,
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || "Upload failed");
            }

            const documentData = {
                id: docId,
                ...docData,
                has_file: !!docData.file,
                file_name: data.file_name || docData.file?.name || null,
            };

            if (type === CONFIG.documentTypes.basic) {
                if (!state.completedBasicDocs.some((d) => d.id === docId)) {
                    state.completedBasicDocs.push(documentData);
                }
            } else if (type === CONFIG.documentTypes.nameTransfer) {
                if (!state.completedNameTransferDocs.some((d) => d.id === docId)) {
                    state.completedNameTransferDocs.push(documentData);
                }
            }

            await handlePostSubmissionWorkflow(docId, type, row);
        } catch (error) {
            console.error("Upload Error:", error);
            alert(error.message || "Error uploading document");
        } finally {
            state.isLoading = false;
            if (!row.classList.contains("completed-row")) {
                setButtonLoading(submitBtn, false, originalText);
            }
        }
    }

    async function handlePostSubmissionWorkflow(docId, type, row) {
        if (type === CONFIG.documentTypes.basic) {
            const totalBasicDocs = state.documentConfigs.basic.length;

            // Allotment Letter (ID 2) triggers EMI form
            if (docId === 2) {
                displayEmiForm();
            }

            // Check if all basic docs are completed to show name transfer section
            checkAndShowNameTransfer();

            loadNextDocument(CONFIG.documentTypes.basic);
        } else if (type === CONFIG.documentTypes.nameTransfer) {
            const totalTransferDocs = state.documentConfigs.nameTransfer.length;

            if (state.completedNameTransferDocs.length >= totalTransferDocs) {
                alert("All name transfer documents submitted successfully.");
            }

            loadNextDocument(CONFIG.documentTypes.nameTransfer);
        }

        updateProgress();
        
        // Check and update next button state after document submission
        validateAndUpdateNextButton();
    }

    // ==================== DOCUMENT LOADING ====================

    function loadNextDocument(type) {
        const tbody = document.getElementById(
            type === CONFIG.documentTypes.basic ? "basicDocumentRows" : "additionalDocumentRows"
        );
        const documents = state.documentConfigs[type];
        const completedDocs = type === CONFIG.documentTypes.basic ? state.completedBasicDocs : state.completedNameTransferDocs;

        if (!tbody) return;

        const nextIndex = completedDocs.length;
        tbody.innerHTML = "";

        // Render completed rows
        completedDocs.forEach((completedDoc, index) => {
            const originalDoc = documents.find((d) => d.id === completedDoc.id);
            if (originalDoc) {
                tbody.insertAdjacentHTML(
                    "beforeend",
                    createDocumentRow(originalDoc, index + 1, type, true, completedDoc)
                );
            }
        });

        // Render next incomplete document if any
        if (nextIndex < documents.length) {
            renderNextDocumentRow(tbody, documents[nextIndex], nextIndex + 1, type);
        } else if (type === CONFIG.documentTypes.nameTransfer) {
            showCompletionMessage(tbody);
        }
    }

    function renderNextDocumentRow(tbody, document, index, type) {
        tbody.insertAdjacentHTML("beforeend", createDocumentRow(document, index, type, false));

        const newRow = tbody.querySelector(`tr[data-document-id="${document.id}"]`);
        if (newRow) {
            attachInputListeners(newRow);
            updatePreviewButtonState(newRow);

            setTimeout(() => {
                newRow.scrollIntoView({ behavior: "smooth", block: "center" });
            }, 100);
        }
    }

    function showCompletionMessage(tbody) {
        const tableContainer = tbody.closest(".table-container");
        if (tableContainer && !document.getElementById("completionMessage")) {
            const messageHtml = `
                <div id="completionMessage" style="margin-top: 20px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; text-align: center;">
                    <strong>✓ All documents have been successfully uploaded!</strong>
                </div>
            `;
            tableContainer.insertAdjacentHTML("afterend", messageHtml);
        }
    }

    // ==================== EMI FORM DISPLAY ====================

    function displayEmiForm() {
        if (document.getElementById("emiStatusSection") || state.emiFormSaved) return;

        const basicTable = elements.basicRows?.closest("table");
        if (basicTable) {
            basicTable.insertAdjacentHTML("afterend", EMI_STATUS_TEMPLATE);

            // Add hidden inputs to the form
            addHiddenInputsToForm();

            setTimeout(() => {
                document.getElementById("emiStatusSection").scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }, 100);
        }
    }

    // ==================== PROGRESS TRACKING ====================

    function updateProgress() {
        const totalBasic = state.documentConfigs.basic.length;
        const totalNameTransfer = state.isNameTransfer ? state.documentConfigs.nameTransfer.length : 0;
        const completedCount = state.completedBasicDocs.length + state.completedNameTransferDocs.length;
        const totalDocs = totalBasic + totalNameTransfer;

        if (elements.progressCount) {
            elements.progressCount.textContent = `${completedCount}/${totalDocs}`;
        }

        if (elements.progressBar) {
            const percentage = totalDocs > 0 ? (completedCount / totalDocs) * 100 : 0;
            elements.progressBar.style.width = `${percentage}%`;
        }
    }

    // ==================== UTILITY FUNCTIONS ====================

    function num(v) {
        return parseFloat(v) || 0;
    }

    function formatNumber(num) {
        if (num === 0) return "0.00";
        return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
    }

    function hideElement(selector) {
        const element = document.querySelector(selector);
        if (element) element.style.display = "none";
    }

    function showElement(selector) {
        const element = document.querySelector(selector);
        if (element) element.style.display = "block";
    }

    function removeElement(selector) {
        const element = document.querySelector(selector);
        if (element) element.remove();
    }

    function generateDateOptions(selected = {}) {
        return {
            days: generateOptions(1, 31, "DD", selected.day),
            months: generateOptions(1, 12, "MM", selected.month),
            years: generateYearOptions(selected.year),
        };
    }

    function generateOptions(start, end, placeholder, selected = "") {
        let options = `<option value="">${placeholder}</option>`;
        for (let i = start; i <= end; i++) {
            const val = i.toString().padStart(2, "0");
            options += `<option value="${val}" ${selected === val ? "selected" : ""}>${val}</option>`;
        }
        return options;
    }

    function generateYearOptions(selected = "") {
        const currentYear = new Date().getFullYear();
        let options = '<option value="">YYYY</option>';
        for (let i = currentYear; i >= 1960; i--) {
            options += `<option value="${i}" ${selected == i ? "selected" : ""}>${i}</option>`;
        }
        return options;
    }

    function generateFilePreview(file) {
        if (!file) return "<p>No file selected</p>";

        const fileType = file.type;
        const fileUrl = URL.createObjectURL(file);

        if (fileType.startsWith("image/")) {
            return `<img src="${fileUrl}" alt="Preview" style="max-width: 100%; max-height: 350px; display: block; margin: 0 auto;">`;
        } else if (fileType === "application/pdf") {
            return `<embed src="${fileUrl}" type="application/pdf" width="100%" height="350px" />`;
        } else {
            return `
                <div style="text-align: center; padding: 20px;">
                    <i class="fas fa-file" style="font-size: 48px; color: #b11226;"></i>
                    <p>${file.name}</p>
                    <p style="color: #666;">(Preview not available for this file type)</p>
                </div>
            `;
        }
    }

    function setButtonLoading(button, isLoading, text) {
        button.disabled = isLoading;
        button.textContent = text;
    }

    // ==================== TEMPLATES ====================

    const EMI_HIDDEN_INPUTS = `
        <input type="hidden" name="emi_status" id="emi_status_hidden" value="">
        <input type="hidden" name="emi_mode" id="emi_mode_hidden" value="manual">
        <input type="hidden" name="emi_config" id="emi_config_hidden" value="">
        <input type="hidden" name="emi_data" id="emi_data_hidden" value="">
    `;

    const EMI_STATUS_TEMPLATE = `
        <div id="emiStatusSection" style="margin: 20px 0; padding: 30px; background: #fff; border: 1px solid #b11226; border-radius: 4px; text-align: center;">
            <h4 style="margin: 0 0 20px; color: #b11226;">EMI Payment Status</h4>
            <div style="font-size: 16px; margin-bottom: 25px;">Is the allottee still paying EMI?</div>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <button type="button" class="btn-submit emi-status-btn" data-status="yes" style="padding: 12px 40px; background: #4caf50; font-size: 16px;">Yes</button>
                <button type="button" class="btn-submit emi-status-btn" data-status="no" style="padding: 12px 40px; background: #f44336; font-size: 16px;">No</button>
                <button type="button" class="btn-submit emi-status-btn" data-status="no_information" style="padding: 12px 40px; background: #ff9800; font-size: 16px;">Don't Know</button>
            </div>
        </div>
    `;

    const EMI_CONFIG_TEMPLATE = `
        <div id="emiConfigurationSection" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #b11226; border-radius: 4px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; color: #b11226;">EMI Configuration</h4>
                <button type="button" id="changeEmiSelectionBtn" class="btn-submit" style="background: #ff9800; padding: 5px 15px; font-size: 12px; width: 20%;">Change Selection</button>
            </div>
            
            <!-- Mode Selection Tabs -->
            <div style="margin-bottom: 20px; display: flex; gap: 10px; border-bottom: 2px solid #eee; padding-bottom: 10px;">
                <button type="button" id="modeManualBtn" class="mode-btn active" data-mode="manual" style="padding: 8px 20px; background: #b11226; color: white; border: none; border-radius: 4px; cursor: pointer;">Manual</button>
                <button type="button" id="modeAutoBtn" class="mode-btn" data-mode="auto" style="padding: 8px 20px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Auto Generate</button>
            </div>
            
            <!-- EMI Configuration Summary -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                <div>
                    <label style="font-size: 12px; color: #666;">Total EMI Amount</label>
                    <div style="font-size: 16px; font-weight: bold;" id="display_total_emi_amount">₹0</div>
                </div>
                <div>
                    <label style="font-size: 12px; color: #666;">Total EMI Count</label>
                    <div style="font-size: 16px; font-weight: bold;" id="display_total_emi_count">0</div>
                </div>
                <div>
                    <label style="font-size: 12px; color: #666;">EMI Period</label>
                    <div style="font-size: 16px; font-weight: bold;" id="display_emi_period">-</div>
                </div>
            </div>
    `;

    const EMI_MANUAL_TEMPLATE = `
            <!-- Manual Mode Form -->
            <div id="manualModeSection" style="margin-bottom: 20px; padding: 20px; background: #f0f2f5; border-radius: 4px;">
                <h5 style="margin: 0 0 20px; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Manual EMI Entry</h5>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
                    <!-- Left Column -->
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Total EMI Count</label>
                            <input type="number" id="manualTotalCount" class="compact-input manual-field" value="${state.emiConfig.totalCount}" readonly style="width: 100%; background: #e9ecef;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Expected EMI Count <span style="font-weight: normal; color: #666;">(Auto-calculated)</span></label>
                            <input type="number" id="manualExpectedCount" class="compact-input" readonly style="width: 100%; background: #e9ecef;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Completed EMI Count</label>
                            <input type="number" id="manualCompletedCount" class="compact-input manual-field" min="0" max="${state.emiConfig.totalCount}" placeholder="Enter completed count" style="width: 100%;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Late EMI Count <span style="font-weight: normal; color: #666;">(Default 0)</span></label>
                            <input type="number" id="manualLateCount" class="compact-input manual-field" min="0" value="0" placeholder="Enter late count" style="width: 100%;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Remaining EMI Count</label>
                            <input type="number" id="manualRemainingCount" class="compact-input" readonly style="width: 100%; background: #e9ecef;">
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Without Penalty Amount (₹)</label>
                            <input type="number" id="manualWithoutPenaltyAmount" class="compact-input manual-field" step="0.01" min="0" placeholder="Enter amount" style="width: 100%;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Penalty EMI Amount (₹)</label>
                            <input type="number" id="manualPenaltyAmount" class="compact-input manual-field" step="0.01" min="0" placeholder="Enter penalty amount" style="width: 100%;">
                        </div>
                        <!-- MANUAL TOTAL PAID INPUT -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Total Paid Amount (₹) <span style="font-weight: normal; color: #666;">(Manual Entry)</span></label>
                            <input type="number" id="manualTotalPaidInput" class="compact-input manual-field" step="0.01" min="0" placeholder="Enter total paid amount" style="width: 100%;">
                        </div>
                        <!-- MANUAL REMAINING BALANCE INPUT -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Remaining Balance (₹) <span style="font-weight: normal; color: #666;">(Manual Entry)</span></label>
                            <input type="number" id="manualBalanceInput" class="compact-input manual-field" step="0.01" min="0" placeholder="Enter remaining balance" style="width: 100%;">
                        </div>
                    </div>
                </div>
                
                <!-- Calculated Summary -->
                <div style="margin-top: 25px; padding: 20px; background: #fff; border: 1px solid #b11226; border-radius: 4px;">
                    <h6 style="margin: 0 0 15px; color: #333; font-size: 15px;">Summary</h6>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <div>
                            <span style="font-size: 13px; color: #666;">Total Paid Amount</span>
                            <div style="font-size: 20px; font-weight: bold; color: #2e7d32;" id="manualTotalPaidDisplay">₹0.00</div>
                        </div>
                        <div>
                            <span style="font-size: 13px; color: #666;">Total Balance Amount</span>
                            <div style="font-size: 20px; font-weight: bold; color: #c62828;" id="manualTotalBalanceDisplay">₹0.00</div>
                        </div>
                        <div>
                            <span style="font-size: 13px; color: #666;">EMI Status</span>
                            <select id="manualStatus" class="compact-input" style="width: 100%; margin-top: 5px;">
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Late Payment">Late Payment</option>
                                <option value="On Schedule">On Schedule</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 20px; font-size: 13px; color: #666; background: #fff; padding: 10px; border-radius: 4px;">
                    <i class="fas fa-info-circle"></i> Enter counts and amounts manually. Late count cannot exceed completed count.
                </div>
            </div>
    `;

    const EMI_AUTO_TEMPLATE = `
            <!-- Auto Mode Form - With Calculate Button -->
            <div id="autoModeSection" style="margin-bottom: 20px; padding: 20px; background: #e8f5e8; border-radius: 4px; display: none;">
                <h5 style="margin: 0 0 20px; color: #2e7d32; border-bottom: 1px solid #a5d6a7; padding-bottom: 10px;">Auto Generate EMI</h5>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">EMI Paid Without Penalty</label>
                            <input type="number" id="autoWithoutPenaltyCount" class="compact-input auto-field" min="0" placeholder="Enter count" style="width: 100%;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">EMI Paid With Penalty (Late)</label>
                            <input type="number" id="autoWithPenaltyCount" class="compact-input auto-field" min="0" placeholder="Enter count" style="width: 100%;">
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-end; justify-content: flex-end;">
                        <button type="button" class="btn-submit" id="calculateAutoBtn" style="padding: 10px 30px; background: #4caf50; font-size: 14px;">Calculate</button>
                    </div>
                </div>
                
                <div style="margin-top: 15px; font-size: 13px; color: #2e7d32; background: #fff; padding: 10px; border-radius: 4px;">
                    <i class="fas fa-calculator"></i> Enter values and click Calculate to generate ledger.
                </div>
            </div>
    `;

    const FINANCIAL_LEDGER_TEMPLATE = `
            <!-- Timeline Validation Summary (Auto Mode Only) -->
            <div id="autoTimelineSection" style="display: none;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                    <div style="padding: 15px; background: #e3f2fd; border-radius: 4px;">
                        <div style="font-size: 12px; color: #01579b;">EXPECTED EMI COUNT</div>
                        <div style="font-size: 24px; font-weight: bold; color: #01579b;" id="expected_count">0</div>
                        <div style="font-size: 12px;">As of current date</div>
                    </div>
                    <div style="padding: 15px; background: #fff3e0; border-radius: 4px;">
                        <div style="font-size: 12px; color: #e65100;">PAYMENT GAP</div>
                        <div style="font-size: 24px; font-weight: bold; color: #e65100;" id="payment_gap">0</div>
                        <div style="font-size: 12px;">Expected - Paid</div>
                    </div>
                    <div style="padding: 15px; background: #f3e5f5; border-radius: 4px;">
                        <div style="font-size: 12px; color: #6a1b9a;">PENALTY STATUS</div>
                        <div style="font-size: 18px; font-weight: bold; color: #6a1b9a;" id="penalty_status">No Penalty</div>
                    </div>
                </div>
            </div>

            <!-- EMI Summary Cards -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="padding: 15px; background: #e8f5e9; border-radius: 4px; text-align: center;">
                    <div style="font-size: 12px; color: #2e7d32;">COMPLETED EMI COUNT</div>
                    <div style="font-size: 24px; font-weight: bold; color: #2e7d32;" id="completed_count">0</div>
                </div>
                <div style="padding: 15px; background: #ffebee; border-radius: 4px; text-align: center;">
                    <div style="font-size: 12px; color: #c62828;">LATE EMI COUNT</div>
                    <div style="font-size: 24px; font-weight: bold; color: #c62828;" id="late_count">0</div>
                </div>
                <div style="padding: 15px; background: #e3f2fd; border-radius: 4px; text-align: center;">
                    <div style="font-size: 12px; color: #1565c0;">REMAINING EMI COUNT</div>
                    <div style="font-size: 24px; font-weight: bold; color: #1565c0;" id="remaining_count">0</div>
                </div>
            </div>

            <!-- Financial Ledger -->
            <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 4px;">
                <h5 style="margin: 0 0 15px; color: #333;">Financial Ledger</h5>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
                    <div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Total EMI Count:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="ledger_total_count">0</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Completed EMI Count:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="ledger_completed_count">0</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Late EMI Count:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #c62828; text-align: right;" id="ledger_late_count">0</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Remaining EMI Count:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #2e7d32; text-align: right;" id="ledger_remaining_count">0</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>EMI Amount (Without Penalty):</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="display_emi_amount">₹0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>EMI Amount (With Penalty):</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #c62828; text-align: right;" id="display_emi_late_amount">₹0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Total Paid Amount:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="total_paid_amount">₹0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Remaining Balance:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #2e7d32; text-align: right;" id="remaining_balance">₹0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Current Balance:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #b11226; text-align: right;" id="current_balance">₹0.00</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- EMI Status Display -->
            <div style="margin-bottom: 20px; padding: 15px; background: #e1f5fe; border-radius: 4px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 14px; color: #01579b;">CURRENT EMI STATUS</span>
                        <div style="font-size: 24px; font-weight: bold; padding: 5px 15px; border-radius: 20px; display: inline-block;" id="current_emi_status">Pending</div>
                    </div>
                    <div>
                        <span style="font-size: 14px; color: #e65100;">LAST EMI DATE</span>
                        <div style="font-size: 18px; font-weight: bold;" id="last_emi_date">-</div>
                    </div>
                </div>
            </div>
            
            <!-- Save Button -->
            <div style="margin-top: 20px; text-align: right;">
                <button type="button" class="btn-submit" id="saveEmiDetailsBtn" style="padding: 10px 30px; background: #4caf50; font-size: 16px;">Save EMI Details</button>
            </div>
        </div>
    `;

    const EMI_CLOSED_TEMPLATE = `
        <div id="emiClosedSection" style="margin: 20px 0; padding: 20px; background: #fff3e0; border: 1px solid #ff9800; border-radius: 4px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; color: #e65100;">EMI Not Active</h4>
                <button type="button" id="changeEmiSelectionBtn" class="btn-submit" style="background: #ff9800; padding: 5px 15px; font-size: 12px; width: 20%;">Change Selection</button>
            </div>
            
            <div style="margin-bottom: 20px; padding: 15px; background: #fff; border-radius: 4px;">
                <p style="margin: 0; color: #666;">EMI payments are closed for this allotment. No EMI information required.</p>
            </div>
            
            <!-- Show ledger with zero values -->
            ${FINANCIAL_LEDGER_TEMPLATE}
        </div>
    `;

    const NO_INFORMATION_TEMPLATE = `
        <div id="emiNoInfoSection" style="margin: 20px 0; padding: 30px; background: #fff3e0; border: 1px solid #ff9800; border-radius: 4px; text-align: center;">
            <i class="fas fa-question-circle" style="font-size: 48px; color: #ff9800; margin-bottom: 15px;"></i>
            <h4 style="margin: 0 0 10px; color: #e65100;">No EMI Information</h4>
            <p style="margin: 0 0 20px; color: #666;">EMI status set to "Don't Know". No EMI data will be saved.</p>
            <button type="button" id="changeEmiSelectionBtn" class="btn-submit" style="background: #ff9800; padding: 8px 25px; width: 20%;">Change Selection</button>
            
            <!-- Hidden input for no information -->
            <input type="hidden" name="emi_status" value="no_information">
        </div>
    `;

    // ==================== CLEANUP ====================

    function destroy() {
        console.log("Step 5 Handler Destroyed");
        document.removeEventListener("click", handleDocumentClick);

        if (elements.nameTransferSelect) {
            elements.nameTransferSelect.removeEventListener("change", handleNameTransferChange);
        }
    }

    // Public API
    return {
        init,
        destroy,
        getState: () => ({ ...state }),
        validateAndUpdateNextButton,
    };
})();

// Register with StepManager
if (typeof StepManager !== "undefined") {
    StepManager.registerHandler(5, Step5Handler);
}

// Auto-initialize
document.addEventListener("DOMContentLoaded", function() {
    if (document.querySelector("#step5Form")) {
        Step5Handler.init();
    }
});