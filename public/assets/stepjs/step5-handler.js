// ============================================
// OPTIMIZED STEP 5 HANDLER - Documents Uploads
// ============================================
const Step5Handler = (function () {
    // Configuration constants
    const CONFIG = {
        submitUrl: "/applicant/documents/store",
        reuploadUrl: "/applicant/documents/reupload",
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
        documentTypes: {
            basic: "basic",
            nameTransfer: "nameTransfer",
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
                finalSubmitBtn: "#finalSubmitBtn",
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

    // Document configurations - RECEIVE from global variable
    const DOCUMENT_CONFIGS = {
        basic: window.documentBasicList || [],
        nameTransfer: [
            {
                id: 9,
                name: "Transfer Application",
                key: "transfer_application",
            },
            { id: 10, name: "Indemnity Bond", key: "indemnity_bond" },
            { id: 11, name: "Affidavit", key: "affidavit" },
            { id: 12, name: "NOC from Original Allottee", key: "noc_original" },
            {
                id: 13,
                name: "Succession Certificate",
                key: "succession_certificate",
            },
        ],
    };

    // Completed documents from server
    const COMPLETED_DOCUMENTS = window.completedDocumentsList || [];

    // State management (encapsulated)
    const state = {
        manager: null,
        isNameTransfer: false,
        completedBasicDocs: [],
        completedNameTransferDocs: [],
        emiFormSaved: false,
        applicantId: null,
        documentConfigs: DOCUMENT_CONFIGS,
        isLoading: false,
        // EMI Status Question
        isEmiActive: null, // true = yes, false = no, null = not answered
        // EMI Configuration
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
        // EMI Inputs (Only these two are user-entered)
        emiInputs: {
            withoutPenaltyCount: 0,
            withPenaltyCount: 0,
        },
        // EMI Timeline Calculations
        emiTimeline: {
            expectedCount: 0,
            paymentGap: 0,
            isEndDatePassed: false,
            penaltyApplied: false,
            penaltyReason: "",
        },
        // EMI Calculated Values
        emiCalculated: {
            completedCount: 0,
            lateCount: 0,
            remainingCount: 0,
            totalPaid: 0,
            totalRemaining: 0,
            currentBalance: 0,
            status: "Pending",
            expectedCount: 0,
            paymentGap: 0,
        },
    };

    // Cache DOM elements
    let elements = {};

    // ==================== INITIALIZATION ====================

    function init() {
        console.log("Step 5 Handler Initialized");

        cacheElements();
        state.applicantId = elements.applicantId?.value || "";

        bindEvents();
        initializeUI();

        // Load EMI configuration from DOM
        loadEmiConfiguration();
    }

    function cacheElements() {
        elements = {
            basicRows: document.querySelector(CONFIG.ui.selectors.basicRows),
            additionalRows: document.querySelector(
                CONFIG.ui.selectors.additionalRows,
            ),
            nameTransferSection: document.querySelector(
                CONFIG.ui.selectors.nameTransferSection,
            ),
            nameTransferSelect: document.querySelector(
                CONFIG.ui.selectors.nameTransferSelect,
            ),
            nametransferValue: document.querySelector(
                CONFIG.ui.selectors.nametransferValue,
            ),
            progressCount: document.querySelector(
                CONFIG.ui.selectors.progressCount,
            ),
            progressBar: document.querySelector(
                CONFIG.ui.selectors.progressBar,
            ),
            finalSubmitBtn: document.querySelector(
                CONFIG.ui.selectors.finalSubmitBtn,
            ),
            applicantId: document.querySelector(
                CONFIG.ui.selectors.applicantId,
            ),
            csrfToken:
                document.querySelector(CONFIG.ui.selectors.csrfToken)
                    ?.content || "",
        };
    }

    function bindEvents() {
        // Use event delegation for dynamic elements
        document.addEventListener("click", handleDocumentClick);

        if (elements.nameTransferSelect) {
            elements.nameTransferSelect.addEventListener(
                "change",
                handleNameTransferChange,
            );
        }
    }

    function initializeUI() {
        if (elements.basicRows) {
            elements.basicRows.innerHTML = "";
            loadNextDocument(CONFIG.documentTypes.basic);
        }

        setupNameTransfer();
        updateProgress();
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

        // EMI Status Question handler
        if (target.classList.contains("emi-status-btn")) {
            handleEmiStatusResponse(target.dataset.status);
        }

        // Change Selection button handler
        if (target.id === "changeEmiSelectionBtn") {
            resetEmiSelection();
        }

        // Calculate EMI button handler
        if (target.id === "calculateEmiBtn") {
            calculateEmiSummary();
        }

        // Save EMI button handler
        if (target.id === "saveEmiDetailsBtn") {
            saveEmiDetails();
        }
    }

    function handleNameTransferChange(e) {
        const isTransfer = e.target.value === "yes";
        state.isNameTransfer = isTransfer;

        if (elements.nametransferValue) {
            elements.nametransferValue.value = isTransfer ? "yes" : "no";
        }

        if (isTransfer) {
            hideElement("#additionalDocumentsSection");
            state.completedNameTransferDocs = [];
        } else {
            hideElement("#additionalDocumentsSection");
            state.completedNameTransferDocs = [];

            if (elements.additionalRows) {
                elements.additionalRows.innerHTML = "";
            }
        }

        updateProgress();
    }

    function handleEmiStatusResponse(status) {
        state.isEmiActive = status === "yes";

        // Hide the question section
        const questionSection = document.getElementById("emiStatusQuestion");
        if (questionSection) {
            questionSection.style.display = "none";
        }

        // Remove any existing content
        removeElement("#emiLedgerSystem");
        removeElement("#emiClosedMessage");

        if (state.isEmiActive) {
            // Show EMI configuration form and ledger
            showEmiConfigurationSection();
        } else {
            // Show only the financial ledger
            showLedgerOnlySection();
        }
    }

    function resetEmiSelection() {
        // Reset state
        state.isEmiActive = null;
        state.emiFormSaved = false;

        // Remove all EMI related sections
        removeElement("#emiLedgerSystem");
        removeElement("#emiClosedMessage");
        removeElement("#emiConfigurationForm");

        // Show the status question again
        const questionSection = document.getElementById("emiStatusQuestion");
        if (questionSection) {
            questionSection.style.display = "block";
        } else {
            // If question section was removed, recreate it
            const basicTable = elements.basicRows?.closest("table");
            if (basicTable) {
                basicTable.insertAdjacentHTML("afterend", EMI_STATUS_TEMPLATE);
            }
        }

        // Scroll to question
        setTimeout(() => {
            const questionEl = document.getElementById("emiStatusQuestion");
            if (questionEl) {
                questionEl.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }
        }, 100);
    }

    // ==================== UTILITY FUNCTIONS ====================

    function num(v) {
        return parseFloat(v) || 0;
    }

    function formatNumber(num) {
        if (num === 0) return "0.00";
        return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
    }

    function formatDate(dateString) {
        if (!dateString) return "-";
        const date = new Date(dateString);
        return date.toLocaleDateString("en-IN", {
            day: "2-digit",
            month: "short",
            year: "numeric",
        });
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

    // ==================== DOCUMENT ROW MANAGEMENT ====================

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
            previewBtn.textContent = file
                ? "Preview Document"
                : "Preview Remarks";
        }
    }

    function createDocumentRow(
        doc,
        sl,
        type,
        isCompleted = false,
        data = null,
    ) {
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
            remarksInput.addEventListener("input", () =>
                updatePreviewButtonState(row),
            );
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
        return [
            ...state.documentConfigs.basic,
            ...state.documentConfigs.nameTransfer,
        ].find((d) => d.id === docId);
    }

    // ==================== NAME TRANSFER SECTION ====================

    function setupNameTransfer() {
        if (!elements.nameTransferSection || !elements.nameTransferSelect)
            return;

        elements.nameTransferSection.style.display = "none";
    }

    // ==================== EMI STATUS QUESTION ====================

    const EMI_STATUS_TEMPLATE = `
        <div id="emiStatusQuestion" style="margin: 20px 0; padding: 30px; background: #fff; border: 1px solid #b11226; border-radius: 4px; text-align: center;">
            <h4 style="margin: 0 0 20px; color: #b11226;">EMI Payment Status</h4>
            <div style="font-size: 16px; margin-bottom: 25px;">Is the allottee currently paying EMI?</div>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <button type="button" class="btn-submit emi-status-btn" data-status="yes" style="padding: 12px 40px; background: #4caf50; font-size: 16px;">Yes</button>
                <button type="button" class="btn-submit emi-status-btn" data-status="no" style="padding: 12px 40px; background: #f44336; font-size: 16px;">No</button>
            </div>
        </div>
    `;

    // ==================== EMI CONFIGURATION FORM ====================

    const EMI_CONFIG_TEMPLATE = `
        <div id="emiConfigurationForm" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #b11226; border-radius: 4px;">
            <input type="hidden" id="emi_active_hidden" value="1">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; color: #b11226;">EMI Configuration Form</h4>
                <button type="button" id="changeEmiSelectionBtn" class="btn-submit" style="background: #ff9800; padding: 5px 15px; font-size: 12px;width: 10%;">Change Selection</button>
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

            <!-- EMI Input Form - ONLY TWO FIELDS -->
            <div style="margin-bottom: 20px; padding: 15px; background: #f0f2f5; border-radius: 4px;">
                <h5 style="margin: 0 0 15px; color: #333;">Enter EMI Payment Details</h5>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; align-items: end;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 12px;">EMI Paid Without Penalty</label>
                        <input type="number" id="withoutPenaltyCount" class="compact-input" min="0" placeholder="Enter count" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 12px;">EMI Paid With Penalty (Late)</label>
                        <input type="number" id="withPenaltyCount" class="compact-input" min="0" placeholder="Enter count" style="width: 100%;">
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn-submit" id="calculateEmiBtn" style="padding: 8px 20px;">Calculate</button>
                    </div>
                </div>
                <div style="margin-top: 10px; font-size: 12px; color: #666;">
                    <small>* Only these two values need to be entered. Everything else auto-calculates based on timeline.</small>
                </div>
            </div>
    `;

    // ==================== FINANCIAL LEDGER (Shared between both paths) ====================

    const FINANCIAL_LEDGER_TEMPLATE = `
            <!-- Timeline Validation Summary -->
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

            <!-- EMI Summary Cards -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="padding: 15px; background: #e8f5e9; border-radius: 4px; text-align: center;">
                    <div style="font-size: 12px; color: #2e7d32;">COMPLETED EMI COUNT</div>
                    <div style="font-size: 24px; font-weight: bold; color: #2e7d32;" id="completed_count">0</div>
                    <div style="font-size: 14px;" id="completed_breakdown">(0 + 0)</div>
                </div>
                <div style="padding: 15px; background: #ffebee; border-radius: 4px; text-align: center;">
                    <div style="font-size: 12px; color: #c62828;">LATE EMI COUNT</div>
                    <div style="font-size: 24px; font-weight: bold; color: #c62828;" id="late_count">0</div>
                    <div style="font-size: 14px;">With Penalty</div>
                </div>
                <div style="padding: 15px; background: #e3f2fd; border-radius: 4px; text-align: center;">
                    <div style="font-size: 12px; color: #1565c0;">REMAINING EMI COUNT</div>
                    <div style="font-size: 24px; font-weight: bold; color: #1565c0;" id="remaining_count">0</div>
                    <div style="font-size: 14px;" id="remaining_out_of">Out of 60</div>
                </div>
            </div>

            <!-- Financial Ledger - Accounting Style -->
            <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 4px;">
                <h5 style="margin: 0 0 15px; color: #333;">Financial Ledger</h5>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
                    <!-- Left Column - Counts -->
                    <div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Total EMI Count:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="ledger_total_count">60</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Expected EMI Count:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="ledger_expected_count">0</td>
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
                    
                    <!-- Right Column - Amounts -->
                    <div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>EMI Amount (Without Penalty):</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="display_emi_amount">₹0</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>EMI Amount (With Penalty):</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #c62828; text-align: right;" id="display_emi_late_amount">₹0</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Total Paid Amount:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; text-align: right;" id="total_paid_amount">₹0</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Remaining Balance:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #2e7d32; text-align: right;" id="remaining_balance">₹0</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Current Account Balance:</strong></td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #b11226; text-align: right;" id="current_balance">₹0</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- EMI Status -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="padding: 15px; background: #fff3e0; border-radius: 4px;">
                    <div style="font-size: 12px; color: #e65100;">LAST EMI DATE</div>
                    <div style="font-size: 20px; font-weight: bold;" id="last_emi_date">-</div>
                </div>
                <div style="padding: 15px; background: #e1f5fe; border-radius: 4px;">
                    <div style="font-size: 12px;color: #01579b;margin-bottom: 10px;">CURRENT EMI STATUS</div>
                    <div style="font-size: 20px; font-weight: bold;">
                        <span id="current_emi_status" style="padding: 5px 15px; border-radius: 20px; display: inline-block;">Pending</span>
                    </div>
                </div>
            </div>

            <!-- Calculation Logic Display -->
            <div style="margin-top: 20px; padding: 15px; background: #fafafa; border: 1px dashed #ccc; border-radius: 4px; font-size: 13px;">
                <strong>Calculation Logic:</strong>
                <div id="calculation_logic" style="margin-top: 10px; color: #555;">
                    <span id="logic_text">Enter values above and click Calculate</span>
                </div>
            </div>
            
            <!-- Save Button (Always visible) -->
            <div style="margin-top: 20px; text-align: right;">
                <button type="button" class="btn-submit" id="saveEmiDetailsBtn" style="padding: 10px 30px; background: #4caf50; font-size: 16px;">Save EMI Details</button>
            </div>
        </div>
    `;

    const EMI_CLOSED_LEDGER_TEMPLATE = `
        <div id="emiLedgerSystem" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #b11226; border-radius: 4px;">
            <input type="hidden" id="emi_closed_hidden" value="1">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; color: #b11226;">Financial Ledger (EMI Closed)</h4>
                <button type="button" id="changeEmiSelectionBtn" class="btn-submit" style="background: #ff9800; padding: 5px 15px; font-size: 12px;width:10%;">Change Selection</button>
            </div>
            
            <!-- Message indicating EMI is closed -->
            <div style="margin-bottom: 20px; padding: 15px; background: #fff3e0; border: 1px solid #ff9800; border-radius: 4px; text-align: center;">
                <div style="font-size: 14px; color: #e65100;">
                    <strong>EMI payments are closed for this allotment.</strong> Below is the final ledger summary.
                </div>
            </div>
            
            <!-- EMI Configuration Summary (Read-only) -->
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

    // Update the displayEmiForm function to show status question first
    function displayEmiForm() {
        if (document.getElementById("emiStatusQuestion") || state.emiFormSaved)
            return;

        const basicTable = elements.basicRows?.closest("table");
        if (basicTable) {
            // First show the status question
            basicTable.insertAdjacentHTML("afterend", EMI_STATUS_TEMPLATE);

            setTimeout(() => {
                document.getElementById("emiStatusQuestion").scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }, 100);
        }
    }

    function showEmiConfigurationSection() {
        console.log("load time");
        const statusQuestion = document.getElementById("emiStatusQuestion");
        const insertAfter =
            statusQuestion || elements.basicRows?.closest("table");

        if (insertAfter) {
            // Insert configuration form (without closing div)
            insertAfter.insertAdjacentHTML("afterend", EMI_CONFIG_TEMPLATE);

            // Then append the ledger part FIRST
            const configForm = document.getElementById("emiConfigurationForm");
            if (configForm) {
                configForm.insertAdjacentHTML(
                    "beforeend",
                    FINANCIAL_LEDGER_TEMPLATE,
                );
            }

            // NOW update configuration display AFTER all elements are in DOM
            setTimeout(() => {
                updateEmiConfigurationDisplay();

                // Update the remaining_out_of text
                const remainingOutOf =
                    document.getElementById("remaining_out_of");
                if (remainingOutOf) {
                    remainingOutOf.textContent = `Out of ${state.emiConfig.totalCount}`;
                }

                // Bind events
                const calculateBtn = document.getElementById("calculateEmiBtn");
                if (calculateBtn) {
                    calculateBtn.addEventListener("click", calculateEmiSummary);
                }

                const saveBtn = document.getElementById("saveEmiDetailsBtn");
                if (saveBtn) {
                    saveBtn.addEventListener("click", saveEmiDetails);
                }

                const changeBtn = document.getElementById(
                    "changeEmiSelectionBtn",
                );
                if (changeBtn) {
                    changeBtn.addEventListener("click", resetEmiSelection);
                }

                // Add input validation
                const withoutPenaltyInput = document.getElementById(
                    "withoutPenaltyCount",
                );
                const withPenaltyInput =
                    document.getElementById("withPenaltyCount");

                if (withoutPenaltyInput) {
                    withoutPenaltyInput.addEventListener(
                        "input",
                        validateEmiInputs,
                    );
                }
                if (withPenaltyInput) {
                    withPenaltyInput.addEventListener(
                        "input",
                        validateEmiInputs,
                    );
                }

                // Check for pre-filled values from server
                checkForPrefilledEmiData();

                // Auto-calculate if there are pre-filled values
                if (withoutPenaltyInput && withoutPenaltyInput.value) {
                    calculateEmiSummary();
                }
            }, 100); // Small delay to ensure DOM is ready

            setTimeout(() => {
                const form = document.getElementById("emiConfigurationForm");
                if (form) {
                    form.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                }
            }, 200);
        } else {
            console.log("green");
        }
    }

    function showLedgerOnlySection() {
        const statusQuestion = document.getElementById("emiStatusQuestion");
        const insertAfter =
            statusQuestion || elements.basicRows?.closest("table");

        if (insertAfter) {
            // Insert closed ledger template
            insertAfter.insertAdjacentHTML(
                "afterend",
                EMI_CLOSED_LEDGER_TEMPLATE,
            );

            // Update configuration display
            updateEmiConfigurationDisplay();

            // Then append the ledger part (without input fields)
            const ledgerContainer = document.getElementById("emiLedgerSystem");
            if (ledgerContainer) {
                ledgerContainer.insertAdjacentHTML(
                    "beforeend",
                    FINANCIAL_LEDGER_TEMPLATE,
                );
            }

            // Update the remaining_out_of text
            const remainingOutOf = document.getElementById("remaining_out_of");
            if (remainingOutOf) {
                remainingOutOf.textContent = `Out of ${state.emiConfig.totalCount}`;
            }

            // Update ledger total count
            const ledgerTotalCount =
                document.getElementById("ledger_total_count");
            if (ledgerTotalCount) {
                ledgerTotalCount.textContent = state.emiConfig.totalCount;
            }

            // Bind change selection button
            document
                .getElementById("changeEmiSelectionBtn")
                .addEventListener("click", resetEmiSelection);

            // Bind save button
            document
                .getElementById("saveEmiDetailsBtn")
                .addEventListener("click", saveEmiDetails);

            // Check for pre-filled values from server
            checkForPrefilledEmiData();

            // Calculate with existing values if any
            calculateEmiSummary(true);

            setTimeout(() => {
                document.getElementById("emiLedgerSystem").scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }, 100);
        }
    }

    function checkForPrefilledEmiData() {
        console.log("Checking for pre-filled EMI data...");

        // Check if there are pre-filled values from server
        const withoutPenaltyInput = document.getElementById(
            "withoutPenaltyCount",
        );
        const withPenaltyInput = document.getElementById("withPenaltyCount");

        console.log("Without Penalty Input:", withoutPenaltyInput);
        console.log("With Penalty Input:", withPenaltyInput);

        // Check if inputs have values (pre-filled by server)
        if (withoutPenaltyInput) {
            const withoutVal = parseInt(withoutPenaltyInput.value) || 0;
            const withVal = parseInt(withPenaltyInput?.value) || 0;

            console.log("Pre-filled values:", { withoutVal, withVal });

            if (withoutVal > 0 || withVal > 0) {
                console.log("Found pre-filled EMI data:", {
                    withoutVal,
                    withVal,
                });

                // Set EMI as active
                state.isEmiActive = true;

                // Auto-calculate with these values
                setTimeout(() => {
                    calculateEmiSummary();
                }, 200);
            }
        }

        // Check if there's a hidden field indicating EMI is closed
        const emiClosedHidden = document.getElementById("emi_closed_hidden");
        if (emiClosedHidden && emiClosedHidden.value === "1") {
            state.isEmiActive = false;
        }
    }

    function loadEmiConfiguration() {
        const totalAmountEl = document.querySelector(
            CONFIG.ui.selectors.totalEmiAmount,
        );
        const emiCountEl = document.querySelector(
            CONFIG.ui.selectors.emiMonthCount,
        );
        const startMonthEl = document.querySelector(
            CONFIG.ui.selectors.emiStartMonth,
        );
        const startYearEl = document.querySelector(
            CONFIG.ui.selectors.emiStartYear,
        );
        const amountWithoutPenaltyEl = document.querySelector(
            CONFIG.ui.selectors.emiAmount,
        );
        // FIX: Remove the duplicate declaration - use the correct selector
        const amountWithPenaltyEl = document.querySelector(
            CONFIG.ui.selectors.emiAmountLateAmount, // This is "#late_interest_amount"
        );

        console.log("Without Penalty Element:", amountWithoutPenaltyEl);
        console.log("With Penalty Element:", amountWithPenaltyEl);
        console.log("Without Penalty Value:", amountWithoutPenaltyEl?.value);
        console.log("With Penalty Value:", amountWithPenaltyEl?.value);

        state.emiConfig = {
            totalAmount: parseFloat(totalAmountEl?.value || 0),
            totalCount: parseInt(emiCountEl?.value || 60),
            startMonth: startMonthEl?.value || "",
            startYear: startYearEl?.value || "",
            amountWithoutPenalty: parseFloat(
                amountWithoutPenaltyEl?.value || 0,
            ),
            amountWithPenalty: parseFloat(amountWithPenaltyEl?.value || 0),
        };

        console.log("Loaded EMI Config:", state.emiConfig);

        // Calculate last EMI month and year
        if (state.emiConfig.startMonth && state.emiConfig.startYear) {
            const startDate = new Date(
                state.emiConfig.startYear,
                parseInt(state.emiConfig.startMonth) - 1,
                1,
            );
            const lastDate = new Date(startDate);
            lastDate.setMonth(
                startDate.getMonth() + state.emiConfig.totalCount - 1,
            );
            state.emiConfig.lastEmiMonth =
                CONFIG.monthNames[lastDate.getMonth() + 1];
            state.emiConfig.lastEmiYear = lastDate.getFullYear().toString();
            state.emiConfig.endDate =
                state.emiConfig.lastEmiMonth +
                " " +
                state.emiConfig.lastEmiYear;
        }
    }

    function updateEmiConfigurationDisplay() {
        console.log("Updating display with:", state.emiConfig);

        // Wait for elements to exist
        const displayTotalAmount = document.getElementById(
            "display_total_emi_amount",
        );
        const displayTotalCount = document.getElementById(
            "display_total_emi_count",
        );
        const displayEmiPeriod = document.getElementById("display_emi_period");
        const displayEmiAmount = document.getElementById("display_emi_amount");
        const displayEmiLateAmount = document.getElementById(
            "display_emi_late_amount",
        );
        const lastEmiDate = document.getElementById("last_emi_date");
        const ledgerTotalCount = document.getElementById("ledger_total_count");

        // Only update if elements exist
        if (displayTotalAmount) {
            displayTotalAmount.textContent =
                "₹" + formatNumber(state.emiConfig.totalAmount);
            console.log(
                "Updated total amount:",
                displayTotalAmount.textContent,
            );
        } else {
            console.log("display_total_emi_amount not found");
        }

        if (displayTotalCount) {
            displayTotalCount.textContent = state.emiConfig.totalCount;
        }

        if (ledgerTotalCount) {
            ledgerTotalCount.textContent = state.emiConfig.totalCount;
        }

        if (
            displayEmiPeriod &&
            state.emiConfig.startMonth &&
            state.emiConfig.startYear
        ) {
            const startMonthName =
                CONFIG.monthNames[parseInt(state.emiConfig.startMonth)];
            displayEmiPeriod.textContent = `${startMonthName} ${state.emiConfig.startYear} to ${state.emiConfig.endDate}`;
        }

        if (displayEmiAmount) {
            console.log(
                "Setting EMI Without Penalty:",
                state.emiConfig.amountWithoutPenalty,
            );
            displayEmiAmount.textContent =
                "₹" + formatNumber(state.emiConfig.amountWithoutPenalty);
        } else {
            console.log("display_emi_amount not found");
        }

        if (displayEmiLateAmount) {
            console.log(
                "Setting EMI With Penalty:",
                state.emiConfig.amountWithPenalty,
            );
            displayEmiLateAmount.textContent =
                "₹" + formatNumber(state.emiConfig.amountWithPenalty);
        } else {
            console.log("display_emi_late_amount not found");
        }

        if (lastEmiDate) {
            lastEmiDate.textContent = state.emiConfig.endDate || "-";
        }
    }

    function validateEmiInputs() {
        if (!state.isEmiActive) return true; // Skip validation if EMI is closed

        const withoutPenalty =
            parseInt(document.getElementById("withoutPenaltyCount")?.value) ||
            0;
        const withPenalty =
            parseInt(document.getElementById("withPenaltyCount")?.value) || 0;
        const total = withoutPenalty + withPenalty;

        if (total > state.emiConfig.totalCount) {
            alert(
                `Total EMIs paid (${total}) cannot exceed total EMI count (${state.emiConfig.totalCount})`,
            );
            return false;
        }
        return true;
    }

    function calculateExpectedEmiCount() {
        if (!state.emiConfig.startMonth || !state.emiConfig.startYear) return 0;

        const startDate = new Date(
            state.emiConfig.startYear,
            parseInt(state.emiConfig.startMonth) - 1,
            1,
        );
        const currentDate = new Date();

        // Calculate months between start date and current date
        const startYear = startDate.getFullYear();
        const startMonth = startDate.getMonth();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();

        let monthsDiff =
            (currentYear - startYear) * 12 + (currentMonth - startMonth);

        // Add 1 to include current month if we're past the start day
        if (currentDate.getDate() >= startDate.getDate()) {
            monthsDiff += 1;
        }

        // Can't be less than 0 or more than total count
        return Math.min(Math.max(monthsDiff, 0), state.emiConfig.totalCount);
    }

    function checkEndDatePassed() {
        if (!state.emiConfig.lastEmiYear || !state.emiConfig.lastEmiMonth)
            return false;

        const lastEmiDate = new Date(
            parseInt(state.emiConfig.lastEmiYear),
            CONFIG.monthNames.indexOf(state.emiConfig.lastEmiMonth) - 1,
            1,
        );
        const currentDate = new Date();

        return currentDate > lastEmiDate;
    }

    function calculateEmiSummary(isClosed = false) {
        // Get user inputs
        let withoutPenalty =
            parseInt(document.getElementById("withoutPenaltyCount")?.value) ||
            0;
        let withPenalty =
            parseInt(document.getElementById("withPenaltyCount")?.value) || 0;

        const {
            totalCount,
            amountWithoutPenalty,
            amountWithPenalty,
            totalAmount,
            endDate,
        } = state.emiConfig;

        console.log("Using EMI amounts:", {
            withoutPenalty: amountWithoutPenalty,
            withPenalty: amountWithPenalty,
            totalCount,
            totalAmount,
        });

        const total = withoutPenalty + withPenalty;

        // Validate
        if (total > totalCount) {
            alert(
                `Total EMIs paid (${total}) cannot exceed total EMI count (${totalCount})`,
            );
            return;
        }

        // Store input
        state.emiInputs = {
            withoutPenaltyCount: withoutPenalty,
            withPenaltyCount: withPenalty,
        };

        // Timeline calculations
        const expectedCount = calculateExpectedEmiCount();
        const isEndDatePassed = checkEndDatePassed();
        const paymentGap = Math.max(expectedCount - total, 0);

        let penaltyApplied = false;
        let penaltyReason = "";

        if (isClosed) {
            penaltyReason = "EMI payments are closed. No remaining EMIs.";
        } else if (isEndDatePassed) {
            penaltyApplied = true;
            penaltyReason = `EMI end date (${endDate}) has passed. All remaining EMIs include penalty.`;
        } else if (paymentGap > 0) {
            penaltyApplied = true;
            penaltyReason = `Payment gap detected: Expected ${expectedCount} EMIs, but only ${total} paid. Remaining EMIs include penalty.`;
        } else {
            penaltyReason = `Payments are on schedule (${total} paid out of ${expectedCount} expected). Remaining EMIs are without penalty.`;
        }

        state.emiTimeline = {
            expectedCount,
            paymentGap,
            isEndDatePassed,
            penaltyApplied,
            penaltyReason,
        };

        // -------- EMI Calculation --------

        // For "Yes" (active EMI): completedCount = total paid EMIs
        // For "No" (closed EMI): completedCount = 0 (no payments made)
        let completedCount = state.isEmiActive ? total : totalCount;
        let remainingCount = totalCount - completedCount;
        console.log("c" + completedCount);
        console.log("r" + remainingCount);

        // Calculate paid amount based on actual payments
        let paidAmount = 0;
        if (state.isEmiActive) {
            // Active EMI: calculate based on user inputs
            paidAmount =
                withoutPenalty * amountWithoutPenalty +
                withPenalty * amountWithPenalty;
        } else {
            // Closed EMI: no payments made
            paidAmount = completedCount * amountWithPenalty;
        }

        // Calculate remaining amount based on penalty logic
        let remainingAmount =
            remainingCount *
            (penaltyApplied ? amountWithPenalty : amountWithoutPenalty);

        let currentBalance = 0;
        if (total == totalCount) {
            currentBalance = 0;
        } else {
            currentBalance = state.isEmiActive ? totalAmount - paidAmount : 0;
        }

        // Determine status
        let status = "Pending";
        if (!state.isEmiActive) {
            status = "Completed"; // EMI is closed
        } else if (completedCount === totalCount) {
            status = "Completed";
        } else if (completedCount > 0) {
            status =
                paymentGap > 0 || isEndDatePassed
                    ? "Late Payment"
                    : "On Schedule";
        }

        // Store results
        state.emiCalculated = {
            completedCount,
            lateCount: withPenalty,
            remainingCount,
            totalPaid: paidAmount,
            totalRemaining: remainingAmount,
            currentBalance,
            status,
            expectedCount,
            paymentGap,
        };

        console.log("Calculated Results:", state.emiCalculated);

        // Update UI
        updateEmiDisplays(penaltyReason);
    }

    function updateEmiDisplays(logicText) {
        // Always show the static EMI amounts from config
        const displayEmiAmount = document.getElementById("display_emi_amount");
        const displayEmiLateAmount = document.getElementById(
            "display_emi_late_amount",
        );

        if (displayEmiAmount) {
            // Always show the static amount, never change it
            displayEmiAmount.textContent =
                "₹" + formatNumber(state.emiConfig.amountWithoutPenalty);
            console.log(
                "Setting EMI Without Penalty to:",
                displayEmiAmount.textContent,
            );
        }

        if (displayEmiLateAmount) {
            // Always show the static amount, never change it
            displayEmiLateAmount.textContent =
                "₹" + formatNumber(state.emiConfig.amountWithPenalty);
            console.log(
                "Setting EMI With Penalty to:",
                displayEmiLateAmount.textContent,
            );
        }

        // Update timeline summary
        const expectedCountEl = document.getElementById("expected_count");
        const paymentGapEl = document.getElementById("payment_gap");
        const penaltyStatusEl = document.getElementById("penalty_status");

        if (expectedCountEl)
            expectedCountEl.textContent = state.emiTimeline.expectedCount;
        if (paymentGapEl)
            paymentGapEl.textContent = state.emiTimeline.paymentGap;

        if (penaltyStatusEl) {
            penaltyStatusEl.textContent = state.emiTimeline.penaltyApplied
                ? "Penalty Applied"
                : "No Penalty";
            penaltyStatusEl.style.color = state.emiTimeline.penaltyApplied
                ? "#c62828"
                : "#2e7d32";
        }

        // Update summary cards
        const completedCountEl = document.getElementById("completed_count");
        const lateCountEl = document.getElementById("late_count");
        const remainingCountEl = document.getElementById("remaining_count");
        const completedBreakdownEl = document.getElementById(
            "completed_breakdown",
        );

        if (completedCountEl)
            completedCountEl.textContent = state.emiCalculated.completedCount;
        if (lateCountEl)
            lateCountEl.textContent = state.emiCalculated.lateCount;
        if (remainingCountEl)
            remainingCountEl.textContent = state.emiCalculated.remainingCount;

        if (completedBreakdownEl) {
            completedBreakdownEl.textContent = `(${state.emiInputs.withoutPenaltyCount} + ${state.emiInputs.withPenaltyCount})`;
        }

        // Update ledger counts
        const ledgerExpectedCountEl = document.getElementById(
            "ledger_expected_count",
        );
        const ledgerCompletedCountEl = document.getElementById(
            "ledger_completed_count",
        );
        const ledgerLateCountEl = document.getElementById("ledger_late_count");
        const ledgerRemainingCountEl = document.getElementById(
            "ledger_remaining_count",
        );

        if (ledgerExpectedCountEl)
            ledgerExpectedCountEl.textContent = state.emiTimeline.expectedCount;
        if (ledgerCompletedCountEl)
            ledgerCompletedCountEl.textContent =
                state.emiCalculated.completedCount;
        if (ledgerLateCountEl)
            ledgerLateCountEl.textContent = state.emiCalculated.lateCount;
        if (ledgerRemainingCountEl)
            ledgerRemainingCountEl.textContent =
                state.emiCalculated.remainingCount;

        // Update financial values
        const totalPaidEl = document.getElementById("total_paid_amount");
        const remainingBalanceEl = document.getElementById("remaining_balance");
        const currentBalanceEl = document.getElementById("current_balance");

        if (totalPaidEl)
            totalPaidEl.textContent =
                "₹" + formatNumber(state.emiCalculated.totalPaid);
        if (remainingBalanceEl)
            remainingBalanceEl.textContent =
                "₹" + formatNumber(state.emiCalculated.totalRemaining);
        if (currentBalanceEl)
            currentBalanceEl.textContent =
                "₹" + formatNumber(state.emiCalculated.currentBalance);

        // Update status with color
        const statusEl = document.getElementById("current_emi_status");
        if (statusEl) {
            statusEl.textContent = state.emiCalculated.status;

            // Apply color based on status
            let bgColor, textColor;
            switch (state.emiCalculated.status) {
                case "Completed":
                    bgColor = "#4caf50";
                    textColor = "white";
                    break;
                case "Late Payment":
                    bgColor = "#f44336";
                    textColor = "white";
                    break;
                case "On Schedule":
                    bgColor = "#2196f3";
                    textColor = "white";
                    break;
                default:
                    bgColor = "#ff9800";
                    textColor = "white";
            }
            statusEl.style.background = bgColor;
            statusEl.style.color = textColor;
            statusEl.style.padding = "5px 15px";
            statusEl.style.borderRadius = "20px";
        }

        // Update calculation logic display
        const logicTextEl = document.getElementById("logic_text");
        if (logicTextEl) {
            logicTextEl.innerHTML =
                logicText || "Enter values above and click Calculate";
        }
    }

    async function saveEmiDetails() {
        // Validate if calculation was done for active EMI
        if (
            state.isEmiActive &&
            state.emiCalculated.completedCount === 0 &&
            (state.emiInputs.withoutPenaltyCount > 0 ||
                state.emiInputs.withPenaltyCount > 0)
        ) {
            alert("Please click Calculate button first");
            return;
        }

        const formData = new FormData();
        formData.append("_token", elements.csrfToken);
        formData.append("allottee_id", state.applicantId);
        formData.append("emi_config", JSON.stringify(state.emiConfig));
        formData.append("emi_inputs", JSON.stringify(state.emiInputs));
        formData.append("emi_timeline", JSON.stringify(state.emiTimeline));
        formData.append("emi_calculated", JSON.stringify(state.emiCalculated));
        formData.append("emi_active", state.isEmiActive);

        const saveBtn = document.getElementById("saveEmiDetailsBtn");
        const originalText = saveBtn.textContent;
        setButtonLoading(saveBtn, true, "Saving...");

        try {
            const response = await fetch("/applicant/save-emi-ledger", {
                method: "POST",
                headers: { Accept: "application/json" },
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                state.emiFormSaved = true;
                saveBtn.textContent = "Saved ✓";
                saveBtn.style.background = "#4caf50";

                // Disable inputs and calculate button after save
                if (state.isEmiActive) {
                    const withoutPenaltyInput = document.getElementById(
                        "withoutPenaltyCount",
                    );
                    const withPenaltyInput =
                        document.getElementById("withPenaltyCount");
                    const calculateBtn =
                        document.getElementById("calculateEmiBtn");

                    if (withoutPenaltyInput)
                        withoutPenaltyInput.disabled = true;
                    if (withPenaltyInput) withPenaltyInput.disabled = true;
                    if (calculateBtn) calculateBtn.disabled = true;
                }

                saveBtn.disabled = true;

                alert("EMI details saved successfully");

                // Check if all documents completed
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

    // ==================== MODAL ====================

    function showPreviewModal(doc, row) {
        const docData = collectDocumentData(row);
        const filePreview = docData.file
            ? generateFilePreview(docData.file)
            : "<p>No file attached</p>";

        removeElement("#filePreviewModal");

        document.body.insertAdjacentHTML(
            "beforeend",
            generateModalTemplate(doc.name, filePreview, docData),
        );

        document
            .getElementById("confirmFileBtn")
            .addEventListener("click", () => {
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

            // Append all document data
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

            // Add to completed documents array
            if (type === CONFIG.documentTypes.basic) {
                if (!state.completedBasicDocs.some((d) => d.id === docId)) {
                    state.completedBasicDocs.push(documentData);
                }
            } else if (type === CONFIG.documentTypes.nameTransfer) {
                if (
                    !state.completedNameTransferDocs.some((d) => d.id === docId)
                ) {
                    state.completedNameTransferDocs.push(documentData);
                }
            }

            // Handle workflow
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

            // Allotment Letter triggers EMI form
            if (docId === 2) {
                displayEmiForm();
                return;
            }

            if (state.completedBasicDocs.length >= totalBasicDocs) {
                if (elements.nameTransferSection) {
                    elements.nameTransferSection.style.display = "block";
                }
            }

            loadNextDocument(CONFIG.documentTypes.basic);
        } else if (type === CONFIG.documentTypes.nameTransfer) {
            const totalTransferDocs = state.documentConfigs.nameTransfer.length;

            if (state.completedNameTransferDocs.length >= totalTransferDocs) {
                alert("All documents submitted successfully.");
            }

            loadNextDocument(CONFIG.documentTypes.nameTransfer);
        }

        updateProgress();
        checkAllDocumentsCompleted();
    }

    // ==================== DOCUMENT LOADING ====================

    function loadNextDocument(type) {
        const tbody = document.getElementById(
            type === CONFIG.documentTypes.basic
                ? "basicDocumentRows"
                : "additionalDocumentRows",
        );
        const documents = state.documentConfigs[type];
        const completedDocs =
            type === CONFIG.documentTypes.basic
                ? state.completedBasicDocs
                : state.completedNameTransferDocs;

        if (!tbody) return;

        const nextIndex = completedDocs.length;
        tbody.innerHTML = "";

        // Render completed rows
        completedDocs.forEach((completedDoc, index) => {
            const originalDoc = documents.find((d) => d.id === completedDoc.id);
            if (originalDoc) {
                tbody.insertAdjacentHTML(
                    "beforeend",
                    createDocumentRow(
                        originalDoc,
                        index + 1,
                        type,
                        true,
                        completedDoc,
                    ),
                );
            }
        });

        // Render next incomplete document if any
        if (nextIndex < documents.length) {
            renderNextDocumentRow(
                tbody,
                documents[nextIndex],
                nextIndex + 1,
                type,
            );
        } else if (type === CONFIG.documentTypes.nameTransfer) {
            showCompletionMessage(tbody);
        }
    }

    function renderNextDocumentRow(tbody, document, index, type) {
        tbody.insertAdjacentHTML(
            "beforeend",
            createDocumentRow(document, index, type, false),
        );

        const newRow = tbody.querySelector(
            `tr[data-document-id="${document.id}"]`,
        );
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

    // ==================== PROGRESS TRACKING ====================

    function updateProgress() {
        const totalBasic = state.documentConfigs.basic.length;
        const totalNameTransfer = state.isNameTransfer
            ? state.documentConfigs.nameTransfer.length
            : 0;
        const completedCount =
            state.completedBasicDocs.length +
            state.completedNameTransferDocs.length;
        const totalDocs = totalBasic + totalNameTransfer;

        if (elements.progressCount) {
            elements.progressCount.textContent = `${completedCount}/${totalDocs}`;
        }

        if (elements.progressBar) {
            const percentage =
                totalDocs > 0 ? (completedCount / totalDocs) * 100 : 0;
            elements.progressBar.style.width = `${percentage}%`;
        }
    }

    function checkAllDocumentsCompleted() {
        const totalBasic = state.documentConfigs.basic.length;
        const totalNameTransfer = state.isNameTransfer
            ? state.documentConfigs.nameTransfer.length
            : 0;

        const allBasicCompleted =
            state.completedBasicDocs.length === totalBasic;
        const allNameTransferCompleted =
            !state.isNameTransfer ||
            state.completedNameTransferDocs.length === totalNameTransfer;

        if (
            allBasicCompleted &&
            allNameTransferCompleted &&
            state.emiFormSaved
        ) {
            enableSubmitButton();
        }
    }

    function enableSubmitButton() {
        if (elements.finalSubmitBtn) {
            elements.finalSubmitBtn.disabled = false;
            elements.finalSubmitBtn.classList.add("enabled");
        }
    }

    function setButtonLoading(button, isLoading, text) {
        button.disabled = isLoading;
        button.textContent = text;
    }

    // ==================== CLEANUP ====================

    function destroy() {
        console.log("Step 5 Handler Destroyed");
        document.removeEventListener("click", handleDocumentClick);

        if (elements.nameTransferSelect) {
            elements.nameTransferSelect.removeEventListener(
                "change",
                handleNameTransferChange,
            );
        }
    }

    // Public API
    return {
        init,
        destroy,
        getState: () => ({ ...state }),
    };
})();

// Register with StepManager
if (typeof StepManager !== "undefined") {
    StepManager.registerHandler(5, Step5Handler);
}
