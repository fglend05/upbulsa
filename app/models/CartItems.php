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
        // Ensure user_id is set
        if (!isset($itemData['user_id'])) {
            error_log("user_id is missing in item data: " . print_r($itemData, true));
            return false; // Or handle this case as needed
        }

        // Add the cart_id to the item data
        $itemData['cart_id'] = $cartId;

        // Insert the item into the database
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
