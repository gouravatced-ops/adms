// ============================================
// OPTIMIZED STEP 5 HANDLER - Name Transfer Only (No EMI)
// ============================================
const Step3Handler = (function () {
    // Configuration constants
    const CONFIG = {
        submitUrl: "/nametransfer/documents/store",
        reuploadUrl: "/nametransfer/documents/reupload",
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
        ui: {
            selectors: {
                documentRows: "#nameTransferDocumentRows", // Only name transfer documents
                progressCount: "#progressCount",
                progressBar: "#progressBar",
                finalSubmitBtn: "#finalSubmitBtn",
                applicantId: "#applicant_id",
                csrfToken: 'meta[name="csrf-token"]',
            },
        },
    };

    // Debug logging
    console.log("=== Step3Handler Initialization Debug ===");
    console.log("window.documentTransferList:", window.documentTransferList);
    console.log("window.completedDocumentsList:", window.completedDocumentsList);
    console.log("Type of documentTransferList:", typeof window.documentTransferList);
    console.log("Is Array?", Array.isArray(window.documentTransferList));

    // Document configurations - RECEIVE from global variable
    const DOCUMENT_CONFIGS = {
        nameTransfer: window.documentTransferList || []
    };

    // Completed documents from server
    const COMPLETED_DOCUMENTS = window.completedDocumentsList || [];

    console.log("DOCUMENT_CONFIGS after assignment:", DOCUMENT_CONFIGS);
    console.log("nameTransfer documents count:", DOCUMENT_CONFIGS.nameTransfer.length);
    if (DOCUMENT_CONFIGS.nameTransfer.length > 0) {
        console.log("First document:", DOCUMENT_CONFIGS.nameTransfer[0]);
    }

    // State management (encapsulated)
    const state = {
        manager: null,
        completedNameTransferDocs: [],
        applicantId: null,
        documentConfigs: DOCUMENT_CONFIGS,
        isLoading: false
    };

    // Cache DOM elements
    let elements = {};

    // ==================== INITIALIZATION ====================

    function init() {
        console.log("Step 5 Handler Initialized - Name Transfer Only");

        cacheElements();
        state.applicantId = elements.applicantId?.value || "";

        // Load completed documents
        loadCompletedDocuments();

        bindEvents();
        initializeUI();
    }

    function cacheElements() {
        elements = {
            documentRows: document.querySelector(CONFIG.ui.selectors.documentRows),
            progressCount: document.querySelector(CONFIG.ui.selectors.progressCount),
            progressBar: document.querySelector(CONFIG.ui.selectors.progressBar),
            finalSubmitBtn: document.querySelector(CONFIG.ui.selectors.finalSubmitBtn),
            applicantId: document.querySelector(CONFIG.ui.selectors.applicantId),
            csrfToken: document.querySelector(CONFIG.ui.selectors.csrfToken)?.content || ""
        };
    }

    function bindEvents() {
        // Use event delegation for dynamic elements
        document.addEventListener("click", handleDocumentClick);
    }

    function loadCompletedDocuments() {
        // Load completed documents from server data
        if (COMPLETED_DOCUMENTS && COMPLETED_DOCUMENTS.length > 0) {
            state.completedNameTransferDocs = COMPLETED_DOCUMENTS.map(doc => ({
                id: doc.document_id,
                doc_no: doc.doc_no || "",
                day: doc.day || "",
                month: doc.month || "",
                year: doc.year || "",
                additional_info: doc.additional_info || "",
                remarks: doc.remarks || "",
                has_file: doc.has_file || false,
                file_name: doc.file_name || null
            }));
        }
    }

    function initializeUI() {
        if (elements.documentRows) {
            elements.documentRows.innerHTML = "";
            loadNextDocument();
        }
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
            previewBtn.textContent = file ? "Preview Document" : "Preview Remarks";
        }
    }

    function createDocumentRow(doc, sl, isCompleted = false, data = null) {
        const dateOptions = generateDateOptions(data || {});
        const rowId = `row_${doc.id}`;
        const completedClass = isCompleted ? "completed-row" : "current-row";

        return `
            <tr class="document-row ${completedClass}" id="${rowId}" 
                data-document-id="${doc.id}" data-document-key="${doc.key}">
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
        return state.documentConfigs.nameTransfer.find((d) => d.id === docId);
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
        const submitBtn = row.querySelector(".preview-btn");
        const originalText = submitBtn.textContent;

        state.isLoading = true;
        setButtonLoading(submitBtn, true, "Submitting...");

        try {
            const formData = new FormData();
            formData.append("_token", elements.csrfToken);
            formData.append("allottee_id", state.applicantId);
            formData.append("document_id", docId);
            formData.append("document_type", "nameTransfer");
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
            if (!state.completedNameTransferDocs.some((d) => d.id === docId)) {
                state.completedNameTransferDocs.push(documentData);
            }

            // Mark row as completed
            markRowAsCompleted(row, documentData);

            // Load next document
            loadNextDocument();

            // Check if all documents completed
            checkAllDocumentsCompleted();

            updateProgress();

            if (state.completedNameTransferDocs.length === state.documentConfigs.nameTransfer.length) {
                showCompletionMessage();
            }
        } catch (error) {
            console.error("Upload Error:", error);
            alert(error.message || "Error uploading document");
        } finally {
            state.isLoading = false;
        }
    }

    function markRowAsCompleted(row, documentData) {
        row.classList.add("completed-row");
        row.classList.remove("current-row");

        // Disable all inputs
        row.querySelectorAll("input, select, textarea, button").forEach(el => {
            el.disabled = true;
        });

        // Replace preview button with checkmark
        const previewCell = row.querySelector("td:last-child");
        if (previewCell) {
            previewCell.innerHTML = '<span class="status-completed" style="display: inline-block; font-size: 15px; color: #ffffff;">✓</span>';
        }

        // Add completed status to document name cell
        const nameCell = row.querySelector(".doc-name-cell");
        if (nameCell) {
            let statusSpan = nameCell.querySelector(".status-completed");
            if (!statusSpan) {
                statusSpan = document.createElement("span");
                statusSpan.className = "status-completed";
                statusSpan.style.cssText = "display: inline-block; margin-left: 5px; color: #4caf50; font-weight: bold;";
                statusSpan.textContent = "✓";
                nameCell.appendChild(statusSpan);
            }
            statusSpan.style.display = "inline-block";
        }
    }

    // ==================== DOCUMENT LOADING ====================

    function loadNextDocument() {
        if (!elements.documentRows) return;

        const documents = state.documentConfigs.nameTransfer;
        const completedDocs = state.completedNameTransferDocs;
        const nextIndex = completedDocs.length;

        elements.documentRows.innerHTML = "";

        // Render completed rows
        completedDocs.forEach((completedDoc, index) => {
            const originalDoc = documents.find((d) => d.id === completedDoc.id);
            if (originalDoc) {
                elements.documentRows.insertAdjacentHTML(
                    "beforeend",
                    createDocumentRow(originalDoc, index + 1, true, completedDoc),
                );
            }
        });

        // Render next incomplete document if any
        if (nextIndex < documents.length) {
            renderNextDocumentRow(documents[nextIndex], nextIndex + 1);
        }
    }

    function renderNextDocumentRow(document, index) {
        elements.documentRows.insertAdjacentHTML(
            "beforeend",
            createDocumentRow(document, index, false),
        );

        const newRow = elements.documentRows.querySelector(
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

    function showCompletionMessage() {
        const tableContainer = elements.documentRows.closest(".table-container");
        if (tableContainer && !document.getElementById("completionMessage")) {
            const messageHtml = `
                <div id="completionMessage" style="margin-top: 20px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; text-align: center;">
                    <strong>✓ All name transfer documents have been successfully uploaded!</strong>
                </div>
            `;
            tableContainer.insertAdjacentHTML("afterend", messageHtml);
        }
    }

    // ==================== PROGRESS TRACKING ====================

    function updateProgress() {
        const totalDocs = state.documentConfigs.nameTransfer.length;
        const completedCount = state.completedNameTransferDocs.length;

        if (elements.progressCount) {
            elements.progressCount.textContent = `${completedCount}/${totalDocs}`;
        }

        if (elements.progressBar) {
            const percentage = totalDocs > 0 ? (completedCount / totalDocs) * 100 : 0;
            elements.progressBar.style.width = `${percentage}%`;
        }
    }

    function checkAllDocumentsCompleted() {
        const allCompleted = state.completedNameTransferDocs.length === state.documentConfigs.nameTransfer.length;

        if (allCompleted && elements.finalSubmitBtn) {
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
        console.log("Step 3 Handler Destroyed");
        document.removeEventListener("click", handleDocumentClick);
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
    StepManager.registerHandler(3, Step3Handler);
}