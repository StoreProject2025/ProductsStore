<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Web\DashboardController;

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::post('/logout', [UsersController::class, 'doLogout'])->name('logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::post('users/update_credit/{user}', [UsersController::class, 'updateCredit'])->name('update_credit');
Route::get('verify', [UsersController::class, 'verify'])->name('verify');

Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
Route::post('/update-credit', [UsersController::class, 'updateCredit'])->name('update.credit');
Route::post('/add-credit', [UsersController::class, 'addCredit'])->name('add.credit');
Route::get('/purchases', [UsersController::class, 'purchases'])->name('purchases');

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
Route::put('products/hold/{product}', [ProductsController::class, 'hold'])->name('products_hold');

Route::post('/bought-products', [ProductsController::class, 'boughtProducts'])->name('bought_products_list');
Route::get('/products/insufficient_credit', [ProductsController::class, 'show'])->name('insufficient.credit');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::find($id);
    
    if (!$user || !hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        throw new \Illuminate\Auth\Access\AuthorizationException;
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('info', 'Email already verified.');
    }

    if ($user->markEmailAsVerified()) {
        return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
    }

    return redirect()->route('login')->with('error', 'Email verification failed.');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['throttle:6,1'])->name('verification.send');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    return view('test');
});

Route::get('/test-email', [UsersController::class, 'testEmail'])->name('test.email');

// Social Login Routes
Route::get('auth/google', [UsersController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [UsersController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('auth/facebook', [UsersController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [UsersController::class, 'handleFacebookCallback'])->name('facebook.callback');

// Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Routes
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
});

// Wishlist Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Static Pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Language Switch Route
Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('language.switch');

// Temporary route to assign Admin role
Route::get('/assign-admin', function() {
    try {
        // Clear cache first
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $user = \App\Models\User::where('email', 'hanenmahmoud0@gmail.com')->first();
        if ($user) {
            // Remove any existing roles
            $user->roles()->detach();
            
            // Assign Admin role
            $user->assignRole('Admin');
            
            // Update is_admin flag
            $user->is_admin = true;
            $user->save();
            
            // Clear cache again
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            
            return 'Admin role assigned successfully! Please refresh your profile page.';
        }
        return 'User not found';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/deals', function () {
    return view('deals');
})->name('deals');