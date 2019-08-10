@extends('layouts.app')

@section('title','Edit Data Hasil Pertanian')

@section('css')
@if ($errors->has('komoditas_id'))
<style>
	.select2-selection--single {
		border-color: #dc3545 !important;
	}
</style>
@endif

@if ($errors->has('thumbnail'))
<style>
	.img-thumbnail {
		border-color: #dc3545 !important;
	}
</style>
@endif
@endsection

@section('content')
<section class="section">
	<div class="section-header">
		<h1>Hasil Pertanian</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="{{ route('home') }}">Dashboard</a>
			</div>
			<div class="breadcrumb-item">
				<a href="{{ route('agriculture.index') }}">Hasil Pertanian</a>
			</div>

			<div class="breadcrumb-item">Edit Data Hasil Pertanian</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Edit Data Hasil Pertanian</h2>

		<div class="row">
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

						<form method="POST" action="{{ route('agriculture.update', $agriculture->id) }}"
							enctype="multipart/form-data">
							@csrf
							@method("PATCH")

							<div class="form-group ">
								<label>Nama Hasil Pertanian</label>
								<input type="text" name="agriculture_name" value="{{ $agriculture->agriculture_name }}"
									class="form-control {{ $errors->has('agriculture_name') ? ' is-invalid' : '' }}"
									placeholder="Nama Hasil Pertanian" autofocus="">
							</div>

							<div class="form-group">
								<label>Komoditas</label>
								<select name="commodity_id"
									class="form-control {{ $errors->has('commodity_id') ? ' is-invalid' : '' }}">
									<option value="">-- Pilih Komoditas --</option>
									@foreach ($commodities as $item)
									<option {{ $item->id == $agriculture->commodity_id ? 'selected' : '' }}
										value="{{$item->id}}"
										{{ (old('commodity_id') == $item->id ? 'selected' : '' ) }}>
										{{$item->commodity_name}}</option>

									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label>Thumbnail</label><br>
								<input type="file" name="thumbnail" class="btn-file" id="imgInp">
								<br>
								<img class="mt-3 img-fluid img-thumbnail" id='img-upload' style="width: 400px"
									src="{{ Storage::url('agricultures/'. $agriculture->thumbnail) }}">
							</div>

							<button class="btn btn-primary mr-2" type="submit">Update</button>
							<a href="{{ route('agriculture.index') }}" role="button" class="btn btn-danger">Batal</a>
						</form>
					</div>
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