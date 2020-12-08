<?php
include("constructor.php");
include("login.php");
$db= new mysqli("p:localhost","root","", "bighitent", 3306);
$accounts = [];

$query = "SELECT username, password FROM useradmin";
$result = $db->query($query);
   
while($row = $result->fetch_assoc()) {
    $accounts[] = new Accounts($row['username'], $row['password']);
}
if(isset($_POST['buttonLogin'])){
    $username = $_POST['user'];
    $password = $_POST['Password'];
    
    foreach($accounts as $cred){
        $credUser = $cred->getUser();
        $credPass = $cred->getPassword();

        if($username == $credUser && $password == $credPass){
            session_start();
            header("Location: src/includes/navbanner.php");
            $_SESSION['username'] = $username;
        }
    }
    echo "<script>alert('Username or Password incorrect!')</script>";
    echo "<script>location.href='login.php'</script>";

}
    

?>