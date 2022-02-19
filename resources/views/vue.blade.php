<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shipments</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
</head>
<body class="left-side-menu-condensed">
<div id="app"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
