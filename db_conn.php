<?php 
  $host = "localhost";
  $user = "root";
  $psw = "";
  $db_name = "myserver";
  $conn = new mysqli($host,$user,$psw,$db_name);
  if($conn->error) die("errore nella connessione: " . $conn->error);
?>