<?php
session_start();
require_once('../includes/db_connect.php');

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    die("Preencha todos os campos.");
}

try {
    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../views/dashboard_view.php");
        exit;
    } else {
        echo "Email ou senha inválidos.";
    }
} catch (PDOException $e) {
    echo "Erro ao logar: " . $e->getMessage();
}
