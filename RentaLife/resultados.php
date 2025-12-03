<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/resultados.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/modal1.css">
</head>
<body>
  <header>
    <div id="logo"><img src="source/logo.png" width="50px"></div>

  <nav id="nav-header">
    <button id="filtro" class="btn" onclick="abrirModal1()"><img src="source/filtro-icon.png" width="25px"></button>
    <!-- Ventana emergente del filtro-->
    <div id="modal1" class="modal">
      <div class="modal-contenido">
        <span class="close" onclick="cerrarModal1()">&times;</span>
        <h2>Filtrar resultados</h2>
        <h3>Tipo de vivienda</h3>
        <div id="tipovivienda">
         <button class="botonesfiltro">Casa</button>
         <button class="botonesfiltro">Departamento</button>
         <button class="botonesfiltro">Cuarto</button>
        </div>

        <br>
        <h3>Precios</h3>
        <div id="precioest">
          <p><b id="precioActual">$1000</b></p>  
        </div>
            
         <div class="slider">
 
            <div class="inputlabel">
                <span>Mínimo</span>
                <input type="number" id="min" value="1000" min="0" max="100000">
            </div>
            <input type="range" id="range" min="0" max="100" value="0">
            <br>
           
            <div class="inputlabel">
                <span>Máximo</span>
                <input type="number" id="max" value="5000" min="0" max="100000">
            </div>
            <br>
 
        </div>
            
        <h3>Servicios/Detalles</h3>
        <div id="Servicios">
          <input type="checkbox"><label for="">Mascotas permitidas</label>
        <br>
        <input type="checkbox"><label for="">Cerca de centros comerciales</label>
        <br>
        <input type="checkbox"><label for="">Garage</label>
        <br>
        <input type="checkbox"><label for="">Transporte cercano</label>
        <br>
        <input type="checkbox"><label for="">Wifi</label>
        <br>
        <input type="checkbox"><label for="">Aire acondicionado</label>
        <br>
        <input type="checkbox"><label for="">Cuarto compartido</label>
        <br>
        <input type="checkbox"><label for="">Luz</label>
        <br>
        <input type="checkbox"><label for="">Agua potable</label>
        <br>
        <input type="checkbox"><label for="">Patio</label>
        <br>
        <input type="checkbox"><label for="">Amueblada</label>

        </div>
        
        <br>
        <div id="aplicarFiltro">
          <button class="btn" id="aplicarfiltro" onclick="aplicarFiltro()"><b>Aplicar filtro</b></button>
        </div>
        
      </div>
      
    </div>
    <div id="otrosbotones">
     <a href="mapa.html"><button id="mapa" class="btn"><img src="source/mapa-icon.png" width="20px"></button></a>
     <a href="login.php"><button class="btn" id="miespacio"><b>Mi espacio</b></button></a>
     <button class="btn" id="registro"><b>Regístrate</b></button>

    </div>
    

  </nav>
</header>
<section id="resultados">
    <h2>Resultados de la búsqueda</h2>
    <div class="cards-container">
        <?php
include "conexion.php";

// Consulta
$sql = "
SELECT p.titulo, p.precio, p.foto, p.id_propiedad, c.nombre_colonia AS colonia, m.nombre_municipio AS municipio
FROM propiedades p
INNER JOIN colonia c ON p.id_colonia = c.id_colonia
INNER JOIN municipio m ON c.id_municipio = m.id_municipio;
";

$resultado = mysqli_query($conexion, $sql);

if(mysqli_num_rows($resultado) > 0){
    while($row = mysqli_fetch_assoc($resultado)){
        echo '
        <a href="infovivienda.php?id=' . $row['id_propiedad'] . '">
            <div class="card">
                <img src="'. $row["foto"] .'">
                <h3>'. $row["titulo"] .'</h3>
                <p>Precio: $'. number_format($row["precio"]) .' MXN/mes</p>
                <p>Ubicación: '. $row["colonia"] .', '. $row["municipio"] .'</p>
            </div>
        </a>
        ';
    }
} else {
    echo "<p>No hay propiedades disponibles.</p>";
}
?>

    </div>

</section>
 <!-- Ver filtro-->
  <script>
function abrirModal1() {
  document.getElementById("modal1").style.display = "block";
  document.getElementById("otrosbotones").classList.add("oculto");
}

function cerrarModal1() {
  document.getElementById("modal1").style.display = "none";
  document.getElementById("otrosbotones").classList.remove("oculto");
}
</script>

<!--Slider -->
<script>
const slider = document.getElementById("range");
const minInput = document.getElementById("min");
const maxInput = document.getElementById("max");
const precioActual = document.getElementById("precioActual");

function actualizarPrecio() {
    const min = parseFloat(minInput.value);
    const max = parseFloat(maxInput.value);

    // Convierte el slider (0-100) en porcentaje
    const porcentaje = slider.value / 100;

    // Calcula el precio proporcional
    const precio = min + (max - min) * porcentaje;

    // Mostrar el precio
    precioActual.textContent = "$" + Math.round(precio);
}

// Cuando mueves el slider
slider.addEventListener("input", actualizarPrecio);

// Si el usuario modifica el mínimo o máximo manualmente
minInput.addEventListener("input", actualizarPrecio);
maxInput.addEventListener("input", actualizarPrecio);

// Inicializa el precio al entrar al modal
actualizarPrecio();
</script>

</body>

</html>