@extends('admin.layouts.app')
@section('content')

<title>جدول بسيط</title>
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

<h2>Posts</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>content</th>
            <th>status</th>
                 <th>Operations</th>
 
         </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->content }}</td>
                <td>{{ $post->status }}</td>
                @if ($post->status == 'pending')
                <td><button class="btn btn-primary">Action</button></td>
            @else
            <td>
                <form action="{{ url('remove/posts/' . $post->id) }}" method="POST" style="display: inline;">
                    @csrf  
                  
                        <button type="submit" class="btn btn-primary">Remove</button>
                 </form>
            
                

            </td> <!-- Leave the Operations cell empty for non-pending posts -->
            @endif
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
