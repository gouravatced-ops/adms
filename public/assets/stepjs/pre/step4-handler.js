// ============================================
// STEP 4 HANDLER - Document Upload with Skip Functionality
// ============================================
const Step4Handler = {
    manager: null,
    skipModal: null,

    init: function () {
        console.log("Step 4 Handler Initialized");
        this.createSkipModal();
        this.bindEvents();
        this.showSkipButton(true); // Show skip button when step 4 is active
    },

    bindEvents: function () {
        // Handle skip button click
        const skipBtn = document.getElementById("step4-skip-btn");
        if (skipBtn) {
            skipBtn.addEventListener("click", (e) => this.openSkipModal(e));
        }

        // Handle modal form submission
        const submitSkipBtn = document.getElementById("submit-skip");
        if (submitSkipBtn) {
            submitSkipBtn.addEventListener("click", (e) =>
                this.submitSkipForm(e),
            );
        }

        // Close modal on backdrop click and close button
        const modal = document.getElementById("skipRemarkModal");
        if (modal) {
            modal
                .querySelectorAll(".btn-close, .close-modal")
                .forEach((btn) => {
                    btn.addEventListener("click", () => this.closeSkipModal());
                });

            // Close on backdrop click
            modal.addEventListener("click", (e) => {
                if (e.target === modal) this.closeSkipModal();
            });
        }

        // Escape key to close modal
        document.addEventListener("keydown", (e) => {
            if (
                e.key === "Escape" &&
                document.getElementById("skipRemarkModal")?.style.display ===
                    "block"
            ) {
                this.closeSkipModal();
            }
        });

        // Input restrictions
        this.applyInputRestrictions();
    },

    showSkipButton: function (show) {
        const skipBtn = document.getElementById("step4-skip-btn");
        if (skipBtn) {
            skipBtn.style.display = show ? "flex" : "none";
        } else if (show) {
            // If button doesn't exist, create it
            this.createSkipButton();
        }
    },

    createSkipButton: function () {
        // Find the navigation container
        const navContainer = document.querySelector(
            ".nav-bar > div:last-child",
        );
        if (!navContainer) return;

        // Check if skip button already exists
        if (document.getElementById("step4-skip-btn")) return;

        // Create skip button
        const skipBtn = document.createElement("button");
        skipBtn.id = "step4-skip-btn";
        skipBtn.type = "button";
        skipBtn.className = "btn btn-warning";
        skipBtn.style.cssText = `
            background: linear-gradient(90deg, #f59e0b, #f97316);
            color: white;
        `;
        skipBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                <path fill="#ffffff" d="M28.448,17.261L15.552,27.739C14.698,28.432,14,28.1,14,27v-6.938l-9.448,7.676
                C3.698,28.432,3,28.1,3,27V5c0-1.1,0.698-1.432,1.552-0.739L14,11.937V5c0-1.1,0.698-1.432,1.552-0.739l12.896,10.478
                C29.302,15.432,29.302,16.568,28.448,17.261z"/>
            </svg>
            Skip
        `;

        // Add hover effect
        skipBtn.addEventListener("mouseenter", () => {
            skipBtn.style.transform = "translateY(-2px)";
            skipBtn.style.boxShadow = "0 4px 12px rgba(245, 158, 11, 0.3)";
        });
        skipBtn.addEventListener("mouseleave", () => {
            skipBtn.style.transform = "translateY(0)";
            skipBtn.style.boxShadow = "none";
        });

        // Insert before the next button
        const nextBtn = document.getElementById("nextBtn");
        if (nextBtn) {
            navContainer.insertBefore(skipBtn, nextBtn);
        } else {
            navContainer.appendChild(skipBtn);
        }

        // Add click event
        skipBtn.addEventListener("click", (e) => this.openSkipModal(e));
    },

    createSkipModal: function () {
        // Check if modal already exists
        if (document.getElementById("skipRemarkModal")) return;

        // Get CSRF token from meta tag or form
        const csrfToken =
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") ||
            document.querySelector('input[name="_token"]')?.value ||
            "";

        const modalHTML = `
            <div id="skipRemarkModal" class="modal" style="display: none; position: fixed; top: 0; left: 1300px; width: 100%; height: 100%; background: none; box-shadow:none !important; z-index: 9999;">
                <div class="modal-dialog" style="position: relative; width: 500px; margin: 50px auto; max-width: 90%;">
                    <div class="modal-content" style="background: white; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                        <div class="modal-header" style="padding: 15px 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(90deg, #f59e0b, #f97316); color: white; border-radius: 8px 8px 0 0;">
                            <h5 class="modal-title" style="margin: 0; font-size: 18px; font-weight: 600;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline; margin-right: 8px;">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="16" x2="12" y2="12"/>
                                    <circle cx="12" cy="8" r="1" fill="currentColor"/>
                                </svg>
                                Skip Step 4
                            </h5>
                            <button type="button" class="close-modal btn-close" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
                        </div>
                        <div class="modal-body" style="padding: 20px;">
                            <div class="info-box" style="background: #fef9e7; border-left: 4px solid #f97316; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                                <p style="margin: 0 0 10px 0; color: #92400e; font-weight: 500;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline; margin-right: 6px;">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="12" x2="12" y2="16"/>
                                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                                    </svg>
                                    Why are you skipping this step?
                                </p>
                                <p style="margin: 0; color: #4b5563; font-size: 14px;">
                                    Please provide a reason for skipping the document upload. This will help us understand your situation better.
                                </p>
                            </div>
                            
                            <form id="skipRemarkForm">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="step" value="4">
                                <input type="hidden" name="applicant_id" id="skip_applicant_id" value="">
                                <input type="hidden" name="step_name" value="Nominee & Banking">
                                
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="skip_remark" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                                        Remarks <span style="color: #dc2626;">*</span>
                                    </label>
                                    <textarea 
                                        id="skip_remark" 
                                        name="remark" 
                                        rows="4" 
                                        class="form-control" 
                                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px; resize: vertical;"
                                        placeholder="e.g., Documents not ready, will upload later, etc."
                                        required
                                    ></textarea>
                                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                                        Maximum 500 characters
                                    </small>
                                </div>

                                

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="skip_reason_category" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                                        Reason Category
                                    </label>
                                    <select 
                                        id="skip_reason_category" 
                                        name="reason_category" 
                                        class="form-control" 
                                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;"
                                    >
                                        <option value="">-- Select a category (optional) --</option>
                                        <option value="documents_not_ready">Documents Not Ready</option>
                                        <option value="will_upload_later">Will Upload Later</option>
                                        <option value="technical_issue">Technical Issue</option>
                                        <option value="need_assistance">Need Assistance</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer" style="padding: 15px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 10px; background: #f9fafb; border-radius: 0 0 8px 8px;">
                            <button type="button" class="btn btn-secondary close-modal" style="padding: 8px 16px; border: 1px solid #d1d5db; background: white; border-radius: 4px; cursor: pointer; font-weight: 500;">
                                Cancel
                            </button>
                            <button type="button" id="submit-skip" class="btn btn-warning" style="padding: 8px 16px; border: none; background: linear-gradient(90deg, #f59e0b, #f97316); color: white; border-radius: 4px; cursor: pointer; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                    <path fill="#ffffff" d="M28.448,17.261L15.552,27.739C14.698,28.432,14,28.1,14,27v-6.938l-9.448,7.676
                                    C3.698,28.432,3,28.1,3,27V5c0-1.1,0.698-1.432,1.552-0.739L14,11.937V5c0-1.1,0.698-1.432,1.552-0.739l12.896,10.478
                                    C29.302,15.432,29.302,16.568,28.448,17.261z"/>
                                </svg>
                                Submit & Skip
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append modal to body
        document.body.insertAdjacentHTML("beforeend", modalHTML);
        this.skipModal = document.getElementById("skipRemarkModal");
    },

    openSkipModal: function (e) {
        e.preventDefault();

        // Get applicant ID from the form
        const applicantId =
            document.querySelector('input[name="applicant_id"]')?.value ||
            document.querySelector('input[name="allottee_id"]')?.value ||
            "";

        // Set applicant ID in modal
        const applicantIdField = document.getElementById("skip_applicant_id");
        if (applicantIdField) {
            applicantIdField.value = applicantId;
        }

        if (this.skipModal) {
            this.skipModal.style.display = "block";
            document.body.style.overflow = "hidden"; // Prevent background scrolling
        }
    },

    closeSkipModal: function () {
        if (this.skipModal) {
            this.skipModal.style.display = "none";
            document.body.style.overflow = ""; // Restore scrolling

            // Clear form
            const form = document.getElementById("skipRemarkForm");
            if (form) {
                form.reset();
            }
        }
    },

    submitSkipForm: function (e) {
        e.preventDefault();

        const form = document.getElementById("skipRemarkForm");
        const remark = document.getElementById("skip_remark");
        const applicantId = document.getElementById("allottee_id");

        // Validate remark
        if (!remark.value.trim()) {
            this.showNotification("Please enter a remark", "error");
            remark.focus();
            return;
        }

        // Validate applicant ID
        if (!applicantId.value) {
            this.showNotification("Applicant ID is missing", "error");
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById("submit-skip");
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner"></span> Submitting...';
        submitBtn.disabled = true;

        // Get form data
        const formData = new FormData(form);

        // Submit to server
        fetch("/applicant/skip-step", {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                    ?.value,
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    this.closeSkipModal();
                    // Hide skip button
                    this.showSkipButton(false);
                    console.log(data.next_step);
                    StepManager.loadStep(data.next_step);
                } else {
                    this.showNotification(
                        data.message || "Error skipping step",
                        "error",
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                this.showNotification("Server error occurred", "error");
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    },

    showNotification: function (message, type = "info") {
        // Check if notification container exists
        let container = document.querySelector(".notification-container");
        if (!container) {
            container = document.createElement("div");
            container.className = "notification-container";
            container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
            `;
            document.body.appendChild(container);
        }

        // Create notification
        const notification = document.createElement("div");
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            background: ${type === "success" ? "#10b981" : type === "error" ? "#ef4444" : "#3b82f6"};
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        `;

        notification.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                ${type === "success" ? '<path d="M20 6L9 17l-5-5"/>' : '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'}
            </svg>
            <span>${message}</span>
        `;

        container.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = "slideOut 0.3s ease";
            setTimeout(() => notification.remove(), 300);
        }, 3000);

        // Add keyframes for animations if not exists
        if (!document.getElementById("notification-keyframes")) {
            const style = document.createElement("style");
            style.id = "notification-keyframes";
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
                .spinner {
                    display: inline-block;
                    width: 16px;
                    height: 16px;
                    border: 2px solid rgba(255,255,255,0.3);
                    border-radius: 50%;
                    border-top-color: white;
                    animation: spin 1s ease-in-out infinite;
                    margin-right: 8px;
                }
                @keyframes spin {
                    to { transform: rotate(360deg); }
                }
            `;
            document.head.appendChild(style);
        }
    },

    destroy: function () {
        console.log("Step 4 Handler Destroyed");
        // Hide skip button
        this.showSkipButton(false);
        // Clean up modal if exists
        if (this.skipModal) {
            this.skipModal.remove();
        }
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

        // IFSC Code Validation
        document.querySelectorAll(".ifsc-input").forEach((input) => {
            input.addEventListener("input", function () {
                // Convert to uppercase
                this.value = this.value.toUpperCase();
                // Remove invalid characters
                this.value = this.value.replace(/[^A-Z0-9]/g, "");
                // Limit length to 11
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            });
        });
    },
};

// Register with StepManager
if (typeof StepManager !== "undefined") {
    StepManager.registerHandler(4, Step4Handler);
}
