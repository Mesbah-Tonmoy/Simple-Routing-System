<?php

declare(strict_types=1);

/**
 * Application Entry Point
 * 
 * This file handles all incoming HTTP requests and bootstraps the application.
 * All requests should be routed through this file using .htaccess (Apache).
 */

// Error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set default timezone
date_default_timezone_set('UTC');

// Autoloader for classes (PSR-4 style)
spl_autoload_register(function (string $class): void {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Remove PHP version exposure
header_remove('X-Powered-By');

// Start session securely
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'use_strict_mode' => true,
]);

try {
    // Initialize Router
    $router = new Router();
    
    // Define Routes
    $router->get('/', 'HomeController@index');
    $router->get('/about', 'AboutController@index');
    $router->get('/contact', 'ContactController@index');
    $router->post('/contact', 'ContactController@submit');
    
    // Dynamic route example
    $router->get('/user/{id}', 'UserController@show');
    $router->get('/product/{slug}', 'ProductController@show');    
    
    // Dispatch the request
    $router->dispatch();
    
} catch (Throwable $e) {
    // Log error with full context
    error_log(sprintf(
        "[%s] %s in %s:%d\nStack trace:\n%s",
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    ));
    
    // Determine if we're in development mode
    $isDevelopment = php_sapi_name() === 'cli-server' 
        || ($_ENV['APP_ENV'] ?? 'production') === 'development'
        || true; // Remove this in production
    
    // Set appropriate HTTP status code
    http_response_code(500);
    
    if ($isDevelopment) {
        // Development: Show detailed error information
        $errorClass = get_class($e);
        $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $errorFile = $e->getFile();
        $errorLine = $e->getLine();
        $errorTrace = htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8');
        
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Application Error</title>
            <style>
                body { font-family: system-ui, sans-serif; padding: 2rem; background: #f5f5f5; }
                .error-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
                h1 { color: #e53e3e; margin: 0 0 1rem; }
                .error-type { color: #718096; font-size: 0.875rem; margin-bottom: 1rem; }
                pre { background: #2d3748; color: #e2e8f0; padding: 1rem; border-radius: 4px; overflow-x: auto; }
                .file-info { color: #4a5568; margin: 1rem 0; }
            </style>
        </head>
        <body>
            <div class="error-container">
                <h1>Application Error</h1>
                <div class="error-type">{$errorClass}</div>
                <div class="file-info">
                    <strong>File:</strong> {$errorFile}<br>
                    <strong>Line:</strong> {$errorLine}
                </div>
                <h2>Message:</h2>
                <pre>{$errorMessage}</pre>
                <h2>Stack Trace:</h2>
                <pre>{$errorTrace}</pre>
            </div>
        </body>
        </html>
        HTML;
    } else {
        // Production: Show user-friendly error page
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>500 - Internal Server Error</title>
            <style>
                body { 
                    font-family: system-ui, sans-serif; 
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    min-height: 100vh; 
                    margin: 0;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }
                .container { 
                    text-align: center; 
                    background: white; 
                    padding: 3rem; 
                    border-radius: 8px; 
                    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
                }
                h1 { font-size: 4rem; margin: 0; color: #667eea; }
                p { font-size: 1.25rem; color: #4a5568; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>500</h1>
                <p>Internal Server Error</p>
                <p>Something went wrong. Please try again later.</p>
            </div>
        </body>
        </html>
        HTML;
    }
}