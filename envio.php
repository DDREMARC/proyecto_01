<?php
// ENVÍO DEL FORMULARIO: recibe los campos enviados desde contactos.html.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CONEXIÓN MYSQLI: host, usuario root y contraseña vacía de XAMPP local.
    $conexion = mysqli_connect("localhost", "root", "");

    if (!$conexion) {
        die("Problemas al conectar: " . mysqli_connect_error());
    }
    mysqli_set_charset($conexion, "utf8mb4");

    // SELECCIÓN DE BASE DE DATOS: usa la base academia creada en phpMyAdmin.
    if (!mysqli_select_db($conexion, "academia")) {
        die("Problemas al seleccionar la base de datos");
    }

    // DATOS POST: nombres coinciden con los atributos name del formulario.
    $nombres = mysqli_real_escape_string($conexion, trim($_POST["nombres"] ?? ""));
    $direccion = mysqli_real_escape_string($conexion, trim($_POST["direccion"] ?? ""));
    $correo = mysqli_real_escape_string($conexion, trim($_POST["correo"] ?? ""));
    $comentarios = mysqli_real_escape_string($conexion, trim($_POST["comentarios"] ?? ""));

    // INSERT SQL: guarda los cuatro valores recibidos en la tabla datos.
    $sql = "INSERT INTO datos (nombres, direccion, correo, comentarios)
            VALUES ('$nombres', '$direccion', '$correo', '$comentarios')";

    if (mysqli_query($conexion, $sql)) {
        // CONFIRMACIÓN: muestra el aviso y regresa a la página principal.
        echo '<script>alert("Datos enviados correctamente"); window.location.href="index.html";</script>';
    } else {
        echo '<script>alert("Problemas al enviar los datos"); window.location.href="index.html";</script>';
    }

    mysqli_close($conexion);
} else {
    // ACCESO DIRECTO: vuelve al sitio si el formulario no se envió por POST.
    header("Location: contactos.html");
    exit;
}
?>
