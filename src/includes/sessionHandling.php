<?php
session_start();

if(!empty($_SESSION['username'])){

}else{
    header("Location: ../admin/login.php");
}
?>
