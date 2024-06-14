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

<h2 style="color: blue">Predict User History </h2>
<br>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>user_budget </th>
            <th>user_time</th>
            <th>user_risk</th>
  
         </tr>
    </thead>
    <tbody>
        @foreach ($predicts as $predict)
            <tr>
                <td>{{ $predict->id }}</td>
                <td>{{ $predict->user_budget }} EG</td>
                <td>{{ $predict->user_time }} Month</td>
                <td>{{ $predict->user_risk }}</td>
                
                 
                
                  
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
