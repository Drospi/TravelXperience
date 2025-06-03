<?php
require_once '../config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';
require_once '../includes/functions.php';

$providers = getProviders();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $proveedor = $_POST['proveedor'];
    $fecha_salida = $_POST['fecha_salida'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $asientos_disponibles = $_POST['asientos_disponibles'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    mysqli_query($conn, "INSERT INTO viaje (origen, destino, id_proveedor, fecha_salida, fecha_llegada, asientos_disponibles, precio, descripcion) VALUES ('$origen', '$destino', '$proveedor', '$fecha_salida', '$fecha_llegada', $asientos_disponibles, $precio, '$descripcion')");
    header('Location: ./dashboard.php');
    exit();
} 
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <h2>Agregar Viaje</h2>

            <form method="POST">
                <div class="form-group">
                    <input type="text" name="origen" placeholder="Origen" required>
                </div>
                <div class="form-group">
                    <input type="text" name="destino" placeholder="Destino" required>
                </div>
                <div class="form-group">
                    <select id="opciones" name="proveedor" required >
                        <option value="" disabled selected>Seleccione un Proveedor</option>
                        <?php foreach ($providers as $provider): ?>
                            <option value="<?php echo htmlspecialchars($provider['id_proveedor']); ?>">
                                <?php echo htmlspecialchars($provider['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="date" name="fecha_salida" placeholder="Fecha de Salida" required>
                </div>
                <div class="form-group">
                    <input type="date" name="fecha_llegada" placeholder="Fecha de llegada" required>
                </div>
                <div class="form-group">
                    <input type="number" name="asientos_disponibles" placeholder="Asientos Disponibles" required>
                </div>
                <div class="form-group">
                    <input type="number" name="precio" placeholder="Precio" required>
                </div>
                <div class="form-group">
                    <textarea name="descripcion" placeholder="Descripción" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Registrar Viaje</button>
            </form>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>