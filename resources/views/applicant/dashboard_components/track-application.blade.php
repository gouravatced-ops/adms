@extends('applicant.dashboard_layouts.main')

@section('title', 'Dashboard')

@section('page-title', 'Track Application')

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="table-default" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><button class="table-sort" data-sort="sort-sl-no">SL.NO.</button></th>
                            <th><button class="table-sort" data-sort="sort-name">Name</button></th>
                            <th><button class="table-sort" data-sort="sort-ack-no">Ack. No.</button></th>
                            <th><button class="table-sort" data-sort="sort-course-type">Type</button></th>
                            <th><button class="table-sort" data-sort="sort-course-name">Course Name</button></th>
                            <th><button class="table-sort" data-sort="sort-passing-state">Passing State</button></th>
                            <th><button class="table-sort" data-sort="sort-institute">Institute</button></th>
                            <th><button class="table-sort">Application PDF</button></th>
                            <th><button class="table-sort">Ack. Slip</button></th>
                            <th><button class="table-sort" data-sort="sort-last-updated">Last Updated Datetime</button></th>
                            <th><button class="table-sort" data-sort="sort-quantity">Status</button></th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody">
                        @foreach ($studentApplications as $data)
                            <tr>
                                <td class="sort-sl-no">{{ $loop->iteration }}</td>
                                <td class="sort-name">{{ $data->name }}</td>
                                <td class="sort-ack-no">{{ $data->acknowledgment_no }}</td>
                                <td class="sort-course-type">{{ $data->course_type }}</td>
                                <td class="sort-course-name">
                                    {{ $data->course_name == 'Other' ? $data->course_name . ' ( ' . $data->other_course . ' )' : $data->course_name }}
                                </td>
                                <td class="sort-passing-state">
                                    {{ $data->passing_state == 'Other' ? $data->state : $data->passing_state }}</td>

                                @if ($data->college_name === '999')
                                    <td class="sort-institute"> OTHERS - {{ strtoupper($data->jh_other_college_name) }}</td>
                                @else
                                    <td class="sort-institute">
                                        {{ !empty($data->inst_name) ? strtoupper($data->inst_name) : strtoupper($data->college_name) }}
                                    </td>
                                @endif

                                <td><a href="{{ route('application.pdf', $data->acknowledgment_no) }}"><svg
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
                                <td><a href="{{ route('ack_slip.pdf', $data->acknowledgment_no) }}"><svg
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
                                <td class="sort-last-updated"> {{ $data->auth_action_date }}</td>
                                <td class="sort-progress" data-progress="30">
                                    @if ($data->auth_status == 'pending')
                                        <span class="badge bg-blue-lt">Verification Pending</span>
                                    @elseif($data->auth_status == 'incomplete')
                                        <span class="badge bg-orange-lt">Incomplete Form</span>
                                    @elseif($data->auth_status == 'accept')
                                        <span class="badge bg-success-lt">Accepted Form</span>
                                    @elseif($data->auth_status == 'reject')
                                        <span class="badge bg-red-lt">Reject</span>
                                    @elseif($data->auth_status == 'approved')
                                        <span class="badge bg-green-lt">Approved</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
