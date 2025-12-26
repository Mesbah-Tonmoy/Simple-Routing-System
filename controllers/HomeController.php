<?php

declare(strict_types=1);

require_once __DIR__ . '/../BaseController.php';

class HomeController extends BaseController
{
    public function index(): void
    {
        $data = [
            'title' => 'Home',
            'heading' => 'Welcome to Our PHP Routing System',
            'message' => 'This is a secure, modern PHP routing system built with best practices.',
        ];
        
        $this->viewWithLayout('home', $data);
    }
}