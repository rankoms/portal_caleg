@extends('layouts.app')

@section('content')
@section('vendor-style')
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
@endsection
<div class="p-4">
	<h4 class="py-3 breadcrumb-wrapper mb-4">
		<span class="text-muted fw-light">Forms /</span> News & Announcement
	</h4>
	<form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-12">
				<div class="card mb-4">
					<h5 class="card-header">Tambah News & Announcement</h5>
					<div class="card-body">
						<div class="mb-3">
							<label for="title" class="form-label">Title</label>
							<input type="text" class="form-control" name="title" id="title" />
						</div>
						<div class="mb-3">
							<label for="category" class="form-label">News / Announcement</label>
							<select name="category" id="category" class="form-control">
								<option value="">Pilih News / Announcement</option>
								<option value="news">News</option>
								<option value="announcement">Announcement</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="editor" class="form-label">Isi</label>
							<textarea id="editor" name="editor" rows="10" cols="80"></textarea>
						</div>
						<div class="mb-3 d-none">
							<label for="defaultFormControlInput" class="form-label">Tanggal Terbit</label>
							<input type="text" class="form-control" placeholder="HH:MM" name="tgl_terbit" id="tgl_terbit"
								value="{{ date('Y-m-d H:i') }}" />
						</div>
						<div class="mb-3">
							<label for="defaultFormControlInput" class="form-label">Foto</label>
							<input type="file" class="form-control" name="foto" id="foto" />
						</div>
						<div class="mb-3">
							<label for="defaultFormControlInput" class="form-label">Video</label>
							<input type="file" class="form-control" name="video" id="video" />
						</div>
						<div class="mb-3">
							<label for="defaultFormControlInput" class="form-label">File</label>
							<input type="file" class="form-control" name="file" id="file" />
						</div>
						<div class="mb-3">
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
<script>
	// This sample still does not showcase all CKEditor 5 features (!)
	// Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
	var options = {
		filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
		filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
		filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
		filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
	};
	CKEDITOR.replace('editor', {
		filebrowserBrowseUrl: '{{ asset(route('ckfinder_browser')) }}',
		filebrowserImageBrowseUrl: '{{ asset(route('ckfinder_browser')) }}?type=Images',
		filebrowserFlashBrowseUrl: '{{ asset(route('ckfinder_browser')) }}?type=Flash',
		filebrowserUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Flash'
	});


	document.querySelector('#tgl_terbit').flatpickr({
		enableTime: true,
		dateFormat: 'Y-m-d H:i'
	});
</script>
@endsection
