<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
</head>
<body>
    <h1>FUNCIONA</h1>
    <?php
        $correo = $_POST["correo"];
        $modulo= $_POST["modulo"];
        $asunto= $_POST["asunto"];
        $desc= $_POST["desc"]."\n";

        $duda ="\"$correo\";\"$modulo\";\"$asunto\";\"$desc\"";
        $file = fopen("dudas.csv","a+");
        fwrite($file,$duda);
        fclose($file);
    ?>
</body>
</html>