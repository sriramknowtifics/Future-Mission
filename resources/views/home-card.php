<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --accent-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --glass-bg: rgba(255, 255, 255, 0.95);
    --glass-border: rgba(255, 255, 255, 0.25);
    --shadow-sm: 0 8px 32px rgba(0,0,0,0.08);
    --shadow-md: 0 20px 40px rgba(0,0,0,0.12);
    --shadow-lg: 0 25px 50px rgba(0,0,0,0.15);
}

* { font-family: 'Poppins', sans-serif; }

body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }

/* Premium Hero Section */
.hero-section { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    border-radius: 0 0 40px 40px;
    position: relative;
    overflow: hidden;
    min-height: 80vh;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow-lg);
}
.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}
.hero-content { 
    position: relative;
    z-index: 2;
    max-width: 800px;
    padding: 2rem 1rem;
}
.hero-title { 
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700;
    background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}
.hero-subtitle { 
    font-size: 1.3rem;
    color: rgba(255,255,255,0.95);
    margin-bottom: 2rem;
    font-weight: 400;
}

/* Glass Cards */
.glass-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    box-shadow: var(--shadow-md);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
}
.glass-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.glass-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: var(--shadow-lg);
}
.glass-card:hover::before { opacity: 1; }

/* Banner Cards */
.premium-banner {
    height: 280px;
    background-size: cover !important;
    background-position: center !important;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
}
.premium-banner::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
}
.banner-content {
    position: absolute;
    bottom: 2rem;
    left: 2rem;
    right: 2rem;
    z-index: 2;
    color: white;
}
.banner-title { font-size: 1.6rem; font-weight: 600; margin-bottom: 0.5rem; }

/* Category Cards */
.category-card {
    height: 140px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}
.category-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-gradient);
    margin-bottom: 1rem;
    font-size: 1.8rem;
    color: white;
    box-shadow: var(--shadow-sm);
}
.category-card:hover .category-icon {
    transform: scale(1.1);
    box-shadow: var(--shadow-md);
}
.category-name { font-weight: 600; font-size: 1rem; margin-bottom: 0.25rem; }
.category-count { font-size: 0.85rem; color: #666; }

/* Product Cards */
.product-card {
    height: 380px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
}
.product-image {
    height: 200px;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ed 100%);
}
.product-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.product-discount {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: var(--accent-gradient);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}
.product-title { 
    font-weight: 600;
    font-size: 1rem;
    line-height: 1.4;
    margin-bottom: 0.5rem;
    color: #2d3748;
}
.product-price {
    font-size: 1.3rem;
    font-weight: 700;
    color: #e53e3e;
    margin-bottom: 0.25rem;
}
.product-old-price {
    font-size: 1rem;
    color: #a0aec0;
    text-decoration: line-through;
    margin-left: 0.5rem;
}

/* Buttons */
.premium-btn {
    background: var(--primary-gradient);
    border: none;
    border-radius: 50px;
    padding: 0.8rem 2rem;
    color: white;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}
.premium-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section { min-height: 60vh; border-radius: 0 0 24px 24px; }
    .premium-banner { height: 220px; }
    .product-card { height: 340px; }
    .product-image { height: 160px; }
}
</style>
<section class="bg-white py-5 mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="h2 fw-bold text-dark mb-0">Featured Products</h2>
            <a href="{{ route('shop.index') }}" class="premium-btn">View All Products</a>
        </div>
        <div class="row g-4">
            @forelse($featured->take(8) as $product)
                @php
                    $img = $product->images->first();
                    $oldPrice = $product->price * 1.33;
                    $discount = 25;
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="glass-card product-card h-100 position-relative">
                        <div class="product-discount">{{ $discount }}% OFF</div>
                        <div class="product-image">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ $img ? asset('storage/' . $img->path) : asset('assets/images/placeholder.png') }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <h6 class="product-title">{{ \Illuminate\Support\Str::limit($product->name, 50) }}</h6>
                        <div class="price d-flex align-items-baseline">
                            <span class="product-price">BHD{{ number_format($product->price, 3) }}</span>
                            <span class="product-old-price">BHD{{ number_format($oldPrice, 3) }}</span>
                        </div>
                        <div class="mt-auto pt-3">
                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="premium-btn flex-fill">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">No featured products available yet</h4>
                </div>
            @endforelse
        </div>
    </div>
</section>