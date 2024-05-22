<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $process_id;

    public function __construct(Order $order, $process_id)
    {
        $this->order = $order;
        $this->process_id = $process_id;
    }

    public function handle()
    {
        try {
            $api_url = 'https://wibip.free.beeceptor.com/order';

            $payload = [
                'Order_ID' => $this->order->id,
                'Customer_Name' => $this->order->customer_name,
                'Order_Value' => $this->order->order_value,
                'Order_Date' => $this->order->created_at->toDateTimeString(),
                'Order_Status' => 'Processing',
                'Process_ID' => $this->process_id
            ];

            Http::post($api_url, $payload);
        } catch (\Exception $e) {
            // Log the error
            Log::error($e->getMessage());
        }
    }
}
