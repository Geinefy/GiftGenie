<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GiftGenie') }}</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial; margin: 0; padding: 0; }
        .container { max-width: 1024px; margin: 0 auto; padding: 24px; }
        nav { background: #111827; color: white; padding: 12px 24px; }
        nav a { color: #fff; margin-right: 12px; text-decoration: none; }
    </style>
</head>
<body>
    <nav>
        <a href="/">GiftGenie</a>
        <a href="/gifts">Gifts</a>
        <a href="/dashboard">Dashboard</a>
        <a href="/auth">Auth</a>
    </nav>
    <div class="container">
        <!-- Content -->
        <?php echo isset($content) ? $content : ''; ?>
    </div>
</body>
</html>
