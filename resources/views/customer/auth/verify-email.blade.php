<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Link to a sleek font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #f36);
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .container {
            max-width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .card-header {
            font-size: 28px;
            font-weight: 700;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }

        .message {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            background-color: #f36;
            color: #fff;
            border: transparent;
            padding: 10px 25px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 20px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .btn:hover {
            background-color: #e02f2f;
        }

        .btn-secondary {
            background-color: #c6c6c6;
        }

        .btn-secondary:hover {
            background-color: #9e9e9e;
        }

        .alert-info {
            background-color: #e8f4fd;
            color: #0277bd;
            border: 1px solid #0277bd;
            padding: 10px;
            font-size: 12px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .footer a {
            color: #f36;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        hr {
            margin-top: 25px;
            margin-bottom: 25px;
            border-color: #ddd;
        }

        /* For mobile responsiveness */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
                margin: 15px;
            }
            .card-header {
                font-size: 24px;
            }
            .message {
                font-size: 12px;
            }
            .btn {
                padding: 8px 20px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card-header">
            Verify Your Email
        </div>

        <div class="message">
            <p>Thanks for signing up! A verification link has been sent to your email. Please check your inbox to verify your email address.</p>
            <p>If you didn’t get the email, click the button below to resend it.</p>
        </div>

        @if (session('message'))
            <div class="alert-info">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn">Resend Verification Email</button>
        </form>

        <hr>

        <div class="text-center">
            <p>Already verified?</p>
            <a href="{{ route('login') }}" class="btn btn-secondary">
                Login Now
            </a>
        </div>

        <div class="footer">
            <p>Need help? <a href="mailto:support@example.com">Contact Support</a></p>
        </div>
    </div>

</body>
</html>
