<?php

declare(strict_types=1);

require_once __DIR__ . '/../BaseController.php';

class ProductController extends BaseController
{
    public function show(array $params): void
    {
        $productSlug = $params['slug'] ?? 'unknown';
        
        // In a real app, you'd fetch product data from database
        $data = [
            'title' => 'Product Details',
            'heading' => 'Product Details',
            'product' => [
                'slug' => $this->sanitize($productSlug),
                'name' => ucwords(str_replace('-', ' ', $productSlug)),
                'price' => '$99.99',
                'description' => 'This is a sample product description.',
            ],
        ];
        
        $this->viewWithLayout('product', $data);
    }
}
