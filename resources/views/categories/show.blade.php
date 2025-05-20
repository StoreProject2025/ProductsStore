@extends('layouts.master')
@section('title', $category->name)

@section('content')
<div class="category-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-3">{{ $category->name }}</h1>
            <p class="text-muted">{{ $category->description }}</p>
        </div>
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded">
        </div>
    </div>
</div>

<div class="products-grid">
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-3">
            <div class="card product-card border-0 shadow-sm">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="product-actions">
                        <button class="btn btn-light btn-sm rounded-circle" title="Add to Wishlist">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-circle" title="Quick View">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @if($product->sale_price)
                    <div class="discount-badge bg-danger text-white position-absolute top-0 start-0 m-2 px-2 py-1 rounded">
                        -{{ $product->discount_percentage }}%
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="card-title mb-1">{{ $product->name }}</h5>
                            <p class="card-text text-muted small mb-0">{{ $category->name }}</p>
                        </div>
                        <div class="rating">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if($product->sale_price)
                            <span class="price h5 mb-0">${{ number_format($product->sale_price, 2) }}</span>
                            <small class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</small>
                            @else
                            <span class="price h5 mb-0">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <button class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                No products found in this category.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>
@endsection

@section('styles')
<style>
.category-header {
    background: var(--light-bg);
    padding: 2rem;
    border-radius: 10px;
}

.product-card {
    transition: transform 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-card img {
    height: 250px;
    object-fit: cover;
}

.product-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s;
}

.product-card:hover .product-actions {
    opacity: 1;
}

.price {
    color: var(--secondary-color);
}

.rating {
    font-size: 0.875rem;
}

.discount-badge {
    font-weight: bold;
}
</style>
@endsection 