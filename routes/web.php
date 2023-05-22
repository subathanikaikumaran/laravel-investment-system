<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::group(['middleware' => ['preventBackHistory']], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    Route::get('register', 'Auth\RegisterController@show')->name('register');
    Route::get('register/new/{id}', 'Auth\RegisterController@show')->name('register-new');
    Route::post('register', ['as' => 'register.save', 'uses' => 'Auth\RegisterController@store']);
});

// Route::get('/', 'Auth\LoginController@login');
// Route::group(['middleware' => ['preventBackHistory']], function () {
//     // Route::get('/', 'Auth\LoginController@login');
//     Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
//     Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
//     Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
//     Route::get('register', 'Auth\RegisterController@show')->name('register');
//     Route::get('register/new/{id}', 'Auth\RegisterController@show')->name('register-new');
//     Route::post('register', ['as' => 'register.save', 'uses' => 'Auth\RegisterController@store']);
// });


Route::group(['middleware' => ['auth', 'preventBackHistory']], function () {
    Route::get('changepwd', 'PasswordController@index')->name('changepwd');
    Route::put('changepwd-update', ['as' => 'user.changepwd', 'uses' => 'PasswordController@update']);
});

Route::group(['middleware' => ['auth', 'preventBackHistory','is_customer']], function () {
    Route::get('account-verify', 'AccountVerifyController@index')->name('account-verify');
    Route::post('account-verify-save', ['as' => 'user.accountverify', 'uses' => 'AccountVerifyController@store']);
});


Route::group(['middleware' => ['auth', 'preventBackHistory','change_pwd','is_admin']], function () {
    Route::get('home', 'DashboardController@index')->name('home');

    Route::get('admin-deposit', 'PaymentController@indexDeposit')->name('admin-deposit');
    Route::get('admin-deposit/{id}', 'PaymentController@indexDeposit')->name('admin-deposit');
    Route::post('admin-deposit', 'PaymentController@indexDeposit')->name('admin-deposit');
    Route::get('alldepositpaymentList', 'PaymentController@getDepositPaymentList')->name('alldepositpaymentList');
    Route::get('admin-deposit-create', ['as' => 'admin.deposit.create', 'uses' => 'PaymentController@createDeposit']);
    Route::get('admin-initial-create', ['as' => 'admin.initial.create', 'uses' => 'PaymentController@createInitialDeposit']);
    Route::get('admin-customerinitial-create/{id}', ['as' => 'admin.customerinitial.create', 'uses' => 'PaymentController@createInitialDeposit']);

    Route::get('customer-deposit-create/{id}', ['as' => 'customer.deposit.create', 'uses' => 'PaymentController@createCustomerDeposit']);
    Route::post('admin-deposit-save', ['as' => 'admin.deposit.save', 'uses' => 'PaymentController@storeDeposit']);
    Route::get('admin-deposit/edit/{id}', 'PaymentController@editDeposit');
    Route::put('admin-deposit-update', ['as' => 'admin.deposit.update', 'uses' => 'PaymentController@updateDeposit']);



    Route::get('admin-withdraw', 'PaymentController@indexWithdraw')->name('admin-withdraw');
    Route::post('admin-withdraw', 'PaymentController@indexWithdraw')->name('admin-withdraw');
    Route::get('allwithdrawpaymentList', 'PaymentController@getWithdrawPaymentList')->name('allwithdrawpaymentList');
    Route::get('admin-withdraw-create', ['as' => 'admin.withdraw.create', 'uses' => 'PaymentController@createWithdraw']);
    Route::post('admin-withdraw-save', ['as' => 'admin.withdraw.save', 'uses' => 'PaymentController@storeWithdraw']);
    Route::get('admin-withdraw/edit/{id}', 'PaymentController@editWithdraw');
    Route::put('admin-withdraw-update', ['as' => 'admin.withdraw.update', 'uses' => 'PaymentController@updateWithdraw']);


    Route::get('manage-payreq', 'WithdrawController@index')->name('manage-payreq');
    Route::post('manage-payreq', 'WithdrawController@index')->name('manage-payreq');
    Route::get('manageRequestList', 'WithdrawController@getManageReqList')->name('manageRequestList');
    Route::get('manage-payreq-create', ['as' => 'manage.payreq.create', 'uses' => 'WithdrawController@create']);
    Route::post('manage-payreq-save', ['as' => 'manage.payreq.save', 'uses' => 'WithdrawController@store']);
    Route::get('manage-payreq/edit/{id}', 'WithdrawController@edit');
    Route::put('manage-payreq-update', ['as' => 'manage.payreq.update', 'uses' => 'WithdrawController@update']);

    Route::get('admin-bonus', 'BonusController@index')->name('admin-bonus');
    Route::post('admin-bonus', 'BonusController@index')->name('admin-bonus');
    Route::get('adminBonusList', 'BonusController@getBonusList')->name('getBonusList');
    Route::get('admin-bonus-create', ['as' => 'admin.bonus.create', 'uses' => 'BonusController@create']);
    Route::post('admin-bonus-save', ['as' => 'admin.bonus.save', 'uses' => 'BonusController@store']);
    Route::get('admin-bonus/edit/{id}', 'BonusController@edit');
    Route::put('admin-bonus-update', ['as' => 'admin.bonus.update', 'uses' => 'BonusController@update']);



    Route::get('bonus', 'CustomerBonusController@index')->name('bonus');
    Route::post('bonus', 'CustomerBonusController@index')->name('bonus');
});


