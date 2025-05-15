<?php
session_start();
require 'database.php';

$user = null;

if (isset($_SESSION['user_id'])) {
    $sql = "SELECT id, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
<?php require 'partials/header.php'; ?>

<?php if ($user): ?>
    <br>Bienvenido, <?= htmlspecialchars($user['email']) ?>
    <br>Estás logueado correctamente
    <br><a href="logout.php">Cerrar sesión</a>
<?php else: ?>
    <h1>Registre sus datos</h1>
    <p>Por favor ingrese sus datos para ser verificado.</p>
    <a href="login.php">Login</a> | <a href="signup.php">Signup</a>
<?php endif; ?>
</body>
</html>
