<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["name"];
    $correo = $_POST["email"];
    $telefono = $_POST["telephone"];
    $mensaje = $_POST["message"];
    
    // Validamos que los campos no estén vacíos
    if(empty($nombre) || empty($correo) || empty($telefono) || empty($mensaje)) {
        // echo '
        // <h3>Por favor, complete todos los campos</>
        // <br>
        // <button onclick="history.back()">Volver atrás</button>
        // ';
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100vh;">
        
            <div style="padding: 1rem; margin: 1rem" id="container" class="container_msn">
                <h1 style="font-size: 1rem; letter-spacing: 0.2rem; margin-bottom: 2rem;" class=".message">Por favor, complete todos los campos</h1>
                <button id="form_button" onclick="history.back()">comprobar</button>
            </div>
            
        </body>
        </html>';
        exit();        
    }

	// Validar que el campo de nombre solo contenga letras y espacios
    if(!preg_match("/^[a-zA-Z ]*$/", $nombre)) {
        echo '
        <h3>El campo de nombre solo debe contener letras y espacios.</>
        <br>
        <button onclick="history.back()">Volver atrás</button>
        ';
        exit();
    } 

    // Validamos que el correo tenga un formato válido
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '
        <h3>Por favor, ingrese un correo electrónico válido.</>
        <br>
        <button onclick="history.back()">Volver atrás</button>
        ';
        exit();
    }

    // Validar que el campo de teléfono solo contenga números
    if(!preg_match("/^[0-9]*$/", $telefono)) {
        echo '
        <h3>El campo de teléfono solo debe contener números.</>
        <br>
        <button onclick="history.back()">Volver atrás</button>
        ';        
        exit();
    }

	// Validar que el campo de mensaje solo contenga letras y espacios
    if(!preg_match("/^[a-zA-Z0-9_\-\.\s@]+$/", $mensaje)) {
        echo '
        <h3>El campo de mensaje solo debe contener letras, números, espacios, y caracteres especiales propios de un email.</>
        <br>
        <button onclick="history.back()">Volver atrás</button>
        ';
        exit();
    }     
        
    // Sanitizamos los datos antes de almacenarlos en el archivo de texto
    $nombre = htmlspecialchars($nombre);
    $correo = htmlspecialchars($correo);
    $telefono = htmlspecialchars($telefono);
    $mensaje = htmlspecialchars($mensaje);
    
    // Almacenamos los datos en el archivo de texto
    $archivo = fopen("contactos.txt", "a") or die("No se pudo abrir el archivo.");
    $texto = "Nombre: $nombre\nCorreo: $correo\nTeléfono: $telefono\nMensaje: $mensaje\n\n";
    fwrite($archivo, $texto);
    fclose($archivo);
    
    // Redirigimos al index y enviamos una confirmación de que se almacenó la información
    header("Location: index.html?success=true");
    exit();
}
?>
