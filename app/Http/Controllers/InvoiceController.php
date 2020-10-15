<?php

namespace App\Http\Controllers;

use Exception;
use DB;
use Validator;

use App\Models\Invoice;
use App\Models\InvoiceDetail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function __construct()
	{
        
    }

    private function Validator($request, $criteria_id, $company_id)
    {
        return Validator::make($request, [
            'invoice' => 'required|array',
            'invioce_details' => 'required|array'
        ]);
    }

    public function index(Request $request)
    {
        $invoice_data = Invoice::get();

        return response()->json(["data" => $invoice_data , "status" => 200]);
    }

    public function show(Request $request,$invoice_id)
    {
        $invoice_data = Invoice::with('invoice_details')->find($invoice_id);

        return response()->json(["data" => $invoice_data , "status" => 200]);
    }

    private function saveInvoice($data)
    {
        $new_invoice = new Invoice;
        $new_invoice->fill($data);
        $new_invoice->create_by = "Admin";
        $new_invoice->update_by = "Admin";
        $new_invoice->save();
    }

    private function saveInvoiceDetails($datas)
    {
        foreach($datas as $item)
        {
            $new_invoice_detail = new InvoiceDetail;
            $new_invoice_detail->fill($item);
            $new_invoice_detail->create_by = "Admin";
            $new_invoice_detail->update_by = "Admin";
            $new_invoice_detail->save();
        }
    }

    public function store(Request $request)
    {
        $validator = $this->Validator($request->all(), 0, $request->company_id);

        if ($validator->fails()){
			return $this->sendError($validator->errors(), '2002', 400);
        }

        DB::beginTransaction();
        try{
            saveInvoice($request->invoice);
            saveInvoiceDetails($request->invoice_details);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["status" => 500 , "data" => "Can't Insert"]);
        }
        DB::commit();

        return response()->json(["staus"=>200 , "data" => "Data is CREATED"]);
    }

    private function updateInvoice($data,$invoice_id)
    {
        $new_invoice = Invoice::find($invoice_id);
        $new_invoice->fill($data);
        $new_invoice->create_by = "Admin";
        $new_invoice->update_by = "Admin";
        $new_invoice->save();
    }

    private function updateInvoiceDetails($datas,$invoice_id)
    {
        InvoiceDetail::whereInvoiceId($invoice_id)->delete();
        foreach($datas as $item)
        {
            $new_invoice_detail = new InvoiceDetail;
            $new_invoice_detail->fill($item);
            $new_invoice_detail->create_by = "Admin";
            $new_invoice_detail->update_by = "Admin";
            $new_invoice_detail->save();
        }
    }

    public function update(Request $request,$invoice_id)
    {
        $validator = $this->Validator($request->all(), 0, $request->company_id);

        if ($validator->fails()){
			return $this->sendError($validator->errors(), '2002', 400);
        }

        DB::beginTransaction();
        try{
            updateInvoice($request->invoice,$invoice_id);
            updateInvoiceDetails($request->invoice_details,$invoice_id);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(["status" => 500 , "data" => "Can't Update"]);
        }
        DB::commit();

        return response()->json(["staus"=>200 , "data" => "Data is Updated"]);
    }

    public function destroy(Request $request,$invoice_id)
    {
        try{
            $invoice_data = Invoice::find($invoice_id);
        }catch(Exception $e){
            return response()->json(["status" => 500 , "data" => "Data Not Found"]);
        }

        try{
            InvoiceDetail::whereInvoiceId($invoice_id)->delete();
            $invoice_data->delete();
        }catch(Exception $e){
            return response()->json(["status" => 500 , "data" => "Can't Delete"]);
        }

        return response()->json(["staus"=>200 , "data" => "Data is DELETED"]);

    }
}
