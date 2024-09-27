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
    function validar_correo(){
        if(empty($_POST["correo"])) {
            return "El correo es obligatorio";
        }elseif(!filter_var($_POST["correo"],FILTER_VALIDATE_EMAIL)){
            return  "Este mail es inválido";
        }else{
            return null;
        }
    }
    function validar_asunto(){
        if(empty($_POST["asunto"])) {
           return  "El asunto es obligatorio";
        }elseif(is_numeric($_POST["asunto"]))
        {
            return "El valor de este campo debe ser texto";
        }elseif(strlen($_POST["asunto"])>50) {
            return "El asunto es de maximo 50 caracteres. Usted ha puesto: ".strlen($_POST["asunto"]);
        }else{
            return null;
        }
    }
    function validar_desc(){
        if(empty($_POST["desc"])) {
           return "La descripcion es obligatorio";
        }elseif(strlen($_POST["desc"])> 300) {
            return "El maximo de caracteres de la descripcion es de 300. Usted ha puesto: ".strlen($_POST["desc"]);
        }else{
            return null;
        }
    }
    function validar_modulo(){
        $daw2=array("DSW","DEW","EMR","DPL","DOR");
        if(!in_array($_POST["modulo"], $daw2)) {
            return "La duda debe ser sobre una asignatura de segundo. ".$_POST["modulo"]." es de primero";
        }else{
            return null;
        }
    }

    if ($_SERVER["REQUEST_METHOD"]==="POST") 
        {
            //$errores = [];
            //añadimos al array errores los errores si los hay
           if((validar_correo()==null and validar_asunto() and validar_desc() and validar_modulo()))
            {
                $errores=[];
            }else{
                $errores = [];
                array_push(($errores),validar_correo(),validar_asunto(),validar_desc(),validar_modulo());
            }
            
            //Comprobamos si hay errores
            if(empty($errores)){

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
                echo"<h1>"."Completado"."</h1>";
                echo "<p>"."Su duda se ha registrado con exito"."</p>";
            }else{
                echo"<h1>"."Proceso no completado"."</h1>";
                echo"<h2>"."Listado de errores: "."</h2>";
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