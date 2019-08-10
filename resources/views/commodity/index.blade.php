@extends('layouts.app')

@section('title','Data Komoditas')
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Komoditas</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
			<div class="breadcrumb-item">Komoditas</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Tabel Data Komoditas</h2>

		<div class="col-12 col-md-12 col-lg-12">
			@if (session()->has('success'))		
			<div class="alert alert-primary alert-dismissible show fade">
				<div class="alert-body">
					<button class="close" data-dismiss="alert">
						<span>&times;</span>
					</button>
					{{ session()->get('success') }}
				</div>
			</div>

			@endif

			<div class="card card-primary">
				<div class="card-header">
					@role('superadministrator')
					<a href="{{ route('commodity.create') }}" class="btn btn-primary btn-icon icon-left  ">
						<i class="fas fa-plus"></i> Tambah Data Komoditas
					</a>
					@endrole

					<!-- @role('administrator')
					<a href="{{ route('commodity.create') }}" role="button" class="btn btn-icon icon-left btn-primary disabled">
						<i class="fas fa-plus"></i> Tambah Data Komoditas
					</a>
					@endrole -->
					
				</div>
				<div class="card-body">
					<div class="table table-responsive table-hover table-striped ">

						{!! $html->table(['style' => 'width:100%', 'cellspacing' => '0']) !!}

					</div>
				</div>
			</div>
		</div>
	</div>
</div>


</section>
@endsection

@section('script')
{!! $html->scripts() !!}

<script>
	$(document).ready(function() {

	});

</script>

@endsection