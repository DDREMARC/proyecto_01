# Documentación del proyecto: Academia Triunfadores

Resumen de lo que se revisó, instaló, corrigió y probó para que el proyecto sea una copia fiel de los videos del curso de TecnologíaZero.

## 1. Videos de referencia

| Parte | Título | Enlace | Contenido |
|---|---|---|---|
| 1 | JQuery desde Cero – Sesión 08 Parte 01 | https://youtu.be/kO5s8We8KLY | Navbar, carrusel, footer, efecto `fadeIn`, Nosotros con acordeón, Galería con modal jQuery |
| 2 | Sesión 08 Jquery – Parte 02 | https://youtu.be/N41sf2yfbOo | Iconos sociales, ScrollReveal, Contactos con Google Maps y formulario |
| 3 | Clase BD y Jquey 03 | https://youtu.be/g5aHl76M330 | PHP + MySQL: formulario a base de datos, login |

Método de comparación: se obtuvieron las transcripciones automáticas de los tres videos (solo el texto de los subtítulos) y se compararon con el código del proyecto. Las transcripciones tienen errores de reconocimiento de voz, por lo que algunos detalles (por ejemplo las opciones exactas de FlexSlider) no se pudieron confirmar.

## 2. Lo que se instaló

| Software | Versión | Cómo | Ubicación |
|---|---|---|---|
| XAMPP (Apache + MySQL/MariaDB + PHP + phpMyAdmin) | 8.2.12 (PHP 8.2.12) | `winget install --id ApacheFriends.Xampp.8.2` (paquete oficial, hash verificado) | `C:\xampp` |

No se instaló nada más. (`yt-dlp` ya estaba en el equipo y solo se usó para leer subtítulos.)

### Configuración realizada
1. Copia del proyecto a `C:\xampp\htdocs\proyecto_01` (sin las carpetas `.git` y `.github`).
2. Inicio de MySQL y Apache desde los ejecutables de XAMPP.
3. Importación de la base de datos: `mysql.exe -u root < academia.sql`.
4. Configuración por defecto de XAMPP: host `localhost`, usuario `root`, sin contraseña.

## 3. Cómo usar el proyecto

1. Abrir el **Panel de Control de XAMPP** y activar **Apache** y **MySQL**.
2. Abrir `http://localhost/proyecto_01/`.
3. phpMyAdmin: `http://localhost/phpmyadmin`.

Usuarios de prueba del login: `usuarioxy` y `admin`, ambos con contraseña `123456`.

Importante: el navegador muestra la copia de `C:\xampp\htdocs\proyecto_01`. Si se edita la carpeta del Escritorio hay que volver a copiar los archivos a `htdocs`.

## 4. Estructura del proyecto

```
proyecto_01/
├── index.html          Inicio (FlexSlider + fadeIn)
├── nosotros.html       Carrusel Bootstrap, acordeón, ScrollReveal
├── galeria.html        Galería con modal (jQuery)
├── contactos.html      Mapa + formulario (envía a envio.php)
├── login.html          Formulario de acceso (envía a login.php)
├── pagina.html         Destino tras un login correcto
├── envio.php           Guarda el formulario en la tabla datos
├── login.php           Valida usuario y contraseña
├── academia.sql        Base de datos y tablas
├── css/galeria.css     Estilos de la galería y el modal
├── flexslider.css / jquery.flexslider*.js
├── img/                Logo y banners
└── galeria/            8 fotos de la galería
```

## 5. Tecnologías y código usado

- **Bootstrap 5.3.8** (CDN): navbar responsive, carrusel, acordeón, cards, grilla, formularios.
- **Bootstrap Icons** (CDN): iconos de redes sociales.
- **jQuery 3.7.0** (CDN).
- **FlexSlider 2.7.2** (archivos locales): carrusel de la página de inicio.
- **ScrollReveal** (`unpkg.com/scrollreveal`): animaciones de la página Nosotros.
- **PHP + MySQLi**: formulario y login.

### 5.1 Efecto de entrada (index.html)
```js
$(function () { $('body').hide().fadeIn(3000); });
```

