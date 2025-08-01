<!DOCTYPE html>
<html lang="{{ $locale ?? 'it' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'FriendsOfCats' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 2px solid #000000;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            padding: 20px;
            border-bottom: 1px solid #e5e5e5;
            background-color: #ffffff;
        }
        
        .logo {
            max-width: 150px;
            height: auto;
        }
        
        .content {
            padding: 30px 20px;
            background-color: #ffffff;
        }
        
        .footer {
            padding: 20px;
            border-top: 1px solid #e5e5e5;
            background-color: #ffffff;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .button {
            display: inline-block;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            margin: 10px 0;
        }
        
        .button:hover {
            background-color: #333333;
        }
        
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .security-note {
            background-color: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .user-details {
            background-color: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .user-details p {
            margin: 5px 0;
        }
        
        .user-details strong {
            color: #000000;
        }
        
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .content {
                padding: 20px 15px;
            }
            
            .header {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('images/cat-logo.svg') }}" alt="FriendsOfCats" class="logo">
        </div>
        
        <div class="content">
            @yield('content')
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} FriendsOfCats. Tutti i diritti riservati.</p>
        </div>
    </div>
</body>
</html> 