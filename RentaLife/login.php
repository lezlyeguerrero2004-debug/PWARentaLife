<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = mysqli_real_escape_string($conexion, $_POST["usuario"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);


    $password_sha256 = hash('sha256', $password);

    $sql = "SELECT * FROM usuarios 
            WHERE (email='$usuario') 
            AND password='$password_sha256'
            LIMIT 1";

    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {

        $row = mysqli_fetch_assoc($resultado);

        $_SESSION["id_usuario"] = $row["id_usuario"];
        $_SESSION["nombre"] = $row["nombre"];
        $_SESSION["email"] = $row["email"];
         $_SESSION["descripcion"] = $row["descripcion"];
        $_SESSION["foto"] = $row["foto_perfil"];

        header("Location: perfil.php");
        exit();

    } else {
        echo "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Rentalife</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/resultados.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<header>
  <div id="logo"><img src="source/logo.png" alt="" width="50px"></div>
  
  <nav id="nav-header">
    <a href="resultados.php"><button class="btn" id="mapa"><img src="source/home-icon.png" width="25px" alt=""></button></a>
   <a href="registro.php"><button class="btn" id="registro"><b>Regístrate</b></button></a> 
  </nav>
</header>


<body>

    <div class="login-container">

        <div class="login-box" id="registro-box">
            <h2>Inicio de sesión</h2>
            <form action="login.php" method="POST">

                <input type="text" name="usuario" placeholder="Correo" class="input">
                <input type="password" name="password" placeholder="Contraseña" class="input">

                 <div class="registro-texto">
                    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
                 </div>

                    <button type="submit" class="btn" id="registro"><b>Iniciar sesión</b></button>
           </form>
       </div>
    </div>
</body>
</html>