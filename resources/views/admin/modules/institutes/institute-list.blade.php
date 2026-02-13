<!-- resources/views/admins/create.blade.php -->
@extends('admin.layouts.main')

@section('admin-content')
    <div class="container-xxl flex-grow-1 ">
        <h6 class="py-3 mb-4"><span class="invert-text-white">Affliated College / View Affliated College</span>
        </h6>
        <div class="card mb-4">
            <h5 class="card-header text-white bg-info">View Affliated College</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mx-3 mt-3" role="alert">
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
                <div class="table-responsive">
                    <table id="studentListTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 3%;">#</th>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 20%;">Address</th>
                                <th style="width: 10%;">City</th>
                                <th style="width: 10%;">District</th>
                                <th style="width: 8%;">Pincode</th>
                                <th style="width: 10%;">State</th>
                                <th style="width: 10%;">Mobile No.-1</th>
                                {{-- <th style="width: 10%;">Mobile No.-2</th>
                                <th style="width: 8%;">WhatsApp</th>
                                <th style="width: 15%;">E-mail</th> --}}
                                <th style="width: 7%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inst as $data)
                                <tr data-id="{{ $data->institute_id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="name">{{ $data->name }}</td>
                                    <td class="address">{{ $data->address }}</td>
                                    <td class="city">{{ $data->city }}</td>
                                    <td class="district">{{ $data->district }}</td>
                                    <td class="pin">{{ $data->pin }}</td>
                                    <td class="state">{{ $data->state }}</td>
                                    <td class="primary_mobile_no">{{ $data->primary_mobile_no }}</td>
                                    {{-- <td class="alternate_mobile_no">{{ $data->alternate_mobile_no }}</td>
                                    <td class="whatsapp_mobile_no">{{ $data->whatsapp_mobile_no }}</td>
                                    <td class="email">{{ $data->email }}</td> --}}
                                    <td>
                                        <a href="{{ route('edit.affiliated-college', $data->code) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
