
<?php
require_once '../config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'administrador') {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id_viaje'])) {
    header('Location: ../index.php');
    exit();
}
$id_viaje = intval($_GET['id_viaje']);

$reserva = getFeaturedTrip($id_viaje);

mysqli_query($conn, "DELETE FROM viaje  WHERE id_viaje = $id_viaje");
header('Location: ./dashboard.php');

?>





<?php require_once '../includes/footer.php'; ?>