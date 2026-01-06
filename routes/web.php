<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoTransactionController;
use App\Http\Controllers\User\WithdrawController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\UserAssetController;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('cron', 'CronController@cron')->name('cron');

Route::get('/about', function () { return view('about'); });
Route::get('/careers', function () { return view('careers'); });
Route::get('/fees', function () { return view('fees'); });
Route::get('/legal', function () { return view('legal'); });

// Route::get('/{slug?}', [PageController::class, 'show'])->where('slug', '.*');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller("TradeController")->prefix('trade')->group(function () {
    Route::get('/order/book/{symbol}', 'orderBook')->name('trade.order.book');
    Route::get('pairs', 'pairs')->name('trade.pairs');
    Route::get('history/{symbol}', 'history')->name('trade.history');
    Route::get('order/list/{pairSym}', 'orderList')->name('trade.order.list');
    Route::get('/{symbol?}', 'trade')->name('trade');
});

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('/market/list', 'marketList')->name('market.list');
    Route::get('/crypto/list', 'cryptoCurrencyList')->name('crypto_currency.list');
    Route::get('/market', 'market')->name('market');
    Route::get('/crypto-currency', 'crypto')->name('crypto.currencies');
    Route::get('/crypto/currency/{symbol}', 'cryptoCurrencyDetails')->name('crypto.details');
    Route::post('/subscribe', 'subscribe')->name('subscribe');
    Route::post('pusher/auth/{socketId}/{channelName}', "pusherAuthentication");

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');
    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});

Route::post('/crypto/buy', [CryptoTransactionController::class, 'buy'])->name('user.crypto.buy.store');
Route::post('/crypto/sell', [CryptoTransactionController::class, 'sell'])->name('user.crypto.sell.store');


Route::post('/user/crypto-deposit/update-usd-value', [CryptoDepositController::class, 'updateUsdValue'])
    ->name('user.crypto.deposit.updateUsdValue');
Route::post('/user/withdraw/money', [WithdrawController::class, 'money'])->name('user.withdraw.money');
Route::post('/user/password/update', [UserAssetController::class, 'updatePassword'])->name('user.password.update');
Route::post('/user/email/update', [UserAssetController::class, 'updateEmail'])->name('user.email.update');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/deposit/log', [\App\Http\Controllers\DepositController::class, 'log'])->name('deposit.log');
});
