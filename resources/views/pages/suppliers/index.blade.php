@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        <button class="btn btn-primary mt-2 btn-create" style="float:right">Add New Supplier</button>
        <h2 style="padding:10px">Suppliers</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Supplier List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-supplier" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
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
    <div class="modal fade supplier-modal" tabindex="-1" role="dialog" aria-labelledby="supplier-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="supplier-form" id="supplier-form">
                    <input id="supplier-id" type="hidden">
                    <div class="modal-body">

                       
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-form-label">Mobile</label>
                            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address">
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
        tableSupplier();
        /**
         * load table supplier
         */
        function tableSupplier() {
            generateDataTable({
                selector: $('#table-supplier'),
                url: '{{ route('supplier.index') }}',
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
                    data: 'mobile',
                    name: 'mobile',
                },
                {
                    data: 'address',
                    name: 'address',
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
             * Create supplier
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("supplier-form").reset();
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Supplier`);
                $('#supplier-id').val(id);
                $('.supplier-modal').modal('toggle');
            });

            /**
             * edit supplier
             */
            $('#table-supplier').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("supplier-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Supplier`);
                $('#supplier-id').val(id);
                const url = "supplier/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('supplier.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#supplier-id').attr("disabled", true);
                        $('#name').attr("disabled", true);
                        $('#mobile').attr("disabled", true);
                        $('#address').attr("disabled", true);
                    },
                    complete: function () {
                        $('#supplier-id').attr("disabled", false);
                        $('#name').attr("disabled", false);
                        $('#mobile').attr("disabled", false);
                        $('#address').attr("disabled", false);
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           console.log(res);
                           if(res.data){
                            $('#supplier-id').val(res.data.id);
                            $('#name').val(res.data.name);
                            $('#mobile').val(res.data.mobile);
                            $('#address').val(res.data.address);
                           }
                        }
                    }
                });


                $('.supplier-modal').modal('toggle');
            });

            /**
             * Submit modal
             */
            $('#supplier-form').submit(function(event){
                event.preventDefault();

                const formId = $('#supplier-id').val();

                if(!formId || formId == null){
                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('supplier.create') }}',
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
                            $('.btn-save').text('Successfully Created');
                        },
                        success: function (data) {
                            if(data.status == 200) {  
                                swalSuccess('', data.nessage);
                                tableSupplier();
                                $('.supplier-modal').modal('toggle');
                            }
                        }
                    });
                    
                }else{
                    //Update Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url:"{{ url('inventory/supplier/update') }}" + '/' + formId,
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
                                tableSupplier();
                                $('.supplier-modal').modal('toggle');
                            }
                        }
                    });
                }
                
                return false;
            })

            /**
             * Delete supplier
             */
            $('#table-supplier').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('supplier.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete supplier?',
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
                                tableSupplier();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            })
        })
    </script>
@endpush
