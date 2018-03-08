@extends('layouts.main') 
@section('content')
<div class="jumbotron jumbotron-fluid">
    <form method="POST" action="{{ route('update_ticket', $ticket->id) }}">
        <div class="container">
            <div class="row">
                @csrf {{ method_field('PATCH') }}
                <div class="col-sm-12">
                    <h1><input name="subject" type="subject" class="form-control" id="subject" value="{{ $ticket->subject }}"></h1>
                    <p>{{ $ticket->created_at }} by {{ $ticket->user->name }} @if ( $ticket->assigne ) | <strong>Assigne:</strong>                        {{ $ticket->assigne->name }}</p> @endif
                </div>
            </div>
        </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <p>
                <textarea name="body" type="text" class="form-control" id="body" rows="10">{{ $ticket->body }}</textarea>
            </p>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
    </form>
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