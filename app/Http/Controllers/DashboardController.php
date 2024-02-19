<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use App\Models\WorkOrderModel;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        $statusList = StatusModel::whereNull('deleted_at')->orderby('id', 'asc')->get();
        $paymentList = WorkOrderModel::whereNull('workorder.deleted_at')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('payment', 'payment.workorder_desc', '=', 'workorder.workorder_desc')
        ->whereNull('payment.deleted_at')
        ->selectRaw('SUM( IFNULL(payment.debit,0) - IFNULL(payment.credit,0)) as balance, payment.workorder_desc, customers.name, customers.contact, workorder.device, workorder.model, workorder.id as workorder_id')
        ->groupBy('payment.workorder_desc', 'customers.name', 'customers.contact', 'workorder.device', 'workorder.model', 'workorder.id')
        ->having('balance', '<>', 0)
        ->get();

        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.created_at', 'asc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id')
        ->where('workorder.status_id', '!=', 2)// Unclaimed
        ->get();

        $data = compact('workorderList', 'statusList', 'paymentList');

        return view('dashboard', $data);
    }

    public function generate_workorder_view($id)
    {
        $workorderList = WorkOrderModel::whereNull('workorder.deleted_at')->orderby('workorder.status_at', 'desc')
        ->join('customers', 'customers.id', '=', 'workorder.customer_id')
        ->join('status', 'status.id', '=', 'workorder.status_id')
        ->select('customers.*', 'workorder.*', 'status.*', 'workorder.id as workorder_id')
        ->where('workorder.status_id', '!=', 2) // Unclaimed
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
}
