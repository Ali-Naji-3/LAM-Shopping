<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing transactions
        Transaction::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get users and orders
        $users = User::where('u_type', 'USR')->get();
        $orders = Order::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please seed users first.');
            return;
        }

        $transactionData = [];
        $paymentMethods = [
            'Credit Card', 'Debit Card', 'PayPal', 'Stripe', 'Square', 
            'Apple Pay', 'Google Pay', 'Bank Transfer', 'Cash', 'Wallet'
        ];
        $paymentModes = ['online', 'cash', 'wallet', 'bank_transfer'];
        $statuses = ['pending', 'completed', 'failed', 'refunded'];

        // Create transactions for existing orders
        foreach ($orders as $order) {
            $user = $users->random();
            $status = $this->getRealisticStatus();
            $paymentMode = $this->getRealisticPaymentMode();
            $paymentMethod = $this->getPaymentMethodForMode($paymentMode, $paymentMethods);

            $transactionData[] = [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'transaction_id' => $this->generateTransactionId(),
                'amount' => $order->total_amount,
                'currency' => 'USD',
                'payment_method' => $paymentMethod,
                'payment_mode' => $paymentMode,
                'status' => $status,
                'gateway_response' => $this->generateGatewayResponse($status, $paymentMethod),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        }

        // Create additional standalone transactions
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $status = $this->getRealisticStatus();
            $paymentMode = $this->getRealisticPaymentMode();
            $paymentMethod = $this->getPaymentMethodForMode($paymentMode, $paymentMethods);
            $amount = $this->generateRealisticAmount();

            $transactionData[] = [
                'user_id' => $user->id,
                'order_id' => $orders->isNotEmpty() && rand(0, 1) ? $orders->random()->id : null,
                'transaction_id' => $this->generateTransactionId(),
                'amount' => $amount,
                'currency' => rand(0, 10) == 0 ? ['EUR', 'GBP', 'CAD'][rand(0, 2)] : 'USD',
                'payment_method' => $paymentMethod,
                'payment_mode' => $paymentMode,
                'status' => $status,
                'gateway_response' => $this->generateGatewayResponse($status, $paymentMethod),
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ];
        }

        // Create some refund transactions
        $completedTransactions = collect($transactionData)->where('status', 'completed')->take(5);
        foreach ($completedTransactions as $transaction) {
            $refundAmount = $transaction['amount'] * (rand(50, 100) / 100); // 50-100% refund
            
            $transactionData[] = [
                'user_id' => $transaction['user_id'],
                'order_id' => $transaction['order_id'],
                'transaction_id' => $this->generateTransactionId(),
                'amount' => -$refundAmount,
                'currency' => $transaction['currency'],
                'payment_method' => $transaction['payment_method'],
                'payment_mode' => $transaction['payment_mode'],
                'status' => 'completed',
                'gateway_response' => json_encode([
                    'refund_for' => $transaction['transaction_id'],
                    'refund_reason' => $this->getRefundReason(),
                    'refund_processed_at' => now()->toISOString(),
                    'processed_by' => 'System Admin',
                ]),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 7)),
            ];
        }

        // Insert transactions in chunks
        $chunks = array_chunk($transactionData, 50);
        foreach ($chunks as $chunk) {
            Transaction::insert($chunk);
        }

        $this->command->info('Created ' . count($transactionData) . ' transactions successfully!');
    }

    /**
     * Generate realistic transaction status
     */
    private function getRealisticStatus(): string
    {
        $random = rand(1, 100);
        
        if ($random <= 75) return 'completed';      // 75% completed
        if ($random <= 85) return 'pending';       // 10% pending
        if ($random <= 95) return 'failed';        // 10% failed
        return 'refunded';                          // 5% refunded
    }

    /**
     * Generate realistic payment mode
     */
    private function getRealisticPaymentMode(): string
    {
        $random = rand(1, 100);
        
        if ($random <= 70) return 'online';        // 70% online
        if ($random <= 85) return 'cash';          // 15% cash
        if ($random <= 95) return 'wallet';        // 10% wallet
        return 'bank_transfer';                     // 5% bank transfer
    }

    /**
     * Get payment method based on mode
     */
    private function getPaymentMethodForMode(string $mode, array $methods): string
    {
        return match($mode) {
            'online' => ['Credit Card', 'Debit Card', 'PayPal', 'Stripe', 'Apple Pay', 'Google Pay'][rand(0, 5)],
            'cash' => 'Cash',
            'wallet' => 'Wallet',
            'bank_transfer' => 'Bank Transfer',
            default => $methods[rand(0, count($methods) - 1)]
        };
    }

    /**
     * Generate realistic transaction amount
     */
    private function generateRealisticAmount(): float
    {
        $random = rand(1, 100);
        
        if ($random <= 40) return rand(10, 50);     // 40% small transactions ($10-50)
        if ($random <= 70) return rand(51, 150);   // 30% medium transactions ($51-150)
        if ($random <= 90) return rand(151, 500);  // 20% large transactions ($151-500)
        return rand(501, 2000);                     // 10% very large transactions ($501-2000)
    }

    /**
     * Generate unique transaction ID
     */
    private function generateTransactionId(): string
    {
        do {
            $transactionId = 'TXN' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        } while (Transaction::where('transaction_id', $transactionId)->exists());

        return $transactionId;
    }

    /**
     * Generate gateway response based on status
     */
    private function generateGatewayResponse(string $status, string $paymentMethod): string
    {
        $response = [
            'payment_method' => $paymentMethod,
            'processed_at' => now()->toISOString(),
            'gateway' => $this->getGatewayForMethod($paymentMethod),
        ];

        switch ($status) {
            case 'completed':
                $response['authorization_code'] = strtoupper(substr(uniqid(), -8));
                $response['reference_number'] = 'REF' . rand(100000, 999999);
                $response['message'] = 'Payment completed successfully';
                break;
                
            case 'pending':
                $response['message'] = 'Payment is being processed';
                $response['estimated_completion'] = now()->addMinutes(rand(5, 30))->toISOString();
                break;
                
            case 'failed':
                $response['error_code'] = 'ERR' . rand(1000, 9999);
                $response['message'] = $this->getFailureReason();
                break;
                
            case 'refunded':
                $response['refund_id'] = 'RFD' . rand(100000, 999999);
                $response['message'] = 'Payment refunded successfully';
                $response['refund_reason'] = $this->getRefundReason();
                break;
        }

        return json_encode($response);
    }

    /**
     * Get gateway for payment method
     */
    private function getGatewayForMethod(string $method): string
    {
        return match($method) {
            'Credit Card', 'Debit Card' => ['Stripe', 'Square', 'Authorize.Net'][rand(0, 2)],
            'PayPal' => 'PayPal',
            'Apple Pay' => 'Apple Pay',
            'Google Pay' => 'Google Pay',
            'Bank Transfer' => 'ACH',
            'Cash' => 'POS System',
            'Wallet' => 'Digital Wallet',
            default => 'Generic Gateway'
        };
    }

    /**
     * Get realistic failure reason
     */
    private function getFailureReason(): string
    {
        $reasons = [
            'Insufficient funds',
            'Card declined',
            'Invalid card number',
            'Expired card',
            'Network timeout',
            'Gateway error',
            'Security check failed',
            'Daily limit exceeded'
        ];

        return $reasons[rand(0, count($reasons) - 1)];
    }

    /**
     * Get realistic refund reason
     */
    private function getRefundReason(): string
    {
        $reasons = [
            'Customer request',
            'Product defect',
            'Order cancellation',
            'Duplicate payment',
            'Service issue',
            'Quality complaint',
            'Shipping delay',
            'Wrong item shipped'
        ];

        return $reasons[rand(0, count($reasons) - 1)];
    }
}
