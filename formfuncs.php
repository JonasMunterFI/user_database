<?php
function change_password($email, $old_password, $new_password) {
// change password for username/old_password to new_password
// return true or false

  // if the old password is right
  // change their password to new_password and return true
  // else throw an exception
  login($email, $old_password);
  $conn = db_connect();
  $result = $conn->query("update kayttajat
                          set salasana = sha1('".$new_password."')
                          where email = '".$email."'");
  if (!$result) {
    throw new Exception('Password could not be changed.');
  } else {
    return true;  // changed successfully
  }
}
?>

<?php

function check_valid_user() {
// see if somebody is logged in and notify them if not
  if (isset($_SESSION['valid_user']))  {
      echo "Logged in as ".$_SESSION['valid_user'].".<br>";
  } else {
     // they are not logged in
     
     echo 'You are not logged in.<br>';
     do_html_url('index.php', 'Login');
     exit;
  }
}

function display_login_form() {
?>
  <link rel="stylesheet" href="styles.css">
  <p><a>Not a member? Sign up </a><a href="new_user.php">here!</a></p>
  <form method="post" action="members.php">

  <div class="formblock">
    <h2>Members Log In Here</h2>

    <p><label for="email">Enter your email address:</label><br/>
    <input type="email" name="email" id="email" /></p>

    <p><label for="passwd">Password:</label><br/>
    <input type="password" name="passwd" id="passwd" /></p>

    <button type="submit">Log In</button>

    <p><a href="forgot_form.php">Forgot your password?</a></p>
  </div>

 </form>
<?php
}

function display_password_form() {
  // display html change password form
?>
  <link rel="stylesheet" href="styles.css">
   <br>
   <form action="change_passwd.php" method="post">

 <div class="formblock">
    <h2>Change Password</h2>

    <p><label for="old_passwd">Old Password:</label><br/>
    <input type="password" name="old_passwd" id="old_passwd" 
      size="16" maxlength="16" required /></p>

    <p><label for="passwd2">New Password:</label><br/>
    <input type="password" name="new_passwd" id="new_passwd" 
      size="16" maxlength="16" required /></p>

    <p><label for="passwd2">Repeat New Password:</label><br/>
    <input type="password" name="new_passwd2" id="new_passwd2" 
      size="16" maxlength="16" required /></p>


    <button type="submit">Change Password</button>

   </div>
   <br>
<?php
}


function display_reg_form() {
?>
  <link rel="stylesheet" href="styles.css">
 <form method="post" action="register_new.php">

 <div class="formblock">
    <h2>Register Now</h2>

    <p><label for="firstname">First name <br>(max 25 chars):</label><br/>
    <input type="text" name="firstname" id="firstname" 
      size="25" maxlength="25" required /></p>

    <p><label for="lastname">Last name <br>(max 40 chars):</label><br/>
    <input type="text" name="lastname" id="lastname" 
    size="40" maxlength="40" required /></p>

    <p><label for="email">Email Address:</label><br/>
    <input type="email" name="email" id="email" 
      size="30" maxlength="50" required /></p>

    <p><label for="passwd">Password <br>(between 6 and 50 chars):</label><br/>
    <input type="password" name="passwd" id="passwd" 
      size="16" maxlength="16" required /></p>

    <p><label for="passwd2">Confirm Password:</label><br/>
    <input type="password" name="passwd2" id="passwd2" 
      size="16" maxlength="16" required /></p>
    
    <p><label for="subscribe">Do you want to subscribe to our newsletter? </label><br/>
    <input type="checkbox" name="subs" id="subs" value="true"></p>


    <button type="submit">Register</button>

   </div>

  </form>
  <?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
?>
  <br><a href="<?php echo $url;?>"><?php echo $name;?></a><br>
<?php
}

function filled_out($form_vars) {

  // test that each variable has a value
  foreach ($form_vars as $key => $value) {
     if ((!isset($key)) || ($value == '')) {
        return false;
     }
  }
  return true;
}
function register($firstname, $lastname, $email, $password) {
// register new person with db
// return true or error message

  // connect to db
  $conn = db_connect();

  // check if username is unique
  $result = $conn->query("select * from kayttajat where email='".$email."'");
  if (!$result) {
    throw new Exception('Could not execute query');
  }

  if ($result->num_rows>0) {
    throw new Exception('That email is taken - go back and choose another one.');
  }

  // if ok, put in db
  $result = $conn->query("insert into kayttajat (email, salasana, etunimi, sukunimi) values
                         ('".$email."', sha1('".$password."'), '".$firstname."', '".$lastname."')");
  if (!$result) {
    throw new Exception('Could not register you in database - please try again
later.');
  }

  return true;
}

function login($email, $password) {
// check username and password with db
// if yes, return true
// else throw exception

  // connect to db
  $conn = db_connect();

  // check if username is unique
  $result = $conn->query("select * from kayttajat
                         where email='".$email."'
                         and salasana = sha1('".$password."')");
  if (!$result) {
     throw new Exception('Could not log you in.');
  }

  if ($result->num_rows>0) {
     return true;
  } else {
     throw new Exception('Could not log you in.');
  }
}

function valid_email($address) {
  // check an email address is possibly valid
  if (preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $address)) {
    return true;
  } else {
    return false;
  }
}
?>
