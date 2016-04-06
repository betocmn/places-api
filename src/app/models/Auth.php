<?php

class Auth extends \App\Mvc\Model
{
    public $id;
    public $name;
    public $email;
    public $username;
    public $password;
    public $is_active;

    /**
     *
     * Defines database table to use
     *
     * @return null
     */
    public function getSource()
    {
        return 'auth';
    }

    /**
     *
     * Defines API mapping for column names
     *
     * @return null
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'username' => 'username',
            'password' => 'password',
            'is_active' => 'is_active',
            'updated_at' => 'updated_at',
            'created_at' => 'created_at',
        ];
    }

    /**
     *
     * Defines which columns can be displayed
     *
     * @return null
     */
    public function whitelist()
    {
        return [
            'name',
            'email',
            'username',
            'password',
            'is_active'
        ];
    }
}