<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Client Registered at {{ config('cloud-sass.name', 'CLOUD SASS') }}</title>
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
            <h1>New Client Registered @ {{ config('cloud-sass.name', 'CLOUD SASS') }}!</h1>
        </div>
        <div class="content">
            <p>Dear Admin,</p>
            <p>A new client is on board!</p>
            <p>They can access their account and explore our services.</p>
            <p>
                Client Name: {{ $client->name }}<br/>
                Client Email: {{ $client->email }}<br/>
                Client Password: {{ $client->phone }}<br/>
                <a href="http://{{ $client->subdomain }}.{{ config('cloud-sass.domain') }}">
                    http://{{ $client->subdomain }}.{{ config('cloud-sass.domain') }}
                </a>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('cloud-sass.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
