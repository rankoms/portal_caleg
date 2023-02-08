
@extends('layouts.app')

@section('title', 'News Detail')

@section('vendor-style')
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
@endsection

@section('css')
<style>
	p {
		margin-top: 0;
		margin-bottom: 1em;
	}

	.kanan-fix {
		width: calc(100% - 60px);
	}

	.icon-heading {
		margin-right: 20px;
		color: #0171BB;
	}

	.preview-item-video {
		height: 350px;
	}

	@media only screen and (max-width: 767.98px) {
		.preview-item-video {
			height: 150px;
		}
	}

	@media only screen and (min-width: 767.98px) and (max-width: 991.98px) {
		.preview-item-video {
			height: 250px;
		}
	}

	.swal2-container.swal2-top>.swal2-popup {
		margin: 25px 0px !important;
	}
	.swal2-html-container.modal-sweetalert {
		text-align: left !important;
	}
	.swal2-html-container .select2-container {
		font-size: 15px !important;
	}

	.container-news-video {
		max-height: 600px;
    	max-width: 100%;
	}

	@media only screen and (max-width: 767.98px) {
		.container-news-video {
			max-height: 250px;
		}
	}

	@media only screen and (min-width: 767.98px) and (max-width: 991.98px) {
		.container-news-video {
			max-height: 350px;
		}
	}

	@media only screen and (min-width: 991.98px) and (max-width: 1540px) {
		.container-news-video {
			max-height: 500px;
		}
	}
