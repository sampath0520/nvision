<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\ProcessOrder;
use Illuminate\Support\Facades\DB;
use App\Services\OrderService;

class OrderController extends Controller
{

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * create order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        // Validate
        $validated = $request->validated();

        try {

            $createOrder = $this->orderService->createOrder($validated);
            if ($createOrder['status']) {
                return ResponseHelper::success($createOrder['message'], $createOrder['data']);
            } else {
                return ResponseHelper::error($createOrder['message']);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
