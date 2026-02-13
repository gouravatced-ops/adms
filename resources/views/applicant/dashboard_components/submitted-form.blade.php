@extends('applicant.dashboard_layouts.main')

@section('title', 'Form Submitted Successfully')

@section('content')
    <style>
        .svg-container {
            width: 100%;
            max-width: 120px;
            /* Adjust max-width as needed */
            margin: 0 auto;
        }

        .svg-container svg {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
    <div class="justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card text-center shadow-lg">
            <div class="card-body">
                <div class="svg-container">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green"
                        class="icon icon-tabler icons-tabler-filled">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                    </svg>
                </div>

                <h2 class="mt-4 text-success">Form Submitted Successfully!</h2>
                <p class="mt-3 text-muted">
                    Thank you for submitting your form. We have received your application successfully. You will be notified
                    soon!
                </p>

                <div class="alert alert-success mt-4">
                    <strong>ACKNOWLEDGEMENT NUMBER:</strong> {{ $acknowledgment_number }}
                </div>

                <a href="{{ route('application.pdf', $acknowledgment_number) }}" class="btn btn-secondary mt-3">Download
                    Application PDF</a>
                <a href="{{ route('ack_slip.pdf', $acknowledgment_number) }}" class="btn btn-success mt-3">Download
                    Acknowledgement PDF</a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
                <a href="{{ route('track-application') }}" class="btn btn-warning mt-3">Track Application</a>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.history.pushState(null, '', window.location.href);
        window.onpopstate = function() {
            window.history.go(1);
        };
    </script>

    <script>
        $(document).ready(function() {
            $('.step').parent().find('.active').removeClass('active');
            $('.step').eq(3).addClass('active');
        });
    </script>
@endpush
