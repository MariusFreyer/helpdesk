@extends('layouts.main') 
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <form id="assign-form-{{ $ticket->id }}" action="{{ route('assign_ticket', ['ticket' => $ticket->id, 'user_id' => Auth::id()]) }}"
            method="POST" style="display: none;">@csrf</form>
        <form id="close-form-{{ $ticket->id }}" action="{{ route('close_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
        <form id="finish-form-{{ $ticket->id }}" action="{{ route('finish_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
        <div class="row">
            <div class="col-sm-9">
                <h1>{{ $ticket->subject }}</h1>
                <p>{{ $ticket->created_at }} by {{ $ticket->user->name }} @if ( $ticket->assigne ) | <strong>Assigne:</strong>                    {{ $ticket->assigne->name }}</p> @endif
            </div>
            @if (Auth::user()->hasRole('admin') || (Auth::user()->hasRole('supporter')))
            <div class="col-sm-3">
    @include('layouts.partials.ticketProgress')
                <div class="dropdown mt-3">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                            Change Status
                        </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('assign_ticket', ['ticket' => $ticket->id, 'user_id' => Auth::id()]) }}" onclick="event.preventDefault();
                                document.getElementById('assign-form-{{ $ticket->id }}').submit();">Assign</a>
                        <a class="dropdown-item" href="{{ route('close_ticket', $ticket->id) }}" onclick="event.preventDefault();
                                document.getElementById('close-form-{{ $ticket->id }}').submit();">Close</a>
                        <a class="dropdown-item" href="{{ route('finish_ticket', $ticket->id) }}" onclick="event.preventDefault();
                                document.getElementById('finish-form-{{ $ticket->id }}').submit();">Finish</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
    @include('layouts.partials.messages')
            <p>
                {{ $ticket->body }}
            </p>
            <div class="ticket-thumbnails mt-3">
                @foreach($ticket->attachments as $attachment)
                <a href="{{ asset(Storage::disk('local')->url($attachment->path))}}">
                    <img src="{{ asset(Storage::disk('local')->url($attachment->path))}}" alt="" class="img-thumbnail" width="150" />
                </a> @endforeach
            </div>
            <a href="{{ route('edit_ticket', $ticket->id) }}" class="btn btn-sm btn-primary" role="button">Edit</a>
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