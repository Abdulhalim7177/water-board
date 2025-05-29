@extends('layouts.admin')

@section('content')
    <h1>Admin Dashboard</h1>
    <div class="card">
        <div class="card-body">
            <h5>Total Customers: {{ $totalCustomers }}</h5>
            <h6>Recent Customers</h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Billing ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->billing_id }}</td>
                            <td>{{ $customer->first_name . ' ' . $customer->surname }}</td>
                            <td>{{ $customer->email ?? '-' }}</td>
                            <td>{{ $customer->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.customers') }}" class="btn btn-primary">View All Customers</a>
        </div>
    </div>
@endsection
?>