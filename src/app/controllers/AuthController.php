<?php

use Library\App\Constants\Services as AppServices;

/**
 * @resource("User")
 */
class AuthController extends \App\Mvc\Controller
{
    /**
     * @title("Authenticate")
     * @description("Authenticate user")
     * @headers({
     *      "Authorization": "Basic sd9u19221934y="
     * })
     * @requestExample("POST /users/authenticate")
     * @response("Data object or Error object")
     */
    public function authenticate()
    {


        $username = $this->request->getUsername();
        $password = $this->request->getPassword();

        $session = $this->authManager->loginWithUsernamePassword(\App\Auth\UsernameAccountType::NAME, $username, $password);
        $response = [
            'token' => $session->getToken(),
            'expires' => $session->getExpirationTime()
        ];

        return $this->respondArray($response, 'data');
    }

}
