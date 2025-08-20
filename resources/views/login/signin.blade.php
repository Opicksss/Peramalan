<x-login.layout>
    <x-slot:title>Login</x-slot:title>
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="p-4">
                                <div class="mb-2 text-center">
                                    <img src="assets/images/logo_coverr.png" width="250" alt="" />
                                </div>
                                <div class="text-center mb-2">
                                    <h5 class="">Login</h5>
                                    <p class="mb-0">Please log in to your account</p>
                                </div>
                                <div class="form-body">
                                    <form action="{{ route('login-proses') }}" method="POST" class="row g-3" validate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="login" class="form-label">Email Or Username</label>
                                            <input type="text" class="form-control" id="login" name="login"
                                                placeholder="Input Email" value="{{ old('login') }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" class="form-control border-end-0" id="password"
                                                    name="password" placeholder="Enter Password" required> <a
                                                    href="javascript:;" class="input-group-text bg-transparent"><i
                                                        class="bx bx-hide"></i></a>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            </div> --}}
                                        <div class="col-md-12 text-end"> <a href="{{ route('forgot') }}">Forgot Password
                                                ?</a>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-light mb-3">Sign in</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</x-login.layout>
