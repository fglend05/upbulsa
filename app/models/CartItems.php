<?php

class CartItems
{
    use Model;

    protected $table = 'products';

/**
     * Add an item to the cart.
     *
     * @param int $cartId
     * @param array $itemData
     * @return bool
     */
    public function addItem($cartId, $itemData)
    {
        // Add an item to the cart
        $itemData['cart_id'] = $cartId;
        return $this->insert($itemData);
    }

    /**
     * Get all items in a cart by cart ID.
     *
     * @param int $cartId
     * @return array
     */
    public function getItemsByCartId($cartId)
    {
        // Get all items in a cart
        return $this->where(['cart_id' => $cartId]);
    }
}
