<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <ul class="list-group">
            @foreach($tasks as $task)
                <li class="list-group-item">
                    <input type="checkbox" class="task-checkbox" data-task-id="{{ $task->id }}" {{ $task->completed ? 'checked' : '' }}>
                    {{ $task->title }}
                </li>
            @endforeach
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
    $('.task-checkbox').on('change', function() {
        var checkbox = $(this);
        var taskId = checkbox.data('task-id');
        var isChecked = checkbox.is(':checked');
        
        $.ajax({
            url: '/tasks/update-status', // Laravel route for updating task status
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for Laravel
                task_id: taskId,
                completed: isChecked ? 1 : 0
            },
            success: function(response) {
                console.log('Task status updated successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error updating task status:', error);
            }
        });
    });
});

    </script>
</body>
</html>



