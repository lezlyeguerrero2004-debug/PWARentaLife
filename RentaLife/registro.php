<?php
include ("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recibir datos
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $whatsapp = $_POST['whatsapp'];
    $descripcion = $_POST['descripcion'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    // Validación de contraseñas
    if($pass1 !== $pass2){
        echo "Las contraseñas no coinciden";
        exit();
    }

    $pass_sha256 = hash("sha256", $pass1);

    // Guardar foto
    if(isset($_FILES['fotousuario']) && $_FILES['fotousuario']['error'] === 0){

        $foto_nombre = $_FILES['fotousuario']['name'];
        $foto_temp   = $_FILES['fotousuario']['tmp_name'];

        $carpeta = "fotos_usuarios/";
        if(!is_dir($carpeta)){
            mkdir($carpeta, 0777, true);
        }

        $foto_destino = $carpeta . uniqid() . "_" . $foto_nombre;
        move_uploaded_file($foto_temp, $foto_destino);

    } else {
        echo "Error al subir la foto";
        exit();
    }

    $sql = "INSERT INTO usuarios (nombre, email, password, whatsapp, foto_perfil, descripcion)
            VALUES ('$nombre', '$correo', '$pass_sha256', '$whatsapp', '$foto_destino', '$descripcion')";

    if(mysqli_query($conexion, $sql)){
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta | Rentalife</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/resultados.css">
    <link rel="stylesheet" href="css/login.css">
    
</head>
 <header>
    <div id="logo"><img src="source/logo.png" width="50px"></div>

  <nav id="nav-header">
    <a href="resultados.php"><button class="btn" id="mapa"><img src="source/home-icon.png" width="25px" alt=""></button></a>

  </nav>
</header>
    
<body>

    <div class="login-container" id="registro-box">

        <div class="login-box">
            <h2>Registro</h2>
            <form action="registro.php" method="POST" enctype="multipart/form-data">

              <div class="registrobox">
               <input type="email" name="correo" placeholder="Ingresa un correo electrónico" class="input" required>
                <input type="text" name="nombre" placeholder="Ingresa tu nombre" class="input" required>
                <input type="text" name="whatsapp" placeholder="Ingresa tu número de whatsapp" class="input" required>

               <label for="descripcion"><p>Descripción:</p></label>
                <textarea name="descripcion" id="descripcion" rows="7" cols="46" placeholder="Escribe sobre ti..."></textarea>

                <input type="password" name="password1" placeholder="Crea una contraseña" class="input" required>
                <input type="password" name="password2" placeholder="Confirma tu contraseña" class="input" required>
              </div>

              <div class="registrobox">
               <label><p>Sube una foto</p></label>
                <p><input type="file" name="fotousuario" accept="image/*" required id="subirfoto"></p>
              </div>
             <button type="submit" class="btn" id="registro"><b>Crear cuenta</b></button>
          </form>
       </div>
    </div>
</body>
</html>
