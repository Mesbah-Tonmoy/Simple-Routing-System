<style>
    .hero {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        margin-bottom: 3rem;
    }
    
    .hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .hero p {
        font-size: 1.25rem;
        opacity: 0.9;
    }
    
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    
    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
    }
    
    .feature-card h3 {
        color: #667eea;
        margin-bottom: 1rem;
    }
</style>

<div class="hero">
    <h1><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
</div>

<div class="features">
    <div class="feature-card">
        <h3>🔒 Secure</h3>
        <p>Built with security in mind - CSRF protection, XSS prevention, and input sanitization out of the box.</p>
    </div>
    
    <div class="feature-card">
        <h3>⚡ Fast</h3>
        <p>Lightweight and optimized for performance with minimal overhead and smart caching.</p>
    </div>
    
    <div class="feature-card">
        <h3>🎯 Modern</h3>
        <p>Leverages PHP 8.4 features including readonly properties, union types, and strict typing.</p>
    </div>
</div>