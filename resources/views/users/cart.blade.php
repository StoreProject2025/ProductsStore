@extends('layouts.master')

@section('title', 'My Cart')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">My Cart</h2>
            
            @if($cartItems->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart text-muted mb-3" style="font-size: 4rem;"></i>
                    <h3 class="text-muted">Your Cart is Empty</h3>
                    <p class="text-muted mb-4">Start adding items to your cart!</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Browse Products
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach($cartItems as $item)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text text-primary">${{ number_format($item->price, 2) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-outline-secondary btn-sm decrease-quantity" data-product-id="{{ $item->id }}">-</button>
                                            <input type="number" class="form-control form-control-sm text-center quantity-input" value="{{ $item->pivot->quantity }}" min="1" data-product-id="{{ $item->id }}">
                                            <button class="btn btn-outline-secondary btn-sm increase-quantity" data-product-id="{{ $item->id }}">+</button>
                                        </div>
                                        <button class="btn btn-outline-danger btn-sm remove-from-cart" data-product-id="{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <h4>Total: ${{ number_format($cartItems->sum(function($item) { return $item->price * $item->pivot->quantity; }), 2) }}</h4>
                        <button class="btn btn-primary mt-3">
                            <i class="fas fa-credit-card me-2"></i>
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Increase quantity
    $('.increase-quantity').click(function() {
        const input = $(this).siblings('.quantity-input');
        input.val(parseInt(input.val()) + 1).trigger('change');
    });

    // Decrease quantity
    $('.decrease-quantity').click(function() {
        const input = $(this).siblings('.quantity-input');
        if (parseInt(input.val()) > 1) {
            input.val(parseInt(input.val()) - 1).trigger('change');
        }
    });

    // Update quantity
    $('.quantity-input').change(function() {
        const productId = $(this).data('product-id');
        const quantity = $(this).val();
        // Add your update quantity logic here
    });

    // Remove from cart
    $('.remove-from-cart').click(function() {
        const productId = $(this).data('product-id');
        // Add your remove from cart logic here
    });
</script>
@endsection 