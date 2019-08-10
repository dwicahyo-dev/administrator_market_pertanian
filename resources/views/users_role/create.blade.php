@extends('layouts.app') 
@section('title','Tambah Data Users Role') 
@section('css')
@endsection
 
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Users Role</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="{{ route('home') }}">Dashboard</a>
			</div>
			<div class="breadcrumb-item">
				<a href="{{ route('users.index') }}">Users Role</a>
			</div>

			<div class="breadcrumb-item">Tambah Data Users Role</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Tambah Data Users Role</h2>

		<div class="col-12 col-md-12 col-lg-12">
			<div class="card card-primary">
				<div class="card-body">
					@if ($errors->any()) @foreach ($errors->all() as $error)
					<div class="alert alert-danger alert-dismissible show fade">
						<div class="alert-body">
							<button class="close" data-dismiss="alert">
								<span>&times;</span>
							</button> {{ $error }}
						</div>
					</div>
					@endforeach @endif

					<form method="POST" action="{{ route('users_role.store') }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label>Users</label>
							<select name="user_id" class="form-control {{ $errors->has('user_id') ? ' is-invalid' : '' }}">
								<option value="">-- Pilih Users --</option>
								@foreach ($users as $item)
								<option value="{{$item->id}}" {{ (old('user_id') == $item->id ? 'selected' : '' ) }} >{{$item->name }}</option>
								@endforeach
							</select> {{--
							<div class="invalid-feedback">{{ $errors->first('user_id') }}</div> --}}
						</div>

						<div class="form-group">
							<label>Roles</label>
							<select name="role_id" class="form-control {{ $errors->has('role_id') ? ' is-invalid' : '' }}">
								<option value="">-- Pilih Roles --</option>
								@foreach ($roles as $item)
								<option value="{{$item->id}}" {{ (old('role_id') == $item->id ? 'selected' : '' ) }} >{{$item->display_name }}</option>
								@endforeach
							</select> {{--
							<div class="invalid-feedback">{{ $errors->first('role_id') }}</div> --}}
						</div>

						<button class="btn btn-primary mr-1" type="submit">Simpan</button>
						<a href="{{ route('users_role.index') }}" role="button" class="btn btn-danger">Batal</a>
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
		$("select").select2();
		
	});

</script>
@endsection