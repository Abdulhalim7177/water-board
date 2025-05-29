@extends('layouts.admin')

@section('content')
    <h1>Edit Customer</h1>
    <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label>Billing ID</label>
            <input type="text" class="form-control" value="{{ $customer->billing_id }}" disabled>
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $customer->first_name }}" required>
        </div>
        <div class="form-group">
            <label>Surname</label>
            <input type="text" name="surname" class="form-control" value="{{ $customer->surname }}" required>
        </div>
        <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" class="form-control" value="{{ $customer->middle_name }}">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
        </div>
        <div class="form-group">
            <label>Street Name</label>
            <input type="text" name="street_name" class="form-control" value="{{ $customer->street_name }}" required>
        </div>
        <div class="form-group">
            <label>Area</label>
            <input type="text" name="area" class="form-control" value="{{ $customer->area }}">
        </div>
        <div class="form-group">
            <label>Landmark</label>
            <input type="text" name="landmark" class="form-control" value="{{ $customer->landmark }}">
        </div>
        <div class="form-group">
            <label>LGA Code</label>
            <input type="text" name="lga_code" class="form-control" value="{{ $customer->lga_code }}">
        </div>
        <div class="form-group">
            <label>Ward Code</label>
            <input type="text" name="ward_code" class="form-control" value="{{ $customer->ward_code }}">
        </div>
        <div class="form-group">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" value="{{ $customer->contact }}" required>
        </div>
        <div class="form-group">
            <label>Success ID</label>
            <input type="number" name="success_id" class="form-control" value="{{ $customer->success_id }}" required>
        </div>
        <div class="form-group">
            <label>Delivery Code</label>
            <input type="text" name="delivery_code" class="form-control" value="{{ $customer->delivery_code }}">
        </div>
        <div class="form-group">
            <label>Billing Condition</label>
            <select name="billing_condition" class="form-control">
                <option value="">Select</option>
                <option value="Metered" {{ $customer->billing_condition == 'Metered' ? 'selected' : '' }}>Metered</option>
                <option value="Non-Metered" {{ $customer->billing_condition == 'Non-Metered' ? 'selected' : '' }}>Non-Metered</option>
            </select>
        </div>
        <div class="form-group">
            <label>Customer Position</label>
            <input type="text" name="customer_position" class="form-control" value="{{ $customer->customer_position }}">
        </div>
        <div class="form-group">
            <label>Water Supply Status</label>
            <select name="water_supply_status" class="form-control">
                <option value="functional" {{ $customer->water_supply_status == 'functional' ? 'selected' : '' }}>Functional</option>
                <option value="non_functional" {{ $customer->water_supply_status == 'non_functional' ? 'selected' : '' }}>Non-Functional</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tariff Category</label>
            <select name="tariff_category_id" class="form-control">
                <option value="">Select</option>
                @foreach ($tariffCategories as $category)
                    <option value="{{ $category->id }}" {{ $customer->tariffs->first() && $customer->tariffs->first()->tariff_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->category }} ({{ $category->code }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Tariff Amount</label>
            <input type="number" name="amount" class="form-control" value="{{ $customer->tariffs->first()->amount ?? '' }}" step="0.01">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
?>