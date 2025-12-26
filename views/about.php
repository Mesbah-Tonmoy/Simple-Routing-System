<style>
    .about-content {
        background: white;
        padding: 3rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .about-content h1 {
        color: #667eea;
        margin-bottom: 2rem;
    }
    
    .features-list {
        list-style: none;
        margin-top: 2rem;
    }
    
    .features-list li {
        padding: 1rem;
        margin-bottom: 0.5rem;
        background: #f7fafc;
        border-left: 4px solid #667eea;
        border-radius: 4px;
    }
    
    .features-list li:before {
        content: "✓ ";
        color: #48bb78;
        font-weight: bold;
        margin-right: 0.5rem;
    }
</style>

<div class="about-content">
    <h1><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
    
    <p>This is a demonstration of a modern PHP routing system that follows industry best practices and security standards.</p>
    
    <h2 style="margin-top: 2rem; color: #2d3748;">Key Features</h2>
    <ul class="features-list">
        <?php foreach ($features as $feature): ?>
            <li><?= htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
    
    <h2 style="margin-top: 2rem; color: #2d3748;">Technology Stack</h2>
    <p style="margin-top: 1rem;">
        Built with <strong>PHP <?= phpversion() ?></strong>, this system demonstrates proper separation of concerns,
        the MVC pattern, and secure coding practices.
    </p>
</div>