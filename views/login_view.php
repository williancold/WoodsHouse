<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard_view.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Wood's House</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Bem-vindo ao sistema!</h1>
                        </div>

                        <form class="user" action="../actions/login_process.php" method="POST">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" name="email" placeholder="Digite seu email..." required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" name="senha" placeholder="Digite sua senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Entrar
                            </button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="#">Wood's House • Sistema Interno</a>
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