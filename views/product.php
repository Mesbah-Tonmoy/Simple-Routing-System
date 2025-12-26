<style>
    .product-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 3rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .product-header h1 {
        color: #667eea;
        margin-bottom: 1rem;
    }
    
    .product-price {
        font-size: 2rem;
        color: #48bb78;
        font-weight: bold;
        margin: 1.5rem 0;
    }
    
    .product-description {
        color: #4a5568;
        line-height: 1.8;
        margin-bottom: 2rem;
    }
    
    .product-meta {
        background: #f7fafc;
        padding: 1rem;
        border-radius: 4px;
        margin-top: 2rem;
    }
</style>

<div class="product-container">
    <div class="product-header">
        <h1><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p style="color: #718096;">Product Slug: <?= htmlspecialchars($product['slug'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
    
    <div class="product-price">
        <?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    
    <div class="product-description">
        <h3 style="color: #2d3748; margin-bottom: 1rem;">Description</h3>
        <p><?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
    
    <div class="product-meta">
        <strong>Note:</strong> This is a demonstration of dynamic routing with URL parameters.
        Try visiting <code>/product/smartphone</code> or <code>/product/headphones</code>
    </div>
</div>