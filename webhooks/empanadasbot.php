<?php
//esto incluye la librería
include_once "../somosioticos/somosioticos_dialogflow.php";
//credenciales('empanadasbot','123456789');
debug();

// me conecto a db
$mysqli = mysqli_connect("localhost", "admin_empabot", "123456789", "admin_empabot");

if (!$mysqli) {
	echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
	die();
}

//demora
$demora_x_empanada = 0.5;

if (intent_recibido("imagen")) {

 	$url = obtener_imagen();

	agrega_imagen($url);
	enviar_texto("Imagen recibida, estará publicada en https://empanadasbot.ml/imagenes.php");

}

if (intent_recibido("imagen2")) {

	if(origen()=="FACEBOOK" || origen()== "TELEGRAM"){
		$imagenes[0] = "https://www.interpatagonia.com/recetas/empanadas_merluza/empanadas-merluza.jpg";
		$imagenes[1] = "http://d26lpennugtm8s.cloudfront.net/stores/480/355/products/empanadas1-e16b9748eacff4993015119479206259-640-0.jpg";
		$imagenes[2] = "http://www.recetasjudias.com/wp-content/uploads/2017/06/Burekas-Empanadas-de-Berenjenas-y-Queso.jpg";

		enviar_imagenes( $imagenes, origen() );
	}
}

//si el intent recibido es consultar_precio...
if (intent_recibido("consultar_precio")) {
  $p_arabes = consulta_precio('arabes');
  $p_choclo = consulta_precio('choclo');
  $p_carne = consulta_precio('carne');
  enviar_texto("Las de carne cuestan $p_carne las arabes cuestan $p_arabes y las de choclo cuestan $p_choclo");
}

//si el intent recibido es tomar orden...
if (intent_recibido("tomar_orden")){
  $cantidad1 = obtener_variables()['cantidad1'];
  $sabor1 = obtener_variables()['sabor1'];
	$disponibilidad1 = 0;
	$precio1 = 0;
	$subtotal1 = 0;
	if ($cantidad1 > 0){
		$precio1 = consulta_precio($sabor1);
		$disponibilidad1 = consulta_stock($sabor1);
		$subtotal1 = $cantidad1 * $precio1;
		if($cantidad1 > $disponibilidad1){
			enviar_texto("$disponibiliad1 Lo siento, no tenemos suficientes  empanadas $sabor1 en este momento, si deseas reformular el pedido simplemente di 'quiero ordenar' la cantidad que actualmente nos quedan es de ".$disponibilidad1." unidades");
			return;
		}
	}

  $cantidad2 = obtener_variables()['cantidad2'];
  $sabor2 = obtener_variables()['sabor2'];
	$disponibilidad2 = 0;
	$precio2 = 0;
	$subtotal2 = 0;
	if ($cantidad2 > 0){
		$precio2 = consulta_precio($sabor2);
		$disponibilidad2 = consulta_stock($sabor2);
		$subtotal2 = $cantidad2 * $precio2;
		if($cantidad2 > $disponibilidad2){
			enviar_texto("Lo siento, no tenemos suficientes  empanadas $sabor2 en este momento, si deseas reformular el pedido simplemente di 'quiero ordenar' la cantidad que actualmente nos quedan es de $disponibilidad2 unidades");
			return;
		}
	}


  $cantidad3 = obtener_variables()['cantidad3'];
  $sabor3 = obtener_variables()['sabor3'];
	$disponibilidad3 = 0;
	$precio3 = 0;
	$subtotal3 = 0;
	if ($cantidad3 > 0){
		$precio3 = consulta_precio($sabor3);
		$disponibilidad3 = consulta_stock($sabor3);
		$subtotal3 = $cantidad3 * $precio3;
		if($cantidad3 > $disponibilidad3){
			enviar_texto("Lo siento, no tenemos suficientes  empanadas $sabor3 en este momento, si deseas reformular el pedido simplemente di 'quiero ordenar' la cantidad que actualmente nos quedan es de $disponibilidad3 unidades");
			return;
		}
	}

	$total = $subtotal1 + $subtotal2 + $subtotal3;
  enviar_texto("Usted encargó: $cantidad1 $sabor1, $cantidad2 $sabor2, $cantidad3 $sabor3  y el total es de $ $total por favor dígame si desea confirmar este pedido");

}

//si se confirma la orden
if (intent_recibido("orden_confirmada")) {
  $nombre = obtener_variables()['nombre'];
	$domicilio = obtener_variables()['domicilio'];
	$telefono = obtener_variables()['telefono'];

	$sabor1 = obtener_variables()['sabor1'];
	$cantidad1 = obtener_variables()['cantidad1'];
	$subtotal1 = 0;
	if ($cantidad1>0){
		$subtotal1 = $cantidad1 * consulta_precio($sabor1);
		descuenta_stock($cantidad1,$sabor1);
	}

	$sabor2 = obtener_variables()['sabor2'];
	$cantidad2 = obtener_variables()['cantidad2'];
	$subtotal2 = 0;
	if ($cantidad2>0){
		$subtotal2 = $cantidad2 * consulta_precio($sabor2);
		descuenta_stock($cantidad2,$sabor2);
	}

	$sabor3 = obtener_variables()['sabor3'];
	$cantidad3 = obtener_variables()['cantidad3'];
	$subtotal3 = 0;
	if ($cantidad3>0){
		$subtotal3 = $cantidad3 * consulta_precio($sabor3);
		descuenta_stock($cantidad3,$sabor3);
	}

	//enviamos mail,
	$total = $subtotal1 + $subtotal2 + $subtotal3;
	$mensaje = "Nueva orden para $nombre enviar: \n\n\n $sabor1 $cantidad1 \n\n $sabor2 $cantidad2 \n\n $sabor3 $cantidad3 \n\n enviar a: $domicilio \n\n Total a cobrar: $total" ;
	mail('somosioticos@gmail.com', 'Nueva Orden desde Empabot!', $mensaje);

	$cantidad_total = $cantidad1 + $cantidad2 + $cantidad3;
	$demora = $demora_x_empanada * $cantidad_total;
  enviar_texto("Listo! su orden está en camino, llegará a destino en aproximadamente $demora minutos. Gracias!");
}

//***************************
//**** FUNCIONES ************
//***************************

function consulta_stock($sabor){
  global $mysqli;
  $resultado = $mysqli->query("SELECT $sabor FROM `stock` WHERE 1");
  $stock = mysqli_fetch_assoc($resultado);
  $cantidad = $stock[$sabor];
  return $cantidad;
}

function consulta_precio($sabor){
  global $mysqli;
  $resultado = $mysqli->query("SELECT $sabor FROM `precios` WHERE 1");
  $precios = mysqli_fetch_assoc($resultado);
  $precio = $precios[$sabor];
  return $precio;
}

function descuenta_stock($cantidad,$sabor){
	  global $mysqli;
		$mysqli->query("UPDATE `stock`  SET $sabor = $sabor - $cantidad ");
}

function agrega_stock($cantidad,$sabor){
	  global $mysqli;
		$mysqli->query("UPDATE `stock`  SET $sabor = $sabor + $cantidad ");
}

function agrega_imagen($url){
	  global $mysqli;
		$mysqli->query("INSERT INTO `imagenes` (`url`) VALUES ('$url')");
}



 ?>
