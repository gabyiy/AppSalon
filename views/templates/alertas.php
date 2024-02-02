<?php 
//cu foreach asta acesam doar alertele care au ca si key error
//acestea fiind definite in models Usuario cu keyu de error
foreach($alertas as $key=>$mensajes):
foreach($mensajes as $mensaje):
?>

<div class="alertas <?php echo $key; ?>">
  <?php echo $mensaje; ?>  
</div>

<?php
endforeach;
endforeach;
?>