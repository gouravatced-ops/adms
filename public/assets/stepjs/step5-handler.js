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
                csrfToken: 'meta[name="csrf-token"]',
            },
        },
    };

    // Document configurations - RECEIVE from global variable
    const DOCUMENT_CONFIGS = {
        basic: window.documentBasicList || [], // Fallback to empty array if not set
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
    console.log("Pending Documents:", DOCUMENT_CONFIGS.basic);
    console.log("Completed Documents:", COMPLETED_DOCUMENTS);
    console.log("Name Transfer Documents:", DOCUMENT_CONFIGS.nameTransfer);

    // State management (encapsulated)
    const state = {
        manager: null,
        isNameTransfer: false,
        completedBasicDocs: [],
        completedNameTransferDocs: [],
        emiFormSaved: false,
        allotteeDetailsSaved: false,
        applicantId: null,
        documentConfigs: DOCUMENT_CONFIGS,
        isLoading: false,
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
    }

    function handleNameTransferChange(e) {
        const isTransfer = e.target.value === "yes";
        state.isNameTransfer = isTransfer;

        if (elements.nametransferValue) {
            elements.nametransferValue.value = isTransfer ? "yes" : "no";
        }

        if (isTransfer) {
            // showNewAllotteeForm();
            hideElement("#additionalDocumentsSection");
            state.completedNameTransferDocs = [];
        } else {
            hideElement("#additionalDocumentsSection");
            removeElement("#newAllotteeForm");
            state.completedNameTransferDocs = [];

            if (elements.additionalRows) {
                elements.additionalRows.innerHTML = "";
            }
        }

        updateProgress();
    }

    // ==================== UTILITY FUNCTIONS ====================

    function num(v) {
        return parseFloat(v) || 0;
    }

    function hideElement(selector) {
        const element = document.querySelector(selector);
        if (element) element.style.display = "none";
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

    function showNewAllotteeForm() {
        if (document.getElementById("newAllotteeForm")) return;

        const formHtml = `
            <div id="newAllotteeForm" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #aa7700; border-radius: 4px;">
                <h4 style="margin: 0 0 15px; color: #aa7700;">New Allottee Details</h4>
                <div id="allotteeDetailsForm" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    ${generateAllotteeFormFields()}
                </div>
                <div style="margin-top: 15px; text-align: right;">
                    <button type="button" class="btn-submit" id="saveAllotteeBtn" style="width: auto; padding: 8px 20px;">Save Allottee Details</button>
                </div>
            </div>
        `;

        elements.nameTransferSection.insertAdjacentHTML("afterend", formHtml);
        document
            .getElementById("saveAllotteeBtn")
            .addEventListener("click", saveAllotteeDetails);
    }

    function generateAllotteeFormFields() {
        return `
            <div>
                <label style="font-size: 12px;">Allottee Name *</label>
                <input type="text" name="allottee_name" class="compact-input" required>
            </div>
            <div>
                <label style="font-size: 12px;">Father/Husband Name *</label>
                <input type="text" name="father_name" class="compact-input" required>
            </div>
            <div>
                <label style="font-size: 12px;">Gender *</label>
                <select name="gender" class="compact-input" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label style="font-size: 12px;">Date of Birth *</label>
                <input type="date" name="dob" class="compact-input" required>
            </div>
            <div>
                <label style="font-size: 12px;">Marital Status *</label>
                <select name="marital_status" class="compact-input" required>
                    <option value="">Select</option>
                    <option value="married">Married</option>
                    <option value="unmarried">Unmarried</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>
            <div>
                <label style="font-size: 12px;">Category *</label>
                <select name="category" class="compact-input" required>
                    <option value="">Select</option>
                    <option value="general">General</option>
                    <option value="obc">OBC</option>
                    <option value="sc">SC</option>
                    <option value="st">ST</option>
                </select>
            </div>
            <div>
                <label style="font-size: 12px;">Religion *</label>
                <input type="text" name="religion" class="compact-input" required>
            </div>
            <div>
                <label style="font-size: 12px;">Nationality *</label>
                <input type="text" name="nationality" class="compact-input" value="Indian" required>
            </div>
            <div>
                <label style="font-size: 12px;">Address for Correspondence *</label>
                <textarea name="correspondence_address" class="compact-input" rows="2" required></textarea>
            </div>
            <div>
                <label style="font-size: 12px;">Full Permanent Address *</label>
                <textarea name="permanent_address" class="compact-input" rows="2" required></textarea>
            </div>
            <div>
                <label style="font-size: 12px;">Mobile No. *</label>
                <input type="tel" name="mobile" class="compact-input" pattern="[0-9]{10}" required>
            </div>
            <div>
                <label style="font-size: 12px;">Alternate Mobile No.</label>
                <input type="tel" name="alternate_mobile" class="compact-input" pattern="[0-9]{10}">
            </div>
            <div>
                <label style="font-size: 12px;">WhatsApp No.</label>
                <input type="tel" name="whatsapp" class="compact-input" pattern="[0-9]{10}">
            </div>
            <div>
                <label style="font-size: 12px;">Email ID *</label>
                <input type="email" name="email" class="compact-input" required>
            </div>
        `;
    }

    async function saveAllotteeDetails() {
        const form = document.getElementById("allotteeDetailsForm");
        const inputs = form.querySelectorAll("input, select, textarea");

        // Basic validation
        if (!validateAllotteeForm(inputs)) return;

        const formData = new FormData();
        formData.append("_token", elements.csrfToken);
        formData.append("allottee_id", state.applicantId);

        inputs.forEach((input) => {
            formData.append(input.name, input.value);
        });

        const saveBtn = document.getElementById("saveAllotteeBtn");
        const originalText = saveBtn.textContent;

        setButtonLoading(saveBtn, true, "Saving...");

        try {
            const response = await fetch("/applicant/save-allottee-details", {
                method: "POST",
                headers: { Accept: "application/json" },
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                document.getElementById("newAllotteeForm").style.opacity =
                    "0.7";
                inputs.forEach((el) => (el.disabled = true));
                saveBtn.textContent = "Saved";
                state.allotteeDetailsSaved = true;
            } else {
                throw new Error(data.message || "Error saving details");
            }
        } catch (error) {
            console.error("Error:", error);
            alert(error.message);
            setButtonLoading(saveBtn, false, originalText);
        }
    }

    function validateAllotteeForm(inputs) {
        let isValid = true;
        inputs.forEach((input) => {
            if (input.hasAttribute("required") && !input.value) {
                isValid = false;
                input.classList.add("error");
            } else {
                input.classList.remove("error");
            }
        });

        if (!isValid) {
            alert("Please fill all required fields");
        }

        return isValid;
    }

    function setButtonLoading(button, isLoading, text) {
        button.disabled = isLoading;
        button.textContent = text;
    }

    // ==================== EMI FORM ====================

    const EMI_FORM_TEMPLATE = `
        <div id="emiPaymentForm" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #b11226; border-radius: 4px;">
            <h4 style="margin: 0 0 15px; color: #b11226;">EMI Payment Status</h4>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Is EMI still being paid?</label>
                <select id="emiPaymentStatus" class="compact-input" style="width: 200px;" required>
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div id="emiCountSection" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Without Penalty EMI Count</label>
                        <input type="number" id="withoutPenaltyEmi" class="compact-input" min="0" placeholder="Enter count">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">With Penalty EMI Count</label>
                        <input type="number" id="withPenaltyEmi" class="compact-input" min="0" placeholder="Enter count">
                    </div>
                </div>
            </div>

            <div style="margin-top: 15px; text-align: right;">
                <button type="button" class="btn-submit" id="saveEmiBtn" style="width: auto; padding: 8px 20px;">Save EMI Details</button>
            </div>
        </div>
    `;

    function displayEmiForm() {
        if (document.getElementById("emiPaymentForm") || state.emiFormSaved)
            return;

        const basicTable = elements.basicRows?.closest("table");
        if (basicTable) {
            basicTable.insertAdjacentHTML("afterend", EMI_FORM_TEMPLATE);

            const emiStatus = document.getElementById("emiPaymentStatus");
            const emiCountSection = document.getElementById("emiCountSection");

            emiStatus.addEventListener("change", (e) => {
                emiCountSection.style.display =
                    e.target.value === "yes" ? "block" : "none";
            });

            document
                .getElementById("saveEmiBtn")
                .addEventListener("click", saveEmiDetails);

            setTimeout(() => {
                document.getElementById("emiPaymentForm").scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }, 100);
        }
    }

    async function saveEmiDetails() {
        const emiStatus = document.getElementById("emiPaymentStatus").value;

        if (!emiStatus) {
            alert("Please select EMI payment status");
            return;
        }

        if (emiStatus === "yes") {
            const withoutPenalty =
                document.getElementById("withoutPenaltyEmi").value;
            const withPenalty = document.getElementById("withPenaltyEmi").value;

            if (!withoutPenalty || !withPenalty) {
                alert("Please enter both EMI counts");
                return;
            }
        }

        const formData = new FormData();
        formData.append("_token", elements.csrfToken);
        formData.append("allottee_id", state.applicantId);
        formData.append("emi_status", emiStatus);

        if (emiStatus === "yes") {
            formData.append(
                "without_penalty_emi",
                document.getElementById("withoutPenaltyEmi").value,
            );
            formData.append(
                "with_penalty_emi",
                document.getElementById("withPenaltyEmi").value,
            );
        }

        const saveBtn = document.getElementById("saveEmiBtn");
        setButtonLoading(saveBtn, true, "Saving...");

        try {
            const response = await fetch("/applicant/save-emi-details", {
                method: "POST",
                headers: { Accept: "application/json" },
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                state.emiFormSaved = true;
                document.getElementById("emiPaymentForm").style.opacity = "0.7";
                document
                    .querySelectorAll(
                        "#emiPaymentForm input, #emiPaymentForm select",
                    )
                    .forEach((el) => (el.disabled = true));
                saveBtn.textContent = "Saved";

                loadNextDocument(CONFIG.documentTypes.basic);
            } else {
                throw new Error(data.message || "Error saving EMI details");
            }
        } catch (error) {
            console.error("Error:", error);
            alert(error.message);
            setButtonLoading(saveBtn, false, "Save EMI Details");
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
        // Expose for debugging if needed
        getState: () => ({ ...state }),
    };
})();

// Register with StepManager
if (typeof StepManager !== "undefined") {
    StepManager.registerHandler(5, Step5Handler);
}
