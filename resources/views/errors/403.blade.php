<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Unauthorized Access</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            text-align: center;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            margin: 20px;
        }

        h1 {
            font-size: 96px;
            margin: 0;
            color: #ff6b6b;
        }

        h2 {
            margin: 20px 0;
            font-size: 28px;
            color: #333;
        }

        p {
            font-size: 18px;
            color: #666;
            margin: 10px 0 30px 0;
        }

        a {
            text-decoration: none;
            background-color: #ff6b6b;
            color: #fff;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #ff4e4e;
        }

        .illustration {
            width: 100px;
            margin: 0 auto 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="https://img.icons8.com/fluency/96/lock.png" alt="Lock Icon" class="illustration">
        <h1>403</h1>
        <h2>Unauthorized Access</h2>
        <p>Sorry, but you don't have permission to access this page.</p>
        <a href="{{ url()->previous() }}">Go Back</a>
    </div>
</body>

</html>
