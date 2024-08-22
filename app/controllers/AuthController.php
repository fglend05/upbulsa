<?php

// namespace App\Contollers;

class AuthController
{
    public function login()
    {
        header('Content-Type: application/json');
        error_log("login method called");

        // Get the JSON data from the request body
        $data = json_decode(file_get_contents('php://input'), true);
        error_log("Received JSON data: " . print_r($data, true));

        if (!$data || !isset($data['email'], $data['password'])) {
            error_log("Missing email or password in request");
            echo json_encode(['error' => 'Missing email or password']);
            return;
        }

        $email = $data['email'];
        $password = $data['password'];

        $userModel = new User();

        try {
            // Verify user credentials
            $user = $userModel->verifyCredentials($email, $password);

            if ($user) {
                // User authenticated, create session or token here
                $_SESSION['user_id'] = $user['id']; // Example of creating a session
                echo json_encode(['success' => 'User logged in successfully']);
            } else {
                echo json_encode(['error' => 'Invalid email or password']);
            }
        } catch (Exception $e) {
            error_log("Exception caught during login: " . $e->getMessage());
            echo json_encode(['error' => 'An error occurred during login']);
        }
    }

    public function logout()
    {
        // Destroy user session
        session_start();
        session_unset();
        session_destroy();

        echo json_encode(['success' => 'User logged out successfully']);
    }
}
