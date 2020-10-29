<?php


function db_connect() {
   $result = new mysqli("127.0.0.1", "root", "", "users");
   if (!$result) {
     throw new Exception('Could not connect to database server');
   } else {
     return $result;
   }
}
?>
