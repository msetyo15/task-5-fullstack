<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;
use Carbon\Carbon;

class CategoryController extends Controller
{
    //list all
    public function index()
    {
        try {
            $list = DB::table('categories')->paginate(5);

            return response([
                'status' => true,
                'message' => [
                    'categories' => $list
                ]
                ]);
            
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
    
    //create
    public function create(Request $request) 
    { 
        //timestamp set
        $current_date_time = Carbon::now()->toDateTimeString();

        $request->validate([
            'name' => ['required'],
            'user_id' => ['required']
        ]);
        
        try {
            $user_id = Categories::where('user_id', $request->user_id)->count();
            if ($user_id == 1) return response(['status' => false, 'message' => 'User id is already!']);
            if ($user_id == 0) 
            {
                $insert = DB::table('categories')->insert([
                    'name' => $request->name,
                    'user_id' => $request->user_id,
                    'created_at' => $current_date_time,
                    'updated_at' => $current_date_time
                ]);
            }

            if ($insert){
                return response(['status' => true, 'message' => 'Success insert']);
            } else {
                return response(['status' => false, 'message' => 'Failed insert']);
            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
        
    }

    //show detail
    public function detail(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required']
            ]);
    
            $detail = Categories::with('user')->where('id', $request->id)->first();
            if (!$detail) return response(['status' => false, 'message' => 'Data not found!']);
            if ($detail) {
                return response([
                    'status' => true,
                    'message' => [
                        'categories' => $detail
                    ]
                ]);
            }
            
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'user_id' => ['required']
        ]);

        try {
            $update = Categories::where('id', $request->id)->update([
                'id' => $request->id,
                'name' => $request->name,
                'user_id' => $request->user_id
            ]);
    
            if ($update){
                return response(['status' => true, 'message' => 'Success update']);
            } else {
                return response(['status' => false, 'message' => 'Failed update']);
            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);        
        }
        
    }

    //delete
    public function delete(Request $request)
    {
        try {
            $delete = Categories::where('id', $request->id)->delete();
        
            if ($delete){
                return response(['status' => true, 'message' => 'Success delete']);
            } else {
                return response(['status' => false, 'message' => 'Failed delete']);
            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
