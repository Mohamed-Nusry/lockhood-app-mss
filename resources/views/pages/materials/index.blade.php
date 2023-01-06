@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        @if(Auth::user()->user_type != null)
            @if(Auth::user()->user_type != 5)
                <button class="btn btn-primary mt-2 btn-create" style="float:right">Purchase New Material</button>
            @else
                <i class="fas fa-question-circle mt-3 btn-help" style="float:right;  cursor:pointer;"></i>
                <button disabled class="btn btn-primary mt-2 btn-create mr-2" style="float:right">Purchase New Material</button>
                
            @endif
        @endif
        <h2 style="padding:10px">Materials</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Material List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-material" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Supplier</th>
                                            <th>Quantity</th>
                                            <th>Purchase Price</th>
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
    <div class="modal fade material-modal" tabindex="-1" role="dialog" aria-labelledby="material-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="material-form" id="material-form">
                    <input id="material-id" type="hidden">
                    <div class="modal-body">

                       
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>

                        <div class="form-group">
                            <label for="supplier_id" class="col-form-label">Supplier *</label>
                            <select id="supplier_id" name="supplier_id" class="form-control">
                                @if (count($all_suppliers) > 0)
                                    @foreach ($all_suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach

                                @else
                                    <option selected>No Suppliers</option>
                                @endif
                                
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="qty" class="col-form-label">Quantity *</label>
                            <input type="number" name="qty" class="form-control" id="qty" placeholder="Enter Quantity">
                        </div>
                        <div class="form-group">
                            <label for="purchase_price" class="col-form-label">Purchase Price *</label>
                            <input type="number" name="purchase_price" class="form-control" id="purchase_price" placeholder="Enter Purchase Price">
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

      <!-- Help Modal -->
      <div class="modal fade help-modal" tabindex="-1" role="dialog" aria-labelledby="help-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fas fa-exclamation-circle "></i> Access Denied</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="help-form" id="help-form">
                    <div class="modal-body">

                        <p>If the button is disabled, that means you have no access to perform this operation. Some operations are restricted
                            to suitable roles. If you have any issues please contact Lockhood system admin.
                        </p>

                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    @include('layouts.assets.js.datatables_js')

    <script>
        tableMaterial();
        /**
         * load table material
         */
        function tableMaterial() {
            generateDataTable({
                selector: $('#table-material'),
                url: '{{ route('material.index') }}',
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
                    data: 'supplier_id',
                    name: 'supplier_id',
                }, 
                {
                    data: 'qty',
                    name: 'qty',
                },
                {
                    data: 'purchase_price',
                    name: 'purchase_price',
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
             * Create material
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("material-form").reset();
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Material`);
                $('#material-id').val(id);
                $('.material-modal').modal('toggle');
                $('#supplier_id').attr("disabled", false);

            });

            /**
             * edit material
             */
            $('#table-material').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("material-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Material`);
                $('#material-id').val(id);
                const url = "material/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('material.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#material-id').attr("disabled", true);
                        $('#name').attr("disabled", true);
                        $('#qty').attr("disabled", true);
                        $('#purchase_price').attr("disabled", true);
                        $('#supplier_id').attr("disabled", true);
                    },
                    complete: function () {
                        $('#material-id').attr("disabled", false);
                        $('#name').attr("disabled", false);
                        $('#qty').attr("disabled", false);
                        $('#purchase_price').attr("disabled", false);
                        $('#supplier_id').attr("disabled", true);
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           console.log(res);
                           if(res.data){
                            $('#material-id').val(res.data.id);
                            $('#name').val(res.data.name);
                            $('#qty').val(res.data.qty);
                            $('#purchase_price').val(res.data.purchase_price);
                            $('#supplier_id').val('');
                           }
                        }
                    }
                });


                $('.material-modal').modal('toggle');
            });

            /**
             * Submit modal
             */
            $('#material-form').submit(function(event){
                event.preventDefault();

                const formId = $('#material-id').val();

                if(!formId || formId == null){
                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('material.create') }}',
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
                                tableMaterial();
                                $('.material-modal').modal('toggle');
                            }
                        }
                    });
                    
                }else{
                    //Update Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url:"{{ url('inventory/material/update') }}" + '/' + formId,
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
                                tableMaterial();
                                $('.material-modal').modal('toggle');
                            }
                        }
                    });
                }
                
                return false;
            })

            /**
             * Delete material
             */
            $('#table-material').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('material.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete material?',
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
                                tableMaterial();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            })

            /**
             * Help Button
             */
             $('.btn-help').on('click', function(event) {
                event.preventDefault();
                $('.help-modal').modal('toggle');
            });
        })
    </script>
@endpush
