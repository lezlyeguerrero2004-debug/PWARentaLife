<?php
session_start();
include("conexion.php");
include("consultas_select.php");

// Verificar si el usuario está logeado
if (!isset($_SESSION['id_usuario'])) {
    echo "Debes iniciar sesión para publicar una vivienda.";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

// 1. Recibir datos del formulario
$titulo      = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$precio      = $_POST['precio'];
$direccion   = $_POST['direccion'];

$id_municipio = $_POST['municipio'];
$id_colonia   = $_POST['colonia'];
$id_tipo      = $_POST['tipopropiedad'];

// 2. Manejo de la imagen subida
    if(isset($_FILES['fotopropiedad']) && $_FILES['fotopropiedad']['error'] === 0){

        $foto_nombre = $_FILES['fotopropiedad']['name'];
        $foto_temp   = $_FILES['fotopropiedad']['tmp_name'];

        $carpeta = "fotos_viviendas/";
        if(!is_dir($carpeta)){
            mkdir($carpeta, 0777, true);
        }

        $foto_destino = $carpeta . uniqid() . "_" . $foto_nombre;
        move_uploaded_file($foto_temp, $foto_destino);
 } else {
        echo "Error al subir la foto";
        exit();
    }


// 3. Insertar en base de datos
$sql = "INSERT INTO propiedades 
        (id_usuario, id_tipo, id_colonia, titulo, descripcion, precio, direccion, foto)
        VALUES 
        ('$id_usuario', '$id_tipo', '$id_colonia', '$titulo', '$descripcion', '$precio', '$direccion', '$foto_destino')";


if ($conexion->query($sql)) {
    echo "Propiedad publicada correctamente";
} else {
    echo "Error: " . $conexion->error;
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar vivienda | Rentalife</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<header>
    <div id="logo">
        <img src="source/logo.png" width="50px">
    </div>

    <nav id="nav-header">
         <a href="logout.php">
             <button class="btn" id="miespacio"><b>Cerrar sesión</b></button>
         </a>
         <a href="perfil.php">
                <button class="btn" id="registro"><b>Mi espacio</b></button>
         </a>
</nav>
</header>
<body>
    <section class="login-container">
    <section class="login-box" id="contenedor-pub">
        <h2>Publicar vivienda</h2>
            <form action="publicar.php" method="POST" enctype="multipart/form-data">
                <input type="text" placeholder="Título" name="titulo" class="select-large" id="titulo">
                 <label for="descripcion"><b><p>Descripción detallada:</p></b></label>
                <textarea name="descripcion" id="descripcion" rows="7" cols="46"></textarea>
                <input type="number" name="precio" id="precio" placeholder="Precio mensual" class="select-large">
                <br>
                <select name="tipopropiedad" required class="select-large">
                    <option value="">Selecciona el tipo de propiedad</option>
                     <?php while($t = $tipos->fetch_assoc()) { ?>
                     <option value="<?= $t['id_tipo'] ?>">
                      <?= $t['nombre_tipo'] ?>
                     </option>
                     <?php } ?>
                </select>
                <br>
                <select name="municipio" required class="select-large">
                    <option value="">Selecciona un municipio</option>
                    <?php while($m = $municipios->fetch_assoc()) { ?>
                  <option value="<?= $m['id_municipio'] ?>">
                   <?= $m['nombre_municipio'] ?>
                    </option>
                    <?php } ?>
                </select>
                <select name="colonia" required class="select-large">
                 <option value="">Selecciona una colonia</option>
                 <?php while($c = $colonias->fetch_assoc()) { ?>
                    <option value="<?= $c['id_colonia'] ?>">
                     <?= $c['nombre_colonia'] ?>
                    </option>
                 <?php } ?>
                </select>
                <input type="text" placeholder="Dirección / Calle / Num" class="select-large" name="direccion" id="direccion">
                <label><b><p>Sube una foto</p></b></label>
                <p><input type="file" name="fotopropiedad" accept="image/*" required id="subirfoto"></p>

                <button type="submit" class="btn" id="registro"><b>Publicar</b></button>

            </form>

    </section>
    </section>
</body>
</html>