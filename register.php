<?php
require_once 'config.php';
require_once './includes/db.php';
require_once 'includes/header.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'telefono' => $_POST['telefono'],
        'direccion' => $_POST['direccion']
    ];
    
    if (registerUser($data)) {
        header('Location: login.php?registered=1');
        exit();
    } else {
        $error = "Error al registrar el usuario. Inténtalo de nuevo.";
    }
}
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <h2>Crear Cuenta</h2>
            <?php if(isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <input type="text" name="apellido" placeholder="Apellido" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="telefono" placeholder="Teléfono">
                </div>
                <div class="form-group">
                    <textarea name="direccion" placeholder="Dirección"></textarea>
                </div>
                <button type="submit" class="btn-submit">Registrarse</button>
            </form>
            <p class="auth-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>