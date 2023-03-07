<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ChatGptRequest;
use App\Services\ChatGptService;

class ChatGptController extends Controller
{
    //
    private $service;

    public function __construct(ChatGptService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ChatGptRequest $request)
    {
        $chat = $this->service->chat(json_decode($request->input('chat'), true));
        return response()->json([
            'result' => (!empty($chat)),
            'data' => $chat,
        ]);
    }
}
