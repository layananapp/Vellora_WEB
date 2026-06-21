<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private $store;

    public function __construct()
    {
        parent::__construct();

        try {
            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->get("{$this->apiUrl}/api/stores/my-store");

            $this->store = $response->json('data');
        } catch (\Exception $e) {
            $this->store = null;
        }
    }

    public function dashboard()
    {
        $productsResponse = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/products/seller");
        $products = $productsResponse->json('data') ?? [];

        $reviewsResponse = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/seller/reviews");
        $reviews = $reviewsResponse->json('data') ?? [];

        $ordersResponse = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/orders/seller/orders");
        $orders = $ordersResponse->json('data') ?? [];

        $totalRevenue = collect($orders)
            ->where('status', 'delivered')
            ->sum('total_amount');

        $pendingCount = collect($orders)
            ->whereIn('status', ['pending_payment', 'waiting_verification', 'processing'])
            ->count();

        $avgRating = count($reviews) > 0
            ? round(collect($reviews)->avg('rating'), 1)
            : 0;

        return view('dashboard.seller.index', [
            'store'         => $this->store,
            'products'      => $products,
            'reviews'       => $reviews,
            'orders'        => $orders,
            'total_revenue' => $totalRevenue,
            'pending_count' => $pendingCount,
            'avg_rating'    => $avgRating,
        ]);
    }

    public function reviews()
    {
        $response = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/seller/reviews");

        $reviews = $response->failed() ? [] : ($response->json('data') ?? []);

        $avgRating = count($reviews) > 0
            ? round(collect($reviews)->avg('rating'), 1)
            : 0;

        return view('dashboard.seller.reviews', [
            'store'      => $this->store,
            'reviews'    => $reviews,
            'avg_rating' => $avgRating,
        ]);
    }

    public function store()
    {
        $productsResponse = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/products/seller");
        $products = $productsResponse->json('data') ?? [];

        return view('dashboard.seller.store', [
            'store'          => $this->store,
            'total_products' => count($products),
        ]);
    }

    public function pesanan()
    {
        $response = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/orders/seller/orders");

        $orders = $response->failed() ? [] : ($response->json('data') ?? []);

        return view('dashboard.seller.pesanan', [
            'store'  => $this->store,
            'orders' => $orders,
        ]);
    }

    public function detailPesanan($id)
    {
        $response = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/seller/orders/{$id}");

        if ($response->failed()) {
            return redirect()->route('seller.pesanan')
                ->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $order = $response->json('data');

        return view('dashboard.seller.detail-pesanan', [
            'store' => $this->store,
            'order' => $order,
        ]);
    }

    public function notifikasi()
    {
        $response = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/notifications");

        $notifications = $response->failed() ? [] : ($response->json('data') ?? []);

        Http::withToken(session('token'))
            ->put("{$this->apiUrl}/api/notifications/read-all");

        return view('dashboard.seller.notifikasi', [
            'store'         => $this->store,
            'notifications' => $notifications,
        ]);
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'product_name' => ['required'],
            'category_id'  => ['required'],
            'price'        => ['required'],
            'stock'        => ['required'],
        ]);

        $response = Http::withToken(session('token'))
            ->post("{$this->apiUrl}/api/products", [
                'product_name' => $request->product_name,
                'category_id'  => $request->category_id ?: null,
                'description'  => $request->description,
                'price'        => $request->price,
                'stock'        => $request->stock,
                'is_active'    => $request->is_active,
            ]);

        if ($response->failed()) {
            $msg = $response->json('message') ?? 'Gagal tambah produk';
            return back()
                ->withInput()
                ->with('error', $msg);
        }

        $productId = $response->json('data.id');

        if ($request->hasFile('image')) {
            Http::withToken(session('token'))
                ->attach(
                    'image',
                    file_get_contents($request->file('image')),
                    $request->file('image')->getClientOriginalName()
                )
                ->post(
                    "{$this->apiUrl}/api/products/$productId/images"
                );
        }

        if ($request->variations) {
            foreach ($request->variations as $variation) {
                if (
                    empty($variation['name']) ||
                    empty($variation['price']) ||
                    empty($variation['stock'])
                ) {
                    continue;
                }

                Http::withToken(session('token'))
                    ->post(
                        "{$this->apiUrl}/api/products/$productId/variants",
                        [
                            'variant_name' => $variation['name'],
                            'price'        => $variation['price'],
                            'stock'        => $variation['stock'],
                        ]
                    );
            }
        }

        return redirect()
            ->route('seller.produk')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function deleteVariant($id)
    {
        $response = Http::withToken(session('token'))
            ->delete(
                "{$this->apiUrl}/api/variants/$id"
            );

        if ($response->failed()) {
            return back()
                ->with('error', 'Gagal hapus variasi');
        }

        return back()
            ->with('success', 'Variasi berhasil dihapus');
    }

    public function produk()
    {
        $response = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/products/seller", [
                'status' => request('status'),
                'search' => request('search')
            ]);

        $products = $response->json('data') ?? [];

        return view('dashboard.seller.produk', [
            'store'    => $this->store,
            'products' => $products
        ]);
    }

    public function detailProduk($id)
    {
        $response = Http::get(
            "{$this->apiUrl}/api/products/$id"
        );

        $product = $response->json('data');

        if (!$product) {
            return redirect()->route('seller.produk')->with('error', 'Produk tidak ditemukan');
        }

        return view(
            'dashboard.seller.detail-produk',
            [
                'store'   => $this->store,
                'product' => $product
            ]
        );
    }

    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'product_name' => ['required'],
            'price'        => ['required'],
            'stock'        => ['required'],
        ]);

        $response = Http::withToken(session('token'))
            ->put("{$this->apiUrl}/api/products/$id", [
                'product_name' => $request->product_name,
                'category_id'  => $request->category_id ?: null,
                'description'  => $request->description,
                'price'        => $request->price,
                'stock'        => $request->stock,
                'is_active'    => $request->is_active,
            ]);

        if ($response->failed()) {
            $msg = $response->json('message') ?? 'Gagal update produk';
            return back()
                ->withInput()
                ->with('error', $msg);
        }

        if ($request->hasFile('image')) {
            Http::withToken(session('token'))
                ->attach(
                    'image',
                    file_get_contents($request->file('image')),
                    $request->file('image')->getClientOriginalName()
                )
                ->post(
                    "{$this->apiUrl}/api/products/$id/images"
                );
        }

        return redirect()
            ->route('seller.produk')
            ->with('success', 'Produk berhasil diupdate');
    }

    public function editProduk($id)
    {
        $response = Http::get(
            "{$this->apiUrl}/api/products/$id"
        );

        $product = $response->json('data');

        if (!$product) {
            return redirect()->route('seller.produk')->with('error', 'Produk tidak ditemukan');
        }

        $categoryResponse = Http::get(
            "{$this->apiUrl}/api/categories"
        );
        $categories = $categoryResponse->json('data') ?? [];

        return view('dashboard.seller.edit-produk', [
            'store'      => $this->store,
            'product'    => $product,
            'categories' => $categories
        ]);
    }

    public function tambahProduk()
    {
        $categoryResponse = Http::get(
            "{$this->apiUrl}/api/categories"
        );

        $categories = $categoryResponse->json('data') ?? [];

        return view(
            'dashboard.seller.tambah-produk',
            [
                'store'      => $this->store,
                'categories' => $categories
            ]
        );
    }

    public function toggleStatusProduk($id)
    {
        $response = Http::withToken(session('token'))
            ->put(
                "{$this->apiUrl}/api/products/$id/toggle-status"
            );

        if ($response->failed()) {
            return back()->with(
                'error',
                'Gagal ubah status produk'
            );
        }

        return back()->with(
            'success',
            'Status produk berhasil diubah'
        );
    }

    public function storeVariant(Request $request, $id)
    {
        $request->validate([
            'variant_name' => ['required'],
            'price'        => ['required'],
            'stock'        => ['required'],
        ]);

        $response = Http::withToken(session('token'))
            ->post(
                "{$this->apiUrl}/api/products/$id/variants",
                [
                    'variant_name' => $request->variant_name,
                    'price'        => $request->price,
                    'stock'        => $request->stock,
                ]
            );

        if ($response->failed()) {
            return back()
                ->with('error', 'Gagal tambah variasi');
        }

        return back()
            ->with('success', 'Variasi berhasil ditambahkan');
    }

    public function hapusProduk($id)
    {
        $response = Http::withToken(session('token'))
            ->delete(
                "{$this->apiUrl}/api/products/$id"
            );

        if ($response->failed()) {
            return back()->with(
                'error',
                'Gagal hapus produk'
            );
        }

        return back()->with(
            'success',
            'Produk berhasil dihapus'
        );
    }

    public function chat()
    {
        $response = Http::withToken(
            session('token')
        )->get(
            "{$this->apiUrl}/api/chat-rooms"
        );

        $rooms = $response->json('data') ?? [];

        $selectedRoom =
            $rooms[0] ?? null;

        $messages = [];

        if ($selectedRoom) {
            $messageResponse =
                Http::withToken(
                    session('token')
                )->get(
                    "{$this->apiUrl}/api/chat-rooms/{$selectedRoom['id']}/messages"
                );

            $messages =
                $messageResponse->json('data') ?? [];
        }

        return view(
            'dashboard.seller.chat',
            [
                'store'        => $this->store,
                'rooms'        => $rooms,
                'selectedRoom' => $selectedRoom,
                'messages'     => $messages
            ]
        );
    }

    public function sendChat(Request $request, $roomId)
    {
        Http::withToken(
            session('token')
        )->post(
            "{$this->apiUrl}/api/chat-rooms/$roomId/messages",
            [
                'message' =>
                    $request->message
            ]
        );

        return back();
    }

    public function pengaturan()
    {
        return view('dashboard.seller.pengaturan', [
            'store' => $this->store
        ]);
    }

    public function akunToko()
    {
        $userResponse = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/auth/profile");

        $user = $userResponse->json('data') ?? [];

        return view('dashboard.seller.akun-toko', [
            'store' => $this->store,
            'user'  => $user
        ]);
    }

    public function akun()
    {
        $response = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/auth/profile");

        $user = $response->json('data') ?? [];

        return view('dashboard.seller.akun', [
            'store' => $this->store,
            'user'  => $user
        ]);
    }

    public function updateAkun(Request $request)
    {
        $request->validate([
            'name'             => ['required'],
            'email'            => ['required', 'email'],
            'current_password' => ['nullable'],
            'new_password'     => ['nullable', 'min:6'],
            'confirm_password' => ['same:new_password']
        ]);

        $response = Http::withToken(session('token'))
            ->put(
                "{$this->apiUrl}/api/update-profile",
                [
                    'name'  => $request->name,
                    'email' => $request->email
                ]
            );

        if ($response->failed()) {
            return back()->with(
                'error',
                $response->json('message')
            );
        }

        if ($request->new_password) {
            $passwordResponse = Http::withToken(session('token'))
                ->put(
                    "{$this->apiUrl}/api/change-password",
                    [
                        'old_password' =>
                            $request->current_password,
                        'new_password' =>
                            $request->new_password,
                    ]
                );

            if ($passwordResponse->failed()) {
                return back()->with(
                    'error',
                    $passwordResponse->json('message')
                );
            }
        }

        return back()->with(
            'success',
            'Akun berhasil diperbarui'
        );
    }

    public function updateAkunToko(Request $request)
    {
        $request->validate([
            'store_name'   => ['required'],
            'phone_number' => ['required']
        ]);

        $http = Http::withToken(
            session('token')
        );

        if ($request->hasFile('store_logo')) {
            $http = $http->attach(
                'store_logo',
                file_get_contents(
                    $request->file('store_logo')
                ),
                $request->file('store_logo')
                    ->getClientOriginalName()
            );
        }

        $response = $http->post(
            "{$this->apiUrl}/api/stores",
            [
                '_method'      => 'PUT',
                'store_name'   => $request->store_name,
                'phone_number' => $request->phone_number
            ]
        );

        if ($response->failed()) {
            return back()->with(
                'error',
                $response->json('message')
                    ?? 'Gagal update akun toko'
            );
        }

        return back()->with(
            'success',
            'Akun toko berhasil diperbarui'
        );
    }

    public function alamatToko()
    {
        $response = Http::withToken(session('token'))
            ->get("{$this->apiUrl}/api/addresses");

        $addresses = $response->failed() ? [] : ($response->json('data') ?? []);

        return view('dashboard.seller.alamat-toko', [
            'store'     => $this->store,
            'addresses' => $addresses,
        ]);
    }
}