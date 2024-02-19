<?php

namespace App\Http\Controllers;

use App\Models\PaymentModel;
use Barryvdh\Snappy\Facades\SnappyImage;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $IncomeList = PaymentModel::whereNull('payment.deleted_at')
        ->where('voucher', '=', 'Payment')
        ->selectRaw('voucher, sum(credit) as total_income, month(created_at) as month')
        ->groupBy('voucher', 'month');

        if ($request->has('receivable_start_date')) {
            $IncomeList->whereYear('created_at', '=', $request->receivable_start_date);
        }

        $IncomeList = $IncomeList->get();

        $data = compact('IncomeList');

        return view('salesreport', $data);
    }

    public function income(Request $request)
    {
        $IncomeList = PaymentModel::whereNull('payment.deleted_at')
        ->where('voucher', '=', 'Payment')
        ->selectRaw('voucher, sum(credit) as total_income, month(created_at) as month')
        ->groupBy('voucher', 'month');

        if ($request->has('receivable_start_date')) {
            $IncomeList->whereYear('created_at', '=', $request->receivable_start_date);
        }

        $IncomeList = $IncomeList->get();

        $data = compact('IncomeList');

        return view('pdf.income', $data);

        // $options = [
        //     'format' => 'jpg',
        //     // 'orientation' => 'portrait', // or 'landscape'
        //     // 'page-size' => 'letter', // or any other supported page size
        // ];

        // $html = view('pdf.income', $data)->render();
        // $pdf = SnappyImage::loadHTML($html)->setOptions($options);
        // // $pdf = SnappyPdf::loadHTML($html)->setOptions($options);

        // return $pdf->stream('income.pdf');
    }
}
