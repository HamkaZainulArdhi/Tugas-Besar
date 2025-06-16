<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer UFkOfJaclj61OxoD7MnQknU1S2XwNdXMuSZA+EZGLkc=',
        ])->post('https://api.deepenglish.com/api/gpt_open_ai/chatnew', [
            'messages' => [
                ['role' => 'user', 'content' => $userMessage],
                ['role' => 'system', 'content' => 'Gunakan bahasa Indonesia yang baik dan benar, Jangan Kaku'],
            ],
            'temperature' => 1,
            'projectName' => 'wordpress',
        ]);

        return response()->json([
            'message' => $response['message'] ?? 'AI tidak merespons.',
        ]);
    }
}
