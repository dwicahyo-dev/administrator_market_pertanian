{{-- <form method="POST" onclick="return confirm('Yakin Ingin Menghapus Data ?')" action="{{ route($model . '.destroy', $id)}} ">
	@csrf
	@method('DELETE')
	<button class="btn btn-danger mt-1"><i class="fas fa-trash"></i></button>
</form> --}}

<a href="javascript:void(0)" model="{{ $model }}" id="btnDelete" onclick="deleteData({{ $id }})" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>