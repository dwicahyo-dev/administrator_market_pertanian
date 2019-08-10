
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Reset Password</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('dist/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/components.min.css') }}">

  <body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                        <div class="card card-primary">
                            <div class="card-header"><h4>{{ __('Reset Password') }}</h4></div>

                            <div class="card-body">
                                @if (session('status'))
                                <div class="alert alert-primary" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif

                                {{-- <p class="text-muted">We will send a link to reset your password</p> --}}
                                <p class="text-muted">Kami akan mengirim surel untuk mereset kata sandi Anda!</p>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email">Alamat E-Mail</label>
                                        <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ Auth::user()->email }}" name="email" tabindex="1" required readonly>
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>

                                    </div>

                                    <div class="form-group">
                                        {{-- <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">{{ __('Send Password Reset Link') }}</button> --}}
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Kirim tautan Reset Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="simple-footer">Copyright &copy; Market-Pertanian 2019</div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('dist/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/modules/popper.js') }}"></script>
    {{-- <script src="{{ asset('dist/modules/tooltip.js') }}"></script> --}}
    <script src="{{ asset('dist/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    {{-- <script src="{{ asset('dist/modules/moment.min.js') }}"></script> --}}
    <script src="{{ asset('dist/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('dist/js/scripts.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>
</body>
</html>