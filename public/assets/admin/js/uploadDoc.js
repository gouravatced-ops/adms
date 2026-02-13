$(document).ready(function() {
    $('form').on('submit', function(e) {
        // Show loader
        $("#jspc-loader").removeClass('d-none');
        $("#loading-text").text("Please Wait...");
    });

    // Function to handle file preview
    function previewFile(file, previewElement) {
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let content = '';
                if (file.type.startsWith('image/')) {
                    content = '<img src="' + e.target.result + '" class="img-fluid" alt="Preview">';
                } else if (file.type === 'application/pdf') {
                    content = '<embed src="' + e.target.result +
                        '" width="100%" height="500px"></iframe>';
                } else {
                    content = '<p>No preview available for this file type.</p>';
                }
                previewElement.html(content);
            }
            reader.readAsDataURL(file);
        }
    }

    // Handle preview button click
    $('.preview-btn').click(function() {
        let fileInput = $(this).siblings('input[type="file"]')[0];
        let documentUrl = $(this).data('document-url');
        let label = $(this).data('label');

        if (documentUrl) {
            // Existing document preview
            $('#previewModalLabel').text(label + ' Preview');
            let content = '';
            if (documentUrl.toLowerCase().endsWith('.pdf')) {
                content = '<iframe src="' + documentUrl + '" width="100%" height="500px"></iframe>';
            } else {
                content = '<img src="' + documentUrl + '" class="img-fluid" alt="Preview">';
            }
            $('#preview-content').html(content);
            $('#previewModal').modal('show');
        } else if (fileInput.files[0]) {
            // New file preview
            $('#previewModalLabel').text(label + ' Preview');
            previewFile(fileInput.files[0], $('#preview-content'));
            $('#previewModal').modal('show');
        } else {
            alert('Please select a file first.');
        }
    });

    // Validate file size on input change
    $('input[type="file"]').change(function() {
        let file = this.files[0];
        let maxSize = $(this).data('max-size') * 1024; // Convert to bytes
        if (file && file.size > maxSize) {
            alert('File size exceeds the maximum limit of ' + $(this).data('max-size') + ' KB');
            this.value = ''; // Clear the input
        }
    });

    // Existing AJAX functionality for document upload (unchanged)
    function uploadFile(inputElement) {
        var file = inputElement.files[0];
        var fileInputId = inputElement.id;
        var formData = new FormData();
        formData.append('file', file);
        formData.append('app_id', $("#app_id").val());
        formData.append('field_name', inputElement.name);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $("#jspc-loader").removeClass('d-none');
        $("#loading-text").text("Uploading student file... Please wait.");

        $.ajax({
            url: "/admin/admin-upload-single-document",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var fileUrl = response.file_path;

                    $(`#${fileInputId}`).closest('.input-group').find('.preview-btn').attr(
                        'data-document-url', fileUrl).removeClass('btn-secondary').addClass(
                        'btn-success');

                    $(`#${fileInputId}`).removeClass('is-invalid');

                } else {
                    $(`#${fileInputId}`).addClass('is-invalid');
                    // alert('Failed to upload document');
                }
                $("#jspc-loader").addClass('d-none');
                $("#loading-text").text("Please wait...")
            },
            error: function() {
                // alert('Error uploading ' + inputElement.name);
                $("#jspc-loader").removeClass('d-none').addClass('d-none');
                $("#loading-text").text("Please wait...")
            }
        });
    }

    // Attach change event to all file inputs for upload
    $('input[type="file"]').on('change', function() {
        uploadFile(this);
    });
});
