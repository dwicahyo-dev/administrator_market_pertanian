@extends('layouts.app')

@section('title','Tambah Data Kualitas Hasil Pertanian')

@section('css')

@endsection

@section('content')
<section class="section">
	<div class="section-header">
		<h1>Kualitas Hasil Pertanian</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="{{ route('home') }}">Dashboard</a>
			</div>
			<div class="breadcrumb-item">
				<a href="{{ route('quality_of_agriculture.index') }}">Kualitas Hasil Pertanian</a>
			</div>

			<div class="breadcrumb-item">Tambah Data Kualitas Hasil Pertanian</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Tambah Data Kualitas Hasil Pertanian</h2>

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

					<form method="POST" action="{{ route('quality_of_agriculture.store') }}">
						@csrf

						<div class="form-group">
							<label>Hasil Pertanian</label>
							<select name="agriculture_id" class="form-control">
								<option value="">-- Pilih Hasil Pertanian --</option>
								@foreach ($agriculture as $item)
								<option value="{{$item->id}}" {{ (old('agriculture_id') == $item->id ? 'selected' : '' ) }} >{{$item->agriculture_name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label>Kualitas</label>
							<select name="quality_id" class="form-control">
								<option value="">-- Pilih Kualitas --</option>
								@foreach ($quality as $item)
								<option value="{{$item->id}}" {{ (old('quality_id') == $item->id ? 'selected' : '' ) }} >{{$item->quality_name }}</option>
								@endforeach
							</select>
						</div>

						<button class="btn btn-primary mr-1" type="submit">Simpan</button>
						<a href="{{ route('quality_of_agriculture.index') }}" role="button" class="btn btn-danger">Batal</a>
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