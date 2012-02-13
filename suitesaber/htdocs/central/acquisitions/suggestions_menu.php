<?php include("sendto.php")?>

<?php



if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>
		<a id=botoes_top href=suggestions_new.php?base=suggestions&cipar=suggestions.par&Opcion=crear&ventana=S&encabezado=s&retorno=<?php echo urlencode("../acquisitions/suggestions.php")?>><strong>
			<?php echo $msgstr["new"]?></strong></a> 
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
		<a id=botoes_top href=suggestions_status.php?base=suggestions&sort=TI><strong>
			<?php echo $msgstr["approve"]." / ". $msgstr["reject"]?></strong></a> 
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
		<a id=botoes_top href=bidding.php?base=suggestions&sort=DA><strong>
			<?php echo $msgstr["bidding"]?></strong></a> 
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
		<a id=botoes_top href=decision.php?base=suggestions&sort=DA><strong>
			<?php echo $msgstr["decision"]?></strong></a> 
<?php }?>

		<a id=botoes_top href="../common/inicio.php?reinicio=s&modulo=acquisitions"><strong>
				<img width="24px" src="../css/saber/images/home.png" alt="Início" title="Início" ></strong></a> &nbsp; &nbsp; 
	