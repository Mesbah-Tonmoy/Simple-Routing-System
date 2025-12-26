<style>
    .error-container {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .error-code {
        font-size: 8rem;
        font-weight: bold;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
    }
    
    .error-message {
        font-size: 1.5rem;
        color: #4a5568;
        margin-bottom: 2rem;
    }
    
    .error-link {
        display: inline-block;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: opacity 0.3s;
    }
    
    .error-link:hover {
        opacity: 0.9;
    }
</style>

<div class="error-container">
    <div class="error-code"><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></div>
    <p class="error-message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <a href="<?= $base_path ?>/" class="error-link">← Back to Home</a>
</div>