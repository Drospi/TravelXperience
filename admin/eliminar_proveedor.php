
<?php
require_once '../config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'administrador') {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id_proveedor'])) {
    header('Location: ../index.php');
    exit();
}
$id_proveedor = intval($_GET['id_proveedor']);

mysqli_query($conn, "DELETE FROM proveedor WHERE id_proveedor = $id_proveedor");
header('Location: ./dashboard.php');

?>

