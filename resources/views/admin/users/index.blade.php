@extends('layouts.main') 
@section('pageTitle', 'User overview')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1>User overview</h1>
    </div>
</div>
<div class="container">
    @include('layouts.partials.messages')
    @if (count($users) > 0 )
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined on</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <a href="#">Edit</a> |
                    <a href="#">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">
        There are no users
    </div>
    @endif

    <a href="{{ route('create_user') }}" class="btn btn-sm btn-primary" role="button">Add</a>
</div>
@endsection