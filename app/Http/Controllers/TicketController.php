<?php

namespace App\Http\Controllers;

use App\Ticket;
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
        $request->user()->authorizeRoles(['admin']);

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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ticket = new Ticket();
        $ticket->subject = $request->input('subject');
        $ticket->body = $request->input('body');
        $ticket->user_id = Auth::user()->id;
        $ticket->status = 'open';

        if ($request->file('image')) {
            $image = $request->file('image')->store('public/tickets');
            $ticket->image = $image;
        }
        
        $ticket->save();

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
        if (($request->user()->id == $ticket->user_id) || $request->user()->hasRole('admin')) {
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
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
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
        $ticket = Ticket::find($ticket->id);
        $ticket->subject = $request->input('subject');
        $ticket->body = $request->input('body');
        $ticket->save();

        $request->session()->flash('alert-success', 'Ticket was successfully updated!');
        return redirect()->route('show_ticket', $ticket->id);
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
        $request->session()->flash('alert-success', 'Ticket was assigned.' );
        return back();
    }

    public function release(Ticket $ticket, Request $request)
    {
        $ticket = Ticket::where('id', $ticket->id)->get()->first();
        $ticket->assigne_id = null;
        $ticket->status = 'open';
        $ticket->save();
        $request->session()->flash('alert-success', 'Ticket was released.' );
        return back();
    }
}
