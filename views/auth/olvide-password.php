<h1 class="nombre-pagina">Olvide password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu correo a continuacion</p>

<?php include_once __DIR__ ."../../templates/alertas.php"; ?>

<form  class="formulario" action="/olvide" method="POST" >
  <div class="campo">
<label for="email">Email</label>
<input type="email" id="email" name="email" placeholder="Introduce tu e-mail">
</div> 
<input type="submit" class="boton" value="Enviar instruciones">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia sesion</a>
    <a href="/crear-cuenta"> Aun no tienes una cuenta? Crea una</a>
</div>