<?php
include("conexion.php");

if(!isset($_GET["id"])){
    die("No se recibió la vivienda.");
}

$id = intval($_GET["id"]);

$sql = "
SELECT 
    p.*, 
    c.nombre_colonia AS colonia,
    m.nombre_municipio AS municipio,
    u.nombre AS propietario,
    u.foto_perfil,
    u.whatsapp,
    s.nombre_servicio
FROM propiedades p
INNER JOIN colonia c ON p.id_colonia = c.id_colonia
INNER JOIN municipio m ON c.id_municipio = m.id_municipio
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
LEFT JOIN servicios_propiedades sp ON p.id_propiedad = sp.id_propiedad
LEFT JOIN servicios s ON sp.id_servicio = s.id_servicio

WHERE p.id_propiedad = $id
";  

$resultado = mysqli_query($conexion, $sql);
$prop = mysqli_fetch_assoc($resultado);

if(!$prop){
    die("Vivienda no encontrada.");
}

$servicios = [];

while($fila = mysqli_fetch_assoc($resultado)){
    $prop = $fila; 

    if ($fila['nombre_servicio']) {
        $servicios[] = $fila['nombre_servicio'];
    }
}

$telefono = $prop["whatsapp"];
$telefono_limpio = preg_replace('/[^0-9]/', '', $telefono); 

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viviendas encontradas | Rentalife</title>
    <link rel="stylesheet" href="css/infovivienda.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/resultados.css">
    <link rel="stylesheet" href="css/modal1.css">
</head>

 <header>
    <div id="logo"><img src="source/logo.png" width="50px"></div>

  <nav id="nav-header">
    <a href="resultados.php"><button class="btn" id="mapa"><img src="source/home-icon.png" width="25px" alt=""></button></a>
    <a href="login.php"><button class="btn" id="miespacio"><b>Mi espacio</b></button></a>
    <button class="btn" id="registro"><b>Regístrate</b></button>
  </nav>
</header>

<body>

    <section class="info-vivienda" id="info1">
        <div class="info">
         <img id="fotovivienda" src="<?php echo $prop['foto']; ?>">
            <div id="botonfoto">
                <button class="btnfoto"><img src="source/flechai-icon.png" width="20px" alt=""></button>
                <button class="btnfoto"><img src="source/flechad-icon.png" width="20px" alt=""></button>
            </div>
            

            <div id="servicios">
                <h2>Servicios</h2>
                      <ul>
                    <?php foreach($servicios as $servicio): ?>
                          <li> <p><?php echo $servicio; ?></p></li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>

        <div class="info" id="card">
                <h2><?php echo $prop['titulo']; ?></h2>
                <h2>$<?php echo number_format($prop['precio']); ?> MX/mes</h2>
                <p><?php echo $prop['descripcion']; ?></p>
                
        </div>
    </section>
<hr>
    <section class="info-vivienda">
            <div id="imapa">
                <h2>Ubicación</h2>
                <p><?php echo $prop['direccion']. " ,".$prop['colonia'] . ", " . $prop['municipio']; ?></p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1897.285084360164!2d-92.95211845874968!3d17.998724018358498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85edd793a0c86a85%3A0x8a626cc922f19101!2sZONA%20TABASCO%202000!5e0!3m2!1ses!2smx!4v1763582448924!5m2!1ses!2smx"style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="info">
                <h2>Propietario</h2>
                <nav class="infoprop">
                    <img id="fotoperfil" src="<?php echo $prop['foto_perfil']; ?>" alt="">
                    <h3><?php echo $prop['propietario']; ?></h3>
                </nav>

                 <h2>Contacto</h2>
                <nav class="infocontacto">
                    <img id="logowhats"  src="source/iconwhatsapp.png" alt="">
                        <a href="https://wa.me/<?php echo $telefono_limpio; ?>" target="_blank">
                         <span>Contactar por Whatsapp</span>
                      </a>
                </nav>

            </div>

    </section>

    


</body>
</html>