@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        @if(Auth::user()->user_type != null)
            @if(Auth::user()->user_type != 5)
                <button class="btn btn-primary mt-2 btn-create" style="float:right">Add New Product</button>
            @else
                <i class="fas fa-question-circle mt-3 btn-help" style="float:right;  cursor:pointer;"></i>
                <button disabled class="btn btn-primary mt-2 btn-create mr-2" style="float:right">Add New Product</button>
                
            @endif
        @endif
        <h2 style="padding:10px">Products</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-product" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price (LKR)</th>
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
    <div class="modal fade product-modal" tabindex="-1" role="dialog" aria-labelledby="product-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Product</h5>
                    <button type="button" onclick="$('.product-modal').modal('toggle');" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="product-form" id="product-form">
                    <input id="product-id" type="hidden">
                    <div class="modal-body">

                       
                        <div class="form-group">
                            <label for="code" class="col-form-label">Code *</label>
                            <input type="text" name="code" class="form-control" id="code" placeholder="Enter Code">
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>

                     

                        <div class="form-group">
                            <label for="qty" class="col-form-label">Quantity *</label>
                            <input type="number" name="qty" class="form-control" id="qty" placeholder="Enter Quantity">
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-form-label">Price *</label>
                            <input type="number" name="price" class="form-control" id="price" placeholder="Enter Price">
                        </div>

                        <div class="form-group" id="material_ids_div" >
                            <label for="material_ids" class="col-form-label">Materials</label>
                            <select id="material_ids" name="material_ids[]" class="form-control selectpicker  select-picker-border" data-style="outline" multiple data-live-search="true">
                                @if (count($all_materials) > 0)
                                    @foreach ($all_materials as $material)
                                        <option value="{{$material->id}}">{{$material->name}}</option>
                                    @endforeach

                                @else
                                    <option selected>No Materials</option>
                                @endif
                                
                            </select>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="$('.product-modal').modal('toggle');" data-dismiss="modal">Close</button>
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
                    <button type="button" onclick="$('.help-modal').modal('toggle');" class="close" data-dismiss="modal" aria-label="Close">
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
                        <button type="button" onclick="$('.help-modal').modal('toggle');" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    @include('layouts.assets.js.datatables_js')

    <script>
        tableProduct();
        /**
         * load table product
         */
        function tableProduct() {
            generateDataTable({
                selector: $('#table-product'),
                url: '{{ route('product.index') }}',
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
                    data: 'code',
                    name: 'code',
                }, 
                {
                    data: 'name',
                    name: 'name',
                }, 
                {
                    data: 'qty',
                    name: 'qty',
                },
                {
                    data: 'price',
                    name: 'price',
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
             * Create product
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("product-form").reset();
                const id = null;
                $('#material_ids_div').attr('style','display:block !important');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Product`);
                $('#product-id').val(id);
                $('.product-modal').modal('toggle');

            });

            /**
             * edit product
             */
            $('#table-product').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("product-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Product`);
                $('#product-id').val(id);
                const url = "product/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('product.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#product-id').attr("disabled", true);
                        $('#code').attr("disabled", true);
                        $('#name').attr("disabled", true);
                        $('#qty').attr("disabled", true);
                        $('#price').attr("disabled", true);
                        $('#material_ids_div').attr('style','display:none !important');
                    },
                    complete: function () {
                        $('#product-id').attr("disabled", false);
                        $('#code').attr("disabled", false);
                        $('#name').attr("disabled", false);
                        $('#qty').attr("disabled", false);
                        $('#price').attr("disabled", false);
                        $('#material_ids_div').attr('style','display:none !important');
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           console.log(res);
                           if(res.data){
                            $('#product-id').val(res.data.id);
                            $('#code').val(res.data.code);
                            $('#name').val(res.data.name);
                            $('#qty').val(res.data.qty);
                            $('#price').val(res.data.price);
                           }
                        }
                    }
                });


                $('.product-modal').modal('toggle');
            });

            /**
             * Submit modal
             */
            $('#product-form').submit(function(event){
                event.preventDefault();

                const formId = $('#product-id').val();

                if(!formId || formId == null){
                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('product.create') }}',
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
                                swalSuccess('', data.message);
                                tableProduct();
                                $('.product-modal').modal('toggle');
                            }
                            if(data.status == 400) {  
                                swalError('', data.message);
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
                        url:"{{ url('inventory/product/update') }}" + '/' + formId,
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
                                swalSuccess('', data.message);
                                tableProduct();
                                $('.product-modal').modal('toggle');
                            }
                        }
                    });
                }
                
                return false;
            })

            /**
             * Delete product
             */
            $('#table-product').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('product.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete product?',
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
                                tableProduct();
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
