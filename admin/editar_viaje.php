
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

$viaje = getFeaturedTrip($id_viaje);

$proveedores = getProviders();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_proveedor = $_POST['id_proveedor'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fecha_salida = $_POST['fecha_salida'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $precio = $_POST['precio'];

    $asientos_disponibles = $_POST['asientos_disponibles'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

    mysqli_query($conn, "UPDATE viaje SET id_proveedor = '$id_proveedor', origen = '$origen', destino = '$destino', fecha_salida = '$fecha_salida', fecha_llegada = '$fecha_llegada', asientos_disponibles = '$asientos_disponibles', precio = '$precio', descripcion = '$descripcion', estado = '$estado' WHERE id_viaje = $id_viaje");
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
                    <select id="id_proveedor" name="id_proveedor" required >
            
                        <?php foreach ($proveedores as $proveedor): ?>
                            <?php
                            if ($proveedor['id_proveedor'] == $viaje['id_proveedor']) {
                                ?>
                                <option value="<?php echo htmlspecialchars($proveedor['id_proveedor']); ?>" selected>
                                    <?php echo htmlspecialchars($proveedor['nombre']); ?>
                                </option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php echo htmlspecialchars($proveedor['id_proveedor']); ?>">
                                    <?php echo htmlspecialchars($proveedor['nombre']); ?>
                                </option>
                            <?php
                            }
                        endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="origen" placeholder="Cantidad de Asientos" value="<?php echo $viaje['origen']; ?>" placeholder="Origen" required>
                </div>
                <div class="form-group">
                    <input type="text" name="destino" placeholder="Cantidad de Asientos" value="<?php echo $viaje['destino']; ?>" placeholder="Destino" required>
                </div>
                <div class="form-group">
                    <input type="date" name="fecha_salida" placeholder="Cantidad de Asientos" value="<?php echo date('Y-m-d', strtotime($viaje['fecha_salida'])); ?>" placeholder="Fecha de Salida" required>
                </div>
                <div class="form-group">
                    <input type="date" name="fecha_llegada" placeholder="Cantidad de Asientos" value="<?php echo date('Y-m-d', strtotime($viaje['fecha_llegada'])); ?>" placeholder="Fecha de llegada" required>
                </div>
                <div class="form-group">
                    <input type="number" name="asientos_disponibles" placeholder="Cantidad de Asientos" value="<?php echo $viaje['asientos_disponibles']; ?>" placeholder="Asientos Disponibles" required>
                </div>
                <div class="form-group">
                    <input type="number" name="precio" placeholder="Precio por Persona" value="<?php echo $viaje['precio']; ?>" required>
                </div>
                <div class="form-group  ">
                    <textarea name="descripcion" placeholder="Descripción del Viaje" required><?php echo $viaje['descripcion']; ?></textarea>
                </div>
                <div class="form-group">
                    <select id="estado" name="estado" required>
                        <option value="disponible" <?php echo $viaje['estado'] === 'disponible' ? 'selected' : ''; ?>>Disponible</option>
                        <option value="no disponible" <?php echo $viaje['estado'] === 'no disponible' ? 'selected' : ''; ?>>No Disponible</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Actualizar Reserva</button>
            </form>
            
            <p class="auth-link">¿Deseas cancelar? <a href="./dashboard.php">Regresar</a></p>
        </div>
    </div>
</section>


<?php require_once '../includes/footer.php'; ?>