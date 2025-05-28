<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Viajes Sostenibles</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="<?php echo SITE_URL; ?>/index.php" class="logo">Travel<span>Xperience</span></a>
                <ul class="nav-links">
                    <li><a href="<?php echo SITE_URL; ?>/index.php">Inicio</a></li>
                    <li><a href="#destinos">Destinos</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                    <?php if(isset($_SESSION['user'])): ?>
                        <li><a href="<?php echo SITE_URL; ?>/user/dashboard.php">Mi Cuenta</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo SITE_URL; ?>/login.php">Iniciar Sesión</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/register.php" class="btn-register">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>