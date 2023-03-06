<?php

declare(strict_types=1);

namespace App\Entitys;

use Exception;
use InvalidArgumentException;

class ChatGptEntity
{
    private $role;
    private $content;

    public function __construct(string|null $role, string $content)
    {
        $this->setRole($role);
        $this->setContent($content);
    }

    public function setRole(string|null $role): void
    {
        $this->role = match ($role) {
            null => "assistant",
            'assistant', 'user', 'system' => $role,
            default => throw new InvalidArgumentException("role을 확인해 주세요."),
        };
    }

    public function setContent(string $content): void
    {
        if (empty($content)) {
            throw new InvalidArgumentException("content를 확인해 주세요.");
        }
        $this->content = $content;
    }

    public function get(): array
    {
        return [
            'role' => $this->role,
            'content' => $this->content,
        ]; 
    }
}