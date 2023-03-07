<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatGptTest extends TestCase
{
    /**
     * @test
     */
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

    /**
     * @test
     */
    public function post_api_chatgpt의_응답을_확인()
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

    /**
     * @test
     */
    public function post_api_chatgpt에서_role을_임의값으로_전송시_에러확인()
    {
        $response = $this->postJson('/api/chatgpt', [
            'chat' => [
                [
                    'content' => 'php에 대해서 알려줘',
                    'role' => 'test'
                ]
            ]
        ]);
        $error_response = [
            'errors' => [
                'chat.0.role' => [
                    'validation.in',
                ],
            ],
            'status' => true
        ];
        $response->assertExactJson($error_response);
    }
}