<?php
/**
 * A class that gets the account credentials of the admin
 *
 * @author Hudson Kit Natividad
 */
class Account {

    private $username;
    private $password;

    public function __construct($user, $pass){
        $this->username = $user;
        $this->password = $pass;
    }

    public function getUser(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }
}
