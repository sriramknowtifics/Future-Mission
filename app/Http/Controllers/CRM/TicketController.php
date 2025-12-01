<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:crm']);
    }

    public function index()
    {
        $tickets = Ticket::with('user','order')->orderByDesc('created_at')->paginate(25);
        return view('crm.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('crm.tickets.show', compact('ticket'));
    }

    public function respond(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'message' => 'required|string',
            'status' => 'nullable|in:open,pending,resolved,closed'
        ]);

        // TODO: implement TicketReply model & save reply; for now update ticket message and status
        $ticket->message = $ticket->message . "\n\nSupport: " . $data['message'];
        if (!empty($data['status'])) $ticket->status = $data['status'];
        $ticket->save();

        // TODO: notify user via email
        return back()->with('success','Response sent.');
    }
}
