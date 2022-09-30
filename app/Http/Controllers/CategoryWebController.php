<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Categories;
use Carbon\Carbon;

class CategoryWebController extends Controller
{
    //list all
    public function index()
    {
        try {
            $list = Categories::paginate(5);
            $user_id = User::all();

            return view('categories')->with([
                'data' => $list,
                'users' =>$user_id
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
            $insert = DB::table('categories')->insert([
                'name' => $request->name,
                'user_id' => $request->user_id,
                'created_at' => $current_date_time,
                'updated_at' => $current_date_time
            ]);

            if ($insert){
                return redirect('../category');

            } else {
                return redirect('../category');

            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
        
    }

    //show detail
    public function detail(Request $request)
    {
        try {
            $detail = Categories::with('user')->where('id', $request->id)->first();
            if (!$detail) return response(['status' => false, 'message' => 'Data not found!']);
            if ($detail) {
                return view('detailCategory')->with(['data' => $detail]);
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
                return redirect('../category');
            } else {
                return redirect('../category');
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
                return redirect('../category');
            } else {
                return redirect('../category');
            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
