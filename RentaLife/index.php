<?php
include("consultas_select.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal | Rentalife</title>
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/login.css">

    
</head>

<body>
<header>
  <div id="logo"><img src="source/logo.png" alt="" width="50px"></div>
  
  <nav id="nav-header">
    <button class="btn" id="miespacio"><b>Mi espacio</b></button>
    <button class="btn" id="registro"><b>Regístrate</b></button>
  </nav>
</header>

<div class="principal">
    <img src="source/FondoIndex.jpg" alt="Departamento" class="imgfondo">
    <div id="busqueda">
        <h1>Encuentra tu renta ideal</h1>

        <form action="resultados.php" method="GET">

        <div class="grupo-input">
        <div class="input-inline">
            <label><b>Ubicación</b></label>

            <select name="municipio" class="select-large">
                <option value="">Selecciona un municipio</option>
                <?php while($m = $municipios->fetch_assoc()) { ?>
                    <option value="<?= $m['id_municipio'] ?>">
                        <?= $m['nombre_municipio'] ?>
                    </option>
                <?php } ?>
            </select>

            <select name="colonia" class="select-large">
                <option value="">Selecciona una colonia</option>
                <?php while($c = $colonias->fetch_assoc()) { ?>
                    <option value="<?= $c['id_colonia'] ?>">
                        <?= $c['nombre_colonia'] ?>
                    </option>
                <?php } ?>
            </select>

            <button class="boton-ubicacion"><b>Cerca de mí</b></button>
        </div>
        </div>

        <div class="grupo-input">
        <label>Tu ingreso mensual:</label> 
        <div id="precioest">
            <p><b id="precioActual">$1000</b></p>  
        </div>

        <div id="sliderindex" class="slider" >
            <div class="inputlabel">
                <span>Mínimo</span>
                <input type="number" id="min" name="precio_min" value="1000">
            </div>

            <input type="range" id="range" min="0" max="100" value="2000">

            <div class="inputlabel">
                <span>Máximo</span>
                <input type="number" id="max" name="precio_max" value="5000">
            </div>
        </div>

        <div>
        <p id="avisoSlider">(Desliza o escribe para ajustar)</p>
         </div>

       <div id="btnbusqueda">
        <button type="submit" class="btn"><b>Buscar</b></button>
      </div>
        </form>
   </div>
</div>
<!--Slider -->
<script src="slider-precio.js"></script>
<script>

    initSlider("range", "min", "max", "precioActual");
</script>
<script>
if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("service-worker.js")
    .then(() => console.log("Service Worker registrado"))
    .catch(err => console.log("Error al registrar Service Worker:", err));
}
</script>
</body>

</html>