
<?php
require_once '../config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'administrador') {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id_reserva'])) {
    header('Location: ../index.php');
    exit();
}
$id_reserva = intval($_GET['id_reserva']);

$reserva = getFeaturedReservation($id_reserva);

mysqli_query($conn, "DELETE FROM reserva  WHERE id_reserva = $id_reserva");
header('Location: ./dashboard.php');

?>





<?php require_once '../includes/footer.php'; ?>