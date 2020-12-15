<?php
/**
 * Checks if username exists before session starts
 *
 * @author Hudson Kit Natividad
 */

// Contains the checking if a username exists before the session starts
session_start();
if(!empty($_SESSION['username'])){

} else {
    header("Location: ../admin/login.php");
}
