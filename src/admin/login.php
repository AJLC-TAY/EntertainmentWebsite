<!--
A page that allows the admin to login to the administration page of bighitmusic

@author Hudson Kit Natividad
-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="style2.css">
      <title>Login Page | Big Hit Music</title>
  </head>
  <body>
    <div id="loginForm" align="center">
    <img src="../images/logo site.png" alt="logo">
    <p><b> Administrative Login </b></p>
      <form method="POST" action="loginAuthentication.php">
        <p>
            <b><label> Username: </label></b>
          <input type="text" id="user" name="user" />
        </p>
        <p>
            <b><label>Password:</label></b>
          <input type="password" id="Password" name="Password" />
        </p>
        <p id="btn">
            <button type="login" id="buttonLogin" name="buttonLogin"> LOGIN </button>
            <br>
        </p>
        </form>
      </div>
 <?php include '../includes/footer.php'?>
