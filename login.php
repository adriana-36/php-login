<?php
session_start();
require "database.php";

if (!empty($_POST['email']) && !empty($_POST['password'])) {
  $records = $conn->prepare("SELECT id, email, password FROM users WHERE email = :email");
  $records->bindParam(':email', $_POST['email']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $message = '';

  if ($results && password_verify($_POST['password'], $results['password'])) {
    $_SESSION['user_id'] = $results['id'];
    header("Location: index.php");
  } else {
    $message = 'Los datos ingresados no son válidos.';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
  <?php require "partials/header.php"; ?>

  <h1>Iniciar sesión</h1>

  <?php if (!empty($message)): ?>
    <p class="message"><?= $message ?></p>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <input name="email" type="email" placeholder="Ingrese su email" required>
    <input name="password" type="password" placeholder="Ingrese su contraseña" required>
    <input type="submit" value="Iniciar sesión">
  </form>

  <a href="signup.php">¿No tienes cuenta? Regístrate</a>
</body>
</html>
