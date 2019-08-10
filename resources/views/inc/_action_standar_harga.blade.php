<a href="{{route($model . '.edit', $id)}}" title="Edit" class="btn btn-warning">
	<i class="fas fa-pencil-alt"></i>
</a>

<a href="javascript:void(0)" model="{{ $model }}" id="btnDelete" onclick="deleteData({{ $id }})" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>