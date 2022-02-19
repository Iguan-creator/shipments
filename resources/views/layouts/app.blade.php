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

<body class="authentication-bg">

<div class="account-pages my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-12 p-5">
                                <div class="mx-auto mb-5">
                                    <h3 class="d-inline align-middle ml-1 text-logo">SHIPMENTS ONLINE</h3>
                                </div>

                                @yield('content', '')
                            </div>
                        </div>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<!-- Vendor js -->
<script src="{{ asset('auth/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('auth/js/app.min.js') }}"></script>

</body>
</html>
