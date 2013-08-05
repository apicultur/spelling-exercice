<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <title>PHP ejemplo para APIS de APIcultur. Ejercicios de ortografía H</title>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
	<style type="text/css">
	  body {
		font-family: Coda, Georgia, "Times New Roman",
			  Times, serif }
	  h1 {
	  color: purple;
		font-family: Coda Helvetica, Geneva, Arial,
			  SunSans-Regular, sans-serif }
	.NEGATIVA {
		color:red }	
	.POSITIVA {
		color:green }	
	.NEUTRA {
		color:grey }
	.PROCESABLE {
		color:purple }	
  </style>
  
	<script type="text/javascript">
	function corregir(cuestion,solucion,isOkey){
		
		element = document.getElementById(cuestion);
		element.innerHTML = solucion;  
		if (isOkey){
			element.setAttribute("class","POSITIVA");
		} else {
			element.setAttribute("class","NEGATIVA");
		}
		
	}
	
	</script>
	
  </head>
  <body>
    <div>
	  
      <h1>Ejercicios de ortografía H</h1>

      <p>Contesta a las siguientes preguntas con H o nada según corresponda pulsando sobre la letra que creas correcta</p>
	  
	  <p>Si la respuesta es correcta, aparecerá en verde. Si es incorrecta, aparecerá en rojo corregido.</p>
	
	  <p></p>

<?php
	 
		//recogemos los parámetros
	if (isset($_REQUEST['dificultad'])){
		$dificultad = $_REQUEST['dificultad'];
	} else {
		$dificultad = 0;
	}
	if (isset($_REQUEST['nivel'])){
		$nivel= $_REQUEST['nivel'];
	} else {
		$nivel = 0;
	}
	
	$numPreguntas = 10;
	
	
	if ($dificultad>0 && $nivel>0){
	
		$preguntas = obtenerPreguntas($numPreguntas,$dificultad,$nivel);
	
		if (isset($preguntas)){
			$i=1;
			foreach ($preguntas as $cuestion){  
		
				echo "<p>";
		
				$pregunta = $cuestion->{'pregunta'};
				$correcta = $cuestion->{'correcta'};
				$respuestas = $cuestion->{'respuestas'};
			
				echo "<div class='pregunta' id='pregunta".$i."'>".$i."." .$pregunta."</div>";
				
				foreach ($respuestas as $respuesta){  
				
					if ($respuesta==$correcta){
						echo"<input type='button' value='".$respuesta."' onclick='corregir(\"pregunta".$i."\",\"".str_replace("_",$correcta,$pregunta)."\",true)' />";
					} else {
						echo"<input type='button' value='".$respuesta."' onclick='corregir(\"pregunta".$i."\",\"".str_replace("_",$correcta,$pregunta)."\",false)' />";
					}
				
				}
				
				$i++;
				
				echo "</p>";
			
			}
			?><div class="volver"><a href="ejercicio_ortografia.php">Volver</a></div><?
		}
	} else {
	 
?>


	<p>
      <form action="ejercicio_ortografia_h.php" method="POST" name="theform">
		Tengo un nivel de español: <input type="text" name="nivel" />
		<h6>1: nivel bajo; 2: nivel medio; 3: nivel alto; 4: soy nativo</h6><br/>
		Quiero palabras de una dificultad: <input type="text" name="dificultad" />
		<h6>1: Fáciles; 2: Intermedias; 3: Difíciles; 4: Muy difíciles</h6><br/>
		
		<input type="submit" value="¡Dame ejercicios!" />
	  </form>
	</p>
	
	<div>


<?php
 }
 ?>

</div>
  </body>
</html>
	
<?php   
   /**
   * Obtiene a través de la api GET un número de preguntas de la dificultad y nivel solicitados por parámetro
   *
   * @returns un objeto JSON con un array de preguntas que indica por cada uno de ellos: la pregunta ("pregunta"), la respuesta correcta ("correcta") y las posibles respuestas  ("respuestas[]")
   */
   
 function obtenerPreguntas($numPreguntas,$dificultad,$nivel) {
	#API Key de nuestra aplicación en APICultur. Para más informacion:	http://www.apicultur.com/instrucciones/
			
	#$access_key = "PON_TU_ACCESS_KEY_AQUI";		
	
	$url="http://store.apicultur.com/api/ejercicioortografiah/1.0.0/".$numPreguntas."/".$dificultad."/".$nivel;		
		
  
    
	#Iniciamos curl
	$ch = curl_init();

	#Pasamos nuestro API Key y señalamos que lo que nos van a devolver es JSON
	curl_setopt($ch,CURLOPT_HTTPHEADER,array( 'Accept: application/json', 'Authorization: Bearer ' . $access_key ));

	#Pasamos la url de la api 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
	#Introducimos en una variable el valor que nos devuelve la api
	$respuesta = curl_exec($ch);
		
	$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	#Cerrar el recurso cURL y liberar recursos
	curl_close($ch);	
    
	#Comprobamos el código devuelto por la API para ver que todo ha salido correctamente y en caso positivo devolvemos ok
	switch ($http_status) {
    case '200':
		$obj = json_decode($respuesta);
	  break;
    default:
	  echo "<br/>error al obtener las preguntas.";
	  echo "<br/>Error:" .$http_status ;
      break;
	}
	
	return $obj;
}
	
	

	
		
	
		
	
?>