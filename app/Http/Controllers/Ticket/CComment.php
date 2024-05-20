<?php

namespace App\Http\Controllers\Ticket;

use App\Models\Ticket;
use App\Models\Comment;
use App\Models\MPegawai;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CommentNotification;
use App\Http\Requests\Ticket\CommentRequest;
use Illuminate\Support\Facades\Notification;

class CComment extends Controller
{
    use ResponseOutput;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $comment = Comment::where('ticket_id', $request->ticket_id)->with('user')->orderBy('created_at', 'asc')->get();
        $user = Auth::user();
        $formattedComments = $comment->map(function ($comment) use ($user) {
            $comment->is_my_comment = $comment->created_by === $user->id;
            return $comment;
        });
       
        return response()->json([
            'comment' => $formattedComments->values()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $validate = $request->validated();
            Comment::create($validate);
            $ticket = Ticket::findOrFail($validate['ticket_id']);
            $technicianIds = $ticket->technician()->pluck('technician_id')->toArray();
            if (Auth::user()->role == 'staff') {
                $technicians = MPegawai::whereIn('id', $technicianIds)->with('user')->get();
                $user = $technicians->pluck('user');
            } elseif (Auth::user()->role == 'teknisi') {
                $user = MPegawai::where('id', $ticket->staff_id)->with('user')->first();
                $user = $user->user;
            }
            Notification::send($user, new CommentNotification($ticket));
            return $this->responseSuccess(['success' => true]);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
