<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ReportController;

// Main frontend route
Route::get('/', [ShopController::class, 'index']);

// Shop customer API routes
Route::prefix('api')->group(function () {
    // Auth routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/auth/status', [AuthController::class, 'status']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);

    Route::get('/categories', [ShopController::class, 'getCategories']);
    Route::get('/products', [ShopController::class, 'getProducts']);
    Route::get('/products/{id}', [ShopController::class, 'getProductDetails']);
    Route::post('/reviews', [ShopController::class, 'submitReview']);
    Route::post('/vouchers/apply', [ShopController::class, 'applyVoucher']);
    Route::post('/orders', [ShopController::class, 'placeOrder']);
    Route::get('/orders', [ShopController::class, 'getOrders']);
    Route::get('/orders/{id}', [ShopController::class, 'getOrderDetails']);
    Route::put('/orders/{id}/cancel', [ShopController::class, 'cancelClientOrder']);

    // Admin dashboard API routes protected by role-based check
    Route::prefix('admin')->middleware(\App\Http\Middleware\AdminCheck::class)->group(function () {
        Route::get('/stats', [AdminController::class, 'getStats']);
        Route::get('/products', [AdminController::class, 'getProducts']);
        Route::post('/products', [AdminController::class, 'createProduct']);
        Route::put('/products/{id}', [AdminController::class, 'updateProduct']);
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct']);
        Route::post('/products/restore-defaults', [AdminController::class, 'restoreDefaults']);
        Route::get('/orders', [AdminController::class, 'getOrders']);
        Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus']);
        Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder']);

        // Admin Vouchers CRUD
        Route::get('/vouchers', [AdminController::class, 'getVouchers']);
        Route::post('/vouchers', [AdminController::class, 'createVoucher']);
        Route::put('/vouchers/{id}', [AdminController::class, 'updateVoucher']);
        Route::delete('/vouchers/{id}', [AdminController::class, 'deleteVoucher']);

        // Admin Reviews moderation
        Route::get('/reviews', [AdminController::class, 'getReviews']);
        Route::delete('/reviews/{id}', [AdminController::class, 'deleteReview']);

        // Admin Users CRUD
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::put('/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

        // Admin Marketing - Banner
        Route::get('/banners', [MarketingController::class, 'getBanners']);
        Route::post('/banners', [MarketingController::class, 'createBanner']);
        Route::put('/banners/{id}', [MarketingController::class, 'updateBanner']);
        Route::delete('/banners/{id}', [MarketingController::class, 'deleteBanner']);

        // Admin Marketing - Promotion (Khuyến mãi)
        Route::get('/promotions', [MarketingController::class, 'getPromotions']);
        Route::post('/promotions', [MarketingController::class, 'createPromotion']);
        Route::put('/promotions/{id}', [MarketingController::class, 'updatePromotion']);
        Route::delete('/promotions/{id}', [MarketingController::class, 'deletePromotion']);

        // Admin Marketing - Collection (Bộ sưu tập)
        Route::get('/collections', [MarketingController::class, 'getCollections']);
        Route::post('/collections', [MarketingController::class, 'createCollection']);
        Route::put('/collections/{id}', [MarketingController::class, 'updateCollection']);
        Route::delete('/collections/{id}', [MarketingController::class, 'deleteCollection']);

        // Admin Marketing - Post (Bài viết)
        Route::get('/posts', [MarketingController::class, 'getPosts']);
        Route::post('/posts', [MarketingController::class, 'createPost']);
        Route::put('/posts/{id}', [MarketingController::class, 'updatePost']);
        Route::delete('/posts/{id}', [MarketingController::class, 'deletePost']);

        // Admin Reports - Báo cáo & Thống kê
        Route::get('/reports/revenue', [ReportController::class, 'getRevenue']);
        Route::get('/reports/orders', [ReportController::class, 'getOrderStats']);
        Route::get('/reports/top-products', [ReportController::class, 'getTopProducts']);
        Route::get('/reports/size-stats', [ReportController::class, 'getSizeStats']);
        Route::get('/reports/color-stats', [ReportController::class, 'getColorStats']);
        Route::get('/reports/inventory', [ReportController::class, 'getInventoryStats']);
        Route::get('/reports/customers', [ReportController::class, 'getCustomerStats']);
        Route::get('/reports/categories', [ReportController::class, 'getCategoryStats']);
    });
});
