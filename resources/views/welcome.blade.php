@extends('layouts.master')
@section('title', 'Home')

@section('content')
<!-- Hero Banner -->
<div class="hero-slider swiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1550009158-9ebf69173e03?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')">
            <div class="slide-content">
                <h2>50% OFF on All Electronics</h2>
                <p>Exclusive deals on the latest gadgets</p>
                <a href="#" class="btn btn-primary cta-button">Shop Now</a>
            </div>
        </div>
        <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')">
            <div class="slide-content">
                <h2>New Summer Collection</h2>
                <p>Latest fashion trends at competitive prices</p>
                <a href="#" class="btn btn-success cta-button">Shop Now</a>
            </div>
        </div>
        <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')">
            <div class="slide-content">
                <h2>30% OFF on Books</h2>
                <p>Best books at discounted prices</p>
                <a href="#" class="btn btn-info cta-button">Shop Now</a>
            </div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <h2 class="text-center mb-4">Featured Categories</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="category-card">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        <div class="category-content">
                            <h3>{{ $category->name }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="best-sellers-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Best Sellers</h2>
        <div class="row">
            @foreach($bestSellers as $product)
            <div class="col-md-3">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="product-content">
                        <h4>{{ $product->name }}</h4>
                        <div class="product-price">
                            <span class="original">${{ $product->formatted_price }}</span>
                            @if($product->discount_price)
                                <span class="discount">${{ $product->formatted_discount_price }}</span>
                            @endif
                        </div>
                        <div class="product-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $product->average_rating)
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $product->average_rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        @auth
                            <button class="add-to-cart" data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        @else
                            <button class="add-to-cart auth-required" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Quick Links -->
<section class="quick-links mb-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                    <h5>Free Shipping</h5>
                    <p class="text-muted mb-0">On orders over $50</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-undo fa-3x text-primary mb-3"></i>
                    <h5>Easy Returns</h5>
                    <p class="text-muted mb-0">30 days return policy</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                    <h5>Secure Payment</h5>
                    <p class="text-muted mb-0">100% secure checkout</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p class="text-muted mb-0">Dedicated support team</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Hero Banner Styles */
    .hero-slider {
        height: 600px;
        margin-bottom: 3rem;
        position: relative;
    }

    .swiper-slide {
        position: relative;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        padding: 0 5%;
        overflow: hidden;
    }

    .swiper-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 1;
    }

    .slide-content {
        position: relative;
        max-width: 600px;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        z-index: 2;
    }

    .slide-content h2 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.8s forwards;
    }

    .slide-content p {
        font-size: 1.4rem;
        margin-bottom: 2rem;
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.8s 0.2s forwards;
    }

    .cta-button {
        padding: 1rem 2.5rem;
        font-size: 1.2rem;
        font-weight: 600;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.8s 0.4s forwards;
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: white;
        background: rgba(0, 0, 0, 0.3);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: rgba(0, 0, 0, 0.5);
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 20px;
    }

    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: white;
        opacity: 0.5;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
        background: var(--primary-color);
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Categories Section */
    .categories-section {
        padding: 4rem 0;
        background-color: #f8f9fa;
    }

    .category-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 300px;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .category-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-card .category-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
    }

    .category-card h3 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
    }

    /* Product Card Styles */
    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .product-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .product-card .product-content {
        padding: 1.5rem;
    }

    .product-card h4 {
        margin-bottom: 1rem;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .product-price .original {
        text-decoration: line-through;
        color: #999;
        font-size: 1.1rem;
    }

    .product-price .discount {
        color: #2196F3;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .product-rating {
        color: #ffc107;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .add-to-cart {
        width: 100%;
        padding: 1rem;
        border: none;
        background: #2196F3;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .add-to-cart:hover {
        background: #1976D2;
    }

    .auth-required {
        cursor: pointer;
        opacity: 0.8;
    }

    .auth-required:hover {
        opacity: 1;
    }

    /* Quick Links Section */
    .quick-links {
        padding: 4rem 0;
        background-color: #f8f9fa;
    }

    .quick-links .card {
        transition: all 0.3s ease;
    }

    .quick-links .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .quick-links i {
        color: #2196F3;
    }

    .quick-links h5 {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 1rem 0;
    }

    .quick-links p {
        font-size: 1.1rem;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper
        const swiper = new Swiper('.hero-slider', {
            // Enable autoplay
            autoplay: true,
            // Autoplay delay in ms
            delay: 3000,
            // Disable autoplay on user interaction
            disableOnInteraction: false,
            // Enable loop
            loop: true,
            // Enable pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            // Enable navigation
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            // Enable keyboard navigation
            keyboard: {
                enabled: true
            },
            // Enable mousewheel navigation
            mousewheel: {
                enabled: true
            },
            // Enable grab cursor
            grabCursor: true,
            // Enable slide effect
            effect: 'slide',
            // Enable speed
            speed: 1000,
            // Enable watch slides progress
            watchSlidesProgress: true,
            // Enable watch overflow
            watchOverflow: true,
            // Enable observer
            observer: true,
            // Enable observe parents
            observeParents: true,
            // Enable update on window resize
            updateOnWindowResize: true,
            // Enable update on images ready
            updateOnImagesReady: true,
            // Enable preload images
            preloadImages: true,
            // Enable lazy loading
            lazy: true,
            // Enable virtual slides
            virtualTranslate: true,
            // Enable auto height
            autoHeight: true,
            // Enable centered slides
            centeredSlides: true,
            // Enable slides per view
            slidesPerView: 1,
            // Enable space between slides
            spaceBetween: 0,
            // Enable breakpoints
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                1024: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        });

        // Force autoplay to start
        setTimeout(() => {
            swiper.autoplay.start();
        }, 1000);

        // Add to Cart
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                if (this.classList.contains('auth-required')) {
                    return;
                }

                const productId = this.dataset.productId;
                // Add AJAX call to add product to cart
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = data.cartCount;
                        });
                        // Show success message
                        alert('Product added to cart successfully');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding product to cart');
                });
            });
        });
    });
</script>
@endsection
