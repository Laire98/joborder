<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\PaymentModel;
use App\Models\WorkOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class WorkOrderController extends Controller
{
    public function index()
    {
        return view('workorder');
    }

    public function store(Request $request)
    {
        $datetime = Carbon::now();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'email' => 'nullable|email',
            'address' => 'required|string',
        ]);

        if (strlen($request->contact) != 11) {
            return redirect()->route('workorder')
                ->withErrors('The contact field must be at least 11.')
                ->withInput();
        }

        if ($validator->fails()) {
            return redirect()->route('workorder')
                ->withErrors($validator)
                ->withInput();
        }

        $customerId = CustomerModel::where('name', $request->name)->value('id');
        if (!$customerId) {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|unique:users,email,except,id',
            ]);
            CustomerModel::create([
                'name' => ucwords($request->name),
                'contact' => $request->contact,
                'email' => $request->email ? strtolower($request->email) : 'NA',
                'address' => $request->address ? ucwords($request->address) : 'NA',
                'created_at' => $datetime,
            ]);
        }

        $cust_valid_Id = CustomerModel::where('name', $request->name)->value('id');
        $max_work_auto_id = WorkOrderModel::max('workorder_desc') ?? 0;
        $work_auto_id = intval($max_work_auto_id) + 1;
        $formatted_work_auto_id = str_pad($work_auto_id, 7, '0', STR_PAD_LEFT);

        WorkOrderModel::create([
            'customer_id' => $cust_valid_Id,
            'workorder_desc' => $formatted_work_auto_id,
            'device' => ucwords($request->device),
            'model' => ucwords($request->model),
            'serial' => $request->serial,
            'access' => $request->access,
            'issue' => $request->issue,
            'inspection' => $request->has('inspection'),
            'software' => $request->has('software'),
            'interview' => $request->has('interview'),
            'replacement' => $request->has('replacement'),
            'patch' => $request->has('patch'),
            'backup' => $request->has('backup'),
            'other' => $request->has('other'),
            'other_desc' => $request->input('other_desc'),
            'completion_time' => $request->completion_time,
            'start_date' => $request->start_date,
            'completion_date' => $request->completion_date,
            'labor_charges' => $request->labor_charges,
            'software_cost' => $request->software_cost,
            'miscellaneous_expense' => $request->miscellaneous_expense,
            'total_cost' => $request->total_cost,
            'created_at' => $datetime,
        ]);

        PaymentModel::create([
            'workorder_desc' => $formatted_work_auto_id,
            'voucher' => 'Work Order',
            'debit' => $request->total_cost,
            'created_at' => $datetime,
        ]);

        return redirect()->route('dashboard')->with('success', 'Work Order added successfully.');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->name;
        $customerList = CustomerModel::where('name', 'like', "%$query%")
        ->whereNull('deleted_at')
        ->orderBy('name', 'asc')
        ->get();

        return response()->json(['customerList' => $customerList]);
    }

    public function edit($id)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.created_at', 'asc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->where('workorder.id', '=', $id)
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id')
        ->get();

        $data = compact('workorderList');

        return view('workorderedit', $data);
    }

    public function modify(Request $request, $id)
    {
        $datetime = Carbon::now();
        $workorder = WorkOrderModel::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'contact' => 'required|numeric',
            'email' => 'nullable|email',
            'address' => 'required|string',
        ]);

        if (strlen($request->contact) != 11) {
            return redirect()->route('workorder')
                ->withErrors('The contact field must be at least 11.')
                ->withInput();
        }

        if ($validator->fails()) {
            return redirect()->route('workorder')
                ->withErrors($validator)
                ->withInput();
        }

        $customerId = CustomerModel::where('name', $request->name)->value('id');
        if (!$customerId) {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|unique:users,email,except,id',
            ]);
            CustomerModel::create([
                'name' => ucwords($request->name),
                'contact' => $request->contact,
                'email' => strtolower($request->email),
                'address' => ucwords($request->address),
                'created_at' => $datetime,
            ]);
        }

        $cust_valid_Id = CustomerModel::where('name', $request->name)->value('id');
        $workorder->update([
            'customer_id' => $cust_valid_Id,
            'device' => ucwords($request->device),
            'model' => ucwords($request->model),
            'serial' => $request->serial,
            'access' => $request->access,
            'issue' => $request->issue,
            'inspection' => $request->has('inspection'),
            'software' => $request->has('software'),
            'interview' => $request->has('interview'),
            'replacement' => $request->has('replacement'),
            'patch' => $request->has('patch'),
            'backup' => $request->has('backup'),
            'other' => $request->has('other'),
            'other_desc' => $request->other_desc,
            'completion_time' => $request->completion_time,
            'start_date' => $request->start_date,
            'completion_date' => $request->completion_date,
            'labor_charges' => $request->labor_charges,
            'software_cost' => $request->software_cost,
            'miscellaneous_expense' => $request->miscellaneous_expense,
            'total_cost' => $request->total_cost,
            'updated_at' => $datetime,
        ]);

        $workorder_desc = $workorder->where('id', '=', $id)->select('workorder_desc')->first();
        PaymentModel::where('voucher', '=', 'Work Order')->where('workorder_desc', '=', $workorder_desc->workorder_desc)
        ->update([
            'debit' => $request->total_cost,
            'updated_at' => $datetime,
        ]);

        PaymentModel::where('voucher', '=', 'Payment')->where('workorder_desc', '=', $workorder_desc->workorder_desc)
        ->update([
            'updated_at' => $datetime,
            'deleted_at' => $datetime,
        ]);

        return redirect()->route('dashboard')->with('success', 'Work Order updated successfully.');
    }

    public function status($id)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.created_at', 'asc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->where('workorder.id', '=', $id)
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id')
        ->get();

        return response()->json(['workorderList' => $workorderList], 200);
    }

    public function confirmation(Request $request, $id)
    {
        $workorder = WorkOrderModel::find($id);
        $workorder->update([
        'status_id' => $request->modal_status,
        ]);

        if ($request->modal_status == '2') { // claimed
            $datetime = Carbon::now();
            $workorder->update([
                'status_at' => $datetime,
                ]);
        }

        return response()->json(['success' => true, 'message' => 'Status Order updated successfully.'], 200);
    }
}
