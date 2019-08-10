@extends('layouts.app') 
@section('title','Dashboard') 
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="alert alert-primary alert-has-icon">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
            <div class="alert-title">Selamat Datang!</div>
            Di Halaman Administrator.
        </div>
    </div>


    <div class="row">

        @role('superadministrator')
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-tree"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Komoditas</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['count_commodities'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kualitas</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['count_quality'] }}

                    </div>
                </div>
            </div>
        </div>

        @endrole

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-cloud"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Hasil Pertanian</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['count_agriculture'] }}

                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-star"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kualitas Hasil Pertanian</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['count_quality_of_agriculture'] }}

                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Standar Harga</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['count_standard_price'] }}

                    </div>
                </div>
            </div>
        </div>

        @role('superadministrator')
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Users</h4>
                    </div>
                    <div class="card-body">
                        {{ $count['count_users'] }}

                    </div>
                </div>
            </div>
        </div>
        @endrole

    </div>
</section>

{{--
<notifications-component></notifications-component> --}}
@endsection
 
@section('script')

<script>
    $(document).ready(function() {
        // console.log('');
        // axios.get('https://x.rajaapi.com/MeP7c5nesCOHyl0NQxEF8sRzf2tByhTlpx9UEGAgRJuTo9iW4CQgsezf7P/m/wilayah/provinsi')
        // .then((data) => {
        //     console.log(data.data.data[0].name);
        // } );

    });

</script>
@endsection