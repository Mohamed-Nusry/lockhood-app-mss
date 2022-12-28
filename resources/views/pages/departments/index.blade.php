@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        <button class="btn btn-primary mt-2 btn-create" style="float:right">Add New Department</button>
        <h2 style="padding:10px">Departments</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Department List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-department" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Created By</th>
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
    <div class="modal fade department-modal" tabindex="-1" role="dialog" aria-labelledby="department-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="department-form" id="department-form">
                    <input id="department-id" type="hidden">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="code" class="col-form-label">Code</label>
                            <input type="text" name="code" class="form-control" id="code" placeholder="Enter Code">
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary btn-save" value="Save">
                        {{-- <input type="submit" class="btn btn-primary btn-edit" value="Save"> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    @include('layouts.assets.js.datatables_js')

    <script>
        tableDepartment();
        /**
         * load table department
         */
        function tableDepartment() {
            generateDataTable({
                selector: $('#table-department'),
                url: '{{ route('department.index') }}',
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
                    data: 'name',
                    name: 'name',
                }, 
                {
                    data: 'code',
                    name: 'code',
                },
                {
                    data: 'created_by',
                    name: 'created_by',
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
             * Create department
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                resetForm($('#department-form'));
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Department`);
                $('#department-id').val(id);
                $('.department-modal').modal('toggle');
            });

            /**
             * edit department
             */
            $('#table-department').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                resetForm($('#department-form'));
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Department`);
                $('#department-id').val(id);
                $('.department-modal').modal('toggle');
            });

            /**
             * Submit modal
             */
            $('#department-form').submit(function(event){
                event.preventDefault();

                //If condition to check whether create or update

                const formData = new FormData(this);
                formData.append('_method', 'POST');
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('department.create') }}',
                    data: formData,
                    type:'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('.btn-save').attr("disabled", true);
                        $('.btn-save').text('Please wait......');
                    },
                    complete: function () {
                        $('.btn-save').attr("disabled", false);
                        $('.btn-save').text('Successfully Updated');
                    },
                    success: function (data) {
                        if(data.status == 200) {  
                            swalSuccess('', data.nessage);
                            tableDepartment();
                            $('.department-modal').modal('toggle');
                        }
                    }
                });

                console.log(3333, 'okkk');

                // const formData = new FormData(this);
                // formData.append('_method', 'PUT');
                // formData.append('_token', '{{ csrf_token() }}');
                // $.ajax({
                //     url: '{{ route('department.update', ['id' => 1]) }}',
                //     data: formData,
                //     type:'POST',
                //     dataType: 'json',
                //     contentType: false,
                //     processData: false,
                //     beforeSend: function () {
                //         $('.btn-save').attr("disabled", true);
                //         $('.btn-save').text('Please wait......');
                //     },
                //     complete: function () {
                //         $('.btn-save').attr("disabled", false);
                //         $('.btn-save').text('Successfully Updated');
                //     },
                //     success: function (data) {
                //         if(data.status == 200) {
                //             swalSuccess('', data.nessage);
                //             tableDepartment();
                //             $('.department-modal').modal('toggle');
                //         }
                //     }
                // });
                return false;
            })

            /**
             * Delete department
             */
            $('#table-department').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('department.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete department?',
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
                                tableDepartment();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            })
        })
    </script>
@endpush
