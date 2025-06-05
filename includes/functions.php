<?php
function getFeaturedUsers() {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM Usuario WHERE tipo = 'cliente' ");
        return $stmt;
    } catch (Exception $e) {
        return [];
    }
}


// Función para obtener viajes destacados
function getFeaturedTrips() {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM viaje WHERE estado = 'disponible' ");
        return $stmt;
    } catch (Exception $e) {
        return [];
    }
}

function getFeaturedTrip($id) {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM viaje WHERE id_viaje = '$id' ");
        $viaje = $stmt->fetch_assoc();
        $stmt->close();
        return $viaje;
    } catch (Exception $e) {
        return [];
    }
}

// Función para registrar un nuevo usuario
function registerUser($data) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO Usuario (nombre, apellido, email, contrasena, telefono, direccion, tipo) VALUES (?, ?, ?, ?, ?, ?, 'cliente')");
        $stmt->bind_param("ssssss", $data['nombre'], $data['apellido'], $data['email'], $data['password'], $data['telefono'], $data['direccion']);
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

// Función para autenticar usuario
function loginUser($email, $password) {
    global $conn;
    try {
        $stmt = mysqli_query($conn,"SELECT * FROM Usuario WHERE email = '$email'");
        $user = $stmt->fetch_assoc();
        $stmt->close();
        if ($user['contrasena']== $password  ) {
            return $user;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

function getFeaturedReservations($id_usuario) {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM reserva JOIN viaje on reserva.id_viaje = viaje.id_viaje WHERE id_usuario = $id_usuario ");
        return $stmt;
    } catch (Exception $e) {
        return [];
    }
}

function getFeaturedReservation($id_reserva) {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM reserva JOIN viaje on reserva.id_viaje = viaje.id_viaje WHERE id_reserva = $id_reserva ");
        $reserva = $stmt->fetch_assoc();
        $stmt->close();
        return $reserva;
    } catch (Exception $e) {
        return [];
    }
}

function getFeaturedReservationsAdmin() {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM reserva JOIN viaje on reserva.id_viaje = viaje.id_viaje  ");
        return $stmt;
    } catch (Exception $e) {
        return [];
    }
}

function createReservation($id_usuario, $id_viaje, $asientos) {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "INSERT INTO reserva (id_viaje, id_usuario, cantidad_asientos) VALUES ($id_viaje, $id_usuario, $asientos)");
    } catch (Exception $e) {
        return false;
    }
}

function getProviders() {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM proveedor");
        return $stmt;
    } catch (Exception $e) {
        return [];
    }
}

function getProvider($id_proveedor) {
    global $conn;
    try {
        $stmt = mysqli_query($conn, "SELECT * FROM proveedor WHERE id_proveedor = '$id_proveedor' ");
        $proveedor = $stmt->fetch_assoc();
        $stmt->close();
        return $proveedor;
    } catch (Exception $e) {
        return [];
    }
}

?>