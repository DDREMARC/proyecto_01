<?php
// PROCESO DE LOGIN: valida el formulario login.html contra la tabla academia.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // MÉTODO POST: acepta únicamente el envío del formulario de acceso.
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: login.html");
        exit;
    }

    // CONEXIÓN A MYSQL: usa la configuración local predeterminada de XAMPP.
    $conexion = new mysqli("localhost", "root", "", "academia");
    $conexion->set_charset("utf8mb4");

    $usuario = trim($_POST["usuario"] ?? "");
    $password = $_POST["password"] ?? "";

    // CONSULTA SEGURA: los parámetros evitan concatenar datos del formulario al SQL.
    $consulta = $conexion->prepare(
        "SELECT usuario FROM academia WHERE usuario = ? AND password = ? LIMIT 1"
    );
    $consulta->bind_param("ss", $usuario, $password);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $accesoValido = $resultado->num_rows === 1;
    $consulta->close();
    $conexion->close();

    if ($accesoValido) {
        header("Location: pagina.html");
        exit;
    }

    // MENSAJE DE ACCESO: informa si las credenciales no coinciden.
    echo '<script>alert("Usuario o contraseña incorrectos"); window.location.href="login.html";</script>';
} catch (Throwable $error) {
    error_log($error->getMessage());
    echo '<script>alert("No se pudo iniciar sesión. Revisa MySQL y la base de datos."); window.location.href="login.html";</script>';
}
?>
