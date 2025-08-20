<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/logoo.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <title>{{ str_replace('_', ' ', config('app.name')) }} | {{ $title }} </title>
</head>

<body class="bg-theme bg-theme9">
    <!--wrapper-->
    <div class="wrapper">
        {{ $slot }}
    </div>
    <!--end wrapper-->
    <x-toast></x-toast>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
        $(document).ready(function() {
            $("#hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#hide_password input').attr("type") == "text") {
                    $('#hide_password input').attr('type', 'password');
                    $('#hide_password i').addClass("bx-hide");
                    $('#hide_password i').removeClass("bx-show");
                } else if ($('#hide_password input').attr("type") == "password") {
                    $('#hide_password input').attr('type', 'text');
                    $('#hide_password i').removeClass("bx-hide");
                    $('#hide_password i').addClass("bx-show");
                }
            });
        });
    </script>

    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastLiveExample = document.getElementById('liveToast');
                const toastTime = document.getElementById('toastTime');

                // Set waktu saat ini
                const currentTime = new Date();
                const formattedTime = currentTime.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                toastTime.textContent = formattedTime;

                const toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            });
        </script>
    @endif

</body>

</html>
