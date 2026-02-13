<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f4f8;
            margin: 0;
        }

        .error-container {
            max-width: 500px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .error-title {
            font-size: 3rem;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 10px;
        }

        .error-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .error-description {
            font-size: 1rem;
            color: #495057;
            margin-bottom: 30px;
        }

        .btn-custom {
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 30px;
        }

        .btn-primary-custom {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary-custom {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="error-container">
    <div class="icon">
        <i class="bi bi-exclamation-triangle-fill"></i>
    </div>
    <h1 class="error-title">419</h1>
    <h2 class="error-subtitle">Session Expired</h2>
    <p class="error-description">
        Oops! It looks like your session has expired. For your security, we have logged you out. Please log in again to continue.
    </p>

    <!-- Add buttons for login and page refresh -->
    <a href="{{ route('login') }}" class="btn btn-primary btn-custom btn-primary-custom">Log In Again</a>
    {{-- <a href="javascript:location.reload()" class="btn btn-secondary btn-custom btn-secondary-custom">Refresh Page</a> --}}
</div>

<!-- Bootstrap JS and Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
