<?php

// include function files for this application
require_once('funcs.php');
session_start();

//create short variable names
if (!isset($_POST['email']))  {
  //if not isset -> set with dummy value 
  $_POST['email'] = " "; 
}
$email = $_POST['email'];
if (!isset($_POST['passwd']))  {
  //if not isset -> set with dummy value 
  $_POST['passwd'] = " "; 
}
$passwd = $_POST['passwd'];

if ($email && $passwd) {
// they have just tried logging in
  try  {
    login($email, $passwd);
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $email;
  }
  catch(Exception $e)  {
    // unsuccessful login
    echo 'You could not be logged in.<br>
          You must be logged in to view this page.';
    do_html_url('index.php', 'Login');
    
    exit;
  }
}


check_valid_user();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to the members page!!!</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    
    <body>
        <h1>Welcome to the members page! Here you can:</h1>
        <p>Change your password! <a href="change_passwd_form.php">Just click here!</a></p>
        <p>Log out by clicking this button!</p> 
        <button><a href="logout.php">Logout</a></button>
        <p>..And nothing else for the moment.</p>
        <p>But, while we're working on bringing you more exclusive content, have a look at these cute puppies!</p><br>
        <img class="center" src="puppies.jpeg" alt="Two cute puppies"> 
    </body>
</html>


