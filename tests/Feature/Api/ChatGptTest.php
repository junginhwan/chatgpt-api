<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatGptTest extends TestCase
{
    public function post_api_chatgpt의_에러_응답을_확인()
    {
        $response = $this->postJson('/api/chatgpt', ['chat' => '']);
        $error_response = [
            'errors' => [
                'chat' => [
                    'validation.required',
                ],
            ],
            'status' => true
        ];
        $response->assertExactJson($error_response);
    }

    public function test_post_api_chatgpt의_응답을_확인()
    {
        $response = $this->postJson('/api/chatgpt', [
            'chat' => [
                [
                    'content' => 'php에 대해서 알려줘',
                ],
                [
                    'content' => '더 자세히 알려줘',
                ]
            ]
        ]);
        $response->assertStatus(200);
    }
}
