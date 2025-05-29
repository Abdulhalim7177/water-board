<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // Web: Customer Dashboard
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $tariffs = $customer->tariffs()->get();
        return view('customer.dashboard', compact('customer', 'tariffs'));
    }

    // API: Login
    public function apiLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $customer->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'customer' => $customer]);
    }

    // API: Register
    public function apiRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'billing_id' => 'required|unique:customers,billing_id',
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|confirmed|min:8',
            'address' => 'required',
            'contact' => 'required',
            'success_id' => 'required|exists:successes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::create([
            'billing_id' => $request->billing_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'gps_coordinates' => $request->gps_coordinates,
            'contact' => $request->contact,
            'success_id' => $request->success_id,
            'status' => 'pending',
        ]);

        $token = $customer->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'customer' => $customer], 201);
    }

    // API: Get Customer Details
    public function getCustomer(Request $request)
    {
        $customer = $request->user('customer-api');
        return response()->json($customer);
    }

    // API: Get Customer Tariffs
    public function getTariffs(Request $request)
    {
        $customer = $request->user('customer-api');
        $tariffs = $customer->tariffs()->get();
        return response()->json($tariffs);
    }
}
?>