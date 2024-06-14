@extends('admin.layouts.app')
@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

 <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #dddddd;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    h2 {
        text-align: center;
    }
</style>

<h2>Users</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>first name </th>
            <th>last name</th>
                 <th>Operations</th>
 
         </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->l_name }}</td>
                <td>{{ $user->f_name }}</td>
                
                <td>
                    <form action="{{ url('block/user/' . $user->id) }}" method="POST" style="display: inline;">
                        @csrf  
                      
                            <button type="submit" class="btn btn-primary">Block</button>
                     </form>
                
                     <a href="{{ url('predict_history/'.$user->id) }}">
                    <button type="submit" class="btn btn-primary">Predict User History </button>
                </a>

                <a href="{{ url('user/posts/'.$user->id) }}">
                    <button type="submit" class="btn btn-primary">Posts User</button>
                </a>

                    <button type="submit" class="btn btn-primary">Courses  User</button>

                </td>
                
                  
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
