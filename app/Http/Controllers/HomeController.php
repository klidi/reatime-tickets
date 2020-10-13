<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\TicketServiceInterface;

class HomeController extends Controller
{
    private $ticketService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, TicketServiceInterface $ticketService)
    {
        $this->middleware('auth');
        $this->ticketService = $ticketService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home')
            ->with('clearances', $this->ticketService->getClearanceValues());
    }
}
