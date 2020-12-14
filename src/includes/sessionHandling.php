<?php

// Contains the checking if a username exists before the session starts
session_start();
if(!empty($_SESSION['username'])){

} else {
    header("Location: ../admin/login.php");
}