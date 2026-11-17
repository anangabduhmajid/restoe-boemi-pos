
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\CategoryController;
use App\Http\Controllers\Owner\MenuController;
use App\Http\Controllers\Owner\DiningTableController;
use App\Http\Controllers\Owner\TableQrController;
use App\Http\Controllers\Customer\PublicMenuController;
use App\Http\Controllers\Owner\OrderController;
use App\Http\Controllers\Cashier\OrderController as CashierOrderController;
use App\Http\Controllers\Kitchen\KitchenOrderController;
use App\Http\Controllers\Owner\UserController;
use App\Http\Controllers\Owner\TransactionController;
use App\Http\Controllers\Owner\CustomerController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\Cashier\PaymentController;
use App\Http\Controllers\Cashier\OrderNotificationController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\BusinessAssistantController;
use App\Http\Controllers\DiningTableStatusController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu/{table:qr_token}', [PublicMenuController::class, 'show'])
    ->name('menu.show');

Route::post('/menu/{table:qr_token}/orders', [PublicMenuController::class, 'store'])
    ->name('menu.orders.store');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('owner')) {
            return redirect()->route('owner.dashboard');
        }

        if ($user->hasRole('cashier')) {
            return redirect()->route('cashier.orders.create');
        }

        if ($user->hasRole('kitchen')) {
            return redirect()->route('kitchen.dashboard');
        }

        if ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard');
        }

        abort(403, 'Akun belum memiliki role.');
    })->name('dashboard');

    // OWNER
    Route::middleware('role:owner')
        ->prefix('owner')
        ->name('owner.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/business-assistant/analyze', [
                BusinessAssistantController::class,
                'analyze'
            ])->name('business-assistant.analyze');

            Route::post('/business-assistant/ask', [
                BusinessAssistantController::class,
                'ask'
            ])->name('business-assistant.ask');

            Route::resource('categories', CategoryController::class)
                ->except(['show']);

            Route::resource('menus', MenuController::class)
                ->except(['show']);

            Route::resource('tables', DiningTableController::class)
                ->except(['show']);

            Route::post('/tables/{table}/clear', [DiningTableStatusController::class, 'clear'])
                ->name('tables.clear');

            Route::get('tables/{table}/qr', [TableQrController::class, 'show'])
                ->name('tables.qr');

            Route::get('tables/{table}/qr/image', [TableQrController::class, 'image'])
                ->name('tables.qr.image');

            Route::get('orders', [OrderController::class, 'index'])
                ->name('orders.index');

            Route::get('orders/{order}', [OrderController::class, 'show'])
                ->name('orders.show');

            Route::get('transactions', [TransactionController::class, 'index'])
                ->name('transactions.index');

            Route::get('transactions/{order}', [TransactionController::class, 'show'])
                ->name('transactions.show');

            Route::get('customers', [CustomerController::class, 'index'])
                ->name('customers.index');

            Route::get('customers/{customer}', [CustomerController::class, 'show'])
                ->name('customers.show');

            Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
                ->name('customers.destroy');
                
            Route::get('reports', [ReportController::class, 'index'])
                ->name('reports.index');

            Route::get('/users', [UserController::class, 'index'])
                ->name('users.index');

            Route::get('/users/create', [UserController::class, 'create'])
                ->name('users.create');

            Route::post('/users', [UserController::class, 'store'])
                ->name('users.store');

            Route::get('/users/{user}/edit', [UserController::class, 'edit'])
                ->name('users.edit');

            Route::put('/users/{user}', [UserController::class, 'update'])
                ->name('users.update');

            Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
                ->name('users.toggle-status');
        });


    // CASHIER
    Route::middleware('role:cashier')
        ->prefix('cashier')
        ->name('cashier.')
        ->group(function () {

            Route::get('/dashboard', [CashierOrderController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/payments', [PaymentController::class, 'index'])
                ->name('payments.index');

            Route::get('/orders/notifications', [OrderNotificationController::class, 'poll'])
                ->name('orders.notifications');

            Route::get('/payments/{order}', [PaymentController::class, 'show'])
                ->name('payments.show');

            Route::post('/payments/{order}/pay', [PaymentController::class, 'pay'])
                ->name('payments.pay');

            Route::post('/tables/{table}/clear', [DiningTableStatusController::class, 'clear'])
                ->name('tables.clear');

            Route::get('/orders/create', [CashierOrderController::class, 'create'])
                ->name('orders.create');

            Route::post('/orders', [CashierOrderController::class, 'store'])
                ->name('orders.store');
        });


    // KITCHEN
    Route::middleware('role:kitchen')
        ->prefix('kitchen')
        ->name('kitchen.')
        ->group(function () {

            Route::get('/dashboard', [KitchenOrderController::class, 'index'])
                ->name('dashboard');

            Route::patch('/orders/{order}/start', [KitchenOrderController::class, 'startPreparing'])
                ->name('orders.start');

            Route::patch('/orders/{order}/complete', [KitchenOrderController::class, 'complete'])
                ->name('orders.complete');

            Route::get('/history', [KitchenOrderController::class, 'history'])
                ->name('history');
        });

    // CUSTOMER
    Route::middleware('role:customer')->group(function () {
        Route::view('/customer/dashboard', 'customer.dashboard')
            ->name('customer.dashboard');
    });
});

require __DIR__ . '/auth.php';
