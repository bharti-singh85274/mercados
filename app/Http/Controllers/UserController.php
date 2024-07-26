<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user_list;
use App\Models\Post;
use App\Models\Task;
use App\Models\User;
use App\Events\PostCreated;
use DB;

class usercontroller extends Controller
{
    
    public function dashboard(){
        
            $user_task = User::with('get_user')->get();
            return view('dashboard',['user_task'=>$user_task]); 
       }


     public function add_post(Request $request){

         $post_data = $request->validate([
            
            'title'=>'required',
            'description'=>'required|min:10',
         ]);

         $post_data['title'] = $request->title;
         $post_data['description'] = $request->description;
         $post_data['user_id'] = auth()->user()->id;

         Task::create($post_data);

         $data = ['title'=>$post_data['title'], 'user'=>auth()->user()->name];
         event(new PostCreated($data));
         return redirect()->back()->with('success','Task Created Successfully..');

    }

     public function view(){

         $user_task = User::with('get_user')->get();
         $all_tasks =  Task::paginate(5);
              return view('view-task',['user_task'=>$user_task,'all_tasks'=>$all_tasks]); 
         }

     public function edit($id){
         $edit = Task::find($id);
             return view('edit-task',compact('edit'));
         }

     public function update(Request $request,$id){

        $update = Task::find($request->id);
        $update->title = $request->title;
        $update->description = $request->description;

        $update->save();
         return redirect()->back()->with('success','Task Updated Successfully..');
       }

     public  function StatusChange($id){
       $data=Task::find($id);
        if($data){
          if($data->status == '0'){
            $data->update(['status'=>'1']);
          }
          else{
            $data->update(['status'=>'0']);
          }
          return redirect()->back()->with('success','Status changed Successfully..');
        }

        else{
          return redirect()->back()->with('error','No Such Task Found !!');
        }
     }


     public function delete($id){

         $delete_task = Task::find($id);
         $delete_task->delete();

         return redirect()->back()->with('msg','Task deleted successfully !!');
     }


}
