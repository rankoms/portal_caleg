@extends('layouts.app')
@section('title', 'Data Masyarakat')

@section('vendor-style')
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('content')
	<div class="container flex-grow-1 container-p-y">
		<div class="card">
			<div class="align-items-center d-flex justify-content-between p-4">
				<h5 class="card-header p-0">List People</h5>

				<a id="tambah-data" class="btn btn-success float-end" href="{{ route('admin.people.create') }}">Create</a>
			</div>
			<div class="table-responsive text-nowrap p-4 pt-0">
				<table class="datatables-ajax table">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody class="table-border-bottom-0">
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<!-- Add New Credit Card Modal -->
	<div class="modal fade" id="modal_people" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
			<div class="modal-content p-3 p-md-5">
				<div class="modal-body">
					<div class="mb-4">
						<h3><span class="title-modal"> Tambah Data
								People</span></h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="form-people" class="row g-3" action="{{ route('admin.people.store') }}" method="POST">
						@csrf
						<input type="hidden" name="poeple_id" id="poeple_id">
						<div class="col-12 col-md-12">
							<label class="form-label" for="name">Name</label>
							<input type="text" id="name" name="name" class="form-control" placeholder="Name" autofocus
								autocomplete="off" />
							<div class="invalid-feedback d-block invalid">
								<div data-field="modalAddCard" data-validator="notEmpty" id="name_invalid-feedback"></div>
							</div>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="nik">NIK KTP</label>
							<input type="text" id="nik" name="nik" class="form-control" placeholder="NIK KTP" autofocus
								autocomplete="off" />
							<div class="invalid-feedback d-block invalid">
								<div data-field="modalAddCard" data-validator="notEmpty" id="nik_invalid-feedback"></div>
							</div>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="alamat">Alamat</label>
							<textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat"></textarea>
							<div class="invalid-feedback d-block invalid">
								<div data-field="modalAddCard" data-validator="notEmpty" id="alamat_invalid-feedback"></div>
							</div>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="no_telp">No Telpon</label>
							<input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="No Telpon / No HP" autofocus
								autocomplete="off" />
							<div class="invalid-feedback d-block invalid">
								<div data-field="modalAddCard" data-validator="notEmpty" id="no_telp_invalid-feedback"></div>
							</div>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="email">Email</label>
							<input type="email" id="email" name="email" class="form-control" placeholder="Email" autofocus
								autocomplete="off" />
							<div class="invalid-feedback d-block invalid">
								<div data-field="modalAddCard" data-validator="notEmpty" id="email_invalid-feedback"></div>
							</div>
						</div>
						<div class="col-12 text-center mt-4">
							<button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
								aria-label="Close">Cancel</button>
							<button type="submit" class="btn btn-primary me-sm-3 me-1" id="btn-save">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--/ Add New Credit Card Modal -->
	<!--/ Refer & Earn Modal -->
@endsection

@section('vendor-script')
	<script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('js')
	<script>
		$(document).ready(function() {

			const select2 = $('.select2');

			if (select2.length) {
				select2.each(function() {
					var $this = $(this);
					$this.wrap('<div class="position-relative"></div>').select2({
						placeholder: 'Line Business',
						dropdownParent: $this.parent(),
					});
				});
			}

			var table = $('.datatables-ajax').DataTable({
				processing: true,
				serverSide: true,
				destroy: true,
				ajax: {
					'type': 'GET',
					'url': "{{ route('admin.people.list') }}",
				},
				pageLength: 10,
				order: [
					[1, 'asc']
				],
				columns: [{
						data: 'DT_RowIndex',
						name: 'DT_RowIndex',
						orderable: false,
						searchable: false
					},
					{
						data: 'name',
						name: "name"
					},
					{
						data: 'email',
						name: "email"
					},
					{
						data: 'action',
						name: "action",
						orderable: false,
						searchable: false
					},
				]
			});
			$('#tambah-data').on('click', function(e) {
				e.preventDefault();
				$('.title-modal').html('Create People Data')
				$('#modal_people').modal('show');
				$('#name').val('');
				$('input').removeClass('invalid');
				$('select').removeClass('invalid');
				$('.invalid-feedback div').html('');
				$('#poeple_id').val('');
				$('#form-people').trigger("reset");
			});

			$('body').on('click', '.btn-edit', function(e) {
				e.preventDefault();
				$('.title-modal').html('Edit People Data')
				$('#modal_people').modal('show');
				$('#line_business_id').val($(this).data('line_business_id')).trigger('change');
				$('#name').val($(this).data('name'));
				$('#poeple_id').val($(this).data('id'));
				$('input').removeClass('invalid');
				$('select').removeClass('invalid');
				$('.invalid-feedback div').html('');
			});

			$(document).on('select2:select', '#line_business_id', function() {
				$(this).removeClass('invalid');
				$(`#${this.id}_invalid-feedback`).html('');
			});

			$('#name').on('input', function() {
				$(this).removeClass('invalid');
				$(`#${this.id}_invalid-feedback`).html('');
			});

			$('body').on('click', '.btn-hapus', function(e) {
				id = $(this).data('id');
				url = "{{ route('admin.people.destroy', [':id']) }}";
				url = url.replace(':id', id);
				e.preventDefault();
				Swal.fire({
					// title: 'Ada yakin akan menghapus department ' + $(this).data('name') + ' ?',
					title: 'Are you sure to delete this People?',
					icon: 'warning',
					showDenyButton: true,
					showConfirmButton: false,
					showCancelButton: true,
					denyButtonText: `Delete`,
					customClass: {
						title: 'swal2-title-custom'
					}
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isDenied) {
						var data = getJSON(url, {
							_token: '{{ csrf_token() }}',
							id: id
						});

						if (data.errors) {

						} else {
							Swal.fire(
								'Success',
								data.meta.message,
								'success'
							)
							table.ajax.reload()
						}
					}
				})
			});


			$('#form-people').on('submit', function(e) {
				e.preventDefault();
				let formData = new FormData(this);
				let type = $(this).attr('method');
				let url = $(this).attr('action');

				$.ajax({
					type: type,
					url: url,
					data: formData,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#btn-save').attr('disabled', true);
						$('#btn-save').html('Loading');
					},
					success: function(response) {
						const meta = response.meta;

						if (meta.status === 'success') {
							swal.fire({
								title: "Success",
								icon: "success",
								text: meta.message,
							}).then(function() {
								$('#modal_people').modal('hide');
								table.ajax.reload();

							})
						} else {
							Swal.fire(
								'Fail',
								meta.message,
								'error'
							);
						}
					},
					error: function(error) {
						const data = JSON.parse(error.responseText);

						if (data.errors) {
							$.each(data.errors, function(key, value) {
								$('#' + key).addClass('invalid');
								$('#' + key + '_invalid-feedback').html(value);
								$('#' + key).focus();
							});
						} else {
							Swal.fire(
								'Fail',
								error.responseJSON.message,
								'error'
							);
						}
					},
					complete: function(jqXHR, textStatus) {
						$('#btn-save').attr('disabled', false);
						$('#btn-save').html('Save');
					}
				});
			});
		});
	</script>
@endsection
