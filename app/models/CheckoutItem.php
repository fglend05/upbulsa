<?php

class CheckoutItem
{
    use Model;

    protected $table = 'checkout';

    // protected $allowedColumns = [
    //     'user_id',
    //     'product_id',
    //     'quantity',
    //     'date_added'
    // ];

    public function addCheckout($userId, $totalAmount)
    {
              // Create a new order
              $data = [
                'user_id' => $userId,
                'order_date' => date('Y-m-d H:i:s'),
                'order_status' => 'pending',
                'total_amount' => $totalAmount
            ];
    
        return $this->insert($data);
    
                
    }

    public function addItemToOrder($orderId, $itemData)
    {
        // Add items to the order
        $data = [
            'order_id' => $orderId,
            'itmdsc' => $itemData['itmdsc'],
            'dlvrdby' => $itemData['dlvrdby'],
            'dlvrdto' => $itemData['dlvrdto'],
            'unit' => $itemData['unit'],
            'qty' => $itemData['qty'],
            'unitprice' => $itemData['unitprice'],
            'cost' => $itemData['cost'],
            'totalprice' => $itemData['totalprice'],
        ];

        return $this->insert($data);
    }

    public function getCheckoutItem($userId)
    {
        return $this->where(['user_id' => $userId]);
    }

    public function getAllCheckoutItem()
    {
        $query = "SELECT * FROM $this->table";
        return $this->query($query);
    }
}
