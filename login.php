<?php
// LOGIN: recibe usuario y contraseña desde el formulario login.html.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CONEXIÓN MYSQLI: configuración local predeterminada de XAMPP.
    $conexion = mysqli_connect("localhost", "root", "");

    if (!$conexion) {
        die("Problemas al conectar: " . mysqli_connect_error());
    }
    mysqli_set_charset($conexion, "utf8mb4");

    // SELECCIÓN DE BASE DE DATOS: la base se llama academia.
    if (!mysqli_select_db($conexion, "academia")) {
        die("Problemas al seleccionar la base de datos");
    }

    // CREDENCIALES POST: nombres iguales a los campos del formulario.
    $usuario = mysqli_real_escape_string($conexion, trim($_POST["usuario"] ?? ""));
    $password = mysqli_real_escape_string($conexion, $_POST["password"] ?? "");

    // CONSULTA SELECT: busca coincidencia en la tabla academia.
    $sql = "SELECT * FROM academia WHERE usuario='$usuario' AND password='$password'";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // ACCESO CORRECTO: abre la página de expedientes del ejemplo.
        header("Location: pagina.html");
        exit;
    }

    // ACCESO INCORRECTO: avisa y vuelve al formulario de login.
    echo '<script>alert("Usuario incorrecto"); window.location.href="login.html";</script>';
    mysqli_close($conexion);
} else {
    header("Location: login.html");
    exit;
}
?>
