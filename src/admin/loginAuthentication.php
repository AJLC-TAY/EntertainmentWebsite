<?php
include("constructor.php");
include("login.php");
include ("../includes/database.php");
$accounts = [];

$query = "SELECT username, password FROM useradmin";
$result = $database->query($query);
   
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
            header("Location: index.php");
            $_SESSION['username'] = $username;
        }
    }
    echo "<script>alert('Username or Password incorrect!')</script>";
    echo "<script>location.href='login.php'</script>";

}
    

?>