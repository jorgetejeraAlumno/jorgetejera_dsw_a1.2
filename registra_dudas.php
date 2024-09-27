<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Result</title>
</head>
<body>
    
    
    <?php
    $resp1="";
    $resp2="";
    $DAW2=["DSW","DEW","EMR","DPL","DOR"];
    if ($_SERVER["REQUEST_METHOD"]==="POST") 
        {
            $errores = [];
            //Validamos el correo
            if(empty($_POST["correo"])) {
                $errores[] = "Este campo es obligatorio";
            }elseif(!filter_var($_POST["correo"],FILTER_VALIDATE_EMAIL)){
                $errores[] = "Este mail es inválido";
            }
            //Validamos el asunto
            if(empty($_POST["asunto"])) {
                $errores[] = "Este campo es obligatorio";
            }elseif(!is_string($_POST["asunto"]))
            {
                $errores[] = "El valor de este campo debe ser texto";
            }elseif(strlen($_POST["asunto"])>50) {
                $errores[] = "El asunto es de maximo 50 caracteres";
            }
            // Validamos la describcion
            if(empty($_POST["desc"])) {
                $errores[] = "Este campo es obligatorio";
            }elseif(strlen($_POST["desc"])> 300) {
                $errores[] = "Puedes poner como maximo 300 caracteres";
            }
            //Comprobamos si hat errores
            if(empty($errores)){
                $resp1="Completado";
                $resp2="Su duda se ha registrado con exito";
                //Guardamos en variables los campos
                $correo = $_POST["correo"];
                $modulo= $_POST["modulo"];
                $asunto= $_POST["asunto"];
                $desc= $_POST["desc"];
                //Los guardamos en un array
                $duda ="\"$correo\";\"$modulo\";\"$asunto\";\"$desc\"\n";
                //Lo escribimos en el csv
                $file = fopen("dudas.csv","a+");
                fwrite($file,$duda);
                fclose($file);
                echo"<h1>".$resp1."</h1>";
                echo "<p>".$resp2."</p>";
            }else{
                $resp1="Errores:";
                echo $resp1;

                foreach($errores as $error) {
                    echo "<br>".$error."<br>";
                }
            }
        }
    ?>
    <div class="resp">
        <a href="./index.html"><button>Nueva duda</button></a>
    </div>
     
</body>
</html>