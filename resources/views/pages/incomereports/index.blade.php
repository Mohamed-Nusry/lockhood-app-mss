@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        <h2 style="padding:10px">Income Report</h2>
        <form name="material-form" id="material-form" method="POST" action="{{url('/report/income/pdf')}}">
            @csrf
            <div class="row">
                <div class="col-4">
            <div class="form-group">
                <label for="from" class="col-form-label">From</label>
                <input type="date" name="from" class="form-control" id="from" placeholder="Enter From Date">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="to" class="col-form-label">To</label>
                <input type="date" name="to" class="form-control" id="to" placeholder="Enter To Date">
            </div>
            </div>

            <div class="col-4">
                @if(Auth::user()->user_type != null)
                    @if(Auth::user()->user_type != 5)
                        <button type="submit" class="btn btn-primary mt-4" style="margin-top: 36px !important;" >Download PDF</button>
                    @else
                        <button disabled type="submit" class="btn btn-primary mt-4" style="margin-top: 36px !important;" >Download PDF &nbsp;&nbsp; <i class="fas fa-question-circle btn-help" style="cursor:pointer;"></i></button>
                    @endif
                @endif

            </div>
            </div>

        </form>

        <br>
        <br>

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
                                            <th>Created On</th>
                                            <th>Created By</th>
                                            <th>Updated By</th>
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
                url: '{{ route('incomereport.index') }}',
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
                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3]
                }, ],
            });
        }

        $(document).ready(function() {
            /**
             * Download PDF
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
            });

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
