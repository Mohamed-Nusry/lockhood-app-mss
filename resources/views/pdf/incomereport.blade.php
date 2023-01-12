<!DOCTYPE html>
<html>
<head>
    <title>Income Report - Lockhood</title>
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

    <p style="font-weight:bold">Total Income - LKR {{$total_income ?? 'N/A'}}</p>

  
  
    <table class="table table-bordered">
        <tr>
            <th>Order No</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Mobile</th>
            <th>Amount (LKR)</th>
            <th>Discount (LKR)</th>
            <th>Total (LKR)</th>
            <th>Created On</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->order_no }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $order->mobile }}</td>
            <td>{{ $order->amount }}</td>
            <td>{{ $order->discount }}</td>
            <td>{{ $order->total }}</td>
            <td>{{ $order->created_at }}</td>
        </tr>
        @endforeach
    </table>
  
</body>
</html>