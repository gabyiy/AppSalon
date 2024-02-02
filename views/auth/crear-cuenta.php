<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguente formulario para crear una cuenta</p>


<?php 
//asa includem alertele unde utilizam un for each pentru a ne arata alertele
include_once __DIR__ ."../../templates/alertas.php";
?>
<form class="formulario" action="/crear-cuenta" method="POST">

<div class="campo">
    <label for="nombre">Nombre</label>
    <!-- folosim value pentru a accesa valoare care deja o avem salvata in $usuario din functia crear din logincontroler 
    care face practic un auto fill in caz ca avem date introduse
-->
    <input type="text" id="nombre" name="nombre" placeholder="Introduce su nombre" value="<?php echo s($usuario->nombre);?>">
</div>

<div class="campo">
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" placeholder="Introduce su apellido" value="<?php echo s($usuario->apellido); ?>" >
</div>


<div class="campo">
    <label for="telefono">Telefono</label>
    <input type="tel" id="telefono" name="telefono" placeholder="Introduce su telefono" value="<?php echo s($usuario->telefono); ?>">
</div>
<div class="campo">
    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" placeholder="Introduce su e-mail" value="<?php echo s($usuario->email); ?>">
</div>
<div class="campo">

<label for="password">Password</label>
<input type="password" id="password" name="password" placeholder="Introduce su password" >
</div>

<input type="submit" class="boton" value="Crear cuenta">
</form>
<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesion</a>
    <a href="/olvide">Olvidaste tu  contrasena?</a>
</div>