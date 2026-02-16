@extends('applicant.auth_layouts.main')

@section('title', 'Login')

@section('content')
@endsection

@push('scripts')
<script>
    window.onload = function () {
        window.location.href = "/"; // Change to your login route
    };
</script>
@endpush
