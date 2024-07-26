<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {

        $array = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
           
        ];

        $validate = Validator::make($request->all(), $array);

        if ($validate->fails()) {
            return $validate->errors();
        } else {

            $registration = new User;
            $registration->name = $request->name;
            $registration->email = $request->email;
            $registration->password = Hash::make($request->password);
            
            $registration->save();
            if ($registration) {
                return ['Result' => 'Thankyou,your registration done successfully !!', 'Registration' => $registration];
            } else {
                return ['Message' => 'Registraion Failed !!'];
            }
        }
    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;

                $response = ['token' => $token, 'user' => $user];

                $user = $user->makeHidden(['deleted_at', 'updated_at']);
                $this->handleDevices($request, $user);

                return response($response, 200);
            } else {
                $response = ['message' => 'Password mismatch', 'status' => false];

                return response($response, 422);
            }
        } else {
            $response = ['message' => 'User does not exist', 'status' => false];

            return response($response, 422);
        }
   }

     protected function handleDevices($request, $user, $type = 'u')
    {
        if ($request->device_token) {
            $device_name = 'default_device';
            if (! empty($request->device_name)) {
                $device_name = Str::slug($request->device_name, '_');
            }

            $userDevice = UserDevice::where([
                'device_name' => $type.'_'.$device_name,
                'app' => empty($request->app) ? 2 : $request->app,
                'user_id' => $user->id,
            ])->first();

            if (empty($userDevice)) {
                UserDevice::create([
                    'device_name' => $type.'_'.$device_name,
                    'app' => empty($request->app) ? 2 : $request->app,
                    'user_id' => $user->id,
                    'device_token' => $request->device_token,
                    'meta' => $request->device_other ?: null,
                    'user_id' => $user->id,
                ]);
            } else {
                $userDevice->device_token = $request->device_token;
                $userDevice->meta = $request->device_other ?: null;
                $userDevice->save();
            }

        }

        return true;
    }



  public function index()
    {
        $tasks = Task::all();
        return response()->json(['tasks' => $tasks], 200);
    }

    public function store(Request $request)
    {
     
        $data = array(
        "title" =>"required",
        "description" =>"required|min:10",
            );

        $validator = Validator::make($request->all(),$data );

        if($validator->fails()){

           return response()->json($validator->errors(),401);  //$use_validator->errors();  
        }else{

            $task = new Task();
            $task->description = request('description');
            $task->title = request('title');
            $task->user_id = Auth::user()->id;

           $task->save();
           
        if($task){
            return ["keys"=>"Task Added."];
        }else{
            return ["keys"=>"operation fail"];
        }

   }

    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json(['task' => $task], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|boolean',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json(['task' => $task], 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
