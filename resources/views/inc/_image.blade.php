@if($src)
<img src="{{ Storage::url($src) }}" class="img img-responsive img-thumbnail">
@else
<img src="{{ asset('dist/img/news/img01.jpg') }}" class="img img-responsive img-thumbnail">
@endif