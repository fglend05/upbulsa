<?php

class Cart
{
    use Model;

    protected $table = 'cart';

    public function addCart($userId)
    {
        // Add a new cart for a user
        $data = [
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $this->insert($data);
    }

    public function getCartByUserId($userId)
    {
        // Get the active cart for a user
        $data = ['user_id' => $userId];
        return $this->first($data, [], 'created_at', 'desc');
    }
}
