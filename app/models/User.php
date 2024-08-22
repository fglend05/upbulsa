<?php

class User
{
    use Model;

    protected $table = 'user'; // Assuming your user table is named 'users'

    /**
     * Verify the user credentials.
     *
     * @param string $email
     * @param string $password
     * @return array|bool
     */
    public function verifyCredentials($email, $password)
    {
        // Fetch the user with the provided email
        $user = $this->first(['email' => $email]);

        // Check if user exists and the password matches
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        // Return false if the credentials are invalid
        return false;
    }
}
