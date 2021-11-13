<?

namespace App\Repositories\Models;

use Carbon\Carbon;
use App\Models\WalletTransaction;
use App\Repositories\ApplicationRepository;
use App\Repositories\Models\OrderRepository;
use App\Repositories\Models\WalletRepository;
use App\Repositories\Models\OrderItemRepository;
use Illuminate\Database\Eloquent\Builder;

class WalletTransactionRepository implements ApplicationRepository
{
    public function builder(): Builder
    {
        return WalletTransaction::query();
    }

    public function creditUser($user_id, $amount)
    {  
        $wallet = $this->walletRepository()->findWallet($user_id);
        $wallet->balance = $wallet->balance + $amount;
        $wallet->save();
        return $wallet;
    }

    public function debitUser($user_id, $amount)
    {  
        $wallet = $this->walletRepository()->findWallet($user_id);
        $wallet->balance = $wallet->balance - $amount;
        $wallet->save();
        return $wallet;
    }

    public function creditVendors($order, $orderItemDetails, $bid, $status, $transaction_type)
    {
        $quantityPurchased = $orderItemDetails->quantity;
        $item_total = $bid->price * $quantityPurchased;

        $vendorBalance = $this->creditUser($bid->vendor_id, $item_total);

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

    public function createTransaction($order, $vendorBalance, $item_total, $orderItemDetails, $status, $transaction_type)
    {
        WalletTransaction::create([
            'receipt_number' => $order->receipt_number,
            'title' => $order->title,
            'user_id' => $vendorBalance->user->id,
            'details' => $order->details,
            'amount' => $item_total,
            'amount_paid' => $item_total,
            'category' => $order->transaction_type,
            'transaction_type' => $transaction_type,
            'status' => $status,
            'remarks' => $status,
            'balance' => $vendorBalance->balance,
            'walletable_id' => $orderItemDetails->itemable_id,
            'walletable_type' => $orderItemDetails->itemable_type,
        ]);
    }

    protected function orderItemRepository(): OrderItemRepository
    {
        return new OrderItemRepository;
    }

    protected function orderRepository(): OrderRepository
    {
        return new OrderRepository;
    }

    protected function walletRepository(): WalletRepository
    {
        return new WalletRepository;
    }
}