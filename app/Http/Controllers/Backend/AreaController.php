<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\areaRequest;
use App\Http\Requests\DivisionRequest;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\subLocationRequest;
use App\Models\Area;
use App\Models\DeliveryZone;
use App\Models\Division;
use App\Models\Location;
use App\Models\SubLocation;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function divisionView()
    {
        return view('backend.division.view-division');
    }

    public function divisionList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');
        $Data = [];
        $Result = DeliveryZone::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $EditRoute = route('areas.division.edit', $Res->id);
            $DeleteRoute = route('areas.division.delete', $Res->id);
            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            $Data[] = array(
                'sn' => $sn,
                'zone_area' => $Res->zone_area,
                'zone_charge' => $Res->zone_charge,
                'action' => $action
            );
            $sn++;
        }
        $res = array(
            "draw" => $draw,
            "iTotalRecords" => DeliveryZone::count(),
            "iTotalDisplayRecords" => DeliveryZone::countResult($columns),
            "aaData" => $Data
        );
        return response()->json($res);
    }


    public function divisionAdd()
    {
        return view('backend.division.add-division');
    }

    public function divisionStore(Request $request)
    {
        $this->validate($request, [
            'zone_area' => 'required|string',
            'zone_charge' => 'required|integer',
        ]);

        $data = new DeliveryZone();
        $data->zone_area = $request->zone_area;
        $data->zone_charge = $request->zone_charge;
        $data->save();

        return redirect()->route('areas.division')->with('success', 'Data inserted successfully');
    }


    public function divisionEdit($id)
    {
        $editData = DeliveryZone::find($id);
        return view('backend.division.add-division', compact('editData'));
    }

    public function divisionUpdate(DivisionRequest $request, $id)
    {
        $data = DeliveryZone::find($id);
        $data->zone_area = $request->zone_area;
        $data->zone_charge = $request->zone_charge;
        $data->save();

        return redirect()->route('areas.division')->with('success', 'Data updated successfully !!!');
    }

    public function divisionDelete(Request $request, $id)
    {
        $data = DeliveryZone::find($id);
        $data->delete();
        return redirect()->route('areas.division')->with('success', 'Data deleted successfully !!!');
    }

    public function locationView()
    {
        return view('backend.location.view-location');
    }

    public function locationList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Location::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $EditRoute = route('areas.location.edit', $Res->id);
            $DeleteRoute = route('areas.location.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";

            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i
                class='fas fa-trash'></i> Delete</a>";


            $Data[] = array(
                'sn' => $sn,
                'division_id' => $Res->division['division_name'],
                'location_name' => $Res->location_name,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Location::count(),
            "iTotalDisplayRecords" => Location::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }


    public function locationAdd()
    {
        $data['divisions'] = Division::all();
        return view('backend.location.add-location', $data);
    }

    public function locationStore(Request $request)
    {
        $this->validate($request, [
            'location_name' => 'required|unique:locations,location_name'
        ]);

        $data = new Location();
        $data->division_id = $request->division_id;
        $data->location_name = $request->location_name;
        $data->save();

        return redirect()->route('areas.location')->with('success', 'Data inserted successfully');
    }


    public function locationEdit($id)
    {
        $data['editData'] = Location::find($id);
        $data['divisions'] = Division::all();
        return view('backend.location.add-location', $data);
    }

    public function locationUpdate(LocationRequest $request, $id)
    {
        $data = Location::find($id);
        $data->division_id = $request->division_id;
        $data->location_name = $request->location_name;
        $data->save();

        return redirect()->route('areas.location')->with('success', 'Data updated successfully !!!');
    }

    public function locationDelete(Request $request, $id)
    {
        $data = Location::find($id);
        $data->delete();

        return redirect()->route('areas.location')->with('success', 'Data deleted successfully !!!');
    }


    // Sub Location Codding here........
    public function sub_locationView()
    {
        return view('backend.sub_location.view-sub_location');
    }

    public function sub_locationList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = SubLocation::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $EditRoute = route('areas.sub_location.edit', $Res->id);
            $DeleteRoute = route('areas.sub_location.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";

            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i
                class='fas fa-trash'></i> Delete</a>";


            $Data[] = array(
                'sn' => $sn,
                'division_id' => $Res->division['division_name'],
                'location_id' => $Res->location['location_name'],
                'sub_location_name' => $Res->sub_location_name,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => SubLocation::count(),
            "iTotalDisplayRecords" => SubLocation::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }


    public function sub_locationAdd()
    {
        $data['divisions'] = Division::all();
        $data['locations'] = Location::all();
        return view('backend.sub_location.add-sub_location', $data);
    }

    public function sub_locationStore(Request $request)
    {
        $this->validate($request, [
            'sub_location_name' => 'required|unique:sub_locations,sub_location_name'
        ]);

        $data = new SubLocation();
        $data->division_id = $request->division_id;
        $data->location_id = $request->location_id;
        $data->sub_location_name = $request->sub_location_name;
        $data->save();

        return redirect()->route('areas.sub_location')->with('success', 'Data inserted successfully');
    }


    public function sub_locationEdit($id)
    {
        $data['editData'] = SubLocation::find($id);
        $data['divisions'] = Division::all();
        $data['locations'] = Location::all();
        return view('backend.sub_location.add-sub_location', $data);
    }

    public function sub_locationUpdate(subLocationRequest $request, $id)
    {
        $data = SubLocation::find($id);
        $data->division_id = $request->division_id;
        $data->location_id = $request->location_id;
        $data->sub_location_name = $request->sub_location_name;
        $data->save();

        return redirect()->route('areas.sub_location')->with('success', 'Data updated successfully !!!');
    }

    public function sub_locationDelete(Request $request, $id)
    {
        $data = SubLocation::find($id);
        $data->delete();

        return redirect()->route('areas.sub_location')->with('success', 'Data deleted successfully !!!');
    }

    // Area Codding here........
    public function areaView()
    {
        return view('backend.area.view-area');
    }

    public function areaList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Area::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $EditRoute = route('areas.area.edit', $Res->id);
            $DeleteRoute = route('areas.area.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";

            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i
                class='fas fa-trash'></i> Delete</a>";

            $Data[] = array(
                'sn' => $sn,
                'division_id' => $Res->division['division_name'],
                'location_id' => $Res->location['location_name'],
                'sub_location_id' => $Res->sub_location['sub_location_name'],
                'area_name' => $Res->area_name,
                'deliveryCharge' => $Res->deliveryCharge,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Area::count(),
            "iTotalDisplayRecords" => Area::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function areaAdd()
    {
        $data['divisions'] = Division::all();
        $data['locations'] = Location::all();
        $data['sub_locations'] = SubLocation::all();
        return view('backend.area.add-area', $data);
    }

    public function areaStore(Request $request)
    {
        $this->validate($request, [
            'area_name' => 'required|unique:areas,area_name'
        ]);

        $data = new Area();
        $data->division_id = $request->division_id;
        $data->location_id = $request->location_id;
        $data->sub_location_id = $request->sub_location_id;
        $data->area_name = $request->area_name;
        $data->deliveryCharge = $request->deliveryCharge;
        $data->save();

        return redirect()->route('areas.area')->with('success', 'Data inserted successfully');
    }

    public function areaEdit($id)
    {
        $data['editData'] = Area::find($id);
        $data['divisions'] = Division::all();
        $data['locations'] = Location::all();
        $data['sub_locations'] = SubLocation::all();
        return view('backend.area.add-area', $data);
    }

    public function areaUpdate(areaRequest $request, $id)
    {
        $data = Area::find($id);
        $data->division_id = $request->division_id;
        $data->location_id = $request->location_id;
        $data->sub_location_id = $request->sub_location_id;
        $data->area_name = $request->area_name;
        $data->deliveryCharge = $request->deliveryCharge;
        $data->save();

        return redirect()->route('areas.area')->with('success', 'Data updated successfully !!!');
    }

    public function areaDelete(Request $request, $id)
    {
        $data = Area::find($id);
        $data->delete();

        return redirect()->route('areas.area')->with('success', 'Data deleted successfully !!!');
    }

    // Json Response here
    public function locationAjax($division_id)
    {
        $loc = Location::where('division_id', $division_id)->orderBy('location_name', 'ASC')->get();
        return response()->json($loc);
    }

    public function sublocationAjax($location_id)
    {
        $subloc = SubLocation::where('location_id', $location_id)->orderBy('sub_location_name', 'ASC')->get();
        return response()->json($subloc);
    }

    public function areaAjax($sub_location_id)
    {
        $area = Area::where('sub_location_id', $sub_location_id)->orderBy('area_name', 'ASC')->get();
        return response()->json($area);
    }
}
