<!DOCTYPE html>
<html lang="en">
<head>
  <title>User tasks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

  <h3>Owner tasks & description </h3>

    <div>
         @if(session()->has('msg'))
            <div style="color: red; text-align: center;padding-top: 10px;">
                {{session()->get('msg')}}
            </div>
            @endif 
    </div>
        
  <table class="table table-bordered">
    <thead>
     <tr>
    <th>Id</th>
    <th>User</th>
    <th>Tasks</th>
   </tr>


  @foreach($user_task as $user_task)
    <tr>
        <td>{{$user_task->id}}</td>
        <td>{{$user_task->name}}</td>
        <td>
            @foreach($user_task->get_user as $index => $users)
                {{$users->title}}
                @if ($index < count($user_task->get_user) - 1)
                    ,
                @endif
            @endforeach
        </td>
    </tr>
   @endforeach
    </tbody>
  </table>


  <table class="table table-bordered">
    <thead>
     <tr>
    <th>Id</th>
 
    <th>Task title</th>
    <th>Task Description</th>
    <th>Status</th>
    <th>Edit</th>
    <th>Delete</th>
   </tr>


   @foreach($all_tasks as $k=>$tasks)
    <tr>
        <td>{{$k+1}}</td>
    
        <td>{{$tasks->title}}</td>
        <td>{{$tasks->description}}</td>
         <td>
         @if($tasks->status == 1)
         <a href="{{url('change-user-status').'/'.$tasks->id}}"><span style="background-color: green" class="badge rounded-pill bg-success">Completed</span>
         @else
         <a href="{{url('change-user-status').'/'.$tasks->id}}"><span style="background-color: red" class="badge rounded-pill bg-danger">Pending</span></a>
         @endif
        </td>
         <td><a href="{{url('edit/'.$tasks->id)}}">Edit</a></td>
        <td><a href="{{url('delete/'.$tasks->id)}}">Delete</a></td>

    </tr>
   @endforeach
    </tbody>
  </table>

  {{$all_tasks->links()}}

</div>

</body>
</html>
