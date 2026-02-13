@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-4"><span class="invert-text-white">Registration Certificate / View Pending Registered Aplicant List </span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">View Pending Registered Applicant List</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mx-3 mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible mx-3 mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="course_type" class="form-label">Type of Course <small
                                class="text-danger">*</small></label>
                        <select class="form-select" id="course_type" name="course_type" required>
                            <option value="">Select Course Type</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Bachelor">Bachelor</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="course_name" class="form-label">Name of Course <small
                                class="text-danger">*</small></label>
                        <select class="form-select" id="course_name" name="course_id">
                            <option value="">Select Course Name</option>

                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="pass_state" class="form-label">Passing State<small
                                class="text-danger">*</small></label>
                        <select class="form-select" id="pass_state" name="pass_state">
                            <option value="">Select </option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Other">Other</option>

                        </select>
                    </div>

                    {{-- @if (session()->get('user_role') === 'council_office')
                        <div class="col-md-3 mb-3">
                            <label for="inst_name" class="form-label">Name of Institute <small
                                    class="text-danger">*</small></label>
                            <select class="form-select" id="inst_name" name="inst_name">
                                <option value="">Select Institute Name</option>
                                @foreach ($instList as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif --}}
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <input type="button" id="searchButton" value="Search" class="btn btn-info mt-4">

                            <button id="resetButton" class="btn btn-danger mt-4">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="studentListTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ack. No</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Course</th>
                                <th>Pass. State</th>
                                <th>Institute</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($regisStuList as $key => $stuList)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset($stuList->document_path) }}" alt="Photo"
                                            class="img-fluid mx-auto d-block" width="50px"><br>
                                        {{ $stuList->acknowledgment_no }}
                                    </td>
                                    <td>{{ $stuList->name }}</td>
                                    <td>{{ $stuList->course_type }}</td>
                                    <td>{{ $stuList->course_name == 'Other' ? $stuList->course_name . '(' . $stuList->other_course . ')' : $stuList->course_name }}
                                    </td>
                                    <td>
                                        {{ $stuList->passing_state == 'Other' ? $stuList->passing_state . ' (' . $stuList->state_name . ')' : $stuList->passing_state }}
                                    </td>
                                    @if ($stuList->college_name == '999')
                                        <td>{{ $stuList->jh_other_college_name }}
                                        </td>
                                    @else
                                        <td>{{ !empty($stuList->institute_name) ? $stuList->institute_name : $stuList->college_name }}
                                        </td>
                                    @endif
                                    <td>
                                        <a title="View" class=" text-info"
                                            href="{{ route('applicant-details', ['id' => $stuList->acknowledgment_no]) }}"><i
                                                class="menu-icon tf-icons bx bx-show-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="fullStuDetailsModal" tabindex="-1" aria-labelledby="fullStuDetailsModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="fullStuDetailsModalLabel">Full Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
