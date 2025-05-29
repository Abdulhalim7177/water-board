<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tariff;
use App\Models\TariffCategory;
use App\Models\GeospatialData;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        $customers = Customer::with('tariffs')->latest()->take(10)->get();
        $totalCustomers = Customer::count();
        return view('admin.dashboard', compact('customers', 'totalCustomers'));
    }

    public function customers(Request $request)
    {
        $query = Customer::with('tariffs.tariffCategory');

        if ($request->lga_code) {
            $query->where('lga_code', $request->lga_code);
        }
        if ($request->ward_code) {
            $query->where('ward_code', $request->ward_code);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $customers = $query->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function createCustomer()
    {
        $tariffCategories = TariffCategory::all();
        return view('admin.customers.create', compact('tariffCategories'));
    }

    public function storeCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'middle_name' => 'nullable|string',
            'email' => 'nullable|email|unique:customers,email',
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
            'water_supply_status' => 'nullable|in:functional,non_functional',
            'tariff_category_id' => 'nullable|exists:tariff_categories,id',
            'amount' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::create([
            'billing_id' => Customer::generateBillingId(),
            'delivery_code' => $request->delivery_code,
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'password' => $request->email ? Hash::make('default123') : null,
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
            'status' => 'approved',
        ]);

        if ($request->tariff_category_id && $request->amount) {
            Tariff::create([
                'customer_id' => $customer->id,
                'tariff_category_id' => $request->tariff_category_id,
                'amount' => $request->amount,
                'balance' => $request->amount,
                'usage_rate' => 10.00, // Default
                'due_date' => now()->addMonth(),
                'status' => 'pending'
            ]);
        }

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'create_customer',
            'details' => json_encode(['customer_id' => $customer->id, 'billing_id' => $customer->billing_id])
        ]);

        return redirect()->route('admin.customers')->with('success', 'Customer created successfully.');
    }

    public function editCustomer(Customer $customer)
    {
        $tariffCategories = TariffCategory::all();
        return view('admin.customers.edit', compact('customer', 'tariffCategories'));
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'middle_name' => 'nullable|string',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
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
            'water_supply_status' => 'nullable|in:functional,non_functional',
            'tariff_category_id' => 'nullable|exists:tariff_categories,id',
            'amount' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer->update([
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
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
            'delivery_code' => $request->delivery_code,
            'status' => $request->status ?? 'approved',
        ]);

        if ($request->tariff_category_id && $request->amount) {
            Tariff::updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'tariff_category_id' => $request->tariff_category_id,
                    'amount' => $request->amount,
                    'balance' => $request->amount,
                    'usage_rate' => 10.00,
                    'due_date' => now()->addMonth(),
                    'status' => 'pending'
                ]
            );
        }

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'update_customer',
            'details' => json_encode(['customer_id' => $customer->id, 'billing_id' => $customer->billing_id])
        ]);

        return redirect()->route('admin.customers')->with('success', 'Customer updated successfully.');
    }

    public function destroyCustomer(Customer $customer)
    {
        $customer->delete();

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'delete_customer',
            'details' => json_encode(['customer_id' => $customer->id, 'billing_id' => $customer->billing_id])
        ]);

        return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully.');
    }

    public function apiCustomers(Request $request)
    {
        $query = Customer::with('tariffs.tariffCategory');

        if ($request->lga_code) {
            $query->where('lga_code', $request->lga_code);
        }
        if ($request->ward_code) {
            $query->where('ward_code', $request->ward_code);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $customers = $query->paginate(10);
        return response()->json($customers);
    }

    public function apiImportCustomers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:json,xlsx,xls'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = $request->file('file');
        $data = [];

        if ($file->extension() === 'json') {
            $data = json_decode(file_get_contents($file), true);
        } else {
            // Use Maatwebsite/Excel or similar for Excel parsing
            // Placeholder: Parse Excel manually
        }

        foreach ($data as $item) {
            $customer = Customer::create([
                'billing_id' => Customer::generateBillingId(),
                'delivery_code' => $item['household_group']['deliverycode'] ?? null,
                'household_id' => $item['household_group']['householdid'] ?? null,
                'first_name' => $item['customer_details']['first_name'],
                'surname' => $item['customer_details']['surname_001'] ?? $item['customer_details']['surname'],
                'middle_name' => $item['customer_details']['middle_name'] ?? null,
                'email' => $item['customer_details']['email'] ?? null,
                'street_name' => $item['customer_details']['street_name'],
                'area' => $item['customer_details']['area'],
                'landmark' => $item['customer_details']['land_mark'] ?? null,
                'lga_code' => $item['customer_lga']['lga'],
                'ward_code' => $item['customer_lga']['ward'],
                'gps_coordinates' => $item['gps']['geopoint'] ?? null,
                'contact' => $item['customer_details']['mobile'],
                'billing_condition' => $item['household_group']['billingcondition'] ?? null,
                'customer_position' => $item['household_group']['customerposition'] ?? null,
                'water_supply_status' => $item['status']['water_supply_status'] ?? 'functional',
                'success_id' => 1, // Default from sample
                'status' => 'approved'
            ]);

            if (isset($item['gps']['area-map'])) {
                GeospatialData::create([
                    'customer_id' => $customer->id,
                    'type' => 'area_map',
                    'coordinates' => json_encode(explode(';', $item['gps']['area-map']))
                ]);
            }

            if (isset($item['gps']['perimeter'])) {
                GeospatialData::create([
                    'customer_id' => $customer->id,
                    'type' => 'perimeter',
                    'coordinates' => json_encode(explode(';', $item['gps']['perimeter']))
                ]);
            }

            if (isset($item['household_group']['tarrif']) && isset($item['household_group']['catcode'])) {
                $category = TariffCategory::where('code', $item['household_group']['catcode'])->first();
                if ($category) {
                    Tariff::create([
                        'customer_id' => $customer->id,
                        'tariff_category_id' => $category->id,
                        'amount' => $item['household_group']['tarrif'],
                        'balance' => $item['household_group']['tarrif'],
                        'usage_rate' => 10.00,
                        'due_date' => now()->addMonth(),
                        'status' => 'pending'
                    ]);
                }
            }
        }

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'import_customers',
            'details' => json_encode(['file' => $file->getClientOriginalName(), 'records' => count($data)])
        ]);

        return response()->json(['message' => 'Customers imported successfully']);
    }
}
?>