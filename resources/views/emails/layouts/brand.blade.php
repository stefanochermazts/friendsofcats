<!DOCTYPE html>
<html lang="{{ $locale ?? 'it' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CatFriends Club' }}</title>
    <style>
        body {
            margin: 0; padding: 24px; background: #f6f7fb; color: #111827;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
            line-height: 1.6;
        }
        .container { max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .header { padding: 20px 24px; border-bottom: 1px solid #eef0f4; background: #ffffff; }
        .logo { height: 28px; display: block; }
        .logo-dark { display: none; }
        .content { padding: 28px 24px; }
        .title { margin: 0 0 16px; font-size: 26px; font-weight: 800; letter-spacing: -0.02em; }
        .lead { font-size: 16px; margin: 0 0 10px; }
        .muted { color: #6b7280; font-size: 13px; }
        .divider { height: 1px; background: #eef0f4; margin: 24px 0; }
        .btn-wrap { text-align: center; margin: 28px 0; }
        .btn { text-decoration: none; display: inline-block; border-radius: 10px; padding: 14px 22px; font-weight: 700; font-size: 15px; line-height: 1; color: #ffffff !important; background: #111827; border: 1px solid #0b1220; }
        .btn:hover { background: #1f2937; }
        .info { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; }
        .footer { padding: 18px 24px; border-top: 1px solid #eef0f4; text-align: center; color: #6b7280; font-size: 12px; background: #ffffff; }
        /* Dark mode adjustments (best-effort) */
        @media (prefers-color-scheme: dark) {
            body { background: #0b0f16; color: #e5e7eb; }
            .container { background: #0f172a; border-color: #1f2937; }
            .header, .footer { background: #0f172a; border-color: #1f2937; }
            .title { color: #f3f4f6; }
            .muted { color: #9ca3af; }
            .info { background: #0b1220; border-color: #1f2937; }
            .btn { background: #16a34a; border-color: #15803d; }
            .btn:hover { background: #15803d; }
            .logo-light { display: none !important; }
            .logo-dark { display: block !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $logoUrlLight ?? ($appName ? (config('app.url') . '/images/cat-logo.svg') : (config('app.url') . '/images/cat-logo.svg')) }}" alt="{{ $appName ?? 'CatFriends Club' }}" class="logo logo-light">
            <img src="{{ $logoUrlDark ?? ($logoUrlLight ?? (config('app.url') . '/images/cat-logo.svg')) }}" alt="{{ $appName ?? 'CatFriends Club' }}" class="logo logo-dark" style="{{ isset($logoUrlDark) && isset($logoUrlLight) && $logoUrlDark !== $logoUrlLight ? '' : 'filter: invert(1) brightness(2);' }}">
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $appName ?? 'CatFriends Club' }}. Tutti i diritti riservati.
        </div>
    </div>

    <!--[if mso]>
    <style type="text/css">
      .btn { font-family: Arial, sans-serif !important; }
    </style>
    <![endif]-->
</body>
</html> 