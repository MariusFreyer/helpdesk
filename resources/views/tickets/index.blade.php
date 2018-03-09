@extends('layouts.main') 
@section('pageTitle', 'Ticket overview') 
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1>Ticket overview</h1>
    </div>
</div>
<div class="container">
    @include('layouts.partials.messages')
    <h2>My Tickets</h2>
    <p>The tickets below need processing</p>
    @if (count($my_tickets) > 0 )
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Subject</th>
                <th>User</th>
                <th>Status</th>
                <th>Assigne</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($my_tickets as $ticket)
            <form id="close-form-{{ $ticket->id }}" action="{{ route('close_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
            <form id="finish-form-{{ $ticket->id }}" action="{{ route('finish_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
            <form id="unassign-form-{{ $ticket->id }}" action="{{ route('release_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
            <tr>
                <td><a href="{{ route('show_ticket', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                <td>{{ $ticket->user->name }}</td>
                <td>
    @include('layouts.partials.ticketProgress')</td>
                <td>@if($ticket->assigne) {{ $ticket->assigne->name }} @endif</td>
                <td>
                    <a href="{{ route('close_ticket', $ticket->id) }}" onclick="event.preventDefault();
                    document.getElementById('close-form-{{ $ticket->id }}').submit();">Close</a> |
                    <a href="{{ route('finish_ticket', $ticket->id) }}" onclick="event.preventDefault();
                            document.getElementById('finish-form-{{ $ticket->id }}').submit();">Finish</a> |
                    <a href="{{ route('release_ticket', $ticket->id) }}" onclick="event.preventDefault();
                            document.getElementById('unassign-form-{{ $ticket->id }}').submit();">Unassign</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">
        You have no open tickets!
    </div>
    @endif
    <hr class="mb-5 mt-5">
    <h2>Open Tickets</h2>
    <p>The tickets below need processing</p>
    @if (count($open_tickets) > 0)
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Subject</th>
                <th>User</th>
                <th>Status</th>
                <th>Assigne</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($open_tickets as $ticket)
            <form id="close-form-{{ $ticket->id }}" action="{{ route('close_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
            <form id="finish-form-{{ $ticket->id }}" action="{{ route('finish_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
            <form id="assign-form-{{ $ticket->id }}" action="{{ route('assign_ticket', ['ticket' => $ticket->id, 'user_id' => Auth::id()]) }}" method="POST"
                style="display: none;">@csrf</form>
            <tr>
                <td><a href="{{ route('show_ticket', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                <td>{{ $ticket->user->name }}</td>
                <td>
    @include('layouts.partials.ticketProgress')</td>
                <td>@if($ticket->assigne) {{ $ticket->assigne->name }} @endif</td>
                <td>
                    <a href="{{ route('close_ticket', $ticket->id) }}" onclick="event.preventDefault();
                                document.getElementById('close-form-{{ $ticket->id }}').submit();">Close</a> |
                    <a href="{{ route('finish_ticket', $ticket->id) }}" onclick="event.preventDefault();
                                        document.getElementById('finish-form-{{ $ticket->id }}').submit();">Finish</a>                    |
                    <a href="{{ route('assign_ticket', ['ticket' => $ticket->id, 'user_id' => Auth::id()]) }}" onclick="event.preventDefault();
                                        document.getElementById('assign-form-{{ $ticket->id }}').submit();">Assign</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">
        There are no open tickets
    </div>
    @endif
    <hr class="mb-5 mt-5">
    <h2>Finished Tickets</h2>
    <p>The tickets below are closed or finished</p>
    @if (count($closed_tickets) > 0 )
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Subject</th>
                <th>User</th>
                <th>Status</th>
                <th>Assigne</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($closed_tickets as $ticket)
            <form id="reopen-form-{{ $ticket->id }}" action="{{ route('reopen_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
            <form id="reset-form-{{ $ticket->id }}" action="{{ route('reset_ticket', $ticket->id) }}" method="POST" style="display: none;">@csrf</form>
            <tr>
                <td><a href="{{ route('show_ticket', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                <td>{{ $ticket->user->name }}</td>
                <td>
    @include('layouts.partials.ticketProgress')</td>
                <td>@if($ticket->assigne) {{ $ticket->assigne->name }} @endif</td>
                <td>
                    <a href="{{ route('reopen_ticket', $ticket->id) }}" onclick="event.preventDefault();
                        document.getElementById('reopen-form-{{ $ticket->id }}').submit();">Reopen</a> |
                    <a href="{{ route('reset_ticket', $ticket->id) }}" onclick="event.preventDefault();
                                document.getElementById('reset-form-{{ $ticket->id }}').submit();">Reset</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">
        There are no finished/closed tickets
    </div>
    @endif
</div>
@endsection