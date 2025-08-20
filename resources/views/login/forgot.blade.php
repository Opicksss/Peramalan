<x-login.layout>
    <x-slot:title>Forgot Password</x-slot:title>
    <div class="authentication-forgot d-flex align-items-center justify-content-center">
        <div class="card forgot-box">
            <div class="card-body">
                <div class="p-3">
                    <div class="text-center">
                        <img src="assets/images/icons/forgot-2.png" width="100" alt="" />
                    </div>
                    <h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
                    <p class="mb-0">Enter your registered email ID to reset the password</p>
                    <form action="{{ route('forgot-proses') }}" method="POST">
                        @csrf
                        <div class="my-4">
                            <label class="form-label">Registered Email</label>
                            <input type="email" class="form-control" placeholder="Enter Your Email Address"
                                id="email" name="email" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-white">Send</button>
                            <a href="{{ route('login') }}" class="btn btn-light"><i
                                    class='bx bx-arrow-back me-1'></i>Back to
                                Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-login.layout>
