@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $customer->first_name }}</h1>
    <h2>Tariffs</h2>
    @if($tariffs->isEmpty())
        <p>No tariffs found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tariffs as $tariff)
                    <tr>
                        <td>{{ $tariff->amount }}</td>
                        <td>{{ $tariff->balance }}</td>
                        <td>{{ $tariff->due_date }}</td>
                        <td>{{ $tariff->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
?>