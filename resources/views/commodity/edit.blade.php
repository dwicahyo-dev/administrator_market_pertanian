@extends('layouts.app')

@section('title','Data Komoditas')

@section('css')

@endsection

@section('content')
<section class="section">
	<div class="section-header">
		<h1>Komoditas</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="{{ route('home') }}">Dashboard</a>
			</div>
			<div class="breadcrumb-item">
				<a href="{{ route('commodity.index') }}">Komoditas</a>
			</div>

			<div class="breadcrumb-item">Edit Data Komoditas</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Edit Data Komoditas</h2>

		<div class="col-12 col-md-12 col-lg-12">
			<div class="card card-primary">
				<div class="card-body">
					@if ($errors->any())
					@foreach ($errors->all() as $error)
					<div class="alert alert-danger alert-dismissible show fade">
						<div class="alert-body">
							<button class="close" data-dismiss="alert">
								<span>&times;</span>
							</button>
							{{ $error }}
						</div>
					</div>
					@endforeach
					@endif

					<form method="POST" action="{{ route('commodity.update', $commodity->id) }}">
						@csrf
						@method("PATCH")

						<div class="form-group ">
							<label>Nama Komoditas</label>
							<input type="text" name="commodity_name" value="{{ $commodity->commodity_name }}" class="form-control {{ $errors->has('commodity_name') ? ' is-invalid' : '' }}" placeholder="Nama Komoditas" autofocus>
						</div>

						<button class="btn btn-primary mr-1" type="submit">Update</button>
						<a href="{{ route('commodity.index') }}" role="button" class="btn btn-danger">Batal</a>
					</form>
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