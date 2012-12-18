<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS 
 * @file:      loanobjects_update.php
 * @desc:      
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
include("../lang/dbadmin.php");
include("../lang/prestamo.php");


include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=".urldecode($value)."<br>";

include("../common/header.php");
$encabezado="";
include("../common/institutional_info.php");
?>
		<div class="sectionInfo">
		<div class="language">
					<a href="configure_menu.php?encabezado=s" class="defaultButton">
					<span><strong><?php echo $msgstr["back"] ?></strong></span>
			   	</a>
		</div>
		</div>
			<div class="breadcrumb">
		<h3><?php echo  $msgstr["policy"] ?></h3>
			</div>
			<div class="actions">
			</div>

	      <div class="middle form">
			<div class="formContent"></div>
			
<?php			
			
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/typeofitems.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/typeofitems.tab";
$fp=fopen($archivo,"w");
$ValorCapturado=urldecode($arrHttp["ValorCapturado"]);
fwrite($fp,$ValorCapturado);
fclose($fp);
echo "<h4>".$archivo." <br /><br /><strong>". $msgstr["saved"]." !</strong></h4>";
echo "</div></div>";
include("../common/footer.php");
echo "
</body>
</html>";
?>