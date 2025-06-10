<?php
if (!isset($_SESSION['usuario'])) {
    header("Location: ../views/login_view.php");
    exit;
}
