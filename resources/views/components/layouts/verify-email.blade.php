<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manager Box</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="flex h-screen overflow-hidden">
    {{ $slot }}
</body>

</html>
