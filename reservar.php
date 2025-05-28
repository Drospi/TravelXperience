
<?php
require_once 'config.php';
require_once './includes/db.php';
require_once './includes/header.php';
require_once './includes/functions.php';

if (!isset($_SESSION['user']) ) {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}
$id_usuario = $_SESSION['user']['id_usuario'];
$viaje_id = intval($_GET['id']);

$viaje = getFeaturedTrip($viaje_id);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asientos = intval($_POST['cantidad_asientos']);
    $precio = floatval($viaje['precio']);
    $reserva = createReservation($id_usuario,$viaje_id,$asientos);
    echo "<script>window.location.href = 'user/user_dashboard.php';</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Viaje | EcoTravel</title>
    <style>
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #388e3c;
            --accent-color: #8bc34a;
            --light-bg: #f5f5f5;
            --white: #ffffff;
            --text-color: #333;
        }
        
        .reserva-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .reserva-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .reserva-header h1 {
            color: var(--primary-color);
            font-size: 2.2rem;
        }
        
        .reserva-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .viaje-info {
            padding: 2rem;
            background: var(--light-bg);
        }
        
        .viaje-info h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }
        
        .info-item {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .info-icon {
            margin-right: 1rem;
            color: var(--accent-color);
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .reserva-form-container {
            padding: 2rem;
        }
        
        .form-title {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: var(--text-color);
            margin-left: 1rem;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        .total-display {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 5px;
            margin: 1.5rem 0;
        }
        
        @media (max-width: 768px) {
            .reserva-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="reserva-container">
        <div class="reserva-header">
            <h1>Reservar Viaje</h1>
        </div>
        
        <div class="reserva-content">
            <div class="viaje-info">
                <h2>Información del Viaje</h2>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-route"></i></div>
                    <div>
                        <strong>Ruta:</strong> 
                        <span id="viaje-origen"><?php echo $viaje["origen"]; ?></span> a 
                        <span id="viaje-destino"><?php echo $viaje["destino"]; ?></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div>
                        <strong>Fecha de Salida:</strong> 
                        <span id="viaje-salida"><?php echo $viaje["fecha_salida"]; ?></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <strong>Fecha de Llegada:</strong> 
                        <span id="viaje-llegada"><?php echo $viaje["fecha_llegada"]; ?></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-chair"></i></div>
                    <div>
                        <strong>Asientos Disponibles:</strong> 
                        <span id="viaje-asientos"><?php echo $viaje["asientos_disponibles"]; ?></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-tag"></i></div>
                    <div>
                        <strong>Precio por persona:</strong> 
                        $<span id="viaje-precio"><?php echo $viaje["precio"]; ?></span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-tag"></i></div>
                    <div>
                        <strong>Descripcion:</strong> 
                        <span id="viaje-precio"><?php echo $viaje["descripcion"]; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="reserva-form-container">
                <h3 class="form-title">Completa tu Reserva</h3>
                
                <form id="form-reserva" method="POST">
                    <div class="form-group">
                        <label for="cantidad_asientos">Cantidad de Asientos</label>
                        <input type="number" id="cantidad_asientos" name="cantidad_asientos" 
                               min="1" max="<?php echo $viaje["descripcion"]; ?>" value="1" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Total a Pagar</label>
                        <div class="total-display">
                            $<span id="total-pagar">450.00</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Cálculo del total en tiempo real
        document.getElementById('cantidad_asientos').addEventListener('input', function() {
            const cantidad = parseInt(this.value) || 0;
            const precio = parseFloat(document.getElementById('viaje-precio').textContent);
            const total = cantidad * precio;
            document.getElementById('total-pagar').textContent = total.toFixed(2);
            
            // Validar máximo de asientos
            const maxAsientos = parseInt(document.getElementById('viaje-asientos').textContent);
            if (cantidad > maxAsientos) {
                this.value = maxAsientos;
                document.getElementById('total-pagar').textContent = (maxAsientos * precio).toFixed(2);
            }
        });
        
    </script>
</body>
</html>

<?php require_once '../includes/footer.php'; ?>