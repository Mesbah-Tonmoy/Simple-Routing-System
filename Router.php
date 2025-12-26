<?php

declare(strict_types=1);

/**
 * Router Class
 * 
 * Handles URL routing with support for:
 * - Multiple HTTP methods (GET, POST, PUT, DELETE, PATCH)
 * - Dynamic route parameters
 */
final class Router
{
    /**
     * Registered routes storage
     */
    private array $routes = [];
    
    /**
     * Current request URI
     */
    private readonly string $requestUri;
    
    /**
     * Current request method
     */
    private readonly string $requestMethod;
    
    public function __construct()
    {
        $this->requestUri = $this->sanitizeUri($_SERVER['REQUEST_URI'] ?? '/');
        $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }
    
    /**
     * Register a GET route
     */
    public function get(string $path, string|callable $handler): self
    {
        return $this->addRoute('GET', $path, $handler);
    }
    
    /**
     * Register a POST route
     */
    public function post(string $path, string|callable $handler): self
    {
        return $this->addRoute('POST', $path, $handler);
    }
    
    /**
     * Register a PUT route
     */
    public function put(string $path, string|callable $handler): self
    {
        return $this->addRoute('PUT', $path, $handler);
    }
    
    /**
     * Register a DELETE route
     */
    public function delete(string $path, string|callable $handler): self
    {
        return $this->addRoute('DELETE', $path, $handler);
    }
    
    /**
     * Register a PATCH route
     */
    public function patch(string $path, string|callable $handler): self
    {
        return $this->addRoute('PATCH', $path, $handler);
    }
    
    /**
     * Add a route to the routing table
     * 
     * @throws InvalidArgumentException
     */
    private function addRoute(string $method, string $path, string|callable $handler): self
    {
        if (empty($path)) {
            throw new InvalidArgumentException('Route path cannot be empty');
        }
        
        if (is_string($handler) && !str_contains($handler, '@')) {
            throw new InvalidArgumentException(
                'String handler must be in format "Controller@method"'
            );
        }
        
        $pattern = $this->convertToRegex($path);
        
        $this->routes[$method][$pattern] = [
            'handler' => $handler,
        ];
        
        return $this;
    }
    
    /**
     * Convert route path to regex pattern
     * Supports parameters like {id}, {slug}, etc.
     */
    private function convertToRegex(string $path): string
    {
        // Normalize path to start with /
        $path = '/' . trim($path, '/');
        
        // Escape forward slashes
        $pattern = str_replace('/', '\/', $path);
        
        // Convert {param} to named capture groups
        $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^\/]+)', $pattern);
        
        return '/^' . $pattern . '$/';
    }
    
    /**
     * Sanitize and normalize URI
     */
    private function sanitizeUri(string $uri): string
    {
        // Remove query string
        $uri = parse_url($uri, PHP_URL_PATH) ?? '/';
        
        // Decode URL encoding
        $uri = urldecode($uri);
        
        // Handle subdirectory installation
        $scriptPath = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = str_replace('\\', '/', dirname($scriptPath));
        
        if ($basePath !== '/' && !empty($basePath)) {
            if (str_starts_with($uri, $basePath)) {
                $uri = substr($uri, strlen($basePath));
            }
        }
        
        // Remove multiple slashes
        $uri = preg_replace('/\/+/', '/', $uri);
        
        // Normalize to always start with /
        $uri = '/' . trim($uri, '/');
        
        // Prevent directory traversal
        if (str_contains($uri, '..')) {
            return '/';
        }
        
        return $uri;
    }
    
    /**
     * Dispatch the current request to appropriate handler
     * 
     * @throws RuntimeException
     */
    public function dispatch(): void
    {
        $route = $this->matchRoute();
        
        if ($route === null) {
            $this->handleNotFound();
            return;
        }
        
        $this->executeHandler($route['handler'], $route['params']);
    }
    
    /**
     * Match current request against registered routes
     */
    private function matchRoute(): ?array
    {
        $methodRoutes = $this->routes[$this->requestMethod] ?? [];
        $uri = $this->requestUri;
        
        foreach ($methodRoutes as $pattern => $route) {
            if (preg_match($pattern, $uri, $matches)) {
                // Extract only named parameters
                $params = array_filter(
                    $matches,
                    fn($key) => is_string($key),
                    ARRAY_FILTER_USE_KEY
                );
                
                return [
                    'handler' => $route['handler'],
                    'params' => $params,
                ];
            }
        }
        
        return null;
    }
    
    /**
     * Execute the route handler
     * 
     * @throws RuntimeException
     */
    private function executeHandler(string|callable $handler, array $params): void
    {
        if (is_callable($handler)) {
            $handler($params);
            return;
        }
        
        [$controllerName, $method] = explode('@', $handler);
        
        $controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            throw new RuntimeException(
                "Controller file not found: {$controllerFile}"
            );
        }
        
        require_once $controllerFile;
        
        if (!class_exists($controllerName)) {
            throw new RuntimeException("Controller class not found: {$controllerName}");
        }
        
        $controller = new $controllerName();
        
        if (!method_exists($controller, $method)) {
            throw new RuntimeException(
                "Method {$method} not found in controller {$controllerName}"
            );
        }
        
        // Call controller method with parameters
        $controller->$method($params);
    }
    
    /**
     * Handle 404 Not Found
     */
    private function handleNotFound(): void
    {
        http_response_code(404);
        
        $notFoundController = __DIR__ . '/controllers/NotFoundController.php';
        
        if (file_exists($notFoundController)) {
            require_once $notFoundController;
            $controller = new NotFoundController();
            $controller->index();
        } else {
            // Fallback 404 response
            echo $this->renderFallback404();
        }
    }
    
    /**
     * Render fallback 404 page when NotFoundController doesn't exist
     */
    private function renderFallback404(): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>404 - Page Not Found</title>
            <style>
                body { 
                    font-family: system-ui, -apple-system, sans-serif; 
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    min-height: 100vh; 
                    margin: 0;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                }
                .container { text-align: center; }
                h1 { font-size: 6rem; margin: 0; }
                p { font-size: 1.5rem; }
                a { color: white; text-decoration: underline; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>404</h1>
                <p>Page Not Found</p>
                <p><a href="/">Go back home</a></p>
            </div>
        </body>
        </html>
        HTML;
    }
    
    /**
     * Get all registered routes (useful for debugging)
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}