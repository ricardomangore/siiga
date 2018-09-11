<?php
	include("conexion.php");
	$temporalId=$_GET["temp"];
	$Folio=$_GET["id"];
	$Serie=$_GET["ss"];
	$Movimiento=$_GET["id2"];
	$Familia=$_GET["id3"];
	echo "Temporal: ".$temporalId."<br>Folio: ".$Folio."<br>Serie: ".$Serie."<br> Movimiento: ".$Movimiento."<br>Familia: ".$Familia;
	$query="DELETE FROM Disponibles WHERE Serie='$Serie'";
	if(mysql_query($query)){
		$query2="DELETE FROM LineaTemporalOpc1 WHERE LineaTemporalId='$temporalId'";
		if(mysql_query($query2)){
			header("Location: ../../AddEquipo2.php?id1=$Folio&id2=$Movimiento&id3=$Familia");
		}
	}
?>