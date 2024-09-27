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
    <?php
    $resp1="";
    $resp2="";
    $daw2=array("DSW","DEW","EMR","DPL","DOR");
    if ($_SERVER["REQUEST_METHOD"]==="POST") 
        {
            $errores = [];
            //Validamos el correo
            if(empty($_POST["correo"])) {
                $errores[] = "El correo es obligatorio";
            }elseif(!filter_var($_POST["correo"],FILTER_VALIDATE_EMAIL)){
                $errores[] = "Este mail es inválido";
            }
            //Validamos el asunto
            if(empty($_POST["asunto"])) {
                $errores[] = "El asunto es obligatorio";
            }elseif(is_numeric($_POST["asunto"]))
            {
                $errores[] = "El valor de este campo debe ser texto";
            }elseif(strlen($_POST["asunto"])>50) {
                $errores[] = "El asunto es de maximo 50 caracteres. Usted ha puesto: ".strlen($_POST["asunto"]);
            }
            // Validamos la describcion
            if(empty($_POST["desc"])) {
                $errores[] = "La descripcion es obligatorio";
            }elseif(strlen($_POST["desc"])> 300) {
                $errores[] = "El maximo de caracteres de la descripcion es de 300. Usted ha puesto: ".strlen($_POST["desc"]);
            }

            //Comprobamos que el asunto pertenece al array DAW2
            if(!in_array($_POST["modulo"], $daw2)) {
                $errores[] = "La duda debe ser sobre una asignatura de segundo. ".$_POST["modulo"]." es de primero";
            }
            //Comprobamos si hay errores
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
                $resp1="<h2>"."Errores:"."</h2>";
                echo $resp1;
                foreach($errores as $error) {
                    echo"<br>".$error."<br>";
                }
                
            }
        }
    ?>
    
        <a href="./index.html"><button>Nueva duda</button></a>
    </div>
     
</body>
</html>