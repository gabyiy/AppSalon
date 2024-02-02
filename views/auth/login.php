<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesiion con tus datos</p>
<?php include_once __DIR__ ."../../templates/alertas.php"; ?>

<!-- cu action selectionam ruta care vremo sa o accesam din login rooter  -->
<form class="formulario" action="/" method="POST">
<div class="campo">
    <label for="email"> Email   </label>
    <!-- punem name ca sa poate fi cititi cu post si id  sa fie relationat cu labelu-->
        <input type="email" id="email" name="email" placeholder="Tu Email" value="<?php echo s($auth->email) ?>">
</div>
<div class="campo">
    <label for="password">  Password  </label>

        <input type="paasword" name="password" id="password" placeholder="Tu Password">
</div>
<input type="submit"  class="boton" value="Iniciar sesiom">
</form>


<div class="acciones">
    <a href="/crear-cuenta">No tienes una cuenta ? Crea una</a>
    <a href="/olvide">Olvidaste tu  contrasena?</a>
</div>