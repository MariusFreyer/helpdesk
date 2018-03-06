@extends('layouts.main') 
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
            <tr>
                <td><a href="{{ route('show_ticket', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                <td>{{ $ticket->user->name }}</td>
                <td>
                    @if ($ticket->status == 'open')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-danger" style="width:33.3%">
                            Open
                        </div>
                    </div>
                    @elseif ($ticket->status == 'assigned')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-warning" style="width:66.6%">
                            Assigned
                        </div>
                    </div>
                    @elseif ($ticket->status == 'closed_success')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-success" style="width:100%">
                            Finished
                        </div>
                    </div>
                    @elseif ($ticket->status == 'closed_error')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-danger" style="width:100%">
                            Closed/Failed
                        </div>
                    </div>
                    @endif
                </td>
                <td>@if($ticket->assigne) {{ $ticket->assigne->name }} @else Take @endif</td>
                <td>Edit | Close | <a href="{{ route('release_ticket', $ticket->id)}}">Release</a></td>
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
            <tr>
                <td><a href="{{ route('show_ticket', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                <td>{{ $ticket->user->name }}</td>
                <td>
                    @if ($ticket->status == 'open')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-danger" style="width:33.3%">
                            Open
                        </div>
                    </div>
                    @elseif ($ticket->status == 'assigned')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-warning" style="width:66.6%">
                            Assigned
                        </div>
                    </div>
                    @elseif ($ticket->status == 'closed_success')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-success" style="width:100%">
                            Finished
                        </div>
                    </div>
                    @elseif ($ticket->status == 'closed_error')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-danger" style="width:100%">
                            Closed/Failed
                        </div>
                    </div>
                    @endif
                </td>
                <td>@if($ticket->assigne) {{ $ticket->assigne->name }} @else Take @endif</td>
                <td><a href="{{route('assign_ticket', ['ticket' => $ticket->id, 'user_id' => Auth::id()]) }}">Take</a> | Close</td>
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
            <tr>
                <td><a href="{{ route('show_ticket', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                <td>{{ $ticket->user->name }}</td>
                <td>
                    @if ($ticket->status == 'open')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-danger" style="width:33.3%">
                            Open
                        </div>
                    </div>
                    @elseif ($ticket->status == 'assigned')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-warning" style="width:66.6%">
                            Assigned
                        </div>
                    </div>
                    @elseif ($ticket->status == 'closed_success')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-success" style="width:100%">
                            Finished
                        </div>
                    </div>
                    @elseif ($ticket->status == 'closed_error')
                    <div class="progress mt-1 bg-light">
                        <div class="progress-bar bg-danger" style="width:100%">
                            Closed/Failed
                        </div>
                    </div>
                    @endif
                </td>
                <td>@if($ticket->assigne) {{ $ticket->assigne->name }} @else Take @endif</td>
                <td>Edit | Take | Close</td>
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