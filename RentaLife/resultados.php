<?php
include "conexion.php";

$municipio = $_GET['municipio'] ?? '';
$colonia   = $_GET['colonia'] ?? '';
$min       = $_GET['precio_min'] ?? 0;
$max       = $_GET['precio_max'] ?? 99999999;
$tipo      = $_GET['tipo'] ?? '';
$servicios = $_GET['servicios'] ?? [];  // Array de checkboxes

// Construcción base del SQL
$sql = "
SELECT DISTINCT p.titulo, p.precio, p.foto, p.id_propiedad,
       c.nombre_colonia AS colonia,
       m.nombre_municipio AS municipio
FROM propiedades p
INNER JOIN colonia c ON p.id_colonia = c.id_colonia
INNER JOIN municipio m ON c.id_municipio = m.id_municipio
LEFT JOIN servicios_propiedades sp ON sp.id_propiedad = p.id_propiedad
WHERE 1=1
";

// -------------------------
// FILTROS
// -------------------------

// Municipio
if (!empty($municipio)) {
    $sql .= " AND m.id_municipio = " . intval($municipio);
}

// Colonia
if (!empty($colonia)) {
    $sql .= " AND c.id_colonia = " . intval($colonia);
}

// Precio
$sql .= " AND p.precio BETWEEN $min AND $max ";

// Tipo de vivienda
if (!empty($tipo)) {
    $sql .= " AND p.id_tipo = '" . mysqli_real_escape_string($conexion, $tipo) . "'";
}

// Servicios (múltiples seleccionados)
if (!empty($servicios) && is_array($servicios)) {

    // Convertir cada servicio a int
    $servicios = array_map('intval', $servicios);

    // Crear lista "1, 5, 7"
    $listaServicios = implode(",", $servicios);

    // Solo propiedades que tengan TODOS los servicios marcados
    $sql .= "
        AND p.id_propiedad IN (
            SELECT sp2.id_propiedad
            FROM servicios_propiedades sp2
            WHERE sp2.id_servicio IN ($listaServicios)
            GROUP BY sp2.id_propiedad
            HAVING COUNT(DISTINCT sp2.id_servicio) = " . count($servicios) . "
        )
    ";
}

$sql .= " ORDER BY p.fecha_publicacion DESC;";

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
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

    <!-- FORMULARIO DEL MODAL -->
    <form action="resultados.php" method="GET">

      <h3>Tipo de vivienda</h3>
      <div id="tipovivienda">
        <label><input type="radio" name="tipo" value="Casa"> Casa</label>
        <label><input type="radio" name="tipo" value="Departamento"> Departamento</label>
        <label><input type="radio" name="tipo" value="Cuarto"> Cuarto</label>
      </div>

      <br>

      <h3>Precios</h3>
      <div id="precioest"> <p><b id="precioActual">$1000</b></p> </div>
      <div class="slider">

        <div class="inputlabel" id="slidermodal">
          <span>Mínimo</span>
                <input type="number" id="min" name="precio_min" value="1000">
        </div>

         <input type="range" id="range" min="0" max="100" value="2000">

        <div class="inputlabel" id="slidermodal">
          <span>Máximo</span>
          <input type="number" id="max" name="precio_max" value="5000">
        </div>
      </div>

      <br>

      <h3>Servicios</h3>
      <div id="Servicios">

        <label><input type="checkbox" name="servicios[]" value="1"> Mascotas permitidas</label><br>
        <label><input type="checkbox" name="servicios[]" value="2"> Centros comerciales</label><br>
        <label><input type="checkbox" name="servicios[]" value="3"> Garage</label><br>
        <label><input type="checkbox" name="servicios[]" value="4"> Transporte cercano</label><br>
        <label><input type="checkbox" name="servicios[]" value="5"> Wifi</label><br>
        <label><input type="checkbox" name="servicios[]" value="6"> Aire acondicionado</label><br>
        <label><input type="checkbox" name="servicios[]" value="7"> Cuarto compartido</label><br>
        <label><input type="checkbox" name="servicios[]" value="8"> Luz</label><br>
        <label><input type="checkbox" name="servicios[]" value="9"> Agua potable</label><br>
        <label><input type="checkbox" name="servicios[]" value="10"> Patio</label><br>
        <label><input type="checkbox" name="servicios[]" value="11"> Amueblada</label>

      </div>

      <br>

      <div id="aplicarFiltro">
        <button type="submit" class="btn" id="registro"><b>Aplicar filtro</b></button>
      </div>

    </form>
  </div>
</div>
    
    </div>
    <div id="otrosbotones">
    <a href="index.php"><button class="btn" id="mapa"><img src="source/home-icon.png" width="25px" alt=""></button></a>
     <a href="mapa.php"><button id="mapa" class="btn"><img src="source/mapa-icon.png" width="20px"></button></a>
     <a href="login.php"><button class="btn" id="miespacio"><b>Mi espacio</b></button></a>
     <a href="registro.php"><button class="btn" id="registro"><b>Regístrate</b></button></a>

    </div>
    

  </nav>
</header>
<section id="resultados">
    <h2>Resultados de la búsqueda</h2>
    <div class="cards-container">

<?php
include "conexion.php";


$municipio = $_GET['municipio'] ?? '';
$colonia = $_GET['colonia'] ?? '';
$precio_min = $_GET['precio_min'] ?? '';
$precio_max = $_GET['precio_max'] ?? '';


$where = [];

if (!empty($municipio)) {
    $where[] = "m.id_municipio = '$municipio'";
}
if (!empty($colonia)) {
    $where[] = "c.id_colonia = '$colonia'";
}
if (!empty($precio_min)) {
    $where[] = "p.precio >= '$precio_min'";
}
if (!empty($precio_max)) {
    $where[] = "p.precio <= '$precio_max'";
}

$where_sql = "";
if (!empty($where)) {
    $where_sql = "WHERE " . implode(" AND ", $where);
}

$sql = "
SELECT DISTINCT p.id_propiedad, p.titulo, p.precio, p.foto,
       c.nombre_colonia AS colonia, m.nombre_municipio AS municipio
FROM propiedades p
INNER JOIN colonia c ON p.id_colonia = c.id_colonia
INNER JOIN municipio m ON c.id_municipio = m.id_municipio
$where_sql
ORDER BY p.fecha_publicacion DESC
LIMIT 200;
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
<script src="slider-precio.js"></script>
<script>

    initSlider("range", "min", "max", "precioActual");
</script>

</body>

</html>