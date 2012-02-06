<?php

if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_LOAN"])){
?>
		<a id=botoes_top href="prestar.php?encabezado=s<?php echo $link_u?>" ><strong>
			<?php echo $msgstr["loan"]?></strong></a> 
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RENEW"])){
?>
		<a id=botoes_top href="renovar.php?encabezado=s<?php echo $link_u?>" ><strong>
			<?php echo $msgstr["renew"]?></strong></a> 
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RESERVE"])){
?>
		<a id=botoes_top href="reservar.php?encabezado=s<?php echo $link_u?>" ><strong>
			<?php echo $msgstr["reserve"]?></strong></a> 
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_RETURN"])){
?>
		<a id=botoes_top href="devolver.php?encabezado=s"><strong>
			<?php echo $msgstr["return"]?></strong></a> 
<?php }
if (isset($_SESSION["permiso"]["CIRC_CIRCALL"]) or isset($_SESSION["permiso"]["CIRC_SUSPEND"])){
?>
		<a id=botoes_top href="sanctions.php?encabezado=s"><strong>
			<?php echo $msgstr["suspend"]."/".$msgstr["fine"]?></strong></a> 
<?php }?>
		<a id=botoes_top href="estado_de_cuenta.php?encabezado=s<?php echo $link_u?>"><strong>
			<?php echo $msgstr["statment"]?></strong></a> 

		<!-- <a href="situacion_de_un_objeto.php?encabezado=s<?php echo $link_u?>"><strong>
			<?php echo $msgstr["ecobj"]?></strong></a> | -->

		<a id=botoes_top href="../common/inicio.php?reinicio=s&modulo=loan"><strong>
			<img width="24px" src="../css/saber/images/home.png" alt="Início" title="Início" ></strong></a> &nbsp; &nbsp; &nbsp;

