@extends('layouts.app')

@section('title','Tambah Data Users')
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Users</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="{{ route('home') }}">Dashboard</a>
			</div>
			<div class="breadcrumb-item">
				<a href="{{ route('users.index') }}">Users</a>
			</div>

			<div class="breadcrumb-item">Tambah Data Users</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Tambah Data Users</h2>

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

					<form method="POST" action="{{ route('users.store') }}">
						{{ csrf_field() }}

						<div class="form-group ">
							<label>Nama User</label>
							<input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nama User" autofocus>
							{{-- <div class="invalid-feedback">{{ $errors->first('name') }}</div> --}}
						</div>
						<div class="form-group ">
							<label>Email User</label>
							<input type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email User">
							{{-- <div class="invalid-feedback">{{ $errors->first('email') }}</div> --}}
						</div>

						<button class="btn btn-primary mr-1" type="submit">Simpan</button>
						<a href="{{ route('users.index') }}" role="button" class="btn btn-danger">Batal</a>
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