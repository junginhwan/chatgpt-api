<?php

declare(strict_types=1);

namespace App\Services;

use Orhanerday\OpenAi\OpenAi;

Class ChatGptService 
{
    private $open_ai;
    private $model = "gpt-3.5-turbo";

    public function __construct()
    {
        $this->open_ai = new OpenAi(env('OPEN_AI_API_KEY'));
    }

    public function chat(Array $param)
    {
        dd($param);
        $complete = $this->open_ai->chat([
            'model' => $this->model,
            'messages' => [
                [
                    "role" => "system",
                    "content" => "You are a helpful assistant."
                ],
            ],
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
         ]);
    }
}