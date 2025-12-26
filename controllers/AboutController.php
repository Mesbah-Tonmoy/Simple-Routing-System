<?php

declare(strict_types=1);

require_once __DIR__ . '/../BaseController.php';

class AboutController extends BaseController
{
    public function index(): void
    {
        $data = [
            'title' => 'About Us',
            'heading' => 'About Our Application',
            'features' => [
                'Secure routing with input sanitization',
                'SOLID principles implementation',
                'PHP 8.4 best practices',
                'DRY methodology',
                'CSRF protection',
                'XSS prevention',
            ],
        ];
        
        $this->viewWithLayout('about', $data);
    }
}