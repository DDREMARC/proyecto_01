<?php
// ENVÍO DEL FORMULARIO: guarda los datos de contactos.html en la tabla datos.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // MÉTODO POST: rechaza accesos directos antes de intentar conectar a MySQL.
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: contactos.html");
        exit;
    }

    // CONEXIÓN A MYSQL: configuración local predeterminada de XAMPP.
    $conexion = new mysqli("localhost", "root", "", "academia");
    $conexion->set_charset("utf8mb4");

    $nombres = trim($_POST["nombres"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $comentarios = trim($_POST["comentarios"] ?? "");

    if ($nombres === "" || $direccion === "" || !filter_var($correo, FILTER_VALIDATE_EMAIL) || $comentarios === "") {
        throw new InvalidArgumentException("Completa todos los campos con datos válidos.");
    }

    // INSERT SEGURO: la consulta preparada trata los datos ingresados como valores.
    $consulta = $conexion->prepare(
        "INSERT INTO datos (nombres, direccion, correo, comentarios) VALUES (?, ?, ?, ?)"
    );
    $consulta->bind_param("ssss", $nombres, $direccion, $correo, $comentarios);
    $consulta->execute();
    $consulta->close();
    $conexion->close();

    // CONFIRMACIÓN: vuelve al formulario después de guardar el registro.
    echo '<script>alert("Datos enviados correctamente"); window.location.href="contactos.html";</script>';
} catch (Throwable $error) {
    // ERROR: el detalle técnico queda en el registro del servidor.
    error_log($error->getMessage());
    $mensaje = $error instanceof InvalidArgumentException
        ? $error->getMessage()
        : "No se pudo guardar. Revisa que MySQL esté iniciado y que la base academia esté importada.";
    echo "<script>alert(" . json_encode($mensaje) . "); window.location.href='contactos.html';</script>";
}
?>
