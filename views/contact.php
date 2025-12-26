<style>
    .contact-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 3rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .contact-container h1 {
        color: #667eea;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #2d3748;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }
    
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }
    
    .form-group textarea {
        resize: vertical;
        min-height: 150px;
    }
    
    .btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        width: 100%;
        transition: opacity 0.3s;
    }
    
    .btn:hover {
        opacity: 0.9;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1rem;
        display: none;
    }
    
    .alert-success {
        background: #c6f6d5;
        color: #22543d;
        border: 1px solid #48bb78;
    }
    
    .alert-error {
        background: #fed7d7;
        color: #742a2a;
        border: 1px solid #f56565;
    }
</style>

<div class="contact-container">
    <h1><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
    
    <div id="alert" class="alert"></div>
    
    <form id="contactForm" method="POST" action="/contact">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
        
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        
        <button type="submit" class="btn">Send Message</button>
    </form>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const alert = document.getElementById('alert');
    
    try {
        const response = await fetch('/contact', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert.className = 'alert alert-success';
            alert.textContent = data.message;
            alert.style.display = 'block';
            form.reset();
        } else {
            alert.className = 'alert alert-error';
            alert.textContent = data.errors.join(', ');
            alert.style.display = 'block';
        }
    } catch (error) {
        alert.className = 'alert alert-error';
        alert.textContent = 'An error occurred. Please try again.';
        alert.style.display = 'block';
    }
});
</script>