<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      configure_menu.php
 * @desc:      Configuration menu
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
$lang=$_SESSION["lang"];
include("../config.php");
include("../common/get_post.php");
include("../lang/admin.php");
include("../lang/prestamo.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
$encabezado="";
echo "<body>\n";
$encabezado="&encabezado=s";
include("../common/institutional_info.php");
echo "<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".
		$msgstr["configure"]."
	</div>
	<div class=\"actions\">\n";

		echo "<a href=\"../common/inicio.php?reinicio=s&modulo=loan\" class=\"defaultButton backButton\">

			<span><strong>". $msgstr["back"]."</strong></span>
		</a>
	</div>
	<div class=\"spacer\">&#160;</div>
</div>";
?>

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


	<style>
	#draggable { width: 60px; height: 60px; padding: 0.5em; }
	</style>
	<script>
	$(function() {
		$( ".menuButton" ).draggable();
	});
	</script>

<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/configure_menu.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])) echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/configure_menu.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; Script: configure_menu.php" ?></font>
	</div>
	
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php echo $msgstr["policy"]?></a></li>
				<li><a href="#tabs-2"><?php echo $msgstr["outputs"]?></a></li>
			</ul>	
	
	<div id="tabs-1">
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent toolSection ">
			<div class="sectionIcon">
				&#160;
			</div>
			<div class="sectionTitle">

			</div>
			<div class="sectionButtons">
				<a href="databases.php"  class="menuButton tooltip databaseButton">

					<span><?php echo $msgstr["sourcedb"]?></span>
				</a>
				<a href="borrowers_configure.php" class="menuButton tooltip importButton">

					<span><?php echo $msgstr["bconf"]?></span>
				</a>
				<a href="typeofusers.php" class="menuButton tooltip userButton">

					<span><?php echo $msgstr["typeofusers"]?></span>
				</a>
                      <a href="typeofitems.php" class="menuButton tooltip importButton">

					<span><?php echo $msgstr["typeofitems"]?></span>
				</a>
                      <a href="loanobjects.php" class="menuButton tooltip newButton">

					<span><?php echo $msgstr["objectpolicy"]?></span>
				</a>

				<a href="locales.php" class="menuButton tooltip importButton">

					<span><?php echo $msgstr["local"]?></span>
				</a>

				<a href="calendario.php" class="menuButton tooltip importButton">

					<span><?php echo $msgstr["calendar"]?></span>
				</a>

                <a href="../reservas/inicio.php" class="menuButton tooltip importButton">

					<span><?php echo $msgstr["reserves_conf"]?></span>
				</a>

			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
</div>

<!-- SEGUNDO ACORDEON -->

<div id="tabs-2"> 
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent toolSection">
			<div class="sectionTitle">
			</div>
			<div class="sectionButtons">
				<a href="../circulation/receipts.php?base=trans&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton tooltip reportButton">

					<span><?php echo $msgstr["receipts"]?></span>
				</a>
				<a href="../dbadmin/pft.php?base=trans&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton tooltip reportButton">

					<span><?php echo $msgstr["reports_trans"]?></span>
				</a>
				<a href="../dbadmin/pft.php?base=suspml&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton tooltip reportButton">

					<span><?php echo $msgstr["reports_suspml"]?></span>
				</a>
				<a href="../dbadmin/pft.php?base=users&encabezado=s&retorno=../circulation/configure_menu.php" class="menuButton tooltip reportButton">

					<span><?php echo $msgstr["reports_borrowers"]?></span>
				</a>


			</div>
			<div class="spacer">&#160;</div>
		</div>

			<div class="spacer">&#160;</div>
		<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
</div>

<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
</form>
</div>
</div>
</div>
<?php include("../common/footer.php");?>

</body>
</html>
