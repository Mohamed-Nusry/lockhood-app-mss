@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        
        <button class="btn btn-primary mt-2 btn-create" style="float:right">Add New User</button>
        <h2 style="padding:10px">User Management</h2>
       
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-user" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>User Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade user-modal" tabindex="-1" role="dialog" aria-labelledby="user-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="user-form" id="user-form">
                    <input id="user-id" type="hidden">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="John doe">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="john@example.com">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary btn-save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    @include('layouts.assets.js.datatables_js')

    <script>
        tableUser();
        /**
         * load table user
         */
        function tableUser() {
            generateDataTable({
                selector: $('#table-user'),
                url: '{{ route('user.index') }}',
                columns: [{
                    data: null,
                    sortable: false,
                    width: '10%',
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {
                    data: 'first_name',
                    name: 'first_name',
                }, 
                {
                    data: 'last_name',
                    name: 'last_name',
                },
                {
                    data: 'email',
                    name: 'email',
                }, 
                {
                    data: 'department_id',
                    name: 'department_id',
                }, 
                {
                    data: 'user_type',
                    name: 'user_type',
                }, 
                {
                    data: 'action',
                    name: 'action',
                    width: '20%',
                }
                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3]
                }, ],
            });
        }

        $(document).ready(function() {
             /**
             * Create user
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                resetForm($('#user-form'));
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create User`);
                $('#user-id').val(id);
                $('.user-modal').modal('toggle');
            });


            /**
             * edit user
             */
            $('#table-user').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                resetForm($('#user-form'));
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit User`);
                $('#user-id').val(id);
                $('.user-modal').modal('toggle');
            });

            /**
             * Submit modal
             */
            $('#user-form').submit(function(event){
                event.preventDefault();
                const formData = new FormData(this);
                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('user.update', ['id' => 1]) }}',
                    data: formData,
                    type:'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('.btn-save').attr("disabled", true);
                        $('.btn-save').text('Please wait...');
                    },
                    complete: function () {
                        $('.btn-save').attr("disabled", false);
                        $('.btn-save').text('Successfully Updated');
                    },
                    success: function (data) {
                        if(data.status == 200) {
                            swalSuccess('', data.nessage);
                            tableUser();
                            $('.user-modal').modal('toggle');
                        }
                    }
                });
                return false;
            })

            /**
             * Delete user
             */
            $('#table-user').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('user.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete user?',
                    confirm: 'Delete!',
                    cancel: 'Cancel',
                    icon: 'question',
                    complete: (result) => {
                        $.ajax({
                            url: url.replace(':id', id),
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(result) {
                                tableUser();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            })
        })
    </script>
@endpush
