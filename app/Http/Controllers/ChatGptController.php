<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ChatGptRequest;
use App\Services\ChatGptService;
use App\Services\PapagoService;

class ChatGptController extends Controller
{
    //
    private $service;
    private $translation_service;

    public function __construct(ChatGptService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ChatGptRequest $request)
    {

        $chats = $request->input('chat');
        if ($request->input('translation')) {
            $this->translation_service = new PapagoService();
            foreach ($chats as $key => $value) {
                $chats[$key]['content'] = $this->translation_service->translation($value['content'], 'ko', $request->input('translation')); 
            }
            $chat = $this->service->chat($chats);

            if ((!empty($chat))) {
                $decodes = json_decode($chat, true);
                foreach ($decodes['choices'] as $key => $value) {
                    $decodes['choices'][$key]['message']['content'] = $this->translation_service->translation($value['message']['content'], $request->input('translation'), 'ko');
                }
                $chat = json_encode($decodes);
            }
        } else {
            $chat = $this->service->chat($chats);
        }

        return response()->json([
            'result' => (!empty($chat)),
            'data' => $chat,
        ]);
    }
}
