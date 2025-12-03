<?php
session_start();
include("conexion.php");

// Si no ha iniciado sesión → lo mandamos a login
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// ID del usuario logueado
$id = $_SESSION["id_usuario"];

// Consulta para obtener los datos del usuario
$sql = "SELECT * FROM usuarios WHERE id_usuario = $id LIMIT 1";
$resultado = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($resultado);

// Si por alguna razón no existe
if (!$usuario) {
    echo "Error: no se pudo cargar la información del usuario.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/resultados.css">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/infovivienda.css">
</head>

<header>
    <div id="logo">
        <img src="source/logo.png" width="50px">
    </div>

    <nav id="nav-header">
        <a href="logout.php">
            <button class="btn" id="miespacio"><b>Cerrar sesión</b></button>
        </a>
    </nav>
</header>

<body>

<section class="info-vivienda" id="cardusuario">

    <!-- PANEL IZQUIERDO: DATOS DEL USUARIO -->
    <div class="info" id="usuario">

        <h2>Usuario</h2>

        <nav class="infoprop" id="infoperfil">

            <!-- FOTO DE PERFIL -->
             <img id="fotoperfil" 
                src="<?php echo $usuario['foto_perfil'] ? $usuario['foto_perfil'] : 'source/fotoperfil.png'; ?>" 
                alt="Foto de perfil">
            <!-- NOMBRE -->
            <h3 id="nombre"><?php echo $usuario["nombre"]; ?></h3>
        </nav>

        <!-- DESCRIPCIÓN DEL USUARIO -->
        <nav id="descripcion">
            <p>
                <?php 
                echo $usuario["descripcion"] 
                    ? $usuario["descripcion"] 
                    : "Este usuario aún no ha agregado una descripción.";
                ?>
            </p>
        </nav>

    </div>

    <!-- PANEL DERECHO: PUBLICACIONES DEL USUARIO -->
    <section class="publicaciones">

        <?php
        // Consultar las viviendas publicadas por este usuario
        $sqlV = "SELECT * FROM propiedades WHERE id_usuario = $id";
        $vResult = mysqli_query($conexion, $sqlV);
        $total = mysqli_num_rows($vResult);
        ?>

        <h2 class="titulo-publi">
            Has publicado <?php echo $total; ?> vivienda<?php echo ($total != 1 ? 's' : ''); ?>
        </h2>

        <div class="viviendas-grid">

            <?php while ($v = mysqli_fetch_assoc($vResult)) { ?>

                <div class="card-vivienda">
                    <img src="<?php echo $v['foto']; ?>" class="img-vivienda">
                    <p class="nombre-vivienda"><?php echo $v["titulo"]; ?></p>
                    <p class="precio">$<?php echo number_format($v["precio"]); ?> / mes</p>
                </div>

            <?php } ?>

        </div>

        <hr>

        <nav id="botonpublicar">
            <a href="publicar.php">
                <button class="btn" id="registro"><b>Publicar nuevo</b></button>
            </a>
        </nav>

    </section>

</section>

</body>
</html>