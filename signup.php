<?php
require "database.php";

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $message = 'Las contraseñas no coinciden.';
    } else {
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bind_param("ss", $_POST['email'], $password);

        if ($stmt->execute()) {
            $message = '¡Usuario creado exitosamente!';
        } else {
            $message = 'Lo sentimos, ocurrió un error al crear su cuenta.';
        }
        $stmt->close();
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
    <p class="message"><?= htmlspecialchars($message) ?></p>
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
