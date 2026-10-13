<?php

namespace App\Http\Controllers;

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\User;
use App\Services\XlsxExport;
use Illuminate\Http\Request;

/**
 * "Download as Excel" endpoints for admin, vendor and customer dashboards.
 *
 * Every export streams a real .xlsx file (see App\Services\XlsxExport).
 */
class ExportController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Customer
    |----------------------------------------------------------------------
    */

    /**
     * Customer order history export.
     */
    public function userOrders(Request $request): void
    {
        $orders = $request->user()->customerOrders()
            ->with('items')
            ->latest('placed_at')
            ->get();

        $rows = $orders->map(fn (Order $order): array => [
            $order->order_number,
            $order->placed_at?->format('Y-m-d H:i') ?? $order->created_at->format('Y-m-d H:i'),
            $order->items->count(),
            number_format((float) $order->total, 2),
            $order->payment_method ?: '—',
            ucfirst($order->status),
            $order->payment_reference ?? '—',
        ])->all();

        XlsxExport::download(
            ['Order #', 'Date', 'Items', 'Total', 'Payment Method', 'Status', 'Payment Reference'],
            $rows,
            'my-order-history-'.now()->format('Y-m-d').'.xlsx',
            'Order History'
        );
    }

    /*
    |----------------------------------------------------------------------
    | Vendor
    |----------------------------------------------------------------------
    */

    /**
     * Vendor products export.
     */
    public function vendorProducts(Request $request): void
    {
        $products = $request->user()->products()
            ->with(['category'])
            ->latest()
            ->get();

        $rows = $products->map(fn (AdminProduct $product): array => [
            $product->id,
            $product->name,
            $product->sku ?? '—',
            $product->category?->name ?? 'Uncategorised',
            number_format((float) $product->regular_price, 2),
            $product->sale_price !== null ? number_format((float) $product->sale_price, 2) : '—',
            $product->quantity,
            ucfirst(str_replace('_', ' ', $product->stock_status)),
            ucfirst($product->status),
            $product->created_at->format('Y-m-d'),
        ])->all();

        XlsxExport::download(
            ['ID', 'Product', 'SKU', 'Category', 'Regular Price', 'Sale Price', 'Qty', 'Stock', 'Status', 'Created'],
            $rows,
            'my-products-'.now()->format('Y-m-d').'.xlsx',
            'Products'
        );
    }

    /**
     * Vendor customers export (customers who bought from this vendor).
     */
    public function vendorUsers(Request $request): void
    {
        $users = User::query()
            ->whereHas('customerOrders.items.product', fn ($query) => $query->where('vendor_id', $request->user()->id))
            ->withCount(['customerOrders' => fn ($query) => $query
                ->whereHas('items.product', fn ($q) => $q->where('vendor_id', $request->user()->id)),
            ])
            ->latest()
            ->get();

        $rows = $users->map(fn (User $user): array => [
            $user->id,
            $user->name,
            $user->email,
            $user->phone ?? '—',
            $user->customer_orders_count,
            ucfirst($user->status),
            $user->created_at->format('Y-m-d'),
        ])->all();

        XlsxExport::download(
            ['ID', 'Customer', 'Email', 'Phone', 'Orders', 'Status', 'Joined'],
            $rows,
            'my-customers-'.now()->format('Y-m-d').'.xlsx',
            'Customers'
        );
    }

    /**
     * Vendor orders export.
     */
    public function vendorOrders(Request $request): void
    {
        $orders = Order::query()
            ->where('vendor_id', $request->user()->id)
            ->with(['user', 'items' => fn ($query) => $query
                ->whereHas('product', fn ($q) => $q->where('vendor_id', $request->user()->id)),
            ])
            ->latest()
            ->get();

        $rows = $orders->map(fn (Order $order): array => [
            $order->order_number,
            $order->user->name ?? '—',
            $order->placed_at?->format('Y-m-d H:i') ?? $order->created_at->format('Y-m-d H:i'),
            $order->items->count(),
            number_format((float) $order->total, 2),
            $order->payment_method ?: '—',
            ucfirst($order->status),
        ])->all();

        XlsxExport::download(
            ['Order #', 'Customer', 'Date', 'My Items', 'Total', 'Payment Method', 'Status'],
            $rows,
            'my-orders-'.now()->format('Y-m-d').'.xlsx',
            'Orders'
        );
    }

    /*
    |----------------------------------------------------------------------
    | Admin
    |----------------------------------------------------------------------
    */

    /**
     * Admin categories export.
     */
    public function adminCategories(): void
    {
        $rows = AdminCategory::query()
            ->withCount('products')
            ->orderBy('name')
            ->get()
            ->map(fn (AdminCategory $category): array => [
                $category->id,
                $category->name,
                $category->slug,
                $category->products_count,
                ucfirst($category->status),
                $category->show_on_homepage ? 'Yes' : 'No',
            ])->all();

        XlsxExport::download(
            ['ID', 'Category', 'Slug', 'Products', 'Status', 'On Homepage'],
            $rows,
            'categories-'.now()->format('Y-m-d').'.xlsx',
            'Categories'
        );
    }

    /**
     * Admin products export (all admin + vendor products).
     */
    public function adminProducts(): void
    {
        $rows = AdminProduct::query()
            ->with(['category'])
            ->latest()
            ->get()
            ->map(fn (AdminProduct $product): array => [
                $product->id,
                $product->name,
                $product->sku ?? '—',
                $product->category?->name ?? 'Uncategorised',
                number_format((float) ($product->regular_price ?? 0), 2),
                $product->sale_price !== null ? number_format((float) $product->sale_price, 2) : '—',
                $product->quantity ?? 0,
                ucfirst(str_replace('_', ' ', (string) ($product->stock_status ?? 'in_stock'))),
                ucfirst((string) ($product->status ?? 'published')),
                $product->created_at?->format('Y-m-d') ?? now()->format('Y-m-d'),
            ])->all();

        XlsxExport::download(
            ['ID', 'Product Name', 'SKU', 'Category', 'Regular Price', 'Sale Price', 'Quantity', 'Stock Status', 'Status', 'Date Added'],
            $rows,
            'products-'.now()->format('Y-m-d').'.xlsx',
            'Products'
        );
    }

    /**
     * Admin vendors export.
     */
    public function adminVendors(): void
    {
        $rows = User::query()
            ->with('vendorDetail')
            ->where('role', User::ROLE_VENDOR)
            ->latest()
            ->get()
            ->map(fn (User $vendor): array => [
                $vendor->id,
                $vendor->name,
                $vendor->email,
                $vendor->phone ?? '—',
                $vendor->vendorDetail?->store_name ?? '—',
                ucfirst($vendor->status),
                $vendor->created_at->format('Y-m-d'),
            ])->all();

        XlsxExport::download(
            ['ID', 'Vendor', 'Email', 'Phone', 'Store', 'Status', 'Joined'],
            $rows,
            'vendors-'.now()->format('Y-m-d').'.xlsx',
            'Vendors'
        );
    }

    /**
     * Admin customers export.
     */
    public function adminUsers(): void
    {
        $rows = User::query()
            ->withCount('customerOrders')
            ->where('role', User::ROLE_USER)
            ->latest()
            ->get()
            ->map(fn (User $user): array => [
                $user->id,
                $user->name,
                $user->email,
                $user->phone ?? '—',
                $user->customer_orders_count,
                ucfirst($user->status),
                $user->created_at->format('Y-m-d'),
            ])->all();

        XlsxExport::download(
            ['ID', 'Customer', 'Email', 'Phone', 'Orders', 'Status', 'Joined'],
            $rows,
            'customers-'.now()->format('Y-m-d').'.xlsx',
            'Customers'
        );
    }

    /**
     * Admin orders export.
     */
    public function adminOrders(): void
    {
        $rows = Order::query()
            ->with(['user', 'items'])
            ->latest()
            ->get()
            ->map(fn (Order $order): array => [
                $order->order_number,
                $order->user->name ?? '—',
                $order->placed_at?->format('Y-m-d H:i') ?? $order->created_at->format('Y-m-d H:i'),
                $order->items->count(),
                number_format((float) $order->total, 2),
                $order->payment_method ?: '—',
                ucfirst($order->status),
            ])->all();

        XlsxExport::download(
            ['Order #', 'Customer', 'Date', 'Items', 'Total', 'Payment Method', 'Status'],
            $rows,
            'orders-'.now()->format('Y-m-d').'.xlsx',
            'Orders'
        );
    }
}
