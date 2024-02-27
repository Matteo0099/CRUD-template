<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifica</title>
  <link rel="stylesheet" href="./assets/main.css">
</head>
<body>
  <div class="modifica-container">
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
  <form action="" method="post">
    <input type="text" name="username" placeholder="Username" value="<?php echo $_SESSION["user"]; ?>" required />
    <input type="password" name="password" placeholder="Password" required />
    <input type="email" name="email" placeholder="Email" value="<?php echo $_SESSION["email"]; ?>" required />
    <input type="text" name="nome" placeholder="Nome" value="<?php echo $_SESSION["nome"]; ?>" required />
    <input type="text" name="cognome" placeholder="Cognome" value="<?php echo $_SESSION["cognome"]; ?>" required />
    <!-- submit -->
    <input type="submit" name="modifica" value="Modifica" />
    <input type="submit" name="elimina" value="Elimina" />
    <input type="submit" name="aggiungi" value="Aggiungi" />
  </form>
</body>
</html>

<?php
if (isset($_POST["modifica"]) || isset($_POST["elimina"]) || isset($_POST["aggiungi"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  $nome = $_POST["nome"];
  $cognome = $_POST["cognome"];
  $password_Hash = password_hash($password, PASSWORD_BCRYPT); // hash password
  require_once "db_conn.php";

  // MODIFICA, ELIMINA, AGGIUNGI
  if (isset($_POST["modifica"])) {
    $sql = "UPDATE crud SET password=?, email=?, nome=?, cognome=? WHERE username=?";
  } elseif (isset($_POST["elimina"])) {
    $sql = "DELETE FROM crud WHERE username=?";
  } elseif (isset($_POST["aggiungi"])) {
    $sql = "INSERT INTO crud (username, password, email, nome, cognome) VALUES (?, ?, ?, ?, ?)";
  }

  $stmt = mysqli_stmt_init($conn); 
  // verifico se viene fatta la query (update,delete o insert)
  if (mysqli_stmt_prepare($stmt, $sql)) { 
    if (isset($_POST["modifica"])) {
      mysqli_stmt_bind_param($stmt, "sssss", $password_Hash, $email, $nome, $cognome, $username); 
    } elseif (isset($_POST["elimina"])) {
      mysqli_stmt_bind_param($stmt, "s", $username); 
    } elseif (isset($_POST["aggiungi"])) {
      mysqli_stmt_bind_param($stmt, "sssss", $username, $password_Hash, $email, $nome, $cognome); 
    }
    mysqli_stmt_execute($stmt); // eseguo la query
    
    if(isset($_POST["modifica"]) || isset($_POST["elimina"])) {
      // Avvio sessione
      $_SESSION["user"] = $username;
      header("Location: login.php");
      exit();
    }
  } 
}
?>