@extends('layouts.main') 
@section('pageTitle', 'New user') 
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1>Create new user</h1>
    </div>
</div>
<div class="container">
    @include('layouts.partials.messages')
    <form method="POST" action="{{ route('store_user') }}">
        <div class="card">
            <div class="card-header">Create user</div>
            <div class="card-body">
                <div class="row">
                    @csrf
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input name="name" type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input name="email" type="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Send</button>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input name="password" type="text" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <label for="email">Role:</label>
                            <select class="form-control" id="role" name="role">
                            <option>user</option>
                            <option>supporter</option>
                            <option>admin</option>
                    </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection