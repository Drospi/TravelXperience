
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

$viaje = getFeaturedReservation($id_reserva);
$usuarios = getFeaturedUsers();
$viajes = getFeaturedTrips();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_viaje = intval($_POST['id_viaje']);
    $id_usuario = intval($_POST['id_usuario']);
    $cantidad_asientos = intval($_POST['cantidad_asientos']);
    $estado = $_POST['estado'];

    mysqli_query($conn, "UPDATE reserva SET id_viaje = $id_viaje, id_usuario = $id_usuario, cantidad_asientos = $cantidad_asientos, estado = '$estado' WHERE id_reserva = $id_reserva");
    header('Location: ./dashboard.php');
    exit();
    
}

?>


    <section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <h2>Editar Reserva</h2>

            <form method="POST">
                <div class="form-group">
                    <select id="id_usuario" name="id_usuario" required >
            
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php
                            if ($usuario['id_usuario'] == $viaje['id_usuario']) {
                                ?>
                                <option value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" selected>
                                    <?php echo htmlspecialchars($usuario['nombre']); ?>
                                </option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                                    <?php echo htmlspecialchars($usuario['nombre']); ?>
                                </option>
                            <?php
                            }
                        endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <select id="id_viaje" name="id_viaje" required >
                        <?php foreach ($viajes as $trip): 

                            if ($trip['id_viaje'] == $viaje['id_viaje']) {
                                ?>
                                <option value="<?php echo htmlspecialchars($trip['id_viaje']); ?>" selected>
                                    <?php echo htmlspecialchars($trip['origen']); ?> a <?php echo htmlspecialchars($trip['destino']); ?>
                                </option>
                            <?php
                            } else {
                                ?>
                                <option value="<?php echo htmlspecialchars($trip['id_viaje']); ?>">
                                    <?php echo htmlspecialchars($trip['origen']); ?> a <?php echo htmlspecialchars($trip['destino']); ?>
                                </option>
                            <?php
                            }
                         endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" name="cantidad_asientos" placeholder="Cantidad de Asientos" value="<?php echo $viaje['cantidad_asientos']; ?>" placeholder="Asientos Disponibles" required>
                </div>
                <div class="form-group">
                    <select id="estado" name="estado" required>
                        <option value="pendiente" <?php echo $viaje['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="confirmado" <?php echo $viaje['estado'] === 'confirmado' ? 'selected' : ''; ?>>Confirmado</option>
                        <option value="cancelado" <?php echo $viaje['estado'] === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Actualizar Reserva</button>
            </form>
        </div>
    </div>
</section>


<?php require_once '../includes/footer.php'; ?>