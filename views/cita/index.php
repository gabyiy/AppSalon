<h1 class="nombre-pagina">Crear cita</h1>
    <p class="descripcion-pagina">Elige tu servicios y coloca tus datos</p>

   <?php include_once __DIR__ . "/../templates/barra.php" ?>
        
    <div id="app">
        <nav class="tabs">
            <!-- creem propriu nostru atribut html data-paso ,pe care o sa il facem functional cu javascript
            in caz ca o sa apasam butonu asta o sa ne arate formularul paso 2 date time etc -->
            <button type="button"  data-paso="1">Servicios</button>
            <button type="button" data-paso="2">Informacion cita</button>
            <button type="button" data-paso="3">Resumen</button>


        </nav>
        <div id="paso-1" class="seccion">
        <h2 >Servicios</h2>
        <p class="text-center">Elije tu servicios a contiunacion</p>
        <div class="listado-servicios" id="servicios"></div>
        </div>
        <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>
        <!-- nu are method nici action pentru ca o salvam toate datele intrun obiect de javascript -->
        <form  class="formulario" >
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" value="<?php echo $nombre ?>" placeholder="Introduce tu nombre" disabled>
    </div>
    <div class="campo" >
        <label for="fecha">Fecha</label>
        <!-- cu min setam ca userul nu poate sa aleaga o data mai mica de 14 a 2 si sa inceapa din ziua 
    urmatoare cu strtotime -->
        <input type="date" id="fecha" min="<?php echo date('Y-m-d' ,strtotime('+1 day')); ?>">
        
    </div>
    <div class="campo">
                <label for="hora">Hora</label>
                <input
                    id="hora"
                    type="time"
                />
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
</div>
<div id="paso-3" class="seccion contenido-resumen">
<h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea corecta</p>

</div>
<div class="paginacion">
    <!-- cu laqua facem o sageata la stanga si cu raquo o sageata la dreapta -->
    <button id="anterior" class="boton">&laquo; anterior</button>
    <button id="siguente" class="boton"> Siguente &raquo;</button>
</div>
    </div>

    <!-- iar aici ce facem este practic sa adaugam variabla $script astfel putem sa utilizam js in pagina asta -->
<?php 
$script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js'></script>
<script src='build/js/app.js'></script>";
?>