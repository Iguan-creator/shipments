<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>SHIPMENTS ONLINE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('auth/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('auth/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('auth/css/app.min.css') }}" rel="stylesheet" type="text/css"/>

</head>

<body>
<div class="container">
    @yield('content', '')
</div>
<!-- end container -->
<!-- end page -->

<!-- Vendor js -->
<script src="{{ asset('auth/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('auth/js/app.min.js') }}"></script>

</body>
</html>
