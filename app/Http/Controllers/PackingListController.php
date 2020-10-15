<?php

namespace App\Http\Controllers;

use Exception;
use DB;
use Validator;

use App\Models\PackingList;
use App\Models\PackingListDetail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;

class PackingListController extends Controller
{
    public function __construct()
	{
        
    }

    private function Validator($request,$packing_list_id)
    {
        return Validator::make($request, [
            'packing_list' => 'required|array',
            'packing_list_details' => 'required|array'
        ]);
    }

    public function index(Request $request)
    {
        $packing_list_data = PackingList::get();

        return response()->json(["data" => $packing_list_data , "status" => 200]);
    }

    public function show(Request $request,$packing_list_id = 0)
    {
        $packing_list_data = PackingList::find($packing_list_id);

        return response()->json(["data" => $packing_list_data , "status" => 200]);
    }

    private function savePackingList($data)
    {
        $new_item = new PackingList;
        $new_item->fill($data);
        $new_item->create_by = "Admin";
        $new_item->update_by = "Admin";
        $new_item->save();
    }

    private function savePackingListDetails($datas)
    {
        foreach($datas as $item)
        {
            $new_item = new PackingListDetail;
            $new_item->fill($item);
            $new_item->create_by = "Admin";
            $new_item->update_by = "Admin";
            $new_item->save();
        }
    }

    public function store(Request $request)
    {
        $validator = $this->Validator($request->all());

        if ($validator->fails()){
			return $this->sendError($validator->errors(), '2002', 400);
        }

        DB::beginTransaction();
        try{
            savePackingList($request->packing_list);
            savePackingListDetails($request->packing_list_details);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["status" => 500 , "data" => "Can't Insert"]);
        }
        DB::commit();

        return response()->json(["staus"=>200 , "data" => "Data is CREATED"]);
    }

    private function updatePackingList($data,$packing_list_id)
    {
        $item = PackingList::find($packing_list_id);
        $item->fill($data);
        $item->create_by = "Admin";
        $item->update_by = "Admin";
        $item->save();
    }

    private function updateInvoiceDetails($datas,$invoice_id)
    {
        InvoiceDetail::whereInvoiceId($invoice_id)->delete();
        foreach($datas as $item)
        {
            $item = new PackingListDetail;
            $item->fill($item);
            $item->create_by = "Admin";
            $item->update_by = "Admin";
            $item->save();
        }
    }

    public function update(Request $request,$packing_list_id)
    {
        $validator = $this->Validator($request->all(), $packing_list_id);

        if ($validator->fails()){
			return $this->sendError($validator->errors(), '2002', 400);
        }

        DB::beginTransaction();
        try{
            updatePackingList($request->packing_list,$packing_list_id);
            updateInvoiceDetails($request->packing_list_details,$packing_list_id);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["status" => 500 , "data" => "Can't Update"]);
        }
        DB::commit();

        return response()->json(["staus"=>200 , "data" => "Data is Updated"]);
    }

    public function destroy(Request $request,$packing_list_id)
    {
        try{
            $item = PackingList::find($packing_list_id);
        }catch(Exception $e){
            return response()->json(["status" => 500 , "data" => "Data Not Found"]);
        }

        try{
            PackingListDetail::wherePackingListId($packing_list_id)->delete();
            $item->delete();
        }catch(Exception $e){
            return response()->json(["status" => 500 , "data" => "Can't Delete"]);
        }

        return response()->json(["staus"=>200 , "data" => "Data is DELETED"]);

    }
}
