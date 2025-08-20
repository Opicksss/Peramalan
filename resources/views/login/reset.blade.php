<x-login.layout>
    <x-slot:title>Reset Password</x-slot:title>
    <div class="authentication-reset-password d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-4">
                                <div class="mb-4 text-center">
                                    <img src="assets/images/logo_coverr.png" width="250" alt="" />
                                </div>
                                <div class=" mb-4">
                                    <h5 class="text-center">Genrate New Password</h5>
                                    <p class="mb-0">We received your reset password request. Please enter your new
                                        password!</p>
                                </div>
                                <form action="{{ route('reset-password-proses') }}" method="POST">
                                    @csrf
                                    <div class="col-12 mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control border-end-0" id="password"
                                                name="password" placeholder="Enter New Password" minlength="8"
                                                required> <a href="javascript:;"
                                                class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                        </div>
                                        @error('password')
                                            <div class="text-sm text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label for="password_confirmation" class="form-label">Confirm
                                            Password</label>
                                        <div class="input-group" id="hide_password">
                                            <input type="password" class="form-control border-end-0"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Confirm Password" minlength="8" required> <a
                                                href="javascript:;" class="input-group-text bg-transparent"><i
                                                    class='bx bx-hide'></i></a>
                                        </div>
                                        @error('password')
                                            <div class="text-sm text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-white">Change Password</button>
                                        <a href="{{ route('login') }}" class="btn btn-light"><i
                                                class='bx bx-arrow-back mr-1'></i>Back to Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-login.layout>
