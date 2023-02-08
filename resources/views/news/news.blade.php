@extends('layouts.app')

@section('title', 'News & Announcement')

@section('vendor-style')
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
@endsection
@section('css')
	<style>
		.container-news .kanan .username {}

		.container-news .kanan .tanggal {}

		.container-news .kanan .title {}

		.container-news .kanan .isi {
			/* display: block;
																																																		text-overflow: ellipsis;
																																																		word-wrap: break-word;
																																																		overflow: hidden;
																																																		max-height: 36px;
																																																		line-height: 18px;
																																																		color: #757575;
																																																		font-size: 15px; */
		}

		.container-news .kanan .isi2 {}

		.container-news .kanan .isi2 p {
			/* line-height: unset; */
		}

		.container-news .kanan .seemore {}

		.container-news .kanan .option-icon {}

		.swal2-show {
			/* height: calc(100% - 12rem); */
		}

		.swal2-container {
			overflow-x: unset !important;
			/* overflow-y: unset !important; */
		}

		.swal2-container.swal2-top>.swal2-popup {
			margin: 25px 0px !important;
		}

		.swal2-html-container {
			overflow: auto;
			margin: 0 !important;
			padding: 1em 1.6em 0.3em !important;
		}

		.swal2-html-container.modal-sweetalert {
			text-align: left !important;
		}

		.swal2-html-container .select2-container {
			font-size: 15px !important;
		}

		.title-custom-primary {
			color: #0171BB;
		}
	</style>
@endsection
@section('content')
	<div class="p-4">
		<div class="col-12 mb-3">
			<div id="sliderNewsTopBanner" class="carousel slide sliderCustomTopBanner bg-custom-primary" data-bs-ride="carousel"
				data-bs-interval="false">
				<div class="carousel-inner carousel-inner-custom-top_banner">
					<div class="carousel-item active">
						<a href="#" class="w-100 d-flex justify-content-center">
							<img class="d-block" src="{{ asset('storage/top_banner/' . \config('config_page.top_banner_news')) }}"
								alt="slide" />
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="card mb-4">
			<div class="row container-input-user gy-3">
				<div class="col-12 col-md-10 align-self-center">
					<span class="name-heading">News and Announcement</span>
				</div>
				<div class="col-12 col-md-2 d-grid">
					<button id="btn-add_data" class="btn btn-custom-primary">Add New</button>
				</div>
			</div>
		</div>
		<div id="news-card-list"></div>
		<div class="isLoading" style="height: 50px;display: none;"></div>
		{{-- @foreach ($news as $key => $value)
			<div class="card container-news p-4 mb-4">
				<div class="row">
					<div class="col-xl-12 col-sm-12">
						<div class="d-flex">
							<div class="kiri">
								<img src="{{ asset('assets/img/users/ellipse.png') }}" alt="User" width="50" height="50">
							</div>
							<div class="kanan w-100">
								<div class="row">
									<div class="col">
										<div class="username">{{ $value->user->name }}</div>
										<div class="tanggal">{{ tgl_indo($value->created_at) }}</div>
									</div>
									@if (Auth::user()->id == $value->user_id)
										<div class="col-auto">
											<div class="btn-group">
												<a href="#" data-bs-toggle="dropdown" aria-expanded="false">
													<i class="fa-solid fa-ellipsis option-icon"></i>
												</a>
												<div class="dropdown-menu w-100">
													<a href="#0" class="dropdown-item edit-menu" data-id="{{ $value->id }}"
														data-title="{{ $value->title }}" data-category="{{ $value->category }}"
														data-highlight_status="{{ $value->highlight_status }}" data-images="{{ $value->images }}"
														data-videos="{{ $value->videos }}" data-files="{{ $value->files }}"
														data-isi="{{ $value->isi }}">Edit</a>
												</div>
											</div>
										</div>
									@endif
								</div>
								<div class="title d-flex flex-wrap pe-4">
									<span>{{ $value->title }}</span>
								</div>
								<div class="isi d-flex flex-wrap pe-4">
									<span>{!! penjelasan_singkat($value->isi, 500) !!}</span>
								</div>
								<div class="seemore">
									<a class="d-block" href="{{ route('admin.news.detail', $value->id) }}">See more...</a>
								</div>
								@php
									$images = json_decode($value->images);
								@endphp
								@if (count($images) > 0)
									<div>
										<img src="{{ asset('storage/news') . '/' . $images[0] }}" alt="Gambar" width="auto" height="100px">
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach --}}
	</div>

	<!-- Add Deparment Modal -->
	{{-- <div class="modal fade" id="modal_news" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
			<div class="modal-content p-3 p-md-5">
				<div class="modal-body pt-0">
					<div class="mb-4">
						<h3><span class="title-modal">Tambah Data News</span></h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="form-line_business" class="row g-3">
						<input type="hidden" name="line_business_id" id="line_business_id">
						<div class="col-12">
							<label for="title" class="form-label">Title</label>
							<input type="text" class="form-control" name="title" id="title" />
							<div class="invalid-feedback d-block invalid">
								<div id="title_invalid-feedback"></div>
							</div>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="body">Body</label>
							<textarea class="form-control" id="body" name="body" rows="10"></textarea>
						</div>
						<div class="col-12 text-center mt-4">
							<button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
								aria-label="Close">Cancel</button>
							<button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div> --}}
	<!--/ Add Deparment Modal -->
