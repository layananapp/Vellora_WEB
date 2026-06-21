<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            $usersResponse = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/users");
            $users = $usersResponse->json('data') ?? [];

            $productsResponse = Http::get("{$this->apiUrl}/api/products?all=true");
            $productsData = $productsResponse->json('data') ?? [];
            $products = $productsData['data'] ?? [];
            $totalProducts = $productsData['total'] ?? 0;

            $ordersResponse = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/orders");
            $orders = $ordersResponse->json('data') ?? [];

            $reportsResponse = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/reports");
            $reports = $reportsResponse->json('data') ?? [];
        } catch (\Exception $e) {
            $users = [];
            $products = [];
            $totalProducts = 0;
            $orders = [];
            $reports = [];
        }

        $buyers = collect($users)->where('role', 'buyer');
        $sellers = collect($users)->where('role', 'seller');

        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateStr = now()->subDays($i)->format('Y-m-d');
            $last7Days[$dateStr] = [
                'label' => now()->subDays($i)->translatedFormat('d M'),
                'total' => 0
            ];
        }

        foreach ($orders as $order) {
            $date = substr($order['created_at'], 0, 10);
            if (isset($last7Days[$date])) {
                $last7Days[$date]['total'] += (float) $order['total_amount'];
            }
        }

        $statusCounts = [
            'pending_payment' => 0,
            'waiting_verification' => 0,
            'processing' => 0,
            'shipped' => 0,
            'delivered' => 0,
            'cancelled' => 0
        ];
        $sevenDaysAgo = now()->subDays(7)->startOfDay();
        foreach ($orders as $order) {
            $orderDate = \Carbon\Carbon::parse($order['created_at']);
            if ($orderDate->greaterThanOrEqualTo($sevenDaysAgo)) {
                $status = $order['status'];
                if (isset($statusCounts[$status])) {
                    $statusCounts[$status]++;
                }
            }
        }

        $statusLabels = [
            'pending_payment' => 'Menunggu Pembayaran',
            'waiting_verification' => 'Menunggu Verifikasi',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        $pieLabels = [];
        $pieData = [];
        foreach ($statusCounts as $status => $count) {
            $pieLabels[] = $statusLabels[$status];
            $pieData[] = $count;
        }

        return view('dashboard.admin.index', [
            'products'         => $products,
            'total_products'   => $totalProducts,
            'users'            => $buyers,
            'sellers'          => $sellers,
            'orders'           => $orders,
            'reports'          => $reports,
            'chart_bar_labels' => array_column($last7Days, 'label'),
            'chart_bar_data'   => array_column($last7Days, 'total'),
            'chart_pie_labels' => $pieLabels,
            'chart_pie_data'   => $pieData,
        ]);
    }

    public function user()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/users");
            $users = $response->json('data') ?? [];
        } catch (\Exception $e) {
            $users = [];
        }

        $buyers = collect($users)->where('role', 'buyer')->toArray();

        return view('dashboard.admin.user', [
            'users' => $buyers,
        ]);
    }

    public function seller()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/users");
            $users = $response->json('data') ?? [];
        } catch (\Exception $e) {
            $users = [];
        }

        $sellers = collect($users)->where('role', 'seller')->toArray();

        return view('dashboard.admin.seller', [
            'sellers' => $sellers,
        ]);
    }

    public function produk()
    {
        try {
            $response = Http::get("{$this->apiUrl}/api/products?all=true");
            $products = $response->json('data.data') ?? [];
        } catch (\Exception $e) {
            $products = [];
        }

        return view('dashboard.admin.produk', [
            'products' => $products,
        ]);
    }

    public function review()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/reviews");
            $reviews = $response->json('data') ?? [];
        } catch (\Exception $e) {
            $reviews = [];
        }

        $reviewsCount = count($reviews);
        $positiveReviews = collect($reviews)->where('rating', '>=', 4)->count();
        $neutralReviews = collect($reviews)->where('rating', 3)->count();
        $negativeReviews = collect($reviews)->where('rating', '<=', 2)->count();

        return view('dashboard.admin.review', [
            'reviews'          => $reviews,
            'reviews_count'    => $reviewsCount,
            'positive_reviews' => $positiveReviews,
            'neutral_reviews'  => $neutralReviews,
            'negative_reviews' => $negativeReviews,
        ]);
    }

    public function transaksi()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/orders");
            $orders = $response->json('data') ?? [];
        } catch (\Exception $e) {
            $orders = [];
        }

        return view('dashboard.admin.transaksi', [
            'orders' => $orders,
        ]);
    }

    public function notifikasi()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/notifications");
            $notifications = $response->json('data') ?? [];
        } catch (\Exception $e) {
            $notifications = [];
        }

        return view('dashboard.admin.notifikasi', [
            'notifications' => $notifications,
        ]);
    }

    public function laporan()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/reports");
            $reports = $response->json('data') ?? [];
        } catch (\Exception $e) {
            $reports = [];
        }

        return view('dashboard.admin.laporan', [
            'reports' => $reports,
        ]);
    }

    public function pengaturan()
    {
        try {
            $categoriesResponse = Http::get("{$this->apiUrl}/api/categories");
            $categories = $categoriesResponse->json('data') ?? [];

            $vouchersResponse = Http::get("{$this->apiUrl}/api/vouchers");
            $vouchers = $vouchersResponse->json('data') ?? [];

            $usersResponse = Http::withHeaders($this->getHeaders())->get("{$this->apiUrl}/api/admin/users");
            $users = $usersResponse->json('data') ?? [];
        } catch (\Exception $e) {
            $categories = [];
            $vouchers = [];
            $users = [];
        }

        $buyersCount = collect($users)->where('role', 'buyer')->count();
        $sellersCount = collect($users)->where('role', 'seller')->count();

        return view('dashboard.admin.pengaturan', [
            'categories'    => $categories,
            'vouchers'      => $vouchers,
            'buyers_count'  => $buyersCount,
            'sellers_count' => $sellersCount,
        ]);
    }

    public function suspendUser($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->put("{$this->apiUrl}/api/admin/users/{$id}/suspend");
            if ($response->successful()) {
                return back()->with('success', 'User berhasil ditangguhkan.');
            }
            return back()->with('error', $response->json('message') ?? 'Gagal menangguhkan user.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function unsuspendUser($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->put("{$this->apiUrl}/api/admin/users/{$id}/unsuspend");
            if ($response->successful()) {
                return back()->with('success', 'User berhasil diaktifkan kembali.');
            }
            return back()->with('error', $response->json('message') ?? 'Gagal mengaktifkan user.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function deleteUser($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->delete("{$this->apiUrl}/api/admin/users/{$id}");
            if ($response->successful()) {
                return back()->with('success', 'User berhasil dihapus.');
            }
            return back()->with('error', $response->json('message') ?? 'Gagal menghapus user.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:100'],
        ]);

        try {
            $response = Http::withHeaders($this->getHeaders())->post("{$this->apiUrl}/api/admin/categories", [
                'category_name' => $request->category_name,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Kategori baru berhasil ditambahkan.');
            }
            return back()->with('error', $response->json('message') ?? 'Gagal menambahkan kategori.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function storeVoucher(Request $request)
    {
        $request->validate([
            'code'                => ['required', 'string', 'max:50'],
            'voucher_name'        => ['required', 'string', 'max:255'],
            'discount_type'       => ['required', 'in:percentage,fixed'],
            'discount_value'      => ['required', 'numeric', 'min:0'],
            'minimum_transaction' => ['nullable', 'numeric', 'min:0'],
            'quota'               => ['required', 'integer', 'min:1'],
            'expired_at'          => ['nullable', 'date'],
        ]);

        try {
            $response = Http::withHeaders($this->getHeaders())->post("{$this->apiUrl}/api/admin/vouchers", [
                'code'                => $request->code,
                'voucher_name'        => $request->voucher_name,
                'discount_type'       => $request->discount_type,
                'discount_value'      => $request->discount_value,
                'minimum_transaction' => $request->minimum_transaction ?? 0,
                'quota'               => $request->quota,
                'expired_at'          => $request->expired_at,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Voucher baru berhasil dibuat.');
            }
            return back()->with('error', $response->json('message') ?? 'Gagal membuat voucher.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function updateReportStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:resolved,rejected'],
        ]);

        try {
            $response = Http::withHeaders($this->getHeaders())->put("{$this->apiUrl}/api/admin/reports/{$id}/status", [
                'status' => $request->status,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Status laporan berhasil diperbarui.');
            }
            return back()->with('error', $response->json('message') ?? 'Gagal memperbarui status laporan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}