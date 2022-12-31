@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        <button class="btn btn-primary mt-2 btn-create" style="float:right">Create Work</button>
        <h2 style="padding:10px">Assigned Works</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Work List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-assignedwork" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Tasks</th>
                                            <th>Department</th>
                                            <th>Employee</th>
                                            <th>Kanban</th>
                                            <th>Status</th>
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
    <div class="modal fade assignedwork-modal" tabindex="-1" role="dialog" aria-labelledby="assignedwork-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Work</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="assignedwork-form" id="assignedwork-form">
                    <input id="assignedwork-id" type="hidden">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="tasks" class="col-form-label">Tasks</label>
                            <textarea name="tasks" class="form-control" id="tasks" placeholder="Enter Tasks"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="employee_id" class="col-form-label">Employee</label>
                            <select id="employee_id" name="employee_id" class="form-control">
                                @if (count($all_employees) > 0)
                                    @foreach ($all_employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                                    @endforeach

                                @else
                                    <option selected>No Employees</option>
                                @endif
                                
                            </select>
                        </div>
                       
                        <div class="form-group">
                            <label for="kanban_id" class="col-form-label">Kanban Card</label>
                            <select id="kanban_id" name="kanban_id" class="form-control">
                                @if (count($all_kanbans) > 0)
                                    @foreach ($all_kanbans as $kanban)
                                        <option value="{{$kanban->id}}">{{$kanban->name}}</option>
                                    @endforeach

                                @else
                                    <option selected>No Kanban Cards</option>
                                @endif
                                
                            </select>
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
        tableWork();
        /**
         * load table assignedwork
         */
        function tableWork() {
            generateDataTable({
                selector: $('#table-assignedwork'),
                url: '{{ route('assignedwork.index') }}',
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
                    data: 'tasks',
                    name: 'tasks',
                },
                {
                    data: 'department_id',
                    name: 'department_id',
                },
                {
                    data: 'employee_id',
                    name: 'employee_id',
                },
                {
                    data: 'kanban_id',
                    name: 'kanban_id',
                },
                {
                    data: 'status',
                    name: 'status',
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
             * Create assignedwork
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("assignedwork-form").reset();
                const id = null;
                $('#material_ids_div').attr('style','display:block !important');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Work`);
                $('#assignedwork-id').val(id);
                $('.assignedwork-modal').modal('toggle');
                $('#employee_id').attr("disabled", false);
                $('#kanban_id').attr("disabled", false);
            });

            /**
             * edit assignedwork
             */
            $('#table-assignedwork').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("assignedwork-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Work`);
                $('#assignedwork-id').val(id);
                const url = "assignedwork/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('assignedwork.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#assignedwork-id').attr("disabled", true);
                        $('#name').attr("disabled", true);
                        $('#tasks').attr("disabled", true);
                        $('#employee_id').attr("disabled", true);
                        $('#kanban_id').attr("disabled", true);
                    },
                    complete: function () {
                        $('#assignedwork-id').attr("disabled", false);
                        $('#name').attr("disabled", false);
                        $('#tasks').attr("disabled", false);
                        $('#employee_id').attr("disabled", true);
                        $('#kanban_id').attr("disabled", true);
                        
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           console.log(res);
                           if(res.data){
                            $('#assignedwork-id').val(res.data.id);
                            $('#name').val(res.data.name);
                            $('#tasks').val(res.data.tasks);
                            $('#employee_id').val('');
                            $('#kanban_id').val('');
                           }
                        }
                    }
                });


                $('.assignedwork-modal').modal('toggle');
            });

            /**
             * Submit modal
             */
            $('#assignedwork-form').submit(function(event){
                event.preventDefault();

                const formId = $('#assignedwork-id').val();

                if(!formId || formId == null){
                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('assignedwork.create') }}',
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
                                tableWork();
                                $('.assignedwork-modal').modal('toggle');
                            }
                        }
                    });
                    
                }else{
                    //Update Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url:"{{ url('work/assignedwork/update') }}" + '/' + formId,
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
                                tableWork();
                                $('.assignedwork-modal').modal('toggle');
                            }
                        }
                    });
                }
                
                return false;
            })

            /**
             * Delete assignedwork
             */
            $('#table-assignedwork').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('assignedwork.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete assignedwork?',
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
                                tableWork();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            })
        })
    </script>
@endpush
