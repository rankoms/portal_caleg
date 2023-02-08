@extends('layouts.app')

@section('content')
	<div class="container flex-grow-1 container-p-y">
		<h4 class="py-3 breadcrumb-wrapper mb-4">
			<span class="text-muted fw-light">Forms /</span> News & Announcement
		</h4>
		<form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-4">
						<h5 class="card-header">Edit News & Announcement</h5>
						<div class="card-body">
							<div class="mb-3">
								<label for="defaultFormControlInput" class="form-label">Title</label>
								<input type="text" class="form-control" name="title" id="title" value="" />
							</div>
							<div class="mb-3">
								<label for="defaultFormControlInput" class="form-label">Isi</label>
								<textarea id="editor" name="editor" rows="10" cols="80"></textarea>
							</div>
							<div class="mb-3">
								<label for="defaultFormControlInput" class="form-label">Tanggal Terbit</label>
								<input type="date" class="form-control" name="tgl_terbit" id="tgl_terbit" value="{{ date('Y-m-d') }}" />
							</div>
							<div class="mb-3">
								<label for="defaultFormControlInput" class="form-label">Foto</label>
								<input type="file" class="form-control" name="foto" id="foto" />
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
		setTimeout(function() {
			CKEDITOR.replace('editor', options);
		}, 100);
	</script>
@endsection
