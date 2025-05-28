<?php
require_once '../config.php';
require_once '../includes/header.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'administrador') {
    header('Location: ../login.php');
    exit();
}

// Obtener todas las reservas
$stmt = $pdo->query("SELECT r.*, v.origen, v.destino, u.nombre as usuario_nombre, u.email as usuario_email 
                    FROM Reserva r 
                    JOIN Viaje v ON r.id_viaje = v.id_viaje 
                    JOIN Usuario u ON r.id_usuario = u.id_usuario 
                    ORDER BY r.fecha_reserva DESC");
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener estadísticas
$stats = $pdo->query("SELECT 
                        COUNT(*) as total_reservas,
                        SUM(CASE WHEN estado = 'confirmada' THEN 1 ELSE 0 END) as confirmadas,
                        SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                        SUM(CASE WHEN estado = 'cancelada' THEN 1 ELSE 0 END) as canceladas
                      FROM Reserva")->fetch(PDO::FETCH_ASSOC);
?>

<section class="dashboard-section">
    <div class="container">
        <h2>Panel de Administración</h2>
        
        <div class="dashboard-grid">
            <div class="dashboard-sidebar">
                <ul>
                    <li class="active"><a href="dashboard.php">Reservas</a></li>
                    <li><a href="viajes.php">Viajes</a></li>
                    <li><a href="usuarios.php">Usuarios</a></li>
                    <li><a href="pagos.php">Pagos</a></li>
                    <li><a href="../logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
            
            <div class="dashboard-content">
                <div class="stats-cards">
                    <div class="stat-card">
                        <h3>Total Reservas</h3>
                        <p><?php echo $stats['total_reservas']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Confirmadas</h3>
                        <p><?php echo $stats['confirmadas']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Pendientes</h3>
                        <p><?php echo $stats['pendientes']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Canceladas</h3>
                        <p><?php echo $stats['canceladas']; ?></p>
                    </div>
                </div>
                
                <h3>Todas las Reservas</h3>
                
                <div class="reservas-list">
                    <?php foreach ($reservas as $reserva): ?>
                    <div class="reserva-card">
                        <div class="reserva-info">
                            <h4><?php echo $reserva['origen']; ?> a <?php echo $reserva['destino']; ?></h4>
                            <p>Usuario: <?php echo $reserva['usuario_nombre']; ?> (<?php echo $reserva['usuario_email']; ?>)</p>
                            <p>Fecha: <?php echo date('d M Y', strtotime($reserva['fecha_salida'])); ?> - <?php echo date('d M Y', strtotime($reserva['fecha_llegada'])); ?></p>
                            <p>Estado: <span class="status-<?php echo strtolower($reserva['estado']); ?>"><?php echo $reserva['estado']; ?></span></p>
                        </div>
                        <div class="reserva-actions">
                            <a href="#" class="btn-details">Ver Detalles</a>
                            <a href="#" class="btn-edit">Editar</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>