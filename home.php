<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page | Benvenuto</title>
  <link rel="stylesheet" href="./assets/main.css">
</head>
<body>
  <div class="home-container">
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <div class="display">
      <table>
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Nome</th>
            <th>Cognome</th>
          </tr>
        </thead>
        <tbody>
          <?php
          session_start();
          if (isset($_SESSION["user"])) {
            echo "<tr>";
            echo "<td>" . $_SESSION["user"] . "</td>";
            echo "<td>" . $_SESSION["email"] . "</td>";
            echo "<td>" . $_SESSION["nome"] . "</td>";
            echo "<td>" . $_SESSION["cognome"] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
      <?php 
        if($_SESSION["user"] === "admin") {
          echo "
            <div class=buttons>
              <a href=modifica.php class=link>MODIFICA</a>
            </div>
          ";
        }
      ?>
    </div>
    <div class="search">
      <form action="" method="get" class="search-form">
        <input type="text" name="nome" class="search-bar" placeholder="nome" />
        <input type="text" name="cognome" class="search-bar" placeholder="cognome" />
        <input type="text" name="data_nascita" class="search-bar" placeholder="data nascita" />
        <input type="text" name="luogo_nascita" class="search-bar" placeholder="luogo nascita" />
        <input type="text" name="ral" class="search-bar" placeholder="RAL" />
        <input type="text" name="codice_fiscale" class="search-bar" placeholder="codice fiscale" />
        <input type="submit" name="submit" value="search" class="btn" />
      </form>
      <h1 class="title">Result:</h1>
      <!-- output -->
      <?php
      include 'array_anagrafica.php';
      if (isset($_GET["submit"])) {
        $nome = $_GET["nome"];
        $cognome = $_GET["cognome"];
        $data_nascita = $_GET["data_nascita"];
        $luogo_nascita = $_GET["luogo_nascita"];
        $ral = $_GET["ral"];
        $codice_fiscale = $_GET["codice_fiscale"];

        echo "
        <table class=table>
          <thead>
            <tr>
              <th>Cognome</th>
              <th>Nome</th>
              <th>Data di nascita</th>
              <th>Luogo di nascita</th>
              <th>RAL</th>
              <th>Codice Fiscale</th>
            </tr>
          </thead>
          <tbody>        
        ";
        foreach ($arrayAnagrafica as $person) {
          if (($nome === "" || stripos($person["nome"], $nome) !== false) &&
            ($cognome === "" || stripos($person["cognome"], $cognome) !== false) &&
            ($data_nascita === "" || $person["data_nascita"] === $data_nascita) &&
            ($luogo_nascita === "" || stripos($person["luogo_nascita"], $luogo_nascita) !== false) &&
            ($ral === "" || $person["ral"] == $ral) &&
            ($codice_fiscale === "" || $person["codice_fiscale"] === $codice_fiscale)
          ) {
            // tutti i campi della persona/e cercata/e
            echo "<tr>";
              echo "<td>" . $person["cognome"] . "</td>";
              echo "<td>" . $person["nome"] . "</td>";
              echo "<td>" . $person["data_nascita"] . "</td>";
              echo "<td>" . $person["luogo_nascita"] . "</td>";
              echo "<td>" . $person["ral"] . "</td>";
              echo "<td>" . $person["codice_fiscale"] . "</td>";
            echo "</tr>";
          }
        }
        echo "</tbody>";
        echo "</table>";
      }
      ?>
    </div>
  </div>
</body>
</html>