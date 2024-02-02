<h1 class="nombre-pagina">Recuperar pagina</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>
<?php  include_once __DIR__  ."../../templates/alertas.php"
?>

<?php 

if($error){
  return ;
}
?>
<!-- aici nu folosim nici o ruta pentru ca vrem sa ramana pe aceasi pagina post de la form -->
<form  class="formulario" method="POST" >
  <div class="campo">
<label for="password">Email</label>
<input type="password" id="password" name="password" placeholder="Introduce nueva password">
</div> 
<input type="submit" class="boton" value="Guardar nueva password">
</form>
<div class="acciones">

    <a href="/">Ya tienes una cuenta? Inicia sesion</a>
    <a href="/crear-cuenta"> Aun no tienes una cuenta? Crea una</a>
</div>
