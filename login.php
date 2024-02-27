<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./assets/main.css">
</head>
<body>
  <form action="" method="post">
    <input type="email" name="email" placeholder="email" required />
    <input type="password" name="password" placeholder="password" required />
    <!-- submit -->
    <input type="submit" name="submit" placeholder="Submit" />
    <div class="container">
      <a href="registrazione.php">Non ti sei registrato?</a>
    </div>
  </form>
</body>
</html>

<?php
  if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // invio i parametri al DB
    require_once "db_conn.php";
    $sql = "SELECT * FROM crud WHERE email = ?";
    // prepara l'istruzione sql
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // verifico se c'è l'utente
    if ($user) {
      if (password_verify($password, $user["password"])) {
        session_start();
        // dati della sessione
        $_SESSION["user"] = $user["username"];
        $_SESSION["nome"] = $user["nome"];
        $_SESSION["cognome"] = $user["cognome"];
        $_SESSION["email"] = $user["email"];
        // reindirizzamento alla home
        header("Location: home.php");
        exit();
      } else 
          echo "<div class='alert alert-danger'>Password non corretta</div>";
    } else 
        echo "<div class='alert alert-danger'>Email non corretta</div>";
  }
?>