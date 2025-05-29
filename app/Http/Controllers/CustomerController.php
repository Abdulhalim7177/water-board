<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $tariffs = $customer->tariffs()->with('tariffCategory')->get();
        return view('customer.dashboard', compact('customer', 'tariffs'));
    }

    public function apiRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'middle_name' => 'nullable|string',
            'email' => 'nullable|email|unique:customers,email',
            'password' => 'required|confirmed|min:8',
            'street_name' => 'required|string',
            'area' => 'nullable|string',
            'landmark' => 'nullable|string',
            'lga_code' => 'nullable|string|exists:locations,code',
            'ward_code' => 'nullable|string|exists:locations,code',
            'contact' => 'required|string',
            'success_id' => 'required|exists:successes,id',
            'delivery_code' => 'nullable|string',
            'billing_condition' => 'nullable|in:Metered,Non-Metered',
            'customer_position' => 'nullable|string',
            'water_supply_status' => 'nullable|in:functional,non_functional'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::create([
            'billing_id' => Customer::generateBillingId(),
            'delivery_code' => $request->delivery_code,
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'street_name' => $request->street_name,
            'area' => $request->area,
            'landmark' => $request->landmark,
            'lga_code' => $request->lga_code,
            'ward_code' => $request->ward_code,
            'gps_coordinates' => $request->gps_coordinates,
            'contact' => $request->contact,
            'billing_condition' => $request->billing_condition,
            'customer_position' => $request->customer_position,
            'water_supply_status' => $request->water_supply_status ?? 'functional',
            'success_id' => $request->success_id,
            'status' => 'pending',
        ]);

        if ($request->gps_area_map) {
            $customer->geospatialData()->create([
                'type' => 'area_map',
                'coordinates' => json_encode($request->gps_area_map)
            ]);
        }

        if ($request->gps_perimeter) {
            $customer->geospatialData()->create([
                'type' => 'perimeter',
                'coordinates' => json_encode($request->gps_perimeter)
            ]);
        }

        $token = $customer->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'customer' => $customer], 201);
    }

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

    public function getCustomer(Request $request)
    {
        $customer = $request->user('customer-api');
        return response()->json($customer);
    }

    public function getTariffs(Request $request)
    {
        $customer = $request->user('customer-api');
        $tariffs = $customer->tariffs()->with('tariffCategory')->get();
        return response()->json($tariffs);
    }
}
?>