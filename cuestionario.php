<!DOCTYPE html>
<html>
<head>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151321328-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-151321328-1');
</script>

    
<link rel="stylesheet" href="styles.css"> 

<script>
MathJax = {
  loader: {load: ['input/asciimath', 'output/chtml']}
}
</script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script type="text/javascript" id="MathJax-script" async
  src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/startup.js">
</script>

<script>
function validateForm() {
  var x = document.forms["cuestionario"]["opcion"].value;
  if (x == "") {
    alert("Por favor selecciona una respuesta");
    return false;
  }
}
</script>
    
</head>    
<body>
<?php

$maximo = 131;

//checa el nivel seleccionado en la portada

if(isset($_GET['nivel'])) {
    
    $elnivel = $_GET['nivel'];    
	
}else{

header('Location: index.php');

}

/*/si no hay nivel registrado regresa al indice

if($elnivel != 4) OR ($elnivel != 8){
	
	header('Location: index.php');
	}
	*/

//Este es el programa principal que presenta las preguntas en problemasverbales.com

//Carga la base de datos
include "database.php";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    

//Determina si hay una pregunta en la url

if(isset($_GET['pregunta'])) {
	$pointer = $_GET['pregunta'];
}else{
	
//si no la hay selecciona una pregunta al azar

if ($elnivel == 4){
	
	$pointer = rand(1,100);
	
}elseif($elnivel == 7){
	
	$pointer = rand(101,131);
	
}


	

/*/Si no la hay selecciona una pregunta al azar de la tabla programa

$random = rand(1,50);

$sql = "SELECT * FROM programa WHERE consecutivo = '$random'";
	
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        
        $pointer = $row["id"];
    }
}     
//Fin del bucle de seleccion de pregunta
*/

}


	
//Carga la pregunta

$sql = "SELECT * FROM preguntas WHERE id = '$pointer'";
	
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        
        
        
        $displayT = $row["texto"];
		$displaymedia = $row["media"];
        $displayP = $row["P"];
        $respuesta_A = $row["A"];
        $respuesta_B = $row["B"];
        $respuesta_C = $row["C"];
		$respuesta_D = $row["D"];
		$respuesta_E = $row["E"];
        $correcta = $row["R"];
		$correcta2 = $row["R2"];
        $displayDiv = $row["tipo"];
		
		
		
    }
}     
//Fin del bucle de seleccion de pregunta


//Si no hay pregunta en la base de datos manda al indice

if($pointer > $maximo){
	header('Location: index.php');
}


echo $pointer;
?>
<div class="flex-container">


<?php

//Determina si hay que presentar blockquote o imagen

if($displaymedia > 0){


echo "<div class=\"foto\">";
echo "<img src=\"https://s3.amazonaws.com/media.problemasverbales.com/".$displaymedia.".png\" height=\"540\" width=\"864\">";
echo "</div>";

}


//despliega la forma


echo "<div class=\"inputGroup\">".$displayP."</div>";    

include "formulario.php";

echo "<input type=\"submit\" name=\"submit\" value=\"Contestar\"  ></form></div>";

?>




</div>
</body>
</html>
