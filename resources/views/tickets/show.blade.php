@extends('layouts.main') 
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <h1>{{ $ticket->subject }}</h1>
                <p>{{ $ticket->created_at }} by {{ $ticket->user->name }} @if ( $ticket->assigne ) | <strong>Assigne:</strong>                    {{ $ticket->assigne->name }}</p> @endif
            </div>
            <div class="col-sm-3">
                @if ($ticket->status == 'open')
                <div class="progress mt-4 bg-light">
                    <div class="progress-bar bg-danger" style="width:33.3%">
                        Open
                    </div>
                </div>
                @elseif ($ticket->status == 'assigned')
                <div class="progress mt-4 bg-light">
                    <div class="progress-bar bg-warning" style="width:66.6%">
                        Assigned
                    </div>
                </div>
                @elseif ($ticket->status == 'closed_success')
                <div class="progress mt-4 bg-light">
                    <div class="progress-bar bg-success" style="width:100%">
                        Finished
                    </div>
                </div>
                @elseif ($ticket->status == 'closed_error')
                <div class="progress mt-4 bg-light">
                    <div class="progress-bar bg-danger" style="width:100%">
                        Closed/Failed
                    </div>
                </div>
                @endif
                <div class="dropdown mt-3">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                            Change Status
                        </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <p>
                {{ $ticket->body }}
            </p>
        </div>
    </div>
    <hr class="mt-4 mb-4">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="mb-3">Comments</h3>
            @foreach ($ticket->comments as $comment)
            <div class="card mb-4">
                <div class="card-header">
                    <strong>{{ $comment->user->name }}</strong> on {{ $comment->created_at }}
                </div>
                <div class="card-body">
                    {{ $comment->body }}
                </div>
            </div>
            @endforeach
            <div class="card">
                <div class="card-header">
                    New comment
                </div>
                <div class="card-body">
    @include('layouts.partials.messages')
                    <form method="POST" action="{{ route('store_comment', $ticket->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="body">Text:</label>
                            <textarea name="body" type="text" class="form-control" id="body" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection