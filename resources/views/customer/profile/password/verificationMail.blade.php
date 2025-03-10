<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Verification Code</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #4caf50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .email-footer {
            text-align: center;
            padding: 15px;
            background-color: #f4f4f4;
            font-size: 12px;
            color: #999999;
        }
        .verification-code {
            display: inline-block;
            font-size: 24px;
            color: #ffffff;
            background-color: #4caf50;
            padding: 10px 20px;
            margin: 20px 0;
            border-radius: 5px;
            text-decoration: none;
        }
        .email-footer a {
            color: #4caf50;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .email-container {
                width: 100%;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Password Verification Code</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Hello {{ $name ?? 'User' }},</p>
            <p>We received a request to verify your account for password reset. Please use the following code to proceed:</p>

            <p class="verification-code">{{ $code }}</p>

            <p>If you did not request this, please ignore this email or contact support.</p>

            <p>Thank you,<br>
            The {{ config('app.name') }} Team</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p><a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
        </div>
    </div>
</body>
</html>