Route::group(['middleware' => ['auth', 'preventBackHistory','change_pwd','is_admin']], function () {
    Route::get('admin-user', 'UserController@index')->name('admin-user');
    Route::post('admin-user', 'UserController@index')->name('admin-user');
    Route::get('allUserList', 'UserController@allUserList')->name('allUserList');
    Route::get('admin-user-create', ['as' => 'admin.user.create', 'uses' => 'UserController@create']);
    Route::post('admin-user-save', ['as' => 'admin.user.save', 'uses' => 'UserController@store']);
    Route::get('admin-user/edit/{id}', 'UserController@edit');
    Route::put('admin-user-update', ['as' => 'admin.user.update', 'uses' => 'UserController@update']);


    Route::get('client-user', 'CustomerController@index')->name('client-user');
    Route::post('client-user', 'CustomerController@index')->name('client-user');
    Route::get('allClientUserList', 'CustomerController@allClientUserList')->name('allClientUserList');
    Route::get('client-user-create', ['as' => 'client.user.create', 'uses' => 'CustomerController@create']);
    Route::post('client-user-save', ['as' => 'client.user.save', 'uses' => 'CustomerController@store']);
    Route::get('client-user/edit/{id}', 'CustomerController@edit');

    Route::get('client-user/changepwd/{id}', 'CustomerController@changePwd');
    Route::put('client-user-changepwd', ['as' => 'client.user.changepwd', 'uses' => 'CustomerController@updateCustomerPassword']);



    Route::put('client-user-update', ['as' => 'client.user.update', 'uses' => 'CustomerController@update']);
    Route::get('client-user/view/{id}', 'CustomerController@view');

    Route::get('start-discount-user/{id}', 'CustomerController@setTempDiscount');
    Route::put('start-discount-user-update', ['as' => 'clientdiscount.user.update', 'uses' => 'CustomerController@setTempDiscountStore']);

    Route::get('admin-payment-request', 'PaymentController@manageRequest')->name('admin-payment-request');
    Route::get('admin-client', 'DashboardController@index')->name('admin-client');


    Route::post('showUser', 'UserController@showUser');
    Route::get('showUser', 'UserController@showUser');

    Route::post('showActiveUser', 'UserController@showActiveUser');
    Route::get('showActiveUser', 'UserController@showActiveUser');
});


Route::group(['middleware' => ['auth', 'preventBackHistory','change_pwd','is_admin']], function () {

    Route::get('auditlog', 'AuditlogController@index');
    Route::post('auditlog', 'AuditlogController@index');
    Route::post('auditlogList', 'AuditlogController@getList')->name('auditlogList');
});


Route::group(['middleware' => ['auth', 'preventBackHistory','change_pwd','is_customer','is_account_verify']], function () {
    Route::get('client-home', 'HomeController@clientHome')->name('client-home');
    Route::get('dashboard', 'DashboardClientController@index')->name('dashboard');
    Route::get('finance-summary', 'FinanceClientController@index')->name('finance-summary');

    Route::get('withdraw', 'WithdrawClientController@index')->name('withdraw');
    Route::post('withdraw', 'WithdrawClientController@index')->name('withdraw');
    Route::delete('withdraw/{id}', 'WithdrawClientController@destroy');
    Route::get('withdrawList', 'WithdrawClientController@getReqList')->name('getReqList');
    Route::get('withdraw-create', ['as' => 'withdraw.create', 'uses' => 'WithdrawClientController@create']);
    Route::post('withdraw-save', ['as' => 'withdraw.save', 'uses' => 'WithdrawClientController@store']);

    Route::get('withdraw/edit/{id}', 'WithdrawClientController@edit');
    Route::put('withdraw-update', ['as' => 'withdraw.update', 'uses' => 'WithdrawClientController@update']);

    Route::get('payment', 'PaymentClientController@index')->name('payment');
    Route::post('payment', 'PaymentClientController@index')->name('payment');
    Route::get('paymentList', 'PaymentClientController@getPaymentList')->name('getPaymentList');

    Route::get('profile', 'ProfileClientController@index')->name('profile');
    Route::get('profile-user-edit', ['as' => 'profile.user.edit', 'uses' => 'ProfileClientController@edit']);
    Route::put('profile-user-update', ['as' => 'profile.user.update', 'uses' => 'ProfileClientController@update']);

    Route::get('profile-user-changepwd', 'ProfileClientController@changePwd');
    Route::put('profile-user-changepwd', ['as' => 'profile.user.changepwd', 'uses' => 'PasswordController@cusromerUpdate']);

    
    
});


Route::get('/clearall', function () {
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return 'all cache cleared';
});

//Clear route cache: issue need to fix
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache:
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache cleared';
});

// gen env
Route::get('/envmt', function () {
    $environment = App::environment();
    return $environment;
});
