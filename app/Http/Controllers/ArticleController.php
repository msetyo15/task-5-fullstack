<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Articles;
use Carbon\Carbon;
use Storage;

class ArticleController extends Controller
{
    //list all
    public function index()
    {
        try {
            $list = Articles::paginate(5); 
            
            return response([
                'status' => true,
                'message' => [
                    'articles' => $list
                ]
            ]);

        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
    
    //create
    public function create(Request $request) 
    {   
        try {
            $request->validate([
                'content' => ['required'],
                'title' => ['required'],
                'image' => ['required', 'mimes:jpg,jpeg,png', 'max:2048'],
                'user_id' => ['required'],
                'category_id' => ['required']
            ]);

            if($request->hasFile('image')) {
                //get original file name
                $fileNameOrigin = $request->file('image')->getClientOriginalName();

                $fileName = pathinfo($fileNameOrigin, PATHINFO_FILENAME);

                //get extension file
                $extension = $request->file('image')->getClientOriginalExtension();

                //add new file name
                $fileNameToStore = $fileName. '_'.time().'.'.$extension;

                //save file to local storage
                $request->image->storeAs('public/image', $fileNameToStore);

                // timestamp set
                $current_date_time = Carbon::now()->toDateTimeString();

                //insert to database
                $insert = DB::table('articles')->insert([
                    'title' => $request->title,
                    'content' => $request->content,
                    'image' => $fileNameToStore,
                    'user_id' => $request->user_id,
                    'category_id' => $request->category_id,
                    'created_at' => $current_date_time,
                    'updated_at' => $current_date_time,
                ]);
                
                if ($insert){
                    return response(['status' => true, 'message' => 'Success insert']);
                } else {
                    return response(['status' => false, 'message' => 'Failed insert']);
                }
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
    
            $detail = Articles::with('user', 'categories')->where('id', $request->id)->first();

            if (!$detail) return response(['status' => false, 'message' => 'Data not found!']);
            if ($detail) {
                return response([
                    'status' => true,
                    'message' => [
                        'articles' => $detail
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
        // $request->validate([
        //     'content' => ['required'],
        //     'title' => ['required'],
        //     'image' => ['required', 'mimes:jpg,jpeg,png', 'max:2048'],
        //     'user_id' => ['required'],
        //     'category_id' => ['required']
        // ]);

        try {
            $current_date_time = Carbon::now()->toDateTimeString();

            $latest_post = Articles::where('id', $request->id)->first();
            
            if($request->hasFile('image')) {
                //get original file name
                $fileNameOrigin = $request->file('image')->getClientOriginalName();

                $fileName = pathinfo($fileNameOrigin, PATHINFO_FILENAME);

                //get extension file
                $extension = $request->file('image')->getClientOriginalExtension();

                //add new file name
                $fileNameToStore = $fileName. '_'.time().'.'.$extension;

                //save file to local storage
                $request->image->storeAs('public/image', $fileNameToStore);
            
                $update = Articles::where('id', $request->id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'image' => $fileNameToStore,
                    'user_id' => $request->user_id,
                    'category_id' => $request->category_id,
                    'created_at' => $latest_post->created_at,
                    'updated_at' => $current_date_time
                ]);
            } else {
                $update = Articles::where('id', $request->id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'image' => $latest_post->image,
                    'user_id' => $request->user_id,
                    'category_id' => $request->category_id,
                    'created_at' => $latest_post->created_at,
                    'updated_at' => $current_date_time
                ]);
            }

            
    
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
        $request->validate([
            'id' => ['required']
        ]);
        
        try {
            //check file name
            $image_name = Articles::where('id', $request->id)->first();
            
            if(Storage::exists("public/image/$image_name->image")){
                // delete file from local storage
                Storage::delete("public/image/$image_name->image");
            }
            
            // delete file data from database
            $delete = Articles::where('id', $request->id)->delete();
        
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
