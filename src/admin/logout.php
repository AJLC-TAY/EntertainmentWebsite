<?php
/**
 * A page that allows the admin to logout
 *
 * @author Hudson Kit Natividad
 */

// Contains the destroying of the session and returns to the login page
session_start();
$_SESSION['username'] = "";
session_destroy();
header("Location: ../admin/login.php");
?>
