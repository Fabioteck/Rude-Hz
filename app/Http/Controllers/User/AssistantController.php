<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\OllamaAssistantService;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    protected OllamaAssistantService $assistant;

    public function __construct(OllamaAssistantService $assistant)
    {
        $this->assistant = $assistant;
    }

    public function index()
    {
        return view('user.assistant');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $reply = $this->assistant->chat($userMessage);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'reply' => $reply
            ]);
        }

        return back()->with('reply', $reply)->with('user_message', $userMessage);
    }
}
