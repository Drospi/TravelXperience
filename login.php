<?php
require_once 'config.php';
require_once './includes/db.php';
require_once 'includes/header.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $user = loginUser($email, $password);
    
    if ($user) {
        
        $_SESSION['user'] = $user;
        
        if ($user['tipo'] === 'administrador') {
            echo "<script>window.location.href = 'admin/dashboard.php';</script>";
        } else {
            echo "<script>window.location.href = 'user/user_dashboard.php';</script>";
        }
        
        
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <h2>Iniciar Sesión</h2>
            <?php if(isset($_GET['registered'])): ?>
                <div class="alert success">¡Registro exitoso! Por favor inicia sesión.</div>
            <?php endif; ?>
            
            <?php if(isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn-submit">Iniciar Sesión</button>
            </form>
            <p class="auth-link">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>