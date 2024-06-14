@extends('admin.layouts.app')

@section('content')

<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card {
        width: calc(33.33% - 20px);
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .card h2 {
        margin-top: 0;
        color: #333;
    }

    .card p {
        color: #666;
        margin-bottom: 20px;
    }

    .card button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .card button:hover {
        background-color: #0056b3;
    }
</style>

<div class="card-container">
    <div class="card">
        <h2>Posts Pending</h2>
        <p>Posts sent by users who have not been approved</p>
        <a href="{{ url('posts/pending') }}"><button>Go To Posts</button></a>
    </div>
    

    <div class="card">
        <h2>Posts Accepted</h2>
        <p>Posts Admin Accepted it</p>
        <a href="{{ url('posts/accepted') }}"><button>Go To Posts</button></a>
    </div>

    <div class="card">
        <h2>Posts Disapprove</h2>
        <p>Posts sent by users who have not been Accepted</p>
        <a href="{{ url('posts/rejected') }}"><button>Go To Posts</button></a>
    </div>
</div>


@endsection
