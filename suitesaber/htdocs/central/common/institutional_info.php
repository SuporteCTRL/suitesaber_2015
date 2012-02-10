<!--Editado em 27/04/2011
Linha: 7
 -->

<div class="heading">
	<div class="institutionalInfo">
		<img title="<?php  echo $institution_name ?>" alt="<?php  echo $institution_name ?>" src=..<?php echo $logo ?> width="<?php echo $sizelogo  ?>" />
	</div>
	<div class="userInfo">
		<span><?php echo $_SESSION["nombre"]?></span>,
	<?php echo $_SESSION["profile"]?> |
<?php
if (isset($_SESSION["newindow"]) or isset($arrHttp["newindow"])){
	echo "<a href='javascript:top.location.href=\"../dataentry/logout.php\";top.close()' xclass=\"button_logout\"><span><img alt=\"$msgstr[logout]\" src=\"../css/$theme/images/logout.png\"></span></a>";}else{	echo "<a href=\"../dataentry/logout.php\" xclass=\"button_logout\"><span><img alt=\"$msgstr[logout]\" src=\"../css/$theme/images/logout.png\"></span></a>";}
?>
	</div>
</div>