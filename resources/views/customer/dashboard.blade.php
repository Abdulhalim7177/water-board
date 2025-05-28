<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, {{ $customer->name }}</h1>
        <div class="card">
            <div class="card-header">Profile Details</div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $customer->id }}</p>
                <p><strong>Billing ID:</strong> {{ $customer->billing_id }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Address:</strong> {{ $customer->address }}</p>
                <p><strong>Contact:</strong> {{ $customer->contact }}</p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">Tariffs</div>
            <div class="card-body">
                @if($tariffs->isEmpty())
                    <p>No tariffs found.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Balance</th>
                                <th>Usage Rate</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tariffs as $tariff)
                                <tr>
                                    <td>{{ $tariff->id }}</td>
                                    <td>{{ $tariff->amount }}</td>
                                    <td>{{ $tariff->balance }}</td>
                                    <td>{{ $tariff->usage_rate }}</td>
                                    <td>{{ $tariff->due_date }}</td>
                                    <td>{{ $tariff->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>
</html>