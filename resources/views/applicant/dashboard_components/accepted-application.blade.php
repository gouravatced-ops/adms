@extends('applicant.dashboard_layouts.main')

@section('title', 'Dashboard')

@section('page-title', 'Accepted Application')

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
                                    <td class="sort-status">
                                        <span class="badge bg-green-lt">Accepted</span>
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
