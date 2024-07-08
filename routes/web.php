<?php

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Name;
use App\Controllers\Home;
use App\Controllers\AuthController;
use App\Controllers\Admin\PenjualanController;
use App\Controllers\Admin\KasirController;
use App\Controllers\Admin\KategoriController;
use App\Controllers\Admin\PembelianController;
use App\Controllers\Admin\ProdukController;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\TestimonialController;
use App\Controllers\Kasir\TestimonialKasirController;
use App\Controllers\Kasir\PembelianKasirController;
use App\Controllers\Kasir\PenjualanKasirController;
use App\Controllers\Kasir\ProdukKasirController;
use App\Controllers\Kasir\KasirLoginController;

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

Route::get('/', 'App\Http\Controllers\Home@index');
Route::get('/shop', 'App\Http\Controllers\Home@shop');
Route::get('/about', 'App\Http\Controllers\Home@about');
Route::post('/tambahtestimonial', 'App\Http\Controllers\Home@store');
Route::get('/contact', 'App\Http\Controllers\Home@contact');
Route::get('/login', 'App\Http\Controllers\AuthController@index');
Route::post('/login', 'App\Http\Controllers\AuthController@authenticate');
Route::get('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/register', 'App\Http\Controllers\AuthController@process');


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [FrontEndController::class, 'Userhome'])->name('home');
// Route::get("/User/home", [FrontEndController::class, 'Userhome'])->name('User.home')->middleware('auth');

// Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
// Route::post('/login', [AuthController::class, 'authenticate']);
// Route::get('/register', [AuthController::class, 'register']);
// Route::post('/register', [AuthController::class, 'process']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/change-password', [AuthController::class, 'changePassword']);
// Route::post('/change-password', [AuthController::class, 'processChangePassword']);

// Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
// Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

// Route::get('/masukan', [FeedbackController::class, 'UserFeedback'])->name('User.masukan');
// Route::post('/masukan', [FeedbackController::class, 'feedback'])->name('masukan');

// Route::get('/pesanan', [FrontendController::class, 'pesanan'])->name('pesanan');
// Route::post('/addpesanan', [FrontEndController::class, 'addpesanan'])->name('addpesanan');
// Route::get('/menu/{slug}',[FrontEndController::class, 'Category'])->name('category');
// Route::get('/search', [FrontEndController::class, 'search'])->name('search');

Route::group(['middleware' => 'admin'], function () {
    //Admin
    Route::get('/admin/dashboard', 'App\Http\Controllers\Admin\AdminController@index');
    Route::get('/admin/logout', 'App\Http\Controllers\AuthController@logout');
    
    Route::get('/admin/produk', 'App\Http\Controllers\Admin\ProdukController@index');
    Route::get('/admin/produk/{id}', 'App\Http\Controllers\Admin\ProdukController@show');
    Route::get('/admin/produk/{id}/edit', 'App\Http\Controllers\Admin\ProdukController@edit');
    Route::put('/admin/produk/{id}', 'App\Http\Controllers\Admin\ProdukController@update');
    Route::delete('/admin/produk/{id}', 'App\Http\Controllers\Admin\ProdukController@destroy');

    Route::get('/admin/kasir/create', 'App\Http\Controllers\Admin\KasirController@create');
    Route::post('/admin/kasir', 'App\Http\Controllers\Admin\KasirController@store');
    Route::get('/admin/kasir', 'App\Http\Controllers\Admin\KasirController@index');
    Route::get('/admin/kasir/{id}', 'App\Http\Controllers\Admin\KasirController@show');
    Route::delete('/admin/kasir/{id}', 'App\Http\Controllers\Admin\KasirController@destroy');

    Route::get('/admin/kategori/create', 'App\Http\Controllers\Admin\KategoriController@create');
    Route::post('/admin/kategori', 'App\Http\Controllers\Admin\KategoriController@store');
    Route::get('/admin/kategori', 'App\Http\Controllers\Admin\KategoriController@index');
    Route::get('/admin/kategori/{id}', 'App\Http\Controllers\Admin\KategoriController@show');
    Route::get('/admin/kategori/{id}/edit', 'App\Http\Controllers\Admin\KategoriController@edit');
    Route::put('/admin/kategori/{id}', 'App\Http\Controllers\Admin\KategoriController@update');
    Route::delete('/admin/kategori/{id}', 'App\Http\Controllers\Admin\KategoriController@destroy');

    Route::get('/admin/pembelian/create', 'App\Http\Controllers\Admin\PembelianController@create');
    Route::post('/admin/pembelian', 'App\Http\Controllers\Admin\PembelianController@store');
    Route::get('/admin/pembelian', 'App\Http\Controllers\Admin\PembelianController@index');
    Route::get('/admin/pembelian/{id}', 'App\Http\Controllers\Admin\PembelianController@show');
    Route::get('/admin/pembelian/{id}/edit', 'App\Http\Controllers\Admin\PembelianController@edit');
    Route::put('/admin/pembelian/{id}', 'App\Http\Controllers\Admin\PembelianController@update');
    Route::delete('/admin/pembelian/{id}', 'App\Http\Controllers\Admin\PembelianController@destroy');

    Route::get('/admin/penjualan/create', 'App\Http\Controllers\Admin\PenjualanController@create');
    Route::post('/admin/penjualan', 'App\Http\Controllers\Admin\PenjualanController@store');
    Route::get('/admin/penjualan', 'App\Http\Controllers\Admin\PenjualanController@index');
    Route::get('/admin/penjualan/{id}', 'App\Http\Controllers\Admin\PenjualanController@show');
    Route::get('/admin/penjualan/{id}/edit', 'App\Http\Controllers\Admin\PenjualanController@edit');
    Route::put('/admin/penjualan/{id}', 'App\Http\Controllers\Admin\PenjualanController@update');
    Route::delete('/admin/penjualan/{id}', 'App\Http\Controllers\Admin\PenjualanController@destroy');

    Route::get('/admin/testimonial', 'App\Http\Controllers\Admin\TestimonialController@index');
    Route::get('/admin/testimonial/{id}', 'App\Http\Controllers\Admin\TestimonialController@show');
    
    Route::get('/admin/profile', 'App\Http\Controllers\Admin\AdminController@profile');
    Route::match (['get', 'post'], '/admin/update-admin-details', 'App\Http\Controllers\Admin\AdminController@UpdateAdminDetails');
    Route::match (['get', 'post'], '/admin/update-admin-password', 'App\Http\Controllers\Admin\AdminController@UpdateAdminPassword');
});


Route::group(['middleware' => 'kasir'], function () {
    //Kasir
    Route::get('/kasir/dashboard', 'App\Http\Controllers\Kasir\KasirLoginController@dashboard');
    Route::get('/kasir/logout', 'App\Http\Controllers\AuthController@logout');

    Route::get('/kasir/produk/create', 'App\Http\Controllers\Kasir\ProdukKasirController@create');
    Route::post('/kasir/produk', 'App\Http\Controllers\Kasir\ProdukKasirController@store');
    Route::get('/kasir/produk', 'App\Http\Controllers\Kasir\ProdukKasirController@index');
    Route::get('/kasir/produk/{id}', 'App\Http\Controllers\Kasir\ProdukKasirController@show');
    Route::get('/kasir/produk/{id}/edit', 'App\Http\Controllers\Kasir\ProdukKasirController@edit');
    Route::put('/kasir/produk/{id}', 'App\Http\Controllers\Kasir\ProdukKasirController@update');
    Route::delete('/kasir/produk/{id}', 'App\Http\Controllers\Kasir\ProdukKasirController@destroy');

    Route::get('/kasir/penjualan/create', 'App\Http\Controllers\Kasir\PenjualanKasirController@create');
    Route::post('/kasir/penjualan', 'App\Http\Controllers\Kasir\PenjualanKasirController@store');
    Route::get('/kasir/penjualan', 'App\Http\Controllers\Kasir\PenjualanKasirController@index');
    Route::get('/kasir/penjualan/{id}', 'App\Http\Controllers\Kasir\PenjualanKasirController@show');
    Route::get('/kasir/penjualan/{id}/edit', 'App\Http\Controllers\Kasir\PenjualanKasirController@edit');
    Route::put('/kasir/penjualan/{id}', 'App\Http\Controllers\Kasir\PenjualanKasirController@update');
    Route::delete('/kasir/penjualan/{id}', 'App\Http\Controllers\Kasir\PenjualanKasirController@destroy');

    Route::get('/kasir/testimonial', 'App\Http\Controllers\Kasir\TestimonialKasirController@index');
    Route::get('/kasir/testimonial/{id}', 'App\Http\Controllers\Kasir\TestimonialKasirController@show');
    
    Route::get('/kasir/profile', 'App\Http\Controllers\Kasir\KasirLoginController@profile');
    Route::match (['get', 'post'], '/kasir/update-kasir-details', 'App\Http\Controllers\Kasir\KasirLoginController@UpdateKasirDetails');
    Route::match (['get', 'post'], '/kasir/update-kasir-password', 'App\Http\Controllers\Kasir\KasirLoginController@UpdateKasirPassword');
});
//     Route::get('/all/pesanan', [FrontEndController::class, 'AllPesanan'])->name('all.pesanan');
//     Route::get('/all/pesanan/{id}', [FrontEndController::class, 'statuspemesanan'])->name('status');


//     // Routes for CategoryController
//     Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
//     Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
//     Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
//     Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
//     Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
//     Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
//     Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

//     Route::resource('/post', PostController::class);

// });

// Route::delete('/pesanan/{id}', [FrontEndController::class, 'deletePesanan'])->name('delete.pesanan');
// Route::get('/admin/sale/create', [SaleController::class, 'create'])->name('admin.sale.create');
// Route::get('/admin/sale', [SaleController::class, 'index'])->name('admin.sale');
// Route::post('/admin/sale', [SaleController::class, 'store'])->name('sale.store');
// Route::get('/admin/sale/{id}', [SaleController::class, 'show'])->name('sale.show');
// Route::get('/admin/sale/{id}/edit', [SaleController::class, 'edit'])->name('sale.edit');
// Route::put('/admin/sale/{id}', [SaleController::class, 'update'])->name('sale.update');
// Route::delete('/admin/sale/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');

