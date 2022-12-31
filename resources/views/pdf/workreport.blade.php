<!DOCTYPE html>
<html>
<head>
    <title>Work Report - Lockhood</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">{{ $title }}</h1>
    @if($from_date != null && $to_date != null)
        <p>{{ "From - ".$from_date  }}</p>
        <p>{{ "To - ".$to_date  }}</p>
    @else
        @if($from_date != null && $to_date == null)
            <p>{{ "From - ".$from_date  }}</p>
            <p>{{ "To - End" }}</p>
        @else
            @if($to_date != null && $from_date == null)
                <p>{{ "From - Beginning"  }}</p>
                <p>{{ "To - ".$to_date  }}</p>
            @else
                <p>{{ "From Beginning To End"}}</p>
            @endif
        @endif
    @endif

  
  
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Tasks</th>
            <th>Employee</th>
            <th>Kanban</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Updated By</th>
        </tr>
        @foreach($assignedworks as $assignedwork)
        <tr>
            <td>{{ $assignedwork->id }}</td>
            <td>{{ $assignedwork->name }}</td>
            <td>{{ $assignedwork->tasks }}</td>
            <td>{{ ($assignedwork->employee && $assignedwork->employee != null) ? $assignedwork->employee->first_name.' '.$assignedwork->employee->last_name : 'N/A'  }}</td>
            <td>{{ ($assignedwork->kanban && $assignedwork->kanban != null) ? $assignedwork->kanban->name : 'N/A'  }}</td>
            <td>{{ $assignedwork->status }}</td>
            <td>{{ $assignedwork->created_at }}</td>
            <td>{{ ($assignedwork->user && $assignedwork->user != null) ? $assignedwork->user->first_name.' '.$assignedwork->user->last_name : 'N/A'  }}</td>
        </tr>
        @endforeach
    </table>
  
</body>
</html>