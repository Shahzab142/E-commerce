<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function trackOrder(Request $request): View
    {
        $trackingNumber = trim((string) $request->query('tracking_number', ''));

        $status = null;
        $steps = [];
        $order = null;

        if ($trackingNumber !== '') {
            $order = Order::query()
                ->with(['items'])
                ->where('order_number', $trackingNumber)
                ->orWhere('payment_reference', $trackingNumber)
                ->first();

            if ($order) {
                $status = $order->status;

                $steps = [
                    ['label' => 'Order Placed', 'status' => 'completed', 'date' => $order->placed_at?->format('d M, Y') ?? $order->created_at->format('d M, Y')],
                    ['label' => 'Processing', 'status' => 'completed', 'date' => $order->placed_at?->addDays(1)->format('d M, Y') ?? ''],
                ];

                if (in_array($status, ['processing', 'shipped', 'delivered'], true)) {
                    $steps[] = ['label' => 'Shipped', 'status' => 'completed', 'date' => $order->updated_at->format('d M, Y')];
                }

                if (in_array($status, ['shipped', 'delivered'], true)) {
                    $steps[] = ['label' => 'Out for Delivery', 'status' => 'active', 'date' => $status === 'delivered' ? $order->updated_at->format('d M, Y') : ''];
                }

                if ($status === 'delivered') {
                    $steps[] = ['label' => 'Delivered', 'status' => 'completed', 'date' => $order->updated_at->format('d M, Y')];
                } elseif ($status === 'cancelled') {
                    $steps = [
                        ['label' => 'Order Placed', 'status' => 'completed', 'date' => $order->placed_at?->format('d M, Y') ?? $order->created_at->format('d M, Y')],
                        ['label' => 'Cancelled', 'status' => 'completed', 'date' => $order->updated_at->format('d M, Y')],
                    ];
                } else {
                    $steps[] = ['label' => 'Delivered', 'status' => 'pending', 'date' => ''];
                }
            }
        }

        return view('track-order', compact('trackingNumber', 'status', 'steps', 'order'));
    }
}
