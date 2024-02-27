<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrazione</title>
  <link rel="stylesheet" href="./assets/main.css">
</head>
<body>
  <form action="" method="post">
    <input type="text" name="username" placeholder="username" required />
    <input type="password" name="password" placeholder="password" required />
    <input type="email" name="email" placeholder="email" required />
    <input type="text" name="nome" placeholder="nome" required />
    <input type="text" name="cognome" placeholder="cognome" required />
    <!-- submit -->
    <input type="submit" name="submit" placeholder="Submit" />
    <div class="container">
      <a href="login.php">Già registrato?</a>
    </div>
  </form>
</body>
</html>

<?php   
  if(isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    // hash della password
    $password_Hash = password_hash($password, PASSWORD_BCRYPT);

    require_once "db_conn.php";
    $sql = "INSERT INTO crud (username, password, email, nome, cognome) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn); // inizializza una nuova istruzione
    mysqli_stmt_prepare($stmt, $sql); // prepara l'istruzione sql
    mysqli_stmt_bind_param($stmt, "sssss", $username, $password_Hash, $email, $nome, $cognome); // associo i valori alle posizioni della query;
    mysqli_stmt_execute($stmt); // eseguo la query con i valori associati
    
    // avvio sessione
    session_start();
    $_SESSION["user"] = $username; 
    header("Location: login.php");
    exit(); 
  }
?>