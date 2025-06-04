<?php
require_once '../config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

// Verificar sesión y tipo de usuario
if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'administrador') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user']['id_usuario'];
$reservas = getFeaturedReservationsAdmin();
$viajes = getFeaturedTrips();
$proveedores = getProviders();
?>

<section class="dashboard-section">
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user']['nombre']); ?></h2>


        <div class="dashboard-grid">
            <div class="dashboard-sidebar">
                <ul>
                    <li id="link-reservas" class="active"><a href="" onclick="showSection('reservas'); event.preventDefault();">Reservas</a></li>
                    <li id="link-viajes" class="active"><a href="" onclick="showSection('viajes'); event.preventDefault();">Viajes</a></li>
                    <li id="link-proveedores" class="active"><a href="" onclick="showSection('proveedores'); event.preventDefault();">Proveedores</a></li>
                    <li><a href="../logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>

            <div class="dashboard-content">
                <div id="dashboard-reservas">
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
                                        <a href="editar_reserva.php?id_reserva=<?php echo $reserva['id_reserva']; ?>" class="btn-details">Editar</a>
                                        <a href="cancelar_reserva.php?id_reserva=<?php echo $reserva['id_reserva']; ?>" class="btn-cancel">Eliminar</a>
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

                <div id="dashboard-viajes">
                    <div class="dashboard-header">

                        <h3>Mis Viajes</h3>
                        <div class="reserva-actions">
                            <a href="agregar_viaje.php" class="btn-details">Agregar Viaje</a>
                        </div>
                    </div>

                    <?php if ($viajes !== []): ?>
                        <div class="reservas-list">
                            <?php while ($viaje = mysqli_fetch_assoc($viajes)): ?>
                                <div class="reserva-card">
                                    <div class="reserva-info">
                                        <h4><?php echo htmlspecialchars($viaje['origen']); ?> a <?php echo htmlspecialchars($viaje['destino']); ?></h4>
                                        <p>Fecha: <?php echo date('d M Y', strtotime($viaje['fecha_salida'])); ?> - <?php echo date('d M Y', strtotime($viaje['fecha_llegada'])); ?></p>
                                        <p>Estado: <span class="status-<?php echo strtolower($viaje['estado']); ?>"><?php echo htmlspecialchars($viaje['estado']); ?></span></p>
                                    </div>
                                    <div class="reserva-actions">
                                        <a href="editar_viaje.php?id_viaje=<?php echo $viaje['id_viaje']; ?>" class="btn-details">Editar</a>
                                        <a href="eliminar_viaje.php?id_viaje=<?php echo $reserva['id_viaje']; ?>" class="btn-cancel">Eliminar</a>
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

                <div id="dashboard-proveedores">
                    <div class="dashboard-header">

                        <h3>Proveedores</h3>
                        <div class="reserva-actions">
                            <a href="agregar_proveedor.php" class="btn-details">Agregar Proveedor</a>
                        </div>
                    </div>

                    <?php if ($proveedores !== []): ?>
                        <div class="reservas-list">
                            <?php while ($proveedor = mysqli_fetch_assoc($proveedores)): ?>
                                <div class="reserva-card">
                                    <div class="reserva-info">
                                        <h4><?php echo htmlspecialchars($proveedor['nombre']); ?> </h4>
                                        <p>Contacto: <?php echo (($proveedor['contacto'])); ?> - <?php echo (($proveedor['email'])); ?></p>
                                        <p>Direccion: <?php echo ($proveedor['direccion']); ?> - <?php echo htmlspecialchars($proveedor['telefono']); ?></p>
                                    </div>
                                    <div class="reserva-actions">
                                        <a href="editar_proveedor.php?id_proveedor=<?php echo $proveedor['id_proveedor']; ?>" class="btn-details">Editar</a>
                                        <a href="eliminar_proveedor.php?id_proveedor=<?php echo $proveedor['id_proveedor']; ?>" class="btn-cancel">Eliminar</a>
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
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        showSection('reservas');
    });

    function showSection(sectionId) {
        document.getElementById('dashboard-reservas').style.display = 'none';
        document.getElementById('dashboard-viajes').style.display = 'none';
        document.getElementById('link-reservas').classList.remove('active');
        document.getElementById('link-viajes').classList.remove('active');
        document.getElementById('dashboard-proveedores').style.display = 'none';
        document.getElementById('link-proveedores').classList.remove('active');

        document.getElementById('link-' + sectionId).classList.add('active');
        document.getElementById('dashboard-' + sectionId).style.display = 'block';
    }
</script>

<?php
require_once '../includes/footer.php';
?>