@extends('layouts.app')

@section('vendor-style')
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('content')
	<div class="p-4">
		<div class="card">
			<h5 class="card-header">List News & Announcement</h5>
			<div class="table-responsive text-nowrap p-3">
				<table class="datatables-ajax table">
					<thead>
						<tr>
							<th>No</th>
							<th>Category</th>
							<th>Title</th>
							<th>Ringkasan Isi</th>
							<th>Cover</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody class="table-border-bottom-0">
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@section('vendor-script')
	<script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
@endsection
@section('js')
	<script>
		$(document).ready(function() {
			// var dt_ajax = $('.datatables-ajax').dataTable({
			// 	processing: true,
			// 	ajax: "{{ route('department.list') }}"
			// });
			getDataTable()

			function getDataTable() {
				var table = $('.datatables-ajax').DataTable({
					processing: true,
					serverSide: true,
					destroy: true,
					ajax: {
						'type': 'GET',
						'url': "{{ route('news.list') }}",
					},
					pageLength: 10,
					columns: [{
							data: 'DT_RowIndex',
							name: 'DT_RowIndex'
						},
						{
							data: 'category',
							name: "category"
						},
						{
							data: 'title',
							name: "title"
						},
						{
							data: 'isi',
							name: "isi"
						},
						{
							data: 'image',
							name: "image"
						},
						{

							data: null,
							className: "dt-center",
							orderable: false,
							"mRender": function(data, type, row) {

								return `
									<div class="d-flex">
										<a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
										<a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
									</div>`;
							}
						}
					]
				});
			}
		});
	</script>
@endsection
