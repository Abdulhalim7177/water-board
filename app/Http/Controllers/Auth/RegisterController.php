<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'billing_id' => ['required', 'string', 'unique:customers,billing_id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string'],
            'contact' => ['required', 'string'],
            'success_id' => ['required', 'exists:successes,id'],
        ]);
    }

    protected function create(array $data)
    {
        return Customer::create([
            'billing_id' => $data['billing_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'gps_coordinates' => $data['gps_coordinates'] ?? null,
            'contact' => $data['contact'],
            'success_id' => $data['success_id'],
            'status' => 'pending',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $customer = $this->create($request->all());

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }
}
?>