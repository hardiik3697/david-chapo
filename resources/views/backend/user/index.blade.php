@extends('backend.layout.app')

@section('meta')
@endsection

@section('title')
Users
@endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row border-bottom">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Users</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <a href="{{ route('user.create') }}"
                                class="btn btn-secondary create-new btn-primary waves-effect waves-light" tabindex="0"
                                aria-controls="DataTables_Table_0">
                                <span>
                                    <i class="ri-add-line ri-16px me-sm-2"></i>
                                    <span class="d-none d-sm-inline-block">New</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class="datatables-basic table table-bordered dataTable data-table" id="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var datatable;

    $(document).ready(function () {
        if ($('#data-table').length > 0) {
            datatable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,

                // "pageLength": 10,
                // "iDisplayLength": 10,
                "responsive": true,
                "aaSorting": [],
                // "order": [], //Initial no order.
                //     "aLengthMenu": [
                //     [5, 10, 25, 50, 100, -1],
                //     [5, 10, 25, 50, 100, "All"]
                // ],

                // "scrollX": true,
                // "scrollY": '',
                // "scrollCollapse": false,
                // scrollCollapse: true,

                // lengthChange: false,

                "ajax": {
                    "url": "{{ route('user') }}",
                    "type": "POST",
                    "dataType": "json",
                    "data": {
                        _token: "{{csrf_token()}}"
                    }
                },
                "columnDefs": [{
                    //"targets": [0, 5], //first column / numbering column
                    "orderable": true, //set not orderable
                },],
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'profile',
                    name: 'profile'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                },
                ]
            });
        }
    });

    function status(object) {
        var id = $(object).data("id");
        var status = $(object).data("status");

        if (confirm('Are you sure?')) {
            $.ajax({
                "url": "{!! route('user.status') !!}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    id: id,
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.code == 200) {
                        datatable.ajax.reload();
                        toastr.success('Status changed successfully', 'Success');
                    } else {
                        toastr.error('Failed to change status', 'Error');
                    }
                }
            });
        }
    }
</script>
@endsection
