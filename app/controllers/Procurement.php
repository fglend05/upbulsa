<?php

class Procurement extends Controller
{

    //For Carts
    public function addcart(){
        header('Content-Type: application/json');

        // Log the beginning of the method execution
        error_log("addcart method called");

        // Get the JSON data from the request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Log the received JSON data
        error_log("Received JSON data: " . print_r($data, true));

        if (!$data) {
            error_log("Invalid JSON data");
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        // Normalize single item to an array of items
        if (isset($data['itmdsc'])) {
            $data = [$data];
        } elseif (!is_array($data)) {
            error_log("Invalid JSON data format");
            echo json_encode(['error' => 'Invalid JSON data format']);
            return;
        }

        $cartModel = new ProcureItem();
        $errors = [];

        foreach ($data as $item) {
            // Validate the data
            if (!isset($item['userid']) || !isset($item['itmdsc']) || !isset($item['dlvrdby']) || !isset($item['unit']) || !isset($item['qty']) || !isset($item['unitprice']) || !isset($item['cost']) || !isset($item['totalprice'])) {
                $errors[] = ['error' => 'Missing required fields in item: ' . json_encode($item)];
                continue;
            }

            // Insert the data into the cart
            try {
                $result = $cartModel->addToCart($item);
                if (!$result) {
                    $errors[] = ['error' => 'Failed to add item to cart', 'item' => $item];
                }
            } catch (Exception $e) {
                $errors[] = ['error' => 'Exception caught while adding to cart: ' . $e->getMessage(), 'item' => $item];
            }
        }

        if (empty($errors)) {
            echo json_encode(['success' => 'All items added to cart']);
        } else {
            echo json_encode(['errors' => $errors]);
        }
    }

    public function getCart(){
        
            header('Content-Type: application/json');
    
            // Log the beginning of the method execution
            error_log("getCartItems method called");    
    
            $cartModel = new ProcureItem();
            try {
                $cartItems = $cartModel->getAllCartItems();
    
                // Log the result of the query
                error_log("Fetched cart items: " . print_r($cartItems, true));
    
                echo json_encode($cartItems);
            } catch (Exception $e) {
                error_log("Exception caught while fetching cart items: " . $e->getMessage());
                echo json_encode(['error' => 'An error occurred while fetching cart items']);
            }
        
    }

    public function checkOut(){
        
    }

    //For Checkout page
    public function getCheckout(){

        header('Content-Type: application/json');

        // Log the beginning of the method execution
        error_log("getCartItems method called");

        $cartModel = new CheckoutItem();
        try {
            $cartItems = $cartModel->getAllCheckoutItem();

            // Log the result of the query
            error_log("Fetched cart items: " . print_r($cartItems, true));

            echo json_encode($cartItems);
        } catch (Exception $e) {
            error_log("Exception caught while fetching cart items: " . $e->getMessage());
            echo json_encode(['error' => 'An error occurred while fetching cart items']);
        }
    
    }

    //Product Catalog
    public function addCatalog(){
        header('Content-Type: application/json');

        // Log the beginning of the method execution
        error_log("addcart method called");

        // Get the JSON data from the request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Log the received JSON data
        error_log("Received JSON data: " . print_r($data, true));

        if (!$data) {
            error_log("Invalid JSON data");
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        // Normalize single item to an array of items
        if (isset($data['desciption'])) {
            $data = [$data];
        } elseif (!is_array($data)) {
            error_log("Invalid JSON data format");
            echo json_encode(['error' => 'Invalid JSON data format']);
            return;
        }

        $cartModel = new ProductCatalog();
        $errors = [];

        foreach ($data as $item) {
            // Validate the data
            if (!isset($item['description'])) {
                $errors[] = ['error' => 'Missing required fields in item: ' . json_encode($item)];
                continue;
            }

            // Insert the data into the cart
            try {
                $result = $cartModel->save($item);
                if (!$result) {
                    $errors[] = ['error' => 'Failed to add item to cart', 'item' => $item];
                }
            } catch (Exception $e) {
                $errors[] = ['error' => 'Exception caught while adding to cart: ' . $e->getMessage(), 'item' => $item];
            }
        }

        if (empty($errors)) {
            echo json_encode(['success' => 'All items added to cart']);
        } else {
            echo json_encode(['errors' => $errors]);
        }
    }

}
