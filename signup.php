<?php
require "database.php";

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
  $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $stmt->bindParam(':password', $password);

  if ($stmt->execute()) {
    $message = '¡Usuario creado exitosamente!';
  } else {
    $message = 'Lo sentimos, ocurrió un error al crear su cuenta.';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Registro</title>
  <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
  <?php require "partials/header.php"; ?>

  <h1>Registrarse</h1>

  <?php if (!empty($message)): ?>
    <p class="message"><?= $message ?></p>
  <?php endif; ?>

  <form action="signup.php" method="POST">
    <input name="email" type="email" placeholder="Ingrese su email" required>
    <input name="password" type="password" placeholder="Ingrese su clave" required>
    <input name="confirm_password" type="password" placeholder="Confirme su contraseña" required>
    <input type="submit" value="Registrarse">
  </form>

  <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
</body>
</html>