</style>
@endsection
@section('content')
	@php
		$images = json_decode($news->images);
		$videos = json_decode($news->videos);
		$files = json_decode($news->files);
		$attachments = [];

		foreach ($images as $key => $value) {
			$attachments[] = [
				'type' => 'image',
				'url' => $value,
			];
		}
		foreach ($videos as $key => $value) {
			$attachments[] = [
				'type' => 'video',
				'url' => $value,
			];
		}

		function gambar($ext) {
			switch ($ext) {
				case 'docx':
					return asset(config('image_file.docx'));
					break;
				case 'doc':
					return asset(config('image_file.doc'));
				case 'pdf':
					return asset(config('image_file.pdf'));
				case 'xls':
					return asset(config('image_file.xls'));
				case 'xlsx':
					return asset(config('image_file.xlsx'));
				case 'ppt':
					return asset(config('image_file.ppt'));
				case 'pptx':
					return asset(config('image_file.pptx'));
				default:
					return asset(config('image_file.docx'));
			}
		}
	@endphp
	<div class="p-4">
		<div class="card mb-4">
			<div class="container-input-user align-items-center">
				<a href="{{ route('news.index') }}" class="fa-solid fa-chevron-left icon-heading"></a>
				<span class="name-heading">News and Announcement</span>
				{{-- <a class="name-heading" href="javascript:history.back()">
					<img src="{{ asset('assets/img/icons/button/back.png') }}" alt="Back" width="15px" height="auto"
				class="me-3">News and Announcement</a> --}}
			</div>
		</div>
		<div class="card container-news p-4 mb-4">
			<div class="d-flex">
				<div class="kiri">
					<img src="@if (isset($news->user->foto))
						{{ asset('storage/user').'/'.$news->user->id.'/'.$news->user->foto }}
					@else
						{{ asset('assets/img/dummy/default-user.png') }}
					@endif" class="rounded-circle" alt="User" width="50" height="50" />
				</div>
				<div class="kanan kanan-fix">
					<div class="row">
						<div class="col">
							<div class="username">{{ $news->user->name }}</div>
							{{-- <div class="tanggal">{{ tgl_indo($news->created_at) }}</div> --}}
							{{-- <div class="tanggal">{{ date_format($news->created_at, 'd F Y H:i:s') }}</div> --}}
							<div class="tanggal">{{ date_format($news->created_at, 'd F Y H:i') }}</div>
						</div>
						@if (Auth::user()->id == $news->created_by)
							<div class="col-auto">
								<div class="btn-group">
									<a href="#" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fa-solid fa-ellipsis option-icon"></i>
									</a>
									<div class="dropdown-menu w-100">
										<a href="javascript:void(0);" class="dropdown-item edit-menu" 
											data-id="{{ $news->id }}" 
											data-title="{{ $news->title }}"
											data-category="{{ $news->category }}"
											data-highlight_status="{{ $news->highlight_status }}"
											data-highlight_image="{{ $news->highlight_image }}"
											data-body_text="{{ $news->isi }}"
											data-images="{{ $news->images }}"
											data-videos="{{ $news->videos }}"
											data-files="{{ $news->files }}"
										>Edit</a>
										<a href="javascript:void(0);" class="dropdown-item delete-menu" 
											data-id="{{ $news->id }}" 
											data-title="{{ $news->title }}" 
										>Delete</a>
									</div>
								</div>
							</div>
						@endif
					</div>
					<div class="title">
						<span>{{ $news->title }}</span>
					</div>
					<div class="isi">
						<span class="isi3">{!! $news->isi !!}</span>
					</div>
					{{-- @if (count($files) > 0)
						<div class="mt-2 d-inline-flex flex-column">
							@foreach ($files as $key => $item)
								<a href="{{ asset('storage/news').'/'.$item }}" class="@if ($key != 0) mt-1 @endif text-break" target="_blank">{{ $item }}</a>
							@endforeach
						</div>
					@endif --}}
					@if (count($files) > 0)
						<div class="d-flex flex-wrap mt-3">
							@foreach ($files as $key => $file)
								@php
									$url = asset('storage/news').'/'.$file;
									$arr = explode(".", $url);
									$ext = end($arr);
								@endphp
								
								<a href="{{ $url }}" class="card-news-file card" target="_blank">
									<div class="card-news-file-content">
										{{-- <img src="{{ asset(config('image_file.'.$ext)) }}" alt="File"> --}}
										<img src="{{ gambar($ext) }}" alt="File">
										<div>
											<div class="name">{{ $file }}</div>
										</div>
									</div>
								</a>
							@endforeach
						</div>
					@endif
					@if (count($attachments) > 0)
						<div id="sliderNews" class="carousel slide sliderCustomDetailNews mt-4" data-bs-ride="carousel">
							<ol class="carousel-indicators">
								@if (count($attachments) > 1)
									@foreach ($attachments as $key => $item)
										@if ($key === 0)
											<li data-bs-target="#sliderNews" data-bs-slide-to="{{ $key }}" class="active"></li>
										@else
											<li data-bs-target="#sliderNews" data-bs-slide-to="{{ $key }}" class=""></li>
										@endif
									@endforeach
								@endif
							</ol>
							<div class="carousel-inner">
								@foreach ($attachments as $key => $item)
									@if ($key === 0)
										<div class="carousel-item active">
											<div class="w-100 d-flex justify-content-center">
												@if ($item['type'] == 'image')
													<img class="img-fluid" src="{{ asset('storage/news').'/'.$item['url'] }}" alt="{{ $key }} slide" />
												@else
													<video controls="controls" src="{{ asset('storage/news').'/'.$item['url'] }}" class="rounded-3 container-news-video" controlsList="nodownload"></video>
												@endif
											</div>
										</div>
									@else
										<div class="carousel-item">
											<div class="w-100 d-flex justify-content-center">
												@if ($item['type'] == 'image')
													<img class="img-fluid" src="{{ asset('storage/news').'/'.$item['url'] }}" alt="{{ $key }} slide" />
												@else
													<video controls="controls" src="{{ asset('storage/news').'/'.$item['url'] }}" class="rounded-3 container-news-video" controlsList="nodownload"></video>
												@endif
											</div>
										</div>
									@endif
								@endforeach
							</div>
							@if (count($attachments) > 1)
								<a class="carousel-control-prev" href="#sliderNews" role="button" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</a>
								<a class="carousel-control-next" href="#sliderNews" role="button" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</a>
							@endif
						</div>
					@endif
					{{-- @if (count($images) > 0)
						<div id="sliderNews" class="carousel slide sliderCustomDetailNews mt-4" data-bs-ride="carousel">
							<ol class="carousel-indicators">
								@if (count($images) > 1)
									@foreach ($images as $key => $item)
										@if ($key === 0)
											<li data-bs-target="#sliderNews" data-bs-slide-to="{{ $key }}" class="active"></li>
										@else
											<li data-bs-target="#sliderNews" data-bs-slide-to="{{ $key }}" class=""></li>
										@endif
									@endforeach
								@endif
							</ol>
							<div class="carousel-inner">
								@foreach ($images as $key => $item)
									@if ($key === 0)
										<div class="carousel-item active">
											<div class="w-100 d-flex justify-content-center">
												<img class="img-fluid" src="{{ asset('storage/news').'/'.$item }}" alt="{{ $key }} slide" />
											</div>
										</div>
									@else
										<div class="carousel-item">
											<div class="w-100 d-flex justify-content-center">
												<img class="img-fluid" src="{{ asset('storage/news').'/'.$item }}" alt="{{ $key }} slide" />
											</div>
										</div>
									@endif
								@endforeach
							</div>
							@if (count($images) > 1)
								<a class="carousel-control-prev" href="#sliderNews" role="button" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</a>
								<a class="carousel-control-next" href="#sliderNews" role="button" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</a>
							@endif
						</div>
					@endif
					@if (count($videos) > 0)
						<div id="sliderNewsVideo" class="carousel slide sliderCustomDetailNews mt-4" data-bs-ride="carousel">
							<ol class="carousel-indicators">
								@if (count($videos) > 1)
									@foreach ($videos as $key => $item)
										@if ($key === 0)
											<li data-bs-target="#sliderNewsVideo" data-bs-slide-to="{{ $key }}" class="active"></li>
										@else
											<li data-bs-target="#sliderNewsVideo" data-bs-slide-to="{{ $key }}" class=""></li>
										@endif
									@endforeach
								@endif
							</ol>
							<div class="carousel-inner">
								@foreach ($videos as $key => $item)
									@if ($key === 0)
										<div class="carousel-item active">
											<div class="d-flex justify-content-center">
												<video controls="controls" src="{{ asset('storage/news').'/'.$item }}" class="rounded-3 container-news-video"></video>
											</div>
										</div>
									@else
										<div class="carousel-item">
											<div class="d-flex justify-content-center">
												<video controls="controls" src="{{ asset('storage/news').'/'.$item }}" class="rounded-3 container-news-video"></video>
											</div>
										</div>
									@endif
								@endforeach
							</div>
							@if (count($videos) > 1)
								<a class="carousel-control-prev" href="#sliderNewsVideo" role="button" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</a>
								<a class="carousel-control-next" href="#sliderNewsVideo" role="button" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</a>
							@endif
						</div>
					@endif --}}
					{{-- @if (count($videos) > 0)
						<div class="mt-4 d-flex overflow-auto pb-3">
							@foreach ($videos as $key => $item)
								<div class="preview-item-video @if ($key != 0) ms-3 @endif" style="">
									<video controls="controls" src="{{ asset('storage/news').'/'.$item }}" class="rounded-3 h-100"></video>
								</div>
							@endforeach
						</div>
					@endif --}}
				</div>
			</div>
		</div>
	</div>
