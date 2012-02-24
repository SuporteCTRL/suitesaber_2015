<?php
session_start();
include("../common/get_post.php");
include("../config.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");

?>
<html>
<head>
	<title>User statment</title>
	<meta http-equiv="Expires" content="-1" />
	<meta http-equiv="pragma" content="no-cache" />
	<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<meta http-equiv="Content-Language" content="pt-br" />
	<meta name="robots" content="all" />
	<meta http-equiv="keywords" content="" />
	<meta http-equiv="description" content="" />
	<link rel="stylesheet" rev="stylesheet" href="../css/stylesmysiste.css" type="text/css" media="screen"/>
 	<style>
 		BODY, INPUT, SELECT, TEXTAREA,td, th {
			font-family:  Arial, Verdana, Helvetica;
			font-size: 11px;
			color: #000;
		}

 	</style>
    <script src=../dataentry/js/lr_trim.js></script>
    <script>top.resizeTo(900,600);</script>
    <script>
function AnularReserva(Mfn){
	document.anular.Mfn.value=Mfn
	document.anular.submit()
}
function Renovar() {
	document.renovar.action="renovar_ex.php"
	marca="N"
	switch (np){     // n�mero de pr�stamos del usuario
		case 1:
			if (document.ecta.chkPr.checked){
				document.renovar.searchExpr.value=document.ecta.chkPr.id
				atraso=document.ecta.chkPr.value
				politica=document.ecta.politica.value
				marca="S"
			}
			break
		default:
			for (i=0;i<document.ecta.chkPr.length;i++){
				if (document.ecta.chkPr[i].checked){
					marca="S"
					document.renovar.searchExpr.value=document.ecta.chkPr[i].id
					atraso=document.ecta.chkPr[i].value
					politica=document.ecta.politica[i].value
					break
				}
			}
	}
	fecha_d="<?php echo date("Ymd")?>"
	if (marca=="S"){
		p=politica.split('|')
		if (p[6]==0){     // the object does not accept renovations
			alert("<?php echo $msgstr["noitrenew"] ?>")
			return
		}
		if (atraso!=0){
			if (p[13]!="Y"){
				alert("<?php echo $msgstr["loanoverdued"]?>")
				return
			}
		}
		if (Trim(p[15])!=""){
			if (fecha_d>p[15]){
				alert("<?php echo $msgstr["limituserdate"]?>"+": "+p[15])
				return
			}
		}
		if (Trim(p[16])!=""){
			if (fecha_d>p[16]){
				alert("<?php echo $msgstr["limitobjectdate"]?>"+": "+p[16])
				return
			}
		}
		if (nMultas!=0){
			alert("<?php echo $msgstr["norenew"]?>")
			return
		}
		document.renovar.submit()
	}else{
		alert("<?php echo $msgstr["markloan"]?>")
	}
}
</script>

</head>
<body>
<br>
<table width=100%>
<td>
<h4>Estado de cuenta</h4><p>
<form name=ecta>
<?php

include("leer_pft.php");

// se lee la configuraci�n local
include("calendario_read.php");
include("locales_read.php");
// SE LEE LA RUTINA PARA CALCULAR EL L�MITE DE LA SUSPENSION
include("fecha_de_devolucion.php");
// se leen las politicas de pr�stamo
include("loanobjects_read.php");
// se lee la configuraci�n de la base de datos de usuarios
include("borrowers_configure_read.php");

include("ec_include.php");
echo $ec_output;



//OJO ESTO SE LO QUIT� PARA QUE NO MUESTRE EL LINK DE LAS RESERVAS
//if (count($prestamos)>0) echo  "<strong><a href=javascript:Renovar()>".$msgstr["renew"]."</a></strong><p>";

//SE LEEN LAS RESERVAS PENDIENTES
//include("opac_reservas.php");
//echo $reserva_output;




?>
</form>
<form name=renovar action=renovar_ex.php method=post>
<input type=hidden name=searchExpr>
<input type=hidden name=usuario value=<?php echo $arrHttp["usuario"]?>>
<input type=hidden name=vienede value=ecta_web>
</form>
<form name=anular method=post action=reservar_anular.php>
<input type=hidden name=Mfn>
<input type=hidden name=usuario value=<?php echo $arrHttp["usuario"]?>>
<input type=hidden name=vienede value=ecta_web>
</form>

</table>

</body>
</html>
<?php
if (isset($arrHttp["error"])){
	echo "<script>alert(\"".$arrHttp["error"]."\")</script>";
}
?>