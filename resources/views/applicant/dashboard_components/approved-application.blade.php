@extends('applicant.dashboard_layouts.main')

@section('title', 'Dashboard')

@section('page-title', 'Approved Application')

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="table-default" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>sl. no.</th>
                            <th><button class="table-sort" data-sort="sort-name">Name</button></th>
                            <th><button class="table-sort" data-sort="sort-course-type">Course Type</button></th>
                            <th><button class="table-sort" data-sort="sort-course-name">Course Name</button></th>
                            <th><button class="table-sort" data-sort="sort-passing-state">Course Passing State</button></th>
                            {{-- <th><button class="table-sort">Application PDF</button></th>
                            <th><button class="table-sort">Acknowledgement Slip</button></th> --}}
                            <th><button class="table-sort">Certificate</button></th>
                            <th><button class="table-sort" data-sort="sort-status">Status</button></th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody">
                        @if ($studentApplications->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No records found</td>
                            </tr>
                        @else
                            @foreach ($studentApplications as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="sort-name">{{ $data->name }}</td>
                                    <td class="sort-course-type">{{ $data->course_type }}</td>
                                    <td class="sort-course-name">{{ $data->course_name }}</td>
                                    <td class="sort-passing-state">
                                        {{ $data->passing_state == 'Other' ? $data->state : $data->passing_state }}
                                    </td>
                                    <td>
                                        @if ($data->signed_certificate_path != null)
                                            <a href="{{ route('certificate.pdf', $data->allotted_certificate_no) }}"><svg
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
                                                </svg></a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="sort-status">
                                        @if ($data->auth_status == 'approved')
                                            <span class="badge bg-green-lt">Approved</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
