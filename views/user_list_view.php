<?php
session_start();
require_once('../includes/session_auth.php');
require_once('../includes/db_connect.php');

// Consulta todos os usuários com o nome do cargo
$sql = "SELECT u.id, u.nome, u.email, u.created_at, c.nome AS cargo 
        FROM usuarios u 
        JOIN cargos c ON u.cargo_id = c.id 
        ORDER BY u.created_at DESC";

$usuarios = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Usuários - Wood's House</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include('../includes/sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../includes/topbar.php'); ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Usuários do Sistema</h1>

                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Data de Criação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= htmlspecialchars($usuario['cargo']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></td>
                                    <td>
                                        <a href="user_edit_view.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                                        <a href="../actions/user_delete.php?id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <a href="user_register_view.php" class="btn btn-success">Novo Usuário</a>
                </div>
            </div>
            <?php include('../includes/footer.php'); ?>
        </div>
    </div>

    <?php include('../includes/scripts.php'); ?>
</body>

</html>