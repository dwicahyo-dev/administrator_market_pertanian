@extends('layouts.app')

@section('title','Edit Data Users')
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

			<div class="breadcrumb-item">Edit Data Users</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Edit Data Users</h2>

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

					<form method="POST" action="{{ route('users.update', $user->id) }}">
						{{ csrf_field() }}
						@method("PATCH")

						<div class="form-group ">
							<label>Nama User</label>
							<input type="text" name="name" value="{{ $user->name }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nama User" autofocus>
							{{-- <div class="invalid-feedback">{{ $errors->first('name') }}</div> --}}
						</div>
						<div class="form-group ">
							<label>Email User</label>
							<input type="email" name="email" value="{{ $user->email }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email User">
							{{-- <div class="invalid-feedback">{{ $errors->first('email') }}</div> --}}
						</div>

						<div class="form-group ">
							<label>Password</label>
							<input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password">
							{{-- <div class="invalid-feedback">{{ $errors->first('password') }}</div> --}}
						</div>

						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" name="confirm_password" class="form-control {{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" placeholder="Konfirmasi Password">
							{{-- <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div> --}}
						</div>

						<button class="btn btn-primary mr-1" type="submit">Update</button>
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