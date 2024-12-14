<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Todo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function list(Request $request){
        $start_date = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $end_date = Carbon::parse($request->input('end_date'))->addDay()->format('Y-m-d');

        $data = Todo::with('user')->whereBetween('start_date', [$start_date, $end_date])->orWhereBetween('deadline', [$start_date, $end_date]) ;

        $datas = Helper::pagination($data->orderBy('priority', 'desc'), $request, [
            'user.name',
            'activity'
        ]);

        return response()->json([
            'success' => true,
            'data' => $datas
        ], 200);
    }

    public function detail($id) {
        $data = Todo::with('user')->find($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ],200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'activity' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        try{
            $data = Todo::create($request->all());
    
            return response()->json([
                'success' => true,
                'messsage' => "Success Added Data",
                'data' => $data
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'messsage' => $e->getMessage(),
            ], 422);
        }
    }
    
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'activity' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        try{
            $data = Todo::find($id);
            $data->update($request->all());
    
            return response()->json([
                'success' => true,
                'messsage' => "Success Updated Data",
                'data' => $data
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'messsage' => $e->getMessage(),
            ], 422);
        }
    }
    
    public function delete($id){
        try{
            $data = Todo::find($id)->delete();
    
            return response()->json([
                'success' => true,
                'messsage' => "Success Deleted Data",
                'data' => $data
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'messsage' => $e->getMessage(),
            ], 422);
        }
    }
}
