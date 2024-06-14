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
            <th>content </th>
            <th>created_at</th>
            <th>updated_at</th>
 
         </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->content }}</td>
                <td>{{ $post->created_at }}</td>
                <td>{{ $post->updated_at}}</td>
                
                <td>
                    <form action="{{ url('remove/posts/' . $post->id) }}" method="POST" style="display: inline;">
                        @csrf  
                      
                            <button type="submit" class="btn btn-primary">Remove</button>
                     </form>
                
                    

                </td>
                
                  
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
