<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .error-message {
            font-size: 24px;
            color: #e74c3c;
        }
        .error-description {
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="error-message">{{ $pageTitle }}</div>
    <div class="error-description">
        The code you entered is incorrect. Please try again or request a new verification code.
    </div>
    <a href="{{ route('customer.password.vetification') }}">Request New Code</a>
</body>
</html>
