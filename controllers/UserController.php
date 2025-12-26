<?php

declare(strict_types=1);

require_once __DIR__ . '/../BaseController.php';

class UserController extends BaseController
{
    public function show(array $params): void
    {
        $userId = $params['id'] ?? 'unknown';
        
        // In a real app, you'd fetch user data from database
        $data = [
            'title' => 'User Profile',
            'heading' => 'User Profile',
            'user_id' => $this->sanitize($userId),
            'user' => [
                'id' => $userId,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'joined' => '2024-01-15',
            ],
        ];
        
        $this->viewWithLayout('user', $data);
    }
}
