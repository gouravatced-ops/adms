{{-- {{ dd($regisStuList) }} --}}
@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-4"><span class="invert-text-white">Registration Certificate / Forms rejected by Registrar </span>
        </h6>

        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">Forms rejected by Registrar</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mx-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible mx-3" role="alert">
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
                        <label for="pass_state" class="form-label">Passing State<small class="text-danger">*</small></label>
                        <select class="form-select" id="pass_state" name="pass_state">
                            <option value="">Select </option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Other">Other</option>

                        </select>
                    </div>

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
                                <th>Rejected On</th>
                                <th>Reject Reason</th>
                                <th>User</th>
                                <th>Ack. Slip</th>
                                <th>App. Form</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($regisStuList as $key => $stuList)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
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
                                    <td>{{ $stuList->auth_action_date }}</td>
                                    <td>{{ $stuList->auth_reject_reason }}</td>
                                    <td>{{ $stuList->user }}</td>
                                    <td><a href="{{ route('applicant_af.pdf', $stuList->acknowledgment_no) }}"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="#f13c0e" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                <path d="M17 18h2" />
                                                <path d="M20 15h-3v6" />
                                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                            </svg></a></td>
                                    <td><a href="{{ route('applicant_ack_slip.pdf', $stuList->acknowledgment_no) }}"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="#f13c0e" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                <path d="M17 18h2" />
                                                <path d="M20 15h-3v6" />
                                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                            </svg></a></td>
                                    <td>Rejected</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
