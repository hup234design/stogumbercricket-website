<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="antialiased font-sans">
<main>
    <x-resourcescontent-blocks :content_blocks="$content_blocks" />
</main>
@livewireScripts
</body>
</html>
