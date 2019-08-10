@extends('layouts.app')

@section('title','Tambah Data Kualitas')
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Kualitas</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="{{ route('home') }}">Dashboard</a>
			</div>
			<div class="breadcrumb-item">
				<a href="{{ route('quality.index') }}">Kualitas</a>
			</div>

			<div class="breadcrumb-item">Tambah Data Kualitas</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Tambah Data Kualitas</h2>

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

					<form method="POST" action="{{ route('quality.store') }}">
						@csrf
						<div class="form-group ">
							<label>Nama Kualitas</label>
							<input type="text" name="quality_name" class="form-control {{ $errors->has('quality_name') ? ' is-invalid' : '' }}" placeholder="Nama Kualitas" autofocus>
						</div>
						<button class="btn btn-primary mr-1" type="submit">Simpan</button>
						<a href="{{ route('quality.index') }}" role="button" class="btn btn-danger">Batal</a>
					</form>
				</div>
			</div>
		</div>
	</div>


</section>
@endsection

@section('script')


@endsection