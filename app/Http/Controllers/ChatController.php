<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function rooms(){
        return ChatRoom::all();
    }
    
    public function messages(ChatRoom $room){
        return ChatMessage::where('chat_room_id', $room->id)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function newMessages(Request $request, ChatRoom $room){
        $newMsg = new ChatMessage;
        $newMsg->user_id = auth()->user()->id;
        $newMsg->chat_room_id = $room->id;
        $newMsg->message = $request->message;
        $newMsg->save();

        return $newMsg;
    }
}
