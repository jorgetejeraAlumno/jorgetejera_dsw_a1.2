<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Result</title>
</head>
<body>
    <div class="resp">
        <h1>Completado</h1>
        <p>Su duda se ha registrado con éxito. Pronto tendrá su respuesta.</p>
        <a href="./index.html"><button>Nueva duda</button></a>
    </div>
    
    <?php
        $correo = $_POST["correo"];
        $modulo= $_POST["modulo"];
        $asunto= $_POST["asunto"];
        $desc= $_POST["desc"];

        $duda ="\"$correo\";\"$modulo\";\"$asunto\";\"$desc\";\n";
        $file = fopen("dudas.csv","a+");
        fwrite($file,$duda);
        fclose($file);
    ?>
</body>
</html>