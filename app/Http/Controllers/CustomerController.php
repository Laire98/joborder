<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customerList = CustomerModel::whereNull('deleted_at')->orderby('name', 'asc')->get();

        $data = compact('customerList');

        return view('customer', $data);
    }

    public function create()
    {
        return view('customeradd');
    }

    public function store(Request $request)
    {
        $datetime = Carbon::now();

        // Validate the form data
        $validator = Validator::make($request->all(), [
              'name' => 'required|string|unique:customers,name,except,id',
              'contact' => 'required|numeric',
              'email' => 'nullable|email',
              'address' => 'nullable|string',
          ]);

        if ($validator->fails()) {
            return redirect()->route('customer.create')
                ->withErrors($validator)
                ->withInput();
        }

        if (strlen($request->contact) != 11) {
            return redirect()->route('customer.create')
                ->withErrors('The contact field must be at least 11.')
                ->withInput();
        }

        try {
            CustomerModel::create([
                'name' => ucwords($request->name),
                'contact' => $request->contact,
                'email' => $request->email ? strtolower($request->email) : 'NA',
                'address' => $request->address ? ucwords($request->address) : 'NA',
                'created_at' => $datetime,
            ]);

            return redirect()->route('customer')->with('success', 'Customer Profile added successfully.');
        } catch (\Exception) {
            return redirect()->route('customer.create')
            ->withErrors('The name has already been taken.')
            ->withInput();
        }
    }

    public function edit($id)
    {
        $customerList = CustomerModel::where('id', '=', $id)->whereNull('deleted_at')->orderby('name', 'asc')->get();
        $data = compact('customerList');

        return view('customeredit', $data);
    }

    public function modify(Request $request, $id)
    {
        $datetime = Carbon::now();
        $customer = CustomerModel::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        if (strlen($request->contact) != 11) {
            return redirect()->route('customer.edit', ['id' => $id])
                ->withErrors('The contact field must be at least 11.')
                ->withInput();
        }

        try {
            $customer->update([
                'name' => ucwords($request->name),
                'contact' => $request->contact,
                'email' => $request->email ? strtolower($request->email) : 'NA',
                'address' => $request->address ? ucwords($request->address) : 'NA',
                'updated_at' => $datetime,
            ]);

            return redirect()->route('customer')->with('success', 'Customer Profile updated successfully.');
        } catch (\Exception) {
            return redirect()->route('customer.edit', ['id' => $id])
            ->withErrors('The name has already been taken.')
            ->withInput();
        }
    }
}
