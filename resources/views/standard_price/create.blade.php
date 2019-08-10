@extends('layouts.app')

@section('title','Tambah Data Standar Harga')

@section('css')
@if ($errors->has('agriculture_id'))
<style>
	.select2-selection--single {
		border-color: #dc3545 !important;
	}
</style>
@endif
@endsection

@section('content')
<section class="section">
	<div class="section-header">
		<h1>Standar Harga</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active">
				<a href="{{ route('home') }}">Dashboard</a>
			</div>
			<div class="breadcrumb-item">
				<a href="{{ route('standard_price.index') }}">Standar Harga</a>
			</div>

			<div class="breadcrumb-item">Tambah Data Standar Harga</div>
		</div>
	</div>

	<div class="section-body">
		<h2 class="section-title">Form Tambah Data Standar Harga</h2>

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

						<form method="POST" action="{{ route('standard_price.store') }}">
							@csrf

							<div class="form-group">
								<label>Hasil Pertanian</label>
								<select name="agriculture_id" class="form-control">
									<option value="">-- Pilih Hasil Pertanian --</option>
									@foreach ($agricultures as $item)
									<option value="{{$item->id}}"
										{{ (old('agriculture_id') == $item->id ? 'selected' : '' ) }}>
										{{$item->agriculture_name }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group ">
								<label>Harga Terendah</label>
								<div class="input-group ">
									<div class="input-group-prepend ">
										<span class="input-group-text">Rp.</span>
									</div>
									<input type="number" name="lowest_price" required
										class="form-control num {{ $errors->has('lowest_price') ? ' is-invalid' : '' }}"
										value="{{ old('lowest_price') }}" placeholder="Harga Terendah">
								</div>
							</div>

							<div class="form-group ">
								<label>Harga Tertinggi</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">Rp.</span>
									</div>
									<input type="number" name="highest_price" required
										class="form-control num {{ $errors->has('highest_price') ? ' is-invalid' : '' }}"
										value="{{ old('highest_price') }}" placeholder="Harga Tertinggi">
								</div>
							</div>

							<button class="btn btn-primary mr-1" type="submit">Simpan</button>
							<a href="{{ route('standard_price.index') }}" role="button" class="btn btn-danger">Batal</a>
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
		
		moment.locale('id');
		console.log(moment().format('LLLL'));

		// $('.num').mask('000.000.000', {reverse: true});

		// $('[name=nama_kualitas]').on('keyup', function(){
		// 	console.log($('[name=nama_kualitas]').cleanVal()); 
		// });
	});

</script>

@endsection