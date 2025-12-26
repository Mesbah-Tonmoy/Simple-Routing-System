<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= htmlspecialchars($title ?? 'Home', ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8') ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Modern PHP routing system with security best practices">
    <meta name="robots" content="index, follow">
    
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --dark: #1a202c;
            --light: #f7fafc;
            --text: #2d3748;
            --border: #e2e8f0;
            --success: #48bb78;
            --error: #f56565;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: var(--text);
            background: var(--light);
        }
        
        /* Navigation */
        nav {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        nav .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        nav a:hover {
            opacity: 0.8;
        }
        
        /* Main Content */
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            min-height: calc(100vh - 200px);
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }
        
        footer a {
            color: var(--primary);
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            nav .container {
                flex-direction: column;
                gap: 1rem;
            }
            
            nav ul {
                gap: 1rem;
            }
            
            main {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container">
            <a href="<?= $base_path ?>/" class="logo"><?= htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8') ?></a>
            <ul>
                <li><a href="<?= $base_path ?>/">Home</a></li>
                <li><a href="<?= $base_path ?>/about">About</a></li>
                <li><a href="<?= $base_path ?>/contact">Contact</a></li>
                <li><a href="<?= $base_path ?>/user/123">User Demo</a></li>
                <li><a href="<?= $base_path ?>/product/laptop">Product Demo</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= $current_year ?> <?= htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8') ?>. All rights reserved.</p>
        <p>Requires PHP 8.1+ | Running PHP <?= phpversion() ?> | <a href="https://github.com" target="_blank">GitHub</a></p>
    </footer>
</body>
</html>