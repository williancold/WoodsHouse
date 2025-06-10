<?php
session_start();
require_once('../includes/db_connect.php');
require_once('../includes/session_auth.php');

$cargos = $pdo->query("SELECT * FROM cargos ORDER BY nome")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastro de Usuário</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-10">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Cadastro de novo usuário</h1>
                        </div>
                        <form class="user" method="POST" action="../actions/user_save.php">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="nome" placeholder="Nome completo" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control form-control-user" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" name="senha" placeholder="Senha" required>
                                </div>
                                <div class="col-sm-6">
                                    <select name="cargo_id" class="form-control form-control-user" required>
                                        <option value="">Selecione o cargo</option>
                                        <?php foreach ($cargos as $cargo): ?>
                                            <option value="<?= $cargo['id'] ?>"><?= $cargo['nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-success btn-user btn-block">
                                Cadastrar Usuário
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="dashboard_view.php">← Voltar para o Painel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>