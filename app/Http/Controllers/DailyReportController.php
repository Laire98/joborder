<?php

namespace App\Http\Controllers;

use App\Models\PaymentModel;
use App\Models\WorkOrderModel;
use Barryvdh\Snappy\Facades\SnappyImage;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.status_at', 'desc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id')
        ->where('workorder.status_id', '=', 2); // Claimed

        if ($request->has('workorder_start_date')) {
            $workorderList->whereDate('workorder.status_at', '>=', $request->input('workorder_start_date'));
        }

        if ($request->has('workorder_end_date')) {
            $workorderList->whereDate('workorder.status_at', '<=', $request->input('workorder_end_date'));
        }

        $workorderList = $workorderList->get();

        $paymentList = WorkOrderModel::whereNull('workorder.deleted_at')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('payment', 'payment.workorder_desc', '=', 'workorder.workorder_desc')
        ->whereNull('payment.deleted_at')
        ->selectRaw('SUM( IFNULL(payment.debit,0) - IFNULL(payment.credit,0)) as balance, payment.workorder_desc, customers.name, customers.contact, workorder.device, workorder.model, workorder.id as workorder_id, workorder.total_cost, workorder.created_at as workorder_created_at')
        ->groupBy('payment.workorder_desc', 'customers.name', 'customers.contact', 'workorder.device', 'workorder.model', 'workorder.id', 'workorder.total_cost', 'workorder.created_at')
        ->having('balance', '=', 0); // Paid

        if ($request->has('receivable_start_date')) {
            $paymentList->whereDate('workorder.created_at', '>=', $request->input('receivable_start_date'));
        }

        if ($request->has('receivable_end_date')) {
            $paymentList->whereDate('workorder.created_at', '<=', $request->input('receivable_end_date'));
        }

        $paymentList = $paymentList->get();

        $data = compact('workorderList', 'paymentList');

        return view('dailyreport', $data);
    }

    public function receivable_view($id)
    {
        $receivableList = PaymentModel::whereNull('payment.deleted_at')
        ->join('workorder', 'workorder.workorder_desc', '=', 'payment.workorder_desc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->where('payment.workorder_desc', '=', $id)
        ->select('payment.*', 'customers.name')
        ->orderBy('payment.created_at', 'asc')
        ->get();

        $runningBalance = 0;
        $runningBalanceList = [];

        foreach ($receivableList as $payment) {
            $debit = $payment->debit;
            $credit = $payment->credit;

            $runningBalance += ($debit - $credit);

            // Add the running balance to the list
            $runningBalanceList[] = [
                'created_at' => $payment->created_at,
                'voucher' => $payment->voucher,
                'debit' => $debit,
                'credit' => $credit,
                'running_balance' => $runningBalance,
            ];
        }

        return response()->json(['receivableList' => $receivableList, 'runningBalanceList' => $runningBalanceList], 200);
    }

    public function generate_workorder_claimed($id)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.status_at', 'desc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id')
        ->where('workorder.status_id', '=', 2) // Claimed
        ->where('workorder.id', '=', $id)
        ->get();

        foreach ($workorderList as $workorder) {
            $diagnostic = '';
            if ($workorder->inspection) {
                $diagnostic .= 'Physical inspection, ';
            }
            if ($workorder->software) {
                $diagnostic .= 'Software diagnostic tools, ';
            }

            if ($workorder->interview) {
                $diagnostic .= 'Customer interview, ';
            }
            $diagnostic = rtrim($diagnostic, ', ');
            $workorder->diagnostic = $diagnostic;
        }

        foreach ($workorderList as $workorder) {
            $resolutionplan = '';
            if ($workorder->replacement) {
                $resolutionplan .= 'Hardware repair/replacement, ';
            }
            if ($workorder->patch) {
                $resolutionplan .= 'Software update/patch, ';
            }

            if ($workorder->backup) {
                $resolutionplan .= 'Data backup/recovery, ';
            }
            if ($workorder->other) {
                $resolutionplan .= $workorder->other_desc;
            }
            $resolutionplan = rtrim($resolutionplan, ', ');
            $workorder->resolutionplan = $resolutionplan;
        }

        $data = compact('workorderList');

        $options = [
            // 'format' => 'jpg',
            'orientation' => 'portrait', // or 'landscape'
            'page-size' => 'letter', // or any other supported page size
        ];

        $html = view('pdf.workorderpdf', $data)->render();
        // $pdf = SnappyImage::loadHTML($html)->setOptions($options);
        $pdf = SnappyPdf::loadHTML($html)->setOptions($options);

        $fileName = 'DailyReport.pdf';
        $filepath = public_path($fileName);
        if (File::exists($filepath)) {
            // Delete the previous file
            File::delete($filepath);
        }

        $pdf->save($filepath);

        return response()->json(['url' => asset($fileName)]);
    }

    public function preview($id)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.status_at', 'desc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id')
        ->where('workorder.status_id', '=', 2) // Claimed
        ->where('workorder.id', '=', $id)
        ->get();

        foreach ($workorderList as $workorder) {
            $diagnostic = '';
            if ($workorder->inspection) {
                $diagnostic .= 'inspection, ';
            }
            if ($workorder->software) {
                $diagnostic .= 'software, ';
            }

            if ($workorder->interview) {
                $diagnostic .= 'interview, ';
            }
            $diagnostic = rtrim($diagnostic, ', ');
            $workorder->diagnostic = $diagnostic;
        }

        foreach ($workorderList as $workorder) {
            $resolutionplan = '';
            if ($workorder->replacement) {
                $resolutionplan .= 'replacement, ';
            }
            if ($workorder->patch) {
                $resolutionplan .= 'patch, ';
            }

            if ($workorder->backup) {
                $resolutionplan .= 'backup, ';
            }
            $resolutionplan = rtrim($resolutionplan, ', ');
            $workorder->resolutionplan = $resolutionplan;
        }

        $data = compact('workorderList');

        $options = [
            // 'format' => 'jpg',
            'orientation' => 'portrait', // or 'landscape'
            'page-size' => 'letter', // or any other supported page size
        ];

        $html = view('pdf.workorderpdf', $data)->render();
        // $pdf = SnappyImage::loadHTML($html)->setOptions($options);
        $pdf = SnappyPdf::loadHTML($html)->setOptions($options);

        return $pdf->stream('table.pdf');

        //  return view('pdf.preview', $data);
    }

    public function generate_soa($id)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.status_at', 'desc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->selectRaw(
            'customers.*,
            workorder.*,
            status.*,
            workorder.id as workorder_id,
            CONCAT(workorder.device, " ", workorder.model) as description'
        )
        ->where('workorder.workorder_desc', '=', $id)
        ->get();

        $receivableList = PaymentModel::whereNull('payment.deleted_at')
        ->join('workorder', 'workorder.workorder_desc', '=', 'payment.workorder_desc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->where('payment.workorder_desc', '=', $id)
        ->select('payment.*')
        ->orderBy('payment.created_at', 'asc')
        ->get();

        $runningBalance = 0;
        $runningBalanceList = [];

        foreach ($receivableList as $payment) {
            $debit = $payment->debit;
            $credit = $payment->credit;

            $runningBalance += ($debit - $credit);
            // Add the running balance to the list
            $runningBalanceList[] = [
                'created_at' => $payment->created_at,
                'voucher' => $payment->voucher,
                'debit' => $debit,
                'credit' => $credit,
                'running_balance' => $runningBalance,
            ];
        }

        $data = compact('workorderList', 'receivableList', 'runningBalanceList');

        $options = [
            // 'format' => 'jpg',
            'orientation' => 'portrait', // or 'landscape'
            'page-size' => 'letter', // or any other supported page size
        ];

        $html = view('pdf.soa', $data)->render();
        // $pdf = SnappyImage::loadHTML($html)->setOptions($options);
        $pdf = SnappyPdf::loadHTML($html)->setOptions($options);

        $fileName = 'Soa.pdf';
        $filepath = public_path($fileName);
        if (File::exists($filepath)) {
            // Delete the previous file
            File::delete($filepath);
        }

        $pdf->save($filepath);

        return response()->json(['url' => asset($fileName)]);
    }
}
