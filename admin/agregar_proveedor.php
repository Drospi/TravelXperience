<?php
require_once '../config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';
require_once '../includes/functions.php';

$providers = getProviders();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    mysqli_query($conn, "INSERT INTO proveedor (nombre, descripcion, contacto, telefono, email, direccion, activo) VALUES ('$nombre', '$descripcion', '$contacto', '$telefono', '$email', '$direccion',1)");
    header('Location: ./dashboard.php');
    exit();
} 
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <h2>Agregar Proveedor</h2>

            <form method="POST">
                <div class="form-group">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <textarea type="text" name="descripcion" placeholder="Descripcion" required></textarea>
                </div>
                <div class="form-group">
                    <input type="text" name="contacto" placeholder="Nombre del Contacto" required>
                </div>
                <div class="form-group">
                    <input type="number" name="telefono" placeholder="7894xxxx" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Ingrese su email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="direccion" placeholder="Ingrese su direccion" required>
                </div>
                <button type="submit" class="btn-submit">Registrar Proveedor</button>
            </form>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>