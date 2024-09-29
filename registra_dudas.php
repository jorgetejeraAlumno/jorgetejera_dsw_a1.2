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
    $errores=[];
        function validar_correo(){
            global $errores;
        if(empty($_POST["correo"])) {
            
            array_push($errores,"El correo es obligatorio");
        }elseif(!filter_var($_POST["correo"],FILTER_VALIDATE_EMAIL)){
            array_push($errores,"Este mail es inválido");
        }
    }
    function validar_asunto(){
        global $errores;
        if(empty($_POST["asunto"])) {
            array_push($errores,"El asunto es obligatorio");
        }elseif(is_numeric($_POST["asunto"]))
        {
            array_push($errores,"El valor de este campo debe ser texto");
        }elseif(strlen($_POST["asunto"])>50) {
            array_push($errores,"El asunto es de maximo 50 caracteres. Usted ha puesto: ".strlen($_POST["asunto"]));
        }
    }
    function validar_desc(){
        global $errores;
        if(empty($_POST["desc"])) {
            array_push($errores,"La descripcion es obligatorio");
        }elseif(strlen($_POST["desc"])> 300) {
            array_push($errores,"El maximo de caracteres de la descripcion es de 300. Usted ha puesto: ".strlen($_POST["desc"]));
        }
    }
    function validar_modulo(){
        global $errores;
        $daw2=array("DSW","DEW","EMR","DPL","DOR");
        if(!in_array($_POST["modulo"], $daw2)) {
            array_push($errores,"La duda debe ser sobre una asignatura de segundo. ".$_POST["modulo"]." es de primero");
        }
    }
    function comprobar_tema(){
        // $temas=array($_POST["linux"],$_POST["windows"],$_POST["php"],$_POST["html"],$_POST["calificaciones"],
        $_POST["notas"],$_POST["examenes"],$_POST["otros"],);

        for($x = 0; $x <= count($temas);$x++){
            if(is_null($temas[$x])){
                unset($temas[$x]);
            }
        }
        $temas = array_values($temas);
        return $temas;
    }

    function validar_tema($temas){
        global $errores;
        if(count($temas)< 0 and count($errores)> 3){
            array_push($errores,"El numero de temas elegido no es correcto. Debe elegir entre 1 y 3");
        }

            
    }

    if ($_SERVER["REQUEST_METHOD"]==="POST") 
        {
            global $errores;
            validar_correo();
            validar_asunto();
            validar_modulo();
            validar_desc();
            comprobar_tema();
            validar_tema(comprobar_tema());
            //Comprobamos si hay errores
            if(empty($errores)){

                //Guardamos en variables los campos
                $correo = $_POST["correo"];
                $modulo= $_POST["modulo"];
                $asunto= $_POST["asunto"];
                $desc= $_POST["desc"];
                $temas=comprobar_tema();

                //Los guardamos en un array
                $duda ="\"$correo\";\"$modulo\";\"$asunto\";\"$desc\;";

                for($x=0; $x <= count($temas);$x++){
                    $duda.=$temas[$x].";";
                }

                $duda.="\n";

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