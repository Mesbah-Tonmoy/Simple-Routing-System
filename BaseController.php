<?php

declare(strict_types=1);

/**
 * Base Controller
 * 
 * All controllers should extend this base class to inherit
 * common functionality like view rendering, input validation, etc.
 */
abstract class BaseController
{
    /**
     * Views directory path
     */
    protected string $viewsPath;
    
    /**
     * Shared data available to all views
     */
    protected array $viewData = [];
    
    public function __construct()
    {
        $this->viewsPath = __DIR__ . '/views/';
        
        // Set default shared data
        $this->viewData = [
            'site_name' => 'Simple Routing System',
            'current_year' => date('Y'),
            'base_path' => $this->getBasePath(),
        ];
    }
    
    /**
     * Get base path for URL generation
     * Computed dynamically based on server configuration
     */
    protected function getBasePath(): string
    {
        $scriptPath = $_SERVER['SCRIPT_NAME'] ?? '';
        $path = str_replace('\\', '/', dirname($scriptPath));
        return $path === '/' ? '' : $path;
    }
    
    /**
     * Render a view with data
     * 
     * @param string $view View file name (without .php extension)
     * @param array $data Data to pass to the view
     * @throws RuntimeException If view file doesn't exist
     */
    protected function view(string $view, array $data = []): void
    {
        $viewFile = $this->viewsPath . $view . '.php';
        
        if (!file_exists($viewFile)) {
            throw new RuntimeException("View not found: {$view}");
        }
        
        // Merge view-specific data with shared data
        $data = [...$this->viewData, ...$data];
        
        (function() use ($viewFile, $data): void {
            foreach ($data as $__key => $__value) {
                $$__key = $__value;
            }
            unset($__key, $__value);
            
            require $viewFile;
        })();
    }
    
    /**
     * Render a view with layout wrapper
     * 
     * @param string $view View file name
     * @param array $data Data to pass to the view
     * @param string $layout Layout file name (default: 'layout')
     */
    protected function viewWithLayout(string $view, array $data = [], string $layout = 'layout'): void
    {
        // Capture view content
        ob_start();
        $this->view($view, $data);
        $content = ob_get_clean();
        
        // Render with layout
        $this->view($layout, [...$data, 'content' => $content]);
    }
    
    /**
     * Get POST data safely
     * 
     * @param string $key The POST key
     * @param mixed $default Default value if key doesn't exist
     * @return mixed
     */
    protected function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get GET data safely
     * 
     * @param string $key The GET key
     * @param mixed $default Default value if key doesn't exist
     * @return mixed
     */
    protected function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Sanitize input string
     */
    protected function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Redirect to another URL
     * 
     * @param string $url URL to redirect to
     * @param int $statusCode HTTP status code (301 or 302)
     */
    protected function redirect(string $url, int $statusCode = 302): never
    {
        header("Location: {$url}", true, $statusCode);
        exit;
    }
    
    /**
     * Return JSON response
     * 
     * @param array $data Data to encode as JSON
     * @param int $statusCode HTTP status code
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Validate CSRF token
     * 
     * @throws RuntimeException If token is invalid
     */
    protected function validateCsrfToken(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            throw new RuntimeException('Invalid CSRF token');
        }
    }
    
    /**
     * Generate CSRF token
     */
    protected function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
}