<?php
session_start();
require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $message = 'Correo o contraseña incorrectos.';
        }

        $stmt->close();
    } else {
        $message = "Error en la preparación de la consulta: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
  <?php require "partials/header.php"; ?>

  <h1>Iniciar Sesión</h1>

  <?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <input name="email" type="email" placeholder="Ingrese su email" required>
    <input name="password" type="password" placeholder="Ingrese su contraseña" required>
    <input type="submit" value="Ingresar">
  </form>

  <a href="signup.php">¿No tienes cuenta? Regístrate</a>
</body>
</html>
