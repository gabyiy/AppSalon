<h1 class="nombre-pagina">Nuesvos Servicio</h1>
<p class="descripcion-pagina">Administracion de Servicios</p>

<!-- <?php include_once __DIR__ . "/../templates/barra.php"?> -->
<?php include_once __DIR__ . "/../templates/alertas.php" ?>


<form action="/servicios/crear" method="POST" class="formulario">


<?php include_once __DIR__ . "/formulario.php"; ?>

<input type="submit" class="boton" value="Crear servico">

</form>