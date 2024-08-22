<?php

class Order
{
    use Model;

    protected $table = 'checkouttable';

    public function createOrder($userId, $totalAmount)
    {
        // Create a new order
        $orderData = [
            'user_id' => $userId,
            'order_date' => date('Y-m-d H:i:s'),
            'order_status' => 'pending',
            'total_amount' => $totalAmount
        ];

        return $this->insert($orderData);

    
    }

    public function addItemToOrder($orderId, $itemData)
    {
        // Add items to the order
        $itemData['order_id'] = $orderId;
        return $this->insert($itemData);
    }

    public function getAll(){
        $query = "SELECT * FROM $this->table";
        return $this->query($query);
    }

    public function getItemsByOrderId(){

    }
}
