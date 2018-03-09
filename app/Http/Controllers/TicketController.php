<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $open_tickets = Ticket::where('status', 'open')->where('assigne_id', null)->get();
        $closed_tickets = Ticket::whereIn('status', ['closed_error', 'closed_success'])->get();
        $my_tickets = Ticket::where('assigne_id', Auth::id())->whereIn('status', ['open', 'assigned'])->get();

        return view('tickets.index',
            ['open_tickets' => $open_tickets, 'closed_tickets' => $closed_tickets, 'my_tickets' => $my_tickets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'body' => 'required',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ticket = Auth::user()->tickets()->create([
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'status' => 'open',
        ]);
        if ($request->file('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/tickets');
                $ticket->attachments()->create([
                    'path' => $path,
                ]);
            }
        }

        $request->session()->flash('alert-success', 'Ticket was successfully added!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket, Request $request)
    {
        if ($this->isPermitted($ticket, $request)) {
            return view('tickets.show', compact('ticket'));
        }
        return abort(403, 'Access denied');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket, Request $request)
    {
        if ($this->isPermitted($ticket, $request)) {
            return view('tickets.edit', compact('ticket'));
        }
        return abort(403, 'Access denied');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        if ($this->isPermitted($ticket, $request)) {
            $ticket = Ticket::find($ticket->id);
            $ticket->subject = $request->input('subject');
            $ticket->body = $request->input('body');
            $ticket->save();

            $request->session()->flash('alert-success', 'Ticket was successfully updated!');
            return redirect()->route('show_ticket', $ticket->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function assign(Ticket $ticket, int $user_id, Request $request)
    {
        $ticket = Ticket::where('id', $ticket->id)->get()->first();
        $ticket->assigne_id = $user_id;
        $ticket->status = 'assigned';
        $ticket->save();
        $request->session()->flash('alert-success', 'Ticket was assigned.');
        return back();
    }

    public function release(Ticket $ticket, Request $request)
    {
        $ticket = Ticket::where('id', $ticket->id)->get()->first();
        $ticket->assigne_id = null;
        $ticket->status = 'open';
        $ticket->save();
        $request->session()->flash('alert-success', 'Ticket was released.');
        return back();
    }

    public function close(Ticket $ticket, Request $request)
    {
        $this->changeStatus($ticket, 'closed_error');
        $request->session()->flash('alert-success', 'Ticket was closed.');
        return back();
    }

    public function finish(Ticket $ticket, Request $request)
    {
        $this->changeStatus($ticket, 'closed_success');
        $request->session()->flash('alert-success', 'Ticket was fished.');
        return back();
    }

    public function reopen(Ticket $ticket, Request $request)
    {
        $this->changeStatus($ticket, 'assigned');
        $request->session()->flash('alert-success', 'Ticket was closed.');
        return back();
    }

    public function reset(Ticket $ticket, Request $request)
    {
        $this->changeStatus($ticket, 'open');
        $ticket = Ticket::where('id', $ticket->id)->get()->first();
        $ticket->assigne_id = null;
        $ticket->save();
        $request->session()->flash('alert-success', 'Ticket was reset to initial state.');
        return back();
    }

    private function changeStatus(Ticket $ticket, string $status)
    {
        $ticket = Ticket::where('id', $ticket->id)->get()->first();
        $ticket->status = $status;
        $ticket->save();
    }

    /**
     * Checks if the ticket belongs to the requesting user or if user is supporter or admin
     */
    private function isPermitted(Ticket $ticket, Request $request)
    {
        return ($request->user()->id == $ticket->user_id || $request->user()->role == User::ADMIN_ROLE
            || $request->user()->role == User::SUPPORTER_ROLE);
    }

}
