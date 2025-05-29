@extends('layouts.admin')

@section('content')
    <h1>Customers</h1>
    <a href="{{ route('admin.customers.create') }}" class="btn btn-success mb-3">Create Customer</a>
    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="lga_code" class="form-control" placeholder="LGA Code" value="{{ request()->lga_code }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="ward_code" class="form-control" placeholder="Ward Code" value="{{ request()->ward_code }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request()->status == 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Billing ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>LGA</th>
                <th>Ward</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->billing_id }}</td>
                    <td>{{ $customer->first_name . ' ' . $customer->surname }}</td>
                    <td>{{ $customer->email ?? '-' }}</td>
                    <td>{{ $customer->lga_code ?? '-' }}</td>
                    <td>{{ $customer->ward_code ?? '-' }}</td>
                    <td>{{ $customer->status }}</td>
                    <td>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links() }}
@endsection
?>