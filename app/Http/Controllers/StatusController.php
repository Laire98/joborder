<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    public function index()
    {
        $statusList = StatusModel::whereNull('deleted_at')->orderby('id', 'asc')
        ->whereNotIn('id', ['1', '2'])
        ->get();

        $data = compact('statusList');

        return view('status', $data);
    }

    public function store(Request $request)
    {
        $datetime = Carbon::now();
        $validator = Validator::make($request->all(), [
            'status_desc' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('status')
                ->withErrors($validator)
                ->withInput();
        }

        StatusModel::create([
            'status_desc' => ucwords($request->status_desc),
            'created_at' => $datetime,
        ]);

        return redirect()->route('status')->with('success', 'Status added successfully.');
    }

    public function edit($id)
    {
        $statusList = StatusModel::whereNull('deleted_at')->orderby('status_desc', 'asc')->get();
        $statusListEdit = StatusModel::where('id', '=', $id)->whereNull('deleted_at')->orderby('status_desc', 'asc')->get();

        $data = compact('statusList', 'statusListEdit');

        return view('statusedit', $data);
    }

    public function modify(Request $request, $id)
    {
        $status = StatusModel::find($id);
        $datetime = Carbon::now();
        $validator = Validator::make($request->all(), [
            'status_desc' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('status.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $status->update([
            'status_desc' => ucwords($request->status_desc),
            'updated_at' => $datetime,
        ]);

        return redirect()->route('status')->with('success', 'Status updated successfully.');
    }
}
