<?php

namespace App\Http\Controllers;

use App\Models\ChargeInvoiceDetailModel;
use App\Models\ChargeInvoiceModel;
use App\Models\CustomerModel;
use Barryvdh\Snappy\Facades\SnappyImage;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class ChargeInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $chargeinvoiceList = ChargeInvoiceModel::whereNull('charge_invoice.deleted_at')
        ->join('customers', 'customers.id', '=', 'charge_invoice.customer_id')
        ->join('charge_invoice_detail', 'charge_invoice_detail.charge_id', '=', 'charge_invoice.id')
        ->whereNull('charge_invoice_detail.deleted_at')
        ->selectRaw('SUM(total) as grandtotal,  charge_invoice.charge_desc, charge_invoice_detail.charge_id, customers.name, charge_invoice.created_at ')
        ->groupBy('charge_invoice.charge_desc', 'charge_invoice_detail.charge_id', 'customers.name', 'charge_invoice.created_at');

        if ($request->has('charge_start_date')) {
            $chargeinvoiceList->whereDate('charge_invoice.created_at', '>=', $request->input('charge_start_date'));
        }

        if ($request->has('charge_end_date')) {
            $chargeinvoiceList->whereDate('charge_invoice.created_at', '<=', $request->input('charge_end_date'));
        }

        $chargeinvoiceList = $chargeinvoiceList->get();

        $data = compact('chargeinvoiceList');

        return view('chargeinvoice', $data);
    }

    public function add()
    {
        return view('chargeinvoiceadd');
    }

    public function register(Request $request)
    {
        $datetime = Carbon::now();

        $data = $request->json()->all();
        $tableData = $data;
        // Access form fields
        $formData = end($data);
        $name = $formData['name'];
        $address = $formData['address'];
        $contact = $formData['contact'];
        $email = $formData['email'];
        $tin = $formData['tin'];
        $remarks = $formData['remarks'];

        // dd($name);

        $customerId = CustomerModel::where('name', $name)->value('id');
        if (!$customerId) {
            CustomerModel::create([
                'name' => ucwords($name),
                'contact' => $contact,
                'email' => $email ? strtolower($email) : 'NA',
                'address' => $address ? ucwords($address) : 'NA',
                'created_at' => $datetime,
            ]);
        }

        $cust_valid_Id = CustomerModel::where('name', $name)->value('id');
        $max_charge_auto_id = ChargeInvoiceModel::max('charge_desc') ?? 0;
        $charge_auto_id = intval($max_charge_auto_id) + 1;
        $formatted_work_auto_id = str_pad($charge_auto_id, 7, '0', STR_PAD_LEFT);

        ChargeInvoiceModel::create([
            'charge_desc' => $formatted_work_auto_id,
            'customer_id' => $cust_valid_Id,
            'tin' => $tin,
            'remarks' => $remarks,
            'non_vat' => '0.00',
            'created_at' => $datetime,
        ]);

        $max_charge_id = ChargeInvoiceModel::max('id') ?? 1;

        foreach ($tableData as $rowData) {
            if (array_key_exists('quantity', $rowData)) {
                $quantity = $rowData['quantity'];
                $unit = $rowData['unit'];
                $articles = $rowData['articles'];
                $price = $rowData['price'];
                $total = $rowData['total'];

                ChargeInvoiceDetailModel::create([
                    'charge_id' => $max_charge_id,
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'articles' => $articles,
                    'price' => $price,
                    'total' => $total,
                    'created_at' => $datetime,
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Charge Invoice added successfully.'], 200);
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

    public function preview(Request $request, $id)
    {
        $chargeinvoiceList = ChargeInvoiceModel::whereNull('charge_invoice.deleted_at')
        ->join('customers', 'customers.id', '=', 'charge_invoice.customer_id')
        ->join('charge_invoice_detail', 'charge_invoice_detail.charge_id', '=', 'charge_invoice.id')
        ->whereNull('charge_invoice_detail.deleted_at')
        ->where('charge_invoice.id', '=', $id)
        ->selectRaw('SUM(total) as grandtotal,  charge_invoice.charge_desc, charge_invoice_detail.charge_id, customers.name, customers.address, customers.contact, charge_invoice.tin, charge_invoice.remarks, charge_invoice.created_at ')
        ->groupBy('charge_invoice.charge_desc', 'charge_invoice_detail.charge_id', 'customers.name', 'customers.address', 'customers.contact', 'charge_invoice.tin', 'charge_invoice.remarks', 'charge_invoice.created_at');

        if ($request->has('charge_start_date')) {
            $chargeinvoiceList->whereDate('charge_invoice.created_at', '>=', $request->input('charge_start_date'));
        }

        if ($request->has('charge_end_date')) {
            $chargeinvoiceList->whereDate('charge_invoice.created_at', '<=', $request->input('charge_end_date'));
        }

        $chargeinvoiceList = $chargeinvoiceList->get();

        $chargeinvoice_detailList = ChargeInvoiceModel::whereNull('charge_invoice.deleted_at')
        ->join('customers', 'customers.id', '=', 'charge_invoice.customer_id')
        ->join('charge_invoice_detail', 'charge_invoice_detail.charge_id', '=', 'charge_invoice.id')
        ->whereNull('charge_invoice_detail.deleted_at')
        ->where('charge_invoice.id', '=', $id)
        ->select('charge_invoice.*', 'charge_invoice_detail.*');

        if ($request->has('charge_start_date')) {
            $chargeinvoice_detailList->whereDate('charge_invoice.created_at', '>=', $request->input('charge_start_date'));
        }

        if ($request->has('charge_end_date')) {
            $chargeinvoice_detailList->whereDate('charge_invoice.created_at', '<=', $request->input('charge_end_date'));
        }

        $chargeinvoice_detailList = $chargeinvoice_detailList->get();

        $data = compact('chargeinvoiceList', 'chargeinvoice_detailList');

        // return view('pdf.chargeinvoicepdf', $data);

        $options = [
            // 'format' => 'jpg',
            'orientation' => 'portrait', // or 'landscape'
            'page-size' => 'letter', // or any other supported page size
        ];

        $html = view('pdf.chargeinvoicepdf', $data)->render();
        // $pdf = SnappyImage::loadHTML($html)->setOptions($options);
        $pdf = SnappyPdf::loadHTML($html)->setOptions($options);

        // return $pdf->stream('table.pdf');

        $fileName = 'ChargeInvoice.pdf';
        $filepath = public_path($fileName);
        if (File::exists($filepath)) {
            // Delete the previous file
            File::delete($filepath);
        }

        $pdf->save($filepath);

        return response()->json(['url' => asset($fileName)]);
    }
}
