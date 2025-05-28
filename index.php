<?php
require_once './config.php';
require_once './includes/db.php';
require_once 'includes/header.php';
require_once 'includes/functions.php';


$featuredTrips = getFeaturedTrips();

?>
<section class="hero">
    <div class="hero-content">
        <h1>Descubre la Naturaleza con Nosotros</h1>
        <p>Viajes sostenibles que conectan con el corazón verde del planeta.</p>
        <a href="#destinos" class="btn-explore">Explorar Destinos</a>
    </div>
</section>

<section id="destinos" class="destinations">
    <div class="container">
        <h2 class="section-title">Destinos Destacados</h2>
        <div class="trips-grid">
            <?php while ($trip = mysqli_fetch_assoc($featuredTrips))  {?>
            <div class="trip-card">
                <div class="trip-image" style="background-image: url('assets/images/nature-<?php echo rand(1, 7); ?>.jpg')"></div>
                <div class="trip-info">
                    <h3><?php echo $trip['origen']; ?> a <?php echo $trip['destino']; ?></h3>
                    <p class="trip-date"><?php echo date('d M Y', strtotime($trip['fecha_salida'])); ?> - <?php echo date('d M Y', strtotime($trip['fecha_llegada'])); ?></p>
                    <p class="trip-price">$<?php echo $trip['precio']; ?></p>
                    <p class="trip-seats">Asientos disponibles: <?php echo $trip['asientos_disponibles']; ?></p>
                    <?php if(isset($_SESSION['user'])): ?>
                        <a href="reservar.php?id=<?php echo $trip['id_viaje']; ?>" class="btn-book">Reservar Ahora</a>
                    <?php else: ?>
                        <a href="register.php" class="btn-book">Regístrate para Reservar</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php }; ?>
        </div>
    </div>
</section>

<section id="nosotros" class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2 class="section-title">Nuestra Misión</h2>
                <p>En TravelXperience nos comprometemos con el turismo sostenible, ofreciendo experiencias que respetan y preservan los entornos naturales mientras apoyamos a las comunidades locales.</p>
                <p>Cada viaje que organizamos está diseñado para minimizar el impacto ambiental y maximizar la conexión con la naturaleza.</p>
                <a href="#" class="btn-learn">Conoce Más</a>
            </div>
            <div class="about-image">
                <img src="assets/images/nature-about.jpg" alt="Nuestra misión">
            </div>
        </div>
    </div>
</section>


<?php require_once 'includes/footer.php'; ?>
    
