<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Articles;
use App\Models\Categories;
use Carbon\Carbon;
use Storage;

class ArticleWebController extends Controller
{
    //list all
    public function index()
    {
        try {

            $list = Articles::paginate(6);
            $user_id = User::all();
            $category_id = Categories::all();
            

            return view('articles')->with([
                'data' => $list, 
                'users' => $user_id,
                'categories' => $category_id
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
                    return redirect('../article');
                } else {
                    return redirect('../article');

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
            $detail = Articles::with('user', 'categories')->where('id', $request->id)->first();

            if (!$detail) return response(['status' => false, 'message' => 'Data not found!']);
            if ($detail) {
                return view('detailArticle')->with(['data' => $detail]);
            }
            
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required'],
            'title' => ['required'],
            'image' => ['mimes:jpg,jpeg,png', 'max:2048'],
            'user_id' => ['required'],
            'category_id' => ['required']
        ]);

        try {
            $current_date_time = Carbon::now()->toDateTimeString();

            $latest_post = Articles::where('id', $request->id)->first();
            
            if($request->hasFile('image')) {
                // delete file from local storage
                Storage::delete("public/image/$latest_post->image");

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
                return redirect('../article');
            } else {
                return redirect('../article');
            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);        
        }
        
    }

    //delete
    public function delete(Request $request)
    {   
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
                return redirect('../article');
            } else {
                return redirect('../article');
            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