@endsection
@section('vendor-script')
    {{-- <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script> --}}
	<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection
@section('js')
<script>
	var options = {
		extraPlugins: 'autolink',
		filebrowserBrowseUrl: '{{ asset(route('ckfinder_browser')) }}',
		filebrowserImageBrowseUrl: '{{ asset(route('ckfinder_browser')) }}?type=Images',
		filebrowserFlashBrowseUrl: '{{ asset(route('ckfinder_browser')) }}?type=Flash',
		filebrowserUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Flash',
		removeButtons: 'Source,Save,NewPage,DocProps,document,Preview,Print,Templates,Find,Replace,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,CreateDiv,Language,Iframe,Smiley,About,PageBreak,Maximize,ExportPdf,Image,Table,HorizontalRule,Link,Unlink,Anchor,Scayt,ShowBlocks,Styles,Format',
		font_defaultLabel: 'Arial',
		font_names: 'Arial',
	};
	const currentId = '{{ $news->id }}';
	var inputImages = [];
	var inputVideos = [];
	var inputFiles = [];
	var currentImages = [];
	var currentVideos = [];
	var currentFiles = [];
	var deletedImages = [];
	var deletedVideos = [];
	var deletedFiles = [];
	var currentHighlightImage = "{{ $news->highlight_image }}";

	$(document).ready(function() {
		$('.edit-menu').click(function() {
			inputImages = [];
			inputVideos = [];
			inputFiles = [];
			currentImages = [];
			currentVideos = [];
			currentFiles = [];
			deletedImages = [];
			deletedVideos = [];
			deletedFiles = [];

			const id = $(this).data('id');
			const title = $(this).data('title');
			const category = $(this).data('category');
			const highlight_status = $(this).data('highlight_status');
			const highlight_image = $(this).data('highlight_image');
			const body_text = $(this).data('body_text');
			const images = $(this).data('images');
			const videos = $(this).data('videos');
			const files = $(this).data('files');

			images.forEach((element, index) => {
				var src = "{{ asset('storage/news').'/' }}";

				src = src+element;
				currentImages.unshift({
					key: images.length+'-'+(Math.floor(Math.random() * 1000000000)),
					src: src,
					fileName: element,
				});
			});
			videos.forEach((element, index) => {
				var src = "{{ asset('storage/news').'/' }}";

				src = src+element;
				currentVideos.unshift({
					key: videos.length+'-'+(Math.floor(Math.random() * 1000000000)),
					src: src,
					fileName: element,
				});
			});
			files.forEach((element, index) => {
				var src = "{{ asset('storage/news').'/' }}";

				src = src+element;
				currentFiles.unshift({
					key: files.length+'-'+(Math.floor(Math.random() * 1000000000)),
					src: src,
					fileName: element,
				});
			});

			if (highlight_status == 1) {
				display = 'block';
			} else {
				display = 'none';
			}

			Swal.fire({
				title: `<div class="d-flex justify-content-start">
					<h5 class="title-custom-primary">Edit News and Announcement</h5>
				</div>`,
				html: `<form>
					<div class="mb-3">
						<label for="title" class="form-label d-flex">Title</label>
						<input type="text" class="form-control" name="title" id="title" value="${title}" />
						<div class="invalid-feedback d-block invalid">
							<div id="title_invalid-feedback"></div>
						</div>
					</div>
					<div class="mb-3">
						<label for="category" class="form-label d-flex">Category</label>
						<select name="category" id="category" class="select2 form-select">
							<option value="">Pilih Category</option>
							<option value="news" ${category == 'news' ? 'selected' : ''}>News</option>
							<option value="announcement" ${category == 'announcement' ? 'selected' : ''}>Announcement</option>
						</select>
						<div class="invalid-feedback d-block invalid">
							<div id="category_invalid-feedback"></div>
						</div>
					</div>
					<div class="mb-3">
						<div class="form-check mt-3">
							<input class="form-check-input" type="checkbox" value="1" id="highlight_status" name="highlight_status" ${highlight_status==1 ? 'checked' : '' } />
							<label class="form-check-label" for="highlight_status" style="font-size: 15px;">Set as Highlight</label>
						</div>
					</div>
					<div class="mb-3" id="container-highlight_foto" style="display: ${display};">
						<label for="highlight_image" class="form-label">Highlight Image</label>
						<input type="file" name="highlight_image" class="form-control" id="highlight_image" accept="image/*" />
						<small class="small-rule-swal2">The highlight image minimum dimensions width 1025 and height 400, the size of highlight image must be less than 10 MB</small>
						<div class="invalid-feedback d-block invalid">
							<div id="highlight_image_invalid-feedback"></div>
						</div>
						<div class="preview-attachments d-flex" id="preview-highlight_image"></div>
					</div>
					<div class="mb-3">
						<label for="body_text" class="form-label d-flex">Body Text</label>
						<textarea name="body_text" id="body_text">${body_text}</textarea>
					</div>
					<div class="">
						<label for="images" class="form-label">Images</label>
						<input type="file" name="images" class="form-control" id="images" accept="image/*" multiple />
						<small class="small-rule-swal2">The total size of images must be less than 10 MB</small>
						<div class="invalid-feedback d-block invalid">
							<div id="images_invalid-feedback"></div>
						</div>
						<div class="preview-attachments d-flex pb-3" id="preview-images"></div>
					</div>
					<div class="">
						<label for="videos" class="form-label">Videos</label>
						<input class="form-control" name="videos" id="videos" type="file" accept="video/mp4,video/mpeg,video/x-m4v,video/mov,video/*" multiple />
						<small class="small-rule-swal2">The total size of videos must be less than 40 MB</small>
						<div class="invalid-feedback d-block invalid">
							<div id="videos_invalid-feedback"></div>
						</div>
						<div class="preview-attachments d-flex pb-3" id="preview-videos"></div>
					</div>
					<div class="">
						<label for="files" class="form-label">Files</label>
						<input type="file" class="form-control" name="files" id="files" multiple accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
						<small class="small-rule-swal2">The total size of files must be less than 20 MB</small>
						<div class="invalid-feedback d-block invalid">
							<div id="files_invalid-feedback"></div>
						</div>
						<div class="preview-attachments" id="preview-files"></div>
					</div>
				</form>`,
				showCancelButton: true,
				position: 'top',
				confirmButtonText: 'Submit',
				showLoaderOnConfirm: false,
				allowOutsideClick: false,
				width: '45em',
				focusConfirm: false,
				customClass: {
					htmlContainer: 'modal-sweetalert',
					header: 'mb-5',
					confirmButton: 'btn btn-custom-primary me-1 btn-submit',
					cancelButton: 'btn btn-custom-danger ms-1',
					actions: 'd-flex justify-content-start mx-4 mt-3 mb-0',
				},
				showClass: {
					popup: 'animate__animated animate__zoomIn animate__faster'
				},
				hideClass: {
					popup: 'animate__animated animate__zoomOut animate__faster'
				},
				buttonsStyling: false,
				preConfirm: async (login) => {
					if (await formSubmitUpdate()) {
						return true;
					} else {
						return false;
					}
				},
				didOpen: () => {
					const select2 = $('.select2');

					if (select2.length) {
						select2.each(function () {
							var $this = $(this);
							$this.wrap('<div class="position-relative"></div>').select2({
								minimumResultsForSearch: -1,
								allowClear: true,
								placeholder: '',
								dropdownParent: $this.parent().parent()
							});
						});
					}

					if (highlight_image) {
						var src = "{{ asset('storage/news').'/' }}";
						src = src+highlight_image;

						$('#preview-highlight_image').html(`
							<div class="container-attachment mt-2" id="ca-highlight_image">
								<img src="${src}" class="item-image">
							</div>
						`);
					}

					CKEDITOR.replace('body_text', options);
					currentImages.forEach((element, index) => {
						let pad = '';

						if (index !== 0) {
							pad = 'me-2'
						}

						$('#preview-images').prepend(`
							<div class="container-attachment mt-2 ${pad}" id="ca-current_image-${element.key}">
								<img src="${element.src}" class="item-image">
								<a href="#" class="avatar avatar-xs close col-close remove-attachment-current_image" data-key="${element.key}">
									<span class="avatar-initial rounded-circle fill">
										<i class="fas fa-xmark"></i>
									</span>
								</a>
							</div>
						`);
					});
					currentVideos.forEach((element, index) => {
						let pad = '';

						if (index !== 0) {
							pad = 'me-2'
						}

						$('#preview-videos').prepend(`
							<div class="container-attachment mt-2 ${pad}" id="ca-current_video-${element.key}">
								<video controls="controls" src="${element.src}" class="item-video"></video>
								<a href="#" class="avatar avatar-xs close remove-attachment-current_video" data-key="${element.key}">
									<span class="avatar-initial rounded-circle fill">
										<i class="fas fa-xmark"></i>
									</span>
								</a>
							</div>
						`);
					});
					currentFiles.forEach((element, index) => {
						$('#preview-files').prepend(`
							<div class="container-attachment w-100 mt-2 d-flex align-items-center" id="ca-current_file-${element.key}">
								<span class="filename me-3">${element.fileName}</span>
								<a href="#" class="avatar avatar-xs row-close ms-auto remove-attachment-current_file" data-key="${element.key}">
									<span class="avatar-initial rounded-circle fill">
										<i class="fas fa-xmark"></i>
									</span>
								</a>
							</div>
						`);
					});
				},
				didClose: async () => {
					inputImages = [];
					inputVideos = [];
					inputFiles = [];
					currentImages = [];
					currentVideos = [];
					currentFiles = [];
					deletedImages = [];
					deletedVideos = [];
					deletedFiles = [];
				}
			}).then((result) => {
				if (result.isConfirmed) {
					
				}
			});
		});
	});

	$(document).on('input', '#title', function() {
		$(this).removeClass('invalid');
		$(`#${this.id}_invalid-feedback`).html('');
	});
	
	$(document).on('select2:select', '#category', function() {
		$(this).removeClass('invalid');
		$(`#${this.id}_invalid-feedback`).html('');
	});

	$(document).on('change', '#highlight_status', function() {
		const checked = $(this).is(':checked'); 
		
		if (checked) {
			$('#container-highlight_foto').show();
		} else {
			$('#container-highlight_foto').hide();
		}
	});

	$(document).on('change', '#highlight_image', function() {
		$(this).removeClass('invalid');
		$(`#${this.id}_invalid-feedback`).html('');

		const $this = $(this)[0];

		if ($this.files.length > 0) {
			if (($this.files[0].size/1024) > (10*1024)) {
				$('#highlight_image').addClass('invalid');
				$('#highlight_image_invalid-feedback').html('The size of highlight image must be less than 10 MB');
				$('#highlight_image').val('');

				toastr.options = {
					positionClass: "toast-center-center",
				}
				toastr['error']('', 'The size of highlight image must be less than 10 MB',);

				return;
			}

			$('#preview-highlight_image').empty();

			var reader = new FileReader();
			var closeHtml = ``;

			if (currentHighlightImage) {
				closeHtml = `<a href="#" class="avatar avatar-xs close col-close remove-attachment-highlight_image">
					<span class="avatar-initial rounded-circle fill">
						<i class="fas fa-xmark"></i>
					</span>
				</a>`
			}

			reader.onload = async function(event) {
				$('#preview-highlight_image').html(`
					<div class="container-attachment mt-2" id="ca-highlight_image">
						<img src="${event.target.result}" class="item-image">
						${closeHtml}
					</div>
				`);
			}
			reader.readAsDataURL($this.files[0]);
		}
	});

	$(document).on('click', '.remove-attachment-highlight_image', function(e) {
		e.preventDefault();

		if (!currentHighlightImage) {
			$('#ca-highlight_image').remove();
		} else {
			var src = "{{ asset('storage/news').'/' }}";

			src = src+currentHighlightImage;
			
			$('#preview-highlight_image').html(`
				<div class="container-attachment mt-2" id="ca-highlight_image">
					<img src="${src}" class="item-image">
				</div>
			`);
			// <a href="#" class="avatar avatar-xs close col-close remove-attachment-highlight_image">
			// 	<span class="avatar-initial rounded-circle fill">
			// 		<i class="fas fa-xmark"></i>
			// 	</span>
			// </a>
		}

		$('#highlight_image').val('');
	});

	$(document).on('change', '#images', async function() {
		$(this).removeClass('invalid');
		$(`#${this.id}_invalid-feedback`).html('');

		const $this = $(this)[0];
		var promises = [];
		var temps = [];
		var filesSize = 0;

		for (let i = 0; i < inputImages.length; i++) {
			filesSize += inputImages[i].image.size;
		}

		for (let i = 0; i < $this.files.length; i++) {
			filesSize += $this.files[i].size;
		}

		if ((filesSize/1024) > (10*1024)) {
			$('#images').addClass('invalid');
			$('#images_invalid-feedback').html('The total size of images must be less than 10 MB');
			$('#images').val('');

			toastr.options = {
				positionClass: "toast-center-center",
			}
			toastr['error']('', 'The total size of images must be less than 10 MB',);

			return;
		}

		for (var i = $this.files.length-1; i >= 0; i--) {
			var key = inputImages.length+'-'+(Math.floor(Math.random() * 1000000000));

			inputImages.unshift({
				key: key,
				image: $this.files[i],
			});
			temps.unshift({
				key: key,
				image: $this.files[i],
			});
			promises.push(new Promise(function(resolve, reject) {
				var reader = new FileReader();

				reader.onload = async function(event) {
					resolve(event);
				}
				reader.readAsDataURL($this.files[i]);
			}));
		}

		var results = await Promise.all(promises);

		for (let i = 0; i < results.length; i++) {
			let pad = '';

			if ($('#preview-images').children().length > 0) {
				pad = 'me-2';
			}

			$('#preview-images').prepend(`
				<div class="container-attachment mt-2 ${pad}" id="ca-image-${temps[i].key}">
					<img src="${results[i].target.result}" class="item-image">
					<a href="#" class="avatar avatar-xs close col-close remove-attachment-image" data-key="${temps[i].key}">
						<span class="avatar-initial rounded-circle fill">
							<i class="fas fa-xmark"></i>
						</span>
					</a>
				</div>
			`);
		}

		$(this).val('');
	});

	$(document).on('change', '#videos', async function() {
		$(this).removeClass('invalid');
		$(`#${this.id}_invalid-feedback`).html('');

		var $this = $(this)[0];
		var promises = [];
		var temps = [];
		var filesSize = 0;

		for (let i = 0; i < inputVideos.length; i++) {
			filesSize += inputVideos[i].video.size;
		}

		for (let i = 0; i < $this.files.length; i++) {
			filesSize += $this.files[i].size;
		}

		if ((inputVideos.length + $this.files.length) > 2) {
			$('#videos').addClass('invalid');
			$('#videos_invalid-feedback').html('The number of videos must be less than 3');
			$('#videos').val('');

			toastr.options = {
				positionClass: "toast-center-center",
			}
			toastr['error']('', 'The number of videos must be less than 3',);

			return;
		}

		if ((filesSize/1024) > (40*1024)) {
			$('#videos').addClass('invalid');
			$('#videos_invalid-feedback').html('The total size of videos must be less than 40 MB');
			$('#videos').val('');

			toastr.options = {
				positionClass: "toast-center-center",
			}
			toastr['error']('', 'The total size of videos must be less than 40 MB',);

			return;
		}

		for (var i = $this.files.length-1; i >= 0; i--) {
			var key = inputVideos.length+'-'+(Math.floor(Math.random() * 1000000000)); 
			var src = URL.createObjectURL($this.files[i]);
			
			inputVideos.unshift({
				key: key,
				video: $this.files[i],
				src: src,
			});
			temps.unshift({
				key: key,
				video: $this.files[i],
				src: src,
			});
		}

		for (let i = 0; i < temps.length; i++) {
			let pad = '';

			if ($('#preview-videos').children().length > 0) {
				pad = 'me-2';
			}

			$('#preview-videos').prepend(`
				<div class="container-attachment mt-2 ${pad}" id="ca-video-${temps[i].key}">
					<video controls="controls" src="${temps[i].src}" class="item-video"></video>
					<a href="#" class="avatar avatar-xs close remove-attachment-video" data-key="${temps[i].key}">
						<span class="avatar-initial rounded-circle fill">
							<i class="fas fa-xmark"></i>
						</span>
					</a>
				</div>
			`);
		}

		$(this).val('');
	});

	$(document).on('change', '#files', async function() {
		$(this).removeClass('invalid');
		$(`#${this.id}_invalid-feedback`).html('');

		var $this = $(this)[0];
		var promises = [];
		var temps = [];
		var filesSize = 0;

		for (let i = 0; i < inputFiles.length; i++) {
			filesSize += inputFiles[i].file.size;
		}

		for (let i = 0; i < $this.files.length; i++) {
			filesSize += $this.files[i].size;
		}

		if ((filesSize/1024) > (20*1024)) {
			$('#files').addClass('invalid');
			$('#files_invalid-feedback').html('The total size of files must be less than 20 MB');
			$('#files').val('');

			toastr.options = {
				positionClass: "toast-center-center",
			}
			toastr['error']('', 'The total size of files must be less than 20 MB',);

			return;
		}

		for (var i = $this.files.length-1; i >= 0; i--) {
			var key = inputFiles.length+'-'+(Math.floor(Math.random() * 1000000000)); 
			var src = URL.createObjectURL($this.files[i]);
			
			inputFiles.unshift({
				key: key,
				file: $this.files[i],
			});
			temps.unshift({
				key: key,
				file: $this.files[i],
			});
		}

		for (let i = 0; i < temps.length; i++) {
			$('#preview-files').prepend(`
				<div class="container-attachment w-100 mt-2 d-flex align-items-center" id="ca-file-${temps[i].key}">
					<span class="filename me-3">${temps[i].file.name}</span>
					<a href="#" class="avatar avatar-xs row-close ms-auto remove-attachment-file" data-key="${temps[i].key}">
						<span class="avatar-initial rounded-circle fill">
							<i class="fas fa-xmark"></i>
						</span>
					</a>
				</div>
			`);
		}

		$(this).val('');
	});

	$(document).on('click', '.remove-attachment-image', function(e) {
		e.preventDefault();

		const key = $(this).data('key');
		const idx = inputImages.findIndex((e) => e.key === key);

		if (idx >= 0) {
			$(`#ca-image-${key}`).remove();
			inputImages.splice(idx, 1);
		}
	});

	$(document).on('click', '.remove-attachment-video', function(e) {
		e.preventDefault();

		const key = $(this).data('key');
		const idx = inputVideos.findIndex((e) => e.key === key);

		if (idx >= 0) {
			$(`#ca-video-${key}`).remove();
			inputVideos.splice(idx, 1);
		}
	});

	$(document).on('click', '.remove-attachment-file', function(e) {
		e.preventDefault();

		const key = $(this).data('key');
		const idx = inputFiles.findIndex((e) => e.key === key);

		if (idx >= 0) {
			$(`#ca-file-${key}`).remove();
			inputFiles.splice(idx, 1);
		}
	});

	$(document).on('click', '.remove-attachment-current_image', function(e) {
		e.preventDefault();

		const key = $(this).data('key');
		const idx = currentImages.findIndex((e) => e.key === key);

		if (idx >= 0) {
			deletedImages.push(currentImages[idx]);
			$(`#ca-current_image-${key}`).remove();
			currentImages.splice(idx, 1);
		}
	});

	$(document).on('click', '.remove-attachment-current_video', function(e) {
		e.preventDefault();

		const key = $(this).data('key');
		const idx = currentVideos.findIndex((e) => e.key === key);

		if (idx >= 0) {
			deletedVideos.push(currentVideos[idx]);
			$(`#ca-current_video-${key}`).remove();
			currentVideos.splice(idx, 1);
		}
	});

	$(document).on('click', '.remove-attachment-current_file', function(e) {
		e.preventDefault();

		const key = $(this).data('key');
		const idx = currentFiles.findIndex((e) => e.key === key);

		if (idx >= 0) {
			deletedFiles.push(currentFiles[idx]);
			$(`#ca-current_file-${key}`).remove();
			currentFiles.splice(idx, 1);
		}
	});

	$('.delete-menu').click(function() {
		const id = $(this).data('id');
		let url = "{{ route('news.destroy', ':id') }}";
		
		url = url.replace(':id', id);

		Swal.fire({
			// title: 'Ada yakin akan menghapus news/announcement ' + $(this).data('title'),
			title: 'Are you sure to delete this news/announcement?',
			icon: 'warning',
			showDenyButton: true,
			showConfirmButton: false,
			showCancelButton: true,
			denyButtonText: `Delete`,
			customClass: {
				title: 'swal2-title-custom'
			}
		}).then((result) => {
			if (result.isDenied) {
				$.ajax({
					type: 'DELETE',
					url: url,
					data: {
						_token: '{{ csrf_token() }}',
					},
					beforeSend: function() {
					},
					success: function(response) {
						const meta = response.meta;
						
						if (meta.status === 'success') {
							Swal.fire(
								'Success',
								meta.message,
								'success'
							).then((result) => {
								window.location.href = "{{ route('news.index') }}";
							});
						} else {
							Swal.fire(
								'Fail',
								meta.message,
								'error'
							);
						}
					},
					error: function(error) {
					}
				});
			}
		})
	});

	$(document).on('click', 'body .container-isi .isi2 a', function(e) {
		e.preventDefault();

		var attr = $(this).attr('target');
		var url = $(this).attr('href');

		if (!attr) {
			window.open(url, '_blank');
		} else {
			window.location = url;
		}
	});

	async function formSubmitUpdate() {
		$('input').removeClass('invalid');
		$('select').removeClass('invalid');
		$('.invalid-feedback div').html('');
		
		var formData = new FormData();
		var hightlight = $('input[name="highlight_status"]:checked').val();

		if (hightlight != 1) {
			hightlight = 0;
		} else {
			const file = $('#highlight_image').prop('files');

			if (file.length > 0) {
				formData.set('highlight_image', file[0]);
			}
		}

		formData.set('_token', '{{ csrf_token() }}');
		formData.set('title', $('#title').val());
		formData.set('category', $('#category').val());
		formData.set('highlight_status', hightlight);
		formData.set('body_text', CKEDITOR.instances.body_text.getData());

		for (var i = inputImages.length-1; i >= 0; i--) {
			formData.append('images[]', inputImages[i].image);
		}
		for (var i = inputVideos.length-1; i >= 0; i--) {
			formData.append('videos[]', inputVideos[i].video);
		}
		for (var i = inputFiles.length-1; i >= 0; i--) {
			formData.append('files[]', inputFiles[i].file);
		}
		for (var i = deletedImages.length-1; i >= 0; i--) {
			formData.append('deleted_images[]', deletedImages[i].fileName);
		}
		for (var i = deletedVideos.length-1; i >= 0; i--) {
			formData.append('deleted_videos[]', deletedVideos[i].fileName);
		}
		for (var i = deletedFiles.length-1; i >= 0; i--) {
			formData.append('deleted_files[]', deletedFiles[i].fileName);
		}

		function ajax() { 
			return new Promise(function(resolve, reject) {
				var url = "{{ route('news.update', ':id') }}";

				url = url.replace(':id', currentId);

				$.ajax({
					url: url,
					method: 'POST',
					data: formData,
					contentType: false,
					cache: false,
					processData: false,
					dataType: 'json',
					beforeSend: function() {
					},
					success: function(response) {
						const meta = response.meta;

						if (response.meta.status === 'success') {
							resolve(response);
						} else {
							reject(response);
						}
					},
					error: function(error) {
						reject(error);
					},
				});
			});
		}

		return ajax()
			.then((response) => {
				const meta = response.meta;

				Swal.fire(
					'Success',
					meta.message,
					'success'
				).then((result) => {
					if (result.isConfirmed) {
						window.location.reload();
					}
				});

				return true;
			})
			.catch((error) => {
				const data = JSON.parse(error.responseText);

				if (data.errors) {
					var idx = 0;

					$.each(data.errors, function(key, value) {
						$('#' + key.split('.')[0]).addClass('invalid');
						$('#' + key.split('.')[0] + '_invalid-feedback').html(value.join(' '));
						
						if (idx == 0) {
							$('#' + key.split('.')[0]).focus();
						}

						idx++;
					});
				} else {
					Swal.fire(
						'Fail',
						error.responseJSON.message,
						'error'
					);
				}
				
				return false;
			});
	}
</script>
@endsection
