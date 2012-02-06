	<script>
	$(function() {
		$( "#tabs" ).tabs().find( ".ui-tabs-nav" ).sortable({ axis: "x" });
	});
	</script>
		<style type="text/css">
			/*demo page css*/
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
		</style>

<?php

	include("../config.php");


$_SESSION["MODULO"]="acquisitions";
global $arrHttp,$msgstr,$db_path,$valortag,$lista_bases;
	include ("../lang/acquisitions.php");
?>


		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $msgstr["suggestions"]?></a></li>
				<li><a href="#tabs-2"><?php echo $msgstr["purchase"]?></a></li>
				<li><a href="#tabs-3"><?php echo $msgstr["basedatos"]?></a></li>
				<li><a href="#tabs-4"><?php echo $msgstr["admin"]?></a></li>
			</ul>

<div id="tabs-1">

			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent loanSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">

					</div>
					<div class="sectionButtons">
						<a href="../acquisitions/overview.php?encabezado=s" class="menuButton tooltip  multiLine resumeButton">

							<span><?php echo $msgstr["overview"]?></span>
						</a>
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_NEWSUGGESTIONS"])){
?>
						<a href="../acquisitions/suggestions_new.php?encabezado=s&base=suggestions&cipar=suggestions.par" class="menuButton tooltip  multiLine newButton">

							<span><?php echo $msgstr["newsugges"]?></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_APPROVREJECT"])){
?>
						<a href="../acquisitions/suggestions_status.php?base=suggestions&cipar=suggestions.par&sort=TI&encabezado=s" class="menuButton tooltip  multiLine checkButton">

							<span><?php echo $msgstr["approve"]."/".$msgstr["reject"]?></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_BIDDING"])){
?>
						<a href="../acquisitions/bidding.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="menuButton tooltip  multiLine biddingButton">

							<span><?php echo $msgstr["bidding"]?></span>
						</a>
<?php }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_DECISION"])){
?>
						<a href="../acquisitions/decision.php?base=suggestions&sort=DA&encabezado=s&menu=s" class="menuButton tooltip  multiLine decisionButton">

							<span><?php echo $msgstr["decision"]?></span>
						</a>
<?php }?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
			
</div><div id="tabs-2">
			
			
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent orderSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">

					</div>
					<div class="sectionButtons">
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_CREATEORDER"])){
?>
						<a href="../acquisitions/order_new_menu.php?base=suggestions&sort=PV&encabezado=s" class="menuButton tooltip  multiLine newButton">

							<span><?php echo $msgstr["createorder"]?></span>
						</a>

						<a href="../acquisitions/order.php?base=suggestions&sort=PV&encabezado=s" class="menuButton tooltip  multiLine requisitionButton">

							<span><?php echo $msgstr["generateorder"]?></span>
						</a>
<?php }?>
						<a href="../acquisitions/pending_order.php?base=purchaseorder&sort=PV&encabezado=s" class="menuButton tooltip  multiLine pendingButton">

							<span><?php echo $msgstr["pendingorder"]?></span>
						</a>
<?php if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RECEIVING"])){
?>
						<a href="../acquisitions/receive_order.php?encabezado=s" class="menuButton tooltip  multiLine receivingButton">

							<span><?php echo $msgstr["receiving"]?></span>
						</a>
<?php }?>
					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
			
			</div><div id="tabs-3">
<?php
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_ACQDATABASES"])){
?>
			<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent dbSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">

					</div>
					<div class="sectionButtons">
						<a href="../dataentry/browse.php?base=suggestions&modulo=acquisitions" class="menuButton tooltip  multiLine suggestButton">

							<span><?php echo $msgstr["suggestions"]?></span>
						</a>
						<a href="../dataentry/browse.php?base=providers&modulo=acquisitions" class="menuButton tooltip  multiLine userButton">

							<span><?php echo $msgstr["providers"]?></span>
						</a>
						<a href="../dataentry/browse.php?base=purchaseorder&modulo=acquisitions" class="menuButton tooltip  multiLine requisitionButton">

							<span><?php echo $msgstr["purchase"]?></span>
						</a>
						<a href="../dataentry/browse.php?base=copies&modulo=acquisitions" class="menuButton tooltip  multiLine copiesdbButton">

							<span><?php echo $msgstr["copies"]?></span>
						</a>

					</div>
					<div class="spacer">&#160;</div>
				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
			
			</div><div id="tabs-4">
<?php  }
if (isset($_SESSION["permiso"]["ACQ_ACQALL"]) or isset($_SESSION["permiso"]["ACQ_RESETCN"])){
?>
            <div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
				<div class="boxTop">
					<div class="btLeft">&#160;</div>
					<div class="btRight">&#160;</div>
				</div>
				<div class="boxContent toolSection">
					<div class="sectionIcon">
						&#160;
					</div>
					<div class="sectionTitle">
					</div>

					<div class="sectionButtons">
						<a href="../acquisitions/resetautoinc.php?base=suggestions" class="menuButton tooltip  multiLine resetButton">

							<span><?php echo $msgstr["resetctl"]. " (".$msgstr["suggestions"].")"?></span>
						</a>
					</div>
					<div class="spacer">&#160;</div>

				</div>
				<div class="boxBottom">
					<div class="bbLeft">&#160;</div>
					<div class="bbRight">&#160;</div>
				</div>
			</div>
<?php }?>
</div>
