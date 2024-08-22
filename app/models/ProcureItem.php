<?php

class ProcureItem
{
    use Model;

    protected $table = 'products';

    // protected $allowedColumns = [
    //     'user_id',
    //     'product_id',
    //     'quantity',
    //     'date_added'
    // ];

    public function addToCart($data)
    {
        // Validate and insert the data into the cart table
        return $this->insert($data);    
    }

    public function getCartItems($userId)
    {
        return $this->where(['user_id' => $userId]);
    }

    public function getAllCartItems()
    {
        $query = "SELECT * FROM $this->table";
        return $this->query($query);
    }
}
