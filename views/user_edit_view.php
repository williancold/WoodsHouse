<?php
session_start();
require_once('../includes/session_auth.php');
require_once('../includes/db_connect.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do usuário não informado.");
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    die("Usuário não encontrado.");
}

$cargos = $pdo->query("SELECT * FROM cargos ORDER BY nome")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Editar Usuário</h1>

                    <form method="POST" action="../actions/user_save.php">
                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Nova Senha (deixe em branco para não alterar)</label>
                            <input type="password" name="senha" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Cargo</label>
                            <select name="cargo_id" class="form-control" required>
                                <?php foreach ($cargos as $cargo): ?>
                                    <option value="<?= $cargo['id'] ?>" <?= $cargo['id'] == $usuario['cargo_id'] ? 'selected' : '' ?>>
                                        <?= $cargo['nome'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button class="btn btn-primary">Salvar Alterações</button>
                        <a href="user_list_view.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>

            <?php include('../includes/footer.php'); ?>
        </div>
    </div>

    <?php include('../includes/scripts.php'); ?>
</body>

</html>