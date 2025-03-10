<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\History;
use App\Models\User;
use App\Http\Requests\StoreHistoryRequest;
use App\Http\Requests\UpdateHistoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class HistoryController extends Controller
{
    /**
     * Constructor to setup Midtrans configuration
     */
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Display a listing of payment histories for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        $histories = History::where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $histories
        ]);
    }

    /**
     * Initiate payment process
     */
    public function initiatePayment(Request $request)
    {
        // Validate request
        $request->validate([
            'event_id' => 'required|exists:events,id',
            // Remove quantity validation or keep for backward compatibility
        ]);

        $user = Auth::user();
        $event = Event::findOrFail($request->event_id);
        $quantity = 1; // Fixed to 1 regardless of request input

        // Calculate total payment
        $totalPayment = $event->harga_tiket * $quantity;

        // Generate order ID
        $orderId = 'ORD-' . strtoupper(Str::random(10));

        // Create transaction parameters for Midtrans
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $totalPayment
        ];

        // Customer details
        $customerDetails = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? ''
        ];

        // Item details
        $itemDetails = [
            [
                'id' => $event->id,
                'price' => $event->harga_tiket,
                'quantity' => $quantity,
                'name' => $event->nama_event,
            ]
        ];

        // Prepare transaction data
        $transactionData = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails
        ];

        try {
            // Get Snap payment page URL
            $snapToken = Snap::getSnapToken($transactionData);

            // Create a new history record with pending status
            // No need for loop since quantity is always 1
            $nomor_tiket = 'TKT-' . strtoupper(Str::random(10));

            History::create([
                'id_user' => $user->id,
                'id_event' => $event->id,
                'nama_event' => $event->nama_event,
                'nomor_tiket' => $nomor_tiket,
                'total_pembayaran' => $event->harga_tiket,
                'status_pembayaran' => 'pending',
                'metode_pembayaran' => 'midtrans',
                'order_id' => $orderId
            ]);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'redirect_url' => "https://app.sandbox.midtrans.com/snap/v2/vtweb/" . $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle notification from Midtrans
     */
    public function handleNotification(Request $request)
    {
        try {
            // Safely decode the JSON body
            $notificationBody = json_decode($request->getContent(), true);

            // Check if we have valid JSON data
            if (!$notificationBody) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid notification data received'
                ], 400);
            }

            // Safely extract required fields with fallbacks
            $orderId = $notificationBody['order_id'] ?? null;
            $transactionStatus = $notificationBody['transaction_status'] ?? 'pending';
            $fraudStatus = $notificationBody['fraud_status'] ?? null;
            $paymentType = $notificationBody['payment_type'] ?? 'unknown';

            // Ensure we have an order ID
            if (!$orderId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No order ID in notification data'
                ], 400);
            }

            $status = 'pending';

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                $status = 'success';
            } else if (
                $transactionStatus == 'cancel' ||
                $transactionStatus == 'deny' ||
                $transactionStatus == 'expire'
            ) {
                $status = 'failed';
            } else if ($transactionStatus == 'pending') {
                $status = 'pending';
            }

            // Update all histories with matching order_id
            $updated = History::where('order_id', $orderId)->update([
                'status_pembayaran' => $status,
                'metode_pembayaran' => $paymentType,
                'tgl_pembayaran' => now()
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error processing notification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check payment status for a specific order
     */
    public function checkPaymentStatus($orderId)
    {
        $history = History::where('order_id', $orderId)->first();

        if (!$history) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'order_id' => $orderId,
                'payment_status' => $history->status_pembayaran
            ]
        ]);
    }

    /**
     * Get user tickets for successful payments
     */
    public function getTickets()
    {
        $user = Auth::user();
        $tickets = History::where('id_user', $user->id)
            ->where('status_pembayaran', 'success')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $tickets
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        // Check if this history belongs to the authenticated user
        if (Auth::id() !== $history->id_user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $history
        ]);
    }

    /**
     * Check payment status for a specific order by querying Midtrans API
     */
    public function forceCheckPaymentStatus($orderId)
    {
        try {
            // Get status from Midtrans API
            $status = \Midtrans\Transaction::status($orderId);

            // Process the status response
            $transactionStatus = $status->transaction_status ?? 'pending';
            $fraudStatus = $status->fraud_status ?? null;
            $paymentType = $status->payment_type ?? 'unknown';

            $dbStatus = 'pending';

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $dbStatus = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                $dbStatus = 'success';
            } else if (
                $transactionStatus == 'cancel' ||
                $transactionStatus == 'deny' ||
                $transactionStatus == 'expire'
            ) {
                $dbStatus = 'failed';
            } else if ($transactionStatus == 'pending') {
                $dbStatus = 'pending';
            }

            // Update history record
            $updated = History::where('order_id', $orderId)->update([
                'status_pembayaran' => $dbStatus,
                'metode_pembayaran' => $paymentType,
                'tgl_pembayaran' => $dbStatus == 'success' ? now() : null
            ]);

            $history = History::where('order_id', $orderId)->first();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'order_id' => $orderId,
                    'payment_status' => $history->status_pembayaran,
                    'midtrans_status' => $transactionStatus,
                    'updated' => (bool) $updated
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error checking payment status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for API
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHistoryRequest $request)
    {
        // Not needed, we use initiatePayment
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        // Not needed for API
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHistoryRequest $request, History $history)
    {
        // Not needed, payment updates come from Midtrans
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        // Not implemented - payment history should be preserved
    }
}
