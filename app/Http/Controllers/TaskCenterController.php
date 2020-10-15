<?php

namespace App\Http\Controllers;

use Exception;
use DB;
use Validator;

use App\Models\PackingList;
use App\Models\Invoice;
use App\Models\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;

class TaskCenterController extends Controller
{
    public function __construct()
	{
        
    }
    public function index(Request $request)
    {
        $task = Task::with(['invoice.details','stage'])->get();

        return response()->json(['status'=>200,'data' => $task]);
    }

    public function show(Request $request,$task_id)
    {
        $task = Task::with(['invoice.details','packing_list.details','stage'])->find($task_id);

        return response()->json(['status'=>200,'data' => $task]);
    }

    public function destroy(Request $request,$task_id)
    {
        try{
            $task = Task::find($task_id);
            app()->call('App\Http\Controllers\InvoiceController@destroy',[$task->invocie_id]);
            app()->call('App\Http\Controllers\PackingListController@destroy',[$task->packing_list_id]);
        }catch(Exception $e){
            return response()->json(["status" => 500 , "data" => "Can't Delete"]);
        }
        
        return response()->json(['status'=>200,'data' => 'Delete Task Success']);

    }
   
}
