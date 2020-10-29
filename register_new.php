<?php
require_once('funcs.php');
  

  //create short variable names
  $email=$_POST['email'];
  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $passwd=$_POST['passwd'];
  $passwd2=$_POST['passwd2'];
  //$sub=$_POST['subs'];
  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  try   {
    // check forms filled in

    if (!filled_out($_POST)) {
      throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }

    // email address not valid
    if (!valid_email($email)) {
      throw new Exception('That is not a valid email address.  Please go back and try again.');
    }

    // passwords not the same
    if ($passwd != $passwd2) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if ((strlen($passwd) < 6) || (strlen($passwd) > 50)) {
      throw new Exception('Your password must be between 6 and 50 characters. Please go back and try again.');
    }

    // attempt to register
    // this function can also throw an exception
    register($firstname, $lastname, $email, $passwd);
    // register session variable
    $_SESSION['valid_user'] = $email;

    // provide link to members page
    
    echo 'Your registration was successful.  Go to the members page to view amazing exclusive content!';
    echo 'Log in here';
    do_html_url('index.php', 'Login');
    

   // end page
   
  }
  catch (Exception $e) {
     
     echo $e->getMessage();
     exit;
  }
?>


