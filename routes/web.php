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



Auth::routes();

Route::get('/images/{file}', function ($file) {
	$url = Storage::disk('do_spaces')->temporaryUrl(
	  $file,
	  date('Y-m-d H:i:s', strtotime("+5 min"))
	);
	if ($url) {
	   return Redirect::to($url);
	}
	return abort(404);
  })->where('file', '.+');


Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/upgame_Joker', [App\Http\Controllers\HomeController::class, 'upgame_Joker'])->name('upgame_Joker');

Route::get('/upgame_pg', [App\Http\Controllers\HomeController::class, 'upgame_pg'])->name('upgame_pg');

Route::get('/upgame_allgame1', [App\Http\Controllers\HomeController::class, 'upgame_allgame'])->name('upgame_allgame');


Route::get('api/data_labelwheel', [App\Http\Controllers\ServiceController::class, 'data_labelwheel'])->name('data_labelwheel');

Route::get('api/data_wheel', [App\Http\Controllers\ServiceController::class, 'data_wheel'])->name('data_wheel');

Route::group(['middleware' => ['auth' ,'checksinglesession']], function () {

    Route::get('/checkout_product/{id}', [App\Http\Controllers\HomeController::class, 'checkout_product'])->name('checkout_product');

    Route::get('api/addwheelresult', [App\Http\Controllers\ServiceController::class, 'addwheelresult'])->name('addwheelresult');
    Route::get('api/addPointCheckin', [App\Http\Controllers\ServiceController::class, 'addPointCheckin'])->name('addPointCheckin');

    Route::get('/spin_wheel', [App\Http\Controllers\HomeController::class, 'spin_wheel'])->name('spin_wheel');


    Route::get('/add_to_checkout/{id}', [App\Http\Controllers\HomeController::class, 'add_to_checkout'])->name('add_to_checkout');

    Route::get('/cart', [App\Http\Controllers\HomeController::class, 'cart'])->name('cart');

    Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');

    Route::get('/payment_success/{id}', [App\Http\Controllers\HomeController::class, 'payment_success'])->name('payment_success');

    Route::get('/history', [App\Http\Controllers\HomeController::class, 'history'])->name('history');
    Route::get('/point_rewards', [App\Http\Controllers\HomeController::class, 'point_rewards'])->name('point_rewards');

    Route::get('/invoice_detail/{id}', [App\Http\Controllers\HomeController::class, 'invoice_detail'])->name('invoice_detail');

    Route::get('/account', [App\Http\Controllers\HomeController::class, 'account'])->name('account');

    Route::post('/add_my_order', [App\Http\Controllers\HomeController::class, 'add_my_order'])->name('add_my_order');
    Route::post('/add_my_order_product', [App\Http\Controllers\HomeController::class, 'add_my_order_product'])->name('add_my_order_product');


    Route::post('/update_user', [App\Http\Controllers\HomeController::class, 'update_user'])->name('update_user');

    Route::get('/promotion', [App\Http\Controllers\HomeController::class, 'promotion'])->name('promotion');

    Route::get('/my_point', [App\Http\Controllers\HomeController::class, 'my_point'])->name('my_point');

    Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

    Route::get('/term', [App\Http\Controllers\HomeController::class, 'term'])->name('term');
    Route::get('/how_to', [App\Http\Controllers\HomeController::class, 'how_to'])->name('how_to');

    Route::get('/get_modal/{id}', [App\Http\Controllers\HomeController::class, 'get_modal'])->name('get_modal');

    Route::post('/add_session_value', [App\Http\Controllers\HomeController::class, 'add_session_value'])->name('add_session_value');

    Route::get('/deleteCart/{id}', [App\Http\Controllers\HomeController::class, 'deleteCart'])->name('deleteCart');
    Route::get('/deleteCart2/{id}', [App\Http\Controllers\HomeController::class, 'deleteCart2'])->name('deleteCart2');



});

Route::group(['middleware' => ['UserRole:superadmin|admin']], function() {


    Route::get('/points_export', [App\Http\Controllers\DashboardController::class, 'points_export'])->name('points_export');
    Route::get('/orders_export', [App\Http\Controllers\DashboardController::class, 'orders_export'])->name('orders_export');

    Route::post('/import', [App\Http\Controllers\DashboardController::class, 'import'])->name('import');

    Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
    Route::resource('/admin/product', App\Http\Controllers\ProductController::class);
    Route::post('/api/product_status', [App\Http\Controllers\ProductController::class, 'product_status'])->name('product_status');
    Route::get('api/del_product/{id}', [App\Http\Controllers\ProductController::class, 'del_product'])->name('del_product');
    Route::get('api/del_point_user_2/{id}', [App\Http\Controllers\UserController::class, 'del_point_user_2'])->name('del_point_user_2');

    Route::resource('/admin/users', App\Http\Controllers\UserController::class);
    Route::get('api/del_users/{id}', [App\Http\Controllers\UserController::class, 'del_user'])->name('del_user');
    Route::post('admin/add_point_user/{id}', [App\Http\Controllers\UserController::class, 'add_point_user'])->name('add_point_user');
    Route::get('api/del_point_user/{id}', [App\Http\Controllers\UserController::class, 'del_point_user'])->name('del_point_user');

    Route::get('api/update_point/{id}', [App\Http\Controllers\UserController::class, 'update_point'])->name('update_point');

    Route::get('admin/user_search', [App\Http\Controllers\UserController::class, 'user_search']);

    Route::resource('/admin/slide_show', App\Http\Controllers\SlideController::class);
    Route::post('api/slide_status', [App\Http\Controllers\SlideController::class, 'slide_status'])->name('slide_status');
    Route::get('api/del_slide/{id}', [App\Http\Controllers\SlideController::class, 'del_slide'])->name('del_slide');

    Route::resource('/admin/order', App\Http\Controllers\OrderController::class);
    Route::get('api/del_order/{id}', [App\Http\Controllers\OrderController::class, 'del_order'])->name('del_order');

    Route::get('admin/setting', [App\Http\Controllers\SettingController::class, 'setting'])->name('setting');
    Route::post('api/post_setting', [App\Http\Controllers\SettingController::class, 'post_setting'])->name('post_setting');

    Route::get('admin/get_point', [App\Http\Controllers\DashboardController::class, 'get_point'])->name('get_point');
    Route::get('admin/get_point/create', [App\Http\Controllers\DashboardController::class, 'get_point_create'])->name('get_point_create');
    Route::get('admin/edit_point/{id}', [App\Http\Controllers\DashboardController::class, 'edit_point'])->name('edit_point');
    Route::post('api/post_wheel/{id}', [App\Http\Controllers\DashboardController::class, 'post_wheel'])->name('post_wheel');

    Route::get('admin/wheel', [App\Http\Controllers\DashboardController::class, 'wheel'])->name('wheel');
    Route::get('admin/point_checkin', [App\Http\Controllers\DashboardController::class, 'point_checkin'])->name('point_checkin');
    Route::get('admin/edit_point_checkin/{id}', [App\Http\Controllers\DashboardController::class, 'edit_point_checkin'])->name('edit_point_checkin');

    Route::post('api/post_point_checkin/{id}', [App\Http\Controllers\DashboardController::class, 'post_point_checkin'])->name('post_point_checkin');

    Route::get('api/del_checkin_all', [App\Http\Controllers\DashboardController::class, 'del_checkin_all'])->name('del_checkin_all');

});
