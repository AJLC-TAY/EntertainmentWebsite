<?php
class Accounts{

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