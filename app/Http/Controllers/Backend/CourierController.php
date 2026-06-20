<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourierController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = \App\Models\Courier::select(['id','name','client_id','store_id','is_active']);
        return DataTables::of($data)
            ->addColumn('status', function($row){
                return $row->is_active 
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function($row){
                return '
                    <a href="'.route('couriers.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                    <form action="'.route('couriers.destroy',$row->id).'" method="POST" style="display:inline-block;">
                        '.csrf_field().method_field("DELETE").'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    return view('backend.couriers.index');
}


    public function create()
    {
        return view('backend.couriers.create');
    }

    public function store(Request $request)
    {
        Courier::create($request->all());
        return redirect()->route('couriers.index')->with('success','Courier created successfully');
    }

    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view('backend.couriers.edit', compact('courier'));
    }

    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);
        $courier->update($request->all());
        return redirect()->route('couriers.index')->with('success','Courier updated successfully');
    }

    public function destroy($id)
    {
        Courier::findOrFail($id)->delete();
        return redirect()->route('couriers.index')->with('success','Courier deleted successfully');
    }
}
