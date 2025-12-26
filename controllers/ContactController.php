<?php

declare(strict_types=1);

require_once __DIR__ . '/../BaseController.php';

class ContactController extends BaseController
{
    public function index(): void
    {
        $data = [
            'title' => 'Contact Us',
            'heading' => 'Get In Touch',
            'csrf_token' => $this->generateCsrfToken(),
        ];
        
        $this->viewWithLayout('contact', $data);
    }
    
    public function submit(): void
    {
        try {
            // Validate CSRF token
            $this->validateCsrfToken();
            
            // Get and sanitize input
            $name = $this->sanitize($this->post('name', ''));
            $email = $this->sanitize($this->post('email', ''));
            $message = $this->sanitize($this->post('message', ''));
            
            // Validate input
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Name is required';
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Valid email is required';
            }
            
            if (empty($message)) {
                $errors[] = 'Message is required';
            }
            
            if (!empty($errors)) {
                $this->json(['success' => false, 'errors' => $errors], 400);
                return;
            }
            
            // Process the form (save to database, send email, etc.)
            // For now, we'll just return success
            
            $this->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'errors' => ['An error occurred. Please try again.'],
            ], 500);
        }
    }
}
