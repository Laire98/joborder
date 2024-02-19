<?php

namespace App\Http\Controllers;

use App\Models\PaymentModel;
use App\Models\WorkOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentsController extends Controller
{
    public function balance_payment($id)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.created_at', 'asc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->join('payment', 'payment.workorder_desc', '=', 'workorder.workorder_desc')
        ->where('workorder.id', '=', $id)
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id', 'workorder.workorder_desc as workorder_desc')
        ->first();

        $balance = PaymentModel::whereNull('payment.deleted_at')->orderby('payment.created_at', 'asc')
        ->where('payment.workorder_desc', '=', $workorderList->workorder_desc)
        ->selectRaw('SUM( IFNULL(debit,0) - IFNULL(credit,0)) as balance ')
        ->first();

        return response()->json(['workorderList' => $workorderList, 'balance' => $balance], 200);
    }

    public function pay(Request $request)
    {
        $datetime = Carbon::now();
        $cashTotal = floatval(preg_replace("/[^\d.]/", '', $request->modal_payments_total));
        $cashReceived = floatval(preg_replace("/[^\d.]/", '', $request->modal_payments_cash));
        $balance = floatval(preg_replace("/[^\d.]/", '', $request->modal_payments_balance));
        if ($balance == 0) {
            $cashReceived = $cashTotal;
        }

        if ($cashReceived == 0) {
            return response()->json(['success' => true, 'message' => 'Cash Received is zero.'], 200);
        }

        PaymentModel::create([
            'workorder_desc' => $request->modal_payments_work_number,
            'voucher' => 'Payment',
            'credit' => $cashReceived,
            'created_at' => $datetime,
        ]);

        return response()->json(['success' => true, 'message' => 'Payment updated successfully.'], 200);
    }
}
