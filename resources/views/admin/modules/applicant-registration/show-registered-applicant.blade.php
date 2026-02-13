@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-4"><span class="invert-text-white">Registered Applicant / View Registered Applicant Applications
            </span>
        </h6>
        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">View Registered Applicant Applications</h5>

            <div id="alert">

            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible mx-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table id="studentListTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Category</th>
                                <th>Aadhaar</th>
                                <th>Date of Birth</th>
                                <th>Mobile No</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applicant as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="name">{{ $data->name }}</td>
                                    <td class="gender">{{ $data->gender }}</td>
                                    <td class="category">{{ $data->category }}</td>
                                    <td class="aadhaar_no">{{ $data->aadhaar_no }}</td>
                                    <td class="date_of_birth">{{ $data->date_of_birth }}</td>
                                    <td class="mobile_no">{{ $data->mobile_no }}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm edit-row">Edit</a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-success btn-sm save-row d-none">Save</a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-danger btn-sm cancel-row d-none">Cancel</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Edit button click event
        $('.edit-row').on('click', function() {
            var $row = $(this).closest('tr');

            // Make the columns editable with input/select elements
            $row.find('.name').html('<input type="text" name="name" class="form-control" value="' + $row.find(
                '.name').text().trim() + '">');

            $row.find('.gender').html(`
                <select name="gender" class="form-select">
                    <option value="Male" ${$row.find('.gender').text().trim() === 'Male' ? 'selected' : ''}>Male</option>
                    <option value="Female" ${$row.find('.gender').text().trim() === 'Female' ? 'selected' : ''}>Female</option>
                    <option value="Other" ${$row.find('.gender').text().trim() === 'Other' ? 'selected' : ''}>Other</option>
                </select>
            `);

            $row.find('.category').html(`
                <select name="category" class="form-select">
                    <option value="General" ${$row.find('.category').text().trim() === 'General' ? 'selected' : ''}>General</option>
                    <option value="OBC" ${$row.find('.category').text().trim() === 'OBC' ? 'selected' : ''}>OBC</option>
                    <option value="SC" ${$row.find('.category').text().trim() === 'SC' ? 'selected' : ''}>SC</option>
                    <option value="ST" ${$row.find('.category').text().trim() === 'ST' ? 'selected' : ''}>ST</option>
                </select>
            `);

            $row.find('.date_of_birth').html(
                '<input type="date" name="date_of_birth" class="form-control" value="' + $row.find(
                    '.date_of_birth').text().trim() + '">');

            $row.find('.mobile_no').html(
                '<input type="tel" name="mobile_no" pattern="[0-9]{10}" maxlength="10" class="form-control" value="' +
                $row.find('.mobile_no').text().trim() + '">');

            $row.find('.aadhaar_no').html(
                '<input type="text" name="aadhaar_no" pattern="[0-9]{12}" maxlength="12" class="form-control" value="' +
                $row.find('.aadhaar_no').text().trim() + '">');

            // Hide Edit button and show Save/Cancel buttons
            $(this).addClass('d-none');
            $row.find('.save-row, .cancel-row').removeClass('d-none');
        });

        function showSuccessAlert(message, type='success') {
            $('#alert').html(`
                <div class="alert alert-${type} alert-dismissible mx-3 mt-3" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);

            setTimeout(function() {
                $('#alert .alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);
        }

        // Save button click event
        $('.save-row').on('click', function() {
            var $row = $(this).closest('tr');
            var id = $row.data('id');

            var updatedData = {
                name: $row.find('input[name="name"]').val(),
                gender: $row.find('select[name="gender"]').val(),
                category: $row.find('select[name="category"]').val(),
                date_of_birth: $row.find('input[name="date_of_birth"]').val(),
                mobile_no: $row.find('input[name="mobile_no"]').val(),
                aadhaar_no: $row.find('input[name="aadhaar_no"]').val(),
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            };

            $.ajax({
                url: '/admin/edit/registered-applicant/' + id,
                method: 'PUT',
                data: updatedData,
                success: function(response) {
                    // Update the row with new data
                    $row.find('.name').html(updatedData.name);
                    $row.find('.gender').html(updatedData.gender);
                    $row.find('.category').html(updatedData.category);
                    $row.find('.date_of_birth').html(updatedData.date_of_birth);
                    $row.find('.mobile_no').html(updatedData.mobile_no);
                    $row.find('.aadhaar_no').html(updatedData.aadhaar_no);

                    // Hide Save/Cancel buttons and show Edit button again
                    $row.find('.save-row, .cancel-row').addClass('d-none');
                    $row.find('.edit-row').removeClass('d-none');

                    showSuccessAlert('Applicant details updated successful!');
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;

                    $row.find('.form-control').removeClass('is-invalid');
                    $row.find('.invalid-feedback').remove();

                    $.each(errors, function(key, value) {
                        var input = $row.find('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.after('<span class="invalid-feedback d-block">' + value[0] +
                            '</span>');
                    });

                    showSuccessAlert('Applicant details updation failed!', 'danger');
                }
            });
        });

        // Cancel button click event
        $('.cancel-row').on('click', function() {
            var $row = $(this).closest('tr');

            // Revert to original text (assuming you can store the original values before editing)
            $row.find('.name').html($row.find('.name input').val());
            $row.find('.gender').html($row.find('.gender select').val());
            $row.find('.category').html($row.find('.category select').val());
            $row.find('.date_of_birth').html($row.find('.date_of_birth input').val());
            $row.find('.mobile_no').html($row.find('.mobile_no input').val());
            $row.find('.aadhaar_no').html($row.find('.aadhaar_no input').val());

            // Hide Save/Cancel buttons and show Edit button again
            $row.find('.save-row, .cancel-row').addClass('d-none');
            $row.find('.edit-row').removeClass('d-none');
        });
    </script>
@endpush
