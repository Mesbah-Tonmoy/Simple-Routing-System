# Simple Routing System

A modern, secure PHP routing system built with best practices and PHP 8.4 compatibility. Features MVC architecture, dynamic routes, and comprehensive security measures.

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## ✨ Features

- 🚀 **Modern PHP** - Built with PHP 8.1+ features (strict types, readonly properties, union types)
- 🔒 **Security First** - CSRF protection, XSS prevention, input sanitization, secure sessions
- 🎯 **Dynamic Routing** - Support for route parameters like `/user/{id}` and `/product/{slug}`
- 🏗️ **MVC Architecture** - Clean separation of concerns with controllers and views
- 🌐 **Multiple HTTP Methods** - GET, POST, PUT, DELETE, PATCH support
- 📁 **Subdirectory Support** - Works in both root and subdirectory installations
- 🎨 **Beautiful UI** - Responsive design with modern gradients and animations
- 🐛 **Smart Error Handling** - Detailed error pages in development, user-friendly in production
- ⚡ **Performance** - Lightweight with minimal overhead and GZIP compression

## 📋 Requirements

- PHP 8.1 or higher
- Apache with mod_rewrite enabled
- Composer (optional, for future dependencies)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Mesbah-Tonmoy/Simple-Routing-System.git
cd Simple-Routing-System
```

### 2. Configure Apache

**For XAMPP/WAMP (Subdirectory Installation):**

Place the project in your `htdocs` folder. The system automatically detects the base path.

Example: `C:\xampp\htdocs\Simple-Routing-System\`

Update `.htaccess` line 9 to match your directory name:
```apache
RewriteBase /Simple-Routing-System/
```

**For Production (Root Installation):**

Update `.htaccess` line 9:
```apache
RewriteBase /
```

### 3. Set Permissions (Linux/Mac)

```bash
chmod -R 755 .
```

### 4. Access Your Application

- **Local:** `http://localhost/Simple-Routing-System/`
- **Production:** `http://yourdomain.com/`

## 📖 Usage

### Defining Routes

Routes are defined in `index.php`:

```php
// Simple routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'AboutController@index');

// POST route
$router->post('/contact', 'ContactController@submit');

// Dynamic routes with parameters
$router->get('/user/{id}', 'UserController@show');
$router->get('/product/{slug}', 'ProductController@show');
```

### Creating a Controller

Create a new controller in the `controllers/` directory:

```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../BaseController.php';

class ExampleController extends BaseController
{
    public function index(): void
    {
        $data = [
            'title' => 'Example Page',
            'message' => 'Hello, World!',
        ];
        
        $this->viewWithLayout('example', $data);
    }
    
    public function show(array $params): void
    {
        $id = $params['id'] ?? null;
        
        $data = [
            'title' => 'Item Details',
            'id' => $id,
        ];
        
        $this->viewWithLayout('example-detail', $data);
    }
}
```

### Creating a View

Create a view file in the `views/` directory:

```php
<!-- views/example.php -->
<style>
    .container {
        padding: 2rem;
        text-align: center;
    }
</style>

<div class="container">
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
</div>
```

## 🏗️ Project Structure

```
Simple-Routing-System/
├── controllers/          # Application controllers
│   ├── HomeController.php
│   ├── AboutController.php
│   ├── ContactController.php
│   ├── UserController.php
│   ├── ProductController.php
│   └── NotFoundController.php
├── views/               # View templates
│   ├── layout.php       # Main layout wrapper
│   ├── home.php
│   ├── about.php
│   ├── contact.php
│   ├── user.php
│   ├── product.php
│   └── 404.php
├── .htaccess           # Apache configuration
├── index.php           # Application entry point
├── Router.php          # Core routing class
├── BaseController.php  # Base controller class
└── README.md          # This file
```

## 🔒 Security Features

### Built-in Protection

- **CSRF Tokens** - Generate and validate tokens for forms
- **XSS Prevention** - All output is escaped with `htmlspecialchars()`
- **Input Sanitization** - Helper methods for safe data handling
- **Secure Sessions** - HttpOnly, SameSite, and Strict mode enabled
- **Security Headers** - X-Frame-Options, CSP, X-Content-Type-Options
- **Directory Protection** - Controllers and views are not directly accessible

### Using CSRF Protection

```php
// In your controller
public function showForm(): void
{
    $data = [
        'csrf_token' => $this->generateCsrfToken(),
    ];
    $this->viewWithLayout('form', $data);
}

public function submitForm(): void
{
    $this->validateCsrfToken(); // Throws exception if invalid
    
    // Process form...
}
```

### In Your View

```php
<form method="POST" action="<?= $base_path ?>/submit">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <!-- Other form fields -->
</form>
```

## 🎨 Customization

### Changing Site Name

Edit `BaseController.php` line 40:

```php
'site_name' => 'Your App Name',
```

### Styling

The layout uses inline CSS for simplicity. You can:
- Modify `views/layout.php` for global styles
- Add custom styles in individual view files
- Create a separate CSS file and link it in the layout

## 🐛 Error Handling

### Development Mode

Set in `index.php` line 85:
```php
$isDevelopment = true; // Shows detailed errors
```

### Production Mode

```php
$isDevelopment = false; // Shows user-friendly error page
```

## 📝 API Reference

### Router Class

```php
// Register routes
$router->get(string $path, string|callable $handler): self
$router->post(string $path, string|callable $handler): self
$router->put(string $path, string|callable $handler): self
$router->delete(string $path, string|callable $handler): self
$router->patch(string $path, string|callable $handler): self

// Dispatch the current request
$router->dispatch(): void

// Get all registered routes (debugging)
$router->getRoutes(): array
```

### BaseController Methods

```php
// Render a view
protected function view(string $view, array $data = []): void

// Render a view with layout
protected function viewWithLayout(string $view, array $data = [], string $layout = 'layout'): void

// Get POST/GET data safely
protected function post(string $key, mixed $default = null): mixed
protected function get(string $key, mixed $default = null): mixed

// Sanitize input
protected function sanitize(string $input): string

// Redirect
protected function redirect(string $url, int $statusCode = 302): never

// JSON response
protected function json(array $data, int $statusCode = 200): void

// CSRF protection
protected function generateCsrfToken(): string
protected function validateCsrfToken(): void
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

## 👤 Author

**Mesbah Tonmoy**

- GitHub: [@Mesbah-Tonmoy](https://github.com/Mesbah-Tonmoy)

## 🙏 Acknowledgments

- Built with modern PHP best practices
- Inspired by popular PHP frameworks (Laravel, Symfony)
- Security guidelines from OWASP

## 📚 Learn More

- [PHP Documentation](https://www.php.net/docs.php)
- [OWASP Security Guide](https://owasp.org/www-project-web-security-testing-guide/)
- [PSR Standards](https://www.php-fig.org/psr/)

---

⭐ If you find this project useful, please consider giving it a star on GitHub!
