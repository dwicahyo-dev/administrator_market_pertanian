{{-- <script src="{{ asset('js/app.js') }}"></script> --}}

<!-- General JS Scripts -->
<script src="{{ asset('dist/modules/jquery.min.js') }}"></script>
<script src="{{ asset('dist/modules/popper.js') }}"></script>
<script src="{{ asset('dist/modules/tooltip.js') }}"></script>
<script src="{{ asset('dist/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('dist/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
{{-- <script src="{{ asset('dist/modules/moment.min.js') }}"></script> --}}
<script src="{{ asset('dist/js/stisla.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('dist/js/scripts.js') }}"></script>
<script src="{{ asset('dist/js/custom.js') }}"></script>

<!-- JS Libraies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>

<!-- Page Specific JS File -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/id.js"></script>

<script>
	$(document).ready(function() {

	});

	function deleteData(id) {
		let url = $("#btnDelete").attr("model");
		// console.log(url);

		Swal({
			title: 'Apakah Anda Yakin?',
			text: "Ingin Menghapus Data Ini?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus Saja!'
		}).then((result) => {
			if (result.value) {
				axios.delete(`${url}/${id}`)
				.then(function (response) {
					// console.log(response.data.message);
					Swal('Terhapus!', `${response.data.message}`,'success')
					.then(() => {
						location.reload();
					})
				})
				.catch(function (error) {
					console.log(error);
					Swal({
						type: 'error',
						title: 'Oops...',
						text: 'Gagal Menghapus Data',
					})
				});
			}
		})
	}

	function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#img-upload').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $(document).on('change', '.btn-file :file', function() {
    var input = $(this),
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
  });

  $('.btn-file :file').on('fileselect', function(event, label) {

    var input = $(this).parents('.input-group').find(':text'),
    log = label;

    if( input.length ) {
      input.val(log);
    } else {
      if( log ) alert(log);
    }

  });

  $("#imgInp").change(function(){
    readURL(this);
  });

</script>