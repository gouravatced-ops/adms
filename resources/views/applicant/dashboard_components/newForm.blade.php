@extends('applicant.dashboard_layouts.main')

@section('title', 'Dashboard')

@section('content')
<style>

</style>
<!-- Form Card -->
<div class="card">
    <!-- Form Header -->
    <div class="modern-card-header">
        <div class="header-flex">
            <div>
                <h1 class="header-title">File Tracking System</h1>
                <p class="header-subtitle">Complete the form below to register a new file</p>
            </div>
            <div class="header-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Form Body -->
    <form id="fileTrackingForm" class="form-body">

        <div class="form-grid">

            <div class="field">
                <label class="label required">Divisions</label>
                <select id="divisions" name="divisions"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 outline-none transition-all duration-200 bg-white">
                    <option value="" disabled selected>Select division</option>
                    @foreach($data['divisions'] as $division)
                        <option value="{{ $division->id }}">
                            {{ $division->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="label">File Holder Name</label>
                <input type="text" placeholder="Enter file holder name (Optional)">
            </div>

            <div class="field">
                <label class="label required">Correct Pages</label>
                <input type="number" min="0" required>
            </div>

            <div class="field">
                <label class="label required">Damaged Pages</label>
                <input type="number" min="0" required>
            </div>

            <div class="field">
                <label class="label">Total Pages</label>
                <input type="number" readonly class="readonly">
            </div>

            <div class="field">
                <label class="label required">Received Date</label>
                <input type="date" required>
            </div>
        </div>

        <div class="form-footer">
            <button class="submit-btn" disabled>
                Submit File Record
                <svg viewBox="0 0 24 24">
                    <path d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>

            <p class="footer-text">
                All required fields must be filled to enable submission
            </p>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<!-- JavaScript -->
<script>
    // Set today's date as default
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('receivedDate').value = today;

            // Initial validation check
            validateForm();
        });

        // Calculate Total Pages
        function calculateTotalPages() {
            const correctPages = parseInt(document.getElementById('correctPages').value) || 0;
            const damagePages = parseInt(document.getElementById('damagePages').value) || 0;
            const totalPages = correctPages + damagePages;

            document.getElementById('totalPages').value = totalPages;

            // Validate form after calculation
            validateForm();
        }

        // Validate Form and Enable/Disable Submit Button
        function validateForm() {
            const form = document.getElementById('fileTrackingForm');
            const submitButton = document.getElementById('submitButton');

            // Get all required fields
            const fileNo = document.getElementById('fileNo').value.trim();
            const correctPages = document.getElementById('correctPages').value;
            const damagePages = document.getElementById('damagePages').value;
            const receivedDate = document.getElementById('receivedDate').value;
            const status = document.querySelector('input[name="status"]:checked');

            // Check if all required fields are filled
            const allFieldsFilled = fileNo &&
                correctPages &&
                damagePages &&
                receivedDate &&
                status;

            // Enable or disable submit button
            submitButton.disabled = !allFieldsFilled;
        }

        // Add event listeners to all required fields
        document.getElementById('fileNo').addEventListener('input', validateForm);
        document.getElementById('correctPages').addEventListener('input', validateForm);
        document.getElementById('damagePages').addEventListener('input', validateForm);
        document.getElementById('receivedDate').addEventListener('change', validateForm);
        document.querySelectorAll('input[name="status"]').forEach(radio => {
            radio.addEventListener('change', validateForm);
        });

        // Handle Form Submission
        function handleSubmit(event) {
            event.preventDefault();

            // Get form data
            const formData = new FormData(event.target);
            const data = {};

            // Convert FormData to object
            for (let [key, value] of formData.entries()) {
                if (key === 'specialHandling[]') {
                    if (!data.specialHandling) {
                        data.specialHandling = [];
                    }
                    data.specialHandling.push(value);
                } else {
                    data[key] = value;
                }
            }

            // Log form data (you can replace this with actual API call)
            console.log('Form Data:', data);

            setTimeout(() => showToast('Success', 'Form submitted successfully!', 'success'), 1000);
        }
</script>
@endpush