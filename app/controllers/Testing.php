<?php

class Testing extends Controller
{
    // For Carts
    public function addcart(){
        header('Content-Type: application/json');
        error_log("addcart method called");
    
        $data = json_decode(file_get_contents('php://input'), true);
        error_log("Received JSON data: " . print_r($data, true));
    
        if (!$data) {
            error_log("Invalid JSON data");
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
    
        // Normalize single item to an array of items
        $data = isset($data['itmdsc']) ? [$data] : $data;
    
        $cartModel = new Cart();
        $cartItemModel = new CartItems();
        $errors = [];
    
        foreach ($data as $item) {
            if ($this->validateCartItem($item)) {
                try {
                    // Add a new cart for the user if not existing
                    $cart = $cartModel->getCartByUserId($item['userid']);
                    if (!$cart) {
                        $cartId = $cartModel->addCart($item['userid']);
                    } else {
                        // Assuming `getCartByUserId` returns an object
                        $cartId = $cart->id;
                    }
    
                    // Add item to the cart
                    $result = $cartItemModel->addItem($cartId, $item);
                    if (!$result) {
                        $errors[] = ['error' => 'Failed to add item to cart', 'item' => $item];
                    }
                } catch (Exception $e) {
                    $errors[] = ['error' => 'Exception caught while adding to cart: ' . $e->getMessage(), 'item' => $item];
                }
            } else {
                $errors[] = ['error' => 'Missing required fields in item: ' . json_encode($item)];
            }
        }
    
        echo json_encode(empty($errors) ? ['success' => 'All items added to cart'] : ['errors' => $errors]);
    }
    
    // public function test(){
    //     try {
    //         $cartItemsModel = new CartItems();
        
    //         $cartId = 4; // Assume this is your existing cart ID
    //         $itemData = [
    //             'user_id' => 1,
    //             'itmdsc' => 'phoneee',
    //             'dlvrdby' => '2024/05/04',
    //             'dlvrdto' => 'Los Banos',
    //             'unit' => 'pcs',
    //             'qty' => 1,
    //             'unitprice' => 50000,
    //             'cost' => 50000,
    //             'totalprice' => 50000
    //         ];
        
    //         $result = $cartItemsModel->addItem($cartId, $itemData);
        
    //         if (!$result) {
    //             echo "Item successfully added to cart!";
    //         } else {
    //             echo "Failed to add item to cart.";
    //         }
    //     } catch (Exception $e) {
    //         echo "Exception caught while adding to cart: " . $e->getMessage();
    //     }
        
    // }
    

    public function getCart()
    {
        header('Content-Type: application/json');
        error_log("getCart method called");
    
        // Assuming the user ID is passed via a query parameter or from session
        if (isset($_GET['user_id'])) {
            $userId = $_GET['user_id'];
        } else {
            // Handle the case where the user ID is not provided
            error_log("User ID not provided");
            echo json_encode(['error' => 'User ID not provided']);
            return;
        }
    
        $cartModel = new Cart();
        $cartItemModel = new CartItems();
        
        try {
            $cartItems = [];
            $cart = $cartModel->getCartByUserId($userId); // Fetch the user's cart
    
            if ($cart) {
                // Fetch items for the cart
                $items = $cartItemModel->getItemsByCartId($cart['id']);
                $cartItems[$cart['id']] = $items;
            } else {
                error_log("No cart found for user ID: " . $userId);
                echo json_encode(['error' => 'No cart found for this user']);
                return;
            }
    
            error_log("Fetched cart items: " . print_r($cartItems, true));
            echo json_encode($cartItems);
        } catch (Exception $e) {
            error_log("Exception caught while fetching cart items: " . $e->getMessage());
            echo json_encode(['error' => 'An error occurred while fetching cart items']);
        }
    }
    

    public function checkOut()
    {
        // Implement your checkout logic here
        // For example, you might create an order and move items from cart to order
    }

    // For Checkout page
    public function getCheckout()
    {
        header('Content-Type: application/json');
        error_log("getCheckoutItems method called");

        $orderModel = new Order();
        try {
            $orders = $orderModel->getAll(); // Implement getAll() in Order model if needed
            $checkoutItems = [];

            foreach ($orders as $order) {
                $items = $orderModel->getItemsByOrderId($order['id']); // Assuming getItemsByOrderId exists
                $checkoutItems[$order['id']] = $items;
            }

            error_log("Fetched checkout items: " . print_r($checkoutItems, true));
            echo json_encode($checkoutItems);
        } catch (Exception $e) {
            error_log("Exception caught while fetching checkout items: " . $e->getMessage());
            echo json_encode(['error' => 'An error occurred while fetching checkout items']);
        }
    }

    // Product Catalog
    public function addCatalog()
    {
        header('Content-Type: application/json');
        error_log("addCatalog method called");
    
        // Get the JSON data from the request body
        $data = json_decode(file_get_contents('php://input'), true);
        error_log("Received JSON data: " . print_r($data, true));
    
        // Check if the JSON data is valid
        if (!$data) {
            error_log("Invalid JSON data");
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
    
        // If the data contains a single item, normalize it into an array
        $data = isset($data['description']) ? [$data] : $data;
    
        $catalogModel = new ProductCatalog(); // Instantiate the ProductCatalog model
        $errors = [];
    
        foreach ($data as $item) {
            if (isset($item['description'])) {
                try {
                    // Set the description in the model
                    $catalogModel->description = $item['description'];
                    
                    // Save the item to the catalog
                    if (!$catalogModel->save($item)) {
                        $errors[] = ['error' => 'Failed to add item to catalog', 'item' => $item];
                    }
                } catch (Exception $e) {
                    $errors[] = ['error' => 'Exception caught while adding to catalog: ' . $e->getMessage(), 'item' => $item];
                }
            } else {
                $errors[] = ['error' => 'Missing required fields in item: ' . json_encode($item)];
            }
        }
    
        // Return the appropriate response based on the outcome
        if (empty($errors)) {
            echo json_encode(['success' => 'All items added to catalog']);
        } else {
            echo json_encode(['errors' => $errors]);
        }
    }
    

    private function validateCartItem($item)
    {
        $requiredFields = ["user_id", 'itmdsc', 'dlvrdby', 'dlvrdto', 'unit', 'qty', 'unitprice', 'cost', 'totalprice'];
    
        foreach ($requiredFields as $field) {
            if (!isset($item[$field]) || empty($item[$field])) {
                return false; // Return false if any required field is missing or empty
            }
        }
    
        return true; // Return true if all required fields are present and not empty
    }
    
}
