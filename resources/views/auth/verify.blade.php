@extends('layouts.app') 
@section('title','Data Hasil Pertanian') 
@section('content')
<section class="section">
    <div class="section-header">
        {{-- <h1>Verify Your Email Address</h1> --}}
        <h1>Verifikasi Alamat E-Mail Anda</h1>

    </div>

    <div class="section-body">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Verifikasi Alamat E-Mail Anda</h4>
                </div>
                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-primary" role="alert">
                        {{-- {{ __('A fresh verification link has been sent to your email address.') }} --}}
                        @lang('passwords.verification')
                    </div>
                    @endif 
                    Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi. Jika Anda tidak menerima email, <a href="{{ route('verification.resend') }}"> klik di sini untuk meminta yang lain</a>.
                </div>
            </div>

        </div>
    </div>

</section>
@endsection
 
@section('script')

<script>
    $(document).ready(function() {

	});

</script>
@endsection