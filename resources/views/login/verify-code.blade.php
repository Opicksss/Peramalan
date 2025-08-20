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
    <title>{{ str_replace('_', ' ', config('app.name')) }} | Verify Code </title>
</head>

<body class="bg-theme bg-theme9">
    <!--wrapper-->
    <div class="wrapper">
        <div class="authentication-forgot d-flex align-items-center justify-content-center">
            <div class="card forgot-box">
                <div class="card-body">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="assets/images/icons/forgot-2.png" width="100" alt="" />
                        </div>
                        <h4 class="mt-5 font-weight-bold">Verify Your Email Code</h4>
                        <p class="mb-0">Enter the 6-digit code sent to your email to change password</p>
                        <form action="{{ route('verify-code-proses') }}" method="POST">
                            @csrf
                            <div class="my-3">
                                <label class="form-label">Verification Code</label>
                                <input type="text" class="form-control" placeholder="Enter Your Email Address"
                                    id="code" name="code" required>
                                <p class="small mt-1">The code will expire in <span id="countdown-text">10:00</span></p>
                                <div class="text-end">
                                    <a href="{{ route('forgot') }}" id="resend-link" class="text-secondary ">Didn't get
                                        the code?</a>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-white">Verify</button>
                                <a href="{{ route('login') }}" class="btn btn-light"><i
                                        class='bx bx-arrow-back me-1'></i>Back to
                                    Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <x-toast></x-toast>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <!--Password show & hide js -->
    <script>
        const createdAt = {{ $created_at }};
        const expireDuration = 600;
        const now = Math.floor(Date.now() / 1000);

        let remaining = expireDuration - (now - createdAt);
        remaining = remaining > 0 ? remaining : 0;

        const countdownTextEl = document.getElementById('countdown-text');
        const resendLink = document.getElementById('resend-link');

        resendLink.style.pointerEvents = 'none';
        resendLink.style.cursor = 'not-allowed';

        const timer = setInterval(() => {
            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;

            const formatted = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            countdownTextEl.textContent = formatted;

            if (remaining <= 480 && resendLink.style.pointerEvents === 'none') {
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.cursor = 'pointer';
                resendLink.classList.remove('text-secondary');
            }

            if (remaining <= 0) {
                clearInterval(timer);
                countdownTextEl.textContent = "Expired";
                document.getElementById('code').disabled = true;
                document.querySelector('button[type="submit"]').disabled = true;
            }

            remaining--;
        }, 1000);
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
