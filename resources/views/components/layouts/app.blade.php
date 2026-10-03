@props(['title' => null, 'bare' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Kembara' }} — Berjelajah Jakarta</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    @unless($bare)
        <x-navbar />
    @endunless

    <main>{{ $slot }}</main>

    @unless($bare)
        <footer class="py-10 text-center text-sm text-ink-muted">© {{ date('Y') }} Kembara. Berjelajah Jakarta bersama Bara.</footer>
    @endunless
</body>
</html>
