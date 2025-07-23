<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $vendorId;

    public function __construct(Order $order, $vendorId)
    {
        $this->order = $order;
        $this->vendorId = $vendorId;
    }

    public function broadcastOn()
    {
        return new Channel('vendor.' . $this->vendorId);
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'total_price' => $this->order->total_price,
            'updated_at' => $this->order->updated_at->toDateString(),
        ];
    }
}