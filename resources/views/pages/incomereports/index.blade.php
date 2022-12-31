@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        <button class="btn btn-primary mt-2 btn-create" style="float:right">Download PDF</button>
        <h2 style="padding:10px">Income Report</h2>
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
                    data: 'created_by',
                    name: 'created_by',
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
                // document.getElementById("material-form").reset();
                // const id = null;
                // $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Material`);
                // $('#material-id').val(id);
                // $('.material-modal').modal('toggle');
                // $('#supplier_id').attr("disabled", false);

            });

        })
    </script>
@endpush
