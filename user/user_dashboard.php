<?php
require_once '../config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

// Verificar sesión y tipo de usuario
if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'cliente') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user']['id_usuario'];
$reservas = getFeaturedReservations($user_id);
?>

<section class="dashboard-section">
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user']['nombre']); ?></h2>
        
        <div class="dashboard-grid">
            <div class="dashboard-sidebar">
                <ul>
                    <li class="active"><a href="user_dashboard.php">Mis Reservas</a></li>
                    <li><a href="../logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
            
            <div class="dashboard-content">
                <h3>Mis Reservas</h3>
                
                <?php if ($reservas !== []): ?>
                    <div class="reservas-list">
                        <?php while ($reserva = mysqli_fetch_assoc($reservas)): ?>
                            <div class="reserva-card">
                                <div class="reserva-info">
                                    <h4><?php echo htmlspecialchars($reserva['origen']); ?> a <?php echo htmlspecialchars($reserva['destino']); ?></h4>
                                    <p>Fecha: <?php echo date('d M Y', strtotime($reserva['fecha_salida'])); ?> - <?php echo date('d M Y', strtotime($reserva['fecha_llegada'])); ?></p>
                                    <p>Estado: <span class="status-<?php echo strtolower($reserva['estado']); ?>"><?php echo htmlspecialchars($reserva['estado']); ?></span></p>
                                    <p>Fecha de reserva: <?php echo date('d M Y H:i', strtotime($reserva['fecha_reserva'])); ?></p>
                                </div>
                                <div class="reserva-actions">
                                    <a href="detalle_reserva.php?id=<?php echo $reserva['id_reserva']; ?>" class="btn-details">Ver Detalles</a>
                                    <?php if ($reserva['estado'] === 'pendiente'): ?>
                                        <a href="cancelar_reserva.php?id=<?php echo $reserva['id_reserva']; ?>" class="btn-cancel">Cancelar</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="no-reservas">
                        <p>No tienes reservas aún. <a href="../index.php">¡Explora nuestros destinos!</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php 
require_once '../includes/footer.php'; 
?>