### 5.2 Carrusel FlexSlider (index.html)
```js
$(window).on('load', function () {
    $('.flexslider').flexslider({
        pauseOnAction: true, pauseOnHover: true,
        useCSS: true, touch: true, animationSpeed: 5000
    });
});
```

### 5.3 Animaciones (nosotros.html)
```js
window.sr = ScrollReveal({ reset: true });
sr.reveal('#logo', { duration: 500 });
sr.reveal('.navbar-nav', { duration: 1000, origin: 'left', distance: '500px' });
sr.reveal('#carouselExampleCaptions', { duration: 2000, origin: 'top', distance: '600px' });
sr.reveal('header', { duration: 3000, origin: 'bottom', distance: '500px' });
```

### 5.4 Galería con modal (galeria.html + css/galeria.css)
```js
$('.img-galeria').on('click', function () {
    const imagen = this.src;
    const modelo = `<div class="modelo"><img src="${imagen}" alt="Imagen ampliada"><button class="cerrar" type="button">&times;</button></div>`;
    $('body, html').append(modelo);
});
$(document).on('click', '.cerrar', function () { $('.modelo').remove(); });
$('body').on('keyup', function (event) {
    if (event.which === 27) $('.modelo').remove();   // 27 = tecla Escape
});
```
La cuadrícula usa flexbox con imágenes al 22 % (escritorio), 45 % (hasta 980 px) y 100 % (hasta 480 px).

### 5.5 Base de datos (academia.sql)
- Base `academia` (utf8mb4).
- Tabla `datos`: `nombres` (30), `direccion` (50), `correo` (50), `comentarios`.
- Tabla `academia`: `usuario` (30), `password` (30), con los usuarios `usuarioxy` y `admin`.

### 5.6 envio.php
Recibe el formulario por POST (`nombres`, `direccion`, `correo`, `comentarios`), se conecta con `mysqli_connect("localhost", "root", "")`, selecciona `academia` e inserta en `datos`. Muestra "Datos enviados correctamente" o "Problemas al enviar los datos" y vuelve a `index.html`.

### 5.7 login.php
Recibe `usuario` y `password` por POST y hace un `SELECT` en la tabla `academia`. Si hay una fila redirige a `pagina.html`; si no, muestra "Usuario incorrecto" y vuelve a `login.html`.

Nota: ambos archivos usan `mysqli_real_escape_string` y validan el método POST, algo más seguro que el código del video; el comportamiento es el mismo. Las contraseñas se guardan en texto plano, igual que en el video, solo para fines de práctica.

## 6. Cambios hechos para igualar los videos

| Archivo | Cambio |
|---|---|
| index, nosotros, galeria, contactos, login | Se agregó **Login** al menú desplegable Servicios (antes solo había Contacto) |
| galeria.html | La tecla Escape ahora usa `.remove()` en lugar de `.hide()` |
| nosotros.html | `header` de ScrollReveal: distancia 600 px → 500 px |
| contactos.html | Formulario dentro de `card` y `card-body`; "Servicios" marcado como activo |
| login.html | Botón `form-control bg-dark text-white`; logo centrado; se quitó el título "Iniciar sesión" |
| pagina.html | Se añadió `main.container` con tres párrafos |
| galeria.html | Se agregó la 8.ª imagen (`galeria/img07.jpg`); antes había 7 |

## 7. Pruebas realizadas

- Las 6 páginas HTML responden con código 200 en `localhost`.
- Sintaxis de `envio.php` y `login.php` sin errores (`php -l`).
- Login correcto (`usuarioxy` / `123456`): redirige a `pagina.html`.
- Login incorrecto: muestra "Usuario incorrecto" y regresa a `login.html`.
- Formulario de contacto: el registro se guardó en la tabla `datos` (la fila de prueba se eliminó después).
- No se probaron visualmente en el navegador FlexSlider ni las animaciones de ScrollReveal.

## 8. Git y GitHub

- Repositorio: https://github.com/DDREMARC/proyecto_01 (rama `main`).
- Commit `10c278e`: "Ajusta el proyecto para igualarlo a los videos de jQuery (partes 1-3)", ya subido con `git push`.
- El repositorio tiene un workflow de GitHub Pages: en Pages solo funciona el HTML estático. El formulario de contacto y el login necesitan PHP y MySQL, que solo corren en XAMPP.