@endsection
@section('vendor-script')
	{{-- <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script> --}}
	<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
	<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
	<script src="{{ asset('assets/js/extended-ui-blockui.js') }}"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
@section('js')
	<script>
		// moment.locale('id');
		var currentPage = 1;
		var lastPage = 1;
		var loading = false;

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
		var inputImages = [];
		var inputVideos = [];
		var inputFiles = [];
		var currentId = '';
		var currentImages = [];
		var currentVideos = [];
		var currentFiles = [];
		var deletedImages = [];
		var deletedVideos = [];
		var deletedFiles = [];
		var currentHighlightImage = '';

		$(document).ready(function() {
			// getNews();
			getNewsPagination(currentPage);

			$('#btn-add_data').click(function() {
				inputImages = [];
				inputVideos = [];
				inputFiles = [];

				Swal.fire({
					title: `<div class="d-flex justify-content-start">
						<h5 class="title-custom-primary">Create News and Announcement</h5>
					</div>`,
					html: `<form>
						<div class="mb-3">
							<label for="title" class="form-label d-flex">Title</label>
							<input type="text" class="form-control" name="title" id="title" />
							<div class="invalid-feedback d-block invalid">
								<div id="title_invalid-feedback"></div>
							</div>
						</div>
						<div class="mb-3">
							<label for="category" class="form-label d-flex">Category</label>
							<select name="category" id="category" class="select2 form-select">
								<option value="">Pilih Category</option>
								<option value="news">News</option>
								<option value="announcement">Announcement</option>
							</select>
							<div class="invalid-feedback d-block invalid">
								<div id="category_invalid-feedback"></div>
							</div>
						</div>
						<div class="mb-3">
							<div class="form-check mt-3">
								<input class="form-check-input" type="checkbox" value="1" id="highlight_status" name="highlight_status" />
								<label class="form-check-label" for="highlight_status" style="font-size: 15px;">Set as Highlight</label>
							</div>
						</div>
						<div class="mb-3" id="container-highlight_foto" style="display: none;">
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
							<textarea name="body_text" id="body_text"></textarea>
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
						if (await formSubmitStore()) {
							return true;
						} else {
							return false;
						}
					},
					didOpen: () => {
						const select2 = $('.select2');

						if (select2.length) {
							select2.each(function() {
								var $this = $(this);
								$this.wrap('<div class="position-relative"></div>')
									.select2({
										minimumResultsForSearch: -1,
										allowClear: true,
										placeholder: '',
										dropdownParent: $this.parent().parent()
									});
							});
						}

						CKEDITOR.replace('body_text', options);
					},
					didClose: async () => {
						inputImages = [];
						inputVideos = [];
						inputFiles = [];
					}
				}).then((result) => {
					if (result.isConfirmed) {

					}
				});
			});

			$(window).scroll(function() {
				const windScrollTop = $(window).scrollTop();
				const docHeight = $(document).height();
				const windHeight = $(window).height();

				// console.log(windScrollTop+10, (docHeight - windHeight), currentPage, lastPage, loading);
				if ((windScrollTop + 10) >= (docHeight - windHeight) && currentPage < lastPage && !loading) {
					getNewsPagination(currentPage + 1);
				}
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
				if (($this.files[0].size / 1024) > (10 * 1024)) {
					$('#highlight_image').addClass('invalid');
					$('#highlight_image_invalid-feedback').html('The size of highlight image must be less than 10 MB');
					$('#highlight_image').val('');

					toastr.options = {
						positionClass: "toast-center-center",
					}
					toastr['error']('', 'The size of highlight image must be less than 10 MB', );

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

			if ((filesSize / 1024) > (10 * 1024)) {
				$('#images').addClass('invalid');
				$('#images_invalid-feedback').html('The total size of images must be less than 10 MB');
				$('#images').val('');

				toastr.options = {
					positionClass: "toast-center-center",
				}
				toastr['error']('', 'The total size of images must be less than 10 MB', );

				return;
			}

			for (var i = $this.files.length - 1; i >= 0; i--) {
				var key = inputImages.length + '-' + (Math.floor(Math.random() * 1000000000));

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

		$(document).on('click', '.remove-attachment-image', function(e) {
			e.preventDefault();

			const key = $(this).data('key');
			const idx = inputImages.findIndex((e) => e.key === key);

			if (idx >= 0) {
				$(`#ca-image-${key}`).remove();
				inputImages.splice(idx, 1);
			}
		});

		$(document).on('click', '.remove-attachment-highlight_image', function(e) {
			e.preventDefault();

			if (!currentHighlightImage) {
				$('#ca-highlight_image').remove();
			} else {
				var src = "{{ asset('storage/news') . '/' }}";

				src = src + currentHighlightImage;

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
				toastr['error']('', 'The number of videos must be less than 3', );

				return;
			}

			if ((filesSize / 1024) > (40 * 1024)) {
				$('#videos').addClass('invalid');
				$('#videos_invalid-feedback').html('The total size of videos must be less than 40 MB');
				$('#videos').val('');

				toastr.options = {
					positionClass: "toast-center-center",
				}
				toastr['error']('', 'The total size of videos must be less than 40 MB', );

				return;
			}

			for (var i = $this.files.length - 1; i >= 0; i--) {
				var key = inputVideos.length + '-' + (Math.floor(Math.random() * 1000000000));
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

		$(document).on('click', '.remove-attachment-video', function(e) {
			e.preventDefault();

			const key = $(this).data('key');
			const idx = inputVideos.findIndex((e) => e.key === key);

			if (idx >= 0) {
				$(`#ca-video-${key}`).remove();
				inputVideos.splice(idx, 1);
			}
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

			if ((filesSize / 1024) > (20 * 1024)) {
				$('#files').addClass('invalid');
				$('#files_invalid-feedback').html('The total size of files must be less than 20 MB');
				$('#files').val('');

				toastr.options = {
					positionClass: "toast-center-center",
				}
				toastr['error']('', 'The total size of files must be less than 20 MB', );

				return;
			}

			for (var i = $this.files.length - 1; i >= 0; i--) {
				var key = inputFiles.length + '-' + (Math.floor(Math.random() * 1000000000));
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

		$(document).on('click', '.remove-attachment-file', function(e) {
			e.preventDefault();

			const key = $(this).data('key');
			const idx = inputFiles.findIndex((e) => e.key === key);

			if (idx >= 0) {
				$(`#ca-file-${key}`).remove();
				inputFiles.splice(idx, 1);
			}
		});

		$(document).on('click', '.edit-menu', function(e) {
			inputImages = [];
			inputVideos = [];
			inputFiles = [];
			currentId = '';
			currentImages = [];
			currentVideos = [];
			currentFiles = [];
			deletedImages = [];
			deletedVideos = [];
			deletedFiles = [];
			currentHighlightImage = '';

			const id = $(this).data('id');
			const title = $(this).data('title');
			const category = $(this).data('category');
			const highlight_status = $(this).data('highlight_status');
			const highlight_image = $(this).data('highlight_image');
			const body_text = $(this).data('body_text');
			const images = $(this).data('images');
			const videos = $(this).data('videos');
			const files = $(this).data('files');
			var display = '';

			currentId = id;
			currentHighlightImage = highlight_image;
			images.forEach((element, index) => {
				var src = "{{ asset('storage/news') . '/' }}";

				src = src + element;
				currentImages.unshift({
					key: images.length + '-' + (Math.floor(Math.random() * 1000000000)),
					src: src,
					fileName: element,
				});
			});
			videos.forEach((element, index) => {
				var src = "{{ asset('storage/news') . '/' }}";

				src = src + element;
				currentVideos.unshift({
					key: videos.length + '-' + (Math.floor(Math.random() * 1000000000)),
					src: src,
					fileName: element,
				});
			});
			files.forEach((element, index) => {
				var src = "{{ asset('storage/news') . '/' }}";

				src = src + element;
				currentFiles.unshift({
					key: files.length + '-' + (Math.floor(Math.random() * 1000000000)),
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
						<small class="small-rule-swal2">The highlight image minimum dimensions width 1025 and height 400</small>
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
						select2.each(function() {
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
						var src = "{{ asset('storage/news') . '/' }}";
						src = src + highlight_image;

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
					currentId = '';
					currentImages = [];
					currentVideos = [];
					currentFiles = [];
					deletedImages = [];
					deletedVideos = [];
					deletedFiles = [];
					currentHighlightImage = '';
				}
			}).then((result) => {
				if (result.isConfirmed) {

				}
			});
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

		$(document).on('click', '.delete-menu', function() {
			const id = $(this).data('id');
			let url = "{{ route('admin.news.destroy', ':id') }}";

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
						beforeSend: function() {},
						success: function(response) {
							const meta = response.meta;

							if (meta.status === 'success') {
								Swal.fire(
									'Success',
									meta.message,
									'success'
								);
								// getNews();

								if ($(`#news-${id}`).length > 0) {
									$(`#news-${id}`).remove();
								}
							} else {
								Swal.fire(
									'Fail',
									meta.message,
									'error'
								);
							}
						},
						error: function(error) {}
					});
				}
			})
		});

		$(document).on('click', 'body .container-isi .isi2 a', function(e) {
			e.preventDefault();

			var attr = $(this).attr('target');
			var url = $(this).attr('href');

			if (!attr || attr === '_blank') {
				window.open(url, '_blank');
			} else {
				window.location = url;
			}
		});

		function showLoading() {
			$('.isLoading').show();
			$('.isLoading').block({
				message: '<div class="d-flex justify-content-center"><p class="mb-0">Please wait...</p> <div class="sk-wave m-0"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
				// timeout: 1000,
				css: {
					backgroundColor: 'transparent',
					color: '#fff',
					border: '0'
				},
				overlayCSS: {
					opacity: 0.5
				}
			});
		}

		function hideLoading() {
			$('.isLoading').unblock();
			$('.isLoading').hide();
		}

		function getNews() {
			$('#news-card-list').empty();

			$.ajax({
				method: 'GET',
				url: "{{ route('admin.news.list1') }}",
				dataType: 'json',
				beforeSend: function() {},
				success: function(response) {
					const data = response.data;

					data.forEach((element, index) => {
						const userId = '{{ Auth::user()->id }}';
						var urlSeeMore = "{{ route('admin.news.detail', ':id') }}";
						// const createdAt = moment(element.created_at).format('DD MMMM YYYY HH:mm:ss');
						const createdAt = moment(element.created_at).format('DD MMMM YYYY HH:mm');
						const images = JSON.parse(element.images);
						const videos = JSON.parse(element.videos);
						const files = JSON.parse(element.files);
						var attachments = [];
						var menuHtml = ``;
						var sliderImage = ``;
						var filesHtml = ``;

						images.forEach((element) => {
							attachments.push({
								type: 'image',
								url: element,
							});
						});
						videos.forEach((element) => {
							attachments.push({
								type: 'video',
								url: element,
							});
						});

						urlSeeMore = urlSeeMore.replace(':id', element.id);

						if (userId == element.user_id) {
							menuHtml = `
							<div class="col-auto">
								<div class="btn-group">
									<a href="#" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fa-solid fa-ellipsis option-icon"></i>
									</a>
									<div class="dropdown-menu w-100">
										<a href="javascript:void(0);" class="dropdown-item edit-menu edit-menu-${index}" 
											data-id="${element.id}" 
											data-title="${element.title}"
											data-category="${element.category}"
											data-highlight_status="${element.highlight_status}"
											data-highlight_image="${element.highlight_image}"
										>Edit</a>
										<a href="javascript:void(0);" class="dropdown-item delete-menu" 
											data-id="${element.id}" 
											data-title="${element.title}" 
										>Delete</a>
									</div>
								</div>
							</div>
							`;
						}

						if (attachments.length > 0) {
							let indicators = ``;
							let items = ``;
							let arrowsHtml = ``;

							attachments.forEach((element2, index2) => {
								let activeClass = ``;
								let imageUrl = "{{ asset('storage/news') . '/' . ':image' }}";
								imageUrl = imageUrl.replace(':image', element2.url);

								if (index2 === 0) {
									activeClass = `active`;
								}

								indicators +=
									`<li data-bs-target="#slider-${index2}" data-bs-slide-to="${index2}" class="${activeClass}"></li>`;

								if (element2.type === 'image') {
									items += `<div class="carousel-item ${activeClass}">
										<div class="w-100 d-flex justify-content-center">
											<img class="d-flex img-fluid" src="${imageUrl}" alt="${index2} slide" />
										</div>
									</div>`;
								} else {
									items += `<div class="carousel-item ${activeClass}">
										<div class="w-100 d-flex justify-content-center">
											<video controls="controls" src="${imageUrl}" class="rounded-3 container-news-video" controlsList="nodownload"></video>
										</div>
									</div>`;
								}
							});

							if (attachments.length > 1) {
								arrowsHtml = `<a class="carousel-control-prev" href="#slider-${index}" role="button" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</a>
								<a class="carousel-control-next" href="#slider-${index}" role="button" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</a>`;
							} else {
								indicators = ``;
							}

							sliderImage = `<div id="slider-${index}" class="sliderCustomNews1 carousel slide mt-4" data-bs-ride="carousel">
								<ol class="carousel-indicators">
									${indicators}
								</ol>
								<div class="carousel-inner">
									${items}
								</div>
								${arrowsHtml}
							</div>`;
						}

						if (files.length > 0) {
							let row = ``;

							files.forEach((element) => {
								let url = "{{ asset('storage/news') . '/' }}" + element;

								row +=
									`<a href="${url}" class=" text-break" target="_blank">${element}</a>`;
							});

							filesHtml = `<div class="mt-2 d-inline-flex flex-column">
								${row}
							</div>`;
						}

						// if (images.length > 0) {
						// 	let indicators = ``;
						// 	let items = ``;
						// 	let arrowsHtml = ``;

						// 	images.forEach((element2, index2) => {
						// 		let activeClass = ``;
						// 		let imageUrl = "{{ asset('storage/news') . '/' . ':image' }}";
						// 		imageUrl = imageUrl.replace(':image', element2);

						// 		if (index2 === 0) {
						// 			activeClass = `active`;
						// 		}

						// 		indicators += `<li data-bs-target="#slider-${index2}" data-bs-slide-to="${index2}" class="${activeClass}"></li>`;
						// 		items += `<div class="carousel-item ${activeClass}">
					// 			<div class="w-100 d-flex justify-content-center">
					// 				<img class="d-flex img-fluid" src="${imageUrl}" alt="${index2} slide" />
					// 			</div>
					// 		</div>`;
						// 	});

						// 	if (images.length > 1) {
						// 		arrowsHtml = `<a class="carousel-control-prev" href="#slider-${index}" role="button" data-bs-slide="prev">
					// 			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					// 			<span class="visually-hidden">Previous</span>
					// 		</a>
					// 		<a class="carousel-control-next" href="#slider-${index}" role="button" data-bs-slide="next">
					// 			<span class="carousel-control-next-icon" aria-hidden="true"></span>
					// 			<span class="visually-hidden">Next</span>
					// 		</a>`;
						// 	} else {
						// 		indicators = ``;
						// 	}

						// 	sliderImage = `<div id="slider-${index}" class="sliderCustomNews1 carousel slide" data-bs-ride="carousel">
					// 		<ol class="carousel-indicators">
					// 			${indicators}
					// 		</ol>
					// 		<div class="carousel-inner">
					// 			${items}
					// 		</div>
					// 		${arrowsHtml}
					// 	</div>`;
						// }

						$('#news-card-list').append(`
						<div class="card container-news p-4 mb-4">
							<div class="row">
								<div class="col-xl-12 col-sm-12">
									<div class="d-flex">
										<div class="kiri">
											<img src="${element.user.foto ? '{{ asset('storage/user') }}/'+element.user.id+'/'+element.user.foto : '{{ asset('assets/img/dummy/default-user.png') }}' }" class="rounded-circle"
											alt="User" width="50" height="50">
										</div>
										<div class="kanan w-100">
											<div class="row">
												<div class="col">
													<div class="username">${element.user.name}</div>
													<div class="tanggal">${createdAt}</div>
												</div>
												${menuHtml}
											</div>
											<div class="title d-flex flex-wrap pe-4">
												<span>${element.title}</span>
											</div>
											<div class="container-isi d-flex flex-wrap pe-4">
												<span class="isi2 text-break" id="news-${element.id}">${element.isi != null ? element.isi : ''}</span>
											</div>
											<div class="seemore d-flex d-none" id="seemore-${element.id}">
												<a class="d-block fw-bold" href="${urlSeeMore}">See more...</a>
											</div>
											${filesHtml}
											${sliderImage}
										</div>
									</div>
								</div>
							</div>
						</div>
						`);

						$(`.edit-menu-${index}`).attr('data-images', element.images);
						$(`.edit-menu-${index}`).attr('data-videos', element.videos);
						$(`.edit-menu-${index}`).attr('data-files', element.files);
						$(`.edit-menu-${index}`).attr('data-body_text', element.isi != null ? element.isi :
							'');

						const scrollHeight = $(`#news-${element.id}`).prop('scrollHeight');
						const clientHeight = $(`#news-${element.id}`).prop('clientHeight');

						if (scrollHeight > clientHeight) {
							$(`#seemore-${element.id}`).removeClass('d-none');
						}
					});
				},
				error: function(error) {},
			});
		}

		function getNewsPagination(page) {
			$.ajax({
				method: 'GET',
				url: `{{ route('admin.news.list1_v2') }}?page=${page}`,
				dataType: 'json',
				beforeSend: function() {
					showLoading();

					loading = true;
				},
				success: function(response) {
					const data = response.data;

					currentPage = data.current_page;
					lastPage = data.last_page;

					data.data.forEach((element, index) => {
						renderCard(element);
					});
				},
				error: function(error) {

				},
				complete: function() {
					hideLoading();

					loading = false;
				}
			});
		}

		function getNewsOne(id) {
			var url = "{{ route('admin.news.show', ':id') }}";
			url = url.replace(':id', id);

			$.ajax({
				method: 'GET',
				url: url,
				dataType: 'json',
				beforeSend: function() {},
				success: function(response) {
					const element = response.data;

					renderCard(element, false);
				},
				error: function(error) {},
			});
		}

		async function formSubmitStore() {
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

			for (var i = inputImages.length - 1; i >= 0; i--) {
				formData.append('images[]', inputImages[i].image);
			}
			for (var i = inputVideos.length - 1; i >= 0; i--) {
				formData.append('videos[]', inputVideos[i].video);
			}
			for (var i = inputFiles.length - 1; i >= 0; i--) {
				formData.append('files[]', inputFiles[i].file);
			}

			// for (var pair of formData.entries()) {
			// 	console.log(pair[0]+ ', ' + pair[1]); 
			// }

			function ajax() {
				return new Promise(function(resolve, reject) {
					$.ajax({
						url: "{{ route('admin.news.store') }}",
						method: 'POST',
						data: formData,
						contentType: false,
						cache: false,
						processData: false,
						dataType: 'json',
						beforeSend: function() {},
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
					const data = response.data;

					Swal.fire(
						'Success',
						meta.message,
						'success'
					);
					// getNews();
					getNewsOne(data.id);

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

			for (var i = inputImages.length - 1; i >= 0; i--) {
				formData.append('images[]', inputImages[i].image);
			}
			for (var i = inputVideos.length - 1; i >= 0; i--) {
				formData.append('videos[]', inputVideos[i].video);
			}
			for (var i = inputFiles.length - 1; i >= 0; i--) {
				formData.append('files[]', inputFiles[i].file);
			}
			for (var i = deletedImages.length - 1; i >= 0; i--) {
				formData.append('deleted_images[]', deletedImages[i].fileName);
			}
			for (var i = deletedVideos.length - 1; i >= 0; i--) {
				formData.append('deleted_videos[]', deletedVideos[i].fileName);
			}
			for (var i = deletedFiles.length - 1; i >= 0; i--) {
				formData.append('deleted_files[]', deletedFiles[i].fileName);
			}

			function ajax() {
				return new Promise(function(resolve, reject) {
					var url = "{{ route('admin.news.update', ':id') }}";

					url = url.replace(':id', currentId);

					$.ajax({
						url: url,
						method: 'POST',
						data: formData,
						contentType: false,
						cache: false,
						processData: false,
						dataType: 'json',
						beforeSend: function() {},
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
					);
					// getNews();
					getNewsOne(currentId);

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

		function renderCard(element, list = true) {
			const userId = '{{ Auth::user()->id }}';
			var urlSeeMore = "{{ route('admin.news.detail', ':id') }}";
			// const createdAt = moment(element.created_at).format('DD MMMM YYYY HH:mm:ss');
			const createdAt = moment(element.created_at).format('DD MMMM YYYY HH:mm');
			const images = JSON.parse(element.images);
			const videos = JSON.parse(element.videos);
			const files = JSON.parse(element.files);
			var attachments = [];
			var menuHtml = ``;
			var sliderImage = ``;
			var filesHtml = ``;

			images.forEach((element) => {
				attachments.push({
					type: 'image',
					url: element,
				});
			});
			videos.forEach((element) => {
				attachments.push({
					type: 'video',
					url: element,
				});
			});

			urlSeeMore = urlSeeMore.replace(':id', element.id);

			if (userId == element.user_id) {
				menuHtml = `
				<div class="col-auto">
					<div class="btn-group">
						<a href="#" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa-solid fa-ellipsis option-icon"></i>
						</a>
						<div class="dropdown-menu w-100">
							<a href="javascript:void(0);" class="dropdown-item edit-menu edit-menu-${element.id}" 
								data-id="${element.id}" 
								data-title="${element.title}"
								data-category="${element.category}"
								data-highlight_status="${element.highlight_status}"
								data-highlight_image="${element.highlight_image}"
							>Edit</a>
							<a href="javascript:void(0);" class="dropdown-item delete-menu" 
								data-id="${element.id}" 
								data-title="${element.title}" 
							>Delete</a>
						</div>
					</div>
				</div>
				`;
			}

			if (attachments.length > 0) {
				let indicators = ``;
				let items = ``;
				let arrowsHtml = ``;

				attachments.forEach((element2, index2) => {
					let activeClass = ``;
					let imageUrl = "{{ asset('storage/news') . '/' . ':image' }}";
					imageUrl = imageUrl.replace(':image', element2.url);

					if (index2 === 0) {
						activeClass = `active`;
					}

					indicators +=
						`<li data-bs-target="#slider-${index2}" data-bs-slide-to="${index2}" class="${activeClass}"></li>`;

					if (element2.type === 'image') {
						items += `<div class="carousel-item ${activeClass}">
							<div class="w-100 d-flex justify-content-center">
								<img class="d-flex img-fluid" src="${imageUrl}" alt="${index2} slide" />
							</div>
						</div>`;
					} else {
						items += `<div class="carousel-item ${activeClass}">
							<div class="w-100 d-flex justify-content-center">
								<video controls="controls" src="${imageUrl}" class="rounded-3 container-news-video" controlsList="nodownload"></video>
							</div>
						</div>`;
					}
				});

				if (attachments.length > 1) {
					arrowsHtml = `<div class="carousel-control-prev">
						<a class="carousel-control-prev-icon" aria-hidden="true" href="#slider-${element.id}" role="button" data-bs-slide="prev"></a>
						<span class="visually-hidden">Previous</span>
					</div>
					<div class="carousel-control-next">
						<a class="carousel-control-next-icon" aria-hidden="true" href="#slider-${element.id}" role="button" data-bs-slide="next"></a>
						<span class="visually-hidden">Next</span>
					</div>`;
					// arrowsHtml = `<a class="carousel-control-prev" href="#slider-${element.id}" role="button" data-bs-slide="prev">
				// 	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				// 	<span class="visually-hidden">Previous</span>
				// </a>
				// <a class="carousel-control-next" href="#slider-${element.id}" role="button" data-bs-slide="next">
				// 	<span class="carousel-control-next-icon" aria-hidden="true"></span>
				// 	<span class="visually-hidden">Next</span>
				// </a>`;
				} else {
					indicators = ``;
				}

				sliderImage = `<div id="slider-${element.id}" class="sliderCustomNews1 carousel slide mt-4" data-bs-ride="carousel">
					<ol class="carousel-indicators">
						${indicators}
					</ol>
					<div class="carousel-inner">
						${items}
					</div>
					${arrowsHtml}
				</div>`;
			}

			if (files.length > 0) {
				let row = ``;

				files.forEach((element) => {
					let url = "{{ asset('storage/news') . '/' }}" + element;
					const ext = url.split('.').pop();

					function gambar() {
						switch (ext) {
							case 'docx':
								return "{{ asset(config('image_file.docx')) }}";
								break;
							case 'doc':
								return "{{ asset(config('image_file.doc')) }}";
							case 'pdf':
								return "{{ asset(config('image_file.pdf')) }}";
							case 'xls':
								return "{{ asset(config('image_file.xls')) }}";
							case 'xlsx':
								return "{{ asset(config('image_file.xlsx')) }}";
							case 'ppt':
								return "{{ asset(config('image_file.ppt')) }}";
							case 'pptx':
								return "{{ asset(config('image_file.pptx')) }}";
							default:
								return "{{ asset(config('image_file.docx')) }}";
						}
					}

					// row += `<a href="${url}" class=" text-break" target="_blank">${element}</a>`;
					row += `<a href="${url}" class="card-news-file card" target="_blank">
						<div class="card-news-file-content">
							<img src="${gambar()}" alt="File">
							<div>
								<div class="name">${element}</div>
							</div>
						</div>
					</a>`;
				});

				// filesHtml = `<div class="mt-2 d-inline-flex flex-column">
			// 	${row}
			// </div>`;
				filesHtml = `<div class="d-flex flex-wrap mt-3">
					${row}
				</div>`;
			}

			// if (images.length > 0) {
			// 	let indicators = ``;
			// 	let items = ``;
			// 	let arrowsHtml = ``;

			// 	images.forEach((element2, index2) => {
			// 		let activeClass = ``;
			// 		let imageUrl = "{{ asset('storage/news') . '/' . ':image' }}";
			// 		imageUrl = imageUrl.replace(':image', element2);

			// 		if (index2 === 0) {
			// 			activeClass = `active`;
			// 		}

			// 		indicators += `<li data-bs-target="#slider-${index2}" data-bs-slide-to="${index2}" class="${activeClass}"></li>`;
			// 		items += `<div class="carousel-item ${activeClass}">
		// 			<div class="w-100 d-flex justify-content-center">
		// 				<img class="d-flex img-fluid" src="${imageUrl}" alt="${index2} slide" />
		// 			</div>
		// 		</div>`;
			// 	});

			// 	if (images.length > 1) {
			// 		arrowsHtml = `<a class="carousel-control-prev" href="#slider-${element.id}" role="button" data-bs-slide="prev">
		// 			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		// 			<span class="visually-hidden">Previous</span>
		// 		</a>
		// 		<a class="carousel-control-next" href="#slider-${element.id}" role="button" data-bs-slide="next">
		// 			<span class="carousel-control-next-icon" aria-hidden="true"></span>
		// 			<span class="visually-hidden">Next</span>
		// 		</a>`;
			// 	} else {
			// 		indicators = ``;
			// 	}

			// 	sliderImage = `<div id="slider-${element.id}" class="sliderCustomNews1 carousel slide" data-bs-ride="carousel">
		// 		<ol class="carousel-indicators">
		// 			${indicators}
		// 		</ol>
		// 		<div class="carousel-inner">
		// 			${items}
		// 		</div>
		// 		${arrowsHtml}
		// 	</div>`;
			// }

			const content = `<div class="row">
				<div class="col-xl-12 col-sm-12">
					<div class="d-flex">
						<div class="kiri">
							<img src="${element.user.foto ? '{{ asset('storage/user') }}/'+element.user.id+'/'+element.user.foto : '{{ asset('assets/img/dummy/default-user.png') }}' }" class="rounded-circle"
							alt="User" width="50" height="50">
						</div>
						<div class="kanan w-100">
							<div class="row">
								<div class="col">
									<div class="username">${element.user.name}</div>
									<div class="tanggal">${createdAt}</div>
								</div>
								${menuHtml}
							</div>
							<div class="title d-flex flex-wrap pe-4">
								<span>${element.title}</span>
							</div>
							<div class="container-isi d-flex flex-wrap pe-4">
								<span class="isi2 text-break" id="news-isi-${element.id}">${element.isi != null ? element.isi : ''}</span>
							</div>
							<div class="seemore d-flex d-none" id="seemore-${element.id}">
								<a class="d-block fw-bold" href="${urlSeeMore}">See more...</a>
							</div>
							${filesHtml}
							${sliderImage}
						</div>
					</div>
				</div>
			</div>`;

			if ($(`#news-${element.id}`).length > 0) {
				$(`#news-${element.id}`).html(content);
			} else {
				if (list) {
					$('#news-card-list').append(`
					<div class="card container-news p-4 mb-4" id="news-${element.id}">
						${content}
					</div>
					`);
				} else {
					$('#news-card-list').prepend(`
					<div class="card container-news p-4 mb-4" id="news-${element.id}">
						${content}
					</div>
					`);
				}
			}

			$(`#slider-${element.id}`).carousel();
			$(`.edit-menu-${element.id}`).attr('data-images', element.images);
			$(`.edit-menu-${element.id}`).attr('data-videos', element.videos);
			$(`.edit-menu-${element.id}`).attr('data-files', element.files);
			$(`.edit-menu-${element.id}`).attr('data-body_text', element.isi != null ? element.isi : '');

			const scrollHeight = $(`#news-isi-${element.id}`).prop('scrollHeight');
			const clientHeight = $(`#news-isi-${element.id}`).prop('clientHeight');

			if (scrollHeight > clientHeight) {
				$(`#seemore-${element.id}`).removeClass('d-none');
			}
		}
	</script>
@endsection
