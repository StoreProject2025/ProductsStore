@extends('layouts.master')
@section('title', $product->name)

@section('content')
<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <div class="product-image-container">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-4">{{ $product->name }}</h1>
            
            <div class="product-price mb-3">
                @if($product->discount > 0)
                    <span class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                    <span class="text-danger fw-bold">${{ number_format($product->discounted_price, 2) }}</span>
                    <span class="badge bg-danger ms-2">{{ $product->discount }}% OFF</span>
                @else
                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <div class="product-description mb-4">
                <h5>Description</h5>
                <p>{{ $product->description }}</p>
            </div>

            <div class="product-meta mb-4">
                <div class="row">
                    <div class="col-6">
                        <p><strong>Category:</strong> {{ $product->category->name }}</p>
                    </div>
                    <div class="col-6">
                        <p><strong>Stock:</strong> {{ $product->stock }}</p>
                    </div>
                </div>
            </div>

            <div class="product-actions">
                @auth
                    <button class="btn btn-primary me-2 add-to-cart" data-product-id="{{ $product->id }}">
                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                    </button>
                    <button class="btn btn-outline-primary add-to-wishlist" data-product-id="{{ $product->id }}">
                        <i class="fas fa-heart me-2"></i>Add to Wishlist
                    </button>
                @else
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                    </button>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-heart me-2"></i>Add to Wishlist
                    </button>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    :root {
        --primary-color: #CB0404;
        --secondary-color: #F4631E;
        --accent-color: #FF9F00;
        --light-color: #309898;
        --dark-color: #06202B;
        --light-bg: #F5EEDD;
        --accent-bg: #7AE2CF;
        --secondary-bg: #077A7D;
    }

    /* Product Styles */
    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        background: white;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .product-image-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .product-image-container img {
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .product-image-container:hover img {
        transform: scale(1.05);
    }

    .product-price {
        font-size: 1.5rem;
    }

    .product-price .text-primary {
        color: var(--primary-color) !important;
    }

    .product-description {
        color: var(--dark-color);
        line-height: 1.6;
    }

    .product-meta {
        background-color: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .product-actions {
        margin-top: 2rem;
    }

    .btn {
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(244, 99, 30, 0.2);
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(203, 4, 4, 0.2);
    }

    h1 {
        color: var(--primary-color);
        font-weight: 700;
    }

    h5 {
        color: var(--dark-color);
        font-weight: 600;
    }

    .product-meta p {
        color: var(--dark-color);
    }

    .product-meta strong {
        color: var(--primary-color);
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to Cart functionality
    const addToCartBtn = document.querySelector('.add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            fetch('/cart/add/' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: 'The product has been added to your cart.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Add to Wishlist functionality
    const addToWishlistBtn = document.querySelector('.add-to-wishlist');
    if (addToWishlistBtn) {
        addToWishlistBtn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            fetch('/wishlist/add/' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Wishlist!',
                        text: 'The product has been added to your wishlist.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});
</script>
@endsection 