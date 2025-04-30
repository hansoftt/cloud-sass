<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('cloud-sass.name', 'CLOUD SASS') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .content {
            padding: 20px 0;
            line-height: 1.6;
            color: #555;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #888;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to {{ config('cloud-sass.name', 'CLOUD SASS') }}!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $client->name }},</p>
            <p>Thank you for registering with us. We are excited to have you on board!</p>
            <p>You can now access your account and explore our services. If you have any questions, feel free to reach out to our support team.</p>
            <p>
                Your Website:
                <a href="http://{{ $client->subdomain }}.{{ config('cloud-sass.domain') }}">
                    http://{{ $client->subdomain }}.{{ config('cloud-sass.domain') }}
                </a>
            </p>
            <p>
                Login URL:
                <a href="http://{{ $client->subdomain }}.{{ config('cloud-sass.domain') }}/login">
                    http://{{ $client->subdomain }}.{{ config('cloud-sass.domain') }}/login
                </a>
            </p>
            <p>
                <u>Login Email:</u> <span style="color: #7b0000;">{{ $client->email }}</span><br/>
                <u>Login Password:</u> <span style="color: #7b0000;">{{ $client->phone }}</span>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('cloud-sass.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
