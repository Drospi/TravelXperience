
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

$proveedor = getProvider($id_proveedor);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $activo = 1;
    mysqli_query($conn, "UPDATE proveedor SET nombre = '$nombre', descripcion = '$descripcion', contacto = '$contacto', telefono = '$telefono', email = '$email', direccion = '$direccion', activo = $activo WHERE id_proveedor = $id_proveedor");
    header('Location: ./dashboard.php');
    exit();
    
}

?>


    <section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <h2>Editar Proveedor</h2>

            <form method="POST">
                <div class="form-group">
                    <input type="text" value="<?php echo $proveedor['nombre']; ?>" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <textarea type="text" name="descripcion" placeholder="Descripcion" required><?php echo $proveedor['descripcion']; ?></textarea>
                </div>
                <div class="form-group">
                    <input type="text" value="<?php echo $proveedor['contacto']; ?>" name="contacto" placeholder="Nombre del Contacto" required>
                </div>
                <div class="form-group">
                    <input type="number" value="<?php echo $proveedor['telefono']; ?>" name="telefono" placeholder="7894xxxx" required>
                </div>
                <div class="form-group">
                    <input type="email" value="<?php echo $proveedor['email']; ?>" name="email" placeholder="Ingrese su email" required>
                </div>
                <div class="form-group">
                    <input type="text" value="<?php echo $proveedor['direccion']; ?>" name="direccion" placeholder="Ingrese su direccion" required>
                </div>
                <button type="submit"  class="btn-submit">Actualizar Proveedor</button>
            </form>
            
            <p class="auth-link">¿Deseas cancelar? <a href="./dashboard.php">Regresar</a></p>
        </div>
    </div>
</section>


<?php require_once '../includes/footer.php'; ?>