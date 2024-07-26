<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Task;

class EmployeeController extends Controller
{

 public function updateStatus(Request $request)
    {

        $request->validate([
            'task_id' => 'required|integer|exists:tasks,id',
            'status' => 'required|boolean',
        ]);

        $taskId = $request->input('task_id');
        $status = $request->input('status');

        $task = Task::find($taskId);
       if ($task) {
        $task->status = $status;
        $task->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
    }


     public function index(){
     
    	return view('employee.index');
      }


     public function fetchemployee(){

    	$employee = Task::all();
    	       return response()->json([
         'employee'=>$employee
    		]);

      }


	 public function store(Request $request){

	    	$validator = Validator::make($request->all(), [
	        'title'=>'required',
	        'description'=>'required|min:10',
	       
	    		]);

	    	if($validator->fails())
	    	{
	           return response()->json([
	           'status'=>400,
	           'errors'=>$validator->messages()
	           	]);
	    	}
	    	else{
	           $employee = new Task;
	           $employee->title = $request->input('title');
	           $employee->description = $request->input('description');
	           $employee['user_id'] = auth()->user()->id;
	       
           $employee->save();

           return response()->json([
           'status'=>200,
           'message'=>' Task Created Successfully..'
           	]);
    	}
     }


     public function edit($id){

	     $employee = Task::find($id);
	     if($employee)
	     {
	     	return response()->json([
	          'status'=>200,
	          'employee'=> $employee
	     		]);
	     }
	     else
     {
     	 return response()->json([
          'status'=>404,
          'message'=> 'Task not found !!'
     		]);
	       }
	   }


     public function update(Request $request, $id)
 
	    {
	    
	    $validator = Validator::make($request->all(), [
	        'title'=>'required',
	        'description'=>'required|min:10',
	      
	        ]);

      if($validator->fails())
      {
           return response()->json([
           'status'=>400,
           'errors'=>$validator->messages()
            ]);
      }
      else{
           $employee = Task::find($id);
           if($employee)
           {

           $employee->title = $request->input('title');
           $employee->description = $request->input('description');
        
           $employee->save();

           return response()->json([
           'status'=>200,
           'message'=>'Task Updated Successfully..'
            ]);
       }
           else
           {  

               return response()->json([
               'status'=>404,
               'message'=>'Task not found..'
            ]);
            
           }
      }

  }

	public function destroy($id){

	     $employee = Task::find($id);
	     if($employee)
	     {
	      $employee->delete();
	      return response()->json([
	          'status'=>200,
	          'message'=>'Task Deleted Successfully' 
	        ]);
	     }
	     else
	     {
	       return response()->json([
	          'status'=>404,
	          'message'=> 'Task not found..'
	        ]);
	     }
	  }



}
