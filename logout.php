<?php 
  header('Location: registrazione.php');
  session_destroy();
  session_abort();
  die();
?>