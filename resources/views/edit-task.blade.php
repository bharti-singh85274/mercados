<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>  Task edit form</h2>

  <div>
         @if(session()->has('success'))
            <div style="color: green; text-align: center;padding-top: 10px;">
                {{session()->get('success')}}
            </div>
            @endif 
    </div>
  <form  method="post" action="{{url('update/'.$edit->id)}}">
    @csrf
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" class="form-control" name="title" id="title" value="{{$edit->title}}" placeholder="Enter title">
    </div>
    <div class="form-group">
      <label for="description">Description:</label>
      <input type="text" class="form-control" value="{{$edit->description}}" placeholder="Enter Description" name="description">
    </div>
   
    <button type="submit" class="btn btn-default">Update</button>
  </form>
</div>

</body>
</html>
