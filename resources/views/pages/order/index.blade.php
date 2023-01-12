@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        @if(Auth::user()->user_type != null)
            @if(Auth::user()->user_type == 3)
                <button class="btn btn-primary mt-2 btn-create" style="float:right">Create Order</button>
            @else
                <i class="fas fa-question-circle mt-3 btn-help" style="float:right;  cursor:pointer;"></i>
                <button disabled class="btn btn-primary mt-2 btn-create mr-2" style="float:right">Create Order</button>
                
            @endif
        @endif
        <h2 style="padding:10px">Orders</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-order" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Order No</th>
                                            <th>Customer Name</th>
                                            <th>Address</th>
                                            <th>Mobile</th>
                                            <th>Amount (LKR)</th>
                                            <th>Discount (LKR)</th>
                                            <th>Total (LKR)</th>
                                            <th>Payment Mode</th>
                                            <th>Reference</th>
                                            <th>Created On</th>
                                            <th>Created By</th>
                                            <th>Updated By</th>
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
    <div class="modal fade order-modal" tabindex="-1" role="dialog" aria-labelledby="order-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="order-form" id="order-form">
                    <input id="order-id" type="hidden">
                    <div class="modal-body">

              
                        <div class="form-group">
                            <label for="customer_name" class="col-form-label">Customer Name *</label>
                            <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Enter Customer Name">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address *</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address">
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-form-label">Mobile *</label>
                            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile">
                        </div>

                        
                        <div class="form-group" id="product_ids_div">
                            <label for="product_ids" class="col-form-label">Products</label>
                            <select id="product_ids" name="product_ids[]" class="form-control selectpicker  select-picker-border product_id_values" data-style="outline" multiple data-live-search="true">
                                @if (count($all_products) > 0)
                                    @foreach ($all_products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach

                                @else
                                    <option selected>No Products</option>
                                @endif
                                
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount *</label>
                            <input type="number"  value="0" readonly  name="amount" class="form-control" id="amount" placeholder="Enter Amount">
                        </div>
                        <div class="form-group">
                            <label for="discount" class="col-form-label">Discount</label>
                            <input type="number" min="0" value="0" name="discount" class="form-control" id="discount" placeholder="Enter Discount">
                        </div>
                        <div class="form-group">
                            <label for="total" class="col-form-label">Total *</label>
                            <input type="number"  value="0" readonly name="total" class="form-control" id="total" placeholder="Enter Total">
                        </div>

                         <div class="form-group" id="payment_types_div">
                            <label for="payment_status" class="col-form-label">Payment Mode</label>
                            <select id="payment_status" name="payment_status" class="form-control selectpicker select-picker-border" data-style="outline" data-live-search="true">
                                <option value="1">Cash</option>
                                <option value="2">Card</option>
                                <option value="3">Checkque</option>
                            </select>
                        </div> 
                        
                        <div class="form-group">
                            <label for="reference" class="col-form-label">Reference</label>
                            <textarea name="reference" class="form-control" id="reference" placeholder="Enter Reference"></textarea>
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
        tableOrder();
        /**
         * load table order
         */
        function tableOrder() {
            generateDataTable({
                selector: $('#table-order'),
                url: '{{ route('order.index') }}',
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
                    data: 'order_no',
                    name: 'order_no',
                }, 
                {
                    data: 'customer_name',
                    name: 'customer_name',
                },
                {
                    data: 'address',
                    name: 'address',
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                },
                {
                    data: 'amount',
                    name: 'amount',
                },
                {
                    data: 'discount',
                    name: 'discount',
                },
                {
                    data: 'total',
                    name: 'total',
                },
                {
                    data: 'payment_status',
                    name: 'payment_status',
                },
                {
                    data: 'reference',
                    name: 'reference',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                }, 
                {
                    data: 'created_by',
                    name: 'created_by',
                }, 
                {
                    data: 'updated_by',
                    name: 'updated_by',
                }, 
                {
                    data: 'action',
                    name: 'action',
                    width: '23%',
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
             * Create order
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("order-form").reset();
                const id = null;
                $('#product_ids_div').attr('style','display:block !important');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Order`);
                $('#order-id').val(id);
                $('.order-modal').modal('toggle');
            });

         
          
            //On product select
             $('.product_id_values').on('change',function(){

                // var value = $(this).find('option:selected').val();

                var value = $('#product_ids').val();

                $.ajax({
                    url: '{{ route('order.price') }}',
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        "product_ids": value,
                        "_method": 'POST',
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result) {
                        console.log(result.data);

                        $('#amount').val(result.data);

                        //Get discount value
                        var discount_val = $('#discount').val();
                        console.log(discount_val);

                        var total_after_discount = result.data - discount_val;
                        $('#total').val(total_after_discount);

                        // tableKanban();
                    }
                })

            });

               //On discount change
               $('#discount').on('change',function(){

                    var discount_val = $('#discount').val();

                    var amount = $('#amount').val();

                    var total_after_discount = amount - discount_val;

                    $('#total').val(total_after_discount);

  
                });

            /**
             * Submit modal
             */

            $('#order-form').submit(function(event){
                event.preventDefault();

                const formId = $('#order-id').val();

                if(!formId || formId == null){
                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('order.create') }}',
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
                                tableOrder();
                                $('.order-modal').modal('toggle');
                            }
                        }
                    });
                    
                }
                
                return false;
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
