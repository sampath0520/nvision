<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Jobs\ProcessOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderService
{

    // Create order
    /**
     * @param array $data
     * @return array
     */

    public function createOrder($data)
    {
        try {
            //start the transaction
            DB::beginTransaction();

            // Generate a random process ID
            $process_id = rand(1, 10);

            // Create a new Order instance
            $order = Order::create([
                'customer_name' => $data['customer_name'],
                'order_value' => $data['order_value'],
                'order_date' => now(),
                'order_status' => 'Processing',
                'process_id' => $process_id
            ]);

            // Dispatch the order processing job
            ProcessOrder::dispatch($order, $process_id);

            // Commit the transaction
            DB::commit();

            return [
                'status' => true,
                'message' => 'Order created successfully',
                'data' => $order
            ];
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            return [
                'status' => false,
                'message' => 'Order creation failed'
            ];
        }
    }
}
