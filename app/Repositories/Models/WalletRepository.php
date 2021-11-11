<?

namespace App\Repositories\Models;

use Carbon\Carbon;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Repositories\ApplicationRepository;

class WalletRepository implements ApplicationRepository
{
    public function creditVendors($order, $orderItemDetails, $bid, $status, $transaction_type)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $vendorBalance = Wallet::where('user_id', $bid->vendor_id)->first();
        $item_total = $bid->price * $quantityPurchased;
        $vendorBalance->balance = $vendorBalance->balance + $item_total;
        $vendorBalance->save();

        if($orderItemDetails->itemable_type == 'quotes'){
            $title = 'Receiving '.  $orderItemDetails->itemable_type . ' transaction payment';
            $details = 'Receiving '.  $orderItemDetails->itemable_type . ' transaction payment';
        }

        $newOrder = $vendorBalance->user->orders()->create([
            'title' => $title,
            'details' => $details,
            'receipt_number' => $order->receipt_number,
            'address_id' => $order->address_id,
            'payment_method_id' => $order->payment_method_id,
            'payment_charge_id' => $order->payment_charge_id,
            'subtotal' => $order->subtotal,
            'total' => $order->total,
            'amount_paid' => $order->amount_paid,
            'transaction_type' => 'credit',
            'currency' => 'NGN',
            'payment_reference' => $order->receipt_number,
            'payment_gateway_charge' => 0,
            'payment_message' => $details,
            'payment_status' => 'successful',
            'platform_initiated' => 'inapp',
            'transaction_initiated_date' => Carbon::now(),
            'transaction_initiated_time' => Carbon::now(),
            'date_time_paid' => Carbon::now(),
            'status' => 'paid',
            'service_status' => 'paid',
        ]);

        WalletTransaction::create([
            'receipt_number' => $newOrder->receipt_number,
            'title' => $newOrder->title,
            'user_id' => $vendorBalance->user->id,
            'details' => $newOrder->details,
            'amount' => $item_total,
            'amount_paid' => $item_total,
            'category' => $newOrder->transaction_type,
            'transaction_type' => $transaction_type,
            'status' => $status,
            'remarks' => $status,
            'balance' => $vendorBalance->balance,
            'walletable_id' => $orderItemDetails->itemable_id,
            'walletable_type' => $orderItemDetails->itemable_type,
        ]);
    }
}