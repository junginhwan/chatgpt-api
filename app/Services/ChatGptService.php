<?php

declare(strict_types=1);

namespace App\Services;

use App\Entitys\ChatGptEntity;
use Orhanerday\OpenAi\OpenAi;

Class ChatGptService 
{
    private $open_ai;
    private $model;

    public function __construct()
    {
        $this->open_ai = new OpenAi(env('OPEN_AI_API_KEY'));
        $this->model = env('CHAT_GPT_MODEL');
    }

    public function chat(Array $param)
    {
        return $this->open_ai->chat([
            'model' => $this->model,
            'messages' => $this->messages($param),
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
         ]);
    }

    private function messages(array $param): array
    {
        $result = [];
        foreach ($param as $value) {
            $chat_gpt = new ChatGptEntity($value['role'] ?? null, $value['content']);
            $result[] = $chat_gpt->get();
        }
        return $result;
    }
}