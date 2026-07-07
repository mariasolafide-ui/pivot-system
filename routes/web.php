<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Customer\WaiterCallController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ─── Landing Page Routes ───────────────────────────────────────────────────
Route::get('/', [Admin\AuthController::class, 'showLogin']);
Route::get('/order/table/{table}', [Customer\LandingController::class, 'home'])->name('customer.home');
Route::get('/about', [Customer\LandingController::class, 'about'])->name('customer.about');
Route::get('/contact', [Customer\LandingController::class, 'contact'])->name('customer.contact');
Route::post('/contact', [Customer\LandingController::class, 'submitContact'])->name('customer.contact.submit');

// ─── Customer Routes ─────────────────────────────────────────────────────
Route::prefix('order')->name('customer.')->group(function () {

    // Status & feedback
    Route::get('/status/{transaction_id}', [Customer\OrderController::class, 'status'])->name('status');
    Route::get('/status/{transaction_id}/peek', [Customer\OrderController::class, 'statusPeek'])->name('status.peek');
    Route::get('/feedback/{transaction_id}', [Customer\FeedbackController::class, 'show'])->name('feedback');
    Route::post('/feedback/{transaction_id}', [Customer\FeedbackController::class, 'store'])->name('feedback.store');

    // QR token based routes
    Route::prefix('{qr_token}')->group(function () {
        Route::get('/', [Customer\MenuController::class, 'index'])->name('menu');
        Route::get('/menu/{menu}', [Customer\MenuController::class, 'show'])->name('menu.detail');
        Route::get('/menu/{menu}/options', [Customer\MenuController::class, 'getOptions'])->name('menu.options');
        Route::get('/retail/{retailProduct}', [Customer\MenuController::class, 'showRetail'])->name('retail.detail');
        
        // Cart
        Route::post('/cart/add', [Customer\CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update', [Customer\CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove', [Customer\CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [Customer\CartController::class, 'clear'])->name('cart.clear');
        
        // Checkout
        Route::get('/checkout', [Customer\CheckoutController::class, 'show'])->name('checkout');
        Route::post('/checkout', [Customer\CheckoutController::class, 'store'])->name('checkout.store');

        // Order actions
        Route::post('/cancel', [Customer\OrderController::class, 'cancel'])->name('cancel');
        Route::post('/waiter', [Customer\OrderController::class, 'callWaiter'])->name('waiter');

        // ── WAITER CALLS ──
        Route::post('/waiter/call', [WaiterCallController::class, 'call'])->name('waiter.call');
        Route::post('/waiter/cancel', [WaiterCallController::class, 'cancel'])->name('waiter.cancel');
        Route::get('/waiter/status', [WaiterCallController::class, 'status'])->name('waiter.status');
    });
});

Route::get('/nota/{transactionId}', [\App\Http\Controllers\Customer\OrderController::class, 'showNota'])->name('customer.nota');
Route::get('/nota/{transactionId}/download', [\App\Http\Controllers\Customer\OrderController::class, 'downloadNota'])->name('customer.nota.download');

// ─── Midtrans Webhook ──────────────────────────────────────────────────────
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

// ═════════════════════════════════════════════════════════════════════════
// ─── ADMIN ROUTES ────────────────────────────────────────────────────────
// ═════════════════════════════════════════════════════════════════════════

// ─── Admin Auth Routes (tanpa middleware, akses publik) ────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Login
    Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    // ── Lupa Password ──
    Route::get('/password/reset', [Admin\ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request'); // link "Lupa?" di login

    Route::post('/password/email', [Admin\ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email'); // action form forgot-password

    Route::get('/password/reset/{token}', [Admin\ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset'); // halaman reset dengan token dari email

    Route::post('/password/reset', [Admin\ResetPasswordController::class, 'reset'])
        ->name('password.update'); // action form reset-password
});

// ─── Admin Protected Routes (dengan middleware) ─────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(\App\Http\Middleware\AdminAuthenticate::class)
    ->group(function () {

        // Shared: admin + kasir
        Route::middleware('role:admin,kasir')->group(function () {
            Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
            Route::get('/notifications/peek', [Admin\DashboardController::class, 'notificationsPeek'])->name('notifications.peek');

            Route::get('/orders/monitor', [Admin\OrderController::class, 'monitor'])->name('orders.monitor');
            Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/filter', [Admin\OrderController::class, 'filter'])->name('orders.filter');
            Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
            Route::post('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
            Route::post('/orders/{order}/confirm-payment', [Admin\OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
            Route::get('/orders/{order}/print', [Admin\OrderController::class, 'print'])->name('orders.print');

            Route::get('/waiter-calls', [Admin\WaiterCallController::class, 'index'])->name('waiter-calls.index');
            Route::post('/waiter-calls/{waiterCall}/done', [Admin\WaiterCallController::class, 'done'])->name('waiter-calls.done');
            Route::post('/waiter-calls/{waiterCall}/process', [Admin\WaiterCallController::class, 'process'])->name('waiter-calls.process');
        });

        // Admin only
        Route::middleware('role:admin')->group(function () {
            Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan');
            Route::get('/laporan/export-excel', [Admin\LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
            Route::get('/laporan/export-pdf', [Admin\LaporanController::class, 'exportPDF'])->name('laporan.export-pdf');

            Route::delete('/waiter-calls/{waiterCall}', [Admin\WaiterCallController::class, 'destroy'])->name('waiter-calls.destroy');

            // Menus
            Route::get('/menus', [Admin\MenuController::class, 'index'])->name('menus.index');
            Route::post('/menus', [Admin\MenuController::class, 'store'])->name('menus.store');
            Route::put('/menus/{menu}', [Admin\MenuController::class, 'update'])->name('menus.update');
            Route::delete('/menus/{menu}', [Admin\MenuController::class, 'destroy'])->name('menus.destroy');
            Route::post('/menus/{menu}/toggle', [Admin\MenuController::class, 'toggle'])->name('menus.toggle');
            Route::get('/menus/{menu}/edit-data', [Admin\MenuController::class, 'editData'])->name('menus.edit-data');

            // Variant & Addon (AJAX)
            Route::post('/menus/{menu}/variant-groups', [Admin\MenuController::class, 'addVariantGroup'])->name('menus.variant-groups.store');
            Route::delete('/variant-groups/{variantGroup}', [Admin\MenuController::class, 'deleteVariantGroup'])->name('variant-groups.destroy');
            Route::post('/variant-groups/{variantGroup}/variants', [Admin\MenuController::class, 'addVariant'])->name('variant-groups.variants.store');
            Route::delete('/variants/{variant}', [Admin\MenuController::class, 'deleteVariant'])->name('variants.destroy');
            Route::post('/menus/{menu}/addons', [Admin\MenuController::class, 'addAddon'])->name('menus.addons.store');
            Route::delete('/menus/{menu}/addons/{addon}', [Admin\MenuController::class, 'deleteAddon'])->name('menus.addons.destroy');

            // Master Variant Groups
            Route::get('/variant-groups', [Admin\VariantGroupController::class, 'index'])->name('variant-groups.index');
            Route::post('/variant-groups', [Admin\VariantGroupController::class, 'store'])->name('variant-groups.store');
            Route::put('/variant-groups/{variantGroup}', [Admin\VariantGroupController::class, 'update'])->name('variant-groups.update');
            Route::delete('/variant-groups/{variantGroup}', [Admin\VariantGroupController::class, 'destroy'])->name('variant-groups.destroy');
            Route::post('/variant-groups/{variantGroup}/toggle', [Admin\VariantGroupController::class, 'toggle'])->name('variant-groups.toggle');
            Route::post('/variant-groups/{variantGroup}/variants', [Admin\VariantGroupController::class, 'storeVariant'])->name('variant-groups.variants.store');
            Route::delete('/variant-groups/{variantGroup}/variants/{variant}', [Admin\VariantGroupController::class, 'destroyVariant'])->name('variant-groups.variants.destroy');
            Route::post('/variant-groups/{variantGroup}/variants/{variant}/default', [Admin\VariantGroupController::class, 'setDefault'])->name('variant-groups.variants.default');

            // Addons
            Route::get('/addons', [Admin\AddonController::class, 'index'])->name('addons.index');
            Route::post('/addons', [Admin\AddonController::class, 'store'])->name('addons.store');
            Route::put('/addons/{addon}', [Admin\AddonController::class, 'update'])->name('addons.update');
            Route::delete('/addons/{addon}', [Admin\AddonController::class, 'destroy'])->name('addons.destroy');
            Route::post('/addons/{addon}/toggle', [Admin\AddonController::class, 'toggle'])->name('addons.toggle');

            // Categories
            Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

            // Tables
            Route::get('/tables', [Admin\TableController::class, 'index'])->name('tables.index');
            Route::post('/tables', [Admin\TableController::class, 'store'])->name('tables.store');
            Route::put('/tables/{table}', [Admin\TableController::class, 'update'])->name('tables.update');
            Route::delete('/tables/{table}', [Admin\TableController::class, 'destroy'])->name('tables.destroy');
            Route::get('/tables/{table}/qr', [Admin\TableController::class, 'qr'])->name('tables.qr');

            // Promos
            Route::get('/promos', [Admin\PromoController::class, 'index'])->name('promos.index');
            Route::post('/promos', [Admin\PromoController::class, 'store'])->name('promos.store');
            Route::put('/promos/{promo}', [Admin\PromoController::class, 'update'])->name('promos.update');
            Route::delete('/promos/{promo}', [Admin\PromoController::class, 'destroy'])->name('promos.destroy');

            // Feedback
            Route::get('/feedback', [Admin\FeedbackController::class, 'index'])->name('feedback.index');
            Route::delete('/feedback/{feedback}', [Admin\FeedbackController::class, 'destroy'])->name('feedback.destroy');

            // Users
            Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
            Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
            Route::put('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

            // Contact Messages
            Route::get('/contacts', [Admin\ContactMessageController::class, 'index'])->name('contacts.index');
            Route::delete('/contacts/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('contacts.destroy');

            // Retail Products
            Route::get('/retail-products', [Admin\RetailProductController::class, 'index'])->name('retail-products.index');
            Route::post('/retail-products', [Admin\RetailProductController::class, 'store'])->name('retail-products.store');
            Route::put('/retail-products/{retailProduct}', [Admin\RetailProductController::class, 'update'])->name('retail-products.update');
            Route::delete('/retail-products/{retailProduct}', [Admin\RetailProductController::class, 'destroy'])->name('retail-products.destroy');
        });
    });