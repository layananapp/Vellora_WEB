<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\SellerController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\OrderController;

Route::get('/', function () {
    return view('landing.index');
})->name('landing');

Route::get('/tentang-kami', function () {
    return view('landing.pages.tentang-kami');
})->name('tentang-kami');

Route::get('/kontak', function () {
    return view('landing.pages.kontak');
})->name('kontak');

Route::get('/syarat-ketentuan', function () {
    return view('landing.pages.syarat-ketentuan');
})->name('syarat-ketentuan');   

Route::get('/kebijakan-privasi', function () {
    return view('landing.pages.kebijakan-privasi');
})->name('kebijakan-privasi');

Route::get('/cara-belanja', function () {
    return view('landing.pages.cara-belanja');
})->name('cara-belanja');

Route::get('/hapus-data', function () {
    return view('landing.pages.hapus-data');
})->name('hapus-data');

Route::get('/products/{category}', function ($category) {
    try {
        $apiUrl = config('services.marketplace_api.url');
        // Fetch categories from API
        $categoriesResponse = Illuminate\Support\Facades\Http::get($apiUrl . '/api/categories');
        $categories = $categoriesResponse->json('data') ?? [];

        // Match category
        $matchedCategory = collect($categories)->first(function ($cat) use ($category) {
            $dbName = strtolower($cat['category_name']);
            $routeCategory = strtolower($category);
            if ($routeCategory === 'rumah' && str_contains($dbName, 'rumah')) {
                return true;
            }
            return str_contains($dbName, $routeCategory) || str_contains($routeCategory, $dbName);
        });

        $products = [];
        if ($matchedCategory) {
            $productsResponse = Illuminate\Support\Facades\Http::get($apiUrl . '/api/products', [
                'category_id' => $matchedCategory['id']
            ]);
            $products = $productsResponse->json('data.data') ?? [];
        } else {
            $productsResponse = Illuminate\Support\Facades\Http::get($apiUrl . '/api/products');
            $products = $productsResponse->json('data.data') ?? [];
        }
    } catch (\Exception $e) {
        $products = [];
    }

    return view('landing.products.index', compact('category', 'products'));
})->name('products');

Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'login')
        ->name('login');

    Route::post('/login', 'authenticate')
        ->name('login.authenticate');

    Route::post('/logout', 'logout')
        ->name('logout');

    Route::get('/lupa-password', 'lupaPassword')
        ->name('lupa-password');

    Route::post('/lupa-password', 'sendOtp')
        ->name('lupa-password.send');

    Route::get('/verifikasi-kode', 'verifikasiKode')
        ->name('verifikasi-kode');

    Route::post('/verifikasi-kode', 'verifyOtp')
        ->name('verifikasi-kode.verify');

    Route::get('/reset-password', 'resetPassword')
        ->name('reset-password');

    Route::post('/reset-password', 'submitResetPassword')
        ->name('reset-password.submit');
});

Route::middleware(['auth.custom', 'role.custom:seller'])
->prefix('seller')
->controller(SellerController::class)
->name('seller.')
->group(function () {

    Route::get('/dashboard', 'dashboard')
        ->name('dashboard');

    Route::get('/reviews', 'reviews')
        ->name('reviews');

    Route::get('/store', 'store')
        ->name('store');

    Route::get('/pesanan', 'pesanan')
        ->name('pesanan');

    Route::get('/detail-pesanan/{id}', 'detailPesanan')
        ->name('detail-pesanan');

    Route::get('/produk', 'produk')
        ->name('produk');

    Route::get('/detail-produk/{id}', 'detailProduk')
        ->name('detail-produk');

    Route::get('/edit-produk/{id}', 'editProduk')
        ->name('edit-produk');

    Route::put('/update-produk/{id}', 'updateProduk')
        ->name('update-produk');

    Route::post('/produk/{id}/variant', 'storeVariant')
        ->name('store-variant');

    Route::delete('/variant/{id}', 'deleteVariant')
        ->name('delete-variant');

    Route::put('/produk/{id}/nonaktif','nonaktifProduk')
        ->name('nonaktif-produk');

    Route::put('/produk/{id}/toggle-status','toggleStatusProduk')
        ->name('toggle-status-produk');

    Route::delete('/produk/{id}', 'hapusProduk')
        ->name('hapus-produk');

    Route::get('/tambah-produk', 'tambahProduk')
        ->name('tambah-produk');

    Route::post('/tambah-produk', 'storeProduk')
        ->name('store-produk');

    Route::get('/chat', 'chat')
        ->name('chat');

    Route::post('/chat/{roomId}/send', 'sendChat')
        ->name('send-chat');

    Route::get('/notifikasi', 'notifikasi')
        ->name('notifikasi');

    Route::get('/pengaturan', 'pengaturan')
        ->name('pengaturan');

    Route::get('/akun-toko', 'akunToko')
        ->name('akun-toko');

    Route::get('/akun', 'akun')
        ->name('akun');

    Route::put('/akun', 'updateAkun')
        ->name('update-akun');

    Route::put('/akun-toko', 'updateAkunToko')
        ->name('update-akun-toko');

    Route::get('/alamat-toko', 'alamatToko')
        ->name('alamat-toko');

});

Route::middleware('auth.custom', 'role.custom:admin')
->prefix('admin')
->controller(AdminController::class)
->name('admin.')
->group(function () {

    Route::get('/dashboard', 'dashboard')
        ->name('dashboard');

    Route::get('/user', 'user')
        ->name('user');

    Route::get('/seller', 'seller')
        ->name('seller');

    Route::get('/produk', 'produk')
        ->name('produk');

    Route::get('/review', 'review')
        ->name('review');

    Route::get('/transaksi', 'transaksi')
        ->name('transaksi');

    Route::get('/notifikasi', 'notifikasi')
        ->name('notifikasi');

    Route::get('/laporan', 'laporan')
        ->name('laporan');

    Route::get('/pengaturan', 'pengaturan')
        ->name('pengaturan');

    Route::put('/user/{id}/suspend', 'suspendUser')
        ->name('user.suspend');

    Route::put('/user/{id}/unsuspend', 'unsuspendUser')
        ->name('user.unsuspend');

    Route::delete('/user/{id}', 'deleteUser')
        ->name('user.delete');

    Route::post('/categories', 'storeCategory')
        ->name('store-category');

    Route::post('/vouchers', 'storeVoucher')
        ->name('store-voucher');

    Route::put('/reports/{id}/status', 'updateReportStatus')
        ->name('report.status');

});