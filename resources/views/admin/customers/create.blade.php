@extends('layouts.admin')

@section('content')
    <h1>Create Customer</h1>
    <form method="POST" action="{{ route('admin.customers.store') }}">
        @csrf
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Surname</label>
            <input type="text" name="surname" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Street Name</label>
            <input type="text" name="street_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Area</label>
            <input type="text" name="area" class="form-control">
        </div>
        <div class="form-group">
            <label>Landmark</label>
            <input type="text" name="landmark" class="form-control">
        </div>
        <div class="form-group">
            <label>LGA Code</label>
            <input type="text" name="lga_code" class="form-control">
        </div>
        <div class="form-group">
            <label>Ward Code</label>
            <input type="text" name="ward_code" class="form-control">
        </div>
        <div class="form-group">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Success ID</label>
            <input type="number" name="success_id" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Delivery Code</label>
            <input type="text" name="delivery_code" class="form-control">
        </div>
        <div class="form-group">
            <label>Billing Condition</label>
            <select name="billing_condition" class="form-control">
                <option value="">Select</option>
                <option value="Metered">Metered</option>
                <option value="Non-Metered">Non-Metered</option>
            </select>
        </div>
        <div class="form-group">
            <label>Customer Position</label>
            <input type="text" name="customer_position" class="form-control">
        </div>
        <div class="form-group">
            <label>Water Supply Status</label>
            <select name="water_supply_status" class="form-control">
                <option value="functional">Functional</option>
                <option value="non_functional">Non-Functional</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tariff Category</label>
            <select name="tariff_category_id" class="form-control">
                <option value="">Select</option>
                @foreach ($tariffCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }} ({{ $category->code }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Tariff Amount</label>
            <input type="number" name="amount" class="form-control" step="0.01">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
?>