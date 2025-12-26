<?php

declare(strict_types=1);

require_once __DIR__ . '/../BaseController.php';

class NotFoundController extends BaseController
{
    public function index(): void
    {
        http_response_code(404);
        
        $data = [
            'title' => '404 - Page Not Found',
            'heading' => '404',
            'message' => 'The page you are looking for does not exist.',
        ];
        
        $this->viewWithLayout('404', $data);
    }
}