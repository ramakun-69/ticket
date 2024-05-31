@extends('layouts.auth')
@section('content')
    <style>
        /* Gaya untuk mengatur stacking context */
        .mb-3 {
            position: relative;
            z-index: 2;
            /* Tingkatkan z-index agar kontainer input dan pesan kesalahan muncul di atas elemen lain */
        }

        .form-label {
            position: relative;
            z-index: 3;
            /* Tingkatkan z-index agar label selalu muncul di depan elemen lain */
        }

        .btn-outline-secondary {
            outline: none !important;
        }
    </style>
    <div class="auth-maintenance d-flex align-items-center min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-3">
                                <div class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class=""></div>
                                            <div class="h-100 bg-auth align-items-end">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <div>
                                                    <div class="text-center mt-1">
                                                        <h4 class="font-size-18">{{ strtoupper(__('welcome')) }}</h4>
                                                        <p class="text-muted">{{ __('please login') }}</p>
                                                    </div>

                                                    <form method="POST" action="{{ route('login') }}" class="auth-input">
                                                        @csrf
                                                        <div class="mb-2">
                                                            <label for="email"
                                                                class="form-label">{{ __('email') }}</label>
                                                            <input id="email" type="text"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email" value="{{ old('email') }}"
                                                                placeholder="{{ __('enter email') }}" autocomplete="off"
                                                                autofocus>
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 position-relative" style="z-index: 2;">
                                                            <label class="form-label"
                                                                style="position: relative; z-index: 3;"
                                                                for="password-input">{{ __('Password') }}</label>
                                                            <div class="input-group" style="z-index: 2;">
                                                                <input type="password"
                                                                    class="form-control password-toggle @error('password') is-invalid @enderror"
                                                                    placeholder="{{ __('Masukkan kata sandi') }}"
                                                                    id="password-input" name="password"
                                                                    autocomplete="current-password">
                                                            </div>
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>


                                                        <div class="form-check d-flex justify-content-between">
                                                            <div>
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="remember" id="remember"
                                                                    {{ old('remember') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="remember">{{ __('remember me') }}</label>
                                                            </div>
                                                            <a href="{{ route('password.update') }}"
                                                                class="text-end text-danger">{{ __('forget password?') }}</a>
                                                        </div>
                                                        <div class="mt-4">
                                                            <button type="submit" class="btn btn-danger w-100"
                                                                type="submit">{{ __('sign in') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->

                                <div class="mt-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> PT.Samco Farma. Developer by 
                                        {{-- <a href="www.erasites.com">Erasites Citra Digital Indonesia</a> --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
    @widget('auth');
@endsection